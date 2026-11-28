# Checklist ตรวจสอบและแก้ปัญหา Auth Redirect, Flash/Flicker และ PHP 8.5 Deprecation (CI3 + @amec/webasset)

ให้ตรวจสอบโปรเจกต์นี้ตามหัวข้อด้านล่างทีละข้อ รายงานว่าพบปัญหาข้อไหนบ้าง และแก้ให้ครบพร้อม build + ทดสอบยืนยัน

---

## 1. PHP 8.4/8.5 `E_DEPRECATED` แว๊บตอนเข้าครั้งแรก (ก่อน Custom Handler โหลด)
**อาการ:** เข้าเว็บครั้งแรกหลัง restart Apache/PHP จะเห็นกล่อง PHP Error `Severity: 8192` จาก `vendor/` แว๊บขึ้นมา (ครั้งถัดไปไม่เห็นเพราะ OPcache)

**วิธีเช็ค:**
- เปิด `index.php` ดู `case 'development':` ว่าตั้ง `error_reporting(-1);` หรือไม่
- เช็ค `application/config/config.php` ว่า `$config['composer_autoload'] = TRUE;` หรือไม่ (Composer โหลดก่อน `Handler` library)
- เช็ค `application/logs/` ล่าสุดว่ามี `Severity: 8192` จาก `vendor/` หรือไม่

**วิธีแก้:**
ใน `index.php` เปลี่ยน `case 'development':` เป็น:
```php
case 'development':
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
    ini_set('display_errors', 1);
break;
```

---

## 2. หน้าเว็บ Render DOM / โหลด JS ก่อน Redirect ไป `/form/authen/index/<APP_ID>`
**อาการ:** เข้าเว็บครั้งแรกแบบไม่มี cookie จะเห็นหน้า Home/เนื้อหาเว็บ + Preloader โผล่ขึ้นมาก่อน แล้วค่อย redirect ฝั่ง JS ไปหน้า authen

**วิธีเช็ค:**
- เปิด `application/core/MY_Controller.php` ดู method `views()` (หรือ base controller ที่ render หน้า) ว่ามีการตรวจ `$_COOKIE[$_ENV['APP_NAME']]` ฝั่ง PHP หรือไม่
- ตรวจสอบทุก controller ใน `application/controllers/` ก่อนว่ามีหน้า public ที่ **ต้องเข้าได้โดยไม่มี cookie** หรือไม่ (ถ้ามีให้เว้น route นั้น)
- ทดสอบยิง `curl --noproxy '*' -s -i <APP_URL>` แบบไม่ส่ง cookie — ถ้าได้ `200 OK` พร้อม HTML แสดงว่ายัง redirect ฝั่ง JS อยู่

**วิธีแก้:**
เพิ่ม server-side cookie guard ใน `MY_Controller::views()` (ก่อน `echo $this->blade->render(...)`):
```php
public function views($view_name, $data = array()){
    $appName = $_ENV['APP_NAME'] ?? '';
    if (!is_cli() && !$this->isAjaxRequest() && $appName !== '' && empty($_COOKIE[$appName])) {
        $authUrl = rtrim($_ENV['APP_HOST'], '/') . '/form/authen/index/' . $_ENV['APP_ID'];
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Location: ' . $authUrl, true, 302);
        exit;
    }
    echo $this->blade->render($view_name, $data);
}
```

---

## 3. Sidebar ค้าง/หายช้าทับหน้า Splash `/form/authen/...` จาก Cross-Document View Transition
**อาการ:** ตอน redirect / logout ออกไปหน้า `/form/authen/...` (origin เดียวกันแต่ไม่มี sidebar) ตัว sidebar ค้างทับหน้า splash แว๊บหนึ่งแล้วค่อยหาย

**วิธีเช็ค:**
- ค้นหา `@view-transition` และ `view-transition-name` ในไฟล์ CSS (เช่น `assets/style/tailwind.css`)
- ถ้ามีการตั้ง `::view-transition-old(app-sidebar) { animation: none; }` ให้เช็คใน `script.js` ว่ามี `pageswap` listener สำหรับยกเลิก transition ตอนออกนอกแอปหรือไม่

