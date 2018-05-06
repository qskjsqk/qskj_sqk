/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    checkIsLogin();

    $("select[name='cat_id']").change(function () {
        var cat_id = $(this).val();
        //如果选中3,即第三方劵码,需要手动填写编号
        if(cat_id == 3) {
            $("#goods-number-title").show();
            $("#goods-number-input").show();
        } else {
            $("#goods-number-title").hide();
            $("#goods-number-input").hide();
            $("input[name='goods_number']").val('');
            //如果选中2,即积分换,不需要填写支付价
            if(cat_id == 2) {
                $("#payment-amount-title").hide();
                $("#payment-amount-input").hide();
                $("input[name='payment_amount']").val('');
            } else {
                $("#payment-amount-title").show();
                $("#payment-amount-input").show();
            }
        }
    })

});

//验证提交
function checkAddGoods() {
    if($("input[name='goods_name']").val() == '') {
        mui.alert('请输入商品名称');
        return false;
    }

    if($("select[name='cat_id']").val() == 3) {
        if($("input[name='goods_number']").val() == '') {
            mui.alert('请输入商品编号');
            return false;
        } else {
            if(checkGoodsNumberUnique($("input[name='goods_number']").val()) == false) {
                mui.alert('该商品编号已经存在');
                return false;
            }
        }
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

    return true;
}

//验证手动输入的编号是否已经存在
function checkGoodsNumberUnique(goodsNumber) {
    var flag = true;
    $.ajax({
        url : c_path + '/checkGoodsNumberIsExist',
        data : {goodsNumber : goodsNumber},
        type : 'post',
        async: false,
        success : function (res) {
            if(res.ret == 0 ) {
                flag = false;
            }
        }
    })
    return flag;
}

//添加商品
function addGoods() {
    if(checkAddGoods() == true) {
        $.ajax({
            url : c_path + '/addGoods',
            data : {data : $('#form').serialize()},
            type : 'post',
            async: false,
            success : function (res) {
                if(res.ret == 0 ) {
                    mui.alert('添加成功', '提示', '已添加', function () {
                        aHref(c_path + "/goods_manage");
                    });
                } else {
                    mui.alert('添加失败');
                }
            }
        })
    }
}



