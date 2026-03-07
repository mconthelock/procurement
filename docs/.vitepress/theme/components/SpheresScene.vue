<template>
  <div ref="container" class="ai-model-canvas">
    <canvas id="webgl" ref="webglCanvas"></canvas>

    <div class="main-txt" v-if="!loadingComplete">Loading...</div>
    <div class="hide-text" :class="{ 'is-visible': loadingComplete }">
      <h2>Welcome to 3D Scene</h2>
    </div>

    <div class="mouse-effect" ref="mouseEffect">
      <div class="circle"></div>
      <div class="circle-follow"></div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls';
import gsap from 'gsap';
import * as dat from 'dat.gui';

// --- Data Constants (ตัดมาบางส่วนเพื่อความกระชับ) ---
const radii = [1, 0.6, 0.8, 0.4, 0.9, 0.7, 0.9 /* ... ข้อมูลเดิมของคุณ ... */];
const positions = [{ x: 0, y: 0, z: 0 }, { x: 1.2, y: 0.9, z: -0.5 } /* ... ข้อมูลเดิมของคุณ ... */];

// --- Vue State ---
const webglCanvas = ref(null);
const loadingComplete = ref(false);
const mouseEffect = ref(null);

// --- Three.js Variables ---
let scene, camera, renderer, controls, gui;
let animationFrameId;
const spheres = [];
const forces = new Map();
const mouse = new THREE.Vector2();
const raycaster = new THREE.Raycaster();
const tempVector = new THREE.Vector3();

// Configuration
const initY = -25;
const revolutionRadius = 4;
const revolutionDuration = 2;
const breathingAmplitude = 0.1;
const breathingSpeed = 0.002;

const initScene = () => {
  // 1. Scene & Camera
  scene = new THREE.Scene();
  camera = new THREE.PerspectiveCamera(25, window.innerWidth / window.innerHeight, 0.1, 1000);
  camera.position.z = 24;

  // 2. Renderer
  renderer = new THREE.WebGLRenderer({
    canvas: webglCanvas.value,
    antialias: true,
    alpha: true
  });
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.shadowMap.enabled = true;
  renderer.shadowMap.type = THREE.PCFSoftShadowMap;

  // 3. Controls
  controls = new OrbitControls(camera, renderer.domElement);
  controls.enableDamping = true;

  // 4. Lights
  const ambientLight = new THREE.AmbientLight(0xffffff, 1);
  scene.add(ambientLight);

  const spotLight = new THREE.SpotLight(0xffffff, 0.52);
  spotLight.position.set(14, 24, 30);
  spotLight.castShadow = true;
  scene.add(spotLight);

  // 5. Objects
  const material = new THREE.MeshLambertMaterial({ color: "#c7a5a5", emissive: "red" });
  const group = new THREE.Group();

  positions.forEach((pos, index) => {
    const radius = radii[index] || 0.5;
    const geometry = new THREE.SphereGeometry(radius, 32, 32); // ลด Segments เพื่อ Performance
    const sphere = new THREE.Mesh(geometry, material);

    sphere.position.set(pos.x, initY, pos.z); // เริ่มต้นที่ด้านล่าง
    sphere.userData = { originalPosition: { ...pos }, radius };
    sphere.castShadow = true;
    sphere.receiveShadow = true;

    spheres.push(sphere);
    group.add(sphere);
  });
  scene.add(group);

  // 6. GUI
  gui = new dat.GUI();
  const lightFolder = gui.addFolder('Lighting');
  lightFolder.add(ambientLight, 'intensity', 0, 2);
  gui.close();
};

const initAnimations = () => {
  // GSAP Mouse Follower Setup
  gsap.set(".circle, .circle-follow", { xPercent: -50, yPercent: -50 });
  const xTo = gsap.quickTo(".circle", "x", { duration: 0.6, ease: "power3" });
  const yTo = gsap.quickTo(".circle", "y", { duration: 0.6, ease: "power3" });

  // Loading Animation
  spheres.forEach((sphere, i) => {
    const delay = i * 0.02;
    gsap.timeline()
      .to(sphere.position, {
        duration: revolutionDuration / 2,
        y: revolutionRadius,
        ease: "power1.out",
        onUpdate: function () {
          const progress = this.progress();
          sphere.position.z = sphere.userData.originalPosition.z + Math.sin(progress * Math.PI) * revolutionRadius;
        },
        delay: delay
      })
      .to(sphere.position, {
        duration: revolutionDuration / 2,
        y: initY / 5,
        ease: "power1.out",
        onUpdate: function () {
          const progress = this.progress();
          sphere.position.z = sphere.userData.originalPosition.z - Math.sin(progress * Math.PI) * revolutionRadius;
        }
      })
      .to(sphere.position, {
        duration: 0.6,
        x: sphere.userData.originalPosition.x,
        y: sphere.userData.originalPosition.y,
        z: sphere.userData.originalPosition.z,
        ease: "power1.out"
      });
  });

  setTimeout(() => {
    loadingComplete.value = true;
  }, (revolutionDuration + 1) * 1000);
};

