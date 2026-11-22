---
title: Quick Start & System Overview
roles: ['*']
outline: deep
---

# ภาพรวมระบบ AMEC Procurement System (PUR-008P)

**AMEC Procurement System** คือระบบบริหารจัดการงานจัดซื้อจัดจ้างและซัพพลายเชนแบบครบวงจร (End-to-End Procurement & Supply Chain Management) สำหรับ **Mitsubishi Elevator Asia Co., Ltd. (AMEC)** เพื่อเชื่อมโยงกระบวนการขอซื้อ การออกใบสั่งซื้อ การรับสินค้า การจัดการสินค้าคงคลัง ทะเบียนคู่ค้า และรายงานตรวจสอบให้ทำงานสอดคล้องกันตามมาตรฐาน **ISO 27001 / J-SOX / PRO-QP-A-020**

---

## 1. โมดูลหลักของระบบ (Core Modules)

| โมดูล | หน้าที่หลัก | ผู้ใช้งานหลัก |
| :--- | :--- | :--- |
| **P/R Management** | สร้างใบขอซื้อ (Purchase Requisition), ติดตามสถานะเอกสารของตนเอง และพิจารณาอนุมัติใบขอซื้อ | Requester, Approver, Buyer |
| **P/O Management** | ออกใบสั่งซื้อ (Purchase Order), อนุมัติ P/O, ติดตามสินค้าค้างส่ง (Awaiting Delivery) และจัดการ P/O ที่ถูกยกเลิก | Buyer, Approver |
| **Receiving** | บันทึกการรับสินค้าเข้าคลัง (WH Receive), แผนการรับสินค้า (Receiving Plan) และตรวจสอบใบแจ้งหนี้/ใบกำกับภาษี (Invoice/Tax) | Warehouse, Accounting, Buyer |
| **Products & Inventory** | จัดการข้อมูลรายการสินค้า (Product List / Item Master) และหมวดหมู่สินค้า (Category) | Buyer, Warehouse |
| **Vendor Management** | ทะเบียนรายชื่อคู่ค้า (Vendor Directory), ขออนุมัติขึ้นทะเบียน/แก้ไขคู่ค้า (Cover Sheet) และจัดการบัญชีคู่ค้าบน E-SCM Portal | Buyer, Approver, Admin |
| **Report** | รายงานการสั่งซื้อ, รายงานการรับสินค้า, รายงาน Matching (PO-Receive-Invoice), สินค้าคงคลัง และรายการคำสั่งซื้อที่กำลังดำเนินการ | Buyer, Approver, Accounting, Warehouse |

---

## 2. ภาพรวมกระบวนการทำงาน (End-to-End Procurement Flow)

```text
[1. P/R Management]        [2. P/O Management]        [3. Receiving & QC]        [4. Matching & Report]
สร้างใบขอซื้อ & อนุมัติ  ──▶  ออกใบสั่งซื้อ & ส่งคู่ค้า  ──▶  รับสินค้าเข้าคลัง & Invoice  ──▶  ตรวจสอบ Matching & รายงาน
                                    ▲
                                    │ ข้อมูลคู่ค้า & สินค้า
                     [Vendor Management & Product Master]
                     (ซิงก์ข้อมูลกับ AS400 ERP & E-SCM Portal)
```

---

## 3. การเริ่มต้นใช้งาน (Getting Started)

### 3.1 การเข้าสู่ระบบ
1. เข้าสู่ระบบหลักผ่าน **AMEC Webflow Authentication** (หรือคลิกปุ่ม **Login** ที่มุมขวาบนของแถบเมนูเอกสาร)
2. ระบบจะตรวจสอบสิทธิ์ผู้ใช้งาน (`GROUP_CODE`) จากบัญชีพนักงานของคุณโดยอัตโนมัติ
3. เมื่อเข้าสู่ระบบแล้ว ป้ายบทบาท (**Role Badge**) ที่มุมขวาบนจะแสดงบทบาทและรหัสพนักงานของคุณ พร้อมเปิดแสดงเมนูเอกสารที่เกี่ยวข้องกับหน้าที่งานของคุณโดยอัตโนมัติ

### 3.2 การเชื่อมโยงกับระบบภายนอก
- **AS400 ERP**: ซิงก์ข้อมูลหลักรหัสคู่ค้า 5 หลัก (`VENDCODE`), เงื่อนไขชำระเงิน และข้อมูลใบสั่งซื้อ
- **E-SCM / EDI Supplier Portal**: ช่องทางให้คู่ค้าภายนอกรับ P/O, แจ้งส่งมอบสินค้า (ASN), ตอบเคลมคุณภาพ (CAR) และดาวน์โหลดแบบวิศวกรรม
- **AMEC Webflow**: ระบบยืนยันตัวตนกลาง (Single Sign-On) และแจ้งเตือนสายการอนุมัติ

---

## 4. สิทธิ์การเข้าถึงเอกสารตามบทบาทผู้ใช้งาน (Role-Based Access)

เอกสารคู่มือนี้แยกการแสดงผลตามบทบาทผู้ใช้งานที่เข้าสู่ระบบ หากไม่ได้เข้าสู่ระบบจะได้รับสิทธิ์เป็น **Guest** โดยอัตโนมัติ:

| บทบาท (Role) | สิทธิ์การเข้าถึงคู่มือ |
| :--- | :--- |
| **Guest** *(ยังไม่เข้าสู่ระบบ)* | ดูได้เฉพาะหน้า **Home**, **Quick Start** และ **Change Log** |
| **Requester** | P/R Management (สร้างและติดตาม P/R ของตนเอง) |
| **Approver** | P/R & P/O Approval, Approving Vendor และรายงานการสั่งซื้อ |
| **Buyer** | P/R, P/O, Receiving, Products, Vendor Management และรายงานทั้งหมด |
| **Warehouse** | Receiving (WH Receive / Plan), Products & Inventory และรายงานคลังสินค้า |
| **Accounting** | Receiving (Invoice/Tax) และรายงาน Matching / Receiving |
| **Admin** | เข้าถึงคู่มือได้ทุกหมวด รวมถึงเอกสาร **Technical Specification** สำหรับทีมพัฒนา |

::: tip ติดตามการอัปเดตของระบบ
สามารถดูประวัติการเพิ่มฟีเจอร์ การปรับปรุง และการแก้ไขบั๊กของระบบทั้งหมดได้ที่หน้า [Change Log](/changelog)
:::
