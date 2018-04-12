/**
 * @name health_stat
 * @info 描述：健康图表
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-20 9:33:29
 */


//全局变量---------------------------------------------------------------------------------------


//初始化-----------------------------------------------------------------------------------------
$(function () {
    checkIsLogin();
    getStatOfCat(6);
});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取健康分类标识
 * @param {type} table_num
 * @returns {undefined}
 */
function getStatOfCat(table_num) {
    mui('#popover').popover('hide');
    if (table_num == 6) {
        $('#openPopover').html('血糖<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;margin-right: -5px;"></span>');
        $('#chartTitle').html('血糖');
    } else if (table_num == 5) {
        $('#openPopover').html('血氧<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;margin-right: -5px;"></span>');
        $('#chartTitle').html('血氧');
    } else if (table_num == 7) {
        $('#openPopover').html('血压<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;margin-right: -5px;"></span>');
        $('#chartTitle').html('血压');
    } else if (table_num == 9) {
        $('#openPopover').html('身高体重<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;margin-right: -5px;"></span>');
        $('#chartTitle').html('身高体重');
    } else if (table_num == 3) {
        $('#openPopover').html('体温<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;margin-right: -5px;"></span>');
        $('#chartTitle').html('体温');
    }
    
//    else if (table_num == 0) {
//        $('#openPopover').html('身高<span class="mui-icon mui-icon-arrowdown" style="margin-top: -7px;margin-right: -5px;"></span>');
//        $('#chartTitle').html('身高');
//    }
    createChart(table_num, 1);
}

/**
 * 生成健康统计图
 * @param {type} table_num
 * @param {type} page
 * @returns {undefined}
 */
