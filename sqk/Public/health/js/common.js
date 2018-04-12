/**
 * @name common
 * @info 描述：公用脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-27 8:54:15
 */
var constants = {//定义了两个常量
    SUCCESS: '操作成功！',
    FAILD: '操作失败,请重新操作！'
}
/**
 * 对象增加方法
 * @param {type} char
 * @param {type} type
 * @returns {String.prototype@call;replace}
 */
String.prototype.trim = function (char, type) {
    if (char) {
        if (type == 'left') {
            return this.replace(new RegExp('^\\'+char+'+', 'g'), '');
        } else if (type == 'right') {
            return this.replace(new RegExp('\\'+char+'+$', 'g'), '');
        }
        return this.replace(new RegExp('^\\'+char+'+|\\'+char+'+$', 'g'), '');
    }
    return this.replace(/^\s+|\s+$/g, '');
};
/**
 * 清空表单数据
 */
function clearForm(form) {
    // 迭代input清空
    $(':input', form).each(function () {
        var type = this.type;
        var tag = this.tagName.toLowerCase(); // normalize case
        if (type == 'text' || type == 'password' || tag == 'textarea' || type=='hidden')
            this.value = "";
        // 跌代多选checkboxes
        else if (type == 'checkbox')
            this.checked = false;
        // select 迭代下拉框
        else if (tag == 'select')
            this.selectedIndex = -1;
        //单选按钮
        else if(tag=='radio'){
            //操作
        }
    });
}
/**
 * 
 * @returns {undefined}显示TreeViewPanel
 */
function showTreeView(){
    //加载下拉树列表
    $.post(c_path + '/getTreeViewData', function (result) {
        treeData = result;//返回TreeView数据
        $('#treeview').show();
        var options = {
            bootstrap2 : false,
            showTags : true,
            levels : 5,
            //showCheckbox : true,
            //checkedIcon : "glyphicon glyphicon-check",
            data : buildDomTree(),
            onNodeSelected : function(event, data) {
                $("#category_name").val(data.text);
                $("#parent_id").val(data.id);
                if(data.id==0){
                    $("input[name='parent_id_path']").val('');
                }else{
                    $("input[name='parent_id_path']").val(data.parent_id_path+data.id+'.');
                }
                $("#treeview").hide();
            }
        };
        $('#treeview').treeview(options);
        $('#treeview').treeview('collapseAll', { silent: true });
    }, 'json');
}
/**
 * 递归下拉树
 * @returns {Array}
 */
function buildDomTree() {
    var data = [];
    var root = "所有分类";
    function walk(nodes, data) {
        if (!nodes) {
            return;
        }
        $.each(nodes, function(id, node) {
            var obj = {
                id : node.id,
                text : node.cat_name != '' ? node.cat_name : root,
                parent_id_path:node.parent_id_path
            };
            if (node.isLeaf = true) {
                obj.nodes = [];
                walk(node.children, obj.nodes);
            }
            data.push(obj);
        });
    }
    walk(treeData, data);
    return data;
}
//列表全选
function setAllChecked(obj){
    if(obj.checked==true) {//选中
        $($('input[name="rowChecked"]')).each(function(){
            $(this).prop('checked', true);
        });
    }else{//取消选中
        $($('input[name="rowChecked"]')).each(function(){
            $(this).prop('checked', false);
        });
    }
}

/**
 * 判断查询框 起始时间不能晚于结束时间
 * @param {type} id1
 * @param {type} id2
 * @param {type} id3
 * @returns {undefined}
 */
function checkse(id1, id2, id3) {
    var sta = $('#' + id1).val();
    var end = $('#' + id2).val();
    if (sta != '' && end != '') {
        if (sta > end) {
            layer.msg('起始时间不能晚于结束时间！');
            $('#' + id3).val('');
        }
    }
}

/**
 * 重置img部分代码
 */
function img_reset(htmlstr) {
    var arr = htmlstr.match(/<(div|p)(\W|\w)*?<img(\W|\w)*?<\/(div|p)>/gi);

    for (var key in arr) {
        var img_arr = arr[key].match(/<img(.|\s)*?>/gi);
        var img_html = '<p style="text-align:center;padding:0px;text-indent:0;">' + img_arr[0] + '</p>';
        htmlstr = htmlstr.replace(img_arr[0], img_html);
    }
    return htmlstr;
}
