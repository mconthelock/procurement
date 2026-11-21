@include('components.page-header', [
    'systemTag' => 'AMEC-PRO-SYS-TH',
    'title' => 'Vendor Directory',
    'description' =>
        'ทะเบียนรายชื่อคู่ค้าทั้งหมด • Official registry of approved tier-1 manufacturing fabricators, electrical component suppliers, precision casting specialists, and logistics partners for AMEC Chonburi Works. Governed by Japanese industrial safety and ISO/J-SOX quality mandates.',
    'actionsList' => [
        [
            'label' => 'Download Approved List (.PDF)',
            'icon' => 'download',
            'variant' => 'default',
            'type' => 'button',
            'onclick' => "alert('Downloading Official Approved Vendor List (.PDF)...')",
        ],
        [
            'label' => 'Export Ledger (.CSV)',
            'icon' => 'table_view',
            'variant' => 'default',
            'type' => 'button',
            'onclick' => "alert('Exporting Vendor Ledger (.CSV)...')",
        ],
        [
            'label' => '+ Register New Vendor',
            'icon' => 'person_add',
            'variant' => 'primary',
            'type' => 'button',
            'href' => $_ENV['APP_ENV'] . '/Vendors/create',
        ],
    ],
])
