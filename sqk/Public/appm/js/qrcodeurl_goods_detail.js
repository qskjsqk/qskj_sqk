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
 * 打开筛选
 */
function openExchange() {
    checkIsUser();
    openModal();
}

function subForm() {
    
    closeModal();
}
