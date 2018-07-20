/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    
    //mousedown() 监听鼠标是否使用 keydown() 监听键盘是否可用
    $(document).mousedown(function () {
        parent.timeZero();
    }).keydown(function () {
        parent.timeZero();
    }).mousemove(function () {
        parent.timeZero();
    });
    
    checkIsLogin();
    getMySignList(1);
});
/**
 * 动态加载数据
 */
function loadMore() {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getMySignList(page);
}

function getMySignList(page) {
    mui.post(c_path + "/getMySignList", {'page': page}, function (data) {
        //最新活动
        var str = '';
        if (data.flag == 1) {
            for (var i = 0; i < data.data.length; i++) {

                if (data.data[i].sign_type == 0) {
                    var img = 'qrcode_sign';
                } else {
                    var img = 'card_sign';
                }

                str += '<li class="mui-table-view-cell mui-media">' +
                        '<a href="javascript:;">' +
                        ' <img class="mui-media-object mui-pull-left" src="/Public/appm/img/' + img + '.jpg">' +
                        '<div class="mui-media-body">' +
                        ' <p class="mui - ellipsis">签到时间：' + data.data[i].add_time + '</p>' +
                        ' <p class="mui - ellipsis">活动名称：' + data.data[i].title + '</p>' +
                        ' <p class="mui - ellipsis">签到次数：' + data.data[i].sign_num + '/' + data.data[i].signin_time + '&#12288;获得积分：' + data.data[i].sign_integral + '分</p>' +
                        '</div>' +
                        '</a>' +
                        '</li>';
            }

        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无数据</li>';
        }

        $("#signinList").html(str);
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