---
title: Change Log (ประวัติการเปลี่ยนแปลงระบบ)
roles: ['*']
outline: deep
---

# Change Log (ประวัติการเปลี่ยนแปลงระบบ)

บันทึกประวัติการเพิ่มฟีเจอร์ใหม่ การปรับปรุงประสิทธิภาพ และการแก้ไขปัญหาของระบบ **AMEC Procurement System (PUR-008P)** โดยเรียงลำดับจากเวอร์ชันล่าสุดไปหาเก่าสุด

---

## [v0.3.1] — 2026-11-22

### Added
- **Approved Vendor List (`/procurement/vendors/list`)**: เพิ่มหน้าทะเบียนคู่ค้าแบบ Read-Only สำหรับผู้ใช้งานทั่วไป (แสดงเฉพาะกลุ่ม Indirect & Subcontractor และข้อมูลติดต่อทั่วไป พร้อม Slide-Over Drawer)
- **Select2 Filter Integration**: เพิ่ม Select2 (`allowClear`) ให้กับตัวกรอง Dropdown ในหน้า Vendor Directory, Approved Vendor List, Vendor Detail (Change History) และ Vendor Users

### Changed
- **Vendor Users / SCM Users**: ปรับโครงสร้างจากการกำหนด Portal Role (RBAC) เป็นการบันทึก **Position / Responsibility** (6 ตำแหน่งหลัก) พร้อมเพิ่มฟิลด์ `Phone Number`, ระบุขอบเขตสิทธิ์ร่วมตามกลุ่ม `PURSYS.VENDORS_CODE` และตั้งค่าสถานะเริ่มต้นของบัญชีใหม่เป็น **`PENDING`** อัตโนมัติ
- **Vendors Controller & Scripts**: ล้างเมธอดเดิม (`create`, `approval`, `form`) ออกจาก `Vendors.php`, แยก Logic ตารางเป็น `assets/script/vendor/index-table.js` และรวมฟังก์ชัน Export Excel ไว้ที่ `assets/script/service/excel.js`
- **Documentation**: อัปเดตเอกสาร [vendor.md](/vendor/vendor), [users.md](/vendor/users), [tech-spec.md](/vendor/tech-spec) และแผนผัง Flowchart ให้ตรงกับโค้ดล่าสุด

---

## [v0.3.0] — 2026-11-22

### Added
- **Documentation — Role-Based Access Control**: เพิ่มระบบแยกสิทธิ์การเข้าถึงเอกสาร VitePress ตาม User Role โดยตรวจสอบจากสถานะ Login จริงของ `@amec/webasset` (Cookie + IndexedDB + `directlogin` API fallback) และกำหนดให้ผู้ที่ยังไม่ Login เข้าสู่สิทธิ์ `GUEST`
- **Documentation — Vendor Management Guides**:
  - เพิ่มคู่มือใช้งานหน้า [Vendor List & Detail](/vendor/vendor), [Approving Vendor](/vendor/approve), และ [SCM Users](/vendor/users)
  - เพิ่มภาพหน้าจอจริงขนาด Desktop (`1440×900`) พร้อมหมุดหมายเลขแบบ Interactive (`<AnnotatedImage />`) อธิบายทุกส่วนของหน้าจอ
  - เพิ่มหน้า **Technical Specification (Admin Only)** พร้อมแผนผัง Flowchart, Data Lineage / ER Diagram, API Endpoints และโครงสร้างตาราง Oracle `PURSYS`
- **Documentation — Interactive 3D Home Scene**: เปลี่ยนฉาก Three.js หน้าแรกเป็นฉาก 3D โรงงานอุตสาหกรรม ท่าเรือ เรือบรรทุกตู้คอนเทนเนอร์ เครนยก รถขนส่ง และโซน Eco (ต้นไม้ โซลาร์เซลล์ กังหันลม) พร้อมระบบปรับแสงตามเวลาจริงใน Light Mode และโหมดกลางคืนแบบเปิดไฟครบใน Dark Mode
- **Documentation — Quick Start & Change Log**: เพิ่มหน้าภาพรวมระบบและหน้าบันทึกการเปลี่ยนแปลงระบบ

### Changed
- **Vendor Directory Scripts**: แยกและจัดโครงสร้างสคริปต์ตารางคู่ค้าใหม่ (`index-table.js`) เพื่อให้อ่านง่ายและดูแลรักษาได้สะดวกขึ้น

---

## [v0.2.0] — 2026-11-21

### Added
- **Vendor Users Management (E-SCM Portal)**: เพิ่มหน้าจัดการบัญชีผู้ใช้งานคู่ค้า (`/procurement/vendors/users`) พร้อม KPI 4 การ์ด, ตัวกรองตามสถานะ/คู่ค้า/Role, Modal สร้าง/แก้ไขบัญชี และนโยบายความปลอดภัย 72h Activation / 90-Day Inactivity
- **Vendor Detail — E-SCM Contacts Tab**: เพิ่มแท็บแสดงผู้ติดต่อ E-SCM และเชื่อมโยงไปยังหน้าจัดการบัญชีคู่ค้า
- **P/O Detail & Reporting**:
  - เพิ่มหน้าจอรายละเอียดใบสั่งซื้อ (P/O Detail) ครบทั้ง Summary, Delivery Tab, Item Tab และ History Tab
  - เพิ่มคอมโพเนนต์และฟังก์ชันสำหรับรายงานใบสั่งซื้อ (P/O Report)

### Changed
- ปรับปรุงโครงสร้างโค้ดและแยกส่วนประกอบ View/Script ให้เป็นมาตรฐานเดียวกันตาม Design System ของ AMEC

---

## [v0.1.0] — 2026-11-09

### Added
- **Initial System Foundation**: โครงสร้างพื้นฐานระบบ AMEC Procurement บน CodeIgniter 3 + Laravel Blade + Tailwind CSS v4 + DaisyUI v5 + Rspack + `@amec/webasset`
- **Master Modules**: โมดูลเบื้องต้นสำหรับ Vendors, Products, Categories, Item Master, Part Shortage และ Purchase Requisition
- **Database Schema (`PURSYS`)**: ฐานข้อมูลหลัก `PUR_VENDORS`, `PUR_VENDORS_ADDRESS`, `PUR_VENDORS_CODE`, `PUR_VENDORS_ATTFILE`

---

<RoleOnly :roles="['ADMIN']">

::: tip แนวทางการบันทึก Change Log (สำหรับทีมพัฒนา / Admin)
เมื่อมีการ Deploy ฟีเจอร์หรือแก้ไขระบบใหม่ ให้เพิ่มหัวข้อด้านบนสุดของไฟล์ `docs/changelog.md` ตามรูปแบบนี้ แล้วรัน `npm run docs:build`:

```markdown
## [v0.x.y] — YYYY-MM-DD

### Added
- ฟีเจอร์หรือหน้าจอใหม่ที่เพิ่มเข้ามา

### Changed
- การปรับปรุงการทำงาน UI หรือประสิทธิภาพของฟีเจอร์เดิม

### Fixed
- รายการบั๊กหรือปัญหาที่แก้ไขแล้ว
```
:::

</RoleOnly>
