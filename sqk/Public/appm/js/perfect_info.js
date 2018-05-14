/**
 * @name setting
 * @info 描述：个人中心的js
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-2 9:02:30
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {

});
/**
 * 修改资料
 * @returns {undefined}
 */
function saveUserInfo() {
    var flag = 1;
    if (flag == 0) {
        mui.toast(msg, {duration: 'long', type: 'div'});
    } else {
        $.post(c_path + "/addSellerInfo", {
            'tel': $('#tel').html(),
            
            'business_license': $('#business_license').val(),
            'name': $('#name').val(),
            'address_id': $('#address_id').val(),
            'address': $('#address').val(),
            'address_api_url': $('#address_api_url').val(),
            'contacts': $('#contacts').val(),
            
            'tx_path': $('#tx_path').val(),
            'wx_num': $('#wx_num').val(),
            'nickname': $('#nickname').val(),
        }, function (data) {
            if (data.is_success.flag == 1) {
                aHref(c_path+'/index');
            } else {
                mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
            }
        }, 'json');
    }

}

