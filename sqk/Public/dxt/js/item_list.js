/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    checkIsLogin();
    $('#keyword').val('');
    getGoodsList(1, '', '', '', '');

    document.onkeydown = function (event_e) {
        if (window.event) {
            event_e = window.event;
        }
        console.log(event_e);
        var int_keycode = event_e.key || event_e.code;
        if (int_keycode == 'Enter') {
            getGoodsList(1, $('#keyword').val(), '', '', '');
            return false;
        }
    }


});


//函数--------------------------------------------------------------------------------------------
/**
 * 获取积分商品列表
 * @param {Object} page
 */
function getGoodsList(page, keyword, orderBy, address, cat_type) {
    $.post(c_path + "/getList", {'page': page, 'keyword': keyword, 'address': address, 'orderBy': orderBy, 'cat_type': cat_type}, function (res) {
        if (res.ret == 0) {
            $("#goods-lists").html('');
            var str = '';
            if (res.data.isEmpty == 1) {
                var shuju = res.data.lists;
                for (var i = 0; i < shuju.length; i++) {
                    str += '<div class="mui-card">';
                    str += '<div class="mui-card-header"><div class="mui-card-link"><div class="seller_s"></div>' + shuju[i]['seller_name'] + '</div><p class="mui-card-link">' + shuju[i]['com_name'] + '</p></div>';
                    str += '<div class="mui-card-content" onclick="getDetail(' + shuju[i]['id'] + ')"><div class="item_list">';
                    str += '<div class="item_list_img"><img src="/' + shuju[i]['goods_pic'] + '" style="width:70px;height:70px;"></div>';
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
            $("#goods-lists").html(str);
        } else {
            $("#goods-lists").html('服务器繁忙,请稍后再试');
        }

        //参数回显--------------------------------------------------------------
        $('#keyword').val(res.data.where.keyword);
        if (res.data.where.orderBy != '') {
            $("input:radio[name='orderBy'][value='" + res.data.where.orderBy + "']").attr("checked", true);
        }
        if (res.data.where.address != '') {
            $("input:radio[name='address'][value='" + res.data.where.address + "']").attr("checked", true);
        }
        if (res.data.where.cat_type != 0) {
            $("input:radio[name='cat_type'][value='" + res.data.where.cat_type + "']").attr("checked", true);
        }


        //动态加载--------------------------------------------------------------
        $("#page").val(res.data.where.page);
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
 * 动态加载数据
 */
function loadMore() {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getGoodsList(page, $('#keyword').val(), '', '', '');
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
    var orderBy = $('input[name="orderBy"]:checked').val();
    var address = $('input[name="address"]:checked').val();
    var cat_type = $('input[name="cat_type"]:checked').val();

    getGoodsList(1, '', orderBy, address, cat_type);
    closeModal();
}

function getDetail(id) {
    aHref(c_path + '/goods_detail?id=' + id);
}
