<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', '学习宝') - xxb 学习宝</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Forum - Responsive HTML5 Template">
    <meta name="author" content="Forum">
    <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.ico') }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/compatible.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font/iconfont.css') }}">
</head>
<body>
<!-- tt-mobile menu -->
@include('layouts._header')
<main id="tt-pageContent" class="tt-offset-small {{ route_class() }}-page">
    @include('layouts._user_bar')
    <div class="container">
        @yield('content')
    </div>
</main>
@include('layouts._setting')

@include('layouts._footer')
<script src="{{ asset('assets/js/bundle.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script !src="">
    $(function () {
        // 用户头像背景颜色
        let username = '{{ auth()->user()->username }}';
        let color = text2Img(username);
        $('.user-avatar').css('background-color', color);
    });
    // 文本转颜色
    function text2Img(text) {
        var str = "";
        for(var i = 0; i < text.length; i ++) {
            str += parseInt(text[i].charCodeAt(0), 10).toString(16);
        }
        return '#' + str.slice(1, 4);
    };
    $(function () {
        $('.logout').click(function () {
            alert('11')
        });
    })
</script>
@yield('scriptsAfterJs')
</body>
</html>
