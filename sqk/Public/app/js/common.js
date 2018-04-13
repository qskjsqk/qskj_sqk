
res_path = '/Public/Upload';
appUpload_path = '/';
root_path = '';
/**
 * 页面条转
 * @param {Object} sys_name
 */
function aHref(sys_name) {
     window.location.href =sys_name;

}

/**
 * 
 * @param {type} name
 * @returns {getUrl.r}正则表达式方法获取url参数获取时记着解码 decodeURI(getUrl(name));
 */
function getUrl(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
        return r[2];
    return null;
}

/**
 * 
 * @param {type} htmlstr
 * @returns {@exp;type|String|@exp;callback|@exp;props|@exp;params|@exp;data|@exp;speed|@exp;options|Array|@exp;props@call;split|@exp;utils@call;serializeParam|@exp;selector|data|@exp;jQuery@call;makeArray|@exp;selectorundefined|@exp;options@pro;duration|jquery-1.11.0_L38|@arr;optionsCache|@exp;options@call;call|jquery-1.10.2_L14|@exp;url|@exp;jQuery@call;extend|@exp;handleObjIn@pro;selector|until|selectorundefined|@arr;optionsCache.duration|options.duration|jquery-1.11.0_L38.duration|options@call;call.duration|jQuery@call;extend.duration|url.duration|jquery-1.10.2_L14.duration|@exp;url@call;slice|@exp;utils@call;html|Object|handleObjIn.selector}重置img部分代码
 */
function img_reset(htmlstr) {
    var arr = htmlstr.match(/<(div|p)(\W|\w)*?<img(\W|\w)*?<\/(div|p)>/gi);

    for (var key in arr) {
        var img_arr = arr[key].match(/<img(.|\s)*?>/gi);
        var img_html = '<div>' + img_arr[0] + '</div>';
        htmlstr = htmlstr.replace(img_arr[0], img_html);
    }
    return htmlstr;
}

/**
 * 编辑器地址去掉前缀
 * @param {Object} str
 */
function delHttp(str) {
    var arr = str.split('/');
    var newStr = '';
    for (var i = 3; i < arr.length; i++) {
        newStr += '/' + arr[i];
    }
    return root_path + newStr;
}

/**
 * 检测登录状态
 * @returns {undefined}
 */
function checkIsLogin() {
    $.post(m_path + "/login/checkIsLogin", function (data) {
        if (data.flag == 0) {
            mui.alert('您的登录信息已失效，请重新登录', '提示', '马上登录', function () {
                aHref(m_path + "/login/index");
            });

        }
    }, 'json');

}

/**
 * 关于app
 */
function about() {
    mui.alert('格瑞雅居健康之家APP是一款集健康服务、便民服务、物业服务、社区服务于一体的智慧社区应用。用户可以通过APP实现查看个人健康体检信息，预定商品、购物，物业报修，险情上报，预约社区活动等。便捷多样的功能等待您的亲自体验。', '关于APP', '确定');
}

/**
 * 代码备份
 */

//server_root = 'http://192.168.1.180:8082/index.php/App/';
//debug_root='http://localhost:9002/index.php/App/';
//debug_root = 'http://192.168.1.12:9002/index.php/App/';



//function aHome() {
//    mui.openWindow({
//        url: 'main.html',
//        extras: {
//            //传递参数
//        },
//        show: {
//            autoShow: true, //页面loaded事件发生后自动显示，默认为true  
//            aniShow: 'slide-in-right', //页面显示动画，默认为”slide-in-right“；  
//            duration: 1000, //页面动画持续时间，Android平台默认100毫秒，iOS平台默认200毫秒；  
//        },
//    });
//}
