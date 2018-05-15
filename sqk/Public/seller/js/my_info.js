/**
 * @name my_info
 * @info 描述：商家资料
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-2 9:02:30
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    getSellerInfo();
});

//函数--------------------------------------------------------------------------------------------
function getSellerInfo() {
    mui.post(c_path + "/getSellerInfo?type=api", function (data) {
        $('#business_license').val(data.business_license);
        $('#tel').val(data.tel);
        $('#name').val(data.name);
        $('#contacts').val(data.contacts);
        $('#address').val(data.address);
        $("#address_id").find("option[value='" + data.address_id + "']").attr("selected", 'selected');
    }, 'json');
}



/**
 * 修改资料
 * @returns {undefined}
 */
function saveUserInfo() {
    var map = new BMap.Map("container");
    var local = new BMap.LocalSearch(map);
    local.search($('#address').val());
    var Longitude = $('#address_api_url').val();
    local.setSearchCompleteCallback(function (searchResult) {
        if (local.getStatus() == BMAP_STATUS_SUCCESS) {
            var poi = searchResult.getPoi(0);
            $('#address_api_url').val(poi.point.lng + ',' + poi.point.lat);
//            mui.toast("坐标：" + poi.point.lng + ',' + poi.point.lat, {duration: 'long', type: 'div'});
            getSellerInfo();
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
                mui.toast(msg, {duration: 'short', type: 'div'});
            } else {
                $.post(c_path + "/saveSellerInfo", {
                    'tel': $('#tel').val(),
                    'name': $('#name').val(),
                    'address': $('#address').val(),
                    'contacts': $('#contacts').val(),
                    'business_license': $('#business_license').val(),
                    'address_api_url': $('#address_api_url').val(),
                    'address_id': $('#address_id').val(),
                }, function (data) {
                    if (data.is_success.flag == 1) {
                        getSellerInfo();
                        mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
                    } else {
                        mui.toast(data.is_success.msg, {duration: 'long', type: 'div'});
                    }
                }, 'json');
            }
        } else {
            mui.toast("地址无法获取地图定位！", {duration: 'long', type: 'div'});
        }
    });



}
