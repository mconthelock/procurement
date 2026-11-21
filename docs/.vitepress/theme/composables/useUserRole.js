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
				// DB does not exist yet — abort so we don't create an empty DB
				// that might conflict with @amec/webasset's schema hash.
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

async function detectUserRole(appName = "procurement") {
	if (!inBrowser) return;

	isLoading.value = true;
	try {
		const cookie = Cookies.get(appName);
		if (cookie) {
			const decrypted = CryptoJS.AES.decrypt(cookie, appName).toString(
				CryptoJS.enc.Utf8,
			);
			if (decrypted && decrypted.includes("-")) {
				const [, emp] = decrypted.split("-");
				empNo.value = emp || "";

				const cachedGroup = await readGroupFromIndexedDB(decrypted);
				const code = cachedGroup?.data?.GROUP_CODE || "";
				if (code) {
					groupCode.value = code;
					actualRoles.value = resolveRolesFromGroupCode(code);
					isAuthenticated.value = true;
				}
			}
		}

		// In local dev without an active AMEC login session, default to ADMIN
		// so authors can browse and test with the Role Switcher.
		if (!isAuthenticated.value && import.meta.env.DEV) {
			actualRoles.value = ["ADMIN"];
			groupCode.value = "DEV_ADMIN";
		}

		// Restore preview role (only allowed for Admin or DEV)
		const canPreview = isAdminRole(actualRoles.value) || import.meta.env.DEV;
		if (canPreview) {
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
		}
	} catch (err) {
		console.warn("[docs:role] Failed to resolve user role:", err);
	} finally {
		isLoading.value = false;
	}
}

export function useUserRole() {
	const { theme } = useData();

	if (inBrowser && !isInitialized.value) {
		isInitialized.value = true;
		const appName = theme.value?.auth?.appName || "procurement";
		detectUserRole(appName);
	}

	const canSwitchRole = computed(
		() => isAdminRole(actualRoles.value) || import.meta.env.DEV,
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

	function canAccess(allowedRoles) {
		// When previewing a non-admin role, disable admin bypass so the preview is accurate
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
		const appName = theme.value?.auth?.appName || "procurement";
		await detectUserRole(appName);
	}

	return {
		isLoading,
		isAuthenticated,
		empNo,
		groupCode,
		actualRoles,
		activeRoles,
		primaryRole,
		primaryRoleMeta,
		canSwitchRole,
		isPreviewing,
		previewRole,
		canAccess,
		setPreviewRole,
		clearPreviewRole,
		refreshRole,
	};
}
