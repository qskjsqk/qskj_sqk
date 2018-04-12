/**
 * 商家订单信息JS
 * Created by GX on 2017-02-20.
 */
$(function(){
});
//处理商家订单信息弹出层
function dealInfoLayer(id){
    var strHtml='<form class="form-horizontal">' +
                    '<div class="container" style="width: 300px;">'+
                        '<div class="row">'+
                            '<div class="form-group" style="margin-top: 20px;">' +
                                '<label for="deal_type" class="col-sm-4 control-label">处理状态</label>'+
                                '<div class="col-sm-8">' +
                                    '<select id="order_deal_type" class="form-control">'+
                                        '<option value="2">处理中</option>'+
                                        '<option value="3">交易完成</option>'+
                                        '<option value="0">取消订单</option>'+
                                    '</select>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</form>';
    layer.open({
        type:1,
        title:['订单处理','font-size:16px;font-weight: bold;color: #2e8ded;'],
        skin: 'layui-layer-rim', //加上边框
        shadeClose:true,//是否点击遮罩关闭
        resize:false,//是否允许拉伸
        area: ['350px', '180px'], //宽高
        content: strHtml, //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        zIndex:111111111,
        btn: ['确定', '取消'],
        yes: function (index) {
            dealSellerOrderInfo(index,id,$('#order_deal_type').val());
        },
        cancel: function (index) {
        }
    });return;
}

//处理单条商家订单信息
function dealSellerOrderInfo(index,id,deal_type){
    layer.close(index);
    layer.confirm('确定要处理此订单嘛？', {
        icon:2,
        title:'提示信息',
        btn: ['确定','取消'] //按钮
    }, function(index){
        $.post(c_path + '/dealSellerOrderInfo',{'id':id,'deal_type':deal_type},function(result){
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
//显示订单列表
function showOrderItemsList(id){
    var strHtml='';
    var items_sum= 0,price_sum=0;
    $.post(c_path + '/showOrderItemsList',{'order_id':id},function(result){
        $.each(result,function(key,value){
            items_sum+=parseInt(value['item_num']);
            price_sum+=parseFloat(value['price']);
            strHtml+='<div style=" background-color: #f5f5f5; margin-top: 5px;"><img src="'+public+'/Upload'+value['logo_img']+'" style="width: 85px;height: 70px;"/><span style="margin-left: 10px;display:-moz-inline-box; display:inline-block; width: 250px;">'+value['name']+'</span><span style="margin-left: 30px;">单价：￥'+value['item_price']+'</span><span style="margin-left: 30px;">数量：×'+value['item_num']+'</span></div>';
        });
        strHtml+='<div><span style="float: right;margin-top: 10px;">共'+items_sum+'件商品 合计：￥'+price_sum.toFixed(1)+'</span></div>';
        $('#items'+id).html(strHtml);
    },'json');
}


