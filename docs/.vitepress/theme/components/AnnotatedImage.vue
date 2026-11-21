<script setup>
import { computed, ref } from "vue";
import { withBase } from "vitepress";

const props = defineProps({
	src: {
		type: String,
		required: true,
	},
	alt: {
		type: String,
		default: "Screenshot",
	},
	caption: {
		type: String,
		default: "",
	},
	markers: {
		type: Array,
		default: () => [],
	},
});

const activeIndex = ref(-1);

const resolvedSrc = computed(() =>
	props.src.startsWith("/") ? withBase(props.src) : props.src,
);
</script>

<template>
	<figure class="vp-annotated-figure">
		<div class="vp-annotated-stage">
			<img :src="resolvedSrc" :alt="alt" class="vp-annotated-img" loading="lazy" />

			<button
				v-for="(m, idx) in markers"
				:key="idx"
				type="button"
				class="vp-marker-pin"
				:class="{ 'is-active': activeIndex === idx }"
				:style="{ left: `${m.x}%`, top: `${m.y}%` }"
				:title="`${idx + 1}. ${m.title}`"
				:aria-label="`${idx + 1}. ${m.title}`"
				@mouseenter="activeIndex = idx"
				@mouseleave="activeIndex = -1"
				@focus="activeIndex = idx"
				@blur="activeIndex = -1"
				@click="activeIndex = activeIndex === idx ? -1 : idx"
			>
				{{ idx + 1 }}
			</button>
		</div>

		<figcaption v-if="caption" class="vp-annotated-caption">
			{{ caption }}
		</figcaption>

		<ol v-if="markers.length" class="vp-marker-legend">
			<li
				v-for="(m, idx) in markers"
				:key="idx"
				class="vp-legend-item"
				:class="{ 'is-active': activeIndex === idx }"
				@mouseenter="activeIndex = idx"
				@mouseleave="activeIndex = -1"
			>
				<span class="vp-legend-num">{{ idx + 1 }}</span>
				<div class="vp-legend-body">
					<strong class="vp-legend-title">{{ m.title }}</strong>
					<p class="vp-legend-desc">{{ m.desc }}</p>
				</div>
			</li>
		</ol>
	</figure>
</template>

<style scoped>
.vp-annotated-figure {
	margin: 1.25rem 0 1.75rem;
}

.vp-annotated-stage {
	position: relative;
	border: 1px solid var(--vp-c-divider);
	background: var(--vp-c-bg-soft);
	overflow: hidden;
	box-shadow: 0 4px 18px rgba(15, 23, 42, 0.08);
}

.vp-annotated-img {
	display: block;
	width: 100%;
	height: auto;
	margin: 0 !important;
}

.vp-marker-pin {
	position: absolute;
	transform: translate(-50%, -50%);
	width: 26px;
	height: 26px;
	border-radius: 9999px;
	border: 2px solid #ffffff;
	background: #e60012;
	color: #ffffff;
	font-size: 12px;
	font-weight: 800;
	line-height: 1;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	cursor: pointer;
	box-shadow: 0 2px 10px rgba(230, 0, 18, 0.45);
	transition:
		transform 0.18s ease,
		background-color 0.18s ease,
		box-shadow 0.18s ease;
	z-index: 2;
}

.vp-marker-pin:hover,
.vp-marker-pin.is-active {
	transform: translate(-50%, -50%) scale(1.22);
	background: #2563eb;
	box-shadow: 0 0 0 5px rgba(37, 99, 235, 0.25);
	z-index: 4;
}

.vp-annotated-caption {
	margin-top: 0.5rem;
	font-size: 12px;
	color: var(--vp-c-text-2);
	text-align: center;
}

.vp-marker-legend {
	list-style: none !important;
	margin: 0.85rem 0 0 !important;
	padding: 0 !important;
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
	gap: 8px;
}

.vp-legend-item {
	display: flex;
	align-items: flex-start;
	gap: 10px;
	padding: 10px 12px;
	border: 1px solid var(--vp-c-divider);
	background: var(--vp-c-bg-soft);
	transition:
		border-color 0.18s ease,
		background-color 0.18s ease;
	margin: 0 !important;
}

.vp-legend-item.is-active {
	border-color: #2563eb;
	background: var(--vp-c-brand-soft);
}

.vp-legend-num {
	flex-shrink: 0;
	width: 22px;
	height: 22px;
	border-radius: 9999px;
	background: #e60012;
	color: #ffffff;
	font-size: 11px;
	font-weight: 800;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	margin-top: 1px;
}

.vp-legend-item.is-active .vp-legend-num {
	background: #2563eb;
}

.vp-legend-body {
	min-width: 0;
}

.vp-legend-title {
	display: block;
	font-size: 13px;
	line-height: 1.35;
	color: var(--vp-c-text-1);
}

.vp-legend-desc {
	margin: 2px 0 0 !important;
	font-size: 12px;
	line-height: 1.5;
	color: var(--vp-c-text-2);
}
</style>
