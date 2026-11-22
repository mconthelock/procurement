---
title: Technical Specification (Admin)
roles: ['ADMIN']
outline: deep
---

# Vendor Module — Technical Specification (Admin Only)

::: danger สำหรับผู้ดูแลระบบและทีมพัฒนาเท่านั้น (Admin / Developer)
เอกสารหน้านี้อธิบายโครงสร้างโปรแกรม, Route/View/Bundle Mapping, Backend API Endpoints, โครงสร้างตารางฐานข้อมูล Oracle (`PURSYS`) และรายการที่ต้องปรับปรุงต่อ เพื่อใช้ในการดูแลและพัฒนาต่อยอดในอนาคต
:::

---

## 1. สถาปัตยกรรมและเทคโนโลยี (System Architecture & Stack)

| Layer | เทคโนโลยีที่ใช้ | หมายเหตุ |
| :--- | :--- | :--- |
| **Web Framework** | PHP CodeIgniter 3 (`MY_Controller`) | จัดการ Routing และ Render View |
| **Template Engine** | Laravel Blade (`duncan3dc/blade`) | เก็บไฟล์ที่ `application/views/vendors/` (Cache ที่ `application/cache/`) |
| **UI / Styling** | Tailwind CSS v4 + DaisyUI v5 + Material Symbols | Build ด้วย `npm run build:css` -> `assets/dist/css/tailwind.css` |
| **JS Bundler** | Rspack (`rspack.config.js`) | Auto-discover จากไฟล์ `assets/script/**/_entry.js` -> `assets/dist/js/[name].js` |
| **Shared Corporate Lib** | `@amec/webasset` | จัดการ Auth (Cookie + IndexedDB `userAuth`), Navbar, Sidebar, DataTables, Preloader, `fetchUtils` |
| **Backend API** | REST API (`APP_API` ใน `.env`) | เส้นทางหลัก `/pursys/vendors/*` (Default Local: `http://localhost:3001`) |
| **Database** | Oracle Database (Schema `PURSYS`) + AS400 Sync | ตารางทะเบียนคู่ค้า, ที่อยู่, รหัสคู่ค้า, ไฟล์แนบ, กลุ่มบริษัท และ E-SCM Users |

---

## 2. แผนผังการทำงานและสายการอนุมัติ (System & Approval Flowchart)

แผนผังด้านล่างแสดงลำดับการทำงานทั้งหมดตั้งแต่การยืนยันตัวตนผ่าน `@amec/webasset`, การดูทะเบียนคู่ค้า, การยื่นคำขอขึ้นทะเบียน/แก้ไขผ่าน Cover Sheet (`PRO-QP-A-020`), สายการอนุมัติ 3 ระดับ (`Buyer → SEM → DEM`) ไปจนถึงการซิงก์ข้อมูลลงฐานข้อมูล Oracle (`PURSYS`), ระบบ **AS400 ERP** และ **E-SCM Portal**:

<VendorFlowDiagrams diagram="system-flow" />

### สรุปการไหลของสถานะ (Lifecycle Steps)
1. **Authentication**: หน้าแอปตรวจสอบ Cookie (`procurement`) และอ่านสิทธิ์จาก IndexedDB (`userAuth.group`) ผ่าน `initApp()` ใน `assets/script/utils.js`
2. **Directory & Detail**: `vendor/index.js` เรียก `POST /pursys/vendors/search/` แสดงตารางทะเบียนคู่ค้า เมื่อคลิกเปิดรายบริษัท `vendor/detail.js` จะโหลดข้อมูลแบบ Read-Only จาก 4 API พร้อมกัน (`detail`, `history`, `evaluation`, `groups/by-code`)
3. **Cover Sheet Request**: ผู้ใช้งานไม่สามารถแก้ข้อมูลหลักโดยตรงในหน้า Detail แต่ต้องส่งคำขอผ่าน `/procurement/vendors/create` (โหมด `ADD` หรือ `U` = Update) เพื่อสร้างใบคำขอสถานะ `Running (1)`
4. **Approval Chain (`Buyer → SEM → DEM`)**:
   - หาก **Reject (`3`)**: ส่งกลับให้ Buyer แก้ไขข้อมูลหรือแนบเอกสารเพิ่ม
   - หาก **Approve (`2`)**: บันทึก Revision ลง `PURSYS`, ซิงก์รหัสคู่ค้า 5 หลักไปยัง **AS400** (`AS400: SYNCED`) และเปิดใช้งานร่วมกับระบบ **E-SCM / EDI**

