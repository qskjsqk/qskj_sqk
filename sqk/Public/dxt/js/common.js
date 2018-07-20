//server_root = 'http://192.168.1.180:8082/index.php/App/';
//debug_root='http://localhost:9002/index.php/App/';
//debug_root = 'http://192.168.1.12:9002/index.php/App/';
res_path = '/Public/Upload';
appUpload_path = '/';
root_path = '';
/**
 * 页面条转
 * @param {Object} sys_name
 */
function aHref(sys_name) {
    window.location.href = sys_name;
}

/**
 * 正则表达式方法获取url参数获取时记着解码 decodeURI(getUrl(name));
 * @param {type} name
 * @returns {getUrl.r}
 */
function getUrl(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
        return r[2];
    return null;
}

/**
 * 重置img部分代码
 * @param {type} htmlstr
 * @returns {unresolved}
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
    parent.TimeNum=0;
    $(document).mousedown(function () {
        parent.timeZero();
    }).keydown(function () {
        parent.timeZero();
    }).mousemove(function () {
        parent.timeZero();
    });
    
    
    console.log('====正在访问【'+module+'】【'+controller+'】【'+action+'】');
    $('#'+controller+'_btn').addClass('mui-active');
    $.post(m_path + "/login/checkIsLogin", function (data) {
        if (data.flag == 0) {
            mui.alert('您的登录信息已失效，请重新登录', '提示', '马上登录', function () {
                aHref(m_path + "/login/index");
            });
        } else {
            console.log('====检测用户已登录！');
            //tabbar 通知公告
            data.data.notice_num == 0 ? $('#notice_num').html('') : $('#notice_num').html('<span class="mui-badge">' + data.data.notice_num + '</span>');
            //tabbar 活动
            data.data.activity_num == 0 ? $('#activity_num').html('') : $('#activity_num').html('<span class="mui-badge">' + data.data.activity_num + '</span>');
        }
    }, 'json');

}

/**
 * 检测登录状态
 * @returns {undefined}
 */
function checkIsUser() {
    console.log('====正在访问【'+module+'】【'+controller+'】【'+action+'】');
    $('#'+controller+'_btn').addClass('mui-active');
    $.post(m_path + "/login/checkIsLogin", function (data) {
        if (data.flag == 0) {
            mui.alert('非登陆状态您不可以使用该功能', '提示', '确定', function () {
                closeModal();
            });
        } else {
            console.log('====检测用户已登录！');
        }
    }, 'json');

}

/**
 * 关于app介绍
 * @returns {undefined}
 */
function about() {
    mui.alert('格瑞雅居健康之家APP是一款集健康服务、便民服务、物业服务、社区服务于一体的智慧社区应用。用户可以通过APP实现查看个人健康体检信息，预定商品、购物，物业报修，险情上报，预约社区活动等。便捷多样的功能等待您的亲自体验。', '关于APP', '确定');
}

/**
 * 拨打电话
 * @param {Object} phone
 */
function callPhone(phone) {
    var btnArray = ['拨打', '取消'];
    mui.confirm('是否拨打' + phone + '?', '提示', btnArray, function (e) {
        if (e.index == 0) {
            plus.device.dial(phone, false);
        }
    });
}

/**
 * 打开模态框
 */
function openModal() {
    $(".m-modal-content").fadeIn(200);
    $(".m-modal").fadeIn(200);

    $(".m-modal").bind('click', function () {
        closeModal();
    });
}
/**
 * 关闭模态框
 */
function closeModal() {
    $(".m-modal-content").fadeOut(200);
    $(".m-modal").fadeOut(200);
}



