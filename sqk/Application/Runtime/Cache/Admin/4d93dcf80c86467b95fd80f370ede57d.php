<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css">
        <script type="application/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="application/javascript" src="/Public/admin/js/common.js"></script>
        <script type="application/javascript" src="/Public/admin/js/system/userInfo.js"></script>
    </head>
    <body>
        <div class="option_search">
            <form method="get" action="/index.php/Admin/SysUserInfo/showList" class="form-horizontal" id="search-form" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-sm-2" style="min-width: 200px;">
                        <button type="button" class="btn btn-success addUserInfo" onclick="javascript:void(window.location.href = '/index.php/Admin/SysUserInfo/saveUserInfo')" style="height: 34px;">
                            <span class="glyphicon glyphicon-plus"></span> 新增
                        </button>
                        <button type="button" class="btn btn-danger delUserInfo" id="delArrayGroup-btn" style="height: 34px;">
                            <span class="glyphicon glyphicon-trash"></span> 批量删除
                        </button>
                    </div>
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo ($searchInfo["category_name"]); ?>" onclick="showTreeView();" placeholder="请选择类别" readonly>
                        <input type="hidden" id="parent_id" name="cat_id" value="<?php echo ($searchInfo["cat_id"]); ?>"/>
                        <div class="dropdown-menu" id="treeview" style="display: none;margin-left:15px;"></div>
                    </div>
                    <div class="col-sm-2" style="text-align: right;">
                        <div class="input-group">
                            <input type="text" class="form-control" id="usr" name="usr" value="<?php echo ($searchInfo["usr"]); ?>" placeholder="请输入用户名">

                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success" id="searchInfo-btn" style="height: 34px;">
                                    <span class="glyphicon glyphicon-search"></span> 搜索
                                </button>
                            </span>
                        </div>
                    </div>
                    <!--                    <div class="col-sm-2" style="text-align: right;">
                    
                                        </div>
                                        <div class="col-sm-1">
                    
                                        </div>-->
                </div>
            </form>
        </div>
        <div class="table_content">
            <table class="table table-hover">
                <tr>
                    <th style="width: 50px;">全选</th>
                    <th><input type="checkbox" name="allChecked" onclick="setAllChecked(this);"/></th>
                    <th>用户名</th>
                    <th>用户组</th>
                    <th>真实姓名</th>
                    <th>电话</th>
                    <th>添加时间</th>
                    <th>最后登录IP</th>
                    <th>最后登录时间</th>
                    <th>是否禁用</th>
                    <th>认证状态</th>
                    <th>操作</th>
                </tr>
                <?php if(!empty($infoList)): if(is_array($infoList)): foreach($infoList as $k=>$v): ?><tr class="tr">
                            <td><?php echo (I('get.p'))?((I('get.p')-1)*C('PAGE_SIZE')+$k+1):($k+1);?></td>
                            <td><input type="checkbox" name="rowChecked" value="<?php echo ($v["id"]); ?>"/></td>
                            <td><?php echo ($v["usr"]); ?></td>
                            <td><?php echo ($v["cat_name"]); ?></td>
                            <td><?php echo ($v["realname"]); ?></td>
                            <td><?php echo ($v["tel"]); ?></td>
                            <td><?php echo ($v["add_time"]); ?></td>
                            <td><?php echo ($v["last_ip"]); ?></td>
                            <td><?php echo ($v["last_login_time"]); ?></td>
                            <td>
                        <?php if($v["is_enable"] == 0): ?>禁用
                            <?php else: ?>启用<?php endif; ?>
                        </td>
                        <td>
                        <?php if($v["rns_type"] == 0): ?>未审核
                            <?php elseif($v["rns_type"] == 1): ?>通过
                            <?php else: ?>未通过<?php endif; ?>
                        </td>
                        <td>
                            <div>
                                <button class="btn btn-default edit-btn editUserInfo" onclick="javascript:void(window.location.href = '/index.php/Admin/SysUserInfo/edit/id/<?php echo ($v["id"]); ?>');">
                                    <span class="glyphicon glyphicon-edit"></span> 编辑
                                </button>
                                <button class="btn btn-default del-btn delUserInfo" onclick="rnsUserLayer(<?php echo ($v["id"]); ?>)">
                                    <span class="glyphicon glyphicon-user"></span> 实名认证
                                </button>
                            </div>
                        </td>
                        </tr><?php endforeach; endif; endif; ?>
                <?php if(empty($infoList)): ?><tr><td colspan="7">暂无数据</td></tr><?php endif; ?>
            </table>
            <div style="text-align: center;"><?php echo ($page); ?></div>
        </div>
    </body>
    <div class="rnsLayer" style="display: none;">
        <div class="container" style="width: 550px;margin-left: 0px;">
            <div class="row">
                <form method="post" action="#" class="form-horizontal" style="margin-top: 20px;">
                    <div class="form-group">
                        <label for="category_name" class="col-sm-2 control-label">姓名</label>
                        <div class="col-sm-2">
                            <div id="realname" style="height: 34px; line-height:34px;"></div>
                        </div>
                        <label class="col-sm-2 control-label">身份证</label>
                        <div class="col-sm-4">
                            <div id="idcard_num" style="height: 34px; line-height:34px;"></div>
                        </div>
                        <label id="checkStatus" class="col-sm-2 control-label">审核状态</label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</html>