---

## 3. แผนผังการเชื่อมโยงข้อมูล (Data Lineage & ER Diagram)

แผนผังแสดงการเชื่อมโยงตั้งแต่หน้าจอ **Blade + JS → REST API (`APP_API`) → ตาราง Oracle (`PURSYS`) → ระบบภายนอก (AS400 / NAS / E-SCM)**:

<VendorFlowDiagrams diagram="data-lineage" />

### Key Linkage Rules (กุญแจหลักในการเชื่อมโยงข้อมูล)
- **Internal Entity Key (`VND_ID` ↔ `VENDOR_ID`)**:
  - `PUR_VENDORS.VND_ID` (Auto-Identity) เป็น Primary Key หลัก เชื่อมแบบ `1:N` ไปยัง `PUR_VENDORS_ADDRESS`, `PUR_VENDORS_CODE`, และ `PUR_VENDORS_ATTFILE` ผ่านคอลัมน์ `VENDOR_ID`
- **Business / ERP Key (`CODE_NUM` / `VENDCODE` 5 หลัก)**:
  - รหัสคู่ค้า 5 หลัก (เช่น `10000`, `10003`, `19000`) คือ Key กลางที่ Frontend ส่งไปใน API (`/detail/`, `/history/`, `/evaluation/`, `/groups/by-code/`), ใช้ซิงก์กับ **AS400 ERP**, ใช้ผูกกลุ่มบริษัทต่างสกุลเงิน (`VGRP-xxxxx`) และใช้ผูกกับบัญชีผู้ใช้คู่ค้า (`VND_CODE`) ในระบบ E-SCM
- **Multi-Currency Corporate Group (`VGRP-*`)**:
  - บริษัทคู่ค้า 1 แห่งที่มีหลายสกุลเงิน (เช่น `JPY`, `USD`, `THB`) จะมีหลายรหัส 5 หลักใน `PUR_VENDORS_CODE` แต่ถูกจัดกลุ่มร่วมกันภายใต้รหัสกลุ่ม `VGRP-*` โดยกำหนด 1 รหัสเป็น **Primary Code** ผ่าน `/pursys/vendors/groups/set-primary/`
- **Document Storage (`PUR_VENDORS_ATTFILE` ↔ NAS)**:
  - ฐานข้อมูลเก็บเฉพาะ Metadata (`FILE_NAME` ชื่อไฟล์บนดิสก์ และ `UFILE_NAME` ชื่อไฟล์ต้นฉบับ) ส่วนไฟล์จริงจัดเก็บบน NAS ตาม Path `FILE_ATTACH` ใน `.env`

---

## 4. แผนผังการจัดการบัญชีคู่ค้า (E-SCM User Provisioning Flow)

<VendorFlowDiagrams diagram="scm-user-flow" />

- เมื่อสร้างผู้ใช้ใหม่ผ่าน `POST /pursys/vendors/users/` ระบบจะผูกบัญชีเข้ากับ `VND_CODE` และ `USER_ROLE` (Position / Responsibility เช่น Sales, Production, Logistics, QA, Finance, Management) โดยเริ่มที่สถานะ **`Pending Activation (0)`** อัตโนมัติพร้อมลิงก์ยืนยันตัวตนที่มีอายุ **72 ชั่วโมง**
- หลังผ่านขั้นตอนอนุมัติและตั้งรหัสผ่านสำเร็จ สถานะจะเปลี่ยนเป็น **`Active (1)`** โดยได้รับสิทธิ์ E-SCM ร่วมกันทุกรหัสคู่ค้าในกลุ่มบริษัทเดียวกัน (`PURSYS.VENDORS_CODE`)
- หากไม่มีการเข้าสู่ระบบเกิน **90 วัน** หรือผู้ดูแลระบบสั่งระงับ สถานะจะเปลี่ยนเป็น **`Locked / Inactive (2)`** พร้อมบันทึก Audit Trail ทุกครั้ง

---

## 5. โครงสร้างไฟล์ของโมดูล Vendors

