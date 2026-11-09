@include('components.page-header', [
    'systemTag' => 'AMEC-PRO-SYS-TH',
    'title' => 'Vendor Directory',
    'description' =>
        'ทะเบียนรายชื่อคู่ค้าทั้งหมด • Official registry of approved tier-1 manufacturing fabricators, electrical component suppliers, precision casting specialists, and logistics partners for AMEC Chonburi Works. Governed by Japanese industrial safety and ISO/J-SOX quality mandates.',
    'actionsList' => [
        [
            'label' => 'Export XLS / CSV',
            'icon' => 'download',
            'variant' => 'default',
            'type' => 'button',
        ],
        [
            'label' => 'Bulk Acknowledge (ยืนยัน)',
            'icon' => 'checklist_rtl',
            'variant' => 'default',
            'type' => 'button',
            'onclick' => 'bulkAcknowledgeModal()',
        ],
        [
            'label' => '+ Create ASN',
            'icon' => 'add_box',
            'variant' => 'default',
            'type' => 'button',
            'onclick' => 'openASNDrawer()',
        ],
    ],
])
