<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
    <link rel="stylesheet" href="/Public/admin/css/common.css">
    <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
    <script type="text/javascript" src="/Public/admin/js/common.js"></script>
    <script type="text/javascript" src="/Public/admin/js/seller/sellerPromInfo.js"></script>
</head>
<body>
    <div class="option_search">
        <button type="button" class="btn btn-success addPromInfo" onclick="javascript:void(window.location.href='/index.php/Admin/SellerPromInfo/saveSellerProm/seller_id/<?php echo ($seller_id); ?>')" style="height: 34px;">
            <span class="glyphicon glyphicon-plus"></span> 新增
        </button>
        <button type="button" class="btn btn-danger delPromInfo" id="delArrayInfo-btn" style="height: 34px;">
            <span class="glyphicon glyphicon-trash"></span> 批量删除
        </button>
    </div>
    <div class="table_content">
        <table class="table table-hover">
            <tr>
                <th>全选</th>
                <th><input type="checkbox" name="allChecked" onclick="setAllChecked(this);"/></th>
                <th>标题</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>阅读人数</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            <?php if(!empty($infoList)): if(is_array($infoList)): foreach($infoList as $k=>$v): ?><tr class="tr">
                        <td><?php echo (I('get.p'))?((I('get.p')-1)*C('PAGE_SIZE')+$k+1):($k+1);?></td>
                        <td><input type="checkbox" name="rowChecked" value="<?php echo ($v["id"]); ?>"/></td>
                        <td><a href="/index.php/Admin/SellerPromInfo/promDetail/id/<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></a></td>
                        <td><?php echo ($v["start_time"]); ?></td>
                        <td><?php echo ($v["end_time"]); ?></td>
                        <td><?php echo ($v["read_num"]); ?>人</td>
                        <td><?php echo ($v["add_time"]); ?></td>
                        <td>
                            <div>
                                <button class="btn btn-default edit-btn editPromInfo" onclick="javascript:void(window.location.href='/index.php/Admin/SellerPromInfo/edit/id/<?php echo ($v["id"]); ?>')">
                                    <span class="glyphicon glyphicon-edit"></span> 编辑
                                </button>
                                <!--<button class="btn btn-default del-btn" onclick="delInfoLayer(<?php echo ($v["id"]); ?>)">-->
                                    <!--<span class="glyphicon glyphicon-trash"></span> 删除-->
                                <!--</button>-->
                            </div>
                        </td>
                    </tr><?php endforeach; endif; endif; ?>
            <?php if(empty($infoList)): ?><tr><td colspan="9">暂无数据</td></tr><?php endif; ?>
        </table>
        <div style="text-align: center;"><?php echo ($page); ?></div>
    </div>
</body>
</html>