```text
procurement/
├── application/
│   ├── controllers/
│   │   └── Vendors.php                    # Controller หลัก (index, list, detail, users)
│   └── views/vendors/
│       ├── index.blade.php                # หน้า Vendor Directory (Buyer / Admin)
│       ├── index/                         # Partial: header, kpi, filters, table, drawer, footer
│       ├── list.blade.php                 # หน้า Approved Vendor List (Indirect & Subcon Read-Only)
│       ├── list/                          # Partial: header, kpi, filters, table, drawer, directives
│       ├── detail.blade.php               # หน้า Vendor Detail (5 Tabs Read-Only)
│       ├── detail/                        # Partial: header, summary, tab-overview, tab-financial,
│       │                                  #          tab-scm, tab-evaluation, tab-history,
│       │                                  #          drawer-diff, drawer-group, directives
│       ├── users.blade.php                # หน้า SCM Users / Vendor Users Management
│       └── users/                         # Partial: header, kpi, filters, table, drawer, modal, directives
├── assets/script/
│   ├── vendor/
│   │   ├── _entry.js                      # Rspack entry points ของโมดูล Vendors
│   │   ├── index.js                       # Entry หน้า Vendor Directory (Export & Coordination)
│   │   ├── index-table.js                 # Logic ตาราง, KPI, Select2 Filters ของ Vendor Directory
│   │   ├── list.js                        # Logic หน้า Approved Vendor List (General Read-Only + Drawer)
│   │   ├── detail.js                      # Logic หน้า Vendor Detail (Tabs, Select2, Group Manager, Diff)
│   │   ├── users.js                       # Logic หน้า Vendor Users (CRUD, Position/Duty, Reset Password)
│   │   ├── create.js / approval.js / frmapv.js  # สคริปต์ฟอร์มคำขอ/อนุมัติ (Legacy / Standalone)
│   │   └── excel-data.js                  # ตัวช่วยแปลงข้อมูลสำหรับ Export Excel
│   └── service/
│       ├── vendors.js                     # API client สำหรับ /pursys/vendors/*
│       ├── vendor-users.js                # API client สำหรับ /pursys/vendors/users/*
│       ├── excel.js                       # Service สร้างและดาวน์โหลดไฟล์ Excel
│       ├── approval.js                    # API client สำหรับคำขออนุมัติ
│       └── country.js / currency.js / payment.js / addressth.js
└── VENDORS.sql, VENDORS_ADDR.sql, VENDORS_CODE.sql, VENDORS_FILE.sql
```

---

## 6. Route → Controller → View → JS Bundle Mapping

อ้างอิงจาก `application/controllers/Vendors.php` และ `assets/script/vendor/_entry.js`:

| URL Route | Controller Method | Blade View | Rspack Bundle (`assets/dist/js/`) | Source JS |
| :--- | :--- | :--- | :--- | :--- |
| `/procurement/vendors` | `Vendors::index()` | `vendors/index` | `vendors.js` | `vendor/index.js` + `index-table.js` |
| `/procurement/vendors/list` | `Vendors::list()` | `vendors/list` | `vendors_list.js` | `vendor/list.js` |
| `/procurement/vendors/detail/{id}` | `Vendors::detail($id)` | `vendors/detail` | `vendors_detail.js` | `vendor/detail.js` |
| `/procurement/vendors/users` | `Vendors::users()` | `vendors/users` | `vendors_users.js` | `vendor/users.js` |

*(หมายเหตุ: เมธอด `create()`, `approval()`, และ `form()` ถูกนำออกจาก `Vendors.php` แล้ว แต่ entry `create.js`, `approval.js`, `frmapv.js` ยังคงอยู่ใน `_entry.js` สำหรับอ้างอิง/ต่อยอด)*

---

## 7. Backend API ที่เรียกใช้งาน

### 7.1 Vendor Master & Group APIs (`assets/script/service/vendors.js`)
เรียกผ่าน `fetchUtils` ไปยัง `${process.env.APP_API}`:

