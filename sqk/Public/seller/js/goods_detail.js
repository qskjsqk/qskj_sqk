/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    checkIsLogin();
});

function lowerFrame(goods_id, type) {
    var title = (type == 1) ? '已发布' : '已下架';
    $.ajax({
        url : c_path + '/lowerFrameGoods',
        data : {goods_id : goods_id, type : type},
        type : 'post',
        success : function (res) {
            console.log(res);
            if(res.ret == 0 ) {
                mui.alert('操作成功', '提示', title, function () {
                    aHref(c_path + "/goods_detail/goods_id/" + goods_id);
                });
            } else {
                mui.alert('操作失败');
            }
        }
    })
}

