/**
 * @name healthn_detail
 * @info 描述：科学知识详情页
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-16 16:12:50
 */


//全局变量---------------------------------------------------------------------------------------


//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    var id = getUrl('id');
    getHealthnDetail(id);
});

//函数--------------------------------------------------------------------------------------------
/**
 * 健康信息详情
 * @param {type} id
 * @returns {undefined}
 */
function getHealthnDetail(id) {
    $.get(c_path + "/getHealthnDetail/id/" + id, function (data) {
        if (data.flag == 1) {
            $("#healthn_title").html(data.data.title);
            $("#healthn_ftitle").html(data.data.realname);
            $("#read_num").html("<span style='float:left;'>浏览量：" + data.data.read_num + "</span><span style='float:right'>" + data.data.add_time + "</sapn>");
            //为增强体验 图片加载完成之前隐藏，加载完成后显示
            $("#healthn_content").css('display', 'none');
//            $("#healthn_content").html(data.data.content.replace(/style="(.)*?"|^\s*|\&nbsp;/gi, ''));
            $("#healthn_content").html(data.data.content);
            $('#healthn_content table').css({'width': '100%'});
            $('#healthn_content table').attr({'border': '1'});
            $('#healthn_content').html(img_reset($('#healthn_content').html()));
            if ($('#healthn_content img').length > 0) {
                $('#healthn_content img').each(function () {
                    $(this).css({'padding': '5px 0'});
                    $(this).attr('src', delHttp(this.src));
                    $(this).load(function () {
                        var img = new Image();
                        img.src = this.src;
                        $(this).css({'width': '100%'});
                        $("#healthn_content").css('display', 'block');
                    });
                });
            } else {
                $("#healthn_content").css('display', 'block');
            }

        } else {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
            window.location.href = "healthn_list.html";
        }

    }, 'json');

}
/**
 * 打开模态框
 */
function openModal() {
    $(".m-modal-if").fadeIn(200);

    $(".m-modal-if").bind('click', function () {
        closeModal();
    });
}
/**
 * 关闭模态框
 */
function closeModal() {
    $(".m-modal-if").fadeOut(200);
}

/**
 * 返回上级
 * @returns {undefined}
 */
function back() {
    //打开详情
    var cat_id = getUrl('cat_id');
    window.location.href = c_path + "/healthn_list.html?cat_id=" + cat_id;
}