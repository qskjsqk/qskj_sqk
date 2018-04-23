/**
 * @name acitvity_list
 * @info 描述：活动列表脚本
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

                if (data.data[i]['pics'].length <= 1) {
                    picsStr = '';
                } else if (data.data[i]['pics'].length <= 4) {
                    picsStr = '<div class="listcontent m-backgc-w">';
                    for (var j = 1; j < data.data[i]['pics'].length; j++) {
                        picsStr += '<div class="listimg"><img src="' + appUpload_path + data.data[i]['pics'][j]['url'] + '"></div>';
                    }
                    picsStr += '</div>';
                } else {
                    picsStr = '<div class="listcontent m-backgc-w">';
                    for (var j = 1; j < 4; j++) {
                        picsStr += '<div class="listimg"><img src="' + appUpload_path + data.data[i]['pics'][j]['url'] + '"></div>';
                    }
                    picsStr += '</div>';
                }


                str += '<div class="mui-card">' +
                        '<div class="mui-card-header mui-card-media" style="height:40vw;position:relative;background-image:url(' + appUpload_path + data.data[i]['pics'][0]['url'] + ')" onclick="getActivDetail(' + data.data[i]['id'] + ')"></div>' +
                        '<div class="mui-card-content">' +
                        '<div class="mui-card-content-inner">' +
                        '<p style="color: #000;font-size:1.1em;" onclick="getActivDetail(' + data.data[i]['id'] + ')">【' + data.data[i]['cat_name'] + '】' + data.data[i]['title'] + '</p>' +
                        '<div>' +
                        '<span class="mui-badge mui-badge-primary" style="float: left;">'+data.data[i]['integral']+'分</span>' +
                        '<span>&#12288;'+data.data[i]['address_name']+'/'+data.data[i]['start_date']+'</sapn>' +
                        '<span style="float: right;"><span class="mui-icon mui-icon-extra mui-icon-extra mui-icon-extra-heart font14"></span>&nbsp;'+data.data[i]['like_num']+'人收藏</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
//                str += '<li class="mui-table-view-cell" style="padding-right: 10px;">' +
//                        '<div class="mui-media-body" style="color:#555;">' +
//                        '<div class="list-xiaod"></div>[' + data.data[i]['cat_name'] + ']&#12288;' + data.data[i]['title'] + '' +
//                        '<div class="listdigest" style="font-size:13px;">' + data.data[i]['content'].replace(/<[^>]+>/gi, '').substr(0, 80) + '...' +
//                        '<a href="#" onclick="getDetail(0)" onclick="getActivDetail(' + data.data[i]['id'] + ')">【详情】</a>' +
//                        '</div>' + picsStr +
//                        '</div>' +
//                        '<div class="listfooter">' +
//                        '<span class="mui-badge" style="color:#555;">联系人：' + data.data[i]['link_name'] + '&#12288;&#12288;联系电话：' + data.data[i]['link_tel'] + '</span>' +
//                        '</div>' +
//                        '<div class="listfooter"><span>' + data.data[i]['add_time'] + '</span>' +
//                        '<div class="listfooter-num">' +
//                        '<p>' + data.data[i]['join_num'] + '</p>' +
//                        '</div>' +
//                        '<div class="listfooter-zan m-icon-join"></div>' +
//                        '<div class="listfooter-num">' +
//                        '<p>' + data.data[i]['comm_num'] + '</p>' +
//                        '</div>' +
//                        '<div class="listfooter-zan m-icon-pingl"></div>' +
//                        '<div class="listfooter-num">' +
//                        '<p>' + data.data[i]['like_num'] + '</p>' +
//                        '</div>' +
//                        '<div class="listfooter-zan ' + zan + '"></div>' +
//                        '</div>' +
//                        '</li>';
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
 * 打开活动详情页
 * @param {type} id
 * @returns {undefined}
 */
function getActivDetail(id) {
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
 * 关键字搜索
 * @returns {undefined}
 */
function keyWordSelect() {
    getActivList(1, $('#keyword').val());
}