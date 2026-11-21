<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from "vue";
import VPSidebarItem from "vitepress/dist/client/theme-default/components/VPSidebarItem.vue";
import { filterSidebarItems } from "../../roles.js";
import { useUserRole } from "../composables/useUserRole.js";

const props = defineProps({
	items: {
		type: Array,
		required: true,
	},
});

const { activeRoles, isPreviewing } = useUserRole();
const isMounted = ref(false);
const disableTransition = ref(true);
let timer = null;

onMounted(() => {
	isMounted.value = true;
	timer = setTimeout(() => {
		timer = null;
		disableTransition.value = false;
	}, 300);
});

onBeforeUnmount(() => {
	if (timer != null) {
		clearTimeout(timer);
		timer = null;
	}
});

const visibleItems = computed(() => {
	if (!isMounted.value) return props.items;
	return filterSidebarItems(props.items, activeRoles.value, {
		bypassAdmin: !isPreviewing.value,
	});
});
</script>

<template>
	<div
		v-for="item in visibleItems"
		:key="item.text"
		class="group"
		:class="{ 'no-transition': disableTransition }"
	>
		<VPSidebarItem :item="item" :depth="0" />
	</div>
</template>

<style scoped>
.no-transition :deep(.caret-icon) {
	transition: none;
}

.group + .group {
	border-top: 1px solid var(--vp-c-divider);
	padding-top: 0.625rem;
}

@media (min-width: 60rem) {
	.group {
		padding-top: 0.625rem;
		width: calc(var(--vp-sidebar-width) - 4rem);
	}
}
</style>
