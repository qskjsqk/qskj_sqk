<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); echo (DATEPICKER); ?>
        <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css">
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="text/javascript" src="/Public/admin/js/common.js"></script>
        <script type="text/javascript" src="/Public/admin/js/system/userAppUserInfo.js"></script>
    </head>
    <body>
        <!--编辑用户信息-->
        <div class="container">
            <form method="post" action="#" class="form-horizontal" id="save-form" style="margin-top: 20px;">
                <input type="hidden" name="id" value="<?php echo ($userInfo["id"]); ?>"/>
                <div class="form-group">
                    <label for="address_id" class="col-sm-2 control-label">所属社区</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="address_id" name="address_id">
                            <!--<option value='0'>全体社区</option>-->
                            <option value='1'>翠景北里</option>
                            <option value='2'>翠屏北里</option>
                            <option value='3'>翠屏南里</option>
                            <option value='4'>大方居</option>
                            <option value='5'>格瑞雅居</option>
                            <option value='6'>葛布店东里</option>
                            <option value='7'>金侨时代</option>
                            <option value='8'>京洲园</option>
                            <option value='9'>靓景明居</option>
                            <option value='10'>梨园东里</option>
                            <option value='11'>龙鼎园</option>
                            <option value='12'>曼城家园</option>
                            <option value='13'>群芳园</option>
                            <option value='14'>万盛北里</option>
                            <option value='15'>欣达园</option>
                            <option value='16'>新城乐居</option>
                            <option value='17'>新华联南区</option>
                            <option value='18'>颐瑞东里</option>
                            <option value='19'>颐瑞西里</option>
                            <option value='20'>云景北里</option>
                            <option value='21'>云景东里</option>
                            <option value='22'>云景里</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="realname" class="col-sm-2 control-label">姓&#12288;&#12288;名</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="realname" name="realname" value="<?php echo ($userInfo["realname"]); ?>" placeholder="请输入真实姓名">
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必填</span></label>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">性&#12288;&#12288;别</label>
                    <div class="radio-inline" style="padding-left: 35px;">
                        <input type="radio" name="gender" id="man" value="0">男
                    </div>
                    <div class="radio-inline">
                        <input type="radio" name="gender" id="woman" value="1">女
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">出生日期</label>
                    <div class="col-sm-8" >
                        <input type="text" class="form-control" id="birthday" name="birthday" value="<?php echo ($userInfo["birthday"]); ?>" placeholder="请输入出生日期" readonly="readonly">
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必填</span></label>
                </div>
                <div class="form-group">
                    <label for="tel" class="col-sm-2 control-label">手机号码</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="tel" name="tel" value="<?php echo ($userInfo["tel"]); ?>" placeholder="请输入手机号码">
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必填</span></label>
                </div>
                <div class="form-group">
                    <label for="address" class="col-sm-2 control-label">地&#12288;&#12288;址</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo ($userInfo["address"]); ?>" placeholder="请输入地址">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否禁用</label>
                    <div class="radio-inline" style="padding-left: 35px;">
                        <input type="radio" name="is_enable" id="able" value="1">启用
                    </div>
                    <div class="radio-inline">
                        <input type="radio" name="is_enable" id="unable" value="0">禁用
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-9">
                        <button type="button" class="btn btn-primary" id="editInfo-btn">提&#12288;&#12288;交</button>
                        <button type="button" class="btn btn-warning" onclick="javascript:void(window.location.href = '/index.php/Admin/SysUserAppInfo/showList')">取&#12288;&#12288;消</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        $('#birthday').datepicker({changeMonth: true, changeYear: true});
        assignData.userInfo.is_enable==1?$('#able').attr('checked','checked'):$('#unable').attr('checked','checked');
        assignData.userInfo.gender==1?$('#woman').attr('checked','checked'):$('#man').attr('checked','checked');
    });
</script>