| Service Function | Method | Endpoint | Payload หลัก | การใช้งาน |
| :--- | :---: | :--- | :--- | :--- |
| `getVendors(q)` | `POST` | `/pursys/vendors/search/` | `{}` หรือเงื่อนไขค้นหา | โหลดตารางและคำนวณ KPI หน้า Vendor Directory |
| `getVendorDetail(vndCode)` | `POST` | `/pursys/vendors/detail/` | `{ VENDCODE }` | โหลดข้อมูลหลัก ที่อยู่ เอกสาร และรหัส AS400 |
| `getVendorHistory(vndCode)` | `POST` | `/pursys/vendors/history/` | `{ VENDCODE }` | โหลดประวัติการเปลี่ยนแปลงและข้อมูล Revision Diff |
| `getVendorEvaluation(vndCode)` | `POST` | `/pursys/vendors/evaluation/` | `{ VENDCODE }` | โหลดเกรดประเมินคุณภาพคู่ค้า (EVA) |
| `getVendorGroups(data)` | `POST` | `/pursys/vendors/groups/search/` | `{}` | ค้นหากลุ่มบริษัทคู่ค้า (`VGRP-*`) |
| `getVendorGroupByCode(vndCode)` | `POST` | `/pursys/vendors/groups/by-code/` | `{ VENDCODE }` | ดึงรหัสคู่ค้าต่างสกุลเงินที่อยู่ในเครือเดียวกัน |
| `linkVendorCodes(data)` | `POST` | `/pursys/vendors/groups/link/` | ข้อมูลรหัสที่ต้องการผูก | เชื่อมโยงรหัสคู่ค้าเข้ากลุ่มบริษัท |
| `setPrimaryVendorCode(data)` | `POST` | `/pursys/vendors/groups/set-primary/` | ข้อมูลรหัสหลัก | ตั้งรหัสคู่ค้าหลัก (Primary Code) ของกลุ่ม |
| `unlinkVendorCode(data)` | `POST` | `/pursys/vendors/groups/unlink/` | ข้อมูลรหัสที่ต้องการแยก | ยกเลิกการผูกรหัสคู่ค้าออกจากกลุ่ม |

### 7.2 Vendor Portal Users APIs (`assets/script/service/vendor-users.js`)

| Service Function | Method | Endpoint | Payload / Params | การใช้งาน |
| :--- | :---: | :--- | :--- | :--- |
| `getVendorUsers(data)` | `POST` | `/pursys/vendors/users/search/` | `{}` หรือตัวกรอง | โหลดรายชื่อบัญชี E-SCM ทั้งหมด |
| `createVendorUser(data)` | `POST` | `/pursys/vendors/users/` | ข้อมูลผู้ใช้ + `USER_ROLE` | สร้างบัญชีผู้ใช้งานคู่ค้าใหม่ |
| `updateVendorUser(id, data)` | `PUT` | `/pursys/vendors/users/{id}` | ข้อมูลที่แก้ไข | แก้ไข Role, แผนก หรือสถานะบัญชี |
| `resetVendorUserPassword(id)` | `POST` | `/pursys/vendors/users/{id}/reset-password` | Path param `id` | ส่งลิงก์รีเซ็ตรหัสผ่านให้คู่ค้า |

### 7.3 Approval & Master Lookup Services
- **`assets/script/service/approval.js`**: `getVendorsApv(id)` ปัจจุบันเรียก `${process.env.MOCK_API}/vendorApprovals/${id}`
- **Master Lookups**: `country.js`, `currency.js`, `payment.js`, `addressth.js`, `excel.js` ใช้ดึงข้อมูลประเทศ สกุลเงิน เงื่อนไขชำระเงิน ที่อยู่ไทย และสร้างไฟล์ Excel

---

## 8. โครงสร้างตารางฐานข้อมูลที่เกี่ยวข้อง (Oracle Schema: `PURSYS`)

ความสัมพันธ์หลักใช้ `VND_ID` จาก `PUR_VENDORS` เป็น Foreign Key เชื่อมไปยังตารางลูก (`VENDOR_ID`):

```text
PURSYS.PUR_VENDORS (PK: VND_ID)
 ├── 1:N ──▶ PURSYS.PUR_VENDORS_ADDRESS  (FK: VENDOR_ID, PK: ADDR_ID)
 ├── 1:N ──▶ PURSYS.PUR_VENDORS_CODE     (FK: VENDOR_ID, PK: CODE_ID)  ◀── Sync AS400 (5-Digit Code)
 └── 1:N ──▶ PURSYS.PUR_VENDORS_ATTFILE  (FK: VENDOR_ID, PK: FILE_ID)
```

### 8.1 `PURSYS.PUR_VENDORS` (ตารางทะเบียนคู่ค้าหลัก)
อ้างอิงจาก `VENDORS.sql` — Tablespace `PURSYS`, Primary Key `PK_VENDORS (VND_ID)`:

