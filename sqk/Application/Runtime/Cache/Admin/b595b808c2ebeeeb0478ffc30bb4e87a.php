<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <!--自定义样式及脚本放于此处-->
        <link rel="stylesheet" href="/Public/admin/css/index.css">
        <script type="text/javascript" src="/Public/admin/js/index/index.js"></script>
        <?php echo (ANIMATION); ?>
        <title><?php echo ($config['system_name']); ?></title>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top b-header">
            <div class="container-fluid">
                <div class="navbar-header ">
                    <div class="b-systitle "><?php echo ($config['system_name']); ?></div>
                </div>
                <div class="navbar-collapse collapse" >
                    <ul class="nav navbar-nav navbar-right" style="margin: 5px 0px;">
                        <li class="dropdown">
                            <a href="/index.php/Admin/login/shome" class="b-top b-icon-shome hvr-buzz-out" style="color: #fff;display:<?php echo ($shome); ?>;">
                                平台首页
                            </a>
                        </li>
                        <li class="dropdown ">
                            <a href="#" class="dropdown-toggle b-top b-icon-tix hvr-buzz-out" style="color: #fff;display:<?php echo ($tixing); ?>" data-toggle="dropdown">
                                提醒
                                <span class="label label-danger" id="countSum">0</span>
                            </a>
                            <ul class="dropdown-menu" style="width: 300px" id="propWarn">
                                <li class="divider"></li>
                                <li><a href="#">暂无提醒</a></li>
                                <li class="divider"></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle b-top b-icon-xiaox hvr-buzz-out" style="color: #fff;display:<?php echo ($xiaoxi); ?>" data-toggle="dropdown">
                                消息
                                <span class="label label-danger" id="newSum">0</span>
                                <!--<span class="label label-danger pull-right b-label" id="newSum">0</span>-->
                            </a>
                            <ul class="dropdown-menu" style="width: 420px" id="newMsg">
                                <li class="divider"></li>
                                <li><a href="#">暂无提醒</a></li>
                                <li class="divider"></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="jumpPage('/index.php/Admin/SysUserInfo/saveUserMyInfo', 0)" class="b-top b-icon-user hvr-buzz-out" style="color: #fff;" target="right">
                                <?php echo ($realname); ?>
                            </a>
                        </li>
                        <li ><a href="/index.php/Admin/login/logout" class="b-top b-icon-logout hvr-buzz-out" style="color: #fff;">退出</a></li>

                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid b-menu">
            <div class="row">
                <div class="col-md-2 b-div-menu" id="menu">
                    <ul id="main-nav" class="nav nav-list nav-stacked">
                        <li style="border-left-color: #3fb2ac">
                            <div class="li-color-1" onclick="jumpPage('/index.php/Admin/index/main', 0)">
                                <i class="glyphicon glyphicon-home"></i>
                                首&#12288;&#12288;页         
                                <span class="pull-right glyphicon">&#12288;</span>
                            </div>
                        </li>

                        <li class="noticeMenu">
                            <div href="#div1" class="nav-header collapsed li-color-2" onclick="zkTab('div1')">
                                <i class="glyphicon glyphicon-list-alt"></i>
                                通知公告
                                <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                            </div>
                            <ul id="div1" class="nav nav-list collapse secondmenu" style="height: 0px;">
                                <li class="showNoticeCat"><div onclick="jumpPage('/index.php/Admin/NoticeCat/showList', this)" class="li-color-2">通知分类</div></li>
                                <li class="showNoticeInfo"><div onclick="jumpPage('/index.php/Admin/NoticeInfo/showList', this)" class="li-color-2" >信息列表</div></li>
                            </ul>
                        </li>

                        <li class="sellerMenu">
                            <div class="nav-header collapsed li-color-3" onclick="zkTab('div2')">
                                <i class="glyphicon glyphicon-shopping-cart"></i>
                                商家管理
                                <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                            </div>
                            <ul id="div2" class="nav nav-list collapse secondmenu" style="height: 0px;">
                                <li class="showSellerItems"><div onclick="jumpPage('/index.php/Admin/SellerItemsInfo/showList/seller_id/<?php echo ($seller_info['id']); ?>', this)"  class="li-color-3">服务项目列表</div></li>
                                <li class="showSellerOrder"><div onclick="jumpPage('/index.php/Admin/SellerOrderInfo/showList/seller_id/<?php echo ($seller_info['id']); ?>/seller_name/<?php echo ($seller_info['name']); ?>', this)"  class="li-color-3">订单列表</div></li>
                                <li class="showSellerProm"><div onclick="jumpPage('/index.php/Admin/SellerPromInfo/showList/seller_id/<?php echo ($seller_info['id']); ?>', this)"  class="li-color-3">广告列表</div></li>
                                <li class="showSellerCat"><div onclick="jumpPage('/index.php/Admin/SellerCat/showList', this)"  class="li-color-3" >商家分类</div></li>
                                <li class="showSellerInfo"><div onclick="jumpPage('/index.php/Admin/SellerInfo/showList', this)"  class="li-color-3" >商家信息</div></li>
                                <li class="showItemsCat"><div onclick="jumpPage('/index.php/Admin/SellerItemsCat/showList', this)"  class="li-color-3" >服务项目分类</div></li>
                            </ul>
                        </li>
                        <li class="ticketMenu">
                            <div class="nav-header collapsed li-color-4" onclick="zkTab('div3')">
                                <i class="glyphicon glyphicon-briefcase"></i>
                                社区卡券
                                <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                            </div>
                            <ul id="div3" class="nav nav-list collapse secondmenu" style="height: 1px;">
                                <li class=""><div onclick="jumpPage('/index.php/Admin/PropDangerCat/showList', this)"  class="li-color-4" >菜单1</div></li>
                                <li class=""><div onclick="jumpPage('/index.php/Admin/PropDangerInfo/showList', this)"  class="li-color-4" >菜单2</div></li>
                                <li class=""><div onclick="jumpPage('/index.php/Admin/PropProbInfo/showList', this)"  class="li-color-4" >菜单3</div></li>
                            </ul>
                        </li>

                        <li class="activMenu">
                            <div class="nav-header collapsed li-color-5" onclick="zkTab('div4')">
                                <i class="glyphicon glyphicon-credit-card"></i>
                                活动管理
                                <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                            </div>
                            <ul id="div4" class="nav nav-list collapse secondmenu" style="height: 0px;">
                                <li class="showActivCat"><div onclick="jumpPage('/index.php/Admin/ActivCat/showList', this)"  class="li-color-5" >活动分类</div></li>
                                <li class="showActivInfo"><div onclick="jumpPage('/index.php/Admin/ActivInfo/showList', this)"  class="li-color-5" >活动列表</div></li>
                                <!--<li><div onclick="jumpPage('/index.php/Admin/ActivStatistics/show', this)"  class="li-color-5" >活动统计</div></li>-->
                            </ul>
                        </li>
                        <li class="listMenu">
                            <div class="nav-header collapsed li-color-2" onclick="zkTab('div5')">
                                <i class="glyphicon glyphicon-signal"></i>
                                榜单数据
                                <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                            </div>
                            <ul id="div5" class="nav nav-list collapse secondmenu" style="height: 1px;">
                                <li class=""><div onclick="jumpPage('/index.php/Admin/PropDangerCat/showList', this)"  class="li-color-2" >菜单1</div></li>
                                <li class=""><div onclick="jumpPage('/index.php/Admin/PropDangerInfo/showList', this)"  class="li-color-2" >菜单2</div></li>
                                <li class=""><div onclick="jumpPage('/index.php/Admin/PropProbInfo/showList', this)"  class="li-color-2" >菜单3</div></li>
                            </ul>
                        </li>

                        <li class="appuserMenu">
                            <div class="nav-header collapsed li-color-1" onclick="zkTab('div6')">
                                <i class="glyphicon glyphicon-user"></i>
                                会员管理
                                <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                            </div>
                            <ul id="div6" class="nav nav-list collapse secondmenu" style="height: 0px;">
                                <li class="showUserAppInfo"><div onclick="jumpPage('/index.php/Admin/SysUserAppInfo/showList', this)"  class="li-color-1" >居民信息</div></li>
                            </ul>
                        </li>
                        <li class="systemMenu">
                            <div class="nav-header collapsed li-color-6" onclick="zkTab('div7')">
                                <i class="glyphicon glyphicon-cog"></i>
                                系统设置
                                <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                            </div>
                            <ul id="div7" class="nav nav-list collapse secondmenu" style="height: 0px;">
                                <li class="showPrivCat"><div onclick="jumpPage('/index.php/Admin/SysPrivCat/showList', this)"  class="li-color-6" >权限分类</div></li>
                                <li class="showPrivInfo"><div onclick="jumpPage('/index.php/Admin/SysPrivInfo/showList', this)"  class="li-color-6" >权限列表</div></li>
                                <li class="showUserGroup"><div onclick="jumpPage('/index.php/Admin/SysUserGroup/showList', this)"  class="li-color-6" >角色管理</div></li>
                                <li class="showUserInfo"><div onclick="jumpPage('/index.php/Admin/SysUserInfo/showList', this)"  class="li-color-6" >用户管理</div></li>
                                <li class="showDbBack"><div onclick="jumpPage('/index.php/Admin/Dbbackup/showList', this)"  class="li-color-6" >数据备份</div></li>
                                <li class="cleanTemPic"><div onclick="jumpPage('/index.php/Admin/Allattach/delAttachs', this)"  class="li-color-6" >清理缓存</div></li>
                                <li class="showLogInfo"><div onclick="jumpPage('/index.php/Admin/Actionlog/showLogList', this)"  class="li-color-6" >系统日志</div></li>
                            </ul>
                        </li>

                        <!--                        <li class="wyMenu">
                            <div class="nav-header collapsed li-color-4" onclick="zkTab('div3')">
                                <i class="glyphicon glyphicon-briefcase"></i>
                                物业服务
                                <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                            </div>
                            <ul id="div3" class="nav nav-list collapse secondmenu" style="height: 1px;">
                                <li class="showDangerCat"><div onclick="jumpPage('/index.php/Admin/PropDangerCat/showList', this)"  class="li-color-4" >险情/隐患分类</div></li>
                                <li class="showDangerInfo"><div onclick="jumpPage('/index.php/Admin/PropDangerInfo/showList', this)"  class="li-color-4" >险情上报列表</div></li>
                                <li class="showProbInfo"><div onclick="jumpPage('/index.php/Admin/PropProbInfo/showList', this)"  class="li-color-4" >诉求/问题列表</div></li>
                            </ul>
                        </li>-->
                        <!--
                        <li class="helpMenu">
                            <div class="nav-header collapsed li-color-7" onclick="zkTab('div7')">
                                <i class="glyphicon glyphicon-phone-alt"></i>
                                应急服务
                                <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                            </div>
                            <ul id="div7" class="nav nav-list collapse secondmenu" style="height: 0px;">
                                <li class="showHelpInfo"><div onclick="jumpPage('/index.php/Admin/HelpInfo/showList', this)"  class="li-color-7" >社区电话</div></li>
                                <li class="showMyHelpInfo"><div onclick="jumpPage('/index.php/Admin/HelpInfo/showHelpList', this)"  class="li-color-7" >紧急联系人</div></li>
                            </ul>
                        </li>-->

                    </ul>
                </div>
                <div class="col-md-10">
                    <div class="panel panel-default">
                        <div class="panel-body b-main-title">
                            <a id="firCat" style="color:#3fb2ac;" href="javascript:void(0)">后台</a>&nbsp;&raquo;&nbsp;<a id="secCat" style="color:#3fb2ac;" href="javascript:void(0)">首页</a>
                        </div>
                    </div>
                    <div class="panel panel-default" id="main">
                        <iframe name="right" id="rightMain" src="/index.php/Admin/index/main" frameborder="no" scrolling="auto" width="100%" height="100%" allowtransparency="true"></iframe>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>