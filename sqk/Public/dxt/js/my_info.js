/**
 * @name setting
 * @info 描述：个人中心的js
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-2 9:02:30
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    
    //mousedown() 监听鼠标是否使用 keydown() 监听键盘是否可用
    $(document).mousedown(function () {
        parent.timeZero();
    }).keydown(function () {
        parent.timeZero();
    }).mousemove(function () {
        parent.timeZero();
    });
    
    checkIsLogin();
    getUserappInfo();
});

//函数--------------------------------------------------------------------------------------------
function getUserappInfo() {
    mui.post(c_path + "/getUserappInfo?type=api", function (data) {
        $('#realname').val(data.realname);
        $('#tel').val(data.tel);
        $('#birthday').val(data.birthday);
        $('#headimgurl').attr('src', data.tx_path);

        $("#gender").find("option[value='" + data.gender + "']").attr("selected", 'selected');
        $("#address_id").find("option[value='" + data.address_id + "']").attr("selected", 'selected');
    }, 'json');
}



/**
 * 修改资料
 * @returns {undefined}
 */
function saveUserInfo() {
    getUserappInfo();
    var flag = 1;
    telCheck = /^1[3|5|7|8|][0-9]{9}$/;
    if ($('#tel').val() != '') {
        if (telCheck.test($('#tel').val())) {
            flag = 1;
        } else {
            flag = 0;
            msg = '手机号码不正确';
        }
    }
    if (flag == 0) {
        mui.toast(msg, {duration: 'long', type: 'div'});
    } else {
        $.post(c_path + "/saveUserappInfo", {
            'tel': $('#tel').val(),
            'realname': $('#realname').val(),
            'birthday': $('#birthday').val(),
            'gender': $('#gender').val(),
            'address_id': $('#address_id').val(),
        }, function (data) {
            if (data.is_success.flag == 1) {
                getUserappInfo();
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
