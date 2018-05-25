/**
 * 商家信息JS
 * Created by GX on 2017-02-20.
 */
$(function () {
    
    //新增按钮绑定事件
    $('#saveInfo-btn').click(function () {
        $.post(c_path + '/saveSellerPromInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000, zIndex: 111111111}, function () {
                    if ($('input[name="from"]').val() != '') {
                        window.location.href = c_path + '/showList/seller_id/' + $('input[name="seller_id"]').val() + '/from/' + $('input[name="from"]').val();
                    } else {
                        window.location.href = c_path + '/showList';
                    }
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
});



//批量删除商家促销信息
function delInfoLayer(isChecked) {
    layer.confirm('确定要批量删除此信息嘛？', {
        icon: 2,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/delArrPromInfo', {'ids': isChecked}, function (result) {
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
