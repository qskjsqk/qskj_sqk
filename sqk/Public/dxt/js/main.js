/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//初始化-----------------------------------------------------------------------------------------
$(function () {
    var client_id = getUrl('client_id');
    var address_id = getUrl('address_id');
    if (address_id == null) {
        getAdList(0, 1);
    } else {
        getAdList(address_id, 1);
    }

    var TimeNum = new Date().getTime();
//mousedown() 监听鼠标是否使用 keydown() 监听键盘是否可用
    $(document).mousedown(function () {
        TimeNum = new Date().getTime();
    }).keydown(function () {
        TimeNum = new Date().getTime();
    }).mousemove(function () {
        TimeNum = new Date().getTime();
    });
    
//    $(document.frames('right').document).mousedown(function () {
//        TimeNum = new Date().getTime();
//    }).keydown(function () {
//        TimeNum = new Date().getTime();
//    }).mousemove(function () {
//        TimeNum = new Date().getTime();
//    });

//setInterval用来判断 当前时间之差
    setInterval(function () {
//这里判断按键或鼠标 事件是否触发了 
        var TimeCount = new Date().getTime();
        var minutes = Math.floor((TimeCount - TimeNum) / 1000);
        console.log(minutes);
//如果两个时间差大于1分钟
        if (minutes >= 60) {
            window.location.href = c_path + '/index?client_id=' + client_id;
        }
    }, 1000);

});

function timeZero(){
    TimeNum = new Date().getTime();
}



/**
 * 获取广告列表
 * @param {type} address_id
 * @returns {undefined}
 */
function getAdList(address_id, page) {
    $.post(c_path + "/getAdList", {'address_id': address_id, 'page': page}, function (data) {
        var str = "";
        if (data.length == 0) {
            str = "<font color='#fff'>该社区暂无商家</font>";
            $('#page').val(0);
        } else {
            for (var i = 0; i < data.length; i++) {
                str += '<div class="adList" >';
                str += '   <div class="adImgArea"><img class="adImg" src="../../../' + data[i].tx_path + '"></div>';
                str += '   <div class="adTitle">' + data[i].name + '</br>[' + data[i].address_name + ']</br>积分：' + data[i].exp_num + '</div>';
                str += '</div>';
            }
            $('#page').val(data[0].page);
            $('#end').val(data[0].end);
        }
        $('#adList').html(str);
    }, 'json');
}

function getAdListNext() {
    TimeNum = new Date().getTime();
    var address_id = $('#address_id').val();
    var page = parseInt($('#page').val());
    var end = parseInt($('#end').val());
    if (page == 0 || end == 1) {

    } else {
        page = parseInt(page) + 1;
        getAdList(address_id, page);
    }
}

function getAdListPre() {
    TimeNum = new Date().getTime();
    var address_id = $('#address_id').val();
    var page = parseInt($('#page').val());
    if (page == 0 || page == 1) {

    } else {
        page = parseInt(page) - 1;
        getAdList(address_id, page);
    }
}

function getAddressAdList() {
    var address_id = $('#address_id').val();
    getAdList(address_id, 1);
}

/**
 * 获取详情
 * @param {type} address_id
 * @param {type} id
 * @returns {undefined}
 */
function getDetail(address_id, id) {
    window.location.href = c_path + '/detail?address_id=' + address_id + '&id=' + id;
}

function backHome(address_id) {
    var client_id = getUrl('client_id');
    window.location.href = c_path + '/index?address_id=' + address_id + '&client_id=' + client_id;
}

/**
 * 正则表达式方法获取url参数获取时记着解码 decodeURI(getUrl(name));
 * @param {type} name
 * @returns {getUrl.r}
 */
function getUrl(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
        return r[2];
    return null;
}

/**
 * 重置img部分代码
 * @param {type} htmlstr
 * @returns {unresolved}
 */
function img_reset(htmlstr) {
    var arr = htmlstr.match(/<(div|p)(\W|\w)*?<img(\W|\w)*?<\/(div|p)>/gi);

    for (var key in arr) {
        var img_arr = arr[key].match(/<img(.|\s)*?>/gi);
        var img_html = '<div>' + img_arr[0] + '</div>';
        htmlstr = htmlstr.replace(img_arr[0], img_html);
    }
    return htmlstr;
}