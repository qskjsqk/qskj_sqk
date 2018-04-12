/**
 * @name Deviceinfo.js
 * @info 描述：体检设备脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-24 13:32:02
 */
var treeData=[];
$(function() {
    //添加分类按钮绑定click事件
    $('#addCatLayer-btn').click(function(){
        clearForm(form_data);
        layer.open({
            type: 1,
            title: ['分类信息','font-size:16px;font-weight: bold;color: #2e8ded;'], //标题信息及样式
            skin: 'layui-layer-rim', //加上边框
            shadeClose:true,//是否点击遮罩关闭
            resize:false,//是否允许拉伸
            area: ['650px', '350px'], //宽高
            content: $('.catLayer'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
            btn: ['确定', '取消'],
            yes: function (index) {
                saveDeviceInfoCat(index);
            },
            cancel: function (index) {
            }
        });
    });
    $('#delArrayCat-btn').click(function(){
        var isChecked='';
        if($("input[name='rowChecked']:checked").length <= 0){
            layer.msg('请选择批量删除的数据！',{time: 2000});return;
        }else{
            $('input[name="rowChecked"]:checked').each(function(){
                isChecked+=$(this).val()+',';
            });
            $.post(c_path + '/delArrayCat', {'ids':isChecked},function(result){
                location.reload();
            });
        }
    });
});
/**
 * 编辑分类
 * @param {type} id
 * @returns {undefined}
 */
function editCatLayer(id){
    layer.open({
        type: 1,
        title: ['分类信息','font-size:16px;font-weight: bold;color: #2e8ded;'], //标题信息及样式
        skin: 'layui-layer-rim', //加上边框
        shadeClose:true,//是否点击遮罩关闭
        resize:false,//是否允许拉伸
        area: ['650px', '350px'], //宽高
        content: $('.catLayer'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        btn: ['确定', '取消'],
        yes: function (index) {
            saveDeviceInfoCat(index);
        },
        cancel: function (index) {
        },
        success: function(layero){
            $.post(c_path + '/findInfoById',{'id':id},function(result){
                if(result.code=='500'){
                    $.each(result.data,function(key,value){
                        if(key=='is_enable'){
                            $('input[name="'+key+'"][value="'+value+'"]').prop("checked",true);return;
                        }
                        $('#'+key).val(value);
                    });
                }
            },'json');
        }
    });
}
/**
 * 保存信息
 * @param {type} index
 * @returns {undefined}
 */
function saveDeviceInfoCat(index) {
    $.post(c_path + '/saveDeviceInfoCat', {"form_data": $('#form_data').serialize()}, function (result) {
        if (result.code == '500') {
            layer.close(index);
            layer.msg(constants.SUCCESS,{time: 1000},function(){
                location.reload();
            });
        } else if(result.code == '502') {
            layer.msg(constants.FAILD);
        }else{
            layer.msg(result.msgError);
        }
    },'json');
}

/**
 * 删除分类信息
 * @param {type} id
 * @returns {undefined}
 */
function delCatLayer(id){
    layer.confirm('确定要删除此信息嘛？', {
        icon:2,
        title:'提示信息',
        btn: ['确定','取消'] //按钮
    }, function(index){
        $.post(c_path + '/delDeviceInfo',{'id':id},function(result){
            if(result.code == '500'){
                layer.msg(constants.SUCCESS,{time: 1000},function(){
                    location.reload();
                });
            }else{
                layer.msg(constants.FAILD);
            }
        },'json');
    });
}

/**
 * 代码备份
 */
//treeview数据格式
//var defaultData = [{"id":0,"cat_name":"","children":[{"id":"1","cat_name":"qqqqq","children":[{"id":"2","cat_name":"sssss","children":[]}]},{"id":"3","cat_name":"\u5bf9\u5bf9\u5bf9","children":[]}]}]
//模态框属性
//$("#addCatModal").modal({show:false});
//$("#addCatModal").modal({keyboard:false});