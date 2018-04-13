<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css">
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <script type="text/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="text/javascript" src="/Public/admin/js/common.js"></script>
        <script type="text/javascript" src="/Public/admin/js/seller/sellerInfo.js"></script>
    </head>
    <body>
        <div class="option_search">
            <form method="get" action="/index.php/Admin/SellerInfo/showList" class="form-horizontal" id="search-form" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-sm-3" style="min-width: 300px;">
                        <button type="button" class="btn btn-success addSellerInfo" id="addInfo-btn" onclick="javascript:void(window.location.href = '/index.php/Admin/SellerInfo/saveSellerUser')" style="height: 34px;">
                            <span class="glyphicon glyphicon-plus"></span> 新增
                        </button>
                        <button type="button" class="btn btn-danger delSellerInfo" id="delArrayInfo-btn" style="height: 34px;">
                            <span class="glyphicon glyphicon-trash"></span> 批量删除
                        </button>
                        <button type="button" class="btn btn-warning checkSellerInfo" id="checkArrayInfo-btn" style="height: 34px;">
                            <span class="glyphicon glyphicon-check"></span> 批量审核
                        </button>
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo ($searchInfo["category_name"]); ?>" onclick="showTreeView();" placeholder="请选择类别" readonly>
                        <input type="hidden" id="parent_id" name="cat_id" value="<?php echo ($searchInfo["cat_id"]); ?>"/>
                        <div class="dropdown-menu" id="treeview" style="display: none;margin-left:15px;"></div>
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control" name="is_checked" value="<?php echo ($searchInfo["is_checked"]); ?>">
                            <option value="">审核状态</option>
                            <option value="0">未审</option>
                            <option value="1">审核通过</option>
                        </select>
                    </div>
                    <div class="col-sm-2" style="min-width: 300px;">
                        <div class="input-group">
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo ($searchInfo["name"]); ?>" placeholder="请输入商家名称">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-success" id="searchInfo-btn" style="height: 34px;">
                                    <span class="glyphicon glyphicon-search"></span> 搜索
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="table_content">
            <table class="table table-hover">
                <tr>
                    <th>序号</th>
                    <th><input type="checkbox" name="allChecked" onclick="setAllChecked(this);"/></th>
                    <th>&nbsp;商家名称</th>
                    <th>手机号码</th>
                    <th>商家电话</th>
                    <th>营业时间</th>
                    <th>操作</th>
                </tr>
                <?php if(!empty($infoList)): if(is_array($infoList)): foreach($infoList as $k=>$v): ?><tr class="tr">
                            <td><?php echo (I('get.p'))?((I('get.p')-1)*C('PAGE_SIZE')+$k+1):($k+1);?></td>
                            <td><input type="checkbox" name="rowChecked" value="<?php echo ($v["id"]); ?>"/></td>
                            <td>
                        <?php if($v["is_checked"] == 0): ?><span class="label label-default" style="padding: 4px;">未审核</span>
                            <?php else: ?>
                            <span class="label label-success" style="padding: 4px;">审核通过</span><?php endif; ?> 
                        【<?php echo ($v["cat_name"]); ?>】&#12288;<?php echo ($v["name"]); ?>&#12288;
                        </td>
                        <td><?php echo ($v["usr"]); ?></td>
                        <td><?php echo ($v["tel"]); ?></td>
                        <td><?php echo ($v["work_start"]); ?>-<?php echo ($v["work_end"]); ?></td>
                        <td>
                            <div>
                                <button class="btn btn-default edit-btn editSellerInfo" onclick="javascript:void(window.location.href = '/index.php/Admin/SellerInfo/edit/id/<?php echo ($v["id"]); ?>')">
                                    <span class="glyphicon glyphicon-edit"></span> 编辑
                                </button>
                                <!--<button class="btn btn-default del-btn" onclick="delInfoLayer(<?php echo ($v["id"]); ?>)">-->
                                <!--<span class="glyphicon glyphicon-trash"></span> 删除-->
                                <!--</button>-->
                                <!--<button class="btn btn-default" onclick="checkInfoLayer(<?php echo ($v["id"]); ?>)">-->
                                <!--<span class="glyphicon glyphicon-check"></span> 审核-->
                                <!--</button>-->
                                <button class="btn btn-default items-btn showItemsInfo" onclick="javascript:void(window.location.href = '/index.php/Admin/SellerItemsInfo/showList/seller_id/<?php echo ($v["id"]); ?>')">
                                    <span class="glyphicon glyphicon-list"></span> 服务项目
                                </button>
                                <button class="btn btn-default order-btn showOrderInfo" onclick="javascript:void(window.location.href = '/index.php/Admin/SellerOrderInfo/showList/seller_id/<?php echo ($v["id"]); ?>/seller_name/<?php echo ($v["name"]); ?>')">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> 订单
                                </button>
                                <button class="btn btn-default prom-btn showPromInfo" onclick="javascript:void(window.location.href = '/index.php/Admin/SellerPromInfo/showList/seller_id/<?php echo ($v["id"]); ?>/seller_name/<?php echo ($v["name"]); ?>')">
                                    <span class="glyphicon glyphicon-usd"></span> 促销信息
                                </button>
                            </div>
                        </td>
                        </tr><?php endforeach; endif; endif; ?>
                <?php if(empty($infoList)): ?><tr><td colspan="9">暂无数据</td></tr><?php endif; ?>
            </table>
            <div style="text-align: center;"><?php echo ($page); ?></div>
        </div>
    </body>
    <script>
        $(document).ready(function () {
            $("select[name='is_checked']").find("option[value='<?php echo ($searchInfo["is_checked"]); ?>']").prop("selected", 'selected');
        });
    </script>
</html>