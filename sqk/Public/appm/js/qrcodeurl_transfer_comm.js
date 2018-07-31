/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {

});


//函数--------------------------------------------------------------------------

function transrerIntegral () {
    var required_integral = $('#integral_num').val();
    if(required_integral==''){
        return;
    }
    var str = required_integral + '积分';
    var btnArray = ['取消', '支付'];
    mui.confirm('确定要转给该社区积分吗', str, btnArray, function (e) {
        if (e.index == 1) {
            $.post(c_path + '/transrerIntegralComm', {
                'comm_id': assignData.commInfo.id,
                'exchange_integral': required_integral
            }, function (data) {
                console.log(data);
                if (data.flag == 1) {
                    var str = '';
                    str += '<table style="text-align:left;">';
                    str += '<tr><td>编号：' + data.data.trading_number + '</td></tr>';
                    str += '<tr><td>收款方：' + data.data.comm_name + '社区</td></tr>';
                    str += '<tr><td>付款方：' + data.data.user_name + '</td></tr>';
                    str += '<tr><td class="fontred">积分：' + data.data.exchange_integral + '</td></tr>';
                    str += '<tr><td>时间：' + data.data.time + '</td></tr>';
                    str += '</table>';
                    mui.alert(str, data.msg);
                    history.go(0);
                } else {
                    mui.alert(data.msg);
                }
            }, 'json');
        }
    })
}
