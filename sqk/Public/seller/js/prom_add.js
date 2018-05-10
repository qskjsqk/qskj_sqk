/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    checkIsLogin();
});

function subForm() {
    $.post(c_path + '/savePromInfo', {"form_data": $('#save-form').serialize()}, function (data) {
        console.log(data);
        if (data.code == 500) {
            mui.toast('添加成功！', {duration: 'long', type: 'div'});
            aHref(c_path+'/prom_manage');
        } else {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
        }
    }, 'json');
   
}

