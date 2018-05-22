/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    checkIsLogin();

    var type = getUrl('type');
    if (type == null) {
        getMyPromList('', 1);
    } else {
        getMyPromList(type, 1);
    }
});

function getMyPromList(type, page) {
    mui.post(c_path + "/getMyPromList", {'type': type, 'page': page}, function (data) {
        //广告列表
        var str = '';
        var picsStr = '';
        var statusStr = '';
        if (data.flag == 1) {
            for (var i = 0; i < data.data.length; i++) {
                if (data.data[i]['pics'] == 0) {
                    picsStr = '../../../Public/Upload/sellerProm/2018-04-21/5adb3b6907f0a.jpg';
                } else {
                    picsStr = '../../../' + data.data[i]['pics'][0]['url'];
                }

                if (data.data[i]['status'] == 0) {
                    statusStr = '<span class="mui-badge mui-badge-primary">未审核</span>';
                } else if (data.data[i]['status'] == 1) {
                    statusStr = '<span class="mui-badge mui-badge-success">已发布</span>';
                } else if (data.data[i]['status'] == 2) {
                    statusStr = '<span class="mui-badge mui-badge-waring">审核未过</span>';
                } else {
                    statusStr = '<span class="mui-badge mui-badge-danger">已下架</span>';
                }

                str += '<div class="mui-card" onclick="toPromDetail(' + data.data[i]['id'] + ')">' +
                        '<div class="mui-card-header">' +
                        '<div class="mui-card-link">' + statusStr + '</div>' +
                        '<p class="mui-card-link">浏览量：' + data.data[i]['read_num'] + '</p>' +
                        '</div>' +
                        '<div class="mui-card-content">' +
                        '<div class="mui-card-content">' +
                        '<div class="item_list">' +
                        '<div class="item_list_img" style="background:url(' + picsStr + ') no-repeat;background-size:140px 70px;"></div>' +
                        '<div class="item_list_word">' +
                        '<p class="mui-ellipsis font333">' + data.data[i]['title'] + '</p>' +
                        '<p class="mui-ellipsis-2">' + data.data[i]['content'] + '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
            }

        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';
        }

        $("#myPromList").html(str);

        //统计数据分配
        $('#status1').html('已发布(' + data.promStat.status1 + ')');
        $('#status02').html('正在审核(' + data.promStat.status02 + ')');
        $('#status3').html('已下架(' + data.promStat.status3 + ')');

        $('#count').html('数量(' + data.count + ')');
        $('#allReadNum').html('浏览量(' + data.allReadNum + ')');
        $('#integral_num').html('积分(' + data.sellerInfo.integral_num + ')');

        if (data.sellerInfo.integral_num >= 2000) {
            $('#promBtn').html('<button type="button" class="mui-btn mui-btn-warning mui-btn-block" onclick="changeConfirm()">兑换广告发布</button>');
        } else {
            $('#promBtn').html('<button type="button" class="mui-btn mui-btn-block">积分不足，无法发布</button>');
        }

    }, 'json');

}

function changeConfirm() {
    var btnArray = ['取消', '确定'];
    mui.confirm('广告发布权限兑换', '需消耗2000积分', btnArray, function (e) {
        if (e.index == 1) {
            //兑换发布权限
            mui.post(c_path + "/exchangeAdInte", function (data) {
//                跳转广告发布页面
//            aHref(m_path + '/prom/prom_add');
            }, 'json');

        }
    })
}

function toPromDetail(id) {
    aHref(c_path + '/prom_detail?id=' + id);
}
