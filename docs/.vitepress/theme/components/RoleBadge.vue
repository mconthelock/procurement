<script setup>
import { onMounted, ref } from "vue";
import { useUserRole } from "../composables/useUserRole.js";

const { isAuthenticated, empNo, primaryRoleMeta, loginUrl } = useUserRole();

const isMounted = ref(false);
onMounted(() => {
	isMounted.value = true;
});
</script>

<template>
	<div v-if="isMounted" class="vp-role-badge-wrap">
		<span
			v-if="isAuthenticated"
			class="vp-role-pill"
			:title="primaryRoleMeta.description"
		>
			<span class="vp-role-dot" />
			<span>{{ primaryRoleMeta.label }}</span>
			<span v-if="empNo" class="vp-role-emp">({{ empNo }})</span>
		</span>

		<div v-else class="vp-guest-group">
			<span class="vp-role-pill is-guest" title="ยังไม่ได้เข้าสู่ระบบ (Guest)">
				<span class="vp-role-dot is-guest" />
				<span>Guest</span>
			</span>
			<a :href="loginUrl" class="vp-login-btn">Login</a>
		</div>
	</div>
</template>

<style scoped>
.vp-role-badge-wrap {
	display: inline-flex;
	align-items: center;
	margin-left: 12px;
}

.vp-guest-group {
	display: inline-flex;
	align-items: center;
	gap: 6px;
}

.vp-role-pill {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	height: 28px;
	padding: 0 10px;
	border: 1px solid var(--vp-c-divider);
	background: var(--vp-c-bg-soft);
	color: var(--vp-c-text-1);
	font-size: 12px;
	font-weight: 600;
	line-height: 1;
	white-space: nowrap;
}

.vp-role-emp {
	color: var(--vp-c-text-2);
	font-weight: 500;
}

.vp-role-dot {
	width: 7px;
	height: 7px;
	border-radius: 50%;
	background: var(--vp-c-brand-1);
	flex-shrink: 0;
}

.vp-role-dot.is-guest {
	background: var(--vp-c-text-3);
}

.vp-login-btn {
	display: inline-flex;
	align-items: center;
	height: 28px;
	padding: 0 10px;
	background: var(--vp-c-brand-3);
	color: var(--vp-c-white) !important;
	font-size: 12px;
	font-weight: 600;
	text-decoration: none;
	line-height: 1;
	white-space: nowrap;
	transition: opacity 0.2s;
}

.vp-login-btn:hover {
	opacity: 0.88;
}

@media (max-width: 767px) {
	.vp-role-emp {
		display: none;
	}
}
</style>
