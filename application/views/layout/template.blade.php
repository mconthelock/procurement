<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="base_url" content="{{ base_url() }}">
    <meta name="base_uri" content="{{ 'https://' . $_SERVER['HTTP_HOST'] }}">
    <meta name="theme-color" content="#C0C0C0">
    <link rel="shortcut icon" href="{{ base_url() }}assets/images/favicon.ico?ver={{ date('YmdHis') }}">
    <link rel="apple-touch-icon" href="{{ base_url() }}assets/images/favicon.ico?ver={{ date('YmdHis') }}">
    <link rel="apple-touch-startup-image" href="{{ base_url() }}assets/images/icon_512.png">
    <title>Test</title>
    <link rel="stylesheet" href="{{ $GLOBALS['cdn'] }}icofont/icofont.min.css">
    <link rel="stylesheet" href="{{ $_ENV['APP_CSS'] }}/tailwind.css?ver={{ $GLOBALS['version'] }}">


    @section('styles')
    @show
</head>

<body class="flex flex-col min-h-screen bg-white" menu="{{ $menu ?? '' }}">
    <div class="user-data" empno="{{ $empno ?? '' }}"></div>
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col items-center justify-start w-full h-full">
            <!-- Page content here -->
            <div class="flex-1 flex flex-col w-full p-4 md:p-8">
                bay
                test
                @yield('contents')
            </div>
        </div>
    </div>

    {{-- <script src="{{ $_ENV['APP_JS'] }}/main.js?ver={{ $GLOBALS['version'] }}"></script> --}}
    @section('scripts')
    @show
</body>

</html>
