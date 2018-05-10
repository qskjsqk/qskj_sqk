/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {

});


//函数--------------------------------------------------------------------------
/**
 * 打开反馈
 */
function openComplaint() {
//    checkIsUser();   
    openModal();
}

function subForm() {
    $.post(c_path + '/InsertComplaint', {"form_data": $('#save-form').serialize()}, function (data) {
        console.log(data);
        if (data.flag == 1) {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
            closeModal();
        } else {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
        }
    }, 'json');

}

function transrerIntegral () {
    var required_integral = $('#integral_num').val();
    if(required_integral==''){
        return;
    }
    var str = required_integral + '积分';
    var btnArray = ['取消', '支付'];
    mui.confirm('确定要转给该商家积分吗', str, btnArray, function (e) {
        if (e.index == 1) {
            $.post(c_path + '/transrerIntegral', {
                'seller_id': assignData.sellerInfo.id,
                'exchange_integral': required_integral
            }, function (data) {
                console.log(data);
                if (data.flag == 1) {
                    var str = '';
                    str += '<table style="text-align:left;">';
                    str += '<tr><td>编号：' + data.data.trading_number + '</td></tr>';
                    str += '<tr><td>商家：' + data.data.seller_name + '</td></tr>';
                    str += '<tr><td>买家：' + data.data.user_name + '</td></tr>';
                    str += '<tr><td class="fontred">积分：' + data.data.exchange_integral + '</td></tr>';
                    str += '<tr><td>时间：' + data.data.time + '</td></tr>';
                    str += '</table>';
                    mui.alert(str, data.msg);
                } else {
                    mui.alert(data.msg, {duration: 'long', type: 'div'});
                }
            }, 'json');
        }
    })
}
