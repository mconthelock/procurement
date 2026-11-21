<script setup>
import { computed, onMounted, ref } from "vue";
import { useUserRole } from "../composables/useUserRole.js";

const props = defineProps({
	roles: {
		type: [Array, String],
		required: true,
	},
	showNotice: {
		type: Boolean,
		default: false,
	},
	noticeText: {
		type: String,
		default: "เนื้อหาส่วนนี้จำกัดสิทธิ์การเข้าถึงตามบทบาทผู้ใช้งาน",
	},
});

const { canAccess } = useUserRole();
const isMounted = ref(false);

onMounted(() => {
	isMounted.value = true;
});

const allowed = computed(() => {
	if (!isMounted.value) return false;
	return canAccess(props.roles);
});

const roleListText = computed(() =>
	(Array.isArray(props.roles) ? props.roles : [props.roles]).join(", "),
);
</script>

<template>
	<div v-if="allowed" class="vp-role-only">
		<slot />
	</div>
	<slot v-else-if="isMounted && $slots.fallback" name="fallback" />
	<div v-else-if="isMounted && showNotice" class="vp-role-only-notice">
		<strong>Restricted Section ({{ roleListText }})</strong>
		<p>{{ noticeText }}</p>
	</div>
</template>

<style scoped>
.vp-role-only-notice {
	margin: 1rem 0;
	padding: 0.875rem 1rem;
	border: 1px solid var(--vp-c-divider);
	border-left: 3px solid var(--vp-c-warning-1);
	background: var(--vp-c-warning-soft);
	font-size: 0.875rem;
	color: var(--vp-c-text-1);
}

.vp-role-only-notice p {
	margin: 0.25rem 0 0;
	color: var(--vp-c-text-2);
}
</style>
