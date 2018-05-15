/**
 * @name setting
 * @info 描述：个人中心的js
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-2 9:02:30
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {

});
/**
 * 修改资料
 * @returns {undefined}
 */
function saveUserInfo() {
    var flag = 1;
    if ($('#realname').val() != '') {
        flag = 1;
    } else {
        flag = 0;
        msg = '请输入姓名';
    }

    birthdayCheck = /^[1-2][0-9]{3}-[0-1][1-9]-[0-3][1-9]$/;
    if ($('#birthday').val() != '') {
        if (birthdayCheck.test($('#birthday').val())) {
            flag = 1;
        } else {
            flag = 0;
            msg = '生日格式不正确';
        }
    }else {
        flag = 0;
        msg = '请输入生日';
    }
    if (flag == 0) {
        mui.toast(msg, {duration: 'long', type: 'div'});
    } else {
        $.post(c_path + "/addUserappInfo", {
            'tel': $('#tel').html(),
            'realname': $('#realname').val(),
            'birthday': $('#birthday').val(),
            'gender': $('#gender').val(),
            'address_id': $('#address_id').val(),
            
            'tx_path': $('#tx_path').val(),
            'wx_num': $('#wx_num').val(),
            'nickname': $('#nickname').val(),
        }, function (data) {
            if (data.is_success.flag == 1) {
                aHref(c_path+'/index');
            } else {
                mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
            }
        }, 'json');
    }

}

