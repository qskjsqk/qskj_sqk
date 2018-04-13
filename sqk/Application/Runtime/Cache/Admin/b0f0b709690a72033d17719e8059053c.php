<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <!--自定义样式及脚本放于此处-->
        <link rel="stylesheet" href="/Public/admin/css/index.css">
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <script type="text/javascript" src="/Public/admin/js/index/index.js"></script>
        <?php echo (ANIMATION); ?>
        <title><?php echo ($config['system_name']); ?></title>
    </head>
    <body
        <div class="container" style="width: 100%;background-color: #e9ecf3;">
            <div class="row" style="background-color: #fff;margin-bottom: 20px;" >
                <div class="b-tip-div col-xs-6 col-sm-3">
                    <div class="b-tip b-color-tip1 hvr-buzz-out">
                        <div class="b-tip-body">
                            <div class="b-tip-left">
                                <i class="glyphicon glyphicon-send"></i>
                            </div>
                            <div class="b-tip-right">
                                <div class="b-tip-titleb"><?php echo ($mainNum['notice']); ?>&#12288;条</div>
                                <div class="b-tip-titlel"> 累计发布&#12288;<b>通知公告</b></div>
                            </div>
                        </div>
                        <div class="b-tip-footer">
                            截至<?php echo ($nowTime); ?>
                            <span class='b-more'><span class="pull-right glyphicon glyphicon-time b-more"></span></span>
                        </div>
                    </div>
                </div>
                <div class="b-tip-div col-xs-6 col-sm-3">
                    <div class="b-tip b-color-tip2 hvr-buzz-out">
                        <div class="b-tip-body">
                            <div class="b-tip-left">
                                <i class="glyphicon glyphicon-globe"></i>
                            </div>
                            <div class="b-tip-right">
                                <div class="b-tip-titleb"><?php echo ($mainNum['activity']); ?>&#12288;条</div>
                                <div class="b-tip-titlel"> 累计发布&#12288;<b>社区活动</b></div>
                            </div>
                        </div>
                        <div class="b-tip-footer">
                            截至<?php echo ($nowTime); ?>
                            <span class='b-more'><span class="pull-right glyphicon glyphicon-time b-more"></span></span>
                        </div>
                    </div>
                </div>
                <div class="b-tip-div col-xs-6 col-sm-3">
                    <div class="b-tip b-color-tip3 hvr-buzz-out">
                        <div class="b-tip-body">
                            <div class="b-tip-left">
                                <i class="glyphicon glyphicon-sound-dolby"></i>
                            </div>
                            <div class="b-tip-right">
                                <div class="b-tip-titleb"><?php echo ($mainNum['dang']+$mainNum['prop']); ?>&#12288;条</div>
                                <div class="b-tip-titlel"> 累计&#12288;<b>物业诉求反馈</b></div>
                            </div>
                        </div>
                        <div class="b-tip-footer">
                            截至<?php echo ($nowTime); ?>
                            <span class='b-more'><span class="pull-right glyphicon glyphicon-time b-more"></span></span>
                        </div>
                    </div>
                </div>
                <div class="b-tip-div col-xs-6 col-sm-3">
                    <div class="b-tip b-color-tip4 hvr-buzz-out" >
                        <div class="b-tip-body">
                            <div class="b-tip-left">
                                <i class="glyphicon glyphicon-gift"></i>
                            </div>
                            <div class="b-tip-right">
                                <div class="b-tip-titleb"><?php echo ($mainNum['seller']); ?>&#12288;家</div>
                                <div class="b-tip-titlel"> 累计&#12288;<b>入驻商家</b></div>
                            </div>
                        </div>
                        <div class="b-tip-footer">
                            截至<?php echo ($nowTime); ?>
                            <span class='b-more'><span class="pull-right glyphicon glyphicon-time b-more"></span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="b-main-list col-xs-12 col-sm-6">
                    <div class="b-main-list-info">
                        <table class="table table-hover">
                            <tr>
                                <th colspan="4" style="text-align: left;color: #45c8dc;"><i class="glyphicon glyphicon-globe hvr-bounce-in"></i>&#12288;最新通知公告</th>
                            </tr>
                            <?php if(!empty($noticeArr)): if(is_array($noticeArr)): foreach($noticeArr as $k=>$v): ?><tr class="tr">
                                        <td>
                                            <?php echo ($v["icon"]); ?><a href="/index.php/Admin/NoticeInfo/noticeDetail/id/<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></a>
                                        </td>
                                        <td><span class="label label-info" style="font-size: 13px;line-height: 13px;"><?php echo ($v["realname"]); ?></span></td>
                                        <td style="text-align: right;"><?php echo ($v["add_time"]); ?></td>
                                    </tr><?php endforeach; endif; endif; ?>
                            <?php if(empty($noticeArr)): ?><tr><td colspan="4" style="text-align: center;">(＞﹏＜)&#12288;暂无数据</td></tr><?php endif; ?>
                        </table>
                    </div>
                </div>
                <div class="b-main-list col-xs-12 col-sm-6">
                    <div class="b-main-list-info">
                        <table class="table table-hover">
                            <tr>
                                <th colspan="4" style="text-align: left;color: #45c8dc;"><i class="glyphicon glyphicon-globe"></i>&#12288;最新社区活动</th>
                            </tr>
                            <?php if(!empty($activArr)): if(is_array($activArr)): foreach($activArr as $k=>$v): ?><tr class="tr">
                                        <td>
                                            <?php echo ($v["icon"]); ?><a href="/index.php/Admin/ActivInfo/activDetail/id/<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></a>
                                        </td>
                                        <td>
                                            <span class="label label-success" style="font-size: 13px;line-height: 13px;">报名：<?php echo ($v["join_num"]); ?></span>
                                        </td>
                                        <td style="text-align: right;"><?php echo ($v["add_time"]); ?></td>
                                    </tr><?php endforeach; endif; endif; ?>
                            <?php if(empty($activArr)): ?><tr><td colspan="4" style="text-align: center;">(＞﹏＜)&#12288;暂无数据</td></tr><?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>