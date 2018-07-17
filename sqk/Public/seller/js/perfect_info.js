/**
 * @name perfect_info
 * @info 描述：商家完善信息
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
function saveSellerInfo() {
    var flag=1;
    var map = new BMap.Map("container");
    var local = new BMap.LocalSearch(map);
    local.search($('#address').val());
    var Longitude = $('#address_api_url').val();
    local.setSearchCompleteCallback(function (searchResult) {
        if (local.getStatus() == BMAP_STATUS_SUCCESS) {
            var poi = searchResult.getPoi(0);
            $('#address_api_url').val(poi.point.lng + ',' + poi.point.lat);
            if (flag == 0) {
                mui.toast(msg, {duration: 'short', type: 'div'});
            } else {
                $.post(c_path + "/saveSellerInfo", {
                    'tel': $('#tel').html(),
                    'name': $('#name').val(),
                    'address': $('#address').val(),
                    'contacts': $('#contacts').val(),
                    'business_license': $('#business_license').val(),
                    'address_api_url': $('#address_api_url').val(),
                    'address_id': $('#address_id').val(),
                    
                    'headimgurl':$('#headimgurl').val(),
                    'openid':$('#openid').val(),
                    'nickname':$('#nickname').val(),
                }, function (data) {
                    if (data.is_success.flag == 1) {
                        location.href=c_path + "/index";
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

