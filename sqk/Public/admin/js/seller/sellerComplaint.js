/**
 * 商家反馈信息JS
 * Created by GX on 2018-04-21.
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

    //标记反馈信息位已处理(列表页)
    $(".table tr:gt(0)").each(function () {
        $(this).find("td").last().find("button:eq(1)").click(function () {
            var id = $(this).attr('title');
            layer.confirm('确定要标记为已处理吗？', {
                icon:2,
                title:'提示信息',
                btn: ['确定','取消'] //按钮
            }, function(index){
                /*$.ajax({
                    url : c_path + '/markedAsProcessed',
                    data : {id : id},
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
                })*/
                operStatusSync(id);
            })
        })
    })
    
});


//删除商家反馈信息
function delInfoLayer(isChecked){
    layer.confirm('确定要删除该商家?', {
        icon:2,
        title:'提示信息',
        btn: ['确定','取消'] //按钮
    }, function(index){
        $.post(c_path + '/delBatchSellerComplaint',{'ids':isChecked},function(result){
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

//标记反馈信息位已处理(详情页)
function changeStatus(id) {
    layer.confirm('确定要标记为已处理吗？', {
        icon:2,
        title:'提示信息',
        btn: ['确定','取消'] //按钮
    }, function(index){
        /*$.ajax({
            url : c_path + '/markedAsProcessed',
            data : {id : id},
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
        })*/
        operStatusSync(id);
    })
}

function operStatusSync(id) {
    $.ajax({
        url : c_path + '/markedAsProcessed',
        data : {id : id},
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




