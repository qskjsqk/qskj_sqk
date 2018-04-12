/**
 * @name health_list
 * @info 描述：体检列表
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-17 13:32:16
 */


//全局变量---------------------------------------------------------------------------------------


//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    $('#keyword').val('');
    var table_num = getUrl('table_num');
    if (table_num > 0) {
        getHealthListOfCat(table_num);
        getHealthList(1, '', table_num);
    } else {
        getHealthListOfCat(6);
        getHealthList(1, '', 6);
    }

});
//函数--------------------------------------------------------------------------------------------
/**
 * 获取健康分类表
 * @param {type} table_num
 * @returns {undefined}
 */
function getHealthListOfCat(table_num) {
    $('#keyword').val('');
    mui('#popover').popover('hide');
    if (table_num == 6) {
        $('#openPopover').html('血糖<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;margin-right: -5px;"></span>');
    } else if (table_num == 5) {
        $('#openPopover').html('血氧<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;margin-right: -5px;"></span>');
    } else if (table_num == 7) {
        $('#openPopover').html('血压<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;margin-right: -5px;"></span>');
    } else if (table_num == 9) {
        $('#openPopover').html('身高体重<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;margin-right: -5px;"></span>');
    } else if (table_num == 3) {
        $('#openPopover').html('体温<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;margin-right: -5px;"></span>');
    } else {
        $('#openPopover').html('血糖<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;margin-right: -5px;"></span>');
    }
    
//    else if (table_num == 0) {
//        $('#openPopover').html('身高<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;margin-right: -5px;"></span>');
//    }
    
    getHealthList(1, '', table_num);
}

/**
 * 获取体检信息
 * @param {type} page
 * @param {type} keyword
 * @param {type} table_num
 * @returns {undefined}
 */
function getHealthList(page, keyword, table_num) {
    $.post(c_path + "/getHealthList", {'page': page, 'keyword': keyword, 'table_num': table_num}, function (data) {
        var str = '';
        if (data.flag == 1) {
            for (var i = 0; i < data.data.length; i++) {
                str += '<li class="mui-table-view-cell" style="padding-right: 10px;" onclick="getHealthDetail(' + data.data[i]['id'] + ',' + data['table_num'] + ')">' +
                        '<a class="mui-navigate-right">' +
                        '<img src="' + public + '/app/img/xd.png" />&#12288;' + data.data[i]['time'] + '&#12288;' + data['table_name'] + '&#12288;检测记录' +
                        '</a>' +
                        '</li>';
            }
        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无数据</li>';
        }

        $("#healthList").html(str);
        //动态加载--------------------------------------------------------------		
        $("#page").val(data.page);
        if (data.is_end == 1) {
            $("#loadMore").removeAttr('onclick');
        } else {
            $("#loadMore").attr('onclick', 'loadMore("' + table_num + '")');
        }
        mui("#loadMore").button('reset');
        $("#loadMore").html(data.ajaxLoad);
        $('#searchBtn').attr('onclick', 'keyWordSelect("' + table_num + '")');
        //---------------------------------------------------------------------

    }, 'json');
}

/**
 * 跳转体检记录详情
 * @param {type} id
 * @returns {undefined}
 */
function getHealthDetail(id, table_num) {
//打开详情
    window.location.href = c_path + "/health_detail.html?id=" + id + '&table_num=' + table_num;
}

/**
 * 动态加载数据
 */
function loadMore(table_num) {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getHealthList(page, $('#keyword').val(), table_num);
}

/**
 * 关键字查询
 * @returns {undefined}
 */
function keyWordSelect(table_num) {
    getHealthList(1, $('#keyword').val(), table_num);
}


/**
 * 打开模态框
 */
function openModal() {
    $(".m-modal-if").fadeIn(200);

    $(".m-modal-if").bind('click', function () {
        closeModal();
    });
}
/**
 * 关闭模态框
 */
function closeModal() {
    $(".m-modal-if").fadeOut(200);
}