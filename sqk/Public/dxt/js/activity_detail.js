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
        console.log(data);
        var picsStr = '';
        var firstPic = '';
        if (data.flag == 1) {

            $('#sendBtn').attr('onclick', 'addComm(' + data.data.id + ')');

            if (data.data['join_flag'] == 0) {
                if (data.data['like_flag'] == 0) {
                    $('#joinLikeBtn').html('<button type="button" class="mui-btn mui-btn-success mui-btn-block" onclick="likeActiv(' + data.data.id + ')">收藏</button>');
                } else {
                    $('#joinLikeBtn').html('<button type="button" class="mui-btn mui-btn-warning mui-btn-block ">已收藏</button>');
                }
            } else {
                $('#joinLikeBtn').html('<button type="button" class="mui-btn mui-btn-block mui-btn-outlined bgfff">已参加</button>');
            }

//基本信息

            $("#activ_title").html(data.data.title + "<p>" + data.data.realname + "&nbsp;发表于&nbsp;" + data.data.add_time + "</p>");
            $("#integral").text(data.data.integral + "分");
            $("#address_name_a_start_date").html("&nbsp;" + data.data.address_name + "/" + data.data.start_date);
            $("#like_num").html('&nbsp;' + data.data.like_num + '人收藏');
//活动信息
            $("#start_time").html(data.data.start_time + "&#12288;");
            $("#end_time").html(data.data.end_time + "&#12288;");
            $("#address").html(data.data.address + "&#12288;");
            $("#signin_time").html(data.data.signin_time + "次&#12288;");
            $("#initiator").html(data.data.initiator + "&#12288;");
            $("#link_name").html(data.data.link_name + "&#12288;");
            $("#link_tel").html(data.data.link_tel + "&#12288;");

            if (data.data.pics == 0) {
                picsStr = '';
                firstPic = 'Public/appm/img/card.jpg';
            } else {
                for (var j = 0; j < data.data.pics.length; j++) {
                    picsStr += '<img src="' + appUpload_path + data.data.pics[j]['url'] + '" style="width:100%;">';
                }
                firstPic = appUpload_path + data.data.pics[0]['url'];
            }

            $('#activ_first_pic').css('background-image', 'url('+firstPic+')');

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
            $("#comm_num").html("&nbsp;" + data.data.comm_num + "人评论");

        } else {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
            window.location.href = "activity_list.html";
        }

    }, 'json');
}

/**
 * 收藏活动事件
 * @param {Object} id
 */
function likeActiv(id) {
    $.get(c_path + "/likeActiv", {'id': id}, function (data) {
        if (data.flag == 1) {
            getDetail(id);
            mui.toast('已将此活动添加到收藏里！');
        } else {
            mui.toast(data.msg);
        }
    }, 'json');
}