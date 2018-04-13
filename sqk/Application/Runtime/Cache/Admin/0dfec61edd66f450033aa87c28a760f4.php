<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <!--自定义样式及脚本放于此处-->
        <link rel="stylesheet" href="/Public/admin/css/login.css">
        <script type="text/javascript" src="/Public/admin/js/login/login.js"></script>
        <?php echo (ANIMATION); ?>
        <title><?php echo ($config['system_name']); ?></title>
    </head>
    <body>
        <input type="hidden" name="url" id="url" value="login">
        <nav class="navbar navbar-inverse navbar-fixed-top b-header">
            <div class="container-fluid">
                <div class="navbar-header ">
                    <div class="b-systitle"><?php echo ($config['system_name']); ?></div>
                </div>                
            </div>
        </nav>

        <div class="container-fluid b-menu">
            <div class="row">                
                <div class="col-md-12 b-login-bg">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 b-login-div b-icon-computer"></div>
                        <div class="col-xs-12 col-sm-6 b-login-div b-icon-login">
                            <div class="b-login-area">
                                <div class="b-login-title ">
                                    登&#12288;录
                                </div>
                                <div class="b-input-tr">
                                    <div class="input-group input-group-lg b-input-border">
                                        <span class="input-group-addon b-input-icon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control" placeholder="请输入用户名" style="height: 50px;" id="loginUser">
                                    </div>
                                </div>
                                <div class="b-input-tr">
                                    <div class="input-group input-group-lg b-input-border">
                                        <span class="input-group-addon b-input-icon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="password" class="form-control" placeholder="请输入密码" style="height: 50px;" id="loginPwd">
                                    </div>
                                </div>
                                <div class="b-input-tr">
                                    <div class="input-group input-group-lg b-input-border">
                                        <span class="input-group-addon b-input-icon"><i class="glyphicon glyphicon-star"></i></span>
                                        <input type="text" class="form-control" placeholder="请输入验证码" style="height: 50px;" id="loginYzm">
                                        <span class="input-group-addon" style="width: 140px;cursor: pointer;padding: 0px;" id="yzm">
                                            <img class="verify "  alt="验证码" src="<?php echo U('Admin/login/verify_c',array());?>" title="点击刷新" onclick="changeValidate();"/>
                                        </span>
                                    </div>

                                </div>
                                <div class="b-input-tr">
                                    <div class="alert alert-danger" style="display: none;" id="warning">
                                        <i class="glyphicon glyphicon-exclamation-sign"></i>
                                        <span id="warnMsg">错误！请进行一些更改。</span>
                                    </div>
                                    <div class="b-login-btn hvr-grow" onclick="subLogin()">
                                        登&#12288;录
                                    </div>
                                </div>
                                <div class="b-input-tr">
                                    <div class="b-input-foot">
                                        <!--<div class="b-input-foot-btn b-text-left" onclick="aHref('register')">注册</div>-->
                                        <div class="b-input-foot-btn b-text-left">&#12288;&#12288;</div>
                                        <div class="b-input-foot-btn b-text-right" onclick="aHref('findpwd')">忘记密码？</div>
                                    </div>
                                </div>
                                <div class="b-input-tr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">                
                <div class="col-md-12 b-login-footer hvr-overline-from-center ">
                    <?php echo ($config['system_name']); ?>
                </div>
            </div>
        </div>
    </body>
</html>