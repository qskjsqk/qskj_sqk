/**
 * @name health_detail
 * @info 描述：体检记录详情
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-17 14:43:05
 */


//全局变量---------------------------------------------------------------------------------------


//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    var id = getUrl('id');
    var table_num = getUrl('table_num');
    getHealthDetail(id, table_num);
});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取体检记录详情
 * @param {type} id
 * @param {type} table_num
 * @returns {undefined}
 */
function getHealthDetail(id, table_num) {
    var str = '';
    var zjStr = '';
    $.get(c_path + "/getHealthDetail/id/" + id + '/table_num/' + table_num, function (data) {
        if (data.flag == 1) {
            $('#title').html(data['table_name'] + '&#12288;检测结果');
            $('#userName').html(data['realname'] + '&#12288;' + data['data']['idcard']);
            $('#time').html(data.data['time']);
            $('#zjtime').html('发表于' + data.data['time']);
            if (data.table_num == 6) {
//                血糖
                str = '<div class="cardcontent-icon m-icon-xuetang">' +
                        '<div class="cardcontent-r" id="content">' +
                        '<p><span class="fontblack">类型&nbsp;</span><span class="fontred font16">' + data.data['type'] + '&nbsp;</span></p>' +
                        '<p><span class="fontblack">血糖值&nbsp;</span><span class="fontred font16">' + data.data['bloodsugar'] + '&nbsp;</span>mmol/L</p>' +
                        ' <p><span class="fontblack">正常值&nbsp;</span><span class="fontred font16">空腹（3.9~6.4）&nbsp;</span>mmol/L</p>' +
                        '</div>' +
                        '</div>';
                zjStr = '&#12288;&#12288;血液中的葡萄糖称为血糖。体内各组织细胞活动所需的能量大部分来自葡萄糖，所以血糖必须保持一定的水平才能维持体内各器官和组织的需要。正常人在清晨空腹血糖浓度为80～120毫克%。空腹血糖浓度超过130毫克%称为高血糖。如果血糖浓度超过160～180毫克%，就有一部分葡萄糖随尿排出，这就是糖尿。血糖浓度低于70毫克%称为低血糖。小粒径负离子，则有良好的生物活性，易于透过人体血脑屏障， 进入人体发挥其生物效应。对于降糖有良好的疗效。同时建议患者对血同（血同型半胱氨酸）进行检测。较低的血同值能大幅降低糖尿病并发症的发病风险。';
            } else if (data.table_num == 5) {
//                血氧
                str = '<div class="cardcontent-icon m-icon-xueyang">' +
                        '<div class="cardcontent-r" id="content">' +
                        '<p><span class="fontblack">血氧饱和度&nbsp;</span><span class="fontred font16">' + data.data['bloodoxygen'] + '&nbsp;</span>%</p>' +
                        '<p><span class="fontblack">脉搏值&nbsp;</span><span class="fontred font16">' + data.data['pulse'] + '&nbsp;</span>次/min</p>' +
                        '</div>' +
                        '</div>';
                zjStr = '<b style="line-height:30px;">常规：</b></br>' + data.data['sugcommon'] + '</br>' +
                        '<b style="line-height:30px;">医疗：</b></br>' + data.data['sugdoctor'] + '</br>' +
                        '<b style="line-height:30px;">运动：</b></br>' + data.data['sugsport'] + '</br>' +
                        '<b style="line-height:30px;">饮食：</b></br>' + data.data['sugfood'];
            } else if (data.table_num == 7) {
//                血压
                str = '<div class="cardcontent-icon m-icon-xueya">' +
                        '<div class="cardcontent-r" id="content">' +
                        '<p><span class="fontblack">收缩压&nbsp;</span><span class="fontred font16">' + data.data['systolic'] + '&nbsp;</span>mmHg</p>' +
                        '<p><span class="fontblack">舒张压&nbsp;</span><span class="fontred font16">' + data.data['diastolic'] + '&nbsp;</span>mmHg</p>' +
                        '<p><span class="fontblack">脉搏值&nbsp;</span><span class="fontred font16">' + data.data['pulse'] + '&nbsp;</span>次/min</p>' +
                        '</div>' +
                        '</div>';
                zjStr = '<b style="line-height:30px;">常规：</b></br>' + data.data['sugcommon'] + '</br>' +
                        '<b style="line-height:30px;">医疗：</b></br>' + data.data['sugdoctor'] + '</br>' +
                        '<b style="line-height:30px;">运动：</b></br>' + data.data['sugsport'] + '</br>' +
                        '<b style="line-height:30px;">饮食：</b></br>' + data.data['sugfood'];
            } else if (data.table_num == 9) {
                if (data.data['height'] == '0.0') {
                    //体重
                    str = '<div class="cardcontent-icon m-icon-tizhong">' +
                            '<div class="cardcontent-r" id="content">' +
                            '<p><span class="fontblack">体重&nbsp;</span><span class="fontred font16">' + data.data['weight'] + '&nbsp;</span>Kg</p>' +
                            '</div>' +
                            '</div>';
                } else {
                    //体重身高
                    str = '<div class="cardcontent-icon m-icon-tizhong">' +
                            '<div class="cardcontent-r" id="content">' +
                            '<p><span class="fontblack">身高&nbsp;</span><span class="fontred font16">' + data.data['height'] + '&nbsp;</span>Cm</p>' +
                            '<p><span class="fontblack">体重&nbsp;</span><span class="fontred font16">' + data.data['weight'] + '&nbsp;</span>Kg</p>' +
                            '<p><span class="fontblack">BMI&nbsp;</span><span class="fontred font16">' + data.data['bmi'] + '&nbsp;</span></p>' +
                            '</div>' +
                            '</div>';
                }

                zjStr = '&#12288;&#12288;BMI是与体内脂肪总量密切相关的指标,该指标考虑了体重和身高两个因素。BMI简单、实用、可反映全身性超重和肥胖。 在测量身体因超重而面临心脏病、高血压等风险时，比单纯的以体重来认定，更具准确性。成人的BMI数值：过轻：低于18.5,正常：18.5-24.99,过重：25-28,肥胖：28-32,非常肥胖：高于32。</br>&#12288;&#12288;肥胖症患者更易发生高血压、高血脂和葡萄糖代谢异常；肥胖是影响冠心病发病和死亡的一个独立危险因素。</br>&#12288;&#12288;体重过低影响未成年人身体和智力发育，影响成年人体力，还与免疫力低下、月经不调或闭经、骨质疏松、贫血、抑郁等病症有关，最终影响寿命。';
            } else if (data.table_num == 3) {
//                体温
                str = '<div class="cardcontent-icon m-icon-tiwen">' +
                        '<div class="cardcontent-r" id="content">' +
                        '<p><span class="fontblack">体温&nbsp;</span><span class="fontred font16">' + data.data['temperature'] + '&nbsp;</span>度（摄氏）</p>' +
                        '</div>' +
                        '</div>';
                zjStr = '<b style="line-height:30px;">常规：</b></br>' + data.data['sugcommon'] + '</br>' +
                        '<b style="line-height:30px;">医疗：</b></br>' + data.data['sugdoctor'] + '</br>' +
                        '<b style="line-height:30px;">运动：</b></br>' + data.data['sugsport'] + '</br>' +
                        '<b style="line-height:30px;">饮食：</b></br>' + data.data['sugfood'];
            }
//            else if (data.table_num == 0) {
////                身高
//                str = '<div class="cardcontent-icon m-icon-tiwen">' +
//                        '<div class="cardcontent-r" id="content">' +
////                        '<p><span class="fontblack">身高&nbsp;</span><span class="fontred font16">' + data.data['type'] + '&nbsp;</span></p>' +
//                        '<p><span class="fontblack">体温&nbsp;</span><span class="fontred font16">' + data.data['temperature'] + '&nbsp;</span>度（摄氏）</p>' +
////                        ' <p><span class="fontblack">BMI&nbsp;</span><span class="fontred font16">空腹（3.9~6.1）&nbsp;</span>mmol/L</p>' +
//                        '</div>' +
//                        '</div>';
//                zjStr = '<b style="line-height:30px;">常规：</b></br>' + data.data['sugcommon'] + '</br>' +
//                        '<b style="line-height:30px;">医疗：</b></br>' + data.data['sugdoctor'] + '</br>' +
//                        '<b style="line-height:30px;">运动：</b></br>' + data.data['sugsport'] + '</br>' +
//                        '<b style="line-height:30px;">饮食：</b></br>' + data.data['sugfood'];
//            }
            $('#zjsug').html(zjStr);
            $('#content').html(str);
        } else {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
            window.location.href = "health_list.html";
        }

    }, 'json');

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
 * 返回上级
 * @returns {undefined}
 */
function back() {
    var table_num = getUrl('table_num');
    //打开详情
    if (table_num > 0) {
        window.location.href = c_path + "/health_list.html?table_num=" + table_num;
    } else {
        window.location.href = c_path + "/health_list.html?table_num=6";
    }

}