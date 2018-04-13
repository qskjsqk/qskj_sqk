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
        <nav class="navbar navbar-inverse navbar-fixed-top b-header">
            <div class="container-fluid">
                <div class="navbar-header ">
                    <div class="b-systitle "><?php echo ($config['system_name']); ?></div>
                </div>                
            </div>
        </nav>

        <div class="container-fluid b-menu">
            <div class="row">                
                <div class="col-md-12 b-login-bg">
                    <div class="row" style="margin-top: 100px;min-width: 1050px;background-color: #adf7ff;height: 245px;padding: 20px 0;">
                        <div class="col-xs-12 col-sm-1"></div>
                        <div class="col-xs-12 col-sm-10" style="height: 175px;">
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 b-cat1 hvr-pop " onclick="aHrefNew('<?php echo (CENTER_CONTROL); ?>')">
                                    <div class="b-cat-name">集中控制系统</div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 b-cat2 hvr-pop" onclick="aHrefNew('<?php echo (HEALTH_CLOUD); ?>')">
                                    <div class="b-cat-name">健康云管理平台</div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 b-cat3 hvr-pop" onclick="aHref('/index.php/health/index/index')" >
                                    <div class="b-cat-name">居民健康信息档案库</div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 b-cat4 hvr-pop" onclick="aHref('/index.php/Admin/index/index')">
                                    <div class="b-cat-name">社区智慧服务系统</div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-1"></div>
                    </div>
                </div>
            </div>
            <div class="row">                
                <div class="col-md-12 b-login-footer hvr-overline-from-center">
                    <?php echo ($config['system_name']); ?>
                </div>
            </div>
        </div>

    </body>
</html>