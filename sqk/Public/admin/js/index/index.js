/**
 * @name index
 * @info 描述：主页脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-27 8:54:15
 */


//全局变量---------------------------------------------------------------------------------------


//初始化-----------------------------------------------------------------------------------------
$(function () {
    var timer2 = '';
    var timer3 = '';
    $(function () {
        clearInterval(timer2);
        clearInterval(timer3);
        timer2 = setInterval(getPropNum, 1000 * 60 * 3);
        timer3 = setInterval(getNewNum, 1000 * 60 * 3);
    });
    resize();
    getPropNum();
    getNewNum();
});
$(window).resize(function () {          //当浏览器大小变化时
    resize();
});

//函数--------------------------------------------------------------------------------------------
//重置窗口大小
function resize() {
    menuh = $(window).height() - 63;
    $('#menu').css('height', menuh + 'px');
    mainh = $(window).height() - 150;
    $('#main').css('height', mainh + 'px');
}

function zkTab(id) {
    $('#main-nav li ul').each(function () {
        $(this).collapse('hide');
    });
    $('#' + id).collapse('show');

}
function jumpPage(url, obj) {
    $('#rightMain').attr('src', url);
    if (obj == 0) {
        $('#firCat').html('后台');
        $('#secCat').html('首页');
    } else {
        $('#firCat').html($(obj).parent().parent().prev('div').text());
        $('#secCat').html($(obj).text());
    }
}

function jumpHome() {
    $('#firCat').html('后台');
    $('#secCat').html('首页');
}

function zkDropDown(id) {
    $(".dropdown-toggle").dropdown('toggle');
    $('#' + id).dropdown('toggle');
}

/**
 * 获取提醒数据
 * @returns {undefined}
 */
function getPropNum() {
    $.post(c_path + "/getPropNum", function (data) {
        var str1 = '<li class="divider"></li>';
        var str2 = '<li class="divider"></li>';
        $('#countSum').html(data.countSum);
        if (data.countSum == 0) {

        } else {
            if (data.dangNum != 0) {
                str1 += '<li>&#12288;' +
                        '<b>未处理险情</b><span class="label label-danger" style="font-size: 13px;line-height: 13px; float: right;margin-right: 5px;">' + data.dangNum + '</span></li>' +
                        '<li class="divider"></li>';
                for (var i = 0; i < data.dangArr.length; i++) {
                    str1 += '<li onclick="jumpHome()"><a href="' + m_path + '/PropDangerInfo/showList" target="right"><i class="glyphicon glyphicon-bullhorn" style="margin-right: 5px;background-color: #ed4e2a;padding: 2px;color: #fff;"></i>' + data.dangArr[i]['title'] + '&#12288;<span class="label label-info">' + data.dangArr[i]['danger_level'] + '级</span></a></li><li class="divider"></li>';
                }
            }
            if (data.propNum != 0) {
                str1 += '<li>&#12288;' +
                        '<b>未处理报修/诉求</b><span class="label label-warning" style="font-size: 13px;line-height: 13px; float: right;margin-right: 5px;">' + data.propNum + '</span></li>' +
                        '<li class="divider"></li>';
                for (var i = 0; i < data.propArr.length; i++) {
                    str1 += '<li onclick="jumpHome()"><a href="' + m_path + '/PropProbInfo/showList" target="right"><i class="glyphicon glyphicon-bullhorn" style="margin-right: 5px;background-color: #fcb322;padding: 2px;color: #fff;"></i>' + data.propArr[i]['title'] + '</a></li><li class="divider"></li>';
                }
            }
            $('#propWarn').html(str1 + str2);
        }
    }, 'json');
}

function getNewNum() {
    $.post(c_path + "/getNewNum", function (data) {
        var str1 = '<li class="divider"></li>';
        var str2 = '<li class="divider"></li>';
        $('#newSum').html(data.Num);
        if (data.Num != 0) {
            if (data.type == 'order') {
                if (data.Num != 0) {
                    if (data.Num != 0) {
                        str1 += '<li>&#12288;' +
                                '<b>未处理订单</b><span class="label label-danger" style="font-size: 13px;line-height: 13px; float: right;margin-right: 5px;">' + data.Num + '</span></li>' +
                                '<li class="divider"></li>';
                        for (var i = 0; i < data.Arr.length; i++) {
                            str1 += '<li onclick="jumpHome()"><a href="' + m_path + '/SellerOrderInfo/showList/seller_id/' + data.Arr[i]['seller_id'] + '/seller_name/' + data.Arr[i]['name'] + '" target="right"><i class="glyphicon glyphicon-bullhorn" style="margin-right: 5px;background-color: #ed4e2a;padding: 2px;color: #fff;"></i>' + data.Arr[i]['order_no'] + '&#12288;<span class="label label-success">' + data.Arr[i]['realname'] + '</span>&#12288;' + data.Arr[i]['deal_type'] + '</a></li><li class="divider"></li>';
                        }
                    }
                    $('#newMsg').html(str1);
                    $('#newMsg').css('width', '420px');
                }
            } else {
                if (data.sellerNum != 0) {
                    str1 += '<li>&#12288;' +
                            '<b>未审核商家</b><span class="label label-danger" style="font-size: 13px;line-height: 13px; float: right;margin-right: 5px;">' + data.sellerNum + '</span></li>' +
                            '<li class="divider"></li>';
                    for (var i = 0; i < data.sellerArr.length; i++) {
                        str1 += '<li onclick="jumpHome()"><a href="' + m_path + '/SellerInfo/showList" target="right"><i class="glyphicon glyphicon-bullhorn" style="margin-right: 5px;background-color: #ed4e2a;padding: 2px;color: #fff;"></i>' + data.sellerArr[i]['name'] + '</a></li><li class="divider"></li>';
                    }
                }
                if (data.itemNum != 0) {
                    str2 += '<li>&#12288;' +
                            '<b>未审核商品</b><span class="label label-warning" style="font-size: 13px;line-height: 13px; float: right;margin-right: 5px;">' + data.itemNum + '</span></li>' +
                            '<li class="divider"></li>';
                    for (var i = 0; i < data.itemArr.length; i++) {
                        str2 += '<li onclick="jumpHome()"><a href="' + m_path + '/SellerItemsInfo/showList/seller_id/' + data.itemArr[i]['seller_id'] + '" target="right"><i class="glyphicon glyphicon-bullhorn" style="margin-right: 5px;background-color: #fcb322;padding: 2px;color: #fff;"></i>' + data.itemArr[i]['name'] + '</a></li><li class="divider"></li>';
                    }
                }
                $('#newMsg').html(str1 + str2);
                $('#newMsg').css('width', '300px');
            }
        }

    }, 'json');
}