| Column | Type | Constraint / Default | คำอธิบาย |
| :--- | :--- | :--- | :--- |
| `VND_ID` | `NUMBER` | `PK`, `IDENTITY`, `NOT NULL` | รหัสอ้างอิงภายในของคู่ค้า |
| `VND_NAME` | `VARCHAR2(256)` | `NOT NULL` | ชื่อบริษัทคู่ค้า (ภาษาอังกฤษ) |
| `VND_TNAME` | `VARCHAR2(256)` | — | ชื่อบริษัทคู่ค้า (ภาษาไทย) |
| `VND_SALE` | `VARCHAR2(256)` | — | ชื่อผู้ติดต่อ / พนักงานขาย |
| `VND_TYPE` | `NUMBER` | `NOT NULL`, `DEFAULT 1` | ประเภท / กลุ่มคู่ค้า (1–8) |
| `VND_REGDATE` | `DATE` | `DEFAULT SYSDATE` | วันที่ลงทะเบียนคู่ค้า |
| `VND_LASTUPDATE` | `DATE` | `DEFAULT SYSDATE` | วันที่แก้ไขล่าสุด |
| `VND_STATUS` | `NUMBER` | `DEFAULT 1` | สถานะการใช้งาน (`1` = Active, อื่นๆ = Inactive/Hold) |
| `VND_USERUPDATE` | `NUMBER` | — | รหัสพนักงานที่อัปเดตล่าสุด |
| `ADDR_PHONE` | `VARCHAR2(100)` | — | เบอร์โทรศัพท์ |
| `ADDR_WEB` | `VARCHAR2(100)` | — | เว็บไซต์บริษัท |
| `EMAIL` | `VARCHAR2(90)` | — | อีเมลหลักของคู่ค้า |
| `FAX` | `VARCHAR2(30)` | — | เบอร์แฟกซ์ |
| `BANKNAME` | `VARCHAR2(50)` | — | ชื่อธนาคารสำหรับโอนชำระเงิน |
| `BRANCH` | `VARCHAR2(50)` | — | สาขาธนาคาร |
| `ACCNUMBER` | `VARCHAR2(10)` | — | เลขที่บัญชีธนาคาร |

### 8.2 `PURSYS.PUR_VENDORS_ADDRESS` (ตารางที่อยู่คู่ค้า)
อ้างอิงจาก `VENDORS_ADDR.sql`:

| Column | Type | Constraint | คำอธิบาย |
| :--- | :--- | :--- | :--- |
| `ADDR_ID` | `NUMBER` | `NOT NULL` | รหัสที่อยู่ |
| `VENDOR_ID` | `NUMBER` | `NOT NULL` | อ้างอิง `PUR_VENDORS.VND_ID` |
| `ADDR_TYPE` | `CHAR(1)` | `NOT NULL` | ประเภทที่อยู่ (เช่น สำนักงานใหญ่ / สาขา / จัดส่ง) |
| `ADDR_LINE1` – `ADDR_LINE3` | `VARCHAR2(200)` | `ADDR_LINE1 NOT NULL` | รายละเอียดที่อยู่บรรทัดที่ 1–3 |
| `ADDR_SUB_CITY` | `VARCHAR2(100)` | — | แขวง / ตำบล |
| `ADDR_CITY` | `VARCHAR2(100)` | — | เขต / อำเภอ / เมือง |
| `ADDR_STATE` | `VARCHAR2(100)` | — | จังหวัด / รัฐ |
| `ADDR_COUNTRY` | `VARCHAR2(200)` | — | ประเทศ |
| `ADDR_ZIPCODE` | `VARCHAR2(50)` | — | รหัสไปรษณีย์ |

### 8.3 `PURSYS.PUR_VENDORS_CODE` (ตารางรหัสคู่ค้า 5 หลัก & เงื่อนไขการค้า)
อ้างอิงจาก `VENDORS_CODE.sql` — Primary Key `PK_VENDORS_CODE (CODE_ID)`:

| Column | Type | Constraint / Default | คำอธิบาย |
| :--- | :--- | :--- | :--- |
| `CODE_ID` | `NUMBER` | `PK`, `IDENTITY`, `NOT NULL` | รหัสอ้างอิงรายการ |
| `CODE_NUM` | `NUMBER` | `NOT NULL` | รหัสคู่ค้า 5 หลัก (เช่น `10000`, `10003`, `19000`) ที่ซิงก์กับ AS400 |
| `VENDOR_ID` | `NUMBER` | — | อ้างอิง `PUR_VENDORS.VND_ID` |
| `CODE_STATUS` | `NUMBER` | `NOT NULL`, `DEFAULT 1` | สถานะของรหัสคู่ค้า |
| `CODE_REGDATE` | `DATE` | — | วันที่ออกรหัส |
| `CODE_CURRENCY` | `CHAR(3)` | — | รหัสสกุลเงิน ISO 3 หลัก (`JPY`, `USD`, `THB`) |
| `CODE_SHIP` | `NUMBER` | — | เงื่อนไขการจัดส่ง (Shipping Term / Method) |
| `CODE_PAY` | `VARCHAR2(8)` | — | เงื่อนไขการชำระเงิน (Payment Term เช่น `C2`) |
| `CODE_TYPE` | `NUMBER` | — | ประเภทรหัส / กลุ่มย่อย |

