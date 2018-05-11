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
    getActivList(1, '', assignData.address_id, 0, 0);

    document.onkeydown = function (event_e) {
        if (window.event) {
            event_e = window.event;
        }
        console.log(event_e);
        var int_keycode = event_e.key || event_e.code;
        if (int_keycode == 'Enter') {
            getActivList(1, $('#keyword').val(), assignData.address_id, 0, 0);
            return false;
        }
    }
});
//函数--------------------------------------------------------------------------------------------
/**
 * 获取活动列表
 * @param {Object} page
 */
function getActivList(page, keyword, address_id, cat_id, integral) {
    $.post(c_path + "/getList", {'page': page, 'keyword': keyword, 'address_id': address_id, 'cat_id': cat_id, 'integral': integral}, function (data) {
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


                str += '<div class="mui-card">' +
                        '<div class="mui-card-header mui-card-media" style="height:40vw;position:relative;background-image:url(' + appUpload_path + data.data[i]['pics'][0]['url'] + ')" onclick="getActivDetail(' + data.data[i]['id'] + ')">' + pModal + '</div>' +
                        '<div class="mui-card-content">' +
                        '<div class="mui-card-content-inner">' +
                        '<p style="color: #000;font-size:1.1em;" onclick="getActivDetail(' + data.data[i]['id'] + ')">【' + data.data[i]['cat_name'] + '】' + data.data[i]['title'] + '</p>' +
                        '<div>' +
                        '<span class="mui-badge mui-badge-primary" style="float: left;">' + data.data[i]['integral'] + '分</span>' +
                        '<span>&#12288;' + data.data[i]['address_name'] + '/' + data.data[i]['start_date'] + '</sapn>' +
                        '<span style="float: right;"><span class="mui-icon mui-icon-extra font14 ' + likeClass + '"></span>&nbsp;' + data.data[i]['like_num'] + '人收藏</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
            }

        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';
        }

        $("#activityList").html(str);
        //参数回显--------------------------------------------------------------
        $('#keyword').val(data.where.keyword);
        if (data.where.address_id != 0) {
            $('#local_address').attr('checked', 'checked');
        } else {
            $('#0_address').attr('checked', 'checked');
        }
        if (data.where.cat_id != 0) {
            $("#cat_id").find("option[value='" + data.where.cat_id + "']").attr("selected", 'selected');
        }
        if (data.where.integral != 0) {
            $("#integral").find("option[value='" + data.where.integral + "']").attr("selected", 'selected');
        }


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
 * 打开筛选
 */
function openSelect() {
    openModal();
}
/**
 * 打开模态框
 */
function openModal() {
    $(".m-modal-content").fadeIn(200);
    $(".m-modal").fadeIn(200);

    $(".m-modal").bind('click', function () {
        closeModal();
    });
}
/**
 * 关闭模态框
 */
function closeModal() {
    $(".m-modal-content").fadeOut(200);
    $(".m-modal").fadeOut(200);
}

function subForm() {
    var address_id = $('input[name="address_id"]').val();
    var cat_id = $('select[name="cat_id"]').val();
    var integral = $('select[name="integral"]').val();

    console.log(integral);
    console.log(cat_id);
    console.log(address_id);
    getActivList(1, '', address_id, cat_id, integral);
    closeModal();
}