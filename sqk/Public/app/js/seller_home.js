/**
 * @name seller_home
 * @info 描述：
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-3 16:33:33
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    var cat_id = getUrl('cat_id');
    if (cat_id > 0) {
        getList(1);
    } else {
        getList(0);
    }

});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取列表
 * @param {Object} type
 */
function getList(type) {
    $("#tabNotice div").removeClass("tab-btn-sel").removeClass("tab-btn-no");

    if (type == 1) {
        $("#seller1").addClass("tab-btn-sel");
        $("#seller0").addClass("tab-btn-no");
        getSellerCat(1);

    } else {
        $("#seller0").addClass("tab-btn-sel");
        $("#seller1").addClass("tab-btn-no");
        getSellerCat(0);
    }
    $('#keyword').val('');

}

/**
 * 获取商家分类列表
 */
function getSellerCat(type) {
    $.get(c_path + "/getSellerCat", function (data) {
        if (data.flag == 1) {
            var str = '';
            for (var i = 0; i < data.data.length; i++) {
                str += '<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-2" style="padding: 0;">' +
                        '<a href="javascript:void(0)" onclick="getBotList(' + type + ',' + data.data[i]['id'] + ',1,0)">' +
                        '<img src="' + public + '/app/img/' + data.data[i]['sys_name'] + '.png" width="40px;">' +
                        '<div class="mui-media-body">' + data.data[i]['cat_name'] + '</div>' +
                        '</a>' +
                        '</li>';
            }
            $("#sellerCatList").html(str);
            $("#catTitle").html(data.data[0]['cat_name']);
            getBotList(type, data.data[0]['id'], 1);
        } else {
            mui.toast("暂无商家分类信息!", {duration: 'long', type: 'div'});
        }

    }, 'json');
}

/**
 * 获取底部列表
 * @param {type} type
 * @param {type} id
 * @param {type} page
 * @param {type} flag
 * @returns {undefined}
 */
