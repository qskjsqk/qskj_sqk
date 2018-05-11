/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {

});


//函数--------------------------------------------------------------------------
//直接扣分交易
koufenExchange = function () {
    var trading_integral = $("input[name='trading_integral']").val();
    if (trading_integral == '') {
        mui.alert('请输入交易积分');
        return;
    }
    var user_id = assignData.data.appUserInfo.id;
    var str = "" + trading_integral + '积分';
    var btnArray = ['取消', '收取'];
    mui.confirm('直接收取用户积分', str, btnArray, function (e) {
        if (e.index == 1) {
            $.ajax({
                url: c_path + '/kouFenExchange',
                type: 'post',
                data: {trading_integral: trading_integral, app_user_id: user_id},
                success: function (res) {
                    if (res.ret == 0) {
                        var str = '';
                        str += '<table style="text-align:left;">';
                        str += '<tr><td>编号：' + res.data.tradingNumber + '</td></tr>';
                        str += '<tr><td>商家：' + res.data.sellerName + '</td></tr>';
                        str += '<tr><td>买家：' + res.data.appUserName + '</td></tr>';
                        str += '<tr><td class="fontred">积分：' + res.data.tradingIntegral + '</td></tr>';
                        str += '<tr><td>时间：' + res.data.tradingTime + '</td></tr>';
                        str += '</table>';
                        mui.alert(str, res.msg);
                    } else {
                        mui.alert(res.msg);
                    }
                }
            })
        }
    })
}

