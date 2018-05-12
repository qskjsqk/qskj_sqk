/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    checkIsLogin();
    var id = getUrl('id');
    
    getGoodsDetail(id);

});


//函数--------------------------------------------------------------------------
function getGoodsDetail(id){
    $.post(c_path + "/getGoodsInfoSync",{'id':id},function(data){
        console.log(data);
    },'json');
}
/**
 * 打开筛选
 */
function openExchange() {
    openModal();
}

function subForm() {
    var status = $('input[name="status"]').val();
    alert(status);
    console.log(status);
//    getActivList(1, '', address_id, cat_id, integral);//加载列表
    closeModal();
}
