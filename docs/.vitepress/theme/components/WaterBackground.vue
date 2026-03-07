<template>
  <div ref="container" class="water-simulation-container">
    <canvas ref="waterCanvas" class="water-canvas"></canvas>
    <img
      v-for="(fish, index) in fishData"
      :key="index"
      :ref="el => setFishRef(el, index)"
      :src="fish.url"
      class="fish"
      @mousedown.prevent="startDrag(index)"
      @touchstart.prevent="startDrag(index)"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import * as THREE from 'three';

// --- ตัวแปรอ้างอิง DOM (Refs) ---
const waterCanvas = ref(null);
const fishElements = [];

const setFishRef = (el, index) => {
  if (el) fishElements[index] = el;
};

const fishGifs = [""];
const fishData = fishGifs.map(url => ({ url }));

// ตัวแปรสำหรับ Animation & Logic
let animationFrameId;
let draggedFish = null;
let mouseOn = false;
let renderer, scene, camera, rtA, rtB, simMat, dispMat, simMesh, dispMesh, bgTex;

const fishes = [];

const startDrag = (index) => {
  draggedFish = fishes[index];
  if (draggedFish) draggedFish.isDragging = true;
};

onMounted(() => {
  if (typeof window === 'undefined') return;

  const innerWidth = window.innerWidth;
  const innerHeight = window.innerHeight;

  // --- Setup Three.js ---
  renderer = new THREE.WebGLRenderer({ canvas: waterCanvas.value, alpha: false, antialias: false });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.setSize(innerWidth, innerHeight);

  scene = new THREE.Scene();
  camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);

  let simScale = innerWidth < 768 ? 0.3 : 0.5;
  const SW = () => Math.max(2, Math.floor(window.innerWidth * simScale));
  const SH = () => Math.max(2, Math.floor(window.innerHeight * simScale));

  const rtOpts = {
    minFilter: THREE.LinearFilter,
    magFilter: THREE.LinearFilter,
    format: THREE.RGBAFormat,
    type: THREE.HalfFloatType,
    depthBuffer: false,
    stencilBuffer: false
  };

  rtA = new THREE.WebGLRenderTarget(SW(), SH(), rtOpts);
  rtB = rtA.clone();

  // --- Background Generation ---
  const bgCvs = document.createElement('canvas');
  const bgCtx = bgCvs.getContext('2d');

  function paintBg() {
    const w = window.innerWidth, h = window.innerHeight;
    bgCvs.width = w;
    bgCvs.height = h;

    const g = bgCtx.createRadialGradient(w * .5, h * .42, 0, w * .5, h * .5, Math.hypot(w, h) * .7);
    g.addColorStop(0, '#0f1e32');
    g.addColorStop(0.5, '#07111d');
    g.addColorStop(1, '#030810');
    bgCtx.fillStyle = g;
    bgCtx.fillRect(0, 0, w, h);

    for (let i = 0; i < 5; i++) {
      const y = h * (0.1 + i * 0.18);
      const band = bgCtx.createLinearGradient(0, y - 40, 0, y + 40);
      band.addColorStop(0, 'rgba(40,90,180,0)');
      band.addColorStop(0.5, 'rgba(40,90,180,0.04)');
      band.addColorStop(1, 'rgba(40,90,180,0)');
      bgCtx.fillStyle = band;
      bgCtx.fillRect(0, y - 40, w, 80);
    }

    const orbs = [
      [0.22, 0.28, 0.32, 'rgba(50,110,220,0.13)'],
      [0.78, 0.55, 0.28, 'rgba(255,101,53,0.07)'],
      [0.50, 0.82, 0.40, 'rgba(40,90,200,0.09)'],
    ];
    orbs.forEach(([ox, oy, or, oc]) => {
      const rg = bgCtx.createRadialGradient(ox * w, oy * h, 0, ox * w, oy * h, or * Math.max(w, h));
      rg.addColorStop(0, oc);
      rg.addColorStop(1, 'rgba(0,0,0,0)');
      bgCtx.fillStyle = rg;
      bgCtx.fillRect(0, 0, w, h);
    });

    bgCtx.strokeStyle = 'rgba(50,110,220,0.04)';
    bgCtx.lineWidth = 1;
    const step = 55;
    for (let x = 0; x < w; x += step) { bgCtx.beginPath(); bgCtx.moveTo(x, 0); bgCtx.lineTo(x, h); bgCtx.stroke(); }
    for (let y = 0; y < h; y += step) { bgCtx.beginPath(); bgCtx.moveTo(0, y); bgCtx.lineTo(w, y); bgCtx.stroke(); }
  }

  paintBg();
  bgTex = new THREE.CanvasTexture(bgCvs);

  // --- Shaders ---
  const NUM_FISH = fishGifs.length;
  const initialFishesUniform = new Array(NUM_FISH).fill(0).map(() => new THREE.Vector3(-9999, -9999, 0));

  simMat = new THREE.ShaderMaterial({
    uniforms: {
      uPrev: { value: null },
      uRes: { value: new THREE.Vector2(SW(), SH()) },
      uMouse: { value: new THREE.Vector3(-9999, -9999, 0) },
      uFishes: { value: initialFishesUniform },
      uDamp: { value: 0.996 },
      uSpeed: { value: 2.0 },
      uForce: { value: 12.2 },
      uRadius: { value: 8.0 },
      uFishRadius: { value: 30.0 },
    },
    vertexShader: `
      varying vec2 vUv;
      void main(){ vUv=uv; gl_Position=vec4(position.xy,0.,1.); }
    `,
    fragmentShader: `
      uniform sampler2D uPrev;
      uniform vec2  uRes;
      uniform vec3  uMouse;
      uniform vec3  uFishes[${NUM_FISH}];
      uniform float uDamp, uSpeed, uForce, uRadius, uFishRadius;
      varying vec2 vUv;

      void main(){
        vec2 px = 1.0/uRes;
        vec4 s  = texture2D(uPrev, vUv);
        float h = s.r, v = s.g;

        float hR=texture2D(uPrev,vUv+vec2(px.x,0.)).r;
        float hL=texture2D(uPrev,vUv+vec2(-px.x,0.)).r;
        float hU=texture2D(uPrev,vUv+vec2(0.,px.y)).r;
        float hD=texture2D(uPrev,vUv+vec2(0.,-px.y)).r;
        float hTR=texture2D(uPrev,vUv+vec2(px.x,px.y)).r;
        float hTL=texture2D(uPrev,vUv+vec2(-px.x,px.y)).r;
        float hBR=texture2D(uPrev,vUv+vec2(px.x,-px.y)).r;
        float hBL=texture2D(uPrev,vUv+vec2(-px.x,-px.y)).r;

        if(vUv.x<px.x)        hL=hR;
        if(vUv.x>1.-px.x)     hR=hL;
        if(vUv.y<px.y)        hD=hU;
        if(vUv.y>1.-px.y)     hU=hD;

        float lap = (hR+hL+hU+hD)*0.2 + (hTR+hTL+hBR+hBL)*0.05 - h;

        v += uSpeed * lap;
        h += v;

        h = mix(h, (hR+hL+hU+hD)*0.25, 0.04);

        v *= uDamp;
        h *= uDamp;

        if(uMouse.z>0.5){
          vec2 coord = vUv*uRes;
          float d = distance(coord, uMouse.xy);
          float f = exp(-d*d/(uRadius*uRadius));
          h += f*uForce;
        }

        for(int i=0; i<${NUM_FISH}; i++) {
          if(uFishes[i].z > 0.5) {
            vec2 coord = vUv*uRes;
            float d = distance(coord, uFishes[i].xy);
            float f = exp(-d*d/(uFishRadius*uFishRadius));
            h += f * uForce * 0.45;
          }
        }

        h=clamp(h,-2.,2.);
        v=clamp(v,-2.,2.);

        float gx=(hR-hL)*0.5;
        float gy=(hU-hD)*0.5;

        gl_FragColor=vec4(h,v,gx,gy);
      }
    `
  });

  dispMat = new THREE.ShaderMaterial({
    uniforms: {
      uSim: { value: null },
      uBg: { value: bgTex },
    },
    vertexShader: `
      varying vec2 vUv;
      void main(){ vUv=uv; gl_Position=vec4(position.xy,0.,1.); }
    `,
    fragmentShader: `
      uniform sampler2D uSim, uBg;
      varying vec2 vUv;

      void main(){
        vec4  d  = texture2D(uSim, vUv);
        float h  = d.r;
        vec2  gr = d.zw;

        vec2 uv2 = vUv + gr * 0.028;
        uv2 = clamp(uv2, 0.001, 0.999);
        vec3 color = texture2D(uBg, uv2).rgb;

        vec3 N = normalize(vec3(-gr.x*6., 1.0, -gr.y*6.));

        vec3 L = normalize(vec3(-1.2, 4.5, 2.0));
        float sp = pow(max(dot(N,L),0.),900.0);
        color += vec3(0.88,0.94,1.0) * sp * 3.0;

        vec3 L2 = normalize(vec3(2.0, 3.0, -1.0));
        float sp2 = pow(max(dot(N,L2),0.),60.0);
        color += vec3(0.25,0.55,1.0) * sp2 * 0.55;

        float caus = sin(h*20.0)*0.5+0.5;
        color += vec3(0.04,0.14,0.38) * caus * abs(h) * 0.3;

        color += vec3(0.02,0.08,0.25) * h * 0.4;

        vec2 p = vUv*2.-1.;
        color *= 1.0 - dot(p,p)*0.35;

        gl_FragColor = vec4(color, 1.0);
      }
    `
  });

  const quad = new THREE.PlaneGeometry(2, 2);
  simMesh = new THREE.Mesh(quad, simMat);
  dispMesh = new THREE.Mesh(quad, dispMat);

  // --- Initialize Fish Logic ---
//   fishData.forEach((data, index) => {
//     const isBottomPatrol = index === 1;
//     fishes.push({
//       x: Math.random() * window.innerWidth,
//       y: Math.random() * window.innerHeight,
//       tx: isBottomPatrol ? window.innerWidth - 150 : Math.random() * window.innerWidth,
//       ty: isBottomPatrol ? window.innerHeight - 120 : Math.random() * window.innerHeight,
//       speed: 0.2 + Math.random() * 1.5,
//       angle: 0,
//       targetAngle: 0,
//       isDragging: false,
//       isBottomPatrol
//     });
//   });

  // --- Event Listeners ---
  const sm = simMat.uniforms.uMouse.value;
  function setMouse(ex, ey) {
    sm.x = (ex / window.innerWidth) * SW();
    sm.y = (1 - ey / window.innerHeight) * SH();
  }

  const onMouseMove = (e) => {
    mouseOn = true;
    setMouse(e.clientX, e.clientY);
    if (draggedFish) {
      const dx = e.clientX - draggedFish.x;
      const dy = e.clientY - draggedFish.y;
      if (Math.hypot(dx, dy) > 2) {
        draggedFish.targetAngle = Math.atan2(dy, dx);
      }
      draggedFish.x = draggedFish.tx = e.clientX;
      draggedFish.y = draggedFish.ty = e.clientY;
    }
  };

  const onMouseLeave = () => { mouseOn = false; };

  const onTouchMove = (e) => {
    mouseOn = true;
    const tx = e.touches[0].clientX;
    const ty = e.touches[0].clientY;
    setMouse(tx, ty);
    if (draggedFish) {
      const dx = tx - draggedFish.x;
      const dy = ty - draggedFish.y;
      if (Math.hypot(dx, dy) > 2) {
        draggedFish.targetAngle = Math.atan2(dy, dx);
      }
      draggedFish.x = draggedFish.tx = tx;
      draggedFish.y = draggedFish.ty = ty;
    }
  };

  const onPointerUp = () => {
    if (draggedFish) {
      draggedFish.isDragging = false;
      draggedFish = null;
    }
  };

  const onTouchEnd = () => {
    mouseOn = false;
    onPointerUp();
  };

  const onResize = () => {
    renderer.setSize(window.innerWidth, window.innerHeight);
    rtA.setSize(SW(), SH()); rtB.setSize(SW(), SH());
    simMat.uniforms.uRes.value.set(SW(), SH());
    paintBg();
    bgTex.needsUpdate = true;
  };

  document.addEventListener('mousemove', onMouseMove);
  document.addEventListener('mouseleave', onMouseLeave);
  document.addEventListener('touchmove', onTouchMove, { passive: false });
  document.addEventListener('mouseup', onPointerUp);
  document.addEventListener('touchend', onTouchEnd);
  window.addEventListener('resize', onResize);

  // เก็บ Event functions ไว้เพื่อลบตอน Unmount
  window._simEvents = { onMouseMove, onMouseLeave, onTouchMove, onPointerUp, onTouchEnd, onResize };

  // --- Animation Loop ---
  function updateFishes() {
    fishes.forEach((f, i) => {
      if (f.isBottomPatrol) {
        if (!f.isDragging) {
          const paddingX = 150;
          const bottomY = window.innerHeight - 120;
          f.ty = bottomY;

          const dx = f.tx - f.x;
          const dy = f.ty - f.y;
          if (Math.hypot(dx, dy) < 80) {
            f.tx = f.tx > window.innerWidth / 2 ? paddingX : window.innerWidth - paddingX;
          }

          f.targetAngle = Math.atan2(f.ty - f.y, f.tx - f.x);
          f.x += Math.cos(f.angle) * f.speed;
          f.y += Math.sin(f.angle) * f.speed;
        }

        let dAngle = f.targetAngle - f.angle;
        while (dAngle > Math.PI) dAngle -= 2 * Math.PI;
        while (dAngle < -Math.PI) dAngle += 2 * Math.PI;
        f.angle += dAngle * 0.02;

        let flipY = Math.cos(f.angle) < 0 ? -1 : 1;
        let deg = f.angle * 180 / Math.PI;

        // อัปเดต DOM โดยตรง
        if (fishElements[i]) {
          fishElements[i].style.transform = `translate(calc(${f.x}px - 50%), calc(${f.y}px - 50%)) rotate(${deg}deg) scaleY(${flipY}) scaleX(-1)`;
        }
      } else {
        if (!f.isDragging) {
          const paddingX = 125;
          const paddingY = 60;
          let bounced = false;

          if (f.x < paddingX) { f.x = paddingX; f.tx = f.x + 400; bounced = true; }
          if (f.x > window.innerWidth - paddingX) { f.x = window.innerWidth - paddingX; f.tx = f.x - 400; bounced = true; }
          if (f.y < paddingY) { f.y = paddingY; f.ty = f.y + 300; bounced = true; }
          if (f.y > window.innerHeight - paddingY) { f.y = window.innerHeight - paddingY; f.ty = f.y - 300; bounced = true; }

          const dx = f.tx - f.x;
          const dy = f.ty - f.y;
          if (Math.hypot(dx, dy) < 50 && !bounced) {
            f.tx = paddingX + Math.random() * (window.innerWidth - paddingX * 2);
            f.ty = paddingY + Math.random() * (window.innerHeight - paddingY * 2);
            f.speed = 0.2 + Math.random() * 1.5;
          }

          f.targetAngle = Math.atan2(f.ty - f.y, f.tx - f.x);
          f.x += Math.cos(f.angle) * f.speed;
          f.y += Math.sin(f.angle) * f.speed;
        }

        let dAngle = f.targetAngle - f.angle;
        while (dAngle > Math.PI) dAngle -= 2 * Math.PI;
        while (dAngle < -Math.PI) dAngle += 2 * Math.PI;
        f.angle += dAngle * 0.015;

        let flipY = Math.cos(f.angle) < 0 ? -1 : 1;
        let deg = f.angle * 180 / Math.PI;

        // อัปเดต DOM โดยตรง
        if (fishElements[i]) {
          fishElements[i].style.transform = `translate(calc(${f.x}px - 50%), calc(${f.y}px - 50%)) rotate(${deg}deg) scaleY(${flipY})`;
        }
      }

      simMat.uniforms.uFishes.value[i].set(
        (f.x / window.innerWidth) * SW(),
        (1 - f.y / window.innerHeight) * SH(),
        1.0
      );
    });
  }

  let prevT = 0, badFrames = 0;
  function loop(t) {
    animationFrameId = requestAnimationFrame(loop);

    updateFishes();

    const dt = t - prevT; prevT = t;
    if (dt > 40) badFrames++;
    else badFrames = Math.max(0, badFrames - 1);
    if (badFrames > 15 && simScale > 0.2) {
      simScale -= 0.05; badFrames = 0; onResize();
    }

    simMat.uniforms.uPrev.value = rtB.texture;
    sm.z = mouseOn ? 1 : 0;

    renderer.setRenderTarget(rtA);
    scene.add(simMesh);
    renderer.render(scene, camera);
    scene.remove(simMesh);

    dispMat.uniforms.uSim.value = rtA.texture;
    renderer.setRenderTarget(null);
    scene.add(dispMesh);
    renderer.render(scene, camera);
    scene.remove(dispMesh);

    const tmp = rtA; rtA = rtB; rtB = tmp;
  }

  loop(0);
});

