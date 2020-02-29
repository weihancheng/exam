<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>学习宝v2</title>
    <meta name="description" content="login page">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('assets/images/bg.png') }}');
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-color: #2b4b6b;
        }

        .text {
            width: 480px;
            border-radius: 5px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: #ffffd5;
            text-align: center;
            padding: 20px;
        }

        .text h1 {
            height: 80px;
            line-height: 80px;
            font-size: 40px;
        }

        .text span {
            font-size: 15px;
        }

        .tabbable {
            width: 350px;
            border-radius: 5px;
            position: absolute;
            left: 82%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: #ffffff;
        }

        .tab-content .tab-pane{
            padding: 20px;
        }
    </style>
</head>

<body>
<div>
    <div class="text">
        <h1>考试培训系统 (学习宝)</h1>
        <span>文档学习，考试培训，考题分析，题目收藏好帮手</span>
    </div>

    <div class="tabbable">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">登录&注册</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">建议&Bug</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">手机登录</a>
            </div>
        </nav>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                @include('layouts._validate')
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">用户名</label>
                        <input type="text" required name="username" class="form-control" aria-describedby="emailHelp" placeholder="请输入用户名">
                        <small id="emailHelp" class="form-text text-muted">用户名可以为 手机号 / 真实姓名 / 身份证</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">密码框</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="请输入密码">
                    </div>
                    <button type="submit" class="btn btn-primary">登录</button>
                </form>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">您的反馈对我们十分重要</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">登录</button>
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                <div style="text-align: center">
                    <p class="text-center" style="font-size: 18px; padding-top: 10px">微信扫一扫</p>
                    <img src="{{ asset('assets/images/mobile-login.png') }}" style="padding-bottom: 20px">
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
