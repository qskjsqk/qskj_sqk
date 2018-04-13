<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css">
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <script type="text/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="text/javascript" src="/Public/admin/js/common.js"></script>
        <script type="text/javascript" src="/Public/admin/js/activity/activInfo.js"></script>
    </head>
    <body>
        <div class="option_search">


            <form method="get" action="/index.php/Admin/ActivInfo/showList" class="form-horizontal" id="search-form" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-sm-5" style="min-width: 200px;">
                        <button type="button" class="btn btn-success addActivInfo" id="addInfo-btn" onclick="javascript:void(window.location.href = '/index.php/Admin/ActivInfo/saveActiv')" style="height: 34px;">
                            <span class="glyphicon glyphicon-plus"></span> 新增
                        </button>
                        <button type="button" class="btn btn-danger delActivInfo" id="delArrayInfo-btn" style="height: 34px;">
                            <span class="glyphicon glyphicon-trash"></span> 批量删除
                        </button>
                        <button type="button" class="btn btn-info pubActivInfo" id="publishArrayInfo-btn" style="height: 34px;">
                            <span class="glyphicon glyphicon-bullhorn"></span> 批量发布
                        </button>
                        <button type="button" class="btn btn-warning overActivInfo" id="overArrayInfo-btn" style="height: 34px;">
                            <span class="glyphicon glyphicon-off"></span> 批量结束
                        </button>
                    </div>
                    <div class="col-sm-1">
                    </div>

                    <div class="col-sm-2" style="text-align: right;">
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo ($searchInfo["category_name"]); ?>" onclick="showTreeView();" placeholder="请选择类别" readonly>
                        <input type="hidden" id="parent_id" name="cat_id" value="<?php echo ($searchInfo["cat_id"]); ?>"/>
                        <div class="dropdown-menu" id="treeview" style="display: none;margin-left:15px;"></div>
                    </div>
                    <div class="col-sm-3" style="text-align: right;">
                        <div class='input-group'>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo ($searchInfo["title"]); ?>" placeholder="请输入标题">
                            <span class='input-group-btn'>
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
                    <th>全选</th>
                    <th><input type="checkbox" name="allChecked" onclick="setAllChecked(this);"/></th>
                    <th>&nbsp;活动标题</th>
                    <th>类别</th>
                    <th>活动积分</th>

                    <th>活动联系人</th>
                    <th>联系人电话</th>
                    <th>开始时间</th>
                    <th>已预约人数</th>
                    <th>操作</th>
                </tr>
                <?php if(!empty($infoList)): if(is_array($infoList)): foreach($infoList as $k=>$v): ?><tr class="tr">
                            <td><?php echo (I('get.p'))?((I('get.p')-1)*C('PAGE_SIZE')+$k+1):($k+1);?></td>
                            <td>
                        <?php if($v["is_over"] == 1 ||$v["is_open"] == 1): ?><input type="checkbox" name="" value="" disabled="disabled"/>
                            <?php else: ?><input type="checkbox" name="rowChecked" value="<?php echo ($v["id"]); ?>"/><?php endif; ?>
                                
                                
                            </td>
                            <td>
                        <?php if($v["is_publish"] == 0): ?><span class="label label-default" style="padding: 4px">未发布</span>
                            <?php else: ?>
                            <span class="label label-success" style="padding: 4px">已发布</span><?php endif; ?>
                        <a href="/index.php/Admin/ActivInfo/activDetail/id/<?php echo ($v["id"]); ?>" title="【<?php echo ($v["realname"]); ?>】发布于【<?php echo ($v["add_time"]); ?>】"><?php echo ($v["title"]); ?></a>

                        </td>
                        <td><?php echo ($v["cat_name"]); ?></td>
                        <td><?php echo ($v["integral"]); ?></td>
                        <td><?php echo ($v["link_name"]); ?></td>
                        <td><?php echo ($v["link_tel"]); ?></td>
                        <td><?php echo ($v["start_time"]); ?></td>
                        <td><a href="javascript:void(0);" onclick="joinUser(<?php echo ($v["id"]); ?>, <?php echo ($v["join_num"]); ?>);"><?php echo ($v["join_num"]); ?></a></td>
                        <td>
                            <div>
                                <?php if($v["is_over"] == 0): ?><button class="btn btn-default edit-btn editActivInfo" onclick="javascript:void(window.location.href = '/index.php/Admin/ActivInfo/edit/id/<?php echo ($v["id"]); ?>')">
                                        <span class="glyphicon glyphicon-edit"></span> 编辑
                                    </button>
                                    <?php if($v["is_open"] == 0): ?><button class="btn btn-success" onclick="openAct(<?php echo ($v["id"]); ?>)">
                                            <span class="glyphicon glyphicon-ok"></span> 开启
                                        </button>
                                        <?php else: ?>
                                        <button type="button" class="btn btn-danger" onclick="closeAct(<?php echo ($v["id"]); ?>)">
                                            <span class="glyphicon glyphicon-remove"></span> 关闭
                                        </button><?php endif; ?>
                                    <?php else: ?>
                                    <!--                                    <button class="btn btn-default edit-btn editActivInfo disabled">
                                                                            <span class="glyphicon glyphicon-edit"></span> 编辑
                                                                        </button>-->
                                    <button class="btn btn-default disabled">
                                        <span class="glyphicon glyphicon-ok"></span> 该活动已结束！
                                    </button><?php endif; ?>
                                <!--                                    
                                <button class="btn btn-danger" onclick="">
                                <span class="glyphicon glyphicon-remove"></span> 关闭
                                </button>-->
                                <!--
                                <button class="btn btn-default" onclick="publishInfoLayer(<?php echo ($v["id"]); ?>)">
                                <span class="glyphicon glyphicon-bullhorn"></span> 发布
                                </button>
                                <button class="btn btn-default list-btn" onclick="javascript:void(window.location.href='/index.php/Admin/ActivInfo/activDetail/id/<?php echo ($v["id"]); ?>')">
                                <span class="glyphicon glyphicon-zoom-in"></span> 查看
                                </button>
                                <button class="btn btn-default upload-btn" onclick="javascript:void(layer.msg('上传'))">
                                <span class="glyphicon glyphicon-upload"></span> 上传
                                </button>-->
                            </div>
                        </td>
                        </tr><?php endforeach; endif; endif; ?>
                <?php if(empty($infoList)): ?><tr><td colspan="9">暂无数据</td></tr><?php endif; ?>
            </table>
            <div style="text-align: center;"><?php echo ($page); ?></div>
        </div>
    </body>
    <div class="userListLayer" style="display: none;">
        <div class="container" style="width: 600px;">
            <div class="row">
                <table class="table table-hover" id="user_table">
                    <tr class="tableTitle">
                        <th>序号</th>
                        <th>姓名</th>
                        <th>电话</th>
                        <th>住址</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</html>