/**
 * @name wuye_form
 * @info 描述：物业表单脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-3 16:34:11
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    var type = getUrl('type');
    getForm(type);
});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取列表
 * @param {Object} type
 */
function getForm(type) {
    $("#tabWuye div").removeClass("tab-btn-sel").removeClass("tab-btn-no");
    if (type == 0) {
        //险情上报
        changeTab(0, 1, 2, '上报');
    } else if (type == 1) {
        //物业报修
        changeTab(1, 0, 2, '报修');
    } else {
        //意见反馈
        changeTab(2, 0, 1, '反馈');
    }
}

/**
 * 切换tab
 * @param {Object} id1
 * @param {Object} id2
 * @param {Object} id3
 * @param {Object} sendChar
 */
function changeTab(id1, id2, id3, sendChar) {
    $("#tabWuye button").css('color','#000');
    $("#wuye" + id1).css('color','#9edee9');
    $("#wuye" + id2).css('color','#000');
    $("#wuye" + id3).css('color','#000');
    $("#sendBtn").html(sendChar);
    $("#proType").html("我要" + sendChar);
    creatForm(id1);
}

/**
 * 生成表单
 * @param {type} type
 * @returns {undefined}
 */
function creatForm(type) {
    var str = '';
    var propStr = '<div class="m-inputheader">故障标题</div>' +
            '<div class="m-inputframe">' +
            '<input type="text" style="margin:0px 0px;" placeholder="请输入故障标题" class="mui-input-clear" name="title">' +
            '</div>' +
            '<div class="m-inputheader">故障描述</div>' +
            '<div class="m-inputframe">' +
            '<textarea placeholder="请输入故障描述" style="margin:0px 0px;" name="content"></textarea>' +
            '</div>' +
            '<div class="m-inputheader">报修类型</div>' +
            '<div class="m-inputframe">' +
            '<div class="m-select">' +
            '<select style="margin:0px 0px; text-indent: 12px;" name="item">' +
            '<option value="1">公共部位维修</option>' +
            '<option value="2">共用设施设备</option>' +
            '<option value="3">自用部位维修</option>' +
            '<option value="4">其他</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="m-inputheader">故障地址</div>' +
            '<div class="m-inputframe">' +
            '<input type="text" style="margin:0px 0px;" placeholder="请输入故障地址" class="mui-input-clear" name="address">' +
            '</div>' +
            '<div class="m-inputheader">联系方式</div>' +
            '<div class="m-inputframe">' +
            '<input type="text" style="margin:0px 0px;" placeholder="请输入联系方式" class="mui-input-clear" name="tel">' +
            '</div>';

    var opinStr = '<div class="m-inputheader">反馈标题</div>' +
            '<div class="m-inputframe">' +
            '<input type="text" style="margin:0px 0px;" placeholder="请输入标题" class="mui-input-clear" name="title">' +
            '</div>' +
            '<div class="m-inputheader">反馈详情</div>' +
            '<div class="m-inputframe">' +
            '<textarea placeholder="请输入描述" style="margin:0px 0px;" name="content"></textarea>' +
            '</div>' +
            '<div class="m-inputheader">联系方式</div>' +
            '<div class="m-inputframe">' +
            '<input type="text" style="margin:0px 0px;" placeholder="请输入联系方式" class="mui-input-clear" name="tel">' +
            '</div>';

    var hiddenStr = '<input type="hidden" name="type" value="' + type + '">';

    if (type == 0) {
        //险情
        $.get(m_path + '/propdang/getDangCatList', function (data) {
            var dangStr1 = '<div class="m-inputheader">险情标题</div>' +
                    '<div class="m-inputframe">' +
                    '<input type="text" style="margin:0px 0px;" placeholder="请输入险情标题" class="mui-input-clear" name="title">' +
                    '</div>' +
                    '<div class="m-inputheader">险情描述</div>' +
                    '<div class="m-inputframe">' +
                    '<textarea placeholder="请输入险情描述" style="margin:0px 0px;" name="content"></textarea>' +
                    '</div>' +
                    '<div class="m-inputheader">险情类型</div>' +
                    '<div class="m-inputframe">' +
                    '<div class="m-select">' +
                    '<select style="margin:0px 0px; text-indent: 12px;" name="cat_id">';

            var dangStr2 = '</select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="m-inputheader">险情级别</div>' +
                    '<div class="m-inputframe">' +
                    '<div class="m-select">' +
                    '<select style="margin:0px 0px; text-indent: 12px;" name="danger_level">' +
                    '<option value="3">三级（可能危险）</option>' +
                    '<option value="2">二级（危险）</option>' +
                    '<option value="1">一级（特别危险）</option>' +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="m-inputheader">险情地址</div>' +
                    '<div class="m-inputframe">' +
                    '<input type="text" style="margin:0px 0px;" placeholder="请输入险情地址" class="mui-input-clear" name="address">' +
                    '</div>' +
                    '<div class="m-inputheader">联系方式</div>' +
                    '<div class="m-inputframe">' +
                    '<input type="text" style="margin:0px 0px;" placeholder="请输入联系方式" class="mui-input-clear" name="tel">' +
                    '</div>';
            var dangStr = '';
            if (data.flag == 1) {
                for (var i = 0; i < data.data.length; i++) {
                    dangStr += '<option value="' + data.data[i]['id'] + '">' + data.data[i]['cat_name'] + '</option>';
                }
            } else {
                dangStr = '<option value="0">暂无分类</option>';
            }
            str = dangStr1 + dangStr + dangStr2 + hiddenStr;
            $("#formStr").html(str);
            $('#fileList').html('');
        }, 'json');

    } else if (type == 1) {
        //物业
        str = propStr + hiddenStr;
        $("#formStr").html(str);
        $('#fileList').html('');
    } else {
        //意见
        str = opinStr + hiddenStr;
        $("#formStr").html(str);
        $('#fileList').html('');
    }

}

/**
 * 表单提交
 */
function subForm() {
    var type = $('input[name="type"]').val();
    var flag = 0;
    var msg = '';
    filter = /^\d+$/;
    if (type == '0') {
        if ($('input[name="title"]').val() == '' || $('input[name="title"]').val() == null) {
            flag = 0;
            msg = '请填写标题';
        } else if ($('textarea[name="content"]').val() == '' || $('textarea[name="content"]').val() == null) {
            flag = 0;
            msg = '请填写描述';
        } else if ($('input[name="address"]').val() == '' || $('input[name="address"]').val() == null) {
            flag = 0;
            msg = '请填写地址';
        } else if ($('input[name="tel"]').val() == '' || $('input[name="tel"]').val() == null) {
            flag = 0;
            msg = '请填写联系方式';
        } else {
            if (filter.test($('input[name="tel"]').val())) {
                flag = 1;
            } else {
                flag = 0;
                msg = '联系方式不正确';
            }
        }
    } else if (type == "1") {
        if ($('input[name="title"]').val() == '' || $('input[name="title"]').val() == null) {
            flag = 0;
            msg = '请填写标题';
        } else if ($('textarea[name="content"]').val() == '' || $('textarea[name="content"]').val() == null) {
            flag = 0;
            msg = '请填写描述';
        } else if ($('input[name="address"]').val() == '' || $('input[name="address"]').val() == null) {
            flag = 0;
            msg = '请填写地址';
        } else if ($('input[name="tel"]').val() == '' || $('input[name="tel"]').val() == null) {
            flag = 0;
            msg = '请填写联系方式';
        } else {
            if (filter.test($('input[name="tel"]').val())) {
                flag = 1;
            } else {
                flag = 0;
                msg = '联系方式不正确';
            }
        }
    } else {
        if ($('input[name="title"]').val() == '' || $('input[name="title"]').val() == null) {
            flag = 0;
            msg = '请填写标题';
        } else if ($('textarea[name="content"]').val() == '' || $('textarea[name="content"]').val() == null) {
            flag = 0;
            msg = '请填写反馈详情';
        } else if ($('input[name="tel"]').val() == '' || $('input[name="tel"]').val() == null) {
            flag = 0;
            msg = '请填写联系方式';
        } else {
            if (filter.test($('input[name="tel"]').val())) {
                flag = 1;
            } else {
                flag = 0;
                msg = '联系方式不正确';
            }
        }
    }
    if (flag == 1) {
        $.post(c_path + '/createPropDang', {"form_data": $('#form').serialize()}, function (data) {
            if (data.flag == 1) {
                mui.alert('提交成功！');
                window.location.href = c_path + "/wuye_list.html?type=" + data.type;
            } else {
                mui.alert('提交问题失败！');
            }
        }, 'json');
    } else {
        mui.toast(msg, {duration: 'long', type: 'div'});
    }

}