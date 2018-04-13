/**
 * Created by GX on 2017-02-20.
 */
$(function() {
    //新增按钮绑定事件
    $('#saveInfo-btn').click(function(){
        var priviledges='';
        $("input[class='pri_unit']:checked").each(function(){
            if($(this).attr("disabled")!="disabled") {
                priviledges+=$(this).val()+',';
            }
        });
        $('input[name="priviledges"]').val(priviledges);
        $.post(c_path + '/saveUserInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS,{time: 1000},function(){
                    window.location.href=c_path + '/showList';
                });
            } else if(result.code == '502') {
                layer.msg(constants.FAILD,{time: 1000});
            }else{
                layer.msg(result.msgError,{time: 2000});
            }
        },'json');
    });
    //编辑按钮绑定事件
    $('#editInfo-btn').click(function(){
        var priviledges='';
        $("input[class='pri_unit']:checked").each(function(){
            if($(this).attr("disabled")!="disabled") {
                priviledges+=$(this).val()+',';
            }
        });
        $('input[name="priviledges"]').val(priviledges);
        $.post(c_path + '/editUserInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS,{time: 1000},function(){
                    window.location.href=c_path + '/showList';
                });
            } else if(result.code == '502') {
                layer.msg(constants.FAILD,{time: 1000});
            }else{
                layer.msg(result.msgError,{time: 2000});
            }
        },'json');
    });
    
      //修改资料事件
    $('#saveMyInfo-btn').click(function(){
        $.post(c_path + '/saveUserMyInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS,{time: 1000},function(){
                    window.location.href=m_path + '/index/main';
                });
            } else if(result.code == '502') {
                layer.msg(constants.FAILD,{time: 1000});
            }else{
                layer.msg(result.msgError,{time: 2000});
            }
        },'json');
    });

    $('#delArrayGroup-btn').click(function(){
        var isChecked='';
        if($("input[name='rowChecked']:checked").length <= 0){
            layer.msg('请选择批量删除的数据！',{time: 2000});return;
        }else{
            $('input[name="rowChecked"]:checked').each(function(){
                isChecked+=$(this).val()+',';
            });
            delUserLayer(isChecked);
        }
    });
    
});
//初始化权限面板
function initPrivPanel(){
    if($('input[name="priviledges"]').val()!=''){
        var priArray=$('input[name="priviledges"]').val().substring(0,$('input[name="priviledges"]').val().length-1).split(",");
        $.each(priArray,function(key,value){
            $('input[value="'+value+'"]').prop('checked', true);
        });
    }
}
//显示TreeViewPanel
function showUserGroupView(){
    //加载下拉树列表
    $.post(c_path + '/getTreeViewData', function (result) {
        treeData = result;//返回TreeView数据
        $('#treeview').show();
        var options = {
            bootstrap2 : false,
            showTags : true,
            levels : 5,
            //showCheckbox : true,
            //checkedIcon : "glyphicon glyphicon-check",
            data : buildDomTree(),
            onNodeSelected : function(event, data) {
                $("#category_name").val(data.text);
                $("#parent_id").val(data.id);
                $('input[type="checkbox"]:disabled').prop('checked', false);
                $('input[type="checkbox"]:disabled').attr('disabled',false);
                initGroupPrivPanel(data.id)
                $("#treeview").hide();
            }
        };
        $('#treeview').treeview(options);
        $('#treeview').treeview('collapseAll', { silent: true });
    }, 'json');
}
//初始化用户组权限
function initGroupPrivPanel(id){
    $.post(c_path + '/getGroupPrivInfo',{'id':id},function(result){
        if(result.code=='500'){
            var priArray=result.data.priviledges.substring(0,result.data.priviledges.length-1).split(",");
            $.each(priArray,function(key,value){
                $('input[value="'+value+'"]').prop('checked', true);
                $('input[type="checkbox"][value="'+value+'"]').attr('disabled','disabled');
            });
        }
    },'json');
}
//删除用户信息
function delUserLayer(isChecked){
    layer.confirm('确定要删除此用户嘛？', {
        icon:2,
        title:'提示信息',
        btn: ['确定','取消'] //按钮
    }, function(index){
        $.post(c_path + '/delArrUserInfo',{'ids':isChecked},function(result){
            if(result.code == '500'){
                layer.msg(constants.SUCCESS,{time: 1000},function(){
                    location.reload();
                });
            }else{
                layer.msg(constants.FAILD);
            }
        },'json');
    });
}
//实名认证
function rnsUserLayer(id){
    layer.open({
        type: 1,
        title: ['实名认证','font-size:16px;font-weight: bold;color: #2e8ded;'], //标题信息及样式
        skin: 'layui-layer-rim', //加上边框
        shadeClose:true,//是否点击遮罩关闭
        resize:false,//是否允许拉伸
        area: ['700px', '200px'], //宽高
        content: $('.rnsLayer'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        btn: ['审核通过', '审核不通过'],
        yes: function (index) {
            rnsUser(index,id,1);
        },
        btn2: function (index) {
            rnsUser(index,id,2);
        },
        success: function(layero){
            $.post(c_path + '/getData',{'id':id},function(result){
                if(result.code=='500'){
                    $('#realname').html(result.data.realname);
                    $('#idcard_num').html(result.data.idcard_num);
                    if(result.data.rns_type=='1'){
                        $('#checkStatus').html('通过');
                    }else if(result.data.rns_type=='2'){
                        $('#checkStatus').html('未通过');
                    }else{
                        $('#checkStatus').html('待审核');
                    }
                }
            },'json');
        }
    });
}
function rnsUser(index,id,flag){
    $.post(c_path + '/rnsUser',{'id':id,'flag':flag},function(result){
        if(result.code == '500'){
            layer.msg(constants.SUCCESS,{time: 1000},function(){
                location.reload();
            });
        }else{
            layer.msg(constants.FAILD);
        }
    });
}
/**
 * function:权限面板复选框全选
 * @param value
 */
function setCheck(value,id){
    var node=$('input[name="'+value+'"]');
    if(node.is(':checked')) {//选中
        $('input[name="'+value+id+'"]').prop('checked', true);
    }else{
        $('input[name="'+value+id+'"]:checked').each(function(){
            if($(this).attr("disabled")!="disabled") {
                $(this).prop('checked', false);
            }
        });
        //$('input[name="'+value+id+'"]').prop('checked', false);
    }
}