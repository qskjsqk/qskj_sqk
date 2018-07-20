/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//初始化------------------------------------------------------------------------
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
    changeTab(0);

});
//函数--------------------------------------------------------------------------
function changeTab(nla) {
    $('#tab0').removeClass('btn_active');
    $('#tab1').removeClass('btn_active');
    $('#tab2').removeClass('btn_active');
    $('#tab' + nla).addClass('btn_active');
    getTopList(nla);
}

function getTopList(nla) {
    var type = getUrl('type');
    switch (type) {
        case '0':
            $('#topName').html('<b>①</b>&nbsp;本社区用户榜');
            $('#top_name').html('本社区用户榜');
            break;
        case '1':
            $('#topName').html('<b>②</b>&nbsp;梨园镇用户榜');
            $('#top_name').html('梨园镇用户榜');
            break;
        case '2':
            $('#topName').html('<b>③</b>&nbsp;梨园镇商家榜');
            $('#top_name').html('梨园镇商家榜');
            break;
        case '3':
            $('#topName').html('<b>④</b>&nbsp;梨园镇社区榜');
            $('#top_name').html('梨园镇社区榜');
            break;
    }
    $.post(c_path + "/getTopList", {'type': type, 'nla': nla}, function (data) {

        var str = '';
        if (data.topList.length == 0) {
            str += '<div class="mui-row row_list"><span class="row_list_integral">暂无数据！</span></div>';
        } else {
            for (var i = 0; i < data.topList.length; i++) {
                str += '<div class="mui-row row_list">' +
                        '<div class="row_list_jp jp0' + (i + 1) + '"></div>' +
                        '<div class="row_list_tx">' +
                        data.topList[i]['tx_icon'] +
                        ' </div>' +
                        '<span class="row_list_title">'+data.topList[i]['top']+'</br><p>'+data.topList[i]['bottom']+'</p></span>' +
                        '<span class="row_list_integral">'+data.topList[i]['right']+'</span>' +
                        '</div>';
            }
        }

        $('#topList').html(str);

    }, 'json');
}
