/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    checkIsLogin();
    $('#keyword').val('');
    getGoodsList(1, '', assignData.address_id, '', '');

    /*document.onkeydown = function (event_e) {
        if (window.event) {
            event_e = window.event;
        }
        console.log(event_e);
        var int_keycode = event_e.key || event_e.code;
        if (int_keycode == 'Enter') {
            getGoodsList(1, $('#keyword').val(), assignData.address_id, 0, 0);
            return false;
        }
    }*/


});


//函数--------------------------------------------------------------------------------------------
/**
 * 获取积分商品列表
 * @param {Object} page
 */
function getGoodsList(page, keyword, orderBy, address, cat_type) {
    $.post(c_path + "/getList", {'page': page, 'keyword': keyword, 'address': address, 'orderBy': orderBy, 'cat_type': cat_type}, function (res) {

        if(res.ret == 0) {
            console.log(res.data);
        } else {
            console.log('error');
        }

        //参数回显--------------------------------------------------------------
        /*$('#keyword').val(data.where.keyword);
        if (data.where.address != 0) {
            $('#local_address').attr('checked', 'checked');
        } else {
            $('#0_address').attr('checked', 'checked');
        }
        if (data.where.cat_id != 0) {
            $("#cat_id").find("option[value='" + data.where.cat_id + "']").attr("selected", 'selected');
        }
        if (data.where.integral != 0) {
            $("#integral").find("option[value='" + data.where.integral + "']").attr("selected", 'selected');
        }*/


        //动态加载--------------------------------------------------------------
        /*$("#page").val(data.page);
        if (data.is_end == 1) {
            $("#loadMore").removeAttr('onclick');
        } else {
            $("#loadMore").attr('onclick', 'loadMore()');
        }
        mui("#loadMore").button('reset');
        $("#loadMore").html(data.ajaxLoad);*/
        //---------------------------------------------------------------------

    }, 'json');
}

/**
 * 动态加载数据
 */
function loadMore() {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getGoodsList(page, $('#keyword').val());
}

/**
 * 打开筛选
 */
function openSelect() {
    $('#realname').val('').removeAttr('readonly');
    $('#department').val('').removeAttr('readonly');
    $('#tel').val('').removeAttr('readonly');
    $('#phone').val('').removeAttr('readonly');
    $('#comment').val('').removeAttr('readonly');
    $('#detailBtn').css('display', 'block');
    openModal();
    $('#id').val(0);
    $('#aType').val('add');
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
    var orderBy = $('input[name="orderBy"]').val();
    var address = $('input[name="address"]').val();
    var cat_type = $('input[name="cat_type"]').val();

    getGoodsList(1, '', orderBy, address, cat_type);
    closeModal();
}
