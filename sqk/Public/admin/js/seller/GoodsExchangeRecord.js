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
    
});


//删除积分商品
function delInfoLayer(isChecked){
    layer.confirm('确定要删除交易记录吗?', {
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


//ajax请求
function operStatusSync(requestAddress, param) {
    var flag = false;
    $.ajax({
        url : c_path + requestAddress,
        data : param,
        type : 'post',
        async : false,
        success : function (res) {
            if(res.ret == 0) {
                flag = res.data;
            }
        }
    })
    return flag;
}

//查看交易详情
function showExchangeInfo(id) {
    layer.open({
        type: 1,
        title: ['交易详情','font-size:16px;font-weight: bold;color: #2e8ded;'], //标题信息及样式
        skin: 'layui-layer-rim', //加上边框
        shadeClose:true,//是否点击遮罩关闭
        resize:false,//是否允许拉伸
        area: ['500px', '400px'], //宽高
        content: $('.catLayer'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        success: function(layero){
            data = operStatusSync('/getExchangeInfoSync', {'id' : id});
            if(data) {
                $("p[class='goods_name']").html(data.goods_name);
                $("p[class='seller_name']").html(data.seller_name);
                $("p[class='exchange_time']").html(data.exchange_time);
                $("p[class='usr']").html(data.usr);
                $("p[class='realname']").html(data.realname);
                $("p[class='com_name']").html(data.com_name);
                $("p[class='exchange_number']").html(data.exchange_number);
            } else {
                alert('获取失败,请关闭弹框重试');
            }
        }
    });
}




