/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//初始化-----------------------------------------------------------------------------------------
$(function () {
    var address_id = getUrl('address_id');
    if (address_id == null) {
        getAdList(0);
    } else {
        getAdList(address_id);
    }
});

/**
 * 获取广告列表
 * @param {type} address_id
 * @returns {undefined}
 */
function getAdList(address_id) {
    $.post(c_path + "/getAdList", {'address_id': address_id}, function (data) {
        var str = "";
        for (var i = 0; i < data.length; i++) {
            str += '<div class="adList" >';
            str += '   <div class="adImgArea"><img class="adImg" src="../../../' + data[i].tx_path + '"></div>';
            str += '   <div class="adTitle">' + data[i].name + '</br>[' + data[i].address_name + ']</div>';
            str += '</div>';
        }
        $('#adList').html(str);
    }, 'json');
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

function backHome(address_id){
    window.location.href = c_path + '/index?address_id=' + address_id;
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