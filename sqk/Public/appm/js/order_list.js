/**
 * Created by zhangzhihui on 2018/5/11.
 */
//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    getList(1);
});

/**
 * 获取列表
 * @param {type} page
 * @return
 */
function getList(page) {
    $.post(m_path + "/trading/getUserTradinglistSync", {'page': page}, function (res) {
        //交易记录列表
        var str = '';
        var data = res.data;
        if (data.isEmpty == 1) {
            var lists = data.lists;
            for (var i = 0; i < lists.length; i++) {
                str += '<li class="mui-table-view-cell" onclick="toTradingDetail(' + lists[i]['id'] + ')">';
                str += '<a class="mui-navigate-right">';
                str += '<span class="mui-badge mui-badge-danger">消费：' + lists[i]['trading_integral'] + '分</span>';
                str += lists[i]['title'] + '<span style="font-size: 12px;">[' + lists[i]['tradingName'] +']</span>';
                str += ' </a></li>';
            }
        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';
        }

        $("#tradingList").html(str);
        $("#page").val(data.page);
        if (data.is_end == 1) {
            $("#loadMore").removeAttr('onclick');
        } else {
            $("#loadMore").attr('onclick', 'loadMore()');
        }
        mui("#loadMore").button('reset');
        $("#loadMore").html(data.ajaxLoad);

    }, 'json');
}

function toTradingDetail(id) {
    aHref(m_path + '/trading/trading_detail/id/' + id);
}


function loadMore() {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getList(page);
}