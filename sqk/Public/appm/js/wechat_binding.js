/**
 * @name login
 * @info 描述：登录相关
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-28 10:23:26
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {

});
//函数--------------------------------------------------------------------------------------------
/**
 * 获取验证码
 * @returns {undefined}
 */
function getApplyKeyCode() {
    var flag = 1;
    emailCheck = /^1[3|5|7|8|][0-9]{9}$/;
    if ($('#tel').val() != '') {
        if (emailCheck.test($('#tel').val())) {
            flag = 1;
        } else {
            flag = 0;
            msg = '手机号码不正确';
        }
    } else {
        flag = 0;
        msg = '请输入手机号码';
    }
    console.log($('#tel').val());

    if (flag == 0) {
        mui.toast(msg, {duration: 'long', type: 'div'});
    } else {
        $.post(c_path + "/getApplyKeyCode", {'tel': $('#tel').val()}, function (data) {
            $('#hiddenKeycode').val(data.keycode);
            if (data.status == 1) {
            } else {
                mui.toast(data.msg, {duration: 'long', type: 'div'});
            }
        }, 'json');
    }
}

function checkApplyKeyCode() {
    var keycode = $('#keycode').val();
    var hiddenKeycode = $('#hiddenKeycode').val();
    if (keycode == hiddenKeycode) {
        aHref(c_path + "/perfect_info?tel=" + $('#tel').val());
    } else {
        mui.toast('验证码错误，请重试', {duration: 'long', type: 'div'});
    }
}

