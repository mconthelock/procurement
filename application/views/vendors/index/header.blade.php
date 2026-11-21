<!-- Section 1: Standard Page Header Component -->
@include('components.page-header', [
    'systemTag' => 'AMEC-PRO-SYS-TH',
    'title' => 'Vendor Directory',
    'description' => 'ทะเบียนรายชื่อคู่ค้าทั้งหมด • Official registry of approved suppliers',
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
