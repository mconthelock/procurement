CREATE TABLE product_lots (
    lot_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    lot_number VARCHAR(100) NOT NULL,
    mfg_date DATE NULL,                                -- วันที่ผลิต
    expiry_date DATE NULL,                             -- วันหมดอายุ (สำหรับดึงข้อมูล FEFO)
    received_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- วันที่รับเข้า (สำหรับดึงข้อมูล FIFO)
    is_active BOOLEAN DEFAULT TRUE,

    -- Foreign Key
    FOREIGN KEY (product_id) REFERENCES products(product_id),

    -- สินค้ารหัสเดียวกันต้องไม่มีเลข Lot ซ้ำกัน
    UNIQUE (product_id, lot_number)
);

-- สร้าง Index เพื่อความเร็วในการเรียงลำดับตัดสต็อก FIFO / FEFO
CREATE INDEX idx_lots_expiry ON product_lots(expiry_date);
CREATE INDEX idx_lots_received ON product_lots(received_date);

CREATE TABLE inventory_balances (
    balance_id INT AUTO_INCREMENT PRIMARY KEY,
    warehouse_id INT NOT NULL,
    product_id INT NOT NULL,
    lot_id INT NULL,                                   -- สามารถเป็น NULL ได้ สำหรับสินค้าที่ไม่คุม Lot
    quantity DECIMAL(12, 4) DEFAULT 0.0000,            -- จำนวนคงเหลือที่ใช้ได้
    reserved_quantity DECIMAL(12, 4) DEFAULT 0.0000,   -- จำนวนที่ถูกจองไว้ (รอจ่ายออก)
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Foreign Keys
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(warehouse_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (lot_id) REFERENCES product_lots(lot_id),

    -- ป้องกันการเกิดข้อมูลซ้ำซ้อนของสินค้ารายการเดียวกัน ล็อตเดียวกัน ในคลังเดียวกัน
    UNIQUE (warehouse_id, product_id, lot_id)
);

-- สร้าง Index เพื่อให้การ Query หายอดคงเหลือเพื่อตัดสต็อกทำได้ไวขึ้น
CREATE INDEX idx_balance_lookup ON inventory_balances(warehouse_id, product_id, quantity);

-- ส่วนหัวเอกสาร (แถมให้เพื่อให้โครงสร้าง Foreign Key สมบูรณ์)
CREATE TABLE stock_movements (
    movement_id INT AUTO_INCREMENT PRIMARY KEY,
    document_no VARCHAR(50) NOT NULL UNIQUE,           -- เลขที่เอกสาร
    movement_type VARCHAR(20) NOT NULL,                -- เช่น 'RECEIVE', 'ISSUE', 'TRANSFER'
    source_warehouse_id INT NULL,                      -- คลังต้นทาง
    destination_warehouse_id INT NULL,                 -- คลังปลายทาง
    status VARCHAR(20) DEFAULT 'PENDING',              -- สถานะเอกสาร
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (source_warehouse_id) REFERENCES warehouses(warehouse_id),
    FOREIGN KEY (destination_warehouse_id) REFERENCES warehouses(warehouse_id)
);

-- รายการสินค้าในเอกสาร (ระบุ Lot)
CREATE TABLE stock_movement_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    movement_id INT NOT NULL,
    product_id INT NOT NULL,
    lot_id INT NULL,                                   -- ระบุว่าเบิก/รับ/ย้าย ของจาก Lot ไหน
    quantity DECIMAL(12, 4) NOT NULL,                  -- จำนวนที่เคลื่อนไหว
    unit_cost DECIMAL(15, 2) NULL,                     -- ต้นทุน ณ วันที่ทำรายการ (สำหรับการเงิน)
    remark TEXT,

    -- หากเอกสารถูกลบ ให้ลบรายการทิ้งด้วย (ON DELETE CASCADE)
    FOREIGN KEY (movement_id) REFERENCES stock_movements(movement_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (lot_id) REFERENCES product_lots(lot_id)
);