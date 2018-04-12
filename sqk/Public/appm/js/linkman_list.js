/**
 * @name linkman_list
 * @info 描述：紧急联系人脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-10 15:29:09
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    getNeighbList();
    getHelpList();
});

//函数--------------------------------------------------------------------------------------------
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

/**
 * 获取社区联系电话
 */
function getNeighbList() {
    $.post(c_path + "/getNeighbLinkList", function (data) {
        if (data.flag == 1) {
            var str = '';
            for (var i = 0; i < data.data.length; i++) {
                str += '<div class="pinglun-list m-margin-l5 m-padding-lr10 m-margin-t10 m-padding-b10" style="border-bottom: 1px solid #e2e2e2;">' +
                        '<div class="pinglun-title">' +
                        '<div class="pinglun-title-img">' +
                        '<img src="' + public + '/app/img/linkman.png">' +
                        '</div>' +
                        '<div class="pinglun-title-title m-margin-l15">' + data.data[i]['realname'] +
                        '<p id="tel-' + data.data[i]['id'] + '">' + data.data[i]['tel'] + '</p>' +
                        '</div>' +
                        '<button type="button" class="mui-btn mui-btn-outlined" style="float: right; border: 0px;" onclick="callPhoneId(' + data.data[i]['id'] + ')"><span class="mui-icon mui-icon-phone" style="font-size: 26px;"></span></button>' +
                        '<button type="button" class="mui-btn mui-btn-outlined" style="float: right; border: 0px;" onclick="getLinkDetail(' + data.data[i]['id'] + ')"><span class="mui-icon mui-icon-search" style="font-size: 26px;"></span></button>' +
                        '</div>' +
                        '</div>';
            }
        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无信息</li>';
        }
        $("#neighbList").html(str);
    }, 'json');
}

/**
 * 获取紧急联系人列表
 */
function getHelpList() {
    $.post(c_path + "/getHelpLinkList", function (data) {
        if (data.flag == 1) {
            var str = '';
            for (var i = 0; i < data.data.length; i++) {
                str += '<div class="pinglun-list m-margin-l5 m-padding-lr10 m-margin-t10 m-padding-b10" style="border-bottom: 1px solid #e2e2e2;">' +
                        '<div class="pinglun-title">' +
                        '<div class="pinglun-title-img">' +
                        '<img src="' + public + '/app/img/linkman.png">' +
                        '</div>' +
                        '<div class="pinglun-title-title m-margin-l15">' + data.data[i]['realname'] +
                        '<p id="tel-' + data.data[i]['id'] + '">' + data.data[i]['tel'] + '</p>' +
                        '</div>' +
                        '<button type="button" class="mui-btn mui-btn-outlined" style="float: right; border: 0px;" onclick="callPhoneId(' + data.data[i]['id'] + ')"><span class="mui-icon mui-icon-phone" style="font-size: 26px;"></span></button>' +
                        '<button type="button" class="mui-btn mui-btn-outlined" style="float: right; border: 0px;" onclick="getLinkDetail(' + data.data[i]['id'] + ')"><span class="mui-icon mui-icon-compose" style="font-size: 26px;"></span></button>' +
                        '<button type="button" class="mui-btn mui-btn-outlined" style="float: right; border: 0px;" onclick="delLinkMan(' + data.data[i]['id'] + ')"><span class="mui-icon mui-icon-trash" style="font-size: 26px;"></span></button>' +
                        '</div>' +
                        '</div>';
            }
        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无信息</li>';
        }
        $("#helpList").html(str);
    }, 'json');
}

/**
 * 获取联系人详情
 */
function getLinkDetail(id) {
    $.get(c_path + "/getLinkDetail/id/" + id, function (data) {
        if (data.flag == 1) {
            openModal();
            $('#id').val(id);
            $('#aType').val('edit');
            if (data.data.type == 1) {
                $('#realname').val(data.data.realname).attr('readonly', 'readonly');
                $('#department').val(data.data.department).attr('readonly', 'readonly');
                $('#tel').val(data.data.tel).attr('readonly', 'readonly');
                $('#phone').val(data.data.phone).attr('readonly', 'readonly');
                $('#comment').val(data.data.comment).attr('readonly', 'readonly');
                $('#detailBtn').css('display', 'none');
            } else {
                $('#realname').val(data.data.realname).removeAttr('readonly');
                $('#department').val(data.data.department).removeAttr('readonly');
                $('#tel').val(data.data.tel).removeAttr('readonly');
                $('#phone').val(data.data.phone).removeAttr('readonly');
                $('#comment').val(data.data.comment).removeAttr('readonly');
                $('#detailBtn').css('display', 'block');
            }

        } else {
            mui.toast('系统错误，请稍候重试');
        }
    }, 'json');
}

/**
 * 删除联系人
 * @param {Object} id
 */
function delLinkMan(id) {
    var btnArray = ['取消', '确定'];
    mui.confirm('确定要删除该联系人吗？', '提示', btnArray, function (e) {
        if (e.index == 1) {
            $.get(c_path + "/delLinkMan/id/" + id, function (data) {
                if (data.flag == 1) {
                    getHelpList();
                    mui.toast(data.msg);
                } else {
                    mui.toast(data.msg);
                }
            }, 'json');
        } else {
            mui.toast('取消删除');
        }
    })
}

/**
 * 添加联系人
 */
function addLinkMan() {
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
 * 提交表单
 */
function subForm() {
    telCheck = /^1[3|5|7|8|][0-9]{9}$/;
    phoneCheck = /^(?:(?:0\d{2,3})-)?(?:\d{7,8})(-(?:\d{3,}))?$/;
    //表单验证
    if ($('input[name="realname"]').val() == '' || $('input[name="realname"]').val() == null) {
        flag = 0;
        msg = '请填写联系人姓名';
    } else if ($('input[name="tel"]').val() == '' && $('input[name="phone"]').val() == '') {
        flag = 0;
        msg = '手机座机请务必填写一项';
    } else {
        if ($('input[name="tel"]').val() != '') {
            if (telCheck.test($('input[name="tel"]').val())) {
                flag = 1;
            } else {
                flag = 0;
                msg = '手机号码不正确';
                $('#tel').val('');
            }
        } else {
            if (phoneCheck.test($('input[name="phone"]').val())) {
                flag = 1;
            } else {
                flag = 0;
                msg = '座机号码不正确';
                $('#phone').val('');
            }
        }
    }


    if (flag == 1) {
        $.post(c_path + "/SaveOrCreateLinkMan", {"form_data": $('#form').serialize()}, function (data) {
            if (data.flag == 1) {
                getHelpList();
                closeModal();
                mui.toast(data.msg);
            } else {
                closeModal();
                mui.toast(data.msg);
            }
        }, 'json');
    } else {
        mui.toast(msg, {duration: 'long', type: 'div'});
    }

}
/**
 * 拨打电话
 * @param {type} id
 * @returns {undefined}
 */
function callPhoneId(id) {
    var tel = $('#tel-' + id).html();
    callPhone(tel);
}
