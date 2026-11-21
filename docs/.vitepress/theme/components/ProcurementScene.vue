<template>
	<div
		ref="containerRef"
		class="procurement-scene-container"
		:class="{ 'is-dark-scene': isDark }"
		aria-hidden="true"
	>
		<canvas ref="canvasRef" class="procurement-scene-canvas"></canvas>
		<div class="procurement-scene-vignette"></div>
	</div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref, watch } from "vue";
import { useData } from "vitepress";
import * as THREE from "three";

const { isDark } = useData();
const containerRef = ref(null);
const canvasRef = ref(null);

let animationFrameId = null;
let lightingIntervalId = null;
let renderer = null;
let scene = null;
let camera = null;
let handleResize = null;
let handlePointerMove = null;
let applyEnvironment = null;

/**
 * Compute target environment palette & lighting intensities.
 * - Dark mode: Illuminated night shift with bright factory, port & ship lights ON.
 * - Light mode: Adjusts smoothly to real local clock time while keeping a bright,
 *   clean visual tone (morning gold -> bright midday -> golden afternoon -> bright twilight).
 */
function getEnvironmentConfig(darkMode, now = new Date()) {
	if (darkMode) {
		return {
			skyHex: 0x0f1f38,
			fogHex: 0x0f1f38,
			fogDensity: 0.013,
			exposure: 1.28,
			hemiSky: 0x7aa7e8,
			hemiGround: 0x1e293b,
			hemiIntensity: 0.95,
			sunColor: 0x93c5fd,
			sunIntensity: 0.9,
			sunPos: [-14, 20, -16],
			waterColor: 0x0d3b66,
			waterEmissive: 0x061b33,
			groundColor: 0x132238,
			padColor: 0x1e2f47,
			roadColor: 0x162235,
			lightsOn: true,
			nightFactor: 1.0,
		};
	}

	const hour = now.getHours() + now.getMinutes() / 60;

	// Morning (05:30 - 09:30)
	if (hour >= 5.5 && hour < 9.5) {
		return {
			skyHex: 0xd8ecff,
			fogHex: 0xdeeeff,
			fogDensity: 0.0085,
			exposure: 1.18,
			hemiSky: 0xfff5e4,
			hemiGround: 0x8da4bd,
			hemiIntensity: 1.15,
			sunColor: 0xffe4b5,
			sunIntensity: 1.85,
			sunPos: [26, 16, 12],
			waterColor: 0x228be6,
			waterEmissive: 0x0b3b66,
			groundColor: 0xdbe6f2,
			padColor: 0xcbd5e1,
			roadColor: 0x475569,
			lightsOn: false,
			nightFactor: 0.15,
		};
	}

	// Bright Midday (09:30 - 16:00)
	if (hour >= 9.5 && hour < 16.0) {
		return {
			skyHex: 0xcce6ff,
			fogHex: 0xd8ecff,
			fogDensity: 0.0075,
			exposure: 1.16,
			hemiSky: 0xffffff,
			hemiGround: 0x94a3b8,
			hemiIntensity: 1.25,
			sunColor: 0xfffdf5,
			sunIntensity: 2.0,
			sunPos: [16, 30, 14],
			waterColor: 0x1c7ed6,
			waterEmissive: 0x0b4475,
			groundColor: 0xdce7f2,
			padColor: 0xcbd5e1,
			roadColor: 0x475569,
			lightsOn: false,
			nightFactor: 0.0,
		};
	}

	// Golden Afternoon (16:00 - 18:45)
	if (hour >= 16.0 && hour < 18.75) {
		return {
			skyHex: 0xf4dfcc,
			fogHex: 0xf2e1d2,
			fogDensity: 0.009,
			exposure: 1.18,
			hemiSky: 0xffe8cc,
			hemiGround: 0x8c7b75,
			hemiIntensity: 1.1,
			sunColor: 0xffb86c,
			sunIntensity: 1.9,
			sunPos: [-24, 13, 16],
			waterColor: 0x1e6fa8,
			waterEmissive: 0x1f3a56,
			groundColor: 0xd8dfe8,
			padColor: 0xc7ced8,
			roadColor: 0x475569,
			lightsOn: true,
			nightFactor: 0.45,
		};
	}

	// Real-time Evening / Blue-Hour while in Light Mode (18:45 - 05:30):
	// Keeps a bright, clear twilight sky with industrial & port lights turned ON.
	return {
		skyHex: 0xa6c4e5,
		fogHex: 0xb1cce8,
		fogDensity: 0.0095,
		exposure: 1.22,
		hemiSky: 0xdbeafe,
		hemiGround: 0x64748b,
		hemiIntensity: 1.2,
		sunColor: 0xffe0b2,
		sunIntensity: 1.25,
		sunPos: [-20, 15, 14],
		waterColor: 0x195e96,
		waterEmissive: 0x0c3459,
		groundColor: 0xc3d3e6,
		padColor: 0xb4c2d4,
		roadColor: 0x3b485c,
		lightsOn: true,
		nightFactor: 0.72,
	};
}

