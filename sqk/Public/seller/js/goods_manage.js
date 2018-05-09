/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    checkIsLogin();

    var type = getUrl('type');
    console.log(type);


    if (type == null) {
        getGoodsList(1, '', '');
    } else {
        getGoodsList(1, '', type);
    }

});


/**
 * 获取积分商品列表
 * @param {Object} page
 */
function getGoodsList(page, keyword, status) {
    $.post(c_path + "/getList", {'page': page, 'keyword': keyword, 'status': status}, function (res) {
        if (res.ret == 0) {
            $("#goods-lists").html('');
            var str = '';
            if (res.data.isEmpty == 1) {
                var shuju = res.data.lists;
                for (var i = 0; i < shuju.length; i++) {
                    var id = shuju[i]['id'];
                    str += '<div class="mui-card" onclick="toDetail(' + id + ')">';
                    str += '<div class="mui-card-header"><div class="mui-card-link"><div class="seller_s"></div>' + shuju[i]['goods_name'] + '</div><p class="mui-card-link"><a href="' + c_path + '/goods_edit/goods_id/' + id + '"><button style="margin-top:5px;" class="mui-btn mui-btn-primary mui-btn-outlined">修改</button></a></div>';
                    str += '<div class="mui-card-content"><div class="item_list">';
                    str += '<div class="item_list_img"><img src="/' + shuju[i]['goods_pic'] + '" style="width:70px;height:70px;"></div>';
//                    str += '<div class="item_list_word"><span class="">' + shuju[i]['status'] + '</span></div>';
                    var price = '';
                    if (shuju[i]['cat_id'] == 1 || shuju[i]['cat_id'] == 3) {
                        price = '￥' + shuju[i]['payment_amount'] + '元+' + shuju[i]['required_integral'] + '积分';
                    } else if (shuju[i]['cat_id'] == 2) {
                        price = shuju[i]['required_integral'] + '积分';
                    }

                    var statusStr = '';
                    if (shuju[i]['status'] == 0) {
                        statusStr = '[未发布]&nbsp;';
                    } else if (shuju[i]['status'] == 1) {
                        statusStr = '<font class="fontgreen">[已发布]</font>&nbsp;';
                    } else {
                        statusStr = '<font class="fontred">[已下架]</font>&nbsp;';
                    }
                    str += '<div class="item_list_word"><span class="fontred font16">' + price + '</span></div>';
                    str += '<div class="item_list_word"><span class="font888">' + statusStr + '原价：￥' + shuju[i]['original_price'] + '</span></div>';
                    str += ' </div></div>';
                    str += '</div>';
                }
            } else {
                str = '<span><center>暂时没有积分商品</center></span>';
            }
            $("#goods-lists").html(str);
        } else {
            $("#goods-lists").html('服务器繁忙,请稍后再试');
        }

        //参数回显--------------------------------------------------------------
        $('#type').val(res.data.where.type);
        //---------------------------------------------------------------------

    }, 'json');
}

/**
 * 跳转到积分商品详情页
 */
function toDetail(id) {
    aHref(c_path + "/goods_detail/goods_id/" + id);
}


