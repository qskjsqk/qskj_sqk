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

//上/下积分商品(列表页)
function changeGoodsStatus(str) {
    var idStatusArray = str.split("-");
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
        operStatusSync('/goodsFrame', {id : idStatusArray[0], status : idStatusArray[1]});
    })
}

//ajax请求
function operStatusSync(requestAddress, param) {
    $.ajax({
        url : c_path + requestAddress,
        data : param,
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

//查看积分商品详情
function showGoodsInfo(id, seller_name) {
    layer.open({
        type: 1,
        title: [seller_name,'font-size:16px;font-weight: bold;color: #2e8ded;'], //标题信息及样式
        skin: 'layui-layer-rim', //加上边框
        shadeClose:true,//是否点击遮罩关闭
        resize:false,//是否允许拉伸
        area: ['650px', '500px'], //宽高
        content: $('.catLayer'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        /*btn: ['确定', '取消'],
        yes: function (index) {
            saveSellerCat(index);
        },
        cancel: function (index) {
        },*/
        success: function(layero){
            $.post(c_path + '/getGoodsInfoSync',{'id' : id},function(result){
                if(result.ret == 0) {
                    var data = result.data;
                    $("img[class='goods_pic']").attr('src', '/' + data.goods_pic);
                    $("p[class='goods_name']").html(data.goods_name);
                    $("p[class='required_integral']").html(data.required_integral + '积分');
                    $("p[class='seller_name']").html(seller_name);
                    $("p[class='goods_detail']").html(data.goods_detail);
                    $("p[class='use_of_knowledge']").html(data.use_of_knowledge);
                } else {
                    alert(result.msg);
                }
            },'json');
        }
    });
}




