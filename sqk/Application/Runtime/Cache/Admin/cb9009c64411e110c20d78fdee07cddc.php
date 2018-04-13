<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); echo (DATEPICKER); ?>
        <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css">
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <script type="text/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="text/javascript" src="/Public/Plugin/ueditor1.4.3.3/ueditor.config.js" charset="UTF-8"></script>
        <script type="text/javascript" src="/Public/Plugin/ueditor1.4.3.3/ueditor.all.min.js" charset="UTF-8"></script>
        <script type="text/javascript" src="/Public/Plugin/ueditor1.4.3.3/lang/zh-cn/zh-cn.js" charset="UTF-8"></script>
        <script type="text/javascript" src="/Public/admin/js/common.js"></script>
        <script type="text/javascript" src="/Public/admin/js/seller/sellerInfo.js"></script>
    </head>
    <body>
        <!--添加信息-->
        <div class="container">
            <form method="post" action="/index.php/Admin/SellerInfo/savePerfectInfo" enctype="multipart/form-data" class="form-horizontal" id="save-form" style="margin-top: 20px;">
                <input type="hidden" name="id" value="<?php echo ($sellerInfo["id"]); ?>"/>
                <input type="hidden" name="user_id" value="<?php echo ($sellerInfo["user_id"]); ?>"/>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">商家名称</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo ($sellerInfo["name"]); ?>" placeholder="请输入名称">
                        <?php if($errorMsg['name'] != ''): ?><span class="tipMsg"><?php echo ($errorMsg['name']); ?></span><?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="category_name" class="col-sm-2 control-label">商家类别</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo ($sellerInfo["category_name"]); ?>" onclick="showTreeView();" placeholder="请选择类别" readonly>
                        <input type="hidden" id="parent_id" name="cat_id" value="<?php echo ($sellerInfo["cat_id"]); ?>"/>
                        <div class="col-sm-11 dropdown-menu" id="treeview" style="display: none;margin-left:15px;z-index: 111111111;"></div>
                        <?php if($errorMsg['cat_id'] != ''): ?><span class="tipMsg"><?php echo ($errorMsg['cat_id']); ?></span><?php endif; ?>
                    </div>
                    <!--<label class="col-sm-2 control-label"><span class="tipMsg">*必选</span></label>-->
                    <!--<div class="col-sm-9" id="treeview" style="display: none;"></div>-->
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">营业时间</label>
                    <div class="col-sm-3" >
                        <div class="input-group">
                            <input type="text" class="form-control" id="work_start" name="work_start" value="<?php echo ($sellerInfo["work_start"]); ?>" placeholder="请输入起始时间">
                            <span class="input-group-addon">至</span>
                            <input type="text" class="form-control" id="work_end" name="work_end" value="<?php echo ($sellerInfo["work_end"]); ?>" placeholder="请输入结束时间">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel" class="col-sm-2 control-label">商家电话</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="tel" name="tel" value="<?php echo ($sellerInfo["tel"]); ?>" placeholder="请输入商家电话">
                        <?php if($errorMsg['tel'] != ''): ?><span class="tipMsg"><?php echo ($errorMsg['tel']); ?></span><?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-sm-2 control-label">商家地址</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo ($sellerInfo["address"]); ?>" placeholder="请输入商家地址">
                        <?php if($errorMsg['address'] != ''): ?><span class="tipMsg"><?php echo ($errorMsg['address']); ?></span><?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否歇业</label>
                    <div class="radio-inline" style="padding-left: 35px;">
                        <input type="radio" name="is_rest" id="rest" value="1">歇业
                    </div>
                    <div class="radio-inline">
                        <input type="radio" name="is_rest" id="enrest" value="0" checked>营业
                    </div>
                </div>
                <div class="form-group">
                    <label for="logo_icon" class="col-sm-2 control-label">商家Logo</label>
                    <div class="col-sm-2">
                        <input type="file" id="logo_icon" name="logo_icon" value="<?php echo ($sellerInfo["logo_icon"]); ?>">
                        <?php if($fileErrorMsg != ''): ?><span class="tipMsg"><?php echo ($fileErrorMsg); ?></span><?php endif; ?>
                    </div>
                </div>
                <?php if($sellerInfo["logo_icon"] != ''): ?><div class="form-group">
                        <label for="logo_icon" class="col-sm-2 control-label"></label>
                        <div class="col-sm-8">
                            <span>Logo图片：<a href="/Public/Upload<?php echo ($sellerInfo["logo_icon"]); ?>" target="_blank"><?php echo ($sellerInfo["logo_icon"]); ?></a></span>
                        </div>
                    </div><?php endif; ?>
                <div class="form-group">
                    <label for="editor" class="col-sm-2 control-label">商家介绍</label>
                    <div class="col-sm-8">
                        <script id="editor" type="text/plain" name="introduction"></script>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary" id="saveInfo-btn">保&#12288;存</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(function () {
            var introEditor = UE.getEditor('editor', {
                //这里可以选择自己需要的工具按钮名称
                toolbars: [[
                        'fullscreen', 'source', '|', 'undo', 'redo', '|',
                        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
                        'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                        'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                        'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                        'link', 'unlink', '|', 'simpleupload', 'insertimage'
                    ]],
                //focus时自动清空初始化时的内容
                autoClearinitialContent: true,
                //关闭字数统计
                wordCount: true,
                //关闭elementPath
                elementPathEnabled: false,
                //默认的编辑区域高度
                initialFrameHeight: 450,
            })
            //初始化编辑器的值
            introEditor.ready(function () {
                introEditor.setContent('<?php echo ($sellerInfo["introduction"]); ?>');
            });
            $('#work_start').timepicker();
            $('#work_end').timepicker();
            $('input[name="is_rest"][value="<?php echo ($sellerInfo["is_rest"]); ?>"]').prop("checked", true);
            //$('input[name="' + key + '"][value="' + value + '"]').prop("checked", true);
        });
    </script>
</html>