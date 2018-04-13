/**
 * 商家信息JS
 * Created by GX on 2017-02-20.
 */
$(function() {
    //批量删除按钮绑定事件
    $('#delArrayInfo-btn').click(function(){
        var isChecked='';
        if($("input[name='rowChecked']:checked").length <= 0){
            layer.msg('请选择批量删除的数据！',{time: 2000});return;
        }else{
            $('input[name="rowChecked"]:checked').each(function(){
                isChecked+=$(this).val()+',';
            });
            delInfoLayer(isChecked);
        }
    });
    //批量审核按钮绑定事件
    $('#checkArrayInfo-btn').click(function(){
        var isChecked='';
        if($("input[name='rowChecked']:checked").length <= 0){
            layer.msg('请选择批量审核的数据！',{time: 2000});return;
        }else{
            $('input[name="rowChecked"]:checked').each(function(){
                isChecked+=$(this).val()+',';
            });
            checkInfoLayer(isChecked);
        }
    });
    //涉及相关社区参数
    //assignData.address_id 登录用户所属社区
    if (action == "edit") {
        console.log(assignData);
        if (assignData.address_id != 0) {
            $("#address_id").find("option[value='" + assignData.address_id + "']").attr("selected", 'selected');
            $("#address_id").find("option[value!='" + assignData.address_id + "']").attr("disabled", "disabled");
        } else {
            $("#address_id").find("option[value='" + assignData.sellerInfo.address_id + "']").attr("selected", 'selected');
        }
    } else if (action == "add") {
        if (assignData.address_id != 0) {
            $("#address_id").find("option[value='" + assignData.address_id + "']").attr("selected", 'selected');
            $("#address_id").find("option[value!='" + assignData.address_id + "']").attr("disabled", "disabled");
        }
    }
    
});
//删除商家信息
function delInfoLayer(isChecked){
    layer.confirm('确定要删除所有商家相关信息(包括历史订单)?', {
        icon:2,
        title:'提示信息',
        btn: ['确定','取消'] //按钮
    }, function(index){
        $.post(c_path + '/delArraySellerInfo',{'ids':isChecked},function(result){
            if(result.code == '500'){
                layer.msg(constants.SUCCESS,{time: 1000},function(){
                    location.reload();
                    window.parent.getNewNum();
                });
            }else if(result.code == '502'){
                layer.msg(constants.FAILD);
            }else{
                layer.msg(constants.ERRORMSG);
            }
        },'json');
    });
}
//审核商家信息
function checkInfoLayer(isChecked){
    layer.confirm('确定要批量审核此信息嘛？', {
        icon:2,
        title:'提示信息',
        btn: ['确定','取消'] //按钮
    }, function(index){
        $.post(c_path + '/checkArrayInfo',{'ids':isChecked},function(result){
            if(result.code == '500'){
                layer.msg(constants.SUCCESS,{time: 1000},function(){
                    location.reload();
                    window.parent.getNewNum();
                });
            }else{
                layer.msg(constants.FAILD);
            }
        },'json');
    });
}