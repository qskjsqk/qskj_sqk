/**
 * @name index
 * @info 描述：主页脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-27 8:54:15
 */


//全局变量---------------------------------------------------------------------------------------


//初始化-----------------------------------------------------------------------------------------
$(function () {
    resize();
});
$(window).resize(function () {          //当浏览器大小变化时
    resize();
});

//函数--------------------------------------------------------------------------------------------
/**
 * 重置大小
 * @returns {undefined}
 */
function resize() {
    menuh = $(window).height() - 63;
    $('#menu').css('height', menuh + 'px');
    mainh = $(window).height() - 150;
    $('#main').css('height', mainh + 'px');
}

/**
 * 展开tab标签
 * @param {type} id
 * @returns {undefined}
 */
function zkTab(id) {
    $('#main-nav li ul').each(function () {
        $(this).collapse('hide');
    });
    $('#' + id).collapse('show');

}
/**
 * 跳转页面变化标题
 * @param {type} url
 * @param {type} obj
 * @returns {undefined}
 */
function jumpPage(url, obj) {
    $('#rightMain').attr('src', url);
    if (obj == 0) {
        $('#firCat').html('');
        $('#secCat').html('首页');
    } else {
        $('#firCat').html($(obj).parent().parent().prev('div').text());
        $('#secCat').html($(obj).text());
    }
}

/**
 * 展开下拉菜单
 * @param {type} id
 * @returns {undefined}
 */
function zkDropDown(id) {
    $(".dropdown-toggle").dropdown('toggle');
    $('#' + id).dropdown('toggle');
}

/**
 * 打印对象信息
 * @param {type} obj
 * @returns {undefined}
 */
function writeObj(obj) {
    var description = "";
    for (var i in obj) {
        var property = obj[i];
        description += i + " = " + property + "\n";
    }
    alert(description);
}  

/**
 * 修改个人信息
 * @returns {undefined}
 */
function clickUser(){
    layer.msg('修改个人信息请前往智慧服务系统！');
}