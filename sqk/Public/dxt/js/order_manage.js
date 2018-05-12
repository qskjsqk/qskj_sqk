/**
 * @name order_manage
 * @info 描述：订单管理脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-7 16:27:24
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    getOrderList(1, '');
});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取订单列表
 * @param {type} page
 * @param {type} keyword
 * @returns {undefined}
 */
function getOrderList(page, keyword) {
    $.get(c_path + "/getOrderList", {'page': page, 'keyword': keyword}, function (data) {
        var str = '';
        var btnStr = '';
        if (data.flag == 1) {
            for (var i = 0; i < data.data.length; i++) {
                str += '<div class="order-m-list">' +
                        '<div class="order-m-title">&#12288;<b>' + data.data[i]['name'] + '</b><span class="fontorder m-float-r m-margin-r15"><b>' + data.data[i]['deal_type'] + '</b></span></div>' +
                        '<div class="m-xjg"></div>' +
                        '<div class="order-m-footer">' +
                        '<span class="font12 fontblack m-float-l">订单号：' + data.data[i]['order_no'] + '</span>' +
                        '<span class="font12 fontblack m-float-r">' + data.data[i]['add_time'] + '</span>' +
                        '</div>' +
                        '<div class="m-xjg"></div>' +
                        '<div class="order-m-body">';

                for (var j = 0; j < data.data[i]['data'].length; j++) {
                    str += '<div class="order-m-body">' +
                            '<div class="order-m-item" style="background-image: url(' + res_path + data.data[i]['data'][j]['logo_img'] + ');">' +
                            '<span class="font14 fontblack"><b>' + data.data[i]['data'][j]['name'] + '</b></span><span class="m-float-r font13"><font class="fontorder font13">￥' + data.data[i]['data'][j]['item_price'] + '</font>&#12288;x' + data.data[i]['data'][j]['item_num'] + '</span>' +
                            '</div>' +
                            '</div>';
                }

                if (data.data[i]['deal_type1'] == 3) {
                    btnStr = '';
                } else if (data.data[i]['deal_type1'] == 0) {
                    btnStr = '<button type="button" class="btn btn-primary btn-xs" style="padding:1px 3px;margin:3px;float:right;color:#c00000;" onclick="changeDealType(' + data.data[i]['id'] + ',1)">重新购买</button>';
                } else {
                    if (data.data[i]['deal_type1'] == 1) {
                        btnStr = '<button type="button" class="btn btn-primary btn-xs" style="padding:1px 3px;margin:3px;float:right;" onclick="changeDealType(' + data.data[i]['id'] + ',0)">取消订单</button>';
                    } else {
                        btnStr = '<button type="button" class="btn btn-primary btn-xs" style="padding:1px 3px;margin:3px;float:right;color:green;" onclick="changeDealType(' + data.data[i]['id'] + ',3)">完成订单</button>' +
                                '<button type="button" class="btn btn-primary btn-xs" style="padding:1px 3px;margin:3px;float:right;" onclick="changeDealType(' + data.data[i]['id'] + ',0)">取消订单</button>';
                    }
                }

                str += '</div>' +
                        '<div class="m-xjg"></div><div class="order-m-footer" style="text-align:left;color:#777;font-size:13px;">备注：' + data.data[i]['buyer_note'] + btnStr + '</div><div class="m-xjg"></div>' +
                        '<div class="order-m-footer" style="text-align:right;">' +
                        '共&nbsp;<span class="fontorder">' + data.data[i]['item_count'] + '</span>&nbsp;件商品&#12288;<font color="#777">' + data.data[i]['send_type'] + '</font>&#12288; 合计：&nbsp;' +
                        '<span class="fontorder font14">￥' + data.data[i]['price_sum'] + '</span>&nbsp;元' +
                        '</div>' +
                        '</div>';
            }

        } else {
            mui.toast("暂无订单信息!", {duration: 'long', type: 'div'});
        }
        $('#orderList').html(str);
        //动态加载--------------------------------------------------------------		
        $("#page").val(data.page);
        if (data.is_end == 1) {
            $("#loadMore").removeAttr('onclick');
        } else {
            $("#loadMore").attr('onclick', 'loadMore()');
        }
        mui("#loadMore").button('reset');
        $("#loadMore").html(data.ajaxLoad);
        //---------------------------------------------------------------------
    }, 'json');
}

/**
 * 动态加载数据
 */
function loadMore() {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getOrderList(page, $('#keyword').val());
}

/**
 * 关键字查询
 * @returns {undefined}
 */
function keyWordSelect() {
    var keyword = $('#keyword').val();
    getOrderList(1, keyword);
}
/**
 * 修改订单状态
 * @param {type} id
 * @param {type} type
 * @returns {undefined}
 */
function changeDealType(id, type) {
    $.get(c_path + "/changeDealType", {'id': id, 'type': type}, function (data) {
        mui.toast(data.msg, {duration: 'long', type: 'div'});
        if (data.flag == 1) {
            getOrderList(1, '');
        }
    }, 'json');
}