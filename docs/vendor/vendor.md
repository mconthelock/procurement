---
title: Vendor List (ทะเบียนรายชื่อคู่ค้า)
roles: ['ADMIN', 'BUYER']
outline: deep
---

# Vendor Directory (ทะเบียนรายชื่อคู่ค้า)

หน้า **Vendor Directory** (`/procurement/vendors`) คือศูนย์กลางข้อมูลทะเบียนคู่ค้าและผู้รับเหมาช่วง (Approved Suppliers & Sub-Contractors) ทั้งหมดของระบบ AMEC Procurement ตามมาตรฐาน **PRO-QP-A-020**

<AnnotatedImage
  src="/images/vendor/vendor-directory.png"
  alt="หน้าจอ Vendor Directory"
  caption="ภาพรวมหน้าจอ Vendor Directory — ชี้เมาส์หรือคลิกที่หมายเลขเพื่อดูคำอธิบายแต่ละส่วน"
  :markers="[
    { x: 11, y: 39, title: 'เมนูหมวด Vendors (Sidebar)', desc: 'แถบเมนูหลักด้านซ้ายสำหรับเข้าสู่หน้า Vendors Directory และ SCM Users' },
    { x: 78, y: 13, title: 'แถบปุ่มคำสั่งหลัก (Action Toolbar)', desc: 'ปุ่มส่งออกข้อมูล (.CSV / .XLSX) และปุ่ม + Register New Vendor เพื่อขึ้นทะเบียนคู่ค้าใหม่' },
    { x: 52, y: 34, title: 'แถบ KPI ภาพรวม (Summary KPI Ribbon)', desc: 'สรุปยอดคู่ค้าทั้งหมด สัดส่วนในประเทศ/ต่างประเทศ ผู้รับเหมาช่วง และความครบถ้วนของ Tax ID / CA / BA' },
    { x: 55, y: 49, title: 'แท็บสถานะและตัวกรอง (Tabs & Filter Strip)', desc: 'สลับดูตามสถานะ/ประเภทคู่ค้า ค้นหาด้วยคำสำคัญ กรองตาม Vendor Group 1–8, Country, Currency และรีเซ็ตตัวกรอง' },
    { x: 55, y: 74, title: 'ตารางทะเบียนคู่ค้า (Vendor Table)', desc: 'แสดงรหัสคู่ค้า 5 หลัก กลุ่ม ชื่อบริษัท หมวดสินค้า Tax ID/CA/BA สกุลเงิน และที่อยู่ คลิกเพื่อเปิดหน้า Vendor Detail' }
  ]"
/>

---

## 1. แถบสรุปข้อมูลภาพรวม (KPI Ribbon)

ด้านบนของหน้าแสดง KPI 4 รายการ เพื่อติดตามภาพรวมฐานข้อมูลคู่ค้าแบบเรียลไทม์:

| KPI | คำอธิบาย |
| :--- | :--- |
| **Total Registered Vendors** | จำนวนคู่ค้าทั้งหมดในระบบ แยกเป็น **Active** (พร้อมใช้งาน) และ **Inactive / Hold** (ระงับชั่วคราว) พร้อมสัดส่วน `% ACTIVE` |
| **Domestic / Overseas Mix** | สัดส่วนคู่ค้าในประเทศ vs ต่างประเทศ และจำนวนประเทศที่ครอบคลุม |
| **Subcon & Non-Production** | จำนวนผู้รับเหมาช่วง (กลุ่ม 8) คู่ค้ากลุ่ม Non-Production และจำนวนสกุลเงินที่ผูกไว้ |
| **Master Completeness** | เปอร์เซ็นต์ความครบถ้วนของเลขประจำตัวผู้เสียภาษี (**Tax ID Verified**) และจำนวนคู่ค้าที่มีสัญญา **CA / BA No.** |

---

## 2. การค้นหาและกรองข้อมูลคู่ค้า

### แท็บสถานะและกลุ่มคู่ค้า (Status Tabs)
สามารถสลับมุมมองตารางได้อย่างรวดเร็วผ่านแถบแท็บ:
- **All Vendors**: คู่ค้าทั้งหมด
- **Active Approved**: คู่ค้าที่ได้รับอนุมัติและพร้อมออก P/O
- **Inactive / Hold**: คู่ค้าที่ถูกระงับการใช้งาน
- **Domestic (3, 4, 5, 7)**: คู่ค้าในประเทศ
- **Overseas (1, 2, 6, 9)**: คู่ค้าต่างประเทศ
- **Subcontractor (8)**: ผู้รับเหมาช่วง

### ตัวกรองละเอียด (Filter Strip)
- **ช่องค้นหา (Search)**: ค้นหาได้จากรหัสคู่ค้า (Vendor Code), ชื่อบริษัท, เลขผู้เสียภาษี (Tax ID), หมวดหมู่, ผู้ติดต่อ หรือเมือง/จังหวัด
- **Vendor Group (1–8)**: กรองตามกลุ่มคู่ค้าหลักของ AMEC:
  1. `1` — Overseas (MELCO Group)
  2. `2` — Overseas (Non-MELCO)
  3. `3` — Domestic BOI
  4. `4` — Domestic IPO
  5. `5` — Domestic Vendor
  6. `6` — Non-Production (AMEC PO)
  7. `7` — Domestic FTA Privilege
  8. `8` — Sub-Contractor
- **Country & Currency**: กรองตามประเทศและสกุลเงินที่ทำการซื้อขาย
- ปุ่ม **Reset Filters** (ไอคอนลูกศรวน) เพื่อล้างเงื่อนไขการกรองทั้งหมด

