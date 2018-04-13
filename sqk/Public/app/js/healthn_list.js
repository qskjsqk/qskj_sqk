/**
 * @name healthn_list
 * @info 描述：科学知识列表
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-16 14:24:57
 */


//全局变量---------------------------------------------------------------------------------------


//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    $('#keyword').val('');
    var cat_id = getUrl('cat_id');
    getCatList();
    if (cat_id > 0) {
        getHealthnList(1, '', cat_id);
        getHealthnListOfCat(cat_id);
    } else {
        getHealthnList(1, '', 0);
        getHealthnListOfCat(0);
    }
});
//函数--------------------------------------------------------------------------------------------

/**
 * 获取分类列表
 * @returns {undefined}
 */
function getCatList() {
    var str = '<li class="mui-table-view-cell">' +
            '<a href="javascript:void(0)" onclick="getHealthnListOfCat(0)" style="text-align:center;">' +
            ' <span style="font-size: 14px;">全部类别</span>' +
            ' </a>' +
            '</li>';

    $.post(c_path + "/getCatList", function (data) {
        if (data.flag == 1) {
            for (var i = 0; i < data.data.length; i++) {
                str += '<li class="mui-table-view-cell">' +
                        '<a href="javascript:void(0)"  onclick="getHealthnListOfCat(' + data.data[i]['id'] + ')" style="text-align:center;">' +
                        ' <span style="font-size: 14px;">' + data.data[i]['cat_name'] + '</span>' +
                        ' </a>' +
                        '</li>';
            }
        }
        $('#healthnCat').html(str);
    }, 'json');
}

/**
 * 获取信息列表
 * @param {type} cat_id
 * @returns {undefined}
 */
function getHealthnListOfCat(cat_id) {
    $('#keyword').val('');
    mui('#popover').popover('hide');
    if (cat_id == 0) {
        $('#openPopover').html('全部类别<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;"></span>');
    } else {
        $.get(c_path + "/getCatName", {'cat_id': cat_id}, function (data) {
            $('#openPopover').html(data.cat_name + '<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;"></span>');
        }, 'json');
    }
    getHealthnList(1, '', cat_id);
}

/**
 * 获取健康知识列表
 * @param {type} page
 * @param {type} keyword
 * @returns {undefined}
 */
function getHealthnList(page, keyword, cat_id) {

    $.post(c_path + "/getHealthnList", {'page': page, 'keyword': keyword, 'cat_id': cat_id}, function (data) {
        var str = '';
        if (data.flag == 1) {
            for (var i = 0; i < data.data.length; i++) {
                str += '<li class="mui-table-view-cell" style="padding-right: 10px;" onclick="getHealthnDetail(' + data.data[i]['id'] + ',' + cat_id + ')">' +
                        '<div class="mui-media-body">' +
                        '<img src="' + public + '/app/img/xd.png" /><span class="font16">&#12288;【' + data.data[i]['cat_name'] + '】&#12288;' + data.data[i]['title'] + '</sapn>' +
                        '<span class="mui-ellipsis" style="float: right;color: #999;font-size:14px;">' + data.data[i]['add_time'] + '</span>' +
                        '<div class="listcontent" style="background-color:#fff;">' +
                        '<div class="listimg">'+getFirstImg(data.data[i]['content'])+'</div>' +
                        '<div class="listinfo" style="width:80%;">' +
                        '<p style="margin-left:10px;color:#444;">' + data.data[i]['content'].replace(/<[^>]+>/gi, '').substr(0, 160) + '...' + '【详情】</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="listfooter"><span>浏览' + data.data[i]['read_num'] + '次</span></div>' +
                        '</li>';
            }
        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';
        }


        $("#healthnList").html(str);

        //动态加载--------------------------------------------------------------		
        $("#page").val(data.page);
        if (data.is_end == 1) {
            $("#loadMore").removeAttr('onclick');
        } else {
            $("#loadMore").attr('onclick', 'loadMore(' + data.cat_id + ')');
        }
        mui("#loadMore").button('reset');
        $("#loadMore").html(data.ajaxLoad);
        $('#searchBtn').attr('onclick', 'keyWordSelect(' + data.cat_id + ')');
        //---------------------------------------------------------------------

    }, 'json');

}

/**
 * 跳转科学知识详情
 * @param {type} id
 * @returns {undefined}
 */
function getHealthnDetail(id, cat_id) {
    //打开详情
    window.location.href = c_path + "/healthn_detail.html?id=" + id + '&cat_id=' + cat_id;
}

/**
 * 动态加载数据
 */
function loadMore(cat_id) {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getHealthnList(page, $('#keyword').val(), cat_id);
}

/**
 * 关键字查询
 * @returns {undefined}
 */
function keyWordSelect(cat_id) {
    getHealthnList(1, $('#keyword').val(), cat_id);
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

/**
 * 获取正文第一张图片
 * @param {type} htmlstr
 * @returns {getFirstImg.img_arr|String}
 */
function getFirstImg(htmlstr) {
    var arr = htmlstr.match(/<(div|p)(\W|\w)*?<img(\W|\w)*?<\/(div|p)>/gi);
    if (arr!=null) {
        var img_arr = arr[0].match(/<img(.|\s)*?>/gi);
        return img_arr[0];
    }else{
        return '<img src="' + res_path + '/common/nopic.jpg">';
    }

}

