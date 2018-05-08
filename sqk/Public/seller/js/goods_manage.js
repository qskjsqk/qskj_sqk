/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    checkIsLogin();

    var type = getUrl('type');
    console.log(type);
    
    if(type==null){
        console.log('ajax加载全部');
    }else{
        console.log('ajax加载'+type);//辉总修改这里
    }

    $('#keyword').val('');
    getGoodsList(1, '', '');

    document.onkeydown = function (event_e) {
        if (window.event) {
            event_e = window.event;
        }
        console.log(event_e);
        var int_keycode = event_e.key || event_e.code;
        if (int_keycode == 'Enter') {
            getGoodsList(1, $('#keyword').val(), '');
            return false;
        }
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
                for(var i = 0; i < shuju.length; i++) {
                    var id = shuju[i]['id'];
                    str += '<div class="mui-card" onclick="toDetail('+ id +')">';
                    str += '<div class="mui-card-header"><div class="mui-card-link"><div class="seller_s"></div>' + shuju[i]['seller_name'] + '</div><p class="mui-card-link">距离1.5KM</p></div>';
                    str += '<div class="mui-card-content"><div class="item_list">';
                    str += '<div class="item_list_img"><img src="/' + shuju[i]['goods_pic'] + '"></div>';
                    str += '<div class="item_list_word"><span class="">' + shuju[i]['goods_name'] + '</span></div>';
                    var price = '';
                    if (shuju[i]['cat_id'] == 1 || shuju[i]['cat_id'] == 3) {
                        price = '￥' + shuju[i]['payment_amount'] + '元+' + shuju[i]['required_integral'] + '积分';
                    } else if (shuju[i]['cat_id'] == 2) {
                        price = shuju[i]['required_integral'] + '积分';
                    }
                    str += '<div class="item_list_word"><span class="fontred">' + price + '</span> <span class="font888">原价：￥' + shuju[i]['original_price'] + '</span> </div>';
                    str += ' </div></div>';
                    str += '</div>';
                }
            } else {
                str = '<span><center>暂时没有积分商品</center></span>';
            }
            //console.log(str);
            $("#goods-lists").html(str);
        } else {
            $("#goods-lists").html('服务器繁忙,请稍后再试');
        }

        //参数回显--------------------------------------------------------------
        $('#keyword').val(res.data.where.keyword);

        //动态加载--------------------------------------------------------------
        $("#page").val(res.data.page);
        if (res.data.is_end == 1) {
            $("#loadMore").removeAttr('onclick');
        } else {
            $("#loadMore").attr('onclick', 'loadMore()');
        }
        mui("#loadMore").button('reset');
        $("#loadMore").html(res.data.ajaxLoad);
        //---------------------------------------------------------------------

    }, 'json');
}

/**
 * 跳转到积分商品详情页
 */
function toDetail(id) {
    aHref(c_path + "/goods_detail/goods_id/" + id);
}

/**
 * 动态加载数据
 */
function loadMore() {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getGoodsList(page, $('#keyword').val(), '');
}

/**
 * 打开筛选
 */
function openSelect() {
    $('#realname').val('').removeAttr('readonly');
    $('#department').val('').removeAttr('readonly');
    $('#tel').val('').removeAttr('readonly');
    $('#phone').val('').removeAttr('readonly');
    $('#comment').val('').removeAttr('readonly');
    $('#detailBtn').css('display', 'block');
    openModal();
    $('#id').val(0);
    $('#aType').val('add');
}


/**
 * 打开模态框
 */
function openModal() {
    $(".m-modal-content").fadeIn(200);
    $(".m-modal").fadeIn(200);

    $(".m-modal").bind('click', function () {
        closeModal();
    });
}
/**
 * 关闭模态框
 */
function closeModal() {
    $(".m-modal-content").fadeOut(200);
    $(".m-modal").fadeOut(200);
}

function subForm() {
    getGoodsList(1, '', '');
    closeModal();
}

