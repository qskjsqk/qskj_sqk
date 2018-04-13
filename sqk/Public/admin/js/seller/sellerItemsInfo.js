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
            //$.post(c_path + '/delArrayInfo', {'ids':isChecked},function(result){
            //    location.reload();
            //});
        }
    });
    //批量审核按钮绑定事件
    $('#checkArrayInfo-btn').click(function(){
        var isChecked='';
        if($("input[name='rowChecked']:checked").length <= 0){
            layer.msg('请选择批量删除的数据！',{time: 2000});return;
        }else{
            $('input[name="rowChecked"]:checked').each(function(){
                isChecked+=$(this).val()+',';
            });
            checkInfoLayer(isChecked);
        }
    });
});
//删除商家信息
function delInfoLayer(isChecked){
    layer.confirm('确定要批量删除此信息嘛？', {
        icon:2,
        title:'提示信息',
        btn: ['确定','取消'] //按钮
    }, function(index){
        $.post(c_path + '/delArrayItemsInfo',{'ids':isChecked},function(result){
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
//审核商家服务项目信息
function checkInfoLayer(isChecked){
    layer.confirm('确定要批量审核此服务项目信息嘛？', {
        icon:2,
        title:'提示信息',
        btn: ['确定','取消'] //按钮
    }, function(index){
        $.post(c_path + '/checkArrayItemsInfo',{'ids':isChecked},function(result){
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