/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {

});


//函数--------------------------------------------------------------------------
/**
 * 打开反馈
 */
function openComplaint() {
//    checkIsUser();   
    openModal();
}

function subForm() {
    $.post(c_path + '/InsertComplaint', {"form_data": $('#save-form').serialize()}, function (data) {
        console.log(data);
        if (data.flag == 1) {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
             closeModal();
        } else {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
        }
    }, 'json');
   
}