onBeforeUnmount(() => {
  // ลบ Event Listeners
  if (window._simEvents) {
    const evts = window._simEvents;
    document.removeEventListener('mousemove', evts.onMouseMove);
    document.removeEventListener('mouseleave', evts.onMouseLeave);
    document.removeEventListener('touchmove', evts.onTouchMove);
    document.removeEventListener('mouseup', evts.onPointerUp);
    document.removeEventListener('touchend', evts.onTouchEnd);
    window.removeEventListener('resize', evts.onResize);
  }

  // หยุด Animation Loop
  cancelAnimationFrame(animationFrameId);

  // เคลียร์หน่วยความจำของ Three.js
  if (renderer) renderer.dispose();
  if (rtA) rtA.dispose();
  if (rtB) rtB.dispose();
  if (simMat) simMat.dispose();
  if (dispMat) dispMat.dispose();
  if (bgTex) bgTex.dispose();
});
</script>

<style scoped>
.three-container {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: -1; /* ให้อยู่หลังเนื้อหา */
	pointer-events: none; /* ไม่ให้ทับการคลิกปุ่ม */
	opacity: 0.4;
}
.water-simulation-container {
  position: absolute;
  width: 100vw;
  height: 100vh;
  overflow: hidden;
  top: 0;
}

.water-canvas {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
}

/* คุณสามารถปรับแต่งสไตล์ของ marquee ได้ที่นี่ */
.marquee-track {
  position: absolute;
  top: 50%; /* วางไว้กลางจอ หรือปรับตามต้องการ */
  left: 0;
  width: 100%;
  white-space: nowrap;
  z-index: 2;
  color: white;
  font-size: 2rem;
  font-family: sans-serif;
  pointer-events: none; /* เพื่อให้คลิกทะลุไปโดนน้ำได้ */
}

.fish {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 3;
  width: 100px; /* ปรับขนาดปลาตามต้องการ */
  cursor: grab;
  user-select: none;
  transform-origin: center center;
}

.fish:active {
  cursor: grabbing;
}
</style>