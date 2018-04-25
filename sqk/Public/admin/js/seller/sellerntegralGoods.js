/**
 * 积分商品JS
 * Created by xiaohuihui on 2018-04-24.
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
    })

    //上/下积分商品(列表页)
    $(".table tr:gt(0)").each(function () {
        $(this).find("td").last().find("button:eq(2)").click(function () {
            var idStatusStr = $(this).attr('title');
            var idStatusArray = idStatusStr.split("-");
            if(idStatusArray[1] == 1) {
                var operNotice = '确定要下架该商品吗？';
            } else if(idStatusArray[1] == 2) {
                var operNotice = '确定要将该商品上架吗？';
            }
            layer.confirm(operNotice, {
                icon:2,
                title:'提示信息',
                btn: ['确定','取消'] //按钮
            }, function(index){
                operStatusSync(idStatusArray[0], idStatusArray[1]);
            })
        })
    })
    
});


//删除积分商品
function delInfoLayer(isChecked){
    layer.confirm('确定要删除该积分商品吗?', {
        icon:2,
        title:'提示信息',
        btn: ['确定','取消'] //按钮
    }, function(index){
        $.post(c_path + '/delBatchSellerIntegralGoods',{'ids':isChecked},function(result){
            if(result.ret == 0){
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

function operStatusSync(id, status) {
    $.ajax({
        url : c_path + '/goodsFrame',
        data : {id : id, status : status},
        type : 'post',
        success : function (res) {
            if(res.ret == 0) {
                layer.msg(constants.SUCCESS,{time: 1000},function(){
                    location.reload();
                });
            } else {
                layer.msg(res.msg);
            }
        }
    })
}




