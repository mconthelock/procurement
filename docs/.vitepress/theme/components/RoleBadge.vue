<script setup>
import { computed, onMounted, ref } from "vue";
import { ROLES } from "../../roles.js";
import { useUserRole } from "../composables/useUserRole.js";

const {
	primaryRole,
	primaryRoleMeta,
	actualRoles,
	canSwitchRole,
	isPreviewing,
	previewRole,
	setPreviewRole,
} = useUserRole();

const isMounted = ref(false);
onMounted(() => {
	isMounted.value = true;
});

const roleOptions = computed(() => Object.values(ROLES));
const selectedValue = computed(() =>
	isPreviewing.value ? previewRole.value : "ACTUAL",
);

function onRoleChange(event) {
	setPreviewRole(event.target.value);
}
</script>

<template>
	<div v-if="isMounted" class="vp-role-badge-wrap">
		<label v-if="canSwitchRole" class="vp-role-switcher" title="Preview documentation as role">
			<span class="vp-role-dot" :class="{ 'is-preview': isPreviewing }" />
			<span class="vp-role-prefix">{{ isPreviewing ? "Preview" : "Role" }}:</span>
			<select
				class="vp-role-select"
				aria-label="Preview documentation role"
				:value="selectedValue"
				@change="onRoleChange"
			>
				<option value="ACTUAL">
					{{ actualRoles[0] || "ADMIN" }} (Actual)
				</option>
				<option
					v-for="role in roleOptions"
					:key="role.key"
					:value="role.key"
				>
					{{ role.label }} ({{ role.key }})
				</option>
			</select>
		</label>

		<span v-else class="vp-role-pill" :title="primaryRoleMeta.description">
			<span class="vp-role-dot" />
			<span>{{ primaryRoleMeta.label }}</span>
		</span>
	</div>
</template>

<style scoped>
.vp-role-badge-wrap {
	display: inline-flex;
	align-items: center;
	margin-left: 12px;
}

.vp-role-switcher,
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

.vp-role-dot {
	width: 7px;
	height: 7px;
	border-radius: 50%;
	background: var(--vp-c-brand-1);
	flex-shrink: 0;
}

.vp-role-dot.is-preview {
	background: var(--vp-c-warning-1);
}

.vp-role-prefix {
	color: var(--vp-c-text-2);
	font-weight: 500;
}

.vp-role-select {
	appearance: auto;
	background: transparent;
	border: none;
	color: var(--vp-c-text-1);
	font-size: 12px;
	font-weight: 600;
	cursor: pointer;
	outline: none;
	padding-right: 2px;
}

.vp-role-select option {
	background: var(--vp-c-bg);
	color: var(--vp-c-text-1);
}

@media (max-width: 767px) {
	.vp-role-prefix {
		display: none;
	}
}
</style>
