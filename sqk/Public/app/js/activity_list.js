/**
 * @name acitvity_list
 * @info 描述：活动列表
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-3 9:39:48
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    $('#keyword').val('');
    getActivList(1, '');
});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取活动列表
 * @param {Object} page
 */
function getActivList(page, keyword) {
    $.post(c_path + "/getList", {'page': page, 'keyword': keyword}, function (data) {
        //最新活动
        var str = '';
        var picsStr = '';
        if (data.flag == 1) {
            for (var i = 0; i < data.data.length; i++) {
                //赞标识
                var zan = '';
                if (data.data[i]['like_flag'] == 1) {
                    zan = 'm-icon-zaned';
                } else {
                    zan = 'm-icon-zan';
                }

                if (data.data[i]['pics'] == 0) {
                    picsStr = '';
                } else {
                    picsStr = '<div class="listcontent m-backgc-w">';
                    for (var j = 0; j < data.data[i]['pics'].length; j++) {
                        picsStr += '<div class="listimg"><img src="' + appUpload_path + data.data[i]['pics'][j]['url'] + '"></div>';
                    }
                    picsStr += '</div>';
                }

                str += '<li class="mui-table-view-cell" style="padding-right: 10px;" onclick="getActivDetail(' + data.data[i]['id'] + ')">' +
                        '<div class="mui-media-body">' +
                        '<div class="list-xiaod"></div>【' + data.data[i]['cat_name'] + '】&#12288;' + data.data[i]['title'] + '' +
                        '<span class="mui-ellipsis" style="float: right;color: #999;font-size:14px;">' + data.data[i]['add_time'] + '</span>' +
                        '<div class="listdigest">' + data.data[i]['content'].replace(/<[^>]+>/gi, '').substr(0, 80) + '...' +
                        '<a href="#" onclick="getDetail(0)">【详情】</a>' +
                        '</div>' + picsStr +
                        '</div>' +
                        '<div class="listfooter">' +
                        '<span style="color:#555;">联系人：' + data.data[i]['link_name'] + '&#12288;&#12288;联系电话：' + data.data[i]['link_tel'] + '</span>' +
                        '</div>' +
                        '<div class="listfooter"><span>浏览' + data.data[i]['read_num'] + '次</span>' +
                        '<div class="listfooter-num">' +
                        '<p>' + data.data[i]['join_num'] + '</p>' +
                        '</div>' +
                        '<div class="listfooter-zan m-icon-join"></div>' +
                        '<div class="listfooter-num">' +
                        '<p>' + data.data[i]['comm_num'] + '</p>' +
                        '</div>' +
                        '<div class="listfooter-zan m-icon-pingl"></div>' +
                        '<div class="listfooter-num">' +
                        '<p>' + data.data[i]['like_num'] + '</p>' +
                        '</div>' +
                        '<div class="listfooter-zan ' + zan + '"></div>' +
                        '</div>' +
                        '</li>';
            }

        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';
        }

        $("#activityList").html(str);

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
 * 跳转活动详情
 * @param {type} id
 * @returns {undefined}
 */
function getActivDetail(id) {
    //打开详情
    window.location.href = c_path + "/activity_detail.html?id=" + id;
}

/**
 * 动态加载数据
 */
function loadMore() {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getActivList(page, $('#keyword').val());
}

/**
 * 关键词搜索
 * @returns {undefined}
 */
function keyWordSelect() {
    getActivList(1, $('#keyword').val());
}