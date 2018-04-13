<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css">
        <script type="application/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="application/javascript" src="/Public/admin/js/common.js"></script>
        <script type="application/javascript" src="/Public/admin/js/system/userAppUserInfo.js"></script>
    </head>
    <body>
        <div class="option_search">
            <form method="get" action="/index.php/Admin/SysUserAppInfo/showList" class="form-horizontal" id="search-form" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-sm-2" style="min-width: 200px;">
                        <button type="button" class="btn btn-success addUserInfo" onclick="javascript:void(window.location.href = '/index.php/Admin/SysUserAppInfo/saveUserInfo/catName/appUser')" style="height: 34px;">
                            <span class="glyphicon glyphicon-plus"></span> 新增
                        </button>
                        <button type="button" class="btn btn-danger delUserInfo" id="delArrayGroup-btn" style="height: 34px;">
                            <span class="glyphicon glyphicon-trash"></span> 批量删除
                        </button>
                    </div>
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-3" style="text-align: right;">
                        <div class="input-group">
                            <input type="text" class="form-control" id="keyword" name="keyword" value="<?php echo ($searchInfo["keyword"]); ?>" placeholder="请输入手机号">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success" id="searchInfo-btn" style="height: 34px;">
                                    <span class="glyphicon glyphicon-search"></span> 搜索
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="table_content">
            <table class="table table-hover">
                <tr>
                    <th style="width: 50px;">全选</th>
                    <th><input type="checkbox" name="allChecked" onclick="setAllChecked(this);"/></th>
                    <th>真实姓名</th>
                    <th>手机号码</th>
                    <th>积分数</th>
                    <th>卡券数</th>
                    <th>参与次数</th>
                    <th>经验值</th>
                    <th>社区卡号</th>
                    <th>操作</th>
                </tr>
                <?php if(!empty($infoList)): if(is_array($infoList)): foreach($infoList as $k=>$v): ?><tr class="tr">
                            <td><?php echo (I('get.p'))?((I('get.p')-1)*C('PAGE_SIZE')+$k+1):($k+1);?></td>
                            <td><input type="checkbox" name="rowChecked" value="<?php echo ($v["id"]); ?>"/></td>
                            <td>
                        <?php if($v["is_enable"] == 0): ?><span class="label label-danger">禁用</span>
                            <?php else: ?><span class="label label-success">启用</span><?php endif; ?>
                        <a href="/index.php/Admin/SysUserAppInfo/appUserDetail/id/<?php echo ($v["id"]); ?>"><?php echo ($v["realname"]); ?></a>
                        </td>
                        <td><?php echo ($v["tel"]); ?></td>
                        <td><?php echo ($v["integral_num"]); ?></td>
                        <td><?php echo ($v["card_num"]); ?></td>
                        <td><?php echo ($v["joined_act_num"]); ?></td>
                        <td><?php echo ($v["exp_num"]); ?></td>
                        <td>
                        <?php if($v["iccard_num"] == 0): ?><span class="label label-default">未绑定</span><?php else: echo ($v["iccard_num"]); endif; ?>
                        </td>

                        <td>
                            <div>
                                <button class="btn btn-default edit-btn editUserInfo" onclick="javascript:void(window.location.href = '/index.php/Admin/SysUserAppInfo/appUserDetail/id/<?php echo ($v["id"]); ?>');">
                                    <span class="glyphicon glyphicon-edit"></span> 编辑
                                </button>
                                <button class="btn btn-default del-btn bindingUserInfo" onclick="bindingCardLayer(<?php echo ($v["id"]); ?>)">
                                    <span class="glyphicon glyphicon-qrcode"></span> 绑卡
                                </button>
                            </div>
                        </td>
                        </tr><?php endforeach; endif; endif; ?>
                <?php if(empty($infoList)): ?><tr><td colspan="12">暂无数据</td></tr><?php endif; ?>
            </table>
            <div style="text-align: center;"><?php echo ($page); ?></div>
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