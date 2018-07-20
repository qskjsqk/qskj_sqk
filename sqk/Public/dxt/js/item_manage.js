/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    
    //mousedown() 监听鼠标是否使用 keydown() 监听键盘是否可用
    $(document).mousedown(function () {
        parent.timeZero();
    }).keydown(function () {
        parent.timeZero();
    }).mousemove(function () {
        parent.timeZero();
    });
    
    checkIsLogin();
});


/**
 * 打开筛选
 */
function openSelect() {
    openModal();
}
/**
 * 打开模态框
 */
function openModal() {
    $(".m-modal-content").fadeIn(200);
    $(".m-modal").fadeIn(200);
    $(".m-modal").bind('click', function () {
        closeModal();
    });
}
/**
 * 关闭模态框
 */
function closeModal() {
    $(".m-modal-content").fadeOut(200);
    $(".m-modal").fadeOut(200);
}

function subForm() {
    var status = $('input[name="status"]').val();
    alert(status);
    console.log(status);
//    getActivList(1, '', address_id, cat_id, integral);//加载列表
    closeModal();
}