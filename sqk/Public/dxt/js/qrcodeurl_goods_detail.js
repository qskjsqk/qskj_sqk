/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
//    checkIsLogin();
    var sellerId = getUrl('seller_id');

    $('#backBtn').attr('onclick', 'aHref("' + m_path + '/Qrcodeurl/seller_detail?id=' + sellerId + '")');

});


//函数--------------------------------------------------------------------------

/**
 * 打开兑换界面
 */
function openExchange() {
    checkIsUser();
    openModal();
    $('#number').html(1);
    calculPrice(1);
}

/**
 * 确认支付
 * @returns {undefined}
 */
function subExchange() {
    closeModal();

    var num = $('#number').html();
    var payment_amount = $('#payment_amount').val() * 1;
    var required_integral = $('#required_integral').val();


    if (payment_amount == '0.00') {
        var str = "" + required_integral + '积分';
    } else {
        var str = "" + required_integral + '积分,金额' + payment_amount.toFixed(2) + '元';
    }

    var btnArray = ['取消', '支付'];
    mui.confirm('您需要支付商家', str, btnArray, function (e) {
        if (e.index == 1) {
            $.post(c_path + '/exchangeGoods', {
                'seller_id': assignData.sellerInfo.id,
                'goods_id': assignData.goodInfo.id,
                'exchange_integral': required_integral
            }, function (data) {
                console.log(data);
                if (data.flag == 1) {
                    var str = '';
                    str += '<table style="text-align:left;">';
                    str += '<tr><td>编号：'+data.data.exchange_number+'</td></tr>';
                    str += '<tr><td>商家：'+data.data.seller_name+'</td></tr>';
                    str += '<tr><td>买家：'+data.data.user_name+'</td></tr>';
                    str += '<tr><td>商品：'+data.data.good_name+'</td></tr>';
                    str += '<tr><td class="fontred">积分：'+data.data.exchange_integral+'</td></tr>';
                    str += '<tr><td>时间：'+data.data.time+'</td></tr>';
                    str += '</table>';
                    mui.alert(str, data.msg);
                } else {
                    mui.alert(data.msg, {duration: 'long', type: 'div'});
                }
            }, 'json');
        }
    })

    console.log(payment_amount);


}

/**
 * 修改数量和价格
 * @param {type} type
 * @returns {undefined}
 */
function changeNum(type) {
    var number = $('#number').html();
    if (type == 0) {
        if (number == 1) {
            return;
        }
        number = parseInt($('#number').html()) - 1;
        $('#number').html(number);
        calculPrice(number);

    } else {
        if (number == assignData.goodInfo.user_exchange_limit) {
            return;
        }
        $('#jian').removeAttr('disabled');
        number = parseInt($('#number').html()) + 1;
        $('#number').html(number);
        calculPrice(number);
    }




}

/**
 * 计算总价格
 * @param {type} number
 * @returns {undefined}
 */
function calculPrice(number) {
    if (assignData.goodInfo.payment_amount == '0.00') {
        var required_integral = assignData.goodInfo.required_integral * number;

        $('#newPrice').html(required_integral + '积分');
    } else {
        var payment_amount = assignData.goodInfo.payment_amount * number;
        var required_integral = assignData.goodInfo.required_integral * number;
        $('#newPrice').html('￥' + payment_amount.toFixed(2) + '+' + required_integral + '积分');
    }
    $('#payment_amount').val(payment_amount);
    $('#required_integral').val(required_integral);
}
