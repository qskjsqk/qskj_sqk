/**
 * @name userAppInfo-javascript
 * @info 描述：居民用户信息相关脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 14:39:17
 */
$(function () {
    //新增按钮绑定事件
    $('#saveInfo-btn').click(function () {
        $.post(c_path + '/saveUserInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    window.location.href = c_path + '/showList';
                });
            } else if (result.code == '502') {
                layer.msg(constants.FAILD, {time: 1000});
            } else {
                layer.msg(result.msgError, {time: 2000});
            }
        }, 'json');
    });
    //编辑按钮绑定事件
    $('#editInfo-btn').click(function () {
        $.post(c_path + '/editUserInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    window.location.href = c_path + '/showList';
                });
            } else if (result.code == '502') {
                layer.msg(constants.FAILD, {time: 1000});
            } else {
                layer.msg(result.msgError, {time: 2000});
            }
        }, 'json');
    });

    //修改资料事件
    $('#saveMyInfo-btn').click(function () {
        $.post(c_path + '/saveUserMyInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    window.location.href = m_path + '/index/main';
                });
            } else if (result.code == '502') {
                layer.msg(constants.FAILD, {time: 1000});
            } else {
                layer.msg(result.msgError, {time: 2000});
            }
        }, 'json');
    });

    $('#delArrayGroup-btn').click(function () {
        var isChecked = '';
        if ($("input[name='rowChecked']:checked").length <= 0) {
            layer.msg('请选择批量删除的数据！', {time: 2000});
            return;
        } else {
            $('input[name="rowChecked"]:checked').each(function () {
                isChecked += $(this).val() + ',';
            });
            delUserLayer(isChecked);
        }
    });
    //涉及相关社区参数
    //assignData.address_id 登录用户所属社区
    if (action == "edit") {
        if (assignData.address_id != 0) {
            $("#address_id").find("option[value='" + assignData.address_id + "']").attr("selected", 'selected');
            $("#address_id").find("option[value!='" + assignData.address_id + "']").attr("disabled", "disabled");
        } else {
            $("#address_id").find("option[value='" + assignData.userInfo.address_id + "']").attr("selected", 'selected');
        }
    } else if (action == "saveUserInfo") {
        if (assignData.address_id != 0) {
            $("#address_id").find("option[value='" + assignData.address_id + "']").attr("selected", 'selected');
            $("#address_id").find("option[value!='" + assignData.address_id + "']").attr("disabled", "disabled");
        }
    }
});

//删除用户信息
function delUserLayer(isChecked) {
    layer.confirm('确定要删除此用户嘛？', {
        icon: 2,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/delArrUserInfo', {'ids': isChecked}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    location.reload();
                });
            } else {
                layer.msg(constants.FAILD);
            }
        }, 'json');
    });
}

/**
 * 绑定实体卡
 * @param {type} id
 * @returns {undefined}
 */
function bindingCardLayer(id) {
    $('#card_num').val('');
    layer.open({
        type: 1,
        title: ['绑定实体卡', 'font-size:16px;font-weight: bold;color: #2e8ded;'], //标题信息及样式
        skin: 'layui-layer-rim', //加上边框
        shadeClose: true, //是否点击遮罩关闭
        resize: false, //是否允许拉伸
        area: ['420px', '230px'], //宽高
        content: $('.bindingCardLayer'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        btn: ['确定', '取消'],
        yes: function (index) {
//            alert(1);
            submitCardInfo(index, id, 1);
        },
        btn2: function (index) {

        },
        success: function (layero) {
//            加载页面成功
//            alert(3);

        }
    });
}

/**
 * 提交IC卡信息
 * @param {type} index
 * @param {type} id
 * @returns {undefined}
 */
function submitCardInfo(index, id) {
    $cardNum = $('#card_num').val();
    if ($cardNum == '') {
        layer.msg('请输入IC卡编号');
        return;
    }
    $.post(c_path + '/setUserAppUfNum', {'id': id, 'card_num': $cardNum}, function (result) {
        if (result.code == '500') {
            layer.msg(constants.SUCCESS, {time: 1000}, function () {
                location.reload();
            });
        } else {
            layer.msg(constants.FAILD);
        }
    });
}

/**
 * 获取ic卡串号
 * @returns {undefined}
 */
function getCardUfNum() {
    $.post(c_path + '/getCardUfNum', function (result) {
        if (result.code == '500') {
            $('#card_ufnum_btn').hide();
            $('#card_ufnum').show();
            $('#card_ufnum').attr('value', result.uf_num);
        } else {
            $('#card_ufnum_btn').html('读卡失败，点击重新读卡');
        }
    }, 'json');
}