<!-- Section 1: Standard Page Header Component -->
@include('components.page-header', [
    'systemTag' => 'AMEC-PRO-SYS-TH',
    'title' => 'Vendor Directory',
    'description' => 'ทะเบียนรายชื่อคู่ค้าทั้งหมด • Official registry of approved suppliers &amp; sub-contractors',
    'actionsList' => [
        [
            'label' => 'Export Approved List',
            'icon' => 'download',
            'variant' => 'default',
            'type' => 'button',
            'id' => 'btn-export-csv',
        ],
        [
            'label' => 'Export Excel',
            'icon' => 'table_view',
            'variant' => 'default',
            'type' => 'button',
            'id' => 'export-vendor',
        ],
        // [
        //     'label' => '+ Register New Vendor',
        //     'icon' => 'person_add',
        //     'variant' => 'primary',
        //     'type' => 'button',
        //     'href' => $_ENV['APP_ENV'] . '/Vendors/create',
        // ],
    ],
])