function createChart(table_num, page) {
    $.post(c_path + "/getStatData", {'page': page, 'table_num': table_num}, function (data) {
        if (data.flag == 0) {
            $('#container').html('<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无数据</li>');
        } else {
            if (data.is_end == 1) {
                $('#is_end').attr('onclick', 'echo(0)');
            } else {
                $('#is_end').removeAttr('onclick').attr('onclick', 'next(' + data.table_num + ',' + data.page + ')');
            }
            if (data.is_start == 1) {
                $('#is_start').attr('onclick', 'echo(1)');
            } else {
                $('#is_start').removeAttr('onclick').attr('onclick', 'prev(' + data.table_num + ',' + data.page + ')');
            }
            if (data.table_num == 6) {
                var strser = "[{name: '血糖值',data: [";
                $.each(data.data, function (i, res) {
                    strser = strser + '[Date.UTC(' + res['y'] + ', ' + res['m'] + ', ' + res['d'] + '), ' + res['bloodsugar'] + '],'
                });
                strser = strser.substr(0, strser.length - 1);
                strser = strser + "]}]";
                series = eval("(" + strser + ")");
                createChartData('血糖 变化趋势图', data.name, '血糖值（mmol/L）', '血糖值：', 'mmol/L', series);
            } else if (data.table_num == 5) {
                var strser = "[{name: '血氧饱和度',data: [";
                $.each(data.data, function (i, res) {
                    strser = strser + '[Date.UTC(' + res['y'] + ', ' + res['m'] + ', ' + res['d'] + '), ' + res['bloodoxygen'] + '],'
                });
                strser = strser.substr(0, strser.length - 1);
                strser = strser + "]}]";
                series = eval("(" + strser + ")");
                createChartData('血氧 变化趋势图', data.name, '血氧饱和度（百分比）', '血氧饱和度：', '%', series);
            } else if (data.table_num == 7) {
                var strser = "[";
                var shou = "{name: '收缩压',data: [";
                var shu = "{name: '舒张压',data: [";

                $.each(data.data, function (i, res) {
                    shu = shu + '[Date.UTC(' + res['y'] + ', ' + res['m'] + ', ' + res['d'] + '), ' + res['diastolic'] + '],'
                });
                shu = shu.substr(0, shu.length - 1);
                shu = shu + "]}";
                $.each(data.data, function (i, res) {
                    shou = shou + '[Date.UTC(' + res['y'] + ', ' + res['m'] + ', ' + res['d'] + '), ' + res['systolic'] + '],'
                });
                shou = shou.substr(0, shou.length - 1);
                shou = shou + "]}";
                strser = strser + shu + ',' + shou + ']';
                series = eval("(" + strser + ")");
                createChartData('血压 变化趋势图', data.name, '血压值（mmHg）', '', 'mmHg', series);
            } else if (data.table_num == 9) {
                var strser = "[{name: '体重',data: [";
                $.each(data.data, function (i, res) {
                    strser = strser + '[Date.UTC(' + res['y'] + ', ' + res['m'] + ', ' + res['d'] + '), ' + res['weight'] + '],'
                });
                strser = strser.substr(0, strser.length - 1);
                strser = strser + "]}]";
                series = eval("(" + strser + ")");
                createChartData('体重 变化趋势图', data.name, '体重（Kg）', '体重：', 'Kg', series);
            } else if (data.table_num == 3) {
                var strser = "[{name: '体温',data: [";
                $.each(data.data, function (i, res) {
                    strser = strser + '[Date.UTC(' + res['y'] + ', ' + res['m'] + ', ' + res['d'] + '), ' + res['temperature'] + '],'
                });
                strser = strser.substr(0, strser.length - 1);
                strser = strser + "]}]";
                series = eval("(" + strser + ")");
                createChartData('体温 变化趋势图', data.name, '体温值（℃）', '体温值：', '℃', series);
            }
            
//            else if (data.table_num == 0) {
//                var strser = "[{name: '身高',data: [";
//                $.each(data.data, function (i, res) {
//                    strser = strser + '[Date.UTC(' + res['y'] + ', ' + res['m'] + ', ' + res['d'] + '), ' + res['temperature'] + '],'
//                });
//                strser = strser.substr(0, strser.length - 1);
//                strser = strser + "]}]";
//                series = eval("(" + strser + ")");
//                createChartData('身高 变化趋势图', data.name, '身高值（cm）', '身高值：', 'cm', series);
//            }
        }
    }, 'json');

}

/**
 * 生成统计图数据
 * @param {type} title
 * @param {type} ftitle
 * @param {type} ytitle
 * @param {type} tipText
 * @param {type} quantif
 * @param {type} ydata
 * @returns {undefined}
 */
function createChartData(title, ftitle, ytitle, tipText, quantif, ydata) {
    $('#container').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: title
        },
        subtitle: {
            text: ftitle
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%e. %b',
                year: '%b'
            },
            title: {
                text: '日期'
            }
        },
        yAxis: {
            title: {
                text: ytitle
            },
            min: 0
        },
        tooltip: {
            headerFormat: '<b>{point.x:%m-%e}</b><br>',
            pointFormat: tipText + '{point.y:.1f}' + quantif
        },
        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },
        series: ydata,
    });
    $('.highcharts-credits').css('display', 'none');
    $('.highcharts-button-symbol').remove();
    $('.highcharts-button-box').remove();
    
}

/**
 * 弹出提示消息
 * @param {type} type
 * @returns {undefined}
 */
function echo(type) {
    if (type == 1) {
        mui.toast('已经是最新一页', {duration: 'long', type: 'div'});
    } else {
        mui.toast('已经没有数据了', {duration: 'long', type: 'div'});
    }
}
/**
 * 下一阶段
 * @param {type} table_num
 * @param {type} page
 * @returns {undefined}
 */
function next(table_num, page) {
    page = page + 1;
    createChart(table_num, page);
}
/**
 * 上一阶段
 * @param {type} table_num
 * @param {type} page
 * @returns {undefined}
 */
function prev(table_num, page) {
    page = page - 1;
    createChart(table_num, page);
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