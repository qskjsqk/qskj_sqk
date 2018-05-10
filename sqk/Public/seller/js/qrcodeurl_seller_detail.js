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
    if(trading_integral == '') {
        mui.alert('请输入交易积分');
    }
    var user_id = assignData.data.appUserInfo.id;
    var str = "" + trading_integral + '积分';
    var btnArray = ['取消', '支付'];
    mui.confirm('您需要支付商家', str, btnArray, function (e) {
        if (e.index == 1) {
            $.ajax({
                url : c_path + '/kouFenExchange',
                type : 'post',
                data : {trading_integral : trading_integral, app_user_id : user_id},
                success : function (res) {
                    console.log(res);
                    if(res.ret == 0) {
                        mui.alert('交易成功');
                    } else {
                        mui.alert(res.msg);
                    }
                }
            })
        }
    })
}

