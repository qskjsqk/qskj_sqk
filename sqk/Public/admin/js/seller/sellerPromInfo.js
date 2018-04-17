/**
 * 商家信息JS
 * Created by GX on 2017-02-20.
 */
$(function () {
    initSelectItems();
    //选择促销项目按钮绑定事件
    $('#selectItemsInfo-btn').click(function () {
        layer.open({
            type: 1,
            title: ['服务项目列表', 'font-size:16px;font-weight: bold;color: #2e8ded;'], //标题信息及样式
            skin: 'layui-layer-rim', //加上边框
            shadeClose: true, //是否点击遮罩关闭
            resize: false, //是否允许拉伸
            zIndex: 111111111,
            area: ['650px', '350px'], //宽高
            content: $('.itemsListLayer'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
            btn: ['确定', '取消'],
            yes: function (index) {
                saveSellerItems(index);
            },
            cancel: function (index) {
            },
            success: function (layero) {
                $("#item_table").find("td").remove();
                var strHtml = '';
                $.post(c_path + '/showItemsList', {'seller_id': $('input[name="seller_id"]').val()}, function (result) {
                    var itemsArray = $('#item_ids').val().trim(',').split(',');
                    $.each(result, function (index, value) {
                        strHtml += '<tr class="tr">' +
                                '<td>' + parseInt(index + 1) + '</td>' +
                                '<td><input type="checkbox" name="rowChecked" value="' + value['id'] + '"/></td>' +
                                '<td><img src="' + public + '/Upload' + value['logo_img'] + '" style="width: 40px; height: 40px;"/></td>' +
                                '<td name="name">' + value['name'] + '</td>' +
                                '<td>' + value['cat_name'] + '</td>' +
                                '<td>' + value['price'] + '/' + value['quantifier'] + '</td>' +
                                '</tr>';
                    });
                    $('.tableTitle').after(strHtml);//
                    $.each(itemsArray, function (index, value) {
                        $('#item_table input[value="' + value + '"]').prop('checked', true);
                    });
                }, 'json');
            }
        });
        return;
    });
    //新增按钮绑定事件
    $('#saveInfo-btn').click(function () {
        $.post(c_path + '/saveSellerPromInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000, zIndex: 111111111}, function () {
                    if($('input[name="from"]').val() != '') {
                        window.location.href = c_path + '/showList/seller_id/' + $('input[name="seller_id"]').val() + '/from/' + $('input[name="from"]').val();
                    } else {
                        window.location.href = c_path + '/showList';
                    }
                });
            } else if (result.code == '502') {
                layer.msg(constants.FAILD, {time: 1000, zIndex: 111111111});
            } else {
                layer.msg(result.msgError, {time: 2000, zIndex: 111111111});
            }
        }, 'json');
    });
    //批量删除按钮绑定事件
    $('#delArrayInfo-btn').click(function () {
        var isChecked = '';
        if ($("input[name='rowChecked']:checked").length <= 0) {
            layer.msg('请选择批量删除的数据！', {time: 2000});
            return;
        } else {
            $('input[name="rowChecked"]:checked').each(function () {
                isChecked += $(this).val() + ',';
            });
            delInfoLayer(isChecked);
        }
    });
});
//初始化被选择的促销服务项目信息
function initSelectItems() {
    var strHtml = '';
    $("#select_item_table").find("td").remove();
    if ($.trim($('input[name="item_ids"]').val()) != '' && $.trim($('input[name="item_ids"]').val()) != ',') {
        $('.select-items').css('display', '');
        $.post(c_path + '/showSelectItems', {'selected_id': $.trim($('input[name="item_ids"]').val())}, function (result) {
            $.each(result, function (index, value) {
                strHtml += '<tr class="tr">' +
                        '<td>' + parseInt(index + 1) + '</td>' +
                        '<td><img src="' + public + '/Upload' + value['logo_img'] + '" style="width: 40px; height: 40px;"/></td>' +
                        '<td name="name">' + value['name'] + '</td>' +
                        '<td>' + value['cat_name'] + '</td>' +
                        '<td>' + value['price'] + '/' + value['quantifier'] + '</td>' +
                        '<td><div><button type="button" class="btn btn-default del-btn" onclick="delSelectItems($(this),' + value['id'] + ')"><span class="glyphicon glyphicon-trash"></span> 删除</button></div></td>' +
                        '</tr>';
            });
            $('.itemsTableTitle').after(strHtml);
        }, 'json');
    }
}
//选择促销项目 //需改进
function saveSellerItems(index) {
    var isChecked = ',';
    $('input[name="rowChecked"]:checked').each(function () {
        isChecked += $(this).val() + ',';
    });
    layer.close(index);
    $('input[name="item_ids"]').val(isChecked);
    initSelectItems();
}
//删除已选择的项目列表
function delSelectItems(obj, value) {
    obj.parent().parent().parent().remove();
    if ($('#item_ids').val().indexOf(',' + value + ',') > -1) {//包含
        $('#item_ids').val($('#item_ids').val().replace(','+value + ',', ","));
    }
    if ($.trim($('input[name="item_ids"]').val()) == '' || $.trim($('input[name="item_ids"]').val()) == ',') {
        $('.select-items').css('display', 'none');
    }
}

//批量删除商家促销信息
function delInfoLayer(isChecked) {
    layer.confirm('确定要批量删除此信息嘛？', {
        icon: 2,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/delArrPromInfo', {'ids': isChecked}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    location.reload();
                });
            } else {
                layer.msg(constants.FAILD);
            }
        }, 'json');
    });
}