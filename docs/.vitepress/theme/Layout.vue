<script setup>
import { computed, onMounted, ref } from "vue";
import DefaultTheme from "vitepress/theme";
import { useData, useRoute, withBase } from "vitepress";
import { ROLES, getRequiredRolesForPage } from "../roles.js";
import { useUserRole } from "./composables/useUserRole.js";
import RoleBadge from "./components/RoleBadge.vue";

const { Layout } = DefaultTheme;
const { frontmatter, site, theme } = useData();
const route = useRoute();

const {
	isLoading,
	isAuthenticated,
	primaryRole,
	primaryRoleMeta,
	isPreviewing,
	clearPreviewRole,
	canAccess,
} = useUserRole();

const isMounted = ref(false);
onMounted(() => {
	isMounted.value = true;
});

const isHome = computed(
	() =>
		frontmatter.value.layout === "home" ||
		Boolean(frontmatter.value.isHome),
);

const requiredRoles = computed(() => {
	if (isHome.value) return null;
	return getRequiredRolesForPage(
		route.path,
		frontmatter.value.roles,
		site.value.base,
	);
});

const isPageAllowed = computed(() => {
	if (!isMounted.value || isHome.value) return true;
	if (!requiredRoles.value || requiredRoles.value.length === 0) return true;
	if (isLoading.value) return false;
	return canAccess(requiredRoles.value);
});

const requiredRoleLabels = computed(() => {
	if (!requiredRoles.value) return [];
	return requiredRoles.value.map((key) => ROLES[key]?.label || key);
});

const appHostUrl = computed(() => theme.value?.auth?.appHost || "/procurement");
const quickStartUrl = computed(() => withBase("/quick-start"));
</script>

<template>
	<div
		class="vp-role-layout"
		:class="{
			'vp-role-denied-active': isMounted && !isPageAllowed,
			'vp-role-loading': isMounted && isLoading && requiredRoles?.length,
		}"
	>
		<Layout>
			<template #nav-bar-content-after>
				<RoleBadge />
			</template>

			<template #nav-screen-content-after>
				<div class="vp-mobile-role-wrap">
					<RoleBadge />
				</div>
			</template>

			<template #doc-before>
				<div
					v-if="isMounted && !isPageAllowed && !isLoading"
					class="vp-access-denied"
					role="alert"
				>
					<div class="vp-access-denied-eyebrow">ACCESS RESTRICTED</div>
					<h1 class="vp-access-denied-title">
						คุณไม่มีสิทธิ์เข้าถึงเอกสารหน้านี้
					</h1>
					<p class="vp-access-denied-desc">
						เอกสารนี้ถูกจำกัดไว้สำหรับบทบาทผู้ใช้งานที่กำหนดเท่านั้น
					</p>

					<div class="vp-access-denied-meta">
						<div>
							<span class="meta-label">บทบาทปัจจุบันของคุณ:</span>
							<span class="meta-chip current">
								{{ primaryRoleMeta.label }} ({{ primaryRole }})
							</span>
						</div>
						<div>
							<span class="meta-label">บทบาทที่ได้รับอนุญาต:</span>
							<span
								v-for="label in requiredRoleLabels"
								:key="label"
								class="meta-chip"
							>
								{{ label }}
							</span>
						</div>
					</div>

					<div class="vp-access-denied-actions">
						<a :href="quickStartUrl" class="vp-btn-primary">
							กลับไปหน้า Quick Start
						</a>
						<a
							v-if="!isAuthenticated"
							:href="appHostUrl"
							class="vp-btn-secondary"
						>
							เข้าสู่ระบบ Procurement
						</a>
						<button
							v-if="isPreviewing"
							type="button"
							class="vp-btn-secondary"
							@click="clearPreviewRole"
						>
							ออกจากโหมด Preview
						</button>
					</div>
				</div>

				<div
					v-else-if="isMounted && requiredRoleLabels.length > 0 && !isLoading"
					class="vp-doc-role-bar"
				>
					<span class="vp-doc-role-label">เอกสารสำหรับบทบาท:</span>
					<span
						v-for="label in requiredRoleLabels"
						:key="label"
						class="vp-doc-role-tag"
					>
						{{ label }}
					</span>
				</div>
			</template>
		</Layout>
	</div>
</template>

<style scoped>
.vp-mobile-role-wrap {
	margin-top: 16px;
	display: flex;
	justify-content: center;
}

.vp-doc-role-bar {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	gap: 6px;
	margin-bottom: 16px;
	padding: 8px 12px;
	border: 1px solid var(--vp-c-divider);
	background: var(--vp-c-bg-soft);
	font-size: 12px;
}

.vp-doc-role-label {
	color: var(--vp-c-text-2);
	font-weight: 500;
	margin-right: 4px;
}

.vp-doc-role-tag {
	display: inline-flex;
	align-items: center;
	padding: 2px 8px;
	background: var(--vp-c-brand-soft);
	color: var(--vp-c-brand-1);
	font-weight: 600;
	font-size: 11px;
	letter-spacing: 0.02em;
}

.vp-access-denied {
	margin: 24px 0;
	padding: 28px 24px;
	border: 1px solid var(--vp-c-danger-soft);
	border-left: 4px solid var(--vp-c-danger-1);
	background: var(--vp-c-bg-soft);
}

.vp-access-denied-eyebrow {
	font-size: 11px;
	font-weight: 700;
	letter-spacing: 0.08em;
	color: var(--vp-c-danger-1);
	margin-bottom: 8px;
}

.vp-access-denied-title {
	margin: 0 0 8px;
	font-size: 22px;
	font-weight: 700;
	line-height: 1.3;
	color: var(--vp-c-text-1);
}

.vp-access-denied-desc {
	margin: 0 0 18px;
	font-size: 14px;
	color: var(--vp-c-text-2);
}

.vp-access-denied-meta {
	display: flex;
	flex-direction: column;
	gap: 8px;
	margin-bottom: 20px;
	font-size: 13px;
}

.meta-label {
	color: var(--vp-c-text-2);
	margin-right: 8px;
}

.meta-chip {
	display: inline-block;
	padding: 2px 8px;
	margin-right: 6px;
	border: 1px solid var(--vp-c-divider);
	background: var(--vp-c-bg);
	color: var(--vp-c-text-1);
	font-size: 12px;
	font-weight: 600;
}

.meta-chip.current {
	border-color: var(--vp-c-danger-soft);
	color: var(--vp-c-danger-1);
}

.vp-access-denied-actions {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
}

.vp-btn-primary,
.vp-btn-secondary {
	display: inline-flex;
	align-items: center;
	padding: 8px 16px;
	font-size: 13px;
	font-weight: 600;
	text-decoration: none;
	cursor: pointer;
	transition: opacity 0.2s;
}

.vp-btn-primary {
	background: var(--vp-c-brand-3);
	color: var(--vp-c-white);
	border: 1px solid transparent;
}

.vp-btn-secondary {
	background: var(--vp-c-bg);
	color: var(--vp-c-text-1);
	border: 1px solid var(--vp-c-divider);
}

.vp-btn-primary:hover,
.vp-btn-secondary:hover {
	opacity: 0.88;
}
</style>

<style>
/* Hide restricted markdown body, outline, and prev/next footer when access is denied */
.vp-role-denied-active .vp-doc,
.vp-role-denied-active .VPDocFooter,
.vp-role-denied-active .VPDoc .aside,
.vp-role-loading .vp-doc {
	display: none !important;
}
</style>
