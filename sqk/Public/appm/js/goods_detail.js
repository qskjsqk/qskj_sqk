/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    checkIsLogin();
    $('#keyword').val('');
    getGoodsList(1, '', '', '', '');

    document.onkeydown = function (event_e) {
        if (window.event) {
            event_e = window.event;
        }
        console.log(event_e);
        var int_keycode = event_e.key || event_e.code;
        if (int_keycode == 'Enter') {
            getGoodsList(1, $('#keyword').val(), '', '', '');
            return false;
        }
    }


});


//函数--------------------------------------------------------------------------------------------
/**
 * 打开筛选
 */
function openExchange() {
    openModal();
}

function subForm() {
    var status = $('input[name="status"]').val();
    alert(status);
    console.log(status);
//    getActivList(1, '', address_id, cat_id, integral);//加载列表
    closeModal();
}
