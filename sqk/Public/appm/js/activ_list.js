/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    selectType(0);
});
//函数--------------------------------------------------------------------------------------------

function selectType(type) {
    $('#tabActiv').find('button').removeClass('mui-btn-warning');
    $('#activBtn' + type).addClass('mui-btn-warning');
    if (type == 0) {
//收藏
        getMyActivList(0, 1);
    } else {
//参加
        getMyActivList(1, 1);
    }
}
/**
 * 动态加载数据
 */
function loadMore() {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getMyActivList($("#type").val(), page);
}

function getMyActivList(type, page) {
    mui.post(c_path + "/getMyActivList", {'type': type, 'page': page}, function (data) {
        //最新活动
        var str = '';
        var picsStr = '';
        if (data.flag == 1) {
            for (var i = 0; i < data.data.length; i++) {
                var pModal = '';
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

                if (data.data[i]['is_open'] == 0) {
                    pModal = '<div class="p-modal"><div class="p-modal-div"><h4><i>已结束</i></h4></div></div>';
                }

                if (data.data[i]['like_flag'] == 0) {
                    var likeClass = 'mui-icon-extra-heart';
                } else {
                    var likeClass = 'mui-icon-extra-heart-filled mui-icon-extra-active';
                }


                if (type == 0) {
                    str += '<div class="mui-card" >' +
                            '<div class="mui-card-header mui-card-media" style="height:40vw;position:relative;background-image:url(' + appUpload_path + data.data[i]['pics'][0]['url'] + ')" onclick="qxLike(' + data.data[i]['id'] + ')">' + pModal + '</div>' +
                            '<div class="mui-card-content">' +
                            '<div class="mui-card-content-inner">' +
                            '<p style="color: #000;font-size:1.1em;">【' + data.data[i]['cat_name'] + '】' + data.data[i]['title'] + '</p>' +
                            '<div>' +
                            '<span class="mui-badge mui-badge-primary" style="float: left;">' + data.data[i]['integral'] + '分</span>' +
                            '<span>&#12288;' + data.data[i]['address_name'] + '/' + data.data[i]['start_date'] + '</sapn>' +
                            '<span style="float: right;" ><span class="mui-icon mui-icon-extra font14 ' + likeClass + '"></span>&nbsp;' + data.data[i]['like_num'] + '人收藏</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                } else {
                    str += '<div class="mui-card" >' +
                            '<div class="mui-card-header mui-card-media" style="height:40vw;position:relative;background-image:url(' + appUpload_path + data.data[i]['pics'][0]['url'] + ')" >' + pModal + '</div>' +
                            '<div class="mui-card-content">' +
                            '<div class="mui-card-content-inner">' +
                            '<p style="color: #000;font-size:1.1em;">【' + data.data[i]['cat_name'] + '】' + data.data[i]['title'] + '</p>' +
                            '<div>' +
                            '<span class="mui-badge mui-badge-primary" style="float: left;">' + data.data[i]['integral'] + '分</span>' +
                            '<span>&#12288;' + data.data[i]['address_name'] + '/' + data.data[i]['start_date'] + '</sapn>' +
                            '<span style="float: right;" ><span class="mui-icon mui-icon-extra font14 ' + likeClass + '"></span>&nbsp;' + data.data[i]['like_num'] + '人收藏</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                }
            }
        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';
        }

        $("#activityList").html(str);
        $("#activNum" + type).html('(' + data.count + ')');
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

function qxLike(id) {
    var btnArray = ['取消', '确定'];
    mui.confirm('确定取消收藏该活动吗？', '提示', btnArray, function (e) {
        if (e.index == 1) {
            //兑换发布权限
            mui.post(c_path + "/qxLike", {'id': id}, function (data) {
                if (data.flag == 1) {
                    getMyActivList(0, 1);
                }
                mui.toast(data.msg, {duration: 'long', type: 'div'});
            }, 'json');

        }
    })
}


