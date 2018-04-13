/**
 * @name notice_detail
 * @info 描述：
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-3 8:47:14
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    var id = getUrl('id');
    getNoticeDetail(id);
});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取通知详情
 * @param {type} id
 * @returns {undefined}
 */
function getNoticeDetail(id) {
    $.get(c_path + "/getNoticeDetail/id/" + id, function (data) {
        if (data.flag == 1) {
            $("#notice_title").html(data.data.title);
            $("#notice_ftitle").html(data.data.realname);
            $("#read_num").html("<span style='float:left;'>浏览量：" + data.data.read_num + "</span><span style='float:right'>" + data.data.add_time + "</sapn>");
            //为增强体验 图片加载完成之前隐藏，加载完成后显示
            $("#notice_content").css('display', 'none');
//            $("#notice_content").html(data.data.content.replace(/style="(.)*?"|^\s*|\&nbsp;/gi, ''));
            $("#notice_content").html(data.data.content);
            $('#notice_content table').css({'width': '100%'});
            $('#notice_content table').attr({'border': '1'});
            $('#notice_content').html(img_reset($('#notice_content').html()));
            if ($('#notice_content img').length > 0) {
                $('#notice_content img').each(function () {
                    $(this).css({'padding': '5px 0'});
                    $(this).attr('src', delHttp(this.src));
                    $(this).load(function () {
                        var img = new Image();
                        img.src = this.src;
                        $(this).css({'width': '100%'});
                        $("#notice_content").css('display', 'block');
                    });
                });
            } else {
                $("#notice_content").css('display', 'block');
            }

        } else {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
            window.location.href = "notice_list.html";
        }

    }, 'json');

}

/**
 * 返回上级
 * @returns {undefined}
 */
function back() {
    var url = getUrl('url');
    var type = getUrl('type');
    if (url == 'home') {
        aHref(m_path + '/index/main');
    } else {
        if (type == 0) {
            window.location.href = "notice_list.html?type=0";
        } else {
            window.location.href = "notice_list.html?type=1";
        }

    }
}