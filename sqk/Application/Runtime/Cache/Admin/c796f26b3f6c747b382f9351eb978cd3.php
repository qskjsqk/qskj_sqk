<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
    <link rel="stylesheet" href="/Public/admin/css/common.css">
    <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css">
    <script type="application/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
    <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
    <script type="application/javascript" src="/Public/admin/js/common.js"></script>
    <script type="application/javascript" src="/Public/admin/js/system/privInfo.js"></script>
</head>
<body>
    <div class="option_search">
        <button type="button" class="btn btn-success addPrivInfo" id="addInfoLayer-btn" style="height: 34px;">
            <span class="glyphicon glyphicon-plus"></span> 新增
        </button>
        <button type="button" class="btn btn-danger delPrivInfo" id="delArrayCat-btn" style="height: 34px;">
            <span class="glyphicon glyphicon-trash"></span> 批量删除
        </button>
    </div>
    <div class="table_content">
        <table class="table table-hover">
            <tr>
                <th style="width: 50px;">全选</th>
                <th><input type="checkbox" name="allChecked" onclick="setAllChecked(this);"/></th>
                <th>权限名称</th>
                <th>权限值</th>
                <th>权限分类</th>
                <th>操作</th>
            </tr>
            <?php if(!empty($infoList)): if(is_array($infoList)): foreach($infoList as $k=>$v): ?><tr class="tr">
                        <td><?php echo (I('get.p'))?((I('get.p')-1)*C('PAGE_SIZE')+$k+1):($k+1);?></td>
                        <td><input type="checkbox" name="rowChecked" value="<?php echo ($v["id"]); ?>"/></td>
                        <td><?php echo ($v["pri_name"]); ?></td>
                        <td><?php echo ($v["pri_value"]); ?></td>
                        <td><?php echo ($v["cat_name"]); ?></td>
                        <td>
                            <div>
                                <button class="btn btn-default edit-btn editPrivInfo" onclick="editInfoLayer(<?php echo ($v["id"]); ?>);">
                                    <span class="glyphicon glyphicon-edit"></span> 编辑
                                </button>
                                <!--<button class="btn btn-default del-btn delPrivInfo" onclick="delInfoLayer(<?php echo ($v["id"]); ?>)">-->
                                    <!--<span class="glyphicon glyphicon-trash"></span> 删除-->
                                <!--</button>-->
                            </div>
                        </td>
                    </tr><?php endforeach; endif; endif; ?>
            <?php if(empty($infoList)): ?><tr><td colspan="6">暂无数据</td></tr><?php endif; ?>
        </table>
        <div style="text-align: center;"><?php echo ($page); ?></div>
    </div>
</body>
<div class="infoLayer" style="display: none;">
    <div class="container" style="width: 500px;">
        <div class="row">
            <form method="post" action="#" class="form-horizontal" id="save_form" style="margin-top: 20px;">
                <input type="hidden" name="id" id="id" value=""/>
                <div class="form-group">
                    <label for="category_name" class="col-sm-3 control-label">权限组</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="category_name" name="category_name" value="" onclick="showTreeView();" placeholder="请选择类别">
                        <input type="hidden" id="parent_id" name="cat_id" value=""/>
                    </div>
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-7" id="treeview" style="display: none;"></div>
                </div>
                <div class="form-group">
                    <label for="pri_name" class="col-sm-3 control-label">权限名称</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="pri_name" name="pri_name" value="" placeholder="请输入权限名称">
                    </div>
                </div>
                <div class="form-group">
                    <label for="pri_value" class="col-sm-3 control-label">权限值</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="pri_value" value="" id="pri_value" placeholder="请输入权限值">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</html>