---
title: SCM Users (จัดการบัญชีผู้ใช้งานคู่ค้า)
roles: ['ADMIN', 'BUYER']
outline: deep
---

# Vendor Users Management / SCM Users

หน้า **Vendor Users Management** (`/procurement/vendors/users`) ใช้สำหรับสร้างและควบคุมสิทธิ์บัญชีผู้ใช้งานของคู่ค้า (Supplier Portal Accounts) บนระบบ **E-SCM / EDI** เพื่อให้คู่ค้าสามารถเข้าถึงเอกสาร P/O, การส่งมอบสินค้า (ASN), เคลมคุณภาพ (CAR) และแบบวิศวกรรม (Drawings) ได้อย่างปลอดภัยตามมาตรฐาน **ISO 27001 / J-SOX**

<AnnotatedImage
  src="/images/vendor/vendor-users.png"
  alt="หน้าจอ Vendor Users Management (Desktop)"
  caption="ภาพรวมหน้าจอ Vendor Users Management (SCM Users) — ชี้เมาส์หรือคลิกที่หมายเลขเพื่อดูคำอธิบายแต่ละส่วน"
  :markers="[
    { x: 86, y: 13, title: 'ปุ่มส่งออกและเพิ่มผู้ใช้ (Action Buttons)', desc: 'ปุ่ม Export User List เพื่อดาวน์โหลดรายชื่อบัญชีทั้งหมด และปุ่ม + Add Vendor User เพื่อสร้างบัญชีคู่ค้าใหม่' },
    { x: 61, y: 35, title: 'แถบ KPI สถานะบัญชี 4 การ์ด', desc: 'สรุปจำนวนบัญชีทั้งหมด (Total Portal Users), บัญชีที่ใช้งาน (Active), รอยืนยันใน 72 ชม. (Pending) และบัญชีที่ถูกระงับ (Locked/Inactive)' },
    { x: 56, y: 51, title: 'แท็บสถานะและตัวกรอง (Tabs & Filter Strip)', desc: 'สลับดูตามสถานะบัญชี ค้นหาด้วยชื่อ/Username/อีเมล/Vendor Code กรองตามบริษัทคู่ค้าและ Portal Role พร้อมปุ่ม Reset' },
    { x: 61, y: 69, title: 'ตารางบัญชีผู้ใช้งานคู่ค้า (Users Table)', desc: 'แสดงบัญชีผู้ใช้งาน บริษัทคู่ค้าที่ผูกไว้ ระดับสิทธิ์ Portal Role เวลาเข้าใช้งานล่าสุด สถานะ และปุ่มจัดการ Actions' },
    { x: 61, y: 88, title: 'แถบนโยบายความปลอดภัย (Security & RBAC Policy)', desc: 'สรุปกฎความปลอดภัยหลัก: ลิงก์เปิดบัญชีหมดอายุใน 72 ชม., การกำหนดสิทธิ์ตามหน้าที่ (RBAC) และการระงับบัญชีที่ไม่ใช้งานเกิน 90 วัน' }
  ]"
/>

---

## 1. แถบสรุปสถานะบัญชีผู้ใช้งาน (KPI Summary)

| ตัวชี้วัด | คำอธิบาย |
| :--- | :--- |
| **Total Users** | จำนวนบัญชีผู้ใช้งานคู่ค้าทั้งหมด และจำนวนบริษัทคู่ค้าที่มีบัญชีในระบบ |
| **Active Users** | จำนวนและอัตราส่วน (`%`) ของบัญชีที่เปิดใช้งานอยู่ |
| **Pending** | บัญชีที่สร้างใหม่หรือรอการยืนยันเปิดใช้งาน |
| **Inactive** | บัญชีที่ถูกปิดการใช้งานหรือระงับสิทธิ์ชั่วคราว |

---

## 2. ระดับสิทธิ์บน E-SCM Portal (Portal Roles)

ระบบแบ่งบทบาทของผู้ใช้งานฝั่งคู่ค้าออกเป็น **4 ระดับ** โดยแต่ละ Role จะเข้าถึงโมดูลบน E-SCM Portal แตกต่างกัน:

