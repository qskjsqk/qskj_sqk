/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    checkIsLogin();
});

function subForm() {
    var title = $('input[name="title"]').val();
    var content = $('textarea[name="content"]').val();
    var file = $('#fileList').html();

    if (title == '' || content == '' || file == '') {
        mui.toast('请完善广告信息！', {duration: 'long', type: 'div'});
        return;
    }
    //兑换发布权限
    mui.post(c_path + "/exchangeAdInte", function (data) {
        if (data.flag == 1) {
            $.post(c_path + '/savePromInfo', {"form_data": $('#save-form').serialize()}, function (data) {
                console.log(data);
                if (data.code == 500) {
                    mui.toast('添加成功！', {duration: 'long', type: 'div'});
                    aHref(c_path + '/prom_manage');
                } else {
                    mui.toast(data.msg, {duration: 'long', type: 'div'});
                }
            }, 'json');
        } else {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
        }
    }, 'json');


}