---

## 3. การส่งออกข้อมูลและลงทะเบียนคู่ค้าใหม่

ที่มุมขวาบนของหน้า Vendor Directory มีปุ่มคำสั่งหลัก 3 รายการ:
1. **Export Approved List (.CSV)** — ส่งออกรายชื่อคู่ค้าที่ผ่านการกรองเป็นไฟล์ `.csv`
2. **Export Excel (.XLSX)** — ส่งออกข้อมูลคู่ค้าแบบละเอียดเป็นไฟล์ Excel
3. **+ Register New Vendor** — เปิดหน้าฟอร์ม (`/procurement/vendors/create`) เพื่อยื่นคำขอขึ้นทะเบียนคู่ค้าใหม่เข้าสู่ขั้นตอนการอนุมัติ

---

## 4. หน้ารายละเอียดคู่ค้า (Vendor Detail)

เมื่อคลิกเลือกคู่ค้าจากตาราง ระบบจะเปิดหน้า **Vendor Detail** (`/procurement/vendors/detail/{id}`) ในโหมด **Read-Only Official Record** แบ่งข้อมูลออกเป็น 5 แท็บหลัก:

<AnnotatedImage
  src="/images/vendor/vendor-detail.png"
  alt="หน้าจอ Vendor Detail"
  caption="ภาพรวมหน้าจอ Vendor Detail — แสดงข้อมูลระบุตัวตน กลุ่มบริษัทในเครือ สถานะซิงก์ระบบ และสายอนุมัติ"
  :markers="[
    { x: 24, y: 26, title: 'ส่วนหัวข้อมูลคู่ค้า (Vendor Identity)', desc: 'แสดงรหัสคู่ค้า 5 หลัก ชื่อบริษัท ป้ายสถานะ (ACTIVE / DIRECT / 1099) เลขผู้เสียภาษี/Swift และหมวดสินค้า' },
    { x: 34, y: 37, title: 'ปุ่มคำสั่งจัดการข้อมูล (Actions)', desc: 'ปุ่ม Request Update (Cover Sheet) สำหรับส่งคำขอแก้ไขข้อมูล, Request Delete, Export และปุ่มย้อนกลับ' },
    { x: 76, y: 47, title: 'กลุ่มบริษัทที่เชื่อมโยง (Corporate Group)', desc: 'แสดงรหัสกลุ่ม (VGRP) และรหัสคู่ค้าต่างสกุลเงินในเครือเดียวกัน พร้อมปุ่ม Manage Group / Link Codes' },
    { x: 26, y: 62, title: 'รหัสคู่ค้าและผลประเมิน (Code & EVA)', desc: 'แสดง Vendor Code 5 หลัก กลุ่มคู่ค้า สกุลเงินหลัก และเกรดประเมินคุณภาพคู่ค้าประจำปีงบประมาณ' },
    { x: 50, y: 84, title: 'สถานะซิงก์และประวัติการแก้ไข (Sync & Monitoring)', desc: 'แสดงสถานะซิงก์กับ PRO / AS400 / E-SCM วันเวลาอัปเดตล่าสุด และสายการอนุมัติ (Buyer → SEM → DEM)' }
  ]"
/>

1. **Overview, Address & Documents**
   - ข้อมูลทั่วไปของบริษัท ที่อยู่สำนักงานใหญ่/สาขา และเอกสารแนบแยกตามหมวดหมู่ (เช่น หนังสือรับรองบริษัท, ภ.พ.20, สัญญา CA/BA)
2. **Financial & AS400**
   - ข้อมูลบัญชีธนาคาร เงื่อนไขการชำระเงิน (Payment Terms) สกุลเงิน และรหัสคู่ค้าที่ซิงก์กับระบบ **AS400**
3. **E-SCM Contacts**
   - รายชื่อผู้ติดต่อและบัญชีผู้ใช้งาน E-SCM Portal ของคู่ค้ารายนั้น พร้อมลิงก์ไปจัดการต่อที่หน้า [SCM Users](/vendor/users)
4. **Evaluation & Compliance**
   - ผลประเมินคุณภาพและเกรดของคู่ค้า (Evaluation Grade) รวมถึงสถานะการปฏิบัติตามมาตรฐาน ISO / J-SOX
5. **Change History & Monitoring**
   - ประวัติการขอแก้ไขข้อมูลทั้งหมด พร้อมปุ่มเปิด **Revision Diff Drawer** เพื่อเปรียบเทียบค่าเดิมกับค่าใหม่แบบทีละฟิลด์

::: info การแก้ไขข้อมูลคู่ค้า (PRO-QP-A-020)
ข้อมูลในหน้า Vendor Detail เป็นแบบ **Read-Only** เพื่อควบคุมการเปลี่ยนแปลงตามมาตรฐาน ISO / J-SOX หากต้องการแก้ไขข้อมูลคู่ค้า ให้คลิกปุ่ม **Request Update (Cover Sheet)** ที่แถบด้านล่าง เพื่อส่งคำขอแก้ไขเข้าสู่ขั้นตอนการอนุมัติในหน้า [Approving Vendor](/vendor/approve)
:::

<RoleOnly :roles="['ADMIN']">

::: tip สำหรับผู้ดูแลระบบ (Admin)
ผู้ดูแลระบบสามารถตรวจสอบและจัดการการจัดกลุ่มคู่ค้าเพิ่มเติมผ่าน **Vendor Group Manager Drawer** ในหน้า Vendor Detail รวมถึงตรวจสอบสิทธิ์การซิงก์ข้อมูลระหว่าง AS400 และ E-SCM ได้
:::

</RoleOnly>
