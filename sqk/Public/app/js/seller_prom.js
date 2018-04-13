/**
 * @name seller_prom
 * @info 描述：卖家促销脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-3 16:33:53
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    var id = getUrl('id');
    getDetail(id);
});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取商家详情
 * @param {Object} id
 */
function getDetail(id) {
    $.get(c_path + "/getPromDetail/id/" + id, function (data) {
        if (data.flag == 1) {
            $("#sellerName").html('<b class="fontblack">' + data.name + '</b>');
            $("#prom_title").html('<font class="fontorder">' + data.title + '</font>');
            $("#prom_ftitle").html(data.ftitle);
            //为增强体验 图片加载完成之前隐藏，加载完成后显示
            $("#prom_content").css('display', 'none');
//            $("#prom_content").html(data.content.replace(/style="(.)*?"|^\s*|\&nbsp;/gi, ''));
            $("#prom_content").html(data.content);
            $('#prom_content table').css({'width': '100%'});
            $('#prom_content table').attr({'border': '1'});
            $('#prom_content').html(img_reset($('#prom_content').html()));
            if ($('#prom_content img').length > 0) {
                $('#prom_content img').each(function () {
                    $(this).css({'padding': '5px 0'});
                    $(this).attr('src', delHttp(this.src));
                    $(this).load(function () {
                        var img = new Image();
                        img.src = this.src;
                        $(this).css({'width': '100%'});
                        $("#prom_content").css('display', 'block');
                    });
                });
            } else {
                $("#prom_content").css('display', 'block');
            }



            $("#read_num").html(data.read_num);
            var itemListStr = '';
            var orderItemListStr = '';
            if (data.item.flag == 1) {
                for (var i = 0; i < data.item.data.length; i++) {
                    itemListStr += '<div class="item-list" style="background-image: url(' + res_path + data.item.data[i]['logo_img'] + ');">' +
                            '<div class="item-title-title">' +
                            '<span class="font16"><b>' + data.item.data[i]['name'] + '</b></span>' +
                            '<div class="item-detail font12 fontblack">【' + data.item.data[i]['cat_name'] + '】' + data.item.data[i]['introduction'] +
                            '<p class="font11">销量&#12288;' + data.item.data[i]['sold_num'] + data.item.data[i]['quantifier'] + '</p>' +
                            '<p class="fontred m-float-l font20"><b>￥' + data.item.data[i]['price'] + '</b>&nbsp;/' + data.item.data[i]['quantifier'] + '</p>' +
                            '<div class="mui-numbox price-numbox">' +
                            '<button class="mui-btn mui-btn-numbox-minus price-btn" type="button" style="background-image: url(' + public + '/app/img/jian.png);width: 20px;height: 20px;" onclick="delShopCar(' + data.item.data[i]['id'] + ',' + data.item.data[i]['price'] + ')"></button>' +
                            '<input class="mui-input-numbox" type="number" readonly="readonly" value="0" id="input-' + data.item.data[i]['id'] + '"/>' +
                            '<button class="mui-btn mui-btn-numbox-plus price-btn" type="button" style="background-image: url(' + public + '/app/img/jia.png);width: 20px;height: 20px;" onclick="addShopCar(' + data.item.data[i]['id'] + ',' + data.item.data[i]['price'] + ')"></button>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                }
                for (var i = 0; i < data.item.data.length; i++) {
                    orderItemListStr += '<input type="hidden" id="item-' + data.item.data[i]['id'] + '" value="" style="display:none;"><div class="order-item-info" style="background-image: url(' + res_path + data.item.data[i]['logo_img'] + ');display:none;" id="orderList-' + data.item.data[i]['id'] + '">' +
                            '<div class="order-item-info-r">' +
                            '<p class="font14 fontblack"><b>' + data.item.data[i]['name'] + '</b></p>' +
                            '<p class="fontred m-float-l font16">￥' + data.item.data[i]['price'] + '</b>&#12288;</p>' +
                            '<div class="mui-numbox order-numbox">' +
                            '<button class="mui-btn mui-btn-numbox-minus price-btn" type="button" style="background-image: url(' + public + '/app/img/jian.png);width: 20px;height: 20px;" onclick="delShopCar(' + data.item.data[i]['id'] + ',' + data.item.data[i]['price'] + ')"></button>' +
                            '<input class="mui-input-numbox" type="number" readonly="readonly" value="0" id="orderInput-' + data.item.data[i]['id'] + '"/>' +
                            '<button class="mui-btn mui-btn-numbox-plus price-btn" type="button" style="background-image: url(' + public + '/app/img/jia.png);width: 20px;height: 20px;" onclick="addShopCar(' + data.item.data[i]['id'] + ',' + data.item.data[i]['price'] + ')"></button>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                }

            } else {
                //暂无商品
                itemListStr = '<div style="text-align:center;margin-bottom:10px;color:#777;">(=￣ω￣=)&#12288;马上添加商品吧！</div>';
                orderItemListStr = '暂无商品';
            }
            $('#itemList').html(itemListStr);
            $('#orderItemList').html(orderItemListStr);
        } else {

        }
    }, 'json');
}

/**
 * 添加购物车
 * @param {Object} id
 * @param {Object} price
 */
function addShopCar(id, price) {
    var inputVal = parseInt($("#input-" + id).val());
    if (inputVal < 99) {
        $("#input-" + id).val(inputVal + 1);
        $("#orderInput-" + id).val(inputVal + 1);
        //底栏
        $("#count_num").html(parseInt($("#count_num").html()) + 1);
        $("#sum_price").html((parseFloat($("#sum_price1").html()) + price).toFixed(1));
        //订单
        $("#count_num1").html(parseInt($("#count_num1").html()) + 1);
        $("#sum_price1").html((parseFloat($("#sum_price1").html()) + price).toFixed(1));

        $("#orderList-" + id).css('display', 'blank');
        $("#item-" + id).attr('readonly', 'readonly');
        $("#item-" + id).val(id + '-' + parseInt($("#input-" + id).val()) + '-' + price);
    } else {
        mui.toast("最大购买数量为99!", {duration: 'long', type: 'div'});
    }
}

/**
 * 移除购物车 
 * @param {Object} id
 * @param {Object} price
 */
function delShopCar(id, price) {
    var inputVal = parseInt($("#input-" + id).val());
    if (inputVal > 0) {
        $("#input-" + id).val(inputVal - 1);
        $("#orderInput-" + id).val(inputVal - 1);
        //底栏
        $("#count_num").html(parseInt($("#count_num").html()) - 1);
        $("#sum_price").html((parseFloat($("#sum_price1").html()) - price).toFixed(1));
        //订单
        $("#count_num1").html(parseInt($("#count_num1").html()) - 1);
        $("#sum_price1").html((parseFloat($("#sum_price1").html()) - price).toFixed(1));

        $("#item-" + id).val(id + '-' + parseInt($("#input-" + id).val()) + '-' + price);
        if (parseInt($("#input-" + id).val()) == 0) {
            $("#orderList-" + id).css('display', 'none');
            $("#item-" + id).removeAttr('readonly');
        }
    } else {
        mui.toast("购买数量不可为负!", {duration: 'long', type: 'div'});
    }
}

/**
 * 打开模态框
 */
function openModal() {
    $(".m-modal-content").fadeIn(200);
    $(".m-modal").fadeIn(200);
    $("#buy-div").css('display', 'none');
    $("#buyerNote").val('');
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
    $("#buy-div").css('display', 'inline-block');
}

/**
 * 取消订单
 */
function cancelOrder() {
    closeModal();
    mui.toast('取消订单！');
}

/**
 * 提交订单
 */
function subOrder() {
    var itemStr = getItemArr();
    if (itemStr == 0) {
        mui.toast('购物车里没有商品！');
        closeModal();
    } else {
        var seller_id = getUrl('seller_id');
        var btnArray = ['取消', '提交'];
        mui.confirm('确认提交订单吗？', '提示', btnArray, function (e) {
            if (e.index == 1) {
                getItemArr();
                $.post(c_path + "/createOrder", {
                    'seller_id': seller_id,
                    'sendType': $("#sendType").val(),
                    'address_id': 1,
                    'buyer_note': $("#buyerNote").val(),
                    'itemStr': itemStr,
                }, function (data) {
                    if (data.flag == 1) {
                        mui.toast('提交订单成功！');
                        resetZero();
                    } else {
                        mui.toast(data.msg);
                    }
                }, 'json');
                closeModal();
            }
        });
    }

    //	mui.toast('提交订单成功！');
}

/**
 * 获取购买者地址
 * @param {type} type
 * @returns {undefined}
 */
function getBuyerAddr(type) {
    if (type == 0) {
        //不需要地址
        $("#orderAddr").css('display', 'none');
        $("#sendType").val(0);
    } else {
        $.get(c_path + "/getBuyerAddr", function (data) {
            if (data.flag == 0) {
                mui.toast('无该用户信息！');
                closeModal();
            } else {
                if (data.data['realname'] == null || data.data['tel'] == null || data.data['address'] == null || data.data['realname'] == '' || data.data['tel'] == '' || data.data['address'] == '') {
                    mui.toast('为了送货上门，请完善您的信息');
                    $("#sendType").val(0);
                    $('#sm').removeClass('mui-selected');
                    $('#zt').addClass('mui-selected');
                    closeModal();
                } else {
                    $("#orderAddr").css('display', 'blank');
                    $("#sendType").val(1);
                    $('#orderAddr').html(data.data['realname'] + '&#12288;&#12288;' + data.data['tel'] + '<div class="order-xjg"></div>' + data.data['address']);
                }
            }
        }, 'json');
    }
}

/**
 * 获取商品列表
 */
function getItemArr() {
    var input = $('#orderItemList').find('input[type="hidden"][readonly="readonly"]');
    if (input.length > 0) {
        var str = '';
        $('#orderItemList input[type="hidden"][readonly="readonly"]').each(function () {
            str += ',' + $(this).val();
        });
        return str;
    } else {
        return 0;
    }
}

/**
 * 提交订单成功后置零
 * @returns {undefined}
 */
function resetZero() {
    $('input[type="number"]').each(function () {
        this.value = 0;
    });
    $('.order-item-info').css('display', 'none');
    $('#orderItemList input[type="hidden"][readonly="readonly"]').each(function () {
        $(this).removeAttr('readonly');
        $(this).val('');
    });
    $('.mui-input-numbox').find('iput').val(0);
    //底栏
    $("#count_num").html(0);
    $("#sum_price").html(0);
    //订单
    $("#count_num1").html(0);
    $("#sum_price1").html(0);
    var id = getUrl('id');
    getDetail(id);
}

/**
 * 返回列表页
 * @returns {undefined}
 */
function back() {
    window.location.href = "seller_home.html?cat_id=1";
}