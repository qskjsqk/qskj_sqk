/**
 * @name activity_detail
 * @info 描述：活动详情页脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-3 9:40:05
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    var id = getUrl('id');
    getDetail(id);

});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取活动详情
 * @param {Object} id
 */
function getDetail(id) {
    $.get(c_path + "/getActivDetail/id/" + id, function (data) {
        var picsStr = '';
        if (data.flag == 1) {

            $('#joinBtn').attr('onclick', 'joinActiv(' + data.data.id + ',"' + data.data.lookUser + '","' + data.data.title + '")');

            $('#sendBtn').attr('onclick', 'addComm(' + data.data.id + ')');

            $('#zan').attr('onclick', 'zanActiv(' + data.data.id + ')');

            if (data.data['like_flag'] == 1) {
                $('#zan').removeClass('m-icon-zan').addClass('m-icon-zaned').removeAttr('onclick');
            }

            if (data.data['join_flag'] == 1) {
                $('#joinBtn').removeClass('mui-btn-warning').addClass('mui-btn-success').removeAttr('onclick').html('取消参加');
                $('#joinBtn').attr('onclick', 'concelJoinActiv(' + data.data.id + ',"' + data.data.lookUser + '","' + data.data.title + '")');
            } else {
                $('#joinBtn').removeClass('mui-btn-success').addClass('mui-btn-warning').html('马上参加');

            }

            $("#activ_title").html(data.data.title + "<p>" + data.data.realname + "&nbsp;发表于&nbsp;" + data.data.add_time + "</p>");

            if (data.data.pics == 0) {
                picsStr = '';
            } else {
                for (var j = 0; j < data.data.pics.length; j++) {
                    picsStr += '<img src="' + appUpload_path + data.data.pics[j]['url'] + '" style="width:100%;">';
                }
            }

            //为增强体验 图片加载完成之前隐藏，加载完成后显示
            $("#activ_content").css('display', 'none');
//            $("#activ_content").html(data.data.content.replace(/style="(.)*?"|^\s*|\&nbsp;/gi, '') + picsStr);
            $("#activ_content").html(data.data.content + picsStr);
            $('#activ_content table').css({'width': '100%'});
            $('#activ_content table').attr({'border': '1'});
            $('#activ_content').html(($('#activ_content').html()));
            if ($('#activ_content img').length > 0) {
                $('#activ_content img').each(function () {
                    $(this).css({'padding': '5px 0'});
                    $(this).attr('src', delHttp(this.src));
                    $(this).load(function () {
                        var img = new Image();
                        img.src = this.src;
                        $(this).css({'width': '100%'});
                        $("#activ_content").css('display', 'block');
                    });
                });
            } else {
                $("#activ_content").css('display', 'block');
            }


            $("#read_num").html("浏览" + data.data.read_num + "次");
            $("#like_num").html(data.data.like_num);
            $("#join_num").html(data.data.join_num);
            $("#comm_num").html(data.data.comm_num);

            var commStr = '';
            if (data.data.commFlag == 1) {
                for (var i = 0; i < data.data.comm.length; i++) {
                    commStr += '<li class="mui-table-view-cell" style="padding-left: 0px;">' +
                            '<div class="mui-row">' +
                            '<div class="pinglun-list m-margin-l15">' +
                            '<div class="pinglun-title">' +
                            '<div class="pinglun-title-img m-icon-tx' + data.data.comm[i]['tx'] + '">' +
                            '</div>' +
                            '<div class="pinglun-title-title m-margin-l15">' + data.data.comm[i]['no'] + '&nbsp;楼--' + data.data.comm[i]['realname'] +
                            '<p>' + data.data.comm[i]['add_time'] + '</p>' +
                            '</div>' +
                            '</div>' +
                            '<div class="pinglun-content">' + data.data.comm[i]['content'] + '</div>' +
                            '</div>' +
                            '</li>';
                }

            } else {
                commStr = '<li class="mui-table-view-cell" style="padding-left: 0px;text-align:center;">(=￣ω￣=)&#12288;赶快来吐槽一下吧！</li>';
            }
            $("#commList").html(commStr);
        } else {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
            window.location.href = "activity_list.html";
        }

    }, 'json');
}

/**
 * 参加活动事件
 * @param {Object} id
 * @param {Object} realname
 * @param {Object} activ_name
 */
function joinActiv(id, realname, activ_name) {
    var btnArray = ['取消', '同意'];
    mui.confirm('To ' + realname + '：您确定要参加《' + activ_name + '》活动吗？', '提示', btnArray, function (e) {
        if (e.index == 1) {
            $.get(c_path + "/joinActiv", {'id': id}, function (data) {
                if (data.flag == 1) {
                    getDetail(id);
                    mui.toast('已经为您报名参加！');
                } else {
                    mui.toast(data.msg);
                }
            }, 'json');
        } else {
            mui.toast('取消参加！');
        }
    })
}

/**
 * 取消参加活动事件
 * @param {Object} id
 * @param {Object} realname
 * @param {Object} activ_name
 */
function concelJoinActiv(id, realname, activ_name) {
    var btnArray = ['取消', '确定'];
    mui.confirm('To ' + realname + '：您确定要取消参加《' + activ_name + '》活动吗？', '提示', btnArray, function (e) {
        if (e.index == 1) {
            $.get(c_path + "/concelJoinActiv", {'id': id}, function (data) {
                if (data.flag == 1) {
                    mui.toast('已取消参加！');
                    getDetail(id);
                } else {
                    mui.toast(data.msg);
                }
            }, 'json');
        } else {
            mui.toast('继续参加！');
        }
    })
}

/**
 * 添加评论事件
 * @param {Object} id
 */
function addComm(id) {
    if ($("#pl_input").val() == "") {
        mui.toast('不可发送空评论！');
    } else {
        $.get(c_path + "/addComm", {'id': id, 'commContent': $("#pl_input").val()}, function (data) {
            if (data.flag == 1) {
                getDetail(id);
                $("#pl_input").val('');
                mui.toast(data.msg);
            } else {
                mui.toast(data.msg);
            }
        }, 'json');
    }

}

/**
 * 点赞活动事件
 * @param {Object} id
 */
function zanActiv(id) {
    $.get(c_path + "/zanActiv", {'id': id}, function (data) {
        if (data.flag == 1) {
            getDetail(id);
            mui.toast('您高贵地赞了一下！');
        } else {
            mui.toast(data.msg);
        }
    }, 'json');
}

/**
 * 返回上级
 * @returns {undefined}
 */
function back() {
    var url = getUrl('url');
    if (url == 'home') {
        aHref(m_path + '/index/main');
    } else {
        aHref(c_path + '/activity_list');
    }
}