<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <link href="/Public/appm/css/mui.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/Public/appm/css/common.css">

        <script src="/Public/appm/js/jquery-1.11.0.js"></script>
        <script src="/Public/appm/js/mui.min.js"></script>
        <script type="text/javascript">
            //启用双击监听
            mui.init({
                gestureConfig: {
                    doubletap: true
                },
            });
        </script>
        <?php echo ($Assigndata); ?>
        <script src="/Public/appm/js/common.js"></script>
        <script src="/Public/appm/js/login.js"></script>
    </head>

    <body>
        <nav class="mui-bar login-bg" style="background-image: url(/Public/appm/img/bg.png);">
            <div class="logo">
                <img src="/Public/appm/img/logo.png">
            </div>
            <div class="logo-form">
                <div class="login-ts"></div>
                <div class="login-user login-icon-user">
                    <input type="text" class="login-input" id="loginUser" placeholder="请输入您的用户名" style="margin: 0px;background-color: #faffd7;border: 0;border-left: 2px solid #a7bf23;padding-top:0px;padding-bottom:0px;height: 30px;">
                </div>

                <div class="login-user login-icon-pwd">
                    <input type="password" class="mui-input-password" id="loginPwd" placeholder="请输入您的密码" style="margin: 0px;background-color: #faffd7;border: 0;border-left: 2px solid #a7bf23;padding-top:0px;padding-bottom:0px;height: 30px;">
                </div>

                <div class="mui-button-row">
                    <div class="login-btn" onclick="subLogin()">登录</div>
                </div>

                <div class="login-bz">
                    <a href="javascript:void(0)" style="float: left;" onclick="aHref('/index.php/Appm/Login/register')">注册</a>
                    <a href="javascript:void(0)" style="float: right;" onclick="aHref('/index.php/Appm/Login/findpwd')">忘记密码？</a>
                </div>
            </div>
        </nav>
    </body>

</html>