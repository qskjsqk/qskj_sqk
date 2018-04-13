/**
 * @name setting
 * @info 描述：个人中心脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-2 9:02:30
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    getUserInfo();
});

//函数--------------------------------------------------------------------------------------------
/**
 * 修改密码
 * @returns {undefined}
 */
function subEditPwd() {
    mui.post(c_path + "/nEditpwd", {'oldPwd': $('#oldPwd').val(), 'newPwd': $('#newPwd').val(), 'confirmPwd': $('#confirmPwd').val()}, function (data) {
        if (data.oldPwd != '' && data.oldPwd != null) {
            mui.toast(data.oldPwd, {duration: 'long', type: 'div'});
        } else if (data.newPwd != '' && data.newPwd != null) {
            mui.toast(data.newPwd, {duration: 'long', type: 'div'});
        } else if (data.confirmPwd != '' && data.confirmPwd != null) {
            mui.toast(data.confirmPwd, {duration: 'long', type: 'div'});
        } else if (data.difference != '' && data.difference != null) {
            mui.toast(data.difference, {duration: 'long', type: 'div'});
        } else if (data.is_success.flag == 0) {
            mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
        } else {
            mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
        }
    }, 'json');
}

/**
 *回显基本信息 
 */
function getUserInfo() {
    mui.post(c_path + "/getUserInfo", function (data) {
        //信息回显
        if (data.tel != '' && data.tel != null) {
            $("#tel").val(data.tel);
        }
        if (data.phone != '' && data.phone != null) {
            $("#phone").val(data.phone);
        }
        if (data.qq != '' && data.qq != null) {
            $("#qq").val(data.qq);
        }
        if (data.email != '' && data.email != null) {
            $("#email").val(data.email);
        }
        if (data.address != '' && data.address != null) {
            $("#address").val(data.address);
        }
        if (data.realname != '' && data.realname != null) {
            $("#realname").val(data.realname);
        }
        if (data.idcard_num != '' && data.idcard_num != null) {
            $("#idcard_num").val(data.idcard_num);
        }
        if (data.rns_type == 0) {
            if (data.idcard_num != '' && data.idcard_num != null) {
                //审核中状态
                $("#rns_type").html('(审核中)');
                $("#realname").val(data.realname);
                $("#idcard_num").val(data.idcard_num);
                $("#realname").attr('readonly', 'readonly');
                $("#realname").css('color', '#888');
                $("#idcard_num").attr('readonly', 'readonly');
                $("#idcard_num").css('color', '#888');
                $('#check').val(0);
            } else {
                //未填写状态
                $("#rns_type").html('(为保证功能使用，请您进行实名认证)');
                $('#check').val(0);
            }
        } else if (data.rns_type == 1) {
            //审核通过状态
            $("#rns_type").html('(审核通过)');
            $("#realname").attr('readonly', 'readonly');
            $("#realname").css('color', '#888');
            $("#realname").val(enctyName(data.realname));
            $("#idcard_num").attr('readonly', 'readonly');
            $("#idcard_num").val(enctyIdcard(data.idcard_num));
            $("#idcard_num").css('color', '#888');
            $('#check').val(1);
        } else {
            //审核不通过装态
            $("#rns_type").html('(审核不通过，请重新认证)');
            $("#realname").val(data.realname);
            $("#idcard_num").val(data.idcard_num);
            $("#realname").removeAttr('readonly');
            $("#realname").css('color', '#000');
            $("#idcard_num").removeAttr('readonly');
            $("#idcard_num").css('color', '#000');
            $('#check').val(0);
        }

    }, 'json');
}
/**
 * 修改资料
 * @returns {undefined}
 */
function saveUserInfo() {
    getUserInfo();
    var flag = 1;
    telCheck = /^1[3|5|7|8|][0-9]{9}$/;
    phoneCheck = /^(?:(?:0\d{2,3})-)?(?:\d{7,8})(-(?:\d{3,}))?$/;
    emailCheck = /^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/;
    idcardCheck = /^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/;
    if ($('#tel').val() != '') {
        if (telCheck.test($('#tel').val())) {
            flag = 1;
        } else {
            flag = 0;
            msg = '手机号码不正确';
        }
    }
    if ($('#phone').val() != '') {
        if (phoneCheck.test($('#phone').val())) {
            flag = 1;
        } else {
            flag = 0;
            msg = '座机号码不正确';
        }
    }
    if ($('#email').val() != '') {
        if (emailCheck.test($('#email').val())) {
            flag = 1;
        } else {
            flag = 0;
            msg = '电子邮箱不正确';
        }
    }
    if ($('#check').val() == 0) {
        if ($('#idcard_num').val() != '') {
            if (idcardCheck.test($('#idcard_num').val())) {
                flag = 1;
            } else {
                flag = 0;
                msg = '身份证号不正确';
            }
        }
    }

    if (flag == 0) {
        mui.toast(msg, {duration: 'long', type: 'div'});
    } else {
        $.post(c_path + "/saveUserInfo", {
            'tel': $('#tel').val(),
            'phone': $('#phone').val(),
            'qq': $('#qq').val(),
            'email': $('#email').val(),
            'realname': $('#realname').val(),
            'idcard_num': $('#idcard_num').val(),
            'address': $('#address').val(),
        }, function (data) {
            if (data.is_success.flag == 1) {
                getUserInfo();
                mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
            } else {
                mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
            }
        }, 'json');
    }

}

/**
 *加密名字 
 * @param {Object} name
 */
function enctyName(name) {
    var newName = name.substring(0, 1);
    for (var i = 0; i < name.length - 1; i++) {
        newName += '*';
    }
    return newName;
}

/**
 *加密身份证号
 * @param {Object} name
 */
function enctyIdcard(idcard) {
    var newidcard = idcard.substring(0, 3);
    newidcard = newidcard + '**********' + idcard.substr(idcard.length - 4, 4);
    return newidcard;
}