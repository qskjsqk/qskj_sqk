/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    checkIsLogin();

    $("select[name='cat_id']").change(function () {
        //如果选中2,即积分换,不需要填写支付价
        var cat_id = $(this).val();
        showORhidePaymentAmount(cat_id);
    })

});

//如果商品类型是积分换,不需要填写支付价
function showORhidePaymentAmount(cat_id) {
    if(cat_id == 2) {
        $("#payment-amount-title").hide();
        $("#payment-amount-input").hide();
        $("input[name='payment_amount']").val('');
    } else {
        $("#payment-amount-title").show();
        $("#payment-amount-input").show();
    }
}

//验证提交
function checkEditGoods() {
    if($("input[name='goods_name']").val() == '') {
        mui.alert('请输入商品名称');
        return false;
    }

    if($("input[name='stock']").val() == '') {
        mui.alert('请输入库存数量');
        return false;
    } else if(isNaN($("input[name='stock']").val())) {
        mui.alert('库存数量必须是数字');
        return false;
    }

    if($("input[name='required_integral']").val() == '') {
        mui.alert('请输入所需积分');
        return false;
    } else if(isNaN($("input[name='required_integral']").val())) {
        mui.alert('所需积分必须是数字');
        return false;
    }

    if($("select[name='cat_id']").val() != 2) {
        if($("input[name='payment_amount']").val() == '') {
            mui.alert('请输入支付价');
            return false;
        } else if(isNaN($("input[name='payment_amount']").val())) {
            mui.alert('支付价必须是数字');
            return false;
        }
    }

    if($("input[name='original_price']").val() == '') {
        mui.alert('请输入声明原价');
        return false;
    } else if(isNaN($("input[name='original_price']").val())) {
        mui.alert('声明原价必须是数字');
        return false;
    }

    if($("input[name='goods_pic']").val() == '') {
        mui.alert('上传一张商品图');
        return false;
    }

    return true;
}

//修改商品
function editGoods() {
    if(checkEditGoods() == true) {
        $.ajax({
            url : c_path + '/editGoods',
            data : {data : $('#form').serialize()},
            type : 'post',
            async: false,
            success : function (res) {
                if(res.ret == 0 ) {
                    mui.alert('修改成功', '提示', '已修改', function () {
                        aHref(c_path + "/goods_manage");
                    });
                } else {
                    mui.alert('修改失败');
                }
            }
        })
    }

}



