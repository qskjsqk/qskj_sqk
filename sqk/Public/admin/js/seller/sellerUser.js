/**
 * @name newjavascript
 * @info 描述：
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 14:39:17
 */
$(function () {
    //新增按钮绑定事件
    $('#saveInfo-btn').click(function () {
        $.post(c_path + '/saveSellerUser', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                window.location.href = c_path + '/saveSellerInfo/user_id/' + result.dataID;
            } else if (result.code == '502') {
                layer.msg(constants.FAILD, {time: 1000, zIndex: 111111111});
            } else {
                layer.msg(result.msgError, {time: 2000, zIndex: 111111111});
            }
        }, 'json');
    });
    
    
});