/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {

});


//函数--------------------------------------------------------------------------

function signIn() {

    var btnArray = ['取消', '签到'];
    mui.confirm('本次签到可获得【' + assignData.signInfo.sign_integral + '】积分', '确认签到', btnArray, function (e) {
        if (e.index == 1) {
            $.post(c_path + '/signIn', {
                'user_id': assignData.myInfo.id,
                'sign_id': assignData.signInfo.id,
                'activity_id': assignData.activInfo.id,
                'sign_integral': assignData.signInfo.sign_integral,
            }, function (data) {
                console.log(data);
                if (data.flag == 1) {
                    var str = '';
                    str += '<table style="text-align:left;">';
                    str += '<tr><td>用户：' + data.data.realname + '</td></tr>';
                    str += '<tr><td>手机：' + data.data.tel + '</td></tr>';
                    str += '<tr><td>方式：' + data.data.sign_type + '</td></tr>';
                    str += '<tr><td class="fontred">获得积分：' + data.data.sign_integral + '</td></tr>';
                    str += '<tr><td>时间：' + data.data.sign_time + '</td></tr>';
                    str += '</table>';
                    mui.alert(str, data.msg);
                    history.go(0);
                } else {
                    mui.alert('<font color="red">' + data.msg + '</font>', '提示');
                }
            }, 'json');
        }
    })
}
