/**
 * @name notice_list
 * @info 描述：通知列表脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-2 14:17:41
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    
    //mousedown() 监听鼠标是否使用 keydown() 监听键盘是否可用
    $(document).mousedown(function () {
        parent.timeZero();
    }).keydown(function () {
        parent.timeZero();
    }).mousemove(function () {
        parent.timeZero();
    });
    
    var model_key = "notice";
    checkIsLogin();
    getList(1, '');
});

//函数--------------------------------------------------------------------------------------------

/**
 * 获取列表
 * @param {type} type
 * @param {type} page
 * @param {type} keyword
 * @returns {undefined}
 */
function getList(page, keyword) {
    $("#searchBtn").attr('onclick', 'keyWordSelect()');
    $.post(c_path + "/getList", {'page': page, 'keyword': keyword}, function (data) {
        //通知公告
        var str = '';
        if (data.flag == 1) {
            for (var i = 0; i < data.data.length; i++) {
                if (data.data[i]["is_read"] == 0) {
                    var readClass = 'font-wb';
                } else {
                    var readClass = 'font333';
                }
                str += '<li class="mui-table-view-cell mui-media">' +
                        '<a href="#" onclick="getNoticeDetial(' + data.data[i]["id"] + ',1)">' +
                        '<img class="mui-media-object mui-pull-left" src="../../../' + data.data[i]["notice_pic"] + '" style="width:100px;">' +
                        '<div class="mui-media-body">' +
                        '<div class="mui-ellipsis ' + readClass + '">' + data.data[i]["title"] + '</div>' +
                        '</div>' +
                        '<div class="meta-info">' +
                        '<div class="author">&#12288;[' + data.data[i]["cat_name"] + ']</div>' +
                        '<div class="time">' + data.data[i]["add_time"] + '</div>' +
                        '</div>' +
                        '</a>' +
                        '</li>';
            }
        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';
        }

        $("#noticeList").html(str);
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
/**
 * 获取通知详情
 * @param {type} id
 * @param {type} type
 * @returns {undefined}
 */
function getNoticeDetial(id, type) {
    //打开新闻详情
    window.location.href = c_path + "/notice_detail.html?id=" + id + '&type=' + type;
}
/**
 * 动态加载数据
 * @param {Object} type
 */
function loadMore() {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getList(page, $('#keyword').val());
}
