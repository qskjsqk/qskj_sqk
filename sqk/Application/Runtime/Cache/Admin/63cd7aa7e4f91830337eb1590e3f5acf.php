<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css">
        <script type="application/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="application/javascript" src="/Public/admin/js/common.js"></script>
        <script type="application/javascript" src="/Public/admin/js/system/userAppUserDetail.js"></script>
    </head>
    <body>

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    用户资料
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="b-main-list col-xs-12 col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <span class="">用户等级</span>
                                <span class="" style="float: right;">Lv.8</span>
                            </div>
                            <div class="panel-body">
                                <span class="">剩余积分</span>
                                <span class="" style="float: right;"><?php echo ($userInfo["integral_num"]); ?>分</span>
                            </div>
                            <div class="panel-body">
                                <span class="">累计积分</span>
                                <span class="" style="float: right;"><?php echo ($userInfo["exp_num"]); ?>分</span>
                            </div>
                        </div>
                    </div>
                    <div class="b-main-list col-xs-12 col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <span class="">未消费卡券</span>
                                <span class="" style="float: right;"><?php echo ($userInfo["card_num"]); ?></span>
                            </div>
                            <div class="panel-body">
                                <span class="">已使用卡券</span>
                                <span class="" style="float: right;"><?php echo ($userInfo["used_card_num"]); ?></span>
                            </div>
                            <div class="panel-body">
                                <span class="">收藏卡券</span>
                                <span class="" style="float: right;"><?php echo ($userInfo["liked_card_num"]); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="b-main-list col-xs-12 col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <span class="">收藏活动</span>
                                <span class="" style="float: right;"><?php echo ($userInfo["liked_act_num"]); ?></span>
                            </div>
                            <div class="panel-body">
                                <span class="">分享活动</span>
                                <span class="" style="float: right;"><?php echo ($userInfo["shared_act_num"]); ?></span>
                            </div>
                            <div class="panel-body">
                                <span class="">参加过的活动</span>
                                <span class="" style="float: right;"><?php echo ($userInfo["joined_act_num"]); ?></span>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">
                    基本信息
                </h3>
            </div>
            <div class="panel-body">
                <div class="table_content col-xs-12 col-sm-6">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td rowspan="4" style='width:150px;'><img src='/<?php echo ($userInfo["qrcode_path"]); ?>' style="width: 150px; height: 150px; border: 1px solid #ccc;"></td>
                                <th>所在社区</th>
                                <td><?php echo ($userInfo["address_name"]); ?></td>
                            </tr>
                            <tr>
                                <th>姓名</th>
                                <td><?php echo ($userInfo["realname"]); ?></td>
                            </tr>
                            <tr>
                                <th>性别</th>
                                <td><?php echo ($userInfo["gender_name"]); ?></td>
                            </tr>
                            <tr>
                                <th>生日</th>
                                <td><?php echo ($userInfo["birthday"]); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <button type="button" class="btn btn-info btn-block" onclick="javascript:void(window.location.href = '/index.php/Admin/SysUserAppInfo/edit/id/<?php echo ($userInfo["id"]); ?>')">修改个人资料</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">
                    帐号安全
                </h3>
            </div>
            <div class="panel-body">
                <div class="table_content col-xs-12 col-sm-6">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>当前状态</th>
                                <td>
                        <?php if($userInfo["is_enable"] == 1): ?><span class="label label-success">正常</span>
                            <?php else: ?><span class="label label-danger">禁用</span><?php endif; ?>
                        </td>
                        <td>
                        <?php if($userInfo["is_enable"] == 1): ?><button class="btn btn-info btn-block" onclick="javascript:void(window.location.href = '/index.php/Admin/SysUserAppInfo/edit/id/<?php echo ($userInfo["id"]); ?>')">
                                <span class="glyphicon glyphicon-remove-sign"></span> 禁用
                            </button>
                            <?php else: ?>
                            <button class="btn btn-info btn-block" onclick="javascript:void(window.location.href = '/index.php/Admin/SysUserAppInfo/edit/id/<?php echo ($userInfo["id"]); ?>')">
                                <span class="glyphicon glyphicon-ok-sign"></span> 启用
                            </button><?php endif; ?>

                        </td>
                        </tr>
                        <tr>
                            <th>注册手机号</th>
                            <td><?php echo ($userInfo["tel"]); ?></td>
                            <td>
                                <button class="btn btn-info btn-block" onclick="javascript:void(window.location.href = '/index.php/Admin/SysUserAppInfo/edit/id/<?php echo ($userInfo["id"]); ?>')">
                                    <span class="glyphicon glyphicon-edit"></span> 修改
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th>社区实体卡</th>
                            <td><?php if($userInfo["iccard_num"] == 0): ?><span class="label label-default">未绑定</span><?php else: echo ($userInfo["iccard_num"]); endif; ?></td>
                            <td>
                                <button class="btn btn-info btn-block" onclick="bindingCardLayer(<?php echo ($v["id"]); ?>)">
                                    <span class="glyphicon glyphicon-qrcode"></span> 绑卡
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th>绑定微信号</th>
                            <td colspan="2"><?php if($userInfo["wx_num"] == 0): ?><span class="label label-default">未绑定</span><?php else: echo ($userInfo["wx_num"]); endif; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>


    <div class="bindingCardLayer" style="display: none;">
        <div class="container" style="width: 370px;margin-left: 0px;">
            <div class="row">
                <form method="post" action="#" class="form-horizontal" style="margin-top: 20px;">
                    <div class="form-group">
                        <label for="card_num" class="col-sm-4 control-label">IC卡编号</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="card_num" name="card_num" value="<?php echo ($userInfo["card_num"]); ?>" placeholder="请输入IC卡面编号">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="card_ufnum" class="col-sm-4 control-label">IC卡串号</label>

                        <div class="col-sm-8">
                            <button type="button" id="card_ufnum_btn" class="btn btn-primary btn-block" style="padding:5px 0;" onclick="getCardUfNum()">请放置读卡器上点击读卡</button>
                            <input type="text" class="form-control" id="card_ufnum" name="card_ufnum" value="" placeholder="读卡成功！" style="display: none;width: 100%;" disabled="disabled">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</html>