onMounted(() => {
	if (typeof window === "undefined" || !canvasRef.value) return;

	const reducedMotion = window.matchMedia?.(
		"(prefers-reduced-motion: reduce)",
	)?.matches;

	// --- Renderer ---
	renderer = new THREE.WebGLRenderer({
		canvas: canvasRef.value,
		antialias: true,
		alpha: false,
		powerPreference: "high-performance",
	});
	renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
	renderer.setSize(window.innerWidth, window.innerHeight);
	renderer.toneMapping = THREE.ACESFilmicToneMapping;
	renderer.toneMappingExposure = 1.18;
	renderer.shadowMap.enabled = true;
	renderer.shadowMap.type = THREE.PCFSoftShadowMap;

	// --- Scene ---
	scene = new THREE.Scene();
	scene.background = new THREE.Color(0xcce6ff);
	scene.fog = new THREE.FogExp2(0xd8ecff, 0.008);

	// --- Camera ---
	camera = new THREE.PerspectiveCamera(
		40,
		window.innerWidth / window.innerHeight,
		0.1,
		200,
	);
	const baseCamPos = new THREE.Vector3(-17.5, 15.5, 26.5);
	const baseLookAt = new THREE.Vector3(1.5, 1.4, 0.5);
	camera.position.copy(baseCamPos);
	camera.lookAt(baseLookAt);

	// --- Core Lights ---
	const hemiLight = new THREE.HemisphereLight(0xffffff, 0x94a3b8, 1.2);
	scene.add(hemiLight);

	const sunLight = new THREE.DirectionalLight(0xfffdf5, 1.9);
	sunLight.position.set(16, 28, 14);
	sunLight.castShadow = true;
	sunLight.shadow.mapSize.width = 1024;
	sunLight.shadow.mapSize.height = 1024;
	sunLight.shadow.camera.near = 2;
	sunLight.shadow.camera.far = 90;
	const shadowBounds = 28;
	sunLight.shadow.camera.left = -shadowBounds;
	sunLight.shadow.camera.right = shadowBounds;
	sunLight.shadow.camera.top = shadowBounds;
	sunLight.shadow.camera.bottom = -shadowBounds;
	sunLight.shadow.bias = -0.0005;
	scene.add(sunLight);

	// Night / Evening Floodlights (dynamically brightened at night)
	const nightPointLights = [];
	const addNightLight = (color, intensity, distance, x, y, z) => {
		const pl = new THREE.PointLight(color, intensity, distance, 1.4);
		pl.position.set(x, y, z);
		scene.add(pl);
		nightPointLights.push({ light: pl, maxIntensity: intensity });
		return pl;
	};

	addNightLight(0xffedd5, 10.0, 26, 0.5, 7.0, 2.0); // Factory plaza floodlight
	addNightLight(0xfef3c7, 11.0, 28, 8.5, 7.5, 1.5); // Container yard floodlight
	addNightLight(0xe0f2fe, 12.0, 32, 16.5, 8.5, 2.0); // Pier & cargo ship floodlight
	addNightLight(0xfde68a, 8.5, 24, 15.0, 6.5, -6.5); // North quay floodlight
	addNightLight(0xff3b30, 4.5, 18, 0.2, 5.2, -1.8); // AMEC crimson factory glow

	// --- Shared Materials ---
	const matGround = new THREE.MeshStandardMaterial({
		color: 0xdce7f2,
		roughness: 0.9,
		metalness: 0.08,
	});
	const matPad = new THREE.MeshStandardMaterial({
		color: 0xcbd5e1,
		roughness: 0.85,
		metalness: 0.12,
	});
	const matQuay = new THREE.MeshStandardMaterial({
		color: 0x94a3b8,
		roughness: 0.82,
		metalness: 0.15,
	});
	const matRoad = new THREE.MeshStandardMaterial({
		color: 0x475569,
		roughness: 0.9,
		metalness: 0.08,
	});
	const matSteelDark = new THREE.MeshStandardMaterial({
		color: 0x334155,
		roughness: 0.45,
		metalness: 0.6,
	});
	const matSteelMid = new THREE.MeshStandardMaterial({
		color: 0x64748b,
		roughness: 0.42,
		metalness: 0.55,
	});
	const matWall = new THREE.MeshStandardMaterial({
		color: 0xe2e8f0,
		roughness: 0.55,
		metalness: 0.2,
	});
	const matAmecRed = new THREE.MeshStandardMaterial({
		color: 0xe60012,
		emissive: 0x7f000a,
		emissiveIntensity: 0.22,
		roughness: 0.35,
		metalness: 0.25,
	});
	const matCraneYellow = new THREE.MeshStandardMaterial({
		color: 0xf59e0b,
		emissive: 0x451a03,
		emissiveIntensity: 0.12,
		roughness: 0.4,
		metalness: 0.4,
	});
	const matWindowGlow = new THREE.MeshStandardMaterial({
		color: 0xbae6fd,
		emissive: 0x38bdf8,
		emissiveIntensity: 0.5,
		roughness: 0.2,
	});
	const matWarmGlow = new THREE.MeshStandardMaterial({
		color: 0xfef3c7,
		emissive: 0xf59e0b,
		emissiveIntensity: 0.45,
		roughness: 0.2,
	});
	const matLampBulb = new THREE.MeshStandardMaterial({
		color: 0xffffff,
		emissive: 0xfff7ed,
		emissiveIntensity: 0.4,
		roughness: 0.15,
	});
	const matLightCone = new THREE.MeshBasicMaterial({
		color: 0xfef3c7,
		transparent: true,
		opacity: 0.0,
		depthWrite: false,
		side: THREE.DoubleSide,
	});
	const matContainerBlue = new THREE.MeshStandardMaterial({
		color: 0x2563eb,
		roughness: 0.48,
		metalness: 0.28,
	});
	const matContainerTeal = new THREE.MeshStandardMaterial({
		color: 0x0d9488,
		roughness: 0.48,
		metalness: 0.28,
	});
	const matContainerSlate = new THREE.MeshStandardMaterial({
		color: 0x475569,
		roughness: 0.5,
		metalness: 0.32,
	});
	const matBoxCardboard = new THREE.MeshStandardMaterial({
		color: 0xd97706,
		roughness: 0.8,
		metalness: 0.05,
	});
	const matWater = new THREE.MeshStandardMaterial({
		color: 0x1c7ed6,
		emissive: 0x0b4475,
		emissiveIntensity: 0.25,
		roughness: 0.22,
		metalness: 0.35,
		flatShading: true,
	});

	// --- Root World Group ---
	const world = new THREE.Group();
	world.position.set(1.5, 0, 0);
	scene.add(world);

	// 1. Land Ground (Left/Center) + Deep-Water Harbor Basin (Right side x > 12.2)
	const landGround = new THREE.Mesh(
		new THREE.PlaneGeometry(80, 140),
		matGround,
	);
	landGround.rotation.x = -Math.PI / 2;
	landGround.position.set(-27.8, 0, 0);
	landGround.receiveShadow = true;
	world.add(landGround);

	const gridHelper = new THREE.GridHelper(60, 30, 0x64748b, 0x94a3b8);
	gridHelper.position.set(-14, 0.02, 0);
	gridHelper.material.transparent = true;
	gridHelper.material.opacity = 0.22;
	world.add(gridHelper);

	// Animated Harbor Ocean Plane (Right side, x from 12.0 to 92.0)
	const waterGeo = new THREE.PlaneGeometry(80, 140, 28, 36);
	waterGeo.rotateX(-Math.PI / 2);
	const waterBaseY = new Float32Array(waterGeo.attributes.position.count);
	for (let i = 0; i < waterBaseY.length; i++) {
		waterBaseY[i] = waterGeo.attributes.position.getY(i);
	}
	const waterMesh = new THREE.Mesh(waterGeo, matWater);
	waterMesh.position.set(52.0, -0.55, 0);
	waterMesh.receiveShadow = true;
	world.add(waterMesh);

	// 2. Concrete Industrial Pad, Quay Wall & Seaport Pier
	const mainPad = new THREE.Mesh(
		new THREE.BoxGeometry(20.5, 0.3, 18),
		matPad,
	);
	mainPad.position.set(2.0, 0.15, -0.5);
	mainPad.receiveShadow = true;
	world.add(mainPad);

	// Concrete Quay Wall along the water edge (x = 12.25)
	const quayWall = new THREE.Mesh(
		new THREE.BoxGeometry(1.4, 1.5, 24),
		matQuay,
	);
	quayWall.position.set(12.25, -0.25, -0.5);
	quayWall.receiveShadow = true;
	quayWall.castShadow = true;
	world.add(quayWall);

	// Yellow safety strip along the pier edge
	const pierEdgeStripe = new THREE.Mesh(
		new THREE.BoxGeometry(0.22, 0.06, 24),
		matCraneYellow,
	);
	pierEdgeStripe.position.set(12.82, 0.52, -0.5);
	world.add(pierEdgeStripe);

	// Mooring bollards & black rubber dock fenders along quay
	const matFender = new THREE.MeshStandardMaterial({
		color: 0x1e293b,
		roughness: 0.9,
	});
	for (let z = -10.5; z <= 9.5; z += 3.3) {
		const bollard = new THREE.Mesh(
			new THREE.CylinderGeometry(0.14, 0.18, 0.34, 10),
			matCraneYellow,
		);
		bollard.position.set(12.6, 0.68, z);
		world.add(bollard);

		const fender = new THREE.Mesh(
			new THREE.BoxGeometry(0.18, 0.55, 0.9),
			matFender,
		);
		fender.position.set(13.02, -0.05, z);
		world.add(fender);
	}

	// Perimeter Roadway around factory & container yard
	const roadOuter = new THREE.Mesh(
		new THREE.BoxGeometry(21.5, 0.1, 22),
		matRoad,
	);
	roadOuter.position.set(1.2, 0.05, -0.5);
	roadOuter.receiveShadow = true;
	world.add(roadOuter);

	const laneMat = new THREE.MeshBasicMaterial({
		color: 0xf8fafc,
		transparent: true,
		opacity: 0.6,
	});
	for (let x = -8.0; x <= 10.5; x += 2.2) {
		const dashFront = new THREE.Mesh(
			new THREE.PlaneGeometry(1.05, 0.12),
			laneMat,
		);
		dashFront.rotation.x = -Math.PI / 2;
		dashFront.position.set(x, 0.115, 9.4);
		world.add(dashFront);

		const dashBack = dashFront.clone();
		dashBack.position.set(x, 0.115, -10.4);
		world.add(dashBack);
	}

	// 3. Industrial Floodlight Towers (Light up at night / evening!)
	function createFloodlightPole(x, z, rotY = 0) {
		const poleGroup = new THREE.Group();
		poleGroup.position.set(x, 0.3, z);
		poleGroup.rotation.y = rotY;

		const mast = new THREE.Mesh(
			new THREE.CylinderGeometry(0.08, 0.12, 6.2, 8),
			matSteelMid,
		);
		mast.position.y = 3.1;
		mast.castShadow = true;
		poleGroup.add(mast);

		const head = new THREE.Mesh(
			new THREE.BoxGeometry(0.75, 0.22, 0.32),
			matSteelDark,
		);
		head.position.set(0.22, 6.15, 0);
		poleGroup.add(head);

		const lamp = new THREE.Mesh(
			new THREE.BoxGeometry(0.65, 0.12, 0.24),
			matLampBulb,
		);
		lamp.position.set(0.24, 6.02, 0);
		poleGroup.add(lamp);

		// Soft volumetric light cone visible at night
		const cone = new THREE.Mesh(
			new THREE.ConeGeometry(2.6, 5.8, 16, 1, true),
			matLightCone,
		);
		cone.position.set(0.45, 3.1, 0);
		poleGroup.add(cone);

		world.add(poleGroup);
	}

	createFloodlightPole(-6.5, 7.6, -Math.PI / 4);
	createFloodlightPole(3.0, 7.6, -Math.PI / 2);
	createFloodlightPole(11.4, 7.8, Math.PI / 4);
	createFloodlightPole(11.4, -7.8, -Math.PI / 4);
	createFloodlightPole(3.0, -8.2, Math.PI / 2);

	// 4. AMEC Smart Factory Complex (Saw-tooth Roof + Skylights + Silos)
	const factoryGroup = new THREE.Group();
	factoryGroup.position.set(-2.4, 0.3, -1.8);
	world.add(factoryGroup);

	const hallBody = new THREE.Mesh(new THREE.BoxGeometry(7.2, 3.2, 6.2), matWall);
	hallBody.position.set(0, 1.6, 0);
	hallBody.castShadow = true;
	hallBody.receiveShadow = true;
	factoryGroup.add(hallBody);

	// Saw-tooth industrial roof
	const ridgeShape = new THREE.Shape();
	ridgeShape.moveTo(0, 0);
	ridgeShape.lineTo(2.4, 0);
	ridgeShape.lineTo(2.4, 1.15);
	ridgeShape.closePath();

	const ridgeGeo = new THREE.ExtrudeGeometry(ridgeShape, {
		depth: 6.2,
		bevelEnabled: false,
	});
	for (let i = 0; i < 3; i++) {
		const ridge = new THREE.Mesh(ridgeGeo, matSteelDark);
		ridge.position.set(-3.6 + i * 2.4, 3.2, -3.1);
		ridge.castShadow = true;
		factoryGroup.add(ridge);

		const skylight = new THREE.Mesh(
			new THREE.BoxGeometry(0.08, 0.72, 5.6),
			matWindowGlow,
		);
		skylight.position.set(-1.2 + i * 2.4 + 0.02, 3.62, 0);
		factoryGroup.add(skylight);
	}

	// Corporate crimson fascia band
	const redStripe = new THREE.Mesh(
		new THREE.BoxGeometry(7.32, 0.28, 6.32),
		matAmecRed,
	);
	redStripe.position.set(0, 2.95, 0);
	factoryGroup.add(redStripe);

	// Factory front windows
	for (let i = 0; i < 4; i++) {
		const win = new THREE.Mesh(
			new THREE.BoxGeometry(1.15, 0.78, 0.1),
			i % 2 === 0 ? matWindowGlow : matWarmGlow,
		);
		win.position.set(-2.25 + i * 1.5, 1.75, 3.12);
		factoryGroup.add(win);
	}

	// Receiving bay door
	const dockDoor = new THREE.Mesh(
		new THREE.BoxGeometry(1.9, 1.5, 0.14),
		matSteelDark,
	);
	dockDoor.position.set(3.62, 0.75, 0.6);
	dockDoor.rotation.y = Math.PI / 2;
	factoryGroup.add(dockDoor);

	// Twin exhaust stacks + aviation warning beacons
	const beaconLights = [];
	[
		[-2.4, -2.0, 5.8],
		[-1.1, -2.0, 5.0],
	].forEach(([sx, sz, sh]) => {
		const stack = new THREE.Mesh(
			new THREE.CylinderGeometry(0.32, 0.42, sh, 16),
			matSteelMid,
		);
		stack.position.set(sx, sh / 2, sz);
		stack.castShadow = true;
		factoryGroup.add(stack);

		const ringBand = new THREE.Mesh(
			new THREE.CylinderGeometry(0.36, 0.36, 0.25, 16),
			matAmecRed,
		);
		ringBand.position.set(sx, sh - 0.65, sz);
		factoryGroup.add(ringBand);

		const beaconMat = new THREE.MeshBasicMaterial({ color: 0xff2a2a });
		const beacon = new THREE.Mesh(
			new THREE.SphereGeometry(0.14, 10, 10),
			beaconMat,
		);
		beacon.position.set(sx, sh + 0.12, sz);
		factoryGroup.add(beacon);
		beaconLights.push(beaconMat);
	});

	// Subtle steam puffs
	const steamParticles = [];
	const steamGeo = new THREE.SphereGeometry(0.22, 8, 8);
	for (let i = 0; i < 10; i++) {
		const sMat = new THREE.MeshBasicMaterial({
			color: 0xe2e8f0,
			transparent: true,
			opacity: 0.28,
		});
		const puff = new THREE.Mesh(steamGeo, sMat);
		factoryGroup.add(puff);
		steamParticles.push({
			mesh: puff,
			mat: sMat,
			offset: i / 10,
			driftX: (Math.random() - 0.3) * 0.6,
			driftZ: (Math.random() - 0.5) * 0.5,
		});
	}

	// 5. Automated Conveyor Belt + RFID Scanner Arch
	const conveyorGroup = new THREE.Group();
	conveyorGroup.position.set(2.8, 0.3, -1.2);
	world.add(conveyorGroup);

	const beltBase = new THREE.Mesh(
		new THREE.BoxGeometry(3.4, 0.36, 1.05),
		matSteelDark,
	);
	beltBase.position.set(0, 0.35, 0);
	beltBase.castShadow = true;
	conveyorGroup.add(beltBase);

	const railMat = new THREE.MeshBasicMaterial({ color: 0x0ea5e9 });
	[-0.5, 0.5].forEach((rz) => {
		const rail = new THREE.Mesh(new THREE.BoxGeometry(3.4, 0.06, 0.05), railMat);
		rail.position.set(0, 0.56, rz);
		conveyorGroup.add(rail);
	});

	// Scanner Arch
	const archLeft = new THREE.Mesh(
		new THREE.BoxGeometry(0.18, 1.35, 0.14),
		matSteelMid,
	);
	archLeft.position.set(0, 0.85, -0.58);
	conveyorGroup.add(archLeft);
	const archRight = archLeft.clone();
	archRight.position.z = 0.58;
	conveyorGroup.add(archRight);
	const archTop = new THREE.Mesh(
		new THREE.BoxGeometry(0.24, 0.18, 1.3),
		matSteelMid,
	);
	archTop.position.set(0, 1.5, 0);
	conveyorGroup.add(archTop);

	const scanBeamMat = new THREE.MeshBasicMaterial({
		color: 0x22d3ee,
		transparent: true,
		opacity: 0.45,
		side: THREE.DoubleSide,
	});
	const scanBeam = new THREE.Mesh(
		new THREE.PlaneGeometry(0.06, 0.95),
		scanBeamMat,
	);
	scanBeam.rotation.y = Math.PI / 2;
	scanBeam.position.set(0, 0.95, 0);
	conveyorGroup.add(scanBeam);

	const conveyorBoxes = [];
	for (let i = 0; i < 4; i++) {
		const box = new THREE.Mesh(
			new THREE.BoxGeometry(0.48, 0.42, 0.5),
			i % 2 === 0 ? matBoxCardboard : matContainerBlue,
		);
		box.castShadow = true;
		conveyorGroup.add(box);
		conveyorBoxes.push({ mesh: box, t: i * 0.25 });
	}

	// 6. Container Yard + Ship-to-Shore (STS) Seaport Gantry Crane
	function createContainer(mat, scale = 1) {
		const g = new THREE.Group();
		const body = new THREE.Mesh(
			new THREE.BoxGeometry(1.05 * scale, 0.92 * scale, 2.2 * scale),
			mat,
		);
		body.castShadow = true;
		body.receiveShadow = true;
		g.add(body);

		const edge = new THREE.LineSegments(
			new THREE.EdgesGeometry(
				new THREE.BoxGeometry(1.06 * scale, 0.93 * scale, 2.21 * scale),
			),
			new THREE.LineBasicMaterial({
				color: 0x0f172a,
				transparent: true,
				opacity: 0.4,
			}),
		);
		g.add(edge);
		return g;
	}

	const yardGroup = new THREE.Group();
	yardGroup.position.set(7.4, 0.3, 0.2);
	world.add(yardGroup);

	const yardStacks = [
		[-1.3, 0.46, -2.5, matAmecRed],
		[-1.3, 1.38, -2.5, matContainerBlue],
		[0.0, 0.46, -2.5, matContainerTeal],
		[1.3, 0.46, -2.5, matContainerBlue],
		[1.3, 1.38, -2.5, matAmecRed],
		[-1.3, 0.46, 0.8, matContainerSlate],
		[0.0, 0.46, 0.8, matAmecRed],
		[0.0, 1.38, 0.8, matContainerTeal],
		[1.3, 0.46, 0.8, matContainerBlue],
		[-1.3, 0.46, 3.9, matContainerTeal],
		[0.0, 0.46, 3.9, matContainerSlate],
	];
	yardStacks.forEach(([cx, cy, cz, mat]) => {
		const c = createContainer(mat);
		c.position.set(cx, cy, cz);
		yardGroup.add(c);
	});

	// Ship-to-Shore (STS) Port Crane straddling the quay & reaching over the Cargo Ship!
	const stsCrane = new THREE.Group();
	stsCrane.position.set(11.6, 0.3, 1.0);
	world.add(stsCrane);

	const stsHeight = 6.8;
	const legGeo = new THREE.BoxGeometry(0.3, stsHeight, 0.3);
	[
		[-1.3, -2.2],
		[-1.3, 2.2],
		[1.1, -2.2],
		[1.1, 2.2],
	].forEach(([lx, lz]) => {
		const leg = new THREE.Mesh(legGeo, matAmecRed);
		leg.position.set(lx, stsHeight / 2, lz);
		leg.castShadow = true;
		stsCrane.add(leg);
	});

	// Cross portal beams
	[-2.2, 2.2].forEach((bz) => {
		const cross = new THREE.Mesh(
			new THREE.BoxGeometry(2.7, 0.34, 0.32),
			matAmecRed,
		);
		cross.position.set(-0.1, stsHeight * 0.55, bz);
		stsCrane.add(cross);
	});

	// Horizontal boom reaching out over the docked cargo ship (x from -2.2 to +7.8)
	const boom = new THREE.Mesh(
		new THREE.BoxGeometry(10.2, 0.42, 0.85),
		matCraneYellow,
	);
	boom.position.set(2.8, stsHeight, 0);
	boom.castShadow = true;
	stsCrane.add(boom);

	// Top A-frame apex & stay cables
	const apex = new THREE.Mesh(
		new THREE.BoxGeometry(0.45, 2.6, 4.6),
		matAmecRed,
	);
	apex.position.set(0.6, stsHeight + 1.3, 0);
	stsCrane.add(apex);

	const cableMat = new THREE.LineBasicMaterial({ color: 0x334155 });
	[
		[new THREE.Vector3(0.6, stsHeight + 2.5, -1.6), new THREE.Vector3(7.4, stsHeight + 0.2, -0.35)],
		[new THREE.Vector3(0.6, stsHeight + 2.5, 1.6), new THREE.Vector3(7.4, stsHeight + 0.2, 0.35)],
		[new THREE.Vector3(0.6, stsHeight + 2.5, -1.6), new THREE.Vector3(-2.1, stsHeight + 0.2, -0.35)],
		[new THREE.Vector3(0.6, stsHeight + 2.5, 1.6), new THREE.Vector3(-2.1, stsHeight + 0.2, 0.35)],
	].forEach(([p1, p2]) => {
		const g = new THREE.BufferGeometry().setFromPoints([p1, p2]);
		stsCrane.add(new THREE.Line(g, cableMat));
	});

	// STS Trolley + Hoist + Lifted Container transferring between Ship and Quay
	const stsTrolley = new THREE.Group();
	stsTrolley.position.set(2.5, stsHeight - 0.15, 0);
	stsCrane.add(stsTrolley);

	const trolleyCab = new THREE.Mesh(
		new THREE.BoxGeometry(0.95, 0.42, 0.95),
		matSteelDark,
	);
	stsTrolley.add(trolleyCab);

	const stsCable = new THREE.Mesh(
		new THREE.BoxGeometry(0.08, 1.0, 0.08),
		matSteelMid,
	);
	stsTrolley.add(stsCable);

	const stsSpreader = new THREE.Mesh(
		new THREE.BoxGeometry(1.12, 0.16, 2.24),
		matCraneYellow,
	);
	stsTrolley.add(stsSpreader);

	const stsContainer = createContainer(matContainerBlue);
	stsTrolley.add(stsContainer);

	// 7. Docked Container Cargo Ship (เรือบรรทุกตู้คอนเทนเนอร์เทียบท่าเรือ)
	const cargoShip = new THREE.Group();
	cargoShip.position.set(16.6, -0.35, 0.6);
	world.add(cargoShip);

	const matHullNavy = new THREE.MeshStandardMaterial({
		color: 0x1e3a5f,
		roughness: 0.5,
		metalness: 0.35,
	});
	const matHullRed = new THREE.MeshStandardMaterial({
		color: 0xb91c1c,
		roughness: 0.55,
		metalness: 0.25,
	});
	const matDeck = new THREE.MeshStandardMaterial({
		color: 0x334155,
		roughness: 0.75,
	});

	// Lower red waterline hull
	const hullBottom = new THREE.Mesh(
		new THREE.BoxGeometry(4.4, 0.75, 13.6),
		matHullRed,
	);
	hullBottom.position.set(0, 0.15, 0);
	cargoShip.add(hullBottom);

	// Upper navy hull
	const hullUpper = new THREE.Mesh(
		new THREE.BoxGeometry(4.55, 1.15, 13.8),
		matHullNavy,
	);
	hullUpper.position.set(0, 1.05, 0);
	hullUpper.castShadow = true;
	hullUpper.receiveShadow = true;
	cargoShip.add(hullUpper);

	// Pointed bow wedge (front, -Z)
	const bowGeo = new THREE.ConeGeometry(3.2, 3.6, 4);
	bowGeo.rotateY(Math.PI / 4);
	bowGeo.rotateX(-Math.PI / 2);
	const bow = new THREE.Mesh(bowGeo, matHullNavy);
	bow.scale.set(0.71, 0.42, 1.0);
	bow.position.set(0, 1.0, -8.6);
	bow.castShadow = true;
	cargoShip.add(bow);

	// Main deck floor
	const deck = new THREE.Mesh(
		new THREE.BoxGeometry(4.2, 0.12, 13.2),
		matDeck,
	);
	deck.position.set(0, 1.66, 0);
	deck.receiveShadow = true;
	cargoShip.add(deck);

	// White Bridge / Superstructure at the stern (+Z)
	const bridgeBase = new THREE.Mesh(
		new THREE.BoxGeometry(3.6, 2.4, 2.5),
		matWall,
	);
	bridgeBase.position.set(0, 2.9, 4.8);
	bridgeBase.castShadow = true;
	cargoShip.add(bridgeBase);

	// Bridge wings & glowing command deck windows
	const bridgeWing = new THREE.Mesh(
		new THREE.BoxGeometry(4.8, 0.55, 1.15),
		matWall,
	);
	bridgeWing.position.set(0, 4.1, 4.5);
	bridgeWing.castShadow = true;
	cargoShip.add(bridgeWing);

	const bridgeWindows = new THREE.Mesh(
		new THREE.BoxGeometry(4.4, 0.28, 1.2),
		matWarmGlow,
	);
	bridgeWindows.position.set(0, 4.15, 4.48);
	cargoShip.add(bridgeWindows);

	// Ship funnel (smokestack) with AMEC red band
	const funnel = new THREE.Mesh(
		new THREE.BoxGeometry(0.9, 1.4, 1.1),
		matSteelDark,
	);
	funnel.position.set(0, 4.6, 5.5);
	cargoShip.add(funnel);
	const funnelBand = new THREE.Mesh(
		new THREE.BoxGeometry(0.94, 0.38, 1.14),
		matAmecRed,
	);
	funnelBand.position.set(0, 4.7, 5.5);
	cargoShip.add(funnelBand);

	// Radar mast + rotating radar bar + navigation lights
	const radarMast = new THREE.Mesh(
		new THREE.CylinderGeometry(0.06, 0.09, 1.6, 8),
		matSteelMid,
	);
	radarMast.position.set(0, 5.1, 4.4);
	cargoShip.add(radarMast);

	const shipRadarBar = new THREE.Mesh(
		new THREE.BoxGeometry(1.0, 0.1, 0.14),
		matLampBulb,
	);
	shipRadarBar.position.set(0, 5.75, 4.4);
	cargoShip.add(shipRadarBar);

	// Port (red) & Starboard (green) navigation lights
	const portNavLight = new THREE.Mesh(
		new THREE.SphereGeometry(0.11, 8, 8),
		new THREE.MeshBasicMaterial({ color: 0xff3b30 }),
	);
	portNavLight.position.set(-2.35, 4.3, 4.45);
	cargoShip.add(portNavLight);

	const stbdNavLight = new THREE.Mesh(
		new THREE.SphereGeometry(0.11, 8, 8),
		new THREE.MeshBasicMaterial({ color: 0x22c55e }),
	);
	stbdNavLight.position.set(2.35, 4.3, 4.45);
	cargoShip.add(stbdNavLight);

	// Containers stacked on the cargo ship deck
	const shipContainerMats = [
		matAmecRed,
		matContainerBlue,
		matContainerTeal,
		matCraneYellow,
		matContainerSlate,
	];
	for (let row = 0; row < 4; row++) {
		const cz = -4.8 + row * 2.45;
		for (let col = -1; col <= 1; col++) {
			const cx = col * 1.16;
			const stackHeight = row === 2 && col === 0 ? 1 : 2; // leave slot for crane
			for (let lvl = 0; lvl < stackHeight; lvl++) {
				const mat =
					shipContainerMats[(row * 3 + col + lvl + 5) % shipContainerMats.length];
				const c = createContainer(mat, 0.96);
				c.position.set(cx, 2.15 + lvl * 0.9, cz);
				cargoShip.add(c);
			}
		}
	}

	// 8. Sailing Feeder Vessel in Outer Harbor Channel
	const feederShip = new THREE.Group();
	const feederHull = new THREE.Mesh(
		new THREE.BoxGeometry(2.1, 0.75, 6.2),
		matHullNavy,
	);
	feederHull.position.y = 0.4;
	feederHull.castShadow = true;
	feederShip.add(feederHull);

	const feederCabin = new THREE.Mesh(
		new THREE.BoxGeometry(1.7, 1.2, 1.4),
		matWall,
	);
	feederCabin.position.set(0, 1.35, 2.0);
	feederShip.add(feederCabin);

	const feederWin = new THREE.Mesh(
		new THREE.BoxGeometry(1.5, 0.25, 1.44),
		matWarmGlow,
	);
	feederWin.position.set(0, 1.65, 2.0);
	feederShip.add(feederWin);

	[
		[-0.48, 1.08, -1.6, matAmecRed],
		[0.48, 1.08, -1.6, matContainerBlue],
		[-0.48, 1.08, 0.3, matContainerTeal],
		[0.48, 1.08, 0.3, matCraneYellow],
	].forEach(([fx, fy, fz, fm]) => {
		const fc = createContainer(fm, 0.75);
		fc.position.set(fx, fy, fz);
		feederShip.add(fc);
	});

	// Soft white wake trail behind feeder ship
	const wakeMesh = new THREE.Mesh(
		new THREE.PlaneGeometry(1.8, 5.5),
		new THREE.MeshBasicMaterial({
			color: 0xffffff,
			transparent: true,
			opacity: 0.25,
			side: THREE.DoubleSide,
		}),
	);
	wakeMesh.rotation.x = -Math.PI / 2;
	wakeMesh.position.set(0, 0.08, 5.6);
	feederShip.add(wakeMesh);

	feederShip.position.set(27.5, -0.45, 24);
	world.add(feederShip);

	// 9. Animated Freight Trucks driving along the Factory & Port Road Loop
	function createTruck(trailerMat) {
		const truck = new THREE.Group();

		const trailer = new THREE.Mesh(
			new THREE.BoxGeometry(2.3, 1.05, 0.96),
			trailerMat,
		);
		trailer.position.set(-0.45, 0.72, 0);
		trailer.castShadow = true;
		truck.add(trailer);

		const cab = new THREE.Mesh(
			new THREE.BoxGeometry(0.82, 0.88, 0.92),
			matWall,
		);
		cab.position.set(1.16, 0.62, 0);
		cab.castShadow = true;
		truck.add(cab);

		const windshield = new THREE.Mesh(
			new THREE.BoxGeometry(0.06, 0.34, 0.76),
			matWindowGlow,
		);
		windshield.position.set(1.57, 0.74, 0);
		truck.add(windshield);

		const hlMat = new THREE.MeshBasicMaterial({ color: 0xfef08a });
		[-0.3, 0.3].forEach((hz) => {
			const hl = new THREE.Mesh(new THREE.BoxGeometry(0.06, 0.12, 0.14), hlMat);
			hl.position.set(1.58, 0.38, hz);
			truck.add(hl);
		});

		const wheelGeo = new THREE.CylinderGeometry(0.22, 0.22, 0.16, 12);
		wheelGeo.rotateX(Math.PI / 2);
		const wheelMat = new THREE.MeshStandardMaterial({
			color: 0x0f172a,
			roughness: 0.9,
		});
		[
			[-1.2, -0.48],
			[-1.2, 0.48],
			[-0.5, -0.48],
			[-0.5, 0.48],
			[1.15, -0.48],
			[1.15, 0.48],
		].forEach(([wx, wz]) => {
			const w = new THREE.Mesh(wheelGeo, wheelMat);
			w.position.set(wx, 0.22, wz);
			truck.add(w);
		});

		return truck;
	}

	const roadCurve = new THREE.CatmullRomCurve3(
		[
			new THREE.Vector3(-8.4, 0.1, 9.4),
			new THREE.Vector3(10.6, 0.1, 9.4),
			new THREE.Vector3(11.1, 0.1, 8.4),
			new THREE.Vector3(11.1, 0.1, -9.4),
			new THREE.Vector3(10.4, 0.1, -10.4),
			new THREE.Vector3(-8.4, 0.1, -10.4),
			new THREE.Vector3(-9.1, 0.1, -9.2),
			new THREE.Vector3(-9.1, 0.1, 8.4),
		],
		true,
		"catmullrom",
		0.18,
	);

	const trucks = [
		{ mesh: createTruck(matAmecRed), t: 0.05, speed: 0.036 },
		{ mesh: createTruck(matContainerBlue), t: 0.4, speed: 0.032 },
		{ mesh: createTruck(matContainerTeal), t: 0.72, speed: 0.038 },
	];
	trucks.forEach((tr) => world.add(tr.mesh));

	// 10. Procurement & Supply-Chain Network Arcs (Vendor -> Ship/Port -> Factory)
	const hubAnchor = new THREE.Vector3(-2.4, 3.8, -1.8);
	const networkEndpoints = [
		new THREE.Vector3(16.6, 3.6, 0.6), // Docked Cargo Ship
		new THREE.Vector3(-13.5, 1.0, -11.5), // Domestic Supplier North
		new THREE.Vector3(7.5, 1.5, -13.5), // Overseas Hub
		new THREE.Vector3(-11.0, 1.0, 12.5), // Regional Distribution
	];

	const arcPulses = [];
	networkEndpoints.forEach((endPos, idx) => {
		if (idx > 0) {
			const pillar = new THREE.Mesh(
				new THREE.CylinderGeometry(0.85, 1.05, 0.8, 6),
				matSteelDark,
			);
			pillar.position.set(endPos.x, 0.4, endPos.z);
			world.add(pillar);

			const cap = new THREE.Mesh(
				new THREE.CylinderGeometry(0.55, 0.55, 0.12, 6),
				idx % 2 === 0 ? matWindowGlow : matAmecRed,
			);
			cap.position.set(endPos.x, 0.86, endPos.z);
			world.add(cap);
		}

		const mid = new THREE.Vector3(
			(endPos.x + hubAnchor.x) * 0.5,
			8.5 + (idx % 2) * 1.8,
			(endPos.z + hubAnchor.z) * 0.5,
		);
		const curve = new THREE.QuadraticBezierCurve3(endPos, mid, hubAnchor);
		const isRedArc = idx % 2 === 0;
		const lineGeo = new THREE.BufferGeometry().setFromPoints(
			curve.getPoints(44),
		);
		const lineMat = new THREE.LineBasicMaterial({
			color: isRedArc ? 0xe60012 : 0x0284c7,
			transparent: true,
			opacity: 0.45,
		});
		world.add(new THREE.Line(lineGeo, lineMat));

		for (let p = 0; p < 2; p++) {
			const pulse = new THREE.Mesh(
				new THREE.SphereGeometry(0.2, 10, 10),
				new THREE.MeshBasicMaterial({
					color: isRedArc ? 0xff4d4f : 0x38bdf8,
				}),
			);
			world.add(pulse);
			arcPulses.push({
				mesh: pulse,
				curve,
				t: (idx * 0.25 + p * 0.5) % 1,
				speed: 0.14 + idx * 0.015,
				reverse: p === 1,
			});
		}
	});

	// --- Apply Lighting & Theme Environment ---
	applyEnvironment = () => {
		if (!scene || !renderer) return;
		const cfg = getEnvironmentConfig(isDark.value, new Date());

		scene.background.setHex(cfg.skyHex);
		scene.fog.color.setHex(cfg.fogHex);
		scene.fog.density = cfg.fogDensity;
		renderer.toneMappingExposure = cfg.exposure;

		hemiLight.color.setHex(cfg.hemiSky);
		hemiLight.groundColor.setHex(cfg.hemiGround);
		hemiLight.intensity = cfg.hemiIntensity;

		sunLight.color.setHex(cfg.sunColor);
		sunLight.intensity = cfg.sunIntensity;
		sunLight.position.set(...cfg.sunPos);

		matWater.color.setHex(cfg.waterColor);
		matWater.emissive.setHex(cfg.waterEmissive);
		matWater.emissiveIntensity = 0.2 + cfg.nightFactor * 0.35;

		matGround.color.setHex(cfg.groundColor);
		matPad.color.setHex(cfg.padColor);
		matRoad.color.setHex(cfg.roadColor);

		// Toggle / scale industrial & port lights based on nightFactor
		nightPointLights.forEach(({ light, maxIntensity }) => {
			light.intensity = cfg.lightsOn ? maxIntensity * cfg.nightFactor : 0;
		});

		matWindowGlow.emissiveIntensity = 0.35 + cfg.nightFactor * 1.35;
		matWarmGlow.emissiveIntensity = 0.3 + cfg.nightFactor * 1.45;
		matLampBulb.emissiveIntensity = 0.25 + cfg.nightFactor * 2.2;
		matLightCone.opacity = cfg.lightsOn ? 0.09 * cfg.nightFactor : 0.0;
		matAmecRed.emissiveIntensity = 0.18 + cfg.nightFactor * 0.45;
	};

	applyEnvironment();
	// Re-evaluate real-time sun & lighting every 60s in light mode
	lightingIntervalId = setInterval(() => {
		if (!isDark.value) applyEnvironment();
	}, 60 * 1000);

	// --- Mouse Parallax & Resize ---
	const pointer = { x: 0, y: 0 };
	const smoothPointer = { x: 0, y: 0 };

	handlePointerMove = (e) => {
		pointer.x = (e.clientX / window.innerWidth) * 2 - 1;
		pointer.y = (e.clientY / window.innerHeight) * 2 - 1;
	};
	window.addEventListener("pointermove", handlePointerMove, { passive: true });

	handleResize = () => {
		if (!renderer || !camera) return;
		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();
		renderer.setSize(window.innerWidth, window.innerHeight);
	};
	window.addEventListener("resize", handleResize);

	// --- Animation Loop ---
	const clock = new THREE.Clock();
	const tmpPos = new THREE.Vector3();
	const tmpNext = new THREE.Vector3();
	const waterPosAttr = waterGeo.attributes.position;

	function animate() {
		animationFrameId = requestAnimationFrame(animate);
		const delta = Math.min(clock.getDelta(), 0.05);
		const elapsed = clock.getElapsedTime();
		const motionScale = reducedMotion ? 0.15 : 1.0;

		// Smooth camera parallax
		smoothPointer.x += (pointer.x - smoothPointer.x) * 0.04;
		smoothPointer.y += (pointer.y - smoothPointer.y) * 0.04;

		camera.position.x =
			baseCamPos.x +
			smoothPointer.x * 2.4 +
			Math.sin(elapsed * 0.16 * motionScale) * 0.85;
		camera.position.y =
			baseCamPos.y -
			smoothPointer.y * 1.15 +
			Math.cos(elapsed * 0.2 * motionScale) * 0.35;
		camera.position.z =
			baseCamPos.z + Math.cos(elapsed * 0.14 * motionScale) * 0.9;
		camera.lookAt(baseLookAt);

		// 1. Subtle animated harbor waves
		for (let i = 0; i < waterPosAttr.count; i++) {
			const vx = waterPosAttr.getX(i);
			const vz = waterPosAttr.getZ(i);
			const wave =
				Math.sin(vx * 0.28 + elapsed * 1.4 * motionScale) * 0.12 +
				Math.cos(vz * 0.22 + elapsed * 1.1 * motionScale) * 0.1;
			waterPosAttr.setY(i, waterBaseY[i] + wave);
		}
		waterPosAttr.needsUpdate = true;

		// 2. Docked Cargo Ship gentle bobbing & rotating radar
		cargoShip.position.y =
			-0.35 + Math.sin(elapsed * 1.1 * motionScale) * 0.09;
		cargoShip.rotation.z = Math.sin(elapsed * 0.8 * motionScale) * 0.018;
		shipRadarBar.rotation.y = elapsed * 2.2 * motionScale;

		// 3. Feeder Vessel cruising across background harbor channel
		feederShip.position.z -= delta * 2.2 * motionScale;
		if (feederShip.position.z < -34) {
			feederShip.position.z = 34;
		}
		feederShip.position.y =
			-0.42 + Math.sin(elapsed * 1.6 * motionScale) * 0.07;

		// 4. Ship-to-Shore Crane loading cycle (Pier <-> Cargo Ship)
		const cranePhase = elapsed * 0.45 * motionScale;
		const trolleyX = 2.4 + Math.sin(cranePhase) * 2.7; // moves between pier and ship deck
		const hoistDrop = 1.6 + (Math.cos(cranePhase * 2.0) * 0.5 + 0.5) * 2.1;

		stsTrolley.position.x = trolleyX;
		stsCable.scale.y = hoistDrop;
		stsCable.position.y = -0.25 - hoistDrop / 2;
		stsSpreader.position.y = -0.25 - hoistDrop;
		stsContainer.position.y = -0.25 - hoistDrop - 0.54;

		// 5. Trucks driving along perimeter road
		trucks.forEach((tr) => {
			tr.t = (tr.t + delta * tr.speed * motionScale) % 1;
			roadCurve.getPointAt(tr.t, tmpPos);
			roadCurve.getPointAt((tr.t + 0.008) % 1, tmpNext);
			tr.mesh.position.copy(tmpPos);
			tr.mesh.rotation.y = Math.atan2(
				tmpPos.z - tmpNext.z,
				tmpNext.x - tmpPos.x,
			);
		});

		// 6. Conveyor boxes + RFID scanner pulse
		let boxUnderScanner = false;
		conveyorBoxes.forEach((b) => {
			b.t = (b.t + delta * 0.22 * motionScale) % 1;
			const x = 1.55 - b.t * 3.1;
			b.mesh.position.set(x, 0.74, 0);
			if (Math.abs(x) < 0.32) boxUnderScanner = true;
		});
		scanBeamMat.opacity = boxUnderScanner
			? 0.88
			: 0.22 + Math.sin(elapsed * 5) * 0.1;

		// 7. Supply-chain data pulses on network arcs
		arcPulses.forEach((p) => {
			p.t = (p.t + delta * p.speed * motionScale) % 1;
			const u = p.reverse ? 1 - p.t : p.t;
			p.curve.getPoint(u, tmpPos);
			p.mesh.position.copy(tmpPos);
		});

		// 8. Aviation beacons & rising steam
		const blink = Math.sin(elapsed * 4.5) > 0.2 ? 1 : 0.3;
		beaconLights.forEach((bMat) => {
			bMat.color.setRGB(blink, 0.12 * blink, 0.12 * blink);
		});

		steamParticles.forEach((sp) => {
			const p = (elapsed * 0.22 * motionScale + sp.offset) % 1;
			sp.mesh.position.set(
				-2.4 + p * sp.driftX * 2.4,
				5.95 + p * 3.0,
				-2.0 + p * sp.driftZ * 2.4,
			);
			const s = 0.55 + p * 1.8;
			sp.mesh.scale.set(s, s, s);
			sp.mat.opacity = Math.sin(p * Math.PI) * 0.25;
		});

		renderer.render(scene, camera);
	}

	animate();
});

watch(isDark, () => {
	if (applyEnvironment) applyEnvironment();
});

onBeforeUnmount(() => {
	if (animationFrameId) cancelAnimationFrame(animationFrameId);
	if (lightingIntervalId) clearInterval(lightingIntervalId);
	if (handleResize) window.removeEventListener("resize", handleResize);
	if (handlePointerMove) {
		window.removeEventListener("pointermove", handlePointerMove);
	}

	if (scene) {
		scene.traverse((obj) => {
			if (obj.geometry) obj.geometry.dispose();
			if (obj.material) {
				if (Array.isArray(obj.material)) {
					obj.material.forEach((m) => m.dispose());
				} else {
					obj.material.dispose();
				}
			}
		});
	}

	if (renderer) {
		renderer.dispose();
		renderer = null;
	}
	scene = null;
	camera = null;
});
</script>

<style scoped>
.procurement-scene-container {
	position: fixed;
	inset: 0;
	width: 100vw;
	height: 100vh;
	overflow: hidden;
	background: #cce6ff;
	z-index: -1;
	pointer-events: none;
	transition: background-color 0.4s ease;
}

.procurement-scene-container.is-dark-scene {
	background: #0f1f38;
}

.procurement-scene-canvas {
	display: block;
	width: 100%;
	height: 100%;
}

/* Light mode: soft bright frost gradient on the left so dark Hero text is crisp */
.procurement-scene-vignette {
	position: absolute;
	inset: 0;
	background:
		linear-gradient(
			95deg,
			rgba(248, 250, 252, 0.84) 0%,
			rgba(241, 245, 249, 0.52) 34%,
			rgba(241, 245, 249, 0.06) 62%,
			rgba(241, 245, 249, 0) 100%
		),
		linear-gradient(
			180deg,
			rgba(255, 255, 255, 0.42) 0%,
			rgba(255, 255, 255, 0) 20%
		);
	pointer-events: none;
	transition: background 0.4s ease;
}

/* Dark mode: soft navy gradient on the left so light Hero text is crisp */
.procurement-scene-container.is-dark-scene .procurement-scene-vignette {
	background:
		linear-gradient(
			95deg,
			rgba(15, 31, 56, 0.84) 0%,
			rgba(15, 31, 56, 0.52) 35%,
			rgba(15, 31, 56, 0.12) 64%,
			rgba(15, 31, 56, 0.25) 100%
		),
		linear-gradient(
			180deg,
			rgba(15, 31, 56, 0.48) 0%,
			rgba(15, 31, 56, 0) 22%
		);
}
</style>