**วิธีแก้:**
1. ใน `script.js` เพิ่ม `pageswap` listener เพื่อ skip transition เมื่อออกนอก `base_url`:
```js
window.addEventListener("pageswap", (event) => {
    if (!event.viewTransition) return;
    const destUrl = event.activation?.entry?.url || "";
    const appBase = (
        document.querySelector('meta[name="base_url"]')?.content || ""
    ).replace(/\/+$/, "");
    if (
        destUrl &&
        appBase &&
        destUrl !== appBase &&
        !destUrl.startsWith(`${appBase}/`)
    ) {
        event.viewTransition.skipTransition();
    }
});
```
2. ในไฟล์ CSS (เช่น `assets/style/tailwind.css`) เพิ่ม fallback สำหรับกรณี sidebar เป็น `:only-child`:
```css
::view-transition-old(app-sidebar):only-child {
    animation: 100ms ease-out both amec-page-out;
}
```

---

## 4. Preloader (`showbgLoader`) กระพริบโดยไม่จำเป็นตอน Redirect หรือ Cache Hit
**อาการ:** จอเทา/GIF preloader กระพริบก่อน redirect หรือกระพริบทุกครั้งที่เปลี่ยนหน้าทั้งที่โหลดเมนูจาก IndexedDB ได้ทันที

**วิธีเช็ค:**
- ค้นหา `showbgLoader` ทั้งโปรเจกต์ใน `assets/script/`
- ดูใน `initFromCache()` (เช่น `assets/script/utils.js`) ว่า:
  - เรียก `showbgLoader()` **ก่อน** เช็ค `cookie` หรือไม่
  - เรียก `showbgLoader()` บน fast path ของ IndexedDB cache hit หรือไม่
  - ใช้ `window.location.href` แทน `window.location.replace` ตอน redirect หรือไม่ (ทำให้กด Back ติด loop)
- ดูใน page script (เช่น `assets/script/home.js`) ว่าเรียก `showbgLoader()` ครอบ `await window.appReady` ซ้ำซ้อนหรือไม่

**วิธีแก้:**
- ใน `initFromCache()`:
  - เช็ค `cookie` เป็นอย่างแรก ถ้าไม่มีให้ใช้ `window.location.replace(`${root}/form/authen/index/${APP_ID}`)` โดยไม่ต้องเปิด loader
  - เอา `showbgLoader()` ออกจาก fast path ของ cache hit (ให้ `initAuthen()` เปิด loader เฉพาะตอน cache miss ที่ต้องยิง API)
- เอา `showbgLoader()` ที่ซ้ำซ้อนใน `home.js` (หรือหน้าอื่นที่ครอบแค่ `window.appReady`) ออก

---

## 5. Null Guard ใน `script.js` (ป้องกัน Console Error ตอนโหลดหน้า)
**วิธีเช็ค:**
- ดูใน `script.js` ว่ามี `document.getElementById("theme").checked = true;` โดยไม่เช็คว่า element มีอยู่จริงหรือไม่

**วิธีแก้:**
```js
document.addEventListener("DOMContentLoaded", function () {
    if (savedTheme === "dark") {
        const themeToggle = document.getElementById("theme");
        if (themeToggle) themeToggle.checked = true;
    }
});
```

---

## 6. Build & Verify หลังแก้ไข
1. Build CSS และ JS ใหม่ (เช่น `npm run build:css` และ `npm run build:js` หรือ `npm run build`)
2. ทดสอบไม่มี cookie → ต้องได้ `HTTP/1.1 302 Found` ไป `/form/authen/index/<APP_ID>` และ `Content-Length: 0`:
   ```bash
   curl --noproxy '*' -s -i <APP_URL>
   ```
3. ทดสอบมี cookie → ต้องได้ `HTTP/1.1 200 OK`:
   ```bash
   curl --noproxy '*' -s -I -H "Cookie: <APP_NAME>=test" <APP_URL>
   ```