const handleCollisions = () => {
  for (let i = 0; i < spheres.length; i++) {
    const sphereA = spheres[i];
    for (let j = i + 1; j < spheres.length; j++) {
      const sphereB = spheres[j];
      const dist = sphereA.position.distanceTo(sphereB.position);
      const minDist = (sphereA.userData.radius + sphereB.userData.radius) * 1.2;
      if (dist < minDist) {
        tempVector.subVectors(sphereB.position, sphereA.position).normalize();
        const push = (minDist - dist) * 0.4;
        sphereA.position.sub(tempVector.clone().multiplyScalar(push));
        sphereB.position.add(tempVector.clone().multiplyScalar(push));
      }
    }
  }
};

const animate = () => {
  animationFrameId = requestAnimationFrame(animate);

  if (loadingComplete.value) {
    const time = Date.now() * breathingSpeed;
    spheres.forEach((sphere, i) => {
      const offset = i * 0.2;
      const breathingY = Math.sin(time + offset) * breathingAmplitude;
      const breathingZ = Math.cos(time + offset) * breathingAmplitude * 0.5;

      const force = forces.get(sphere.uuid);
      if (force) {
        sphere.position.add(force);
        force.multiplyScalar(0.95);
        if (force.length() < 0.01) forces.delete(sphere.uuid);
      }

      const orig = sphere.userData.originalPosition;
      tempVector.set(orig.x, orig.y + breathingY, orig.z + breathingZ);
      sphere.position.lerp(tempVector, 0.018);
    });
    handleCollisions();
  }

  controls.update();
  renderer.render(scene, camera);
};

// Events
const onMouseMove = (event) => {
  if (!loadingComplete.value) return;

  // UI Updates
  gsap.to(".circle", { x: event.clientX, y: event.clientY, duration: 0.6 });
  gsap.to(".circle-follow", { x: event.clientX, y: event.clientY, duration: 0.9 });

  // Raycasting
  mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
  mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
  raycaster.setFromCamera(mouse, camera);

  const intersects = raycaster.intersectObjects(spheres);
  if (intersects.length > 0) {
    const obj = intersects[0].object;
    const force = new THREE.Vector3()
      .subVectors(intersects[0].point, obj.position)
      .normalize()
      .multiplyScalar(0.2);
    forces.set(obj.uuid, force);
  }
};

const onResize = () => {
  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(window.innerWidth, window.innerHeight);
};

// Lifecycle
onMounted(() => {
  initScene();
  initAnimations();
  animate();
  window.addEventListener('mousemove', onMouseMove);
  window.addEventListener('resize', onResize);
});

onUnmounted(() => {
  window.removeEventListener('mousemove', onMouseMove);
  window.removeEventListener('resize', onResize);
  cancelAnimationFrame(animationFrameId);
  gui.destroy();
  // ทำการ Dispose geometries/materials เพื่อประหยัด RAM
  spheres.forEach(s => {
    s.geometry.dispose();
    s.material.dispose();
  });
});
</script>

<style scoped>
.webgl-container {
  position: relative;
  width: 100vw;
  height: 100vh;
  overflow: hidden;
  background: transparent;
}

#webgl {
  position: fixed;
  top: 0;
  left: 0;
  outline: none;
}

.hide-text {
  opacity: 0;
  transition: opacity 1s ease;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  pointer-events: none;
}

.hide-text.is-visible {
  opacity: 1;
}

.circle, .circle-follow {
  position: fixed;
  width: 20px;
  height: 20px;
  border: 1px solid white;
  border-radius: 50%;
  pointer-events: none;
  z-index: 100;
}
</style>