/**
 * Created by GX on 2017-02-20.
 */
$(function () {
    //批量处理险情
    $('#dealArrayInfo-btn').click(function () {
        var isChecked = '';
        if ($("input[name='rowChecked']:checked").length <= 0) {
            layer.msg('请选择批量处理的数据！', {time: 2000});
            return;
        } else {
            $('input[name="rowChecked"]:checked').each(function () {
                isChecked += $(this).val() + ',';
            });
            dealInfoLayer(isChecked);
        }
    });
    //批量删除险情
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
});
//处理险情弹出框
function dealInfoLayer(isChecked) {
    var strHtml = '<form class="form-horizontal">' +
            '<div class="container" style="width: 350px;">' +
            '<div class="row">' +
            '<div class="form-group" style="margin-top: 20px;">' +
            '<label for="is_deal" class="col-sm-3 control-label">处理状态</label>' +
            '<div class="col-sm-8">' +
            '<select id="is_deal" class="form-control" onchange="setReplay(this.value);">' +
            '<option value="1">处理中</option>' +
            '<option value="2">已处理</option>' +
            '<option value="3">延时处理</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="form-group" style="margin-top: 20px;">' +
            '<label for="reply" class="col-sm-3 control-label">回复信息</label>' +
            '<div class="col-sm-8">' +
            '<textarea class="form-control" rows="3" id="reply" name="reply" value="" style="resize:none;" readonly>已接受，马上与您联系。</textarea>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</form>';
    layer.open({
        type: 1,
        title: ['险情处理', 'font-size:16px;font-weight: bold;color: #2e8ded;'],
        skin: 'layui-layer-rim', //加上边框
        shadeClose: true, //是否点击遮罩关闭
        resize: false, //是否允许拉伸
        area: ['400px', '300px'], //宽高
        content: strHtml, //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        btn: ['确定', '取消'],
        yes: function (index) {
            dealDangerInfo(index, isChecked, $('#is_deal').val(), $('#reply').val());
        },
        cancel: function (index) {
        }
    });
    return;
}
//设置默认回复信息
function setReplay(optionValue) {
    if (optionValue == 1) {
        $('#reply').val('已接受，马上与您联系。');
        $("#reply").attr("readonly", true);
    } else if (optionValue == 2) {
        $('#reply').val('谢谢您的反馈。');
        $("#reply").attr("readonly", true);
    } else {
        $('#reply').val('');
        $("#reply").attr("readonly", false);
    }
}
//删除险情信息
function delInfoLayer(isChecked) {
    layer.confirm('确定要批量删除险情嘛？', {
        icon: 2,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/delArrDangerInfo', {'ids': isChecked}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    location.reload();
                    window.parent.getPropNum();
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

//处理单条险情信息
function dealDangerInfo(index, isChecked, is_deal, reply) {
    layer.close(index);
    layer.confirm('确定要批量处理险情嘛？', {
        icon: 2,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/dealArrDangerInfo', {'ids': isChecked, 'is_deal': is_deal, 'reply': reply}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    location.reload();
                    window.parent.getPropNum();
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
//查看险情信息
function checkInfoLayer(id) {
    //do something
}