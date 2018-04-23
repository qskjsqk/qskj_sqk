/**
 * 商家信息JS
 * Created by GX on 2017-02-20.
 */
$(function () {

    //新增按钮绑定事件
    $('#saveInfo-btn').click(function () {
        $.post(c_path + '/saveActivInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000, zIndex: 111111111}, function () {
                    window.location.href = c_path + '/showList';
                });
            } else if (result.code == '502') {
                layer.msg(constants.FAILD, {time: 1000, zIndex: 111111111});
            } else {
                layer.msg(result.msgError, {time: 2000, zIndex: 111111111});
            }
        }, 'json');
    });
    //批量删除按钮绑定事件
    $('#delArrayInfo-btn').click(function () {
        var isChecked = '';
        if ($("input[name='rowChecked']:checked").length <= 0) {
            layer.msg('请选择批量删除的数据！', {time: 2000});
            return;
        } else {
            $('input[name="rowChecked"]:checked').each(function () {
                isChecked += $(this).val() + ',';
            });
            delInfoLayer(isChecked);
        }
    });
    //批量发布按钮绑定事件
    $('#publishArrayInfo-btn').click(function () {
        var isChecked = '';
        if ($("input[name='rowChecked']:checked").length <= 0) {
            layer.msg('请选择批量发布的数据！', {time: 2000});
            return;
        } else {
            $('input[name="rowChecked"]:checked').each(function () {
                isChecked += $(this).val() + ',';
            });
            publishInfoLayer(isChecked);
        }
    });

    console.log(assignData);
    //binding悬停事件
    $(".tips_show").mouseover(function () {
        showActDetail($(this));
    });


    //涉及相关社区参数
    //assignData.address_id 登录用户所属社区
    if (action == "edit") {
        if (assignData.address_id != 0) {
            $("#address_id").find("option[value='" + assignData.address_id + "']").attr("selected", 'selected');
            $("#address_id").find("option[value!='" + assignData.address_id + "']").attr("disabled", "disabled");
        } else {
            $("#address_id").find("option[value='" + assignData.activInfo.address_id + "']").attr("selected", 'selected');
        }
        $("#integral").find("option[value='" + assignData.activInfo.integral + "']").attr("selected", 'selected');
    } else if (action == "add") {
        if (assignData.address_id != 0) {
            $("#address_id").find("option[value='" + assignData.address_id + "']").attr("selected", 'selected');
            $("#address_id").find("option[value!='" + assignData.address_id + "']").attr("disabled", "disabled");
        }
    }
});
//删除活动信息
function delInfoLayer(isChecked) {
    layer.confirm('确定要删除此信息嘛？', {
        icon: 0,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/delArrayInfo', {'ids': isChecked}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    location.reload();
                    $('input[name="rowChecked"]:checked').each(function () {
                        $(this).removeAttr('checked');
                    });
                });
            } else {
                layer.msg(constants.FAILD);
            }
        }, 'json');
    });
}
//发布活动信息
function publishInfoLayer(isChecked) {
    layer.confirm('确定要批量发布此信息嘛？', {
        icon: 0,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/publishArrayInfo', {'ids': isChecked}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    location.reload();
                    $('input[name="rowChecked"]:checked').each(function () {
                        $(this).removeAttr('checked');
                    });
                });
            } else {
                layer.msg(constants.FAILD);
            }
        }, 'json');
    });
}

/**
 * 关闭
 * @param {type} id
 * @returns {undefined}
 */
function closeAct(id) {
    layer.confirm('确定要关闭本活动签到通道吗？', {
        icon: 0,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/closeAct', {'id': id}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    location.reload();
                });
            } else {
                layer.msg(result.msg);
            }
        }, 'json');
    });
}


//显示参加活动人员列表
function joinUser(id, join_num) {
    if (join_num == 0) {
        layer.msg('暂无人员参加');
        return;
    }
    layer.open({
        type: 1,
        title: ['参加活动人员列表', 'font-size:16px;font-weight: bold;color: #2e8ded;'], //标题信息及样式
        skin: 'layui-layer-rim', //加上边框
        shadeClose: true, //是否点击遮罩关闭
        resize: false, //是否允许拉伸
        area: ['650px', '350px'], //宽高
        content: $('.userListLayer'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        btn: ['关闭'],
        cancel: function (index) {
        },
        success: function (layero) {
            $("#user_table").find("td").remove();
            var strHtml = '';
            $.post(c_path + '/showJoinList', {'id': id}, function (result) {
                var usrName = '';
                $.each(result, function (index, value) {
                    if (value['tel'] == null || value['tel'] == '') {
                        value['tel'] = '未填';
                    }
                    if (value['address'] == null || value['address'] == '') {
                        value['address'] = '未填';
                    }
                    if (value['realname'] == null || value['realname'] == '') {
                        usrName = value['usr'];
                    } else {
                        usrName = value['realname'];
                    }
                    strHtml += '<tr class="tr">' +
                            '<td>' + parseInt(index + 1) + '</td>' +
                            '<td>' + usrName + '</td>' +
                            '<td>' + value['tel'] + '</td>' +
                            '<td>' + value['address'] + '</td>' +
                            '</tr>';
                });
                $('.tableTitle').after(strHtml);
            }, 'json');
        }
    });
    return;
}

function showActDetail(obj) {
    console.log(obj);
    var str = '发起：【' + assignData.infoList[obj.context.id].initiator + '】</br>' +
            '联系：【' + assignData.infoList[obj.context.id].link_name + '|' + assignData.infoList[obj.context.id].link_tel + '】</br>' +
            '地点：【' + assignData.infoList[obj.context.id].address + '】</br>' +
            '时间：【' + assignData.infoList[obj.context.id].start_time + '】</br>'+
            '发表：【' + assignData.infoList[obj.context.id].realname + '】</br>' 
            
    layer.tips(str, obj, {
        tips: [2, '#3595CC'],
        time: 4000
    });
}