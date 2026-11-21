/**
 * Role-based documentation access configuration for AMEC Procurement System.
 *
 * วิธีปรับแต่งสิทธิ์ให้ตรงกับ GROUP_CODE จริงในระบบ @amec/webasset:
 * 1. เพิ่ม/แก้ไข role ใน ROLES
 * 2. ผูก GROUP_CODE จาก IndexedDB (`userAuth.group.data.GROUP_CODE`) ใน GROUP_CODE_TO_ROLE
 *    (หาก GROUP_CODE ตรงกับชื่อ key ใน ROLES อยู่แล้ว ระบบจะจับคู่ให้อัตโนมัติ)
 * 3. กำหนดสิทธิ์รายหน้าใน frontmatter ของไฟล์ .md ด้วย `roles: ['BUYER', 'ADMIN']`
 *    หรือใช้ค่าเริ่มต้นตาม path ใน PAGE_ROLE_RULES
 */

export const ROLES = {
	ADMIN: {
		key: "ADMIN",
		label: "Admin",
		description: "Full access to all documentation and role preview",
	},
	REQUESTER: {
		key: "REQUESTER",
		label: "Requester",
		description: "P/R creation and personal request tracking",
	},
	APPROVER: {
		key: "APPROVER",
		label: "Approver",
		description: "P/R and P/O approval workflows & reports",
	},
	BUYER: {
		key: "BUYER",
		label: "Buyer",
		description: "P/O issuance, vendor management, products & reports",
	},
	WAREHOUSE: {
		key: "WAREHOUSE",
		label: "Warehouse",
		description: "Receiving, receiving plans & inventory",
	},
	ACCOUNTING: {
		key: "ACCOUNTING",
		label: "Accounting",
		description: "Invoice/Tax verification & matching reports",
	},
	GUEST: {
		key: "GUEST",
		label: "Guest",
		description: "Public / general documentation only",
	},
};

/**
 * Roles that have full access to all docs and can switch preview roles.
 */
export const ADMIN_ROLES = ["ADMIN", "ADM", "SUPERADMIN", "IT"];

/**
 * Map AMEC GROUP_CODE (from @amec/webasset IndexedDB `userAuth.group`)
 * to one or more documentation role keys above.
 *
 * ตัวอย่าง: ถ้า GROUP_CODE ในระบบคือ "PUR01" ให้เพิ่ม:
 *   PUR01: ["BUYER"],
 */
export const GROUP_CODE_TO_ROLE = {
	ADMIN: ["ADMIN"],
	ADM: ["ADMIN"],
	SUPERADMIN: ["ADMIN"],
	IT: ["ADMIN"],
	REQUESTER: ["REQUESTER"],
	REQ: ["REQUESTER"],
	USER: ["REQUESTER"],
	APPROVER: ["APPROVER"],
	APP: ["APPROVER"],
	MGR: ["APPROVER"],
	BUYER: ["BUYER"],
	PUR: ["BUYER"],
	PROCUREMENT: ["BUYER"],
	WAREHOUSE: ["WAREHOUSE"],
	WH: ["WAREHOUSE"],
	ACCOUNTING: ["ACCOUNTING"],
	ACC: ["ACCOUNTING"],
	FIN: ["ACCOUNTING"],
};

/**
 * Default path-prefix rules when a markdown page does not explicitly specify
 * `roles` in its frontmatter. Most specific prefix wins.
 * Omit or use ["*"] for pages accessible to every user.
 */
export const PAGE_ROLE_RULES = [
	{ prefix: "/pr/approval", roles: ["ADMIN", "APPROVER", "BUYER"] },
	{ prefix: "/pr/", roles: ["ADMIN", "REQUESTER", "APPROVER", "BUYER"] },

	{ prefix: "/po/approve", roles: ["ADMIN", "APPROVER", "BUYER"] },
	{ prefix: "/po/", roles: ["ADMIN", "BUYER", "APPROVER"] },

	{ prefix: "/receive/invoice", roles: ["ADMIN", "ACCOUNTING", "BUYER"] },
	{ prefix: "/receive/", roles: ["ADMIN", "WAREHOUSE", "BUYER", "ACCOUNTING"] },

	{ prefix: "/product/", roles: ["ADMIN", "BUYER", "WAREHOUSE"] },

	{ prefix: "/vendor/approve", roles: ["ADMIN", "APPROVER", "BUYER"] },
	{ prefix: "/vendor/", roles: ["ADMIN", "BUYER"] },

	{ prefix: "/report/matching", roles: ["ADMIN", "ACCOUNTING", "BUYER"] },
	{ prefix: "/report/inventory", roles: ["ADMIN", "WAREHOUSE", "BUYER"] },
	{
		prefix: "/report/",
		roles: ["ADMIN", "BUYER", "APPROVER", "ACCOUNTING", "WAREHOUSE"],
	},
];

export function normalizeRole(role) {
	return String(role ?? "")
		.trim()
		.toUpperCase();
}

export function resolveRolesFromGroupCode(groupCode) {
	const normalized = normalizeRole(groupCode);
	if (!normalized) return ["GUEST"];

	if (GROUP_CODE_TO_ROLE[normalized]) {
		return GROUP_CODE_TO_ROLE[normalized];
	}
	if (ROLES[normalized]) {
		return [normalized];
	}
	// Keep raw GROUP_CODE so pages can also match custom codes directly
	return [normalized];
}

export function isAdminRole(roles) {
	const list = Array.isArray(roles) ? roles : [roles];
	return list.some((r) => ADMIN_ROLES.includes(normalizeRole(r)));
}

/**
 * Check if `userRoles` satisfies `allowedRoles`.
 * @param {string[] | string | undefined | null} allowedRoles
 * @param {string[] | string} userRoles
 * @param {{ bypassAdmin?: boolean }} [options]
 */
export function hasRoleAccess(allowedRoles, userRoles, options = {}) {
	const { bypassAdmin = true } = options;

	if (
		!allowedRoles ||
		(Array.isArray(allowedRoles) && allowedRoles.length === 0)
	) {
		return true;
	}

	const allowed = (Array.isArray(allowedRoles) ? allowedRoles : [allowedRoles])
		.map(normalizeRole)
		.filter(Boolean);

	if (allowed.length === 0 || allowed.includes("*")) {
		return true;
	}

	const current = (Array.isArray(userRoles) ? userRoles : [userRoles])
		.map(normalizeRole)
		.filter(Boolean);

	if (bypassAdmin && isAdminRole(current)) {
		return true;
	}

	return current.some((role) => allowed.includes(role));
}

/**
 * Strip VitePress base path (e.g. "/procurement/docs") and `.html` suffix.
 */
export function normalizeDocPath(rawPath, base = "/procurement/docs/") {
	let path = String(rawPath || "/");
	const cleanBase = base.endsWith("/") ? base.slice(0, -1) : base;
	if (cleanBase && path.startsWith(cleanBase)) {
		path = path.slice(cleanBase.length) || "/";
	}
	path = path.replace(/\.html$/, "").replace(/\/index$/, "/");
	if (!path.startsWith("/")) path = `/${path}`;
	return path;
}

/**
 * Resolve required roles for a doc route using explicit frontmatter `roles`
 * first, falling back to PAGE_ROLE_RULES by path prefix.
 */
export function getRequiredRolesForPage(
	rawPath,
	frontmatterRoles,
	base = "/procurement/docs/",
) {
	if (frontmatterRoles !== undefined && frontmatterRoles !== null) {
		if (frontmatterRoles === "*" || frontmatterRoles === "all") return null;
		const list = Array.isArray(frontmatterRoles)
			? frontmatterRoles
			: [frontmatterRoles];
		if (list.length === 0 || list.includes("*")) return null;
		return list.map(normalizeRole);
	}

	const normalized = normalizeDocPath(rawPath, base);
	// Sort by longest prefix so specific rules (e.g. /pr/approval) override /pr/
	const sorted = [...PAGE_ROLE_RULES].sort(
		(a, b) => b.prefix.length - a.prefix.length,
	);
	const matched = sorted.find((rule) => normalized.startsWith(rule.prefix));
	return matched ? matched.roles : null;
}

/**
 * Recursively filter VitePress sidebar items according to `userRoles`.
 */
export function filterSidebarItems(items, userRoles, options = {}) {
	if (!Array.isArray(items)) return [];

	const result = [];
	for (const item of items) {
		if (!item) continue;

		// Explicit item.roles takes precedence; otherwise infer from item.link
		const requiredRoles =
			item.roles !== undefined
				? item.roles
				: item.link
					? getRequiredRolesForPage(item.link, undefined, "")
					: null;

		if (!hasRoleAccess(requiredRoles, userRoles, options)) {
			continue;
		}

		if (Array.isArray(item.items)) {
			const filteredChildren = filterSidebarItems(
				item.items,
				userRoles,
				options,
			);
			// Drop group if it has no direct link and all children were filtered out
			if (filteredChildren.length === 0 && !item.link) {
				continue;
			}
			result.push({
				...item,
				items: filteredChildren,
			});
		} else {
			result.push(item);
		}
	}
	return result;
}
