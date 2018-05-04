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
 * 登录
 * @returns {undefined}
 */
function subLogin() {
    var user = $('#loginUser').val();
    var pwd = $('#loginPwd').val();

    $.post(c_path + "/login", {'username': user, 'password': pwd}, function (data) {
        if (data.username != '' && data.username != null) {
            mui.toast(data.username);
        } else if (data.password != '' && data.password != null) {
            mui.toast(data.password);
        } else if (data.is_success != '' && data.is_success != null) {
            mui.toast(data.is_success);
        } else {
            aHref(m_path + '/activity/activity_list');
        }
    }, 'json');
}

/**
 * 注册
 * @returns {undefined}
 */
function subReg() {
    $.post(c_path + "/registerUser", {'username': $('#username').val(), 'password': $('#password').val(), 'passworda': $('#passworda').val()}, function (data) {
        if (data.username != '' && data.username != null) {
            mui.toast(data.username, {duration: 'long', type: 'div'});
        } else if (data.password != '' && data.password != null) {
            mui.toast(data.password, {duration: 'long', type: 'div'});
        } else if (data.passworda != '' && data.passworda != null) {
            mui.toast(data.passworda, {duration: 'long', type: 'div'});
        } else if (data.checkpwda != '' && data.checkpwda != null) {
            mui.toast(data.checkpwda, {duration: 'long', type: 'div'});
        } else if (data.is_success == 0) {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
        } else {
            mui.alert('注册成功！请登录', '提示', '马上登录', function () {
                aHref('index');
            });
        }
    }, 'json');
}

/**
 * 获取验证码
 * @returns {undefined}
 */
function getKeyCode() {
    var flag = 1;
    emailCheck = /^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/;
    if ($('#email').val() != '') {
        if (emailCheck.test($('#email').val())) {
            flag = 1;
        } else {
            flag = 0;
            msg = '电子邮箱不正确';
        }
    }

    if (flag == 0) {
        mui.toast(msg, {duration: 'long', type: 'div'});
    } else {
        $.post(c_path + "/forget", {'usr': $('#usr').val(), 'email': $('#email').val()}, function (data) {
            if (data.is_success.flag == 1) {
                mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
            } else {
                mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
            }
        }, 'json');
    }
}

/**
 * 提交找回密码表单
 * @returns {undefined}
 */
function subFindPwd() {
    var flag = 1;
    emailCheck = /^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/;
    if ($('#email').val() != '') {
        if (emailCheck.test($('#email').val())) {
            flag = 1;
        } else {
            flag = 0;
            msg = '电子邮箱不正确';
        }
    }

    if (flag == 0) {
        mui.toast(msg, {duration: 'long', type: 'div'});
    } else {
        $.post(c_path + "/checkKeyCode", {'usr': $('#usr').val(), 'email': $('#email').val(), 'keycode': $('#keycode').val()}, function (data) {
            if (data.is_success.flag == 1) {
                $('#checkUsr').css('display', 'none');
                $('#editPwd').css('display', 'block');
                if(data.is_success.user_id!=null){
                    $('#user_id').val(data.is_success.user_id);
                }
                mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
            } else {
                mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
            }
        }, 'json');
    }
}

/**
 * 修改密码
 * @returns {undefined}
 */
function editPwd() {
    $.post(c_path + "/editPwd", {'newPwd': $('#newPwd').val(), 'confirmPwd': $('#confirmPwd').val(),'user_id':$('#user_id').val()}, function (data) {
        if (data.is_success.flag == 1) {
            $('#checkUsr').css('display', 'none');
            $('#editPwd').css('display', 'block');
            mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
            window.location.href = c_path + "/index";
        } else {
            mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
        }
    }, 'json');

}
