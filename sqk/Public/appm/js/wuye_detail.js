/**
 * @name wuye_detail
 * @info 描述：物业详情页脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-9 14:02:48
 */

//全局变量---------------------------------------------------------------------------------------

//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    var type = getUrl('type');
    var id = getUrl('id');
    if (type == 0) {
        getDangDetail(id, type);
    } else {
        getPropDetail(id);
    }
    $('#back').attr('onclick', 'backList(' + type + ')');
});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取物业详情信息
 * @param {Object} id
 */
function getPropDetail(id) {
    $.post(c_path + "/getPropDetail/id/" + id, function (data) {
        if (data.flag == 1) {
            if (data.type == 1) {
                //意见
                $("#proType").html(data.pro_type);
                $("#title").html(data.title);
                $("#add_time").html(data.add_time);
                $("#reply").html(data.reply);
                $("#is_deal").html(data.is_deal);
                $("#content").html(data.content);
                $("#tel").html(data.tel);
                //屏蔽
                $("#dang_cat").css('display', 'none');
                $("#cat_name").css('display', 'none');
                $("#dang_level").css('display', 'none');
                $("#level_name").css('display', 'none');
                $("#item").css('display', 'none');
                $("#item_name").css('display', 'none');
                $("#address").css('display', 'none');
                $("#address_name").css('display', 'none');
                //改key
                $("#content_name").html('<b class="fontblack" >意见建议</b>');
            } else {
                //物业
                $("#proType").html(data.pro_type);
                $("#title").html(data.title);
                $("#add_time").html(data.add_time);
                $("#reply").html(data.reply);
                $("#is_deal").html(data.is_deal);
                $("#content").html(data.content);
                $("#tel").html(data.tel);
                $("#address").html(data.address);
                $("#item").html(data.item);
                //屏蔽
                $("#dang_cat").css('display', 'none');
                $("#cat_name").css('display', 'none');
                $("#dang_level").css('display', 'none');
                $("#level_name").css('display', 'none');
                //改key
                $("#address_name").html('<b class="fontblack" >故障位置</b>');
                $("#content_name").html('<b class="fontblack" >故障描述</b>');
            }
            //图片区
            if (data.pic_ids['flag'] == 1) {
                var picStr = '';
                for (var i = 0; i < data.pic_ids['data'].length; i++) {
                    picStr += '<img src="' + appUpload_path + data.pic_ids['data'][i]['url'] + '" width="100%">';
                }
            } else {
                picStr = '未上传图片';
            }
            $('#picList').html(picStr);

        } else {
            window.location.href = "wuye_list.html";
        }

    }, 'json');
}

/**
 * 获取险情详情
 * @param {Object} id
 */
function getDangDetail(id) {
    $.post(m_path + "/propdang/getDangDetail/id/" + id, function (data) {
        if (data.flag == 1) {
            //赋值
            $("#proType").html(data.pro_type);
            $("#title").html(data.title);
            $("#add_time").html(data.add_time);
            $("#reply").html(data.reply);
            $("#is_deal").html(data.is_deal);
            $("#content").html(data.content);
            $("#tel").html(data.tel);
            $("#address").html(data.address);
            $("#dang_cat").html(data.dang_cat);
            $("#dang_level").html(data.dang_level);
            //屏蔽
            $("#item").css('display', 'none');
            $("#item_name").css('display', 'none');
            //改key
            $("#content_name").html('<b class="fontblack" >险情描述</b>');
            //图片区
            if (data.pic_ids['flag'] == 1) {
                var picStr = '';
                for (var i = 0; i < data.pic_ids['data'].length; i++) {
                    picStr += '<img src="' + appUpload_path + data.pic_ids['data'][i]['url'] + '" width="100%">';
                }
            } else {
                picStr = '未上传图片';
            }
            $('#picList').html(picStr);
        } else {
            window.location.href = "wuye_list.html";
        }

    }, 'json');
}

/**
 * 返回列表页
 * @param {type} type
 * @returns {undefined}
 */
function backList(type) {
    window.location.href = c_path+"/wuye_list.html?type=" + type;
}