| Role Key | ชื่อบทบาท | โมดูลที่เข้าถึงได้ |
| :--- | :--- | :--- |
| `ADMIN` | **Vendor Admin** | Purchase Orders, ASN Dispatch, Claim Slip (CAR), Drawings, User Management |
| `SALES` | **Sales / PO Handler** | Purchase Orders, Changing Notice, Drawings |
| `LOGISTICS` | **Logistics / ASN** | Purchase Orders (View), ASN Dispatch, Delivery Slips |
| `QA` | **Quality / Claim** | Claim Slip (CAR), Drawings, Changing Notice |

---

## 3. สถานะบัญชีผู้ใช้งาน (Account Status)

- **Active** (สีเขียว): ใช้งาน E-SCM Portal ได้ตามปกติ
- **Pending** (สีเหลือง): อยู่ระหว่างรอเปิดใช้งานหรือรอตั้งรหัสผ่านครั้งแรก
- **Inactive** (สีแดง): ระงับการเข้าสู่ระบบ (ใช้เมื่อพนักงานฝั่งคู่ค้าลาออกหรือเปลี่ยนผู้รับผิดชอบ)

---

## 4. วิธีจัดการบัญชีผู้ใช้งานคู่ค้า

### การค้นหาและกรองข้อมูล
- สามารถกรองรายชื่อผู้ใช้งานตาม **สถานะบัญชี** (`Active` / `Pending` / `Inactive`), **บริษัทคู่ค้า (Vendor)**, **Portal Role** (`ADMIN`, `SALES`, `LOGISTICS`, `QA`) หรือค้นหาด้วยชื่อ/Username/อีเมล

### การเพิ่มบัญชีผู้ใช้งานใหม่ (+ Add Vendor User)
1. คลิกปุ่ม **+ Add Vendor User** ที่มุมขวาบน
2. เลือก **บริษัทคู่ค้า (Vendor)** ที่ต้องการผูกบัญชี
3. กรอกข้อมูลผู้ใช้งาน (ชื่อผู้ติดต่อ, Username, อีเมล, แผนก) และเลือก **Portal Role** ให้ตรงกับหน้าที่งาน
4. กดบันทึกเพื่อสร้างบัญชีเข้าสู่ระบบ

### การดูรายละเอียด แก้ไขสิทธิ์ และรีเซ็ตรหัสผ่าน
- คลิกที่รายการผู้ใช้งานเพื่อเปิด **Slide-Over Detail Drawer** สำหรับตรวจสอบโมดูลที่ได้รับสิทธิ์และประวัติการเข้าใช้งานล่าสุด
- สามารถกด **Edit User** เพื่อปรับเปลี่ยน Role หรือเปลี่ยนสถานะเป็น `Inactive` ได้ทันที
- กรณีคู่ค้าลืมรหัสผ่าน สามารถใช้ฟังก์ชัน **Reset Password** จากหน้ารายละเอียดบัญชี

### การส่งออกรายชื่อผู้ใช้งาน
- คลิกปุ่ม **Export User List** ที่มุมขวาบน เพื่อดาวน์โหลดรายชื่อบัญชีผู้ใช้งานคู่ค้าทั้งหมดพร้อมสิทธิ์และสถานะเป็นไฟล์สำหรับตรวจสอบสิทธิ์ประจำปี (User Access Review)

::: warning นโยบายความปลอดภัย (Access Governance)
เมื่อคู่ค้าแจ้งเปลี่ยนผู้ติดต่อหรือมีพนักงานลาออก ควรปรับสถานะบัญชีเดิมเป็น **Inactive** ทันทีแทนการนำบัญชีเดิมไปให้ผู้อื่นใช้งานต่อ เพื่อรักษาความถูกต้องของ Audit Log บนระบบ E-SCM
:::

<RoleOnly :roles="['ADMIN']">

::: info สำหรับผู้ดูแลระบบและทีมพัฒนา (Admin Only)
ดูรายละเอียด Endpoints (`/pursys/vendors/users/*`), ไฟล์ `assets/script/vendor/users.js` และโครงสร้างฐานข้อมูลได้ที่หน้า [Technical Spec (Admin)](/vendor/tech-spec)
:::

</RoleOnly>
