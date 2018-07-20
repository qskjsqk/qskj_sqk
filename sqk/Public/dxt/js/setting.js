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