### 8.4 `PURSYS.PUR_VENDORS_ATTFILE` (ตารางเอกสารแนบคู่ค้า)
อ้างอิงจาก `VENDORS_FILE.sql` — Primary Key `PK_VENDORS_ATTFILE (FILE_ID)`:

| Column | Type | Constraint | คำอธิบาย |
| :--- | :--- | :--- | :--- |
| `FILE_ID` | `NUMBER` | `PK`, `IDENTITY`, `NOT NULL` | รหัสไฟล์แนบ |
| `VENDOR_ID` | `NUMBER` | `NOT NULL` | อ้างอิง `PUR_VENDORS.VND_ID` |
| `FILE_NAME` | `VARCHAR2(30)` | `NOT NULL` | ชื่อไฟล์ที่จัดเก็บจริงบน NAS (`FILE_ATTACH` ใน `.env`) |
| `UFILE_NAME` | `VARCHAR2(256)` | `NOT NULL` | ชื่อไฟล์ต้นฉบับตอนอัปโหลด |

### 8.5 ตาราง/ระบบภายนอกที่เชื่อมโยงเพิ่มเติม
- **`PURSYS.VENDORS` (Master Registry / AS400 Sync)**: ตารางหลักฝั่ง Backend API ที่รวมข้อมูลจาก AS400, Tax ID, CA/BA No. และสถานะ Sync (`PRO`, `AS400`, `E-SCM`)
- **Vendor Group & Linkage (`VGRP-*`)**: เก็บความสัมพันธ์ของรหัสคู่ค้าหลายสกุลเงินภายใต้บริษัทแม่เดียวกัน
- **Vendor Evaluation (`EVA`) & Change History**: เก็บประวัติคะแนนประเมินประจำปีและ Revision Log ของ Cover Sheet
- **E-SCM Portal Users (`AMEC-EDI`)**: เก็บข้อมูลบัญชีคู่ค้า, `USER_ROLE` (`ADMIN`, `SALES`, `LOGISTICS`, `QA`), สถานะ และประวัติการเข้าสู่ระบบ

---

## 9. คำสั่งสำหรับพัฒนาและ Build

```bash
# พัฒนาพร้อม Watch CSS (Tailwind) + JS (Rspack)
npm run watch

# Build Production Assets (CSS + JS)
npm run build

# พัฒนาและทดสอบเอกสาร VitePress
npm run docs:dev

# Build เอกสารลง docs/dist/
npm run docs:build
```

---

## 10. จุดที่ต้องปรับปรุงและข้อควรระวัง (Known Issues & Roadmap)

::: warning รายการที่ควรแก้ไขในการพัฒนารอบถัดไป
1. **Backend Endpoint สำหรับ SCM Users**: `POST /pursys/vendors/users/search/` ยังตอบ `404 Not Found` บน API Server ฝั่ง Local (`localhost:3001`) ต้อง Implement Route ฝั่ง Backend เพิ่มเติม
2. **ย้าย Approval API ออกจาก Mock**: `assets/script/service/approval.js` ยังชี้ไปที่ `process.env.MOCK_API` ควรเปลี่ยนมาใช้ `process.env.APP_API` และผูกเส้นทาง Webflow/Cover Sheet ให้สมบูรณ์
3. **ความยาวฟิลด์ `ACCNUMBER`**: ใน `PUR_VENDORS` กำหนด `ACCNUMBER VARCHAR2(10)` หากมีเลขบัญชีต่างประเทศหรือบัญชี 12–16 หลัก ควรขยายขนาดคอลัมน์ก่อนรองรับคู่ค้าต่างประเทศเพิ่มเติม
4. **ล้าง Entry เก่าใน `_entry.js`**: หากไม่มีแผนใช้งานหน้า `create`, `approval`, `frmapv` แบบ Standalone ใน CI3 แล้ว สามารถลบออกจาก `assets/script/vendor/_entry.js` เพื่อลดเวลา Build ของ Rspack
:::
