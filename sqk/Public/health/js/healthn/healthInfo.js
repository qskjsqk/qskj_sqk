/**
 * @name healthinfo.js
 * @info 描述：健康知识信息脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-24 13:32:02
 */
$(function () {
    //新增按钮绑定事件
    $('#saveInfo-btn').click(function () {
        $.post(c_path + '/saveHealthInfo', {"form_data": $('#save-form').serialize()}, function (result) {
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
            layer.confirm('确定要批量删除嘛？', {
                icon: 2,
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
    });
});
/**
 * 删除某条信息
 * @param {type} id
 * @returns {undefined}
 */
function delInfoLayer(id) {
    layer.confirm('确定要删除此信息嘛？', {
        icon: 2,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/delHealthInfo', {'id': id}, function (result) {
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
 * 发布某条信息
 * @param {type} id
 * @returns {undefined}
 */
function pubInfoLayer(id) {
    layer.confirm('确定要发布此信息嘛？', {
        icon: 2,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/publHealthInfo', {'id': id}, function (result) {
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