function getBotList(type, id, page, flag) {
    if (flag == 0) {
        $('#keyword').val('');
    }
    var keyword = $('#keyword').val();
    if (type == 0) {
        $.get(c_path + "/getSellerList/cat_id/" + id, {'page': page, 'keyword': keyword}, function (data) {
            if (data.flag == 1) {
                $("#catTitle").html('<b class="fontblack">' + data.title + '</b>');
                var str = '';
                for (var i = 0; i < data.data.length; i++) {
                    str += '<li class="mui-table-view-cell" onclick="getSellerDetail(' + data.data[i]['id'] + ')">' +
                            '<div class="mui-media-body">' +
                            '<img src="' + public + '/app/img/xd.png" />&#12288;<font class="font16">' + data.data[i]['name'] + '</font>' +
                            '<span class="mui-ellipsis" style="float: right;color: #999;font-size:14px;">' + data.data[i]['is_rest'] + '</span>' +
                            '<div class="listcontent" style="padding:10px 5px 0px 10px;height:100px;border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;background-color: #fff;">' +
                            '<div class="listimg" >' +
                            '<img src="' + res_path + data.data[i]['logo_icon'] + '" style="width: 120px;height:80px;">' +
                            '</div>' +
                            '&#12288;&#12288;<b class="fontblack">主营分类：</b>' + data.data[i]['item_cat'] + '</br>' +
                            '&#12288;&#12288;<b class="fontblack">联系方式：</b>' + data.data[i]['tel'] + '</br>' +
                            '&#12288;&#12288;<b class="fontblack">商家地址：</b>' + data.data[i]['address'] + '</br>' +
                            '&#12288;&#12288;<b class="fontblack">商家介绍：</b>' + data.data[i]['introduction'].replace(/<[^>]+>/gi, '').substring(0, 26) + '...【详情】' +
                            '</div></div>' +
                            '<div class="listfooter"><span>累计销量：' + data.data[i]['sum_num'] + '&nbsp;件</span></div>' +
                            '</li>';
                }
                $("#listArea").html(str);
            } else {

                mui.toast("该分类下暂无信息!", {duration: 'long', type: 'div'});
                str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';
                $("#listArea").html(str);
            }

            $("#page").val(data.page);
            if (data.is_end == 1) {
                $("#loadMore").removeAttr('onclick');
            } else {
                $("#loadMore").attr('onclick', 'loadMore(' + type + ',' + id + ')');
            }
            mui("#loadMore").button('reset');
            $("#loadMore").html(data.ajaxLoad);

            $("#searchBtn").attr('onclick', 'keywordSelect(' + type + ',' + id + ')');

        }, 'json');
    } else {
        $.get(c_path + "/getPromList/cat_id/" + id, {'page': page, 'keyword': keyword}, function (data) {
            if (data.flag == 1) {
                $("#catTitle").html('<b>' + data.title + '</b>');
                var str = '';
                for (var i = 0; i < data.data.length; i++) {
                    str += '<li class="mui-table-view-cell" onclick="getPromDetail(' + data.data[i]['id'] + ',' + data.data[i]['seller_id'] + ')">' +
                            '<div class="mui-media-body ">' +
                            '<img src="' + public + '/app/img/xd.png" />&#12288;<font class="font16">' + data.data[i]['name'] + '</font>' +
                            '<span class="mui-ellipsis" style="float: right;color: #999;font-size:14px;">' + data.data[i]['add_time'] + '</span>' +
                            '<div class="listcontent" style="padding:10px 5px 0px 10px;height:100px;border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;background-color: #fff;">' +
                            '<div class="listimg" >' +
                            '<img src="' + res_path + data.data[i]['logo_icon'] + '" style="width: 120px;height:80px;">' +
                            '</div>' +
                            '&#12288;&#12288;<b class="fontorder font16">☆☆☆&nbsp;' + data.data[i]['title'] + '&nbsp;☆☆☆</b></br>' +
                            '&#12288;&#12288;<font color="#777">' + data.data[i]['ad_time'] + '</font></br>' +
                            '&#12288;&#12288;&nbsp;' + data.data[i]['content'].replace(/<[^>]+>/gi, '').substring(0, 60) + '...【详情】' +
                            '</div></div>' +
                            '<div class="listfooter"><span>累计销量：' + data.data[i]['sum_num'] + '&nbsp;件</span></div>' +
                            '</li>';
                }
                $("#listArea").html(str);
            } else {
                mui.toast("该分类下暂无信息!", {duration: 'long', type: 'div'});
                str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';
                $("#listArea").html(str);
            }

            $("#page").val(data.page);
            if (data.is_end == 1) {
                $("#loadMore").removeAttr('onclick');
            } else {
                $("#loadMore").attr('onclick', 'loadMore(' + type + ',' + id + ')');
            }
            mui("#loadMore").button('reset');
            $("#loadMore").html(data.ajaxLoad);

            $("#searchBtn").attr('onclick', 'keywordSelect(' + type + ',' + id + ')');

        }, 'json');
    }
}

/**
 * 获取商家详情页
 * @param {Object} id
 */
function getSellerDetail(id) {
    //打开商家详情
    window.location.href = "seller_info.html?id=" + id + '&cat_id=0';
}

/**
 * 获取促销详情
 * @param {Object} id
 */
function getPromDetail(id, seller_id) {
    //打开促销详情
    window.location.href = "seller_prom.html?id=" + id + '&cat_id=1&seller_id=' + seller_id;
}

/**
 * 动态加载数据
 * @param {Object} type
 */
function loadMore(type, cat_id) {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getBotList(type, cat_id, page);
}
/**
 * 关键字搜索
 * @param {type} type
 * @param {type} cat_id
 * @returns {undefined}
 */
function keywordSelect(type, cat_id) {
    getBotList(type, cat_id, 1);
}

