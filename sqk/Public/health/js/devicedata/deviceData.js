/**
 * @name Devicedata.js
 * @info 描述：体检数据脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-24 13:32:02
 */

/**
 * 绑定事件 
 * @returns {undefined}
 */
$(function () {

    $('#start_time').datepicker({changeMonth: true, changeYear: true}); //绑定输入框
    $('#end_time').datepicker({changeMonth: true, changeYear: true}); //绑定输入框

    $('#delArrayCat-btn').click(function () {
        var isChecked = '';
        if ($("input[name='rowChecked']:checked").length <= 0) {
            layer.msg('请选择批量删除的数据！', {time: 2000});
            return;
        } else {
            $('input[name="rowChecked"]:checked').each(function () {
                isChecked += $(this).val() + ',';
            });
            var table_num = $('#be_table_num').val();
            $.post(c_path + '/delArrayCat', {'ids': isChecked, 'table_num': table_num}, function (result) {
                location.reload();
                $('input[name="rowChecked"]:checked').each(function () {
                    $(this).removeAttr('checked');
                });
            });
        }
    });
});

/**
 * 删体检信息
 * @param {type} id
 * @param {type} table_num
 * @returns {undefined}
 */
function delCatLayer(id, table_num) {
    layer.confirm('确定要删除此信息嘛？', {
        icon: 2,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/delDeviceInfo', {'id': id, 'table_num': table_num}, function (result) {
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

/**
 * 跳转记录详情
 * @param {type} id
 * @param {type} table_num
 * @returns {undefined}
 */
function showDetail(id, table_num) {
    window.location.href = c_path + "/dataDetail/id/" + id + '/table_num/' + table_num;
}

/**
 * 关键字搜索
 * @param {type} keyWord
 * @returns {undefined}
 */
function submitKey(keyWord) {
    $('#keyword').val(keyWord);
    $("#search-form").submit();
}

/**
 * 代码备份
 */
//treeview数据格式
//var defaultData = [{"id":0,"cat_name":"","children":[{"id":"1","cat_name":"qqqqq","children":[{"id":"2","cat_name":"sssss","children":[]}]},{"id":"3","cat_name":"\u5bf9\u5bf9\u5bf9","children":[]}]}]
//模态框属性
//$("#addCatModal").modal({show:false});
//$("#addCatModal").modal({keyboard:false});