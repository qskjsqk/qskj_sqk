/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    checkIsLogin();
    selectType(0);
});
function selectType(type) {

    if (type == 0) {
        getMyPromList(type, 1);
    } else if (type == 1) {

    } else if (type == 2) {

    } else {

    }
}
/**
 * 动态加载数据
 */
function loadMore() {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getMyPromList($("#type").val(), page);
}

function getMyPromList(type, page) {
    mui.post(c_path + "/getMyPromList", {'type': type, 'page': page}, function (data) {
        //最新活动
        var str = '';
        var picsStr = '';
        if (data.flag == 1) {
            for (var i = 0; i < data.data.length; i++) {
                if (data.data[i]['pics']== 0) {
                    picsStr = '../../../Public/Upload/sellerProm/2018-04-21/5adb3b6907f0a.jpg';
                } else {
                    picsStr = '../../../' + data.data[i]['pics'][0]['url'];
                }
                str += '<div class="mui-card" onclick="aHref()">' +
                        '<div class="mui-card-header">' +
                        '<div class="mui-card-link"><div class="seller_s"></div>已发布</div>' +
                        '<p class="mui-card-link">浏览量：'+data.data[i]['read_num']+'</p>' +
                        '</div>' +
                        '<div class="mui-card-content">' +
                        '<div class="mui-card-content">' +
                        '<div class="item_list">' +
                        '<div class="item_list_img" style="background:url('+picsStr+') no-repeat;background-size:140px 70px;"></div>' +
                        '<div class="item_list_word">' +
                        '<p class="mui-ellipsis font333">'+data.data[i]['title']+'</p>' +
                        '<p class="mui-ellipsis-2">'+data.data[i]['content']+'</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
            }

        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';
        }

        $("#myPromList").html(str);
        //参数回显--------------------------------------------------------------
        $('#type').val(data.type);
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
