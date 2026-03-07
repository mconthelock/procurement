@extends('layouts/template')

@section('contents')
    <h1>ทดสอบภาษาไทย</h1>
    <p>
        いろはにほへと ちりぬるを
        わかよたれそ つねならむ
        うゐのおくやま けふこえて
        あさきゆめみし ゑひもせす
    </p>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/home.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
