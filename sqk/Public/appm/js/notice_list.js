/**
 * @name notice_list
 * @info 描述：通知列表脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-2 14:17:41
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    if (getUrl('type') == 1) {
        checkTab(1, 1, '');
    } else {
        checkTab(0, 1, '');
    }

});

//函数--------------------------------------------------------------------------------------------
/**
 * 检测标签
 * @param {type} type
 * @param {type} page
 * @param {type} keyword
 * @returns {undefined}
 */
function checkTab(type, page, keyword) {
    $('#keyword').val('');
    $("#tabNotice div").removeClass("tab-btn-sel").removeClass("tab-btn-no");
    if (type == 1) {
        $("#notice1").addClass("tab-btn-sel");
        $("#notice0").addClass("tab-btn-no");
    } else {
        $("#notice0").addClass("tab-btn-sel");
        $("#notice1").addClass("tab-btn-no");
    }
    getList(type, page, keyword);
}

/**
 * 获取列表
 * @param {type} type
 * @param {type} page
 * @param {type} keyword
 * @returns {undefined}
 */
function getList(type, page, keyword) {
    $("#searchBtn").attr('onclick', 'keyWordSelect(' + type + ')');
    $.post(c_path + "/getList", {'type': type, 'page': page, 'keyword': keyword}, function (data) {
        //通知公告
        var str = '';
        if (data.flag == 1) {
            if (type == 0) {
                for (var i = 0; i < data.data.length; i++) {
//                    str += '<li class="mui-table-view-cell" style="padding-right: 15px;" >' +
//                            '<div class="mui-slider-right mui-disabled">' +
//                            '<a class="mui-btn mui-btn-red" href="javascript:void(0)" onclick="delNotice(' + data.data[i]["id"] + ')">忽略</a>' +
//                            '</div>' +
//                            '<div class="mui-slider-handle mui-table" onclick="getNoticeDetial(' + data.data[i]["id"] + ',0)">' +
//                            '<div class="mui-table-cell">' +
//                            '<div class="mui-media-body">' +
//                            '<img src="' + public + '/app/img/xd.png" />&#12288;【' + data.data[i]["cat_name"] + '】' + data.data[i]["title"] + '' +
//                            '<span class="mui-ellipsis" style="float: right;color: #999;font-size:14px;">' + data.data[i]["add_time"] + '</span>' +
//                            '<p class="mui-ellipsis">' + data.data[i]["content"].replace(/<[^>]+>/gi, '') + '</p>' +
//                            '</div>' +
//                            '</div>' +
//                            '</div>' +
//                            '</li>';
//                    str += '<li class="mui-table-view-cell mui-media">' +
//                            '<a href="javascript:">' +
//                            '<img class="mui-media-object mui-pull-left" src="item.cover">' +
//                            '<div class="mui-media-body">' +
//                            '<div class="mui-ellipsis-2">' + data.data[i]["title"] + '</div>' +
//                            '</div>' +
//                            '<div class="meta-info">' +
//                            '<div class="author">管理员</div>' +
//                            '<div class="time">' + data.data[i]["add_time"] + '</div>' +
//                            '</div>' +
//                            '</a>' +
//                            '</li>';
//                    str += '<li class="mui-table-view-cell mui-media" onclick="getNoticeDetial(' + data.data[i]["id"] + ',0)">' +
//                            '<a href="javascript:;">' +
//                            '<div class="mui-media-body mui-ellipsis" style="color:#555;font-size:15px;" >' +
//                            '<font color="#c00000;">[' + data.data[i]["cat_name"] + ']</font> <span class="mui-badge" style="float: right;">' + data.data[i]["add_time"] + '</span>' + data.data[i]["title"] +
//                            '<p class="mui-ellipsis" style="">' + data.data[i]["content"].replace(/<[^>]+>/gi, '') + '</p>' +
//                            '</div>' +
//                            '</a>' +
//                            '</li>';
                    str += '<li class="mui-table-view-cell mui-media">' +
                            '<a href="javascript:;">' +
                            '<img class="mui-media-object mui-pull-left" src="../../../' + data.data[i]["notice_pic"] + '">' +
                            '<div class="mui-media-body">' +
                            '<div class="mui-ellipsis-2">' + data.data[i]["title"] + '</div>' +
                            '</div>' +
                            '<div class="meta-info">' +
                            ' <div class="author fontred">[' + data.data[i]["cat_name"] + ']</div>' +
                            '<div class="time">' + data.data[i]["add_time"] + '</div>' +
                            '</div>' +
                            '</a>' +
                            '</li>';
                }
            } else {
                for (var i = 0; i < data.data.length; i++) {
//                    str += '<li class="mui-table-view-cell" style="padding-right: 15px;" onclick="getNoticeDetial(' + data.data[i]["id"] + ',1)">' +
//                            '<div class="mui-media-body">' +
//                            '<img src="' + public + '/app/img/xd.png" />&#12288;【' + data.data[i]["cat_name"] + '】' + data.data[i]["title"] + '' +
//                            '<span class="mui-ellipsis" style="float: right;color: #999;font-size:14px;">' + data.data[i]["add_time"] + '</span>' +
//                            '<p class="mui-ellipsis">' + data.data[i]["content"].replace(/<[^>]+>/gi, '') + '</p>' +
//                            '</div>' +
//                            '</li>';

                    str += '<li class="mui-table-view-cell mui-media" onclick="getNoticeDetial(' + data.data[i]["id"] + ',1)">' +
                            '<a href="javascript:;">' +
                            '<div class="mui-media-body mui-ellipsis" style="color:#555;font-size:15px;" >' +
                            '<font color="#c00000;">[' + data.data[i]["cat_name"] + ']</font> <span class="mui-badge" style="float: right;">' + data.data[i]["add_time"] + '</span>' + data.data[i]["title"] +
                            '<p class="mui-ellipsis" style="">' + data.data[i]["content"].replace(/<[^>]+>/gi, '') + '</p>' +
                            '</div>' +
                            '</a>' +
                            '</li>';
                }
            }

        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';
        }

        $("#noticeList").html(str);
        $("#page").val(data.page);
        if (data.is_end == 1) {
            $("#loadMore").removeAttr('onclick');
        } else {
            $("#loadMore").attr('onclick', 'loadMore(' + type + ')');
        }

        mui("#loadMore").button('reset');
        $("#loadMore").html(data.ajaxLoad);

    }, 'json');
}

/**
 * 忽略该条通知
 * @param {type} id
 * @returns {undefined}
 */
function delNotice(id) {
    $.get(c_path + "/delNotice/id/" + id, function (data) {
        if (data.flag == 1) {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
            var page = parseInt($("#page").val());
            getList(0, page, $('#keyword').val());
        } else {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
        }

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
function loadMore(type) {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getList(type, page, $('#keyword').val());
}
/**
 * 关键字搜索
 * @param {type} type
 * @returns {undefined}
 */
function keyWordSelect(type) {
    var keyword = $('#keyword').val();
    getList(type, 1, keyword);
}