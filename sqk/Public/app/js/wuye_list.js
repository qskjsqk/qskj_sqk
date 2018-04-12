/**
 * @name wuye_list
 * @info 描述：
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-8 17:33:46
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    if (getUrl('type') == null) {
        changeTab(1, 0, 2, '报修');
    } else {
        if (getUrl('type') == 0) {
            changeTab(0, 1, 2, '上报');
        } else if (getUrl('type') == 1) {
            changeTab(1, 0, 2, '报修');
        } else {
            changeTab(2, 0, 1, '反馈');
        }
    };
});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取列表
 * @param {Object} type
 * @param {Object} page
 */
function getList(type, page, keyword) {
    if (type == 0) {
        //险情上报
        $.post(m_path + "/propdang/getPropDangList", {'type': type, 'page': page, 'keyword': keyword}, function (data) {
            if (data.flag == 1) {
                var str = '';
                for (var i = 0; i < data.data.length; i++) {
                    str += '<li class="mui-table-view-cell" style="padding-right: 10px;" onclick="getPropDetail(' + data.data[i]['id'] + ',0)">' +
                            '<div class="mui-media-body">' +
                            '<img src="' + public + '/app/img/xd.png" />&#12288;' + data.data[i]['title'] +
                            '<span class="mui-ellipsis" style="float: right;">' + data.data[i]['is_deal'] + '</span>' +
                            '<p class="mui-ellipsis fontblack m-margin-t10 fontred"><span class="mui-icon mui-icon-contact" style="font-size: 18px;"></span>工作人员：' + data.data[i]['reply'] + '<sapn style="float:right;color:#999;">' + data.data[i]['add_time'] + '</sapn></p>' +
                            '<p class="mui-ellipsis m-margin-t10">' + data.data[i]['content'] + '</p>' +
                            '</div>' +
                            '</li>';
                }
            } else {
                str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;该分类下暂无信息</li>';
            }
            $("#wuyeList").html(str);

            //动态加载--------------------------------------------------------------		
            $("#page").val(data.page);
            if (data.is_end == 1) {
                $("#loadMore").removeAttr('onclick');
            } else {
                $("#loadMore").attr('onclick', 'loadMore(' + type + ')');
            }
            mui("#loadMore").button('reset');
            $("#loadMore").html(data.ajaxLoad);
            //---------------------------------------------------------------------

        }, 'json');
    } else if (type == 1) {
        //物业报修
        getPropList(1, page, keyword);

    } else {
        //意见反馈
        getPropList(2, page, keyword);
    }

    $('#searchBtn').attr('onclick', 'keyWordSelect(' + type + ')');
}

/**
 * 切换tab
 * @param {Object} id1
 * @param {Object} id2
 * @param {Object} id3
 * @param {Object} sendChar
 */
function changeTab(id1, id2, id3, sendChar) {
    $('#keyword').val('');
    $("#tabWuye div").removeClass("tab-btn-sel").removeClass("tab-btn-no");
    $("#wuye" + id1).addClass("tab-btn-sel");
    $("#wuye" + id2).addClass("tab-btn-no");
    $("#wuye" + id3).addClass("tab-btn-no");
    $("#sendBtn").html(sendChar);
    $("#sendBtn").attr('onclick', 'jumpForm(' + id1 + ')');
    getList(id1, 1, '');
}

/**
 * 获取物业诉求列表
 * @param {Object} type
 * @param {Object} page
 * @param {Object} keyword
 */
function getPropList(type, page, keyword) {
    $.post(c_path + "/getList", {'type': type, 'page': page, 'keyword': keyword}, function (data) {
        if (data.flag == 1) {
            var str = '';
            for (var i = 0; i < data.data.length; i++) {
                str += '<li class="mui-table-view-cell" style="padding-right: 10px;" onclick="getPropDetail(' + data.data[i]['id'] + ','+type+')">' +
                        '<div class="mui-media-body">' +
                        '<img src="' + public + '/app/img/xd.png" />&#12288;' + data.data[i]['title'] +
                        '<span class="mui-ellipsis" style="float: right;">' + data.data[i]['is_deal'] + '</span>' +
                        '<p class="mui-ellipsis fontblack m-margin-t10 fontred"><span class="mui-icon mui-icon-contact" style="font-size: 18px;"></span>工作人员：' + data.data[i]['reply'] + '<sapn style="float:right;color:#999;">' + data.data[i]['add_time'] + '</sapn></p>' +
                        '<p class="mui-ellipsis m-margin-t10">' + data.data[i]['content'] + '</p>' +
                        '</div>' +
                        '</li>';
            }
        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;该分类下暂无信息</li>';
        }
        $("#wuyeList").html(str);
        //动态加载--------------------------------------------------------------		
        $("#page").val(data.page);
        if (data.is_end == 1) {
            $("#loadMore").removeAttr('onclick');
        } else {
            $("#loadMore").attr('onclick', 'loadMore(' + type + ')');
        }
        mui("#loadMore").button('reset');
        $("#loadMore").html(data.ajaxLoad);
        //---------------------------------------------------------------------
    }, 'json');
}

/**
 * 获取物业详情
 * @param {type} id
 * @param {type} type
 * @returns {undefined}
 */
function getPropDetail(id, type) {
    //打开详情
    window.location.href = c_path+"/wuye_detail.html?id=" + id + "&type=" + type;
}

/**
 * 跳转表单页面
 * @param {type} type
 * @returns {undefined}
 */
function jumpForm(type) {
    window.location.href = c_path+"/wuye_form.html?type=" + type;
}

/**
 * 动态加载数据
 * @param {Object} type
 */
function loadMore(type) {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getList(type, page, $('#keyword').val());
}

/**
 * 关键字搜索
 * @param {type} type
 * @returns {undefined}
 */
function keyWordSelect(type) {
    getList(type, 1, $('#keyword').val());
}
