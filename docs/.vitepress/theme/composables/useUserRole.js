import { computed, ref } from "vue";
import { inBrowser, useData } from "vitepress";
import Cookies from "js-cookie";
import CryptoJS from "crypto-js";
import {
	ROLES,
	hasRoleAccess,
	isAdminRole,
	normalizeRole,
	resolveRolesFromGroupCode,
} from "../../roles.js";

const PREVIEW_STORAGE_KEY = "amec_docs_preview_role";

// Shared reactive singleton state across all theme components
const isInitialized = ref(false);
const isLoading = ref(true);
const empNo = ref("");
const empName = ref("");
const groupCode = ref("");
const actualRoles = ref(["GUEST"]);
const previewRole = ref("");
const isAuthenticated = ref(false);

/**
 * Safely read a record from `@amec/webasset`'s IndexedDB ("userAuth")
 * without ever creating or upgrading the database if it does not exist yet.
 */
function readGroupFromIndexedDB(indexedDBID) {
	return new Promise((resolve) => {
		if (!inBrowser || typeof indexedDB === "undefined") {
			resolve(null);
			return;
		}

		try {
			const request = indexedDB.open("userAuth");

			request.onupgradeneeded = (event) => {
				if (event.oldVersion === 0) {
					event.target.transaction?.abort();
				}
			};

			request.onerror = () => resolve(null);

			request.onsuccess = (event) => {
				const db = event.target.result;
				try {
					if (!db.objectStoreNames.contains("group")) {
						db.close();
						resolve(null);
						return;
					}
					const tx = db.transaction("group", "readonly");
					const store = tx.objectStore("group");
					const getReq = store.get(indexedDBID);

					getReq.onsuccess = () => {
						db.close();
						resolve(getReq.result || null);
					};
					getReq.onerror = () => {
						db.close();
						resolve(null);
					};
				} catch {
					db.close();
					resolve(null);
				}
			};
		} catch {
			resolve(null);
		}
	});
}

/**
 * Fallback to `@amec/webasset`'s directlogin API when the login cookie exists
 * but IndexedDB hasn't been cached yet on this browser.
 */
async function fetchGroupFromDirectLogin(empno, appid, appApi) {
	if (!appApi || !empno || !appid) return null;
	try {
		const md5Hash = CryptoJS.MD5(empno).toString().toUpperCase();
		const body = new URLSearchParams({
			username: md5Hash,
			appid: String(appid),
		});
		const res = await fetch(`${appApi}/auth/directlogin/`, {
			method: "POST",
			credentials: "include",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
			},
			body,
		});
		if (!res.ok) return null;
		return await res.json();
	} catch {
		return null;
	}
}

function resetToGuest() {
	empNo.value = "";
	empName.value = "";
	groupCode.value = "";
	actualRoles.value = ["GUEST"];
	isAuthenticated.value = false;
	previewRole.value = "";
	if (inBrowser) {
		sessionStorage.removeItem(PREVIEW_STORAGE_KEY);
	}
}

async function detectUserRole(authConfig = {}) {
	if (!inBrowser) return;

	const appName = authConfig.appName || "procurement";
	const appApi = authConfig.appApi || "";

	isLoading.value = true;
	try {
		const cookie = Cookies.get(appName);
		if (!cookie) {
			resetToGuest();
			return;
		}

		const decrypted = CryptoJS.AES.decrypt(cookie, appName).toString(
			CryptoJS.enc.Utf8,
		);
		if (!decrypted || !decrypted.includes("-")) {
			resetToGuest();
			return;
		}

		const [appid, emp] = decrypted.split("-");
		empNo.value = emp || "";

		// 1. Try IndexedDB cache written by @amec/webasset
		let code = "";
		const cachedGroup = await readGroupFromIndexedDB(decrypted);
		if (cachedGroup?.data?.GROUP_CODE) {
			code = cachedGroup.data.GROUP_CODE;
		}

		// 2. Fallback to AMEC directlogin API if cookie is present but IndexedDB is empty
		if (!code && appApi && emp && appid) {
			const apiRes = await fetchGroupFromDirectLogin(emp, appid, appApi);
			if (apiRes?.appgroup?.GROUP_CODE) {
				code = apiRes.appgroup.GROUP_CODE;
			}
			if (apiRes?.appuser?.SNAME) {
				empName.value = apiRes.appuser.SNAME;
			}
		}

		if (!code) {
			resetToGuest();
			return;
		}

		groupCode.value = code;
		actualRoles.value = resolveRolesFromGroupCode(code);
		isAuthenticated.value = true;

		// Restore preview role ONLY for authenticated Admin users
		if (isAdminRole(actualRoles.value)) {
			const urlParams = new URLSearchParams(window.location.search);
			const queryRole = normalizeRole(urlParams.get("role"));
			const storedRole = normalizeRole(
				sessionStorage.getItem(PREVIEW_STORAGE_KEY),
			);

			if (queryRole && ROLES[queryRole]) {
				previewRole.value = queryRole;
				sessionStorage.setItem(PREVIEW_STORAGE_KEY, queryRole);
			} else if (storedRole && ROLES[storedRole]) {
				previewRole.value = storedRole;
			}
		} else {
			previewRole.value = "";
			sessionStorage.removeItem(PREVIEW_STORAGE_KEY);
		}
	} catch (err) {
		console.warn("[docs:role] Failed to resolve user role:", err);
		resetToGuest();
	} finally {
		isLoading.value = false;
	}
}

export function useUserRole() {
	const { theme } = useData();

	if (inBrowser && !isInitialized.value) {
		isInitialized.value = true;
		const authConfig = theme.value?.auth || {};
		detectUserRole(authConfig);

		// Re-check login cookie when returning to this tab
		window.addEventListener("focus", () => {
			detectUserRole(theme.value?.auth || {});
		});
	}

	const canSwitchRole = computed(
		() => isAuthenticated.value && isAdminRole(actualRoles.value),
	);

	const isPreviewing = computed(
		() => Boolean(previewRole.value) && canSwitchRole.value,
	);

	const activeRoles = computed(() =>
		isPreviewing.value ? [previewRole.value] : actualRoles.value,
	);

	const primaryRole = computed(() => activeRoles.value[0] || "GUEST");

	const primaryRoleMeta = computed(
		() =>
			ROLES[primaryRole.value] || {
				key: primaryRole.value,
				label: primaryRole.value,
				description: "",
			},
	);

	const loginUrl = computed(() => {
		const auth = theme.value?.auth || {};
		if (auth.appHost && auth.appId) {
			return `${auth.appHost}/form/authen/index/${auth.appId}/`;
		}
		return auth.appEnv || "/procurement";
	});

	function canAccess(allowedRoles) {
		const bypassAdmin = !isPreviewing.value;
		return hasRoleAccess(allowedRoles, activeRoles.value, { bypassAdmin });
	}

	function setPreviewRole(roleKey) {
		if (!canSwitchRole.value || !inBrowser) return;
		const normalized = normalizeRole(roleKey);
		if (!normalized || normalized === "ACTUAL") {
			clearPreviewRole();
			return;
		}
		previewRole.value = normalized;
		sessionStorage.setItem(PREVIEW_STORAGE_KEY, normalized);
	}

	function clearPreviewRole() {
		previewRole.value = "";
		if (inBrowser) {
			sessionStorage.removeItem(PREVIEW_STORAGE_KEY);
		}
	}

	async function refreshRole() {
		await detectUserRole(theme.value?.auth || {});
	}

	return {
		isLoading,
		isAuthenticated,
		empNo,
		empName,
		groupCode,
		actualRoles,
		activeRoles,
		primaryRole,
		primaryRoleMeta,
		canSwitchRole,
		isPreviewing,
		previewRole,
		loginUrl,
		canAccess,
		setPreviewRole,
		clearPreviewRole,
		refreshRole,
	};
}
