/**
 * @name main
 * @info 描述：首页脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-2 11:15:45
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    getList();

});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取首页列表信息
 * @returns {undefined}
 */
function getList() {
    $.post(c_path + "/mainInfo", function (data) {
        //通知公告
        var str = '';
        if (data.notice == null) {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';

        } else {
            for (var i = 0; i < data.notice.length; i++) {
                str += '<li class="mui-table-view-cell" onclick="getNoticeDetail(' + data.notice[i]["id"] + ')">' +
                        //				'<div class="mui-slider-right mui-disabled">' +
                        //				'<a class="mui-btn mui-btn-red" href="javascript:void(0)" onclick="deleteNotice('+data.notice[i]["id"]+')">删除</a>' +
                        //				'</div>' +
                        '<div class="mui-slider-handle mui-table">' +
                        '<div class="mui-table-cell">' +
                        '<div class="mui-media-body">' +
                        '<img src="' + public + '/app/img/xd.png" />&#12288;【' + data.notice[i]["cat_name"] + '】' + data.notice[i]["title"] + '' +
                        '<span class="mui-ellipsis" style="float: right;color: #999;font-size:14px;">' + data.notice[i]["add_time"] + '</span>' +
                        '<p class="mui-ellipsis">' + data.notice[i]["content"].replace(/<[^>]+>/gi, '') + '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</li>';
            }
        }

        $("#noticeList").html(str);

        //社区活动
        var str1 = '';
        if (data.activity == null) {
            str1 = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';
        } else {
            for (var i = 0; i < data.activity.length; i++) {
                str1 += '<li class="mui-table-view-cell" onclick="getActivDetail(' + data.activity[i]["id"] + ')">' +
                        //				'<div class="mui-slider-right mui-disabled">' +
                        //				'<a class="mui-btn mui-btn-red" href="javascript:void(0)" onclick="deleteNotice('+data.activity[i]["id"]+')">删除</a>' +
                        //				'</div>' +
                        '<div class="mui-slider-handle mui-table">' +
                        '<div class="mui-table-cell">' +
                        '<div class="mui-media-body">' +
                        '<img src="' + public + '/app/img/xd.png" />&#12288;【' + data.activity[i]["cat_name"] + '】' + data.activity[i]["title"] + '' +
                        '<span class="mui-ellipsis" style="float: right;color: #999;font-size:14px;">' + data.activity[i]["add_time"] + '</span>' +
                        '<p class="mui-ellipsis">' + data.activity[i]["content"].replace(/<[^>]+>/gi, '') + '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</li>';
            }
        }

        $("#activList").html(str1);
        //轮播图数据
        var sliderStart = '';
        var sliderInfo = '';
        var sliderEnd = '';
        var dianStr = '';
        if (data.slider == 0) {

        } else {
            sliderStart = '<div class="mui-slider-item mui-slider-item-duplicate">' +
                    '<a href="#">' +
                    '<img src="' + appUpload_path + data.slider[0]['url'] + '" style="height:360px;">' +
                    '</a>' +
                    '</div>';
            for (var i = 0; i < data.slider.length; i++) {
                sliderInfo += '<div class="mui-slider-item">' +
                        '<a href="#">' +
                        '<img src="' + appUpload_path + data.slider[i]['url'] + '" style="height:360px;">' +
                        '</a>' +
                        '</div>';
                if (i > 0) {
                    dianStr += '<div class="mui-indicator mui-active"></div>';
                } else {
                    dianStr += '<div class="mui-indicator"></div>';
                }
            }
            sliderEnd = '<div class="mui-slider-item mui-slider-item-duplicate">' +
                    '<a href="#">' +
                    '<img src="' + appUpload_path + data.slider[data.slider.length - 1]['url'] + '" style="height:360px;">' +
                    '</a>' +
                    '</div>';
            $('#sliderList').html(sliderStart + sliderInfo + sliderEnd);
            $('#dianList').html(dianStr);
            mui.init({ });
        }

    }, 'json');
}

/**
 * 查看通知详情
 * @param {type} id
 * @returns {undefined}
 */
function getNoticeDetail(id) {
    window.location.href = m_path + "/notice/notice_detail.html?id=" + id + '&url=home';
}

/**
 * 查看活动详情
 * @param {type} id
 * @returns {undefined}
 */
function getActivDetail(id) {
    window.location.href = m_path + "/activity/activity_detail.html?id=" + id + '&url=home';
}