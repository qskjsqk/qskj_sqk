/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : qs_sqk_db_debug

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2018-04-16 17:38:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `qs_sqk_activ_cat`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_activ_cat`;
CREATE TABLE `qs_sqk_activ_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) DEFAULT NULL COMMENT '系统名称',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `parent_id_path` varchar(50) NOT NULL DEFAULT '' COMMENT '所属上级目录',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用 0：禁用，1：启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_activ_cat
-- ----------------------------
INSERT INTO `qs_sqk_activ_cat` VALUES ('1', 'shequhuodong', '社区', '', '0', '2017-04-01 15:46:03', '1');
INSERT INTO `qs_sqk_activ_cat` VALUES ('2', 'gongyihuodong', '公益', '', '0', '2017-04-01 15:57:44', '1');

-- ----------------------------
-- Table structure for `qs_sqk_activ_comm`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_activ_comm`;
CREATE TABLE `qs_sqk_activ_comm` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `activity_id` int(11) NOT NULL DEFAULT '0' COMMENT '活动id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '评论人id',
  `content` varchar(2000) NOT NULL COMMENT '评论内容',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提交时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_activ_comm
-- ----------------------------
INSERT INTO `qs_sqk_activ_comm` VALUES ('1', '5', '58', '不错不错', '2017-06-09 09:55:16');
INSERT INTO `qs_sqk_activ_comm` VALUES ('2', '5', '61', '味道好极了', '2017-06-28 09:00:56');
INSERT INTO `qs_sqk_activ_comm` VALUES ('3', '9', '109', 'hxbxbxnsnn', '2018-04-11 11:32:30');
INSERT INTO `qs_sqk_activ_comm` VALUES ('4', '11', '109', '公积金理解', '2018-04-11 11:51:56');
INSERT INTO `qs_sqk_activ_comm` VALUES ('5', '12', '109', '吉里吉里控制', '2018-04-12 09:22:40');
INSERT INTO `qs_sqk_activ_comm` VALUES ('6', '11', '106', '例题一样', '2018-04-16 14:19:59');

-- ----------------------------
-- Table structure for `qs_sqk_activ_info`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_activ_info`;
CREATE TABLE `qs_sqk_activ_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属分类id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '归属社区',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布人id',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `content` text COMMENT '内容',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `start_time` datetime NOT NULL COMMENT '活动开始时间',
  `end_time` datetime NOT NULL COMMENT '活动结束时间',
  `link_name` varchar(50) NOT NULL COMMENT '活动联系人',
  `link_tel` varchar(20) NOT NULL COMMENT '活动联系电话',
  `read_ids` text COMMENT '已读人ids',
  `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读人数',
  `join_ids` text NOT NULL COMMENT '参加人ids',
  `join_num` int(11) NOT NULL DEFAULT '0' COMMENT '参加人数',
  `like_ids` text COMMENT '点赞人ids',
  `like_num` int(11) NOT NULL DEFAULT '0' COMMENT '点赞人数',
  `integral` int(11) NOT NULL DEFAULT '0' COMMENT '本次活动积分',
  `qrcode_path` varchar(50) DEFAULT NULL COMMENT '活动签到二维码地址',
  `is_publish` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布 0未发布 1发布',
  `is_open` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启活动  0 未开启，1 开启',
  `is_over` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否举办结束',
  `address` varchar(50) NOT NULL COMMENT '活动地址',
  `initiator` varchar(50) NOT NULL COMMENT '活动发起人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_activ_info
-- ----------------------------
INSERT INTO `qs_sqk_activ_info` VALUES ('7', '1', '0', '1', 'asdfasd', '12312312', '2018-04-04 09:11:15', '2018-04-05 00:00:00', '2018-04-05 00:00:00', '123123123', '13521445899', '', '0', '', '0', '', '0', '0', '', '1', '0', '0', '', '');
INSERT INTO `qs_sqk_activ_info` VALUES ('5', '2', '0', '73', '通州启动春季义务植树活动', '<p><img src=\"/ueditor/php/upload/image/20170421/1492767551607651.jpg\" title=\"1492767551607651.jpg\" alt=\"14658619.jpg\"/></p><p>参加义务植树活动的人员中，有400余名通州区劳动模范、优秀青年和优秀妇女代表，他们是通州发展的见证者和亲历者，今天更是以实际行动为城市副中心园林绿化建设贡献自己的一份力量。<br/><br/>义务植树活动所在的宋庄公园，中坝河穿园而过，规划面积882亩。公园规划范围内原为养殖小区、垃圾渣土和部分平原造林地块。根据总体规划，结合产业结构调整和环境综合整治，共拆除违法建设3.5万平方米，同时提升平原造林的景观效果和服务功能。<br/><br/>公园内栽植白皮松、油松、银杏、樱花、西府海棠等各类苗木2.2万余株，主要以“银杏千株，樱花万枝”为景观特色，3月下旬到4月下旬樱花盛放，着力打造“京东第一樱花园”。宋庄公园建成后，将与东郊森林公园、永顺刘庄公园、减河公园等公园绿地共同围合成56公里长的环城绿色休闲游憩环，为北京城市副中心打造绿色生态屏障。<br/><br/>下一步，区园林绿化局将以春季义务植树活动为序曲，围绕城市副中心的功能定位，将以创建国家森林城市和国家生态园林城市为目标，加快完成2016年42个续建工程建设，在此基础上，再启动实施园林绿化重点项目23个，加大城市副中心园林绿化建设力度，着力打造“水韵林海、蓝绿交织”的优美画卷，进一步彰显城市特色、提高城市魅力，增强城市吸引力。</p>', '2017-04-21 17:39:32', '2017-04-01 00:00:00', '2017-04-30 00:00:00', '张先生', '13000000000', ',31,58,61,62,68,', '12', '', '0', '', '0', '0', '', '1', '0', '0', '', '');
INSERT INTO `qs_sqk_activ_info` VALUES ('6', '1', '0', '1', '中央军委领导在通州参加义务植树活动', '<p><br/>公园内栽植白皮松、油松、银杏、樱花、西府海棠等各类苗木2.2万余株，主要以“银杏千株，樱花万枝”为景观特色，3月下旬到4月下旬樱花盛放，着力打造“京东第一樱花园”。宋庄公园建成后，将与东郊森林公园、永顺刘庄公园、减河公园等公园绿地共同围合成56公里长的环城绿色休闲游憩环，为北京城市副中心打造绿色生态屏障。<br/><br/>下一步，区园林绿化局将以春季义务植树活动为序曲，围绕城市副中心的功能定位，将以创建国家森林城市和国家生态园林城市为目标，加快完成2016年42个续建工程建设，在此基础上，再启动实施园林绿化重点项目23个，加大城市副中心园林绿化建设力度，着力打造“水韵林海、蓝绿交织”的优美画卷，进一步彰显城市特色、提高城市魅力，增强城市吸引力。</p><p><br/></p>', '2017-04-21 17:41:46', '2017-04-01 00:00:00', '2017-04-20 00:00:00', '李主任', '13022228888', ',31,58,61,62,63,68,109,', '28', ',61,', '1', ',58,61,', '2', '50', '', '1', '0', '0', '', '');
INSERT INTO `qs_sqk_activ_info` VALUES ('8', '1', '6', '1', '1231231231', '<p>13231</p>', '2018-04-04 16:44:32', '2018-04-14 00:00:00', '2018-04-18 00:00:00', '123', '13521447599', '', '0', '', '0', '', '0', '0', '', '1', '0', '0', '', '');
INSERT INTO `qs_sqk_activ_info` VALUES ('9', '2', '1', '73', '123123', '<p>sdfasdfas</p>', '2018-04-04 16:57:48', '2018-04-05 07:11:00', '2018-04-18 00:00:00', '12312', '13526985632', ',109,', '3', '', '0', '', '0', '50', '', '1', '0', '0', '', '');
INSERT INTO `qs_sqk_activ_info` VALUES ('10', '1', '0', '1', '如何在程序留下彩蛋？', '<p>上周末，我叫了个滴滴顺风车，从杭州去绍兴乔波滑雪。因为有个较大的雪板行李，因此我选择了不拼车。并增加了15元感谢费。没一会儿一个东北口音的司机打我电话称他比较远，需要我额外添加感谢费才能来接我。</p><p>我说我已经添加了感谢费15元，如果你没办法接的话，可以不用接单，我等下个顺路的司机即可。 该司机挂了选择了接了我的单。</p><p>上车后，司机问我怎么走， 我说我不赶时间，国道和高速都可。因司机的确从很远的地方赶来接我，我本着希望司机也能更早到家的心态，承诺如果走高速的话愿意承担15元过路费。</p><p>到达终点后，司机说过路费35元，需要我出。于是就有了视频中的那一幕。</p><p>司机扣着我的行李，不让我下车，并强行要我给他35元。并在我找人求助的时候，手持螺丝刀对我进行人生威胁。 我因而选择了报警。 注意看下面的视频 可以清晰的看到司机手持螺丝刀。</p><p><br/><br/>作者：LeonLuoJ<br/>链接：https://www.zhihu.com/question/26607538/answer/313040467<br/>来源：知乎<br/>著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。</p><p><br/></p>', '2018-04-08 11:35:59', '2018-04-08 00:00:00', '2018-04-12 00:00:00', '发生大幅', '13521447599', ',109,', '2', '', '0', null, '0', '50', null, '1', '0', '0', '', '');
INSERT INTO `qs_sqk_activ_info` VALUES ('11', '2', '0', '1', '关于开展工会文体活动的通知', '<p style=\"text-indent: 43px\"><strong><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">二、比赛方法及规则</span></strong></p><p style=\"text-indent: 43px\"><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">比赛方法及规则附后。如有问题可向各活动负责人咨询。</span></p><p style=\"text-indent: 43px\"><strong><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">三、奖项设置</span></strong></p><p style=\"text-indent: 43px\"><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">各项目均分别设置一定奖品。</span></p><p style=\"text-indent: 43px\"><strong><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">四、其他事项</span></strong></p><p style=\"text-indent: 43px\"><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">1</span><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">、</span><strong><span style=\"font-family: 仿宋_GB2312;font-size: 24px\">除拔河、套圈比赛外，参加其余各项活动，须在今日向各活动负责人报名。</span></strong></p><p style=\"text-indent: 43px\"><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">2</span><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">、室外活动完毕后，再开展室内活动。</span></p><p style=\"text-indent: 43px\"><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">3</span><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">、所有参赛者都要本着友谊第一、比赛第二的原则，既要赛出水平，又要赛出风格</span></p>', '2018-04-11 11:38:46', '2018-04-13 12:00:00', '2018-04-28 00:00:00', 'zhangsdjl', '13521445789', ',109,106,', '18', ',109,', '1', ',109,', '1', '50', null, '1', '0', '0', '', '');
INSERT INTO `qs_sqk_activ_info` VALUES ('12', '2', '0', '1', '小米Max2怎么样？小米Max2评测小米Max2怎么样？小米Max2评测', '<p style=\"margin: 20px 0px 0px; padding: 0px; color: rgb(0, 0, 0); font-family: 宋体, arial; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial;\">我们知道，小米Max2主打大屏长续航，搭载骁龙625八核处理器，前置500W+后置1200W像素摄像头，配备了一块6.44英寸的大屏幕，内置5300mAh充电宝级大电池，支持18W快充，深受很多大屏爱好者的喜欢。</p><p style=\"margin: 20px 0px 0px; padding: 0px; color: rgb(0, 0, 0); font-family: 宋体, arial; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial;\">　　该机推出了4+64GB和4+128GB两个版本，前者售价1699元，后者售价1999元，性价比还是非常不错的，不过有人希望还能够再便宜一点，毕竟很多人拿来做备用机+充电宝不需要太贵，那么或许你的愿望很快就能实现了。</p><p><br/></p>', '2018-04-11 15:23:12', '2018-04-21 10:25:00', '2018-04-27 08:29:00', '张晓炜', '13521447599', ',109,106,', '8', '', '0', ',109,', '1', '400', null, '1', '0', '0', '北京市通州区玉带河东街', '北京科协');

-- ----------------------------
-- Table structure for `qs_sqk_notice_cat`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_notice_cat`;
CREATE TABLE `qs_sqk_notice_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) DEFAULT NULL COMMENT '系统名称',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `parent_id_path` varchar(50) NOT NULL DEFAULT '' COMMENT '所属上级目录',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用 0：禁用，1：启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_notice_cat
-- ----------------------------
INSERT INTO `qs_sqk_notice_cat` VALUES ('1', 'meiyuetongzhi', '每月通知', '', '0', '2017-04-01 15:33:03', '1');
INSERT INTO `qs_sqk_notice_cat` VALUES ('2', 'linshitongzhi', '临时通知', '', '0', '2017-04-01 15:33:19', '1');
INSERT INTO `qs_sqk_notice_cat` VALUES ('3', 'jinjitongzhi', '紧急通知', '', '0', '2017-04-01 15:34:02', '1');

-- ----------------------------
-- Table structure for `qs_sqk_notice_info`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_notice_info`;
CREATE TABLE `qs_sqk_notice_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属分类id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '社区id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布人id',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `content` text COMMENT '内容',
  `is_publish` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布 0：未发布，1：发布',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `edit_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `read_ids` text COMMENT '已读人id',
  `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读人数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_notice_info
-- ----------------------------
INSERT INTO `qs_sqk_notice_info` VALUES ('13', '1', '1', '73', '234234', '234234', '1', '2018-04-04 16:19:35', '2018-04-16 14:37:56', ',106,', '5');
INSERT INTO `qs_sqk_notice_info` VALUES ('14', '1', '0', '1', 'fasdfa', 'fasdfasd', '0', '2018-04-09 14:49:43', '2018-04-09 14:49:43', ',', '0');
INSERT INTO `qs_sqk_notice_info` VALUES ('12', '2', '1', '1', '崔静北里', '发射点发', '1', '2018-04-04 16:17:11', '2018-04-16 14:37:58', ',109,106,', '3');

-- ----------------------------
-- Table structure for `qs_sqk_seller_cat`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_seller_cat`;
CREATE TABLE `qs_sqk_seller_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) DEFAULT NULL COMMENT '系统名称',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `parent_id_path` varchar(50) NOT NULL DEFAULT '' COMMENT '所属上级目录',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用 0：禁用，1：启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_seller_cat
-- ----------------------------
INSERT INTO `qs_sqk_seller_cat` VALUES ('2', 'fandian', '饭店类', '', '0', '2017-04-01 17:22:18', '1');
INSERT INTO `qs_sqk_seller_cat` VALUES ('3', 'fuwu', '服务类', '', '0', '2017-04-01 17:22:41', '1');
INSERT INTO `qs_sqk_seller_cat` VALUES ('4', 'hunqing', '婚庆类', '', '0', '2017-04-01 17:23:08', '1');
INSERT INTO `qs_sqk_seller_cat` VALUES ('5', 'jiazheng', '家政类', '', '0', '2017-04-01 17:23:33', '1');
INSERT INTO `qs_sqk_seller_cat` VALUES ('6', 'lingshou', '零售类', '', '0', '2017-04-01 17:23:48', '1');
INSERT INTO `qs_sqk_seller_cat` VALUES ('7', 'yaodian', '药店类', '', '0', '2017-04-01 17:24:04', '1');
INSERT INTO `qs_sqk_seller_cat` VALUES ('8', 'zaojiao', '早教类', '', '0', '2017-04-01 17:24:27', '1');
INSERT INTO `qs_sqk_seller_cat` VALUES ('9', 'yule', '娱乐类', '', '0', '2017-04-01 17:24:40', '1');
INSERT INTO `qs_sqk_seller_cat` VALUES ('10', 'lvguan', '旅馆类', '', '0', '2017-04-01 17:24:58', '1');
INSERT INTO `qs_sqk_seller_cat` VALUES ('11', 'meirong', '美容类', '', '0', '2017-04-01 17:25:13', '1');
INSERT INTO `qs_sqk_seller_cat` VALUES ('12', 'qita', '其他类', '', '0', '2017-04-01 17:25:25', '1');

-- ----------------------------
-- Table structure for `qs_sqk_seller_info`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_seller_info`;
CREATE TABLE `qs_sqk_seller_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属分类id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '社区id',
  `name` varchar(50) NOT NULL COMMENT '商家名称',
  `address` varchar(300) NOT NULL COMMENT '商家地址',
  `introduction` text COMMENT '商家介绍',
  `tel` varchar(20) NOT NULL COMMENT '商家电话',
  `logo_icon` varchar(300) DEFAULT NULL COMMENT '商家logo',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '添加人id',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `is_checked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否审核 0：未审核，1：审核通过',
  `is_rest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否歇业 0：未歇业，1：歇业',
  `work_start` time DEFAULT NULL COMMENT '营业时间 起',
  `work_end` time DEFAULT NULL COMMENT '营业时间 终',
  `business_license` varchar(300) DEFAULT NULL,
  `tax_registration` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_seller_info
-- ----------------------------
INSERT INTO `qs_sqk_seller_info` VALUES ('22', '6', '8', '京客隆', '北京市朝阳区管庄', '', '15010808823', '/seller/logo/2017-04-21/58f9cafc3ced7.jpg', '0', '2017-04-21 17:03:56', '1', '0', '08:00:00', '19:00:00', null, null);
INSERT INTO `qs_sqk_seller_info` VALUES ('23', '12', '2', '聚龙电器', '三河市燕郊富地广场', '', '010-7896541', '', '0', '2017-04-21 17:15:43', '1', '0', '10:00:00', '18:00:00', null, null);
INSERT INTO `qs_sqk_seller_info` VALUES ('24', '2', '3', '好味道', '河北省保定市定兴县', '', '15010808823', '/seller/logo/2017-04-21/58f9d22277eeb.jpg', '0', '2017-04-21 17:34:26', '1', '0', '10:00:00', '21:00:00', null, null);
INSERT INTO `qs_sqk_seller_info` VALUES ('25', '3', '4', '张晓炜', 's短发散发的', '<p>发射点发生</p>', '010-1234567', '/seller/logo/2018-04-11/5acd72db221f0.jpg', '0', '2018-04-10 11:19:57', '1', '0', '00:16:00', '00:29:00', null, null);
INSERT INTO `qs_sqk_seller_info` VALUES ('29', '2', '8', '田老师炖牛肉', '北京市海淀区苏州街5号', '<p>666</p><p>666</p><p>666</p>', '15687433456', '/seller/logo/2018-04-15/5ad2c96ca5e7c.png', '0', '2018-04-15 11:39:24', '1', '0', '06:00:00', '18:00:00', null, null);
INSERT INTO `qs_sqk_seller_info` VALUES ('28', '5', '6', '大河庄园', '北京市海淀区苏州街4号', '<p>666</p><p>666</p><p>666</p>', '15823456543', '/seller/logo/2018-04-15/5ad2c50c4356f.png', '0', '2018-04-15 11:20:44', '1', '0', '07:00:00', '17:17:00', null, null);
INSERT INTO `qs_sqk_seller_info` VALUES ('31', '3', '8', '京洲园商家1', '北京市海淀区苏州街6号', '<p>666</p>', '15673453457', '/seller/logo/2018-04-15/5ad2f5fc0f303.jpg', '0', '2018-04-15 14:49:32', '1', '0', '14:48:00', '21:00:00', null, null);
INSERT INTO `qs_sqk_seller_info` VALUES ('32', '3', '6', '葛布店东里商家1', '北京市丰台区纪通东路55号', '<p>哈哈哈哈</p><p>哈哈哈哈</p><p>哈哈哈哈</p>', '18934562345', '/seller/logo/2018-04-15/5ad30992c7a5c.jpg', '0', '2018-04-15 16:13:06', '1', '0', '08:00:00', '18:00:00', null, null);
INSERT INTO `qs_sqk_seller_info` VALUES ('33', '2', '1', '肯德基', '北京市通州区通州北苑万达广场', '<p>666<br/></p><p>666</p><p>666</p>', '15723457865', '/seller/logo/2018-04-16/5ad44fee0ab0c.jpg', '0', '2018-04-15 18:16:12', '1', '0', '08:00:00', '21:00:00', null, null);

-- ----------------------------
-- Table structure for `qs_sqk_seller_prom_info`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_seller_prom_info`;
CREATE TABLE `qs_sqk_seller_prom_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '社区id',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读人数',
  `read_ids` text COMMENT '已阅人id',
  `item_ids` text COMMENT '促销产品ids',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `start_time` datetime NOT NULL COMMENT '开始时间',
  `end_time` datetime NOT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_seller_prom_info
-- ----------------------------
INSERT INTO `qs_sqk_seller_prom_info` VALUES ('7', '31', '8', '限时秒杀', '<p>优惠不要错过哦</p>', '6', ',', ',39,', '2017-04-21 17:39:22', '2017-04-21 00:00:00', '2017-04-30 00:00:00');
INSERT INTO `qs_sqk_seller_prom_info` VALUES ('14', '22', '8', '京客隆促销1', '<p>666</p>', '0', ',', '', '2018-04-15 18:02:43', '2018-04-01 00:00:00', '2018-04-26 00:00:00');
INSERT INTO `qs_sqk_seller_prom_info` VALUES ('13', '31', '5', '新大院', '<p>666</p>', '0', ',', '', '2018-04-15 17:21:01', '2018-04-04 00:00:00', '2018-04-04 00:00:00');
INSERT INTO `qs_sqk_seller_prom_info` VALUES ('11', '24', '3', '好味道促销', '<p>666</p>', '0', ',', ',', '2018-04-15 15:42:14', '2018-04-01 00:00:00', '2018-04-15 00:00:00');
INSERT INTO `qs_sqk_seller_prom_info` VALUES ('12', '32', '6', '双十一半价', '<p>双十一半价，抓紧时间抢购啦！</p>', '0', ',', '', '2018-04-15 16:16:33', '2018-04-08 00:00:00', '2018-04-29 00:00:00');
INSERT INTO `qs_sqk_seller_prom_info` VALUES ('15', '31', '8', '京洲园商家1促销1', '<p>666</p>', '0', ',', '', '2018-04-15 18:06:46', '2018-04-01 00:00:00', '2018-04-03 00:00:00');
INSERT INTO `qs_sqk_seller_prom_info` VALUES ('16', '29', '8', '田老师红烧肉促销2', '<p>666</p>', '0', ',', '', '2018-04-15 18:09:01', '2018-04-05 00:00:00', '2018-04-30 00:00:00');
INSERT INTO `qs_sqk_seller_prom_info` VALUES ('17', '33', '1', '田老师红烧肉促销1', '<p>666</p>', '0', ',', '', '2018-04-15 18:11:11', '2018-04-01 00:00:00', '2018-04-30 00:00:00');
INSERT INTO `qs_sqk_seller_prom_info` VALUES ('18', '33', '1', '肯德基五一促销', '<p>肯德基五一促销啦！</p>', '0', ',', '', '2018-04-15 18:17:27', '2018-04-30 00:00:00', '2018-05-02 00:00:00');

-- ----------------------------
-- Table structure for `qs_sqk_sys_action_log`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_sys_action_log`;
CREATE TABLE `qs_sqk_sys_action_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_name` varchar(20) NOT NULL DEFAULT '0' COMMENT '用户',
  `c_name` varchar(50) NOT NULL COMMENT '控制器名称',
  `a_name` varchar(50) NOT NULL COMMENT '方法名称',
  `action_info` varchar(100) NOT NULL COMMENT '操作描述',
  `ip` varchar(15) NOT NULL COMMENT 'ip地址',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1735 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_sys_action_log
-- ----------------------------
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1283', '管理员', 'login', 'loginSys', '登录系统', '192.168.1.12', '2017-04-21 16:50:16');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1284', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '192.168.1.10', '2017-04-21 17:03:56');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1285', '管理员', 'SellerInfo', 'checkArrayInfo', '审核商家信息', '192.168.1.10', '2017-04-21 17:04:02');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1286', '管理员', 'SellerItemsCat', 'saveSellerItemsCat', '添加/编辑商家服务项目分类', '192.168.1.10', '2017-04-21 17:04:44');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1287', '管理员', 'SellerItemsCat', 'saveSellerItemsCat', '添加/编辑商家服务项目分类', '192.168.1.10', '2017-04-21 17:05:21');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1288', '管理员', 'SellerItemsInfo', 'saveSellerItems', '添加/编辑商家服务项目信息', '192.168.1.10', '2017-04-21 17:08:36');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1289', '管理员', 'SellerItemsInfo', 'saveSellerItems', '添加/编辑商家服务项目信息', '192.168.1.10', '2017-04-21 17:10:50');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1290', '管理员', 'SellerItemsInfo', 'checkArrayItemsInfo', '审核商家服务项目信息', '192.168.1.10', '2017-04-21 17:10:56');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1291', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '192.168.1.10', '2017-04-21 17:15:43');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1292', '管理员', 'SellerInfo', 'checkArrayInfo', '审核商家信息', '192.168.1.10', '2017-04-21 17:15:50');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1293', '管理员', 'SellerItemsCat', 'saveSellerItemsCat', '添加/编辑商家服务项目分类', '192.168.1.10', '2017-04-21 17:16:20');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1294', '管理员', 'SellerItemsInfo', 'saveSellerItems', '添加/编辑商家服务项目信息', '192.168.1.10', '2017-04-21 17:19:26');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1295', '管理员', 'SellerItemsInfo', 'checkArrayItemsInfo', '审核商家服务项目信息', '192.168.1.10', '2017-04-21 17:19:32');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1296', '管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '192.168.1.12', '2017-04-21 17:19:45');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1297', '管理员', 'SellerItemsInfo', 'saveSellerItems', '添加/编辑商家服务项目信息', '192.168.1.10', '2017-04-21 17:20:44');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1298', '管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '192.168.1.12', '2017-04-21 17:20:53');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1299', '管理员', 'NoticeInfo', 'publNoticeInfo', '发布通知信息', '192.168.1.12', '2017-04-21 17:21:00');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1300', '管理员', 'NoticeInfo', 'publNoticeInfo', '发布通知信息', '192.168.1.12', '2017-04-21 17:21:04');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1301', '管理员', 'SellerItemsInfo', 'saveSellerItems', '添加/编辑商家服务项目信息', '192.168.1.10', '2017-04-21 17:22:06');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1302', '管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '192.168.1.12', '2017-04-21 17:22:22');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1303', '管理员', 'NoticeInfo', 'publNoticeInfo', '发布通知信息', '192.168.1.12', '2017-04-21 17:22:30');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1304', '管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '192.168.1.12', '2017-04-21 17:24:24');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1305', '管理员', 'NoticeInfo', 'publNoticeInfo', '发布通知信息', '192.168.1.12', '2017-04-21 17:24:38');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1306', '管理员', 'login', 'loginSys', '登录系统', '192.168.1.12', '2017-04-21 17:30:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1307', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '192.168.1.12', '2017-04-21 17:32:44');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1308', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '192.168.1.12', '2017-04-21 17:33:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1309', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '192.168.1.12', '2017-04-21 17:33:42');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1310', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '192.168.1.12', '2017-04-21 17:34:05');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1311', '管理员', 'ActivCat', 'publishArrayInfo', '发布社区活动信息', '192.168.1.12', '2017-04-21 17:34:10');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1312', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '192.168.1.10', '2017-04-21 17:34:26');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1313', '管理员', 'SellerInfo', 'checkArrayInfo', '审核商家信息', '192.168.1.10', '2017-04-21 17:34:33');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1314', '管理员', 'SellerItemsInfo', 'checkArrayItemsInfo', '审核商家服务项目信息', '192.168.1.10', '2017-04-21 17:34:47');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1315', '管理员', 'HelpInfo', 'saveHelpInfo', '添加/编辑联系人信息', '192.168.1.12', '2017-04-21 17:35:06');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1316', '管理员', 'SellerItemsCat', 'saveSellerItemsCat', '添加/编辑商家服务项目分类', '192.168.1.10', '2017-04-21 17:35:50');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1317', '管理员', 'HelpInfo', 'saveHelpInfo', '添加/编辑联系人信息', '192.168.1.12', '2017-04-21 17:35:55');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1318', '管理员', 'HelpInfo', 'saveHelpInfo', '添加/编辑联系人信息', '192.168.1.12', '2017-04-21 17:36:46');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1319', '管理员', 'SellerItemsInfo', 'saveSellerItems', '添加/编辑商家服务项目信息', '192.168.1.10', '2017-04-21 17:36:59');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1320', '管理员', 'SellerItemsInfo', 'checkArrayItemsInfo', '审核商家服务项目信息', '192.168.1.10', '2017-04-21 17:37:07');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1321', '管理员', 'SellerItemsInfo', 'saveSellerItems', '添加/编辑商家服务项目信息', '192.168.1.10', '2017-04-21 17:38:30');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1322', '管理员', 'SellerItemsInfo', 'checkArrayItemsInfo', '审核商家服务项目信息', '192.168.1.10', '2017-04-21 17:38:36');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1323', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '192.168.1.12', '2017-04-21 17:39:32');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1324', '管理员', 'ActivCat', 'publishArrayInfo', '发布社区活动信息', '192.168.1.12', '2017-04-21 17:39:39');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1325', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '192.168.1.12', '2017-04-21 17:41:46');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1326', '管理员', 'ActivCat', 'publishArrayInfo', '发布社区活动信息', '192.168.1.12', '2017-04-21 17:41:51');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1327', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-04-24 10:09:39');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1328', '管理员', 'login', 'logout', '退出系统', '222.128.67.79', '2017-04-24 15:19:04');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1329', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-04-27 10:56:22');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1330', '管理员', 'login', 'loginSys', '登录系统', '123.115.0.239', '2017-04-27 14:57:06');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1331', '管理员', 'login', 'logout', '退出系统', '123.115.0.239', '2017-04-27 14:59:35');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1332', '管理员', 'login', 'loginSys', '登录系统', '123.115.0.239', '2017-04-27 15:16:23');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1333', '管理员', 'SellerOrderInfo', 'dealSellerOrderInfo', '处理商家订单', '123.115.0.239', '2017-04-27 15:56:42');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1334', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-04-28 16:03:19');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1335', '管理员', 'DeviceInfo', 'saveDeviceInfoCat', '添加/编辑体检设备', '222.128.67.79', '2017-04-28 16:04:09');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1336', '管理员', 'login', 'loginSys', '登录系统', '61.49.252.140', '2017-05-08 14:11:34');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1337', '管理员', 'login', 'logout', '退出系统', '61.49.252.140', '2017-05-08 14:13:54');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1338', '管理员', 'login', 'loginSys', '登录系统', '61.49.252.140', '2017-05-08 14:14:12');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1339', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-05-09 10:39:20');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1340', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-05-09 10:39:21');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1341', '管理员', 'login', 'loginSys', '登录系统', '123.113.246.130', '2017-05-09 13:39:51');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1342', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-05-09 14:25:17');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1343', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-05-15 11:32:17');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1344', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-05-15 11:33:01');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1345', '管理员', 'login', 'loginSys', '登录系统', '125.34.161.23', '2017-05-23 14:00:53');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1346', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-05-24 15:02:36');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1347', '管理员', 'login', 'logout', '退出系统', '222.128.67.79', '2017-05-24 16:24:35');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1348', '社区管理员69', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-05-24 16:25:11');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1349', '管理员', 'login', 'loginSys', '登录系统', '221.216.15.75', '2017-05-24 17:20:52');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1350', '管理员', 'login', 'loginSys', '登录系统', '221.216.15.75', '2017-05-24 17:33:48');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1351', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-05-26 10:44:43');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1352', '管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '222.128.67.79', '2017-05-26 11:01:35');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1353', '管理员', 'NoticeInfo', 'publNoticeInfo', '发布通知信息', '222.128.67.79', '2017-05-26 11:01:39');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1354', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '222.128.67.79', '2017-05-26 11:05:34');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1355', '管理员', 'login', 'logout', '退出系统', '222.128.67.79', '2017-05-26 11:05:40');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1356', '物业测试001', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-05-26 11:05:54');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1357', '物业测试001', 'login', 'logout', '退出系统', '222.128.67.79', '2017-05-26 11:07:06');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1358', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-05-26 11:07:28');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1359', '管理员', 'HealthnCat', 'saveHealthCat', '添加/编辑健康知识分类', '222.128.67.79', '2017-05-26 11:30:00');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1360', '管理员', 'HealthnInfo', 'saveHealthInfo', '添加/编辑健康知识信息', '222.128.67.79', '2017-05-26 11:32:36');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1361', '管理员', 'HealthnInfo', 'publHealthInfo', '发布健康知识信息', '222.128.67.79', '2017-05-26 11:32:42');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1362', '管理员', 'HealthnInfo', 'saveHealthInfo', '添加/编辑健康知识信息', '222.128.67.79', '2017-05-26 11:35:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1363', '管理员', 'HealthnInfo', 'publHealthInfo', '发布健康知识信息', '222.128.67.79', '2017-05-26 11:35:22');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1364', '管理员', 'HealthnInfo', 'saveHealthInfo', '添加/编辑健康知识信息', '222.128.67.79', '2017-05-26 11:35:53');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1365', '管理员', 'HealthnInfo', 'saveHealthInfo', '添加/编辑健康知识信息', '222.128.67.79', '2017-05-26 11:36:24');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1366', '管理员', 'HealthnInfo', 'saveHealthInfo', '添加/编辑健康知识信息', '222.128.67.79', '2017-05-26 11:38:28');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1367', '管理员', 'HealthnInfo', 'saveHealthInfo', '添加/编辑健康知识信息', '222.128.67.79', '2017-05-26 11:39:12');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1368', '管理员', 'HealthnInfo', 'saveHealthInfo', '添加/编辑健康知识信息', '222.128.67.79', '2017-05-26 11:39:36');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1369', '管理员', 'HealthnInfo', 'publHealthInfo', '发布健康知识信息', '222.128.67.79', '2017-05-26 11:39:58');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1370', '管理员', 'HealthnInfo', 'saveHealthInfo', '添加/编辑健康知识信息', '222.128.67.79', '2017-05-26 11:40:56');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1371', '管理员', 'HealthnInfo', 'publHealthInfo', '发布健康知识信息', '222.128.67.79', '2017-05-26 11:41:06');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1372', '管理员', 'HealthnInfo', 'saveHealthInfo', '添加/编辑健康知识信息', '222.128.67.79', '2017-05-26 11:42:33');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1373', '管理员', 'HealthnInfo', 'publHealthInfo', '发布健康知识信息', '222.128.67.79', '2017-05-26 11:42:42');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1374', '管理员', 'HealthnCat', 'saveHealthCat', '添加/编辑健康知识分类', '222.128.67.79', '2017-05-26 11:43:38');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1375', '管理员', 'login', 'loginSys', '登录系统', '123.114.249.207', '2017-05-26 13:15:31');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1376', '管理员', 'HealthnCat', 'saveHealthCat', '添加/编辑健康知识分类', '123.114.249.207', '2017-05-26 13:20:13');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1377', '管理员', 'login', 'loginSys', '登录系统', '123.114.249.207', '2017-05-26 13:27:42');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1378', '管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '123.114.249.207', '2017-05-26 13:28:10');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1379', '管理员', 'login', 'loginSys', '登录系统', '123.114.249.207', '2017-05-26 16:03:28');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1380', '管理员', 'login', 'logout', '退出系统', '222.128.67.79', '2017-06-01 09:12:03');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1381', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-06-09 08:48:51');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1382', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-06-09 16:51:19');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1383', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-06-12 08:41:04');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1384', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-06-13 10:52:46');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1385', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-06-15 14:33:41');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1386', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-06-16 08:57:20');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1387', '管理员', 'login', 'loginSys', '登录系统', '123.127.181.171', '2017-06-27 15:57:19');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1388', '管理员', 'login', 'loginSys', '登录系统', '123.127.181.171', '2017-06-27 16:16:55');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1389', '管理员', 'login', 'loginSys', '登录系统', '222.128.67.79', '2017-06-28 08:40:02');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1390', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2017-07-24 10:08:05');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1391', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2017-11-13 14:47:09');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1392', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2017-11-13 14:48:29');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1393', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-03 11:44:11');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1394', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-03 13:11:49');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1395', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-03 13:12:27');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1396', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-03 13:14:04');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1397', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-03 13:14:54');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1398', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-03 13:16:00');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1399', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-03 13:16:24');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1400', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-03 13:44:41');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1401', '管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '127.0.0.1', '2018-04-03 14:18:16');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1402', '管理员', 'NoticeInfo', 'publNoticeInfo', '发布通知信息', '127.0.0.1', '2018-04-03 14:18:20');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1403', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-03 14:20:55');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1404', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-03 14:21:01');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1405', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-03 14:22:21');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1406', '管理员', 'ActivCat', 'showJoinList', '查看参加活动人数', '127.0.0.1', '2018-04-03 14:43:44');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1407', '管理员', 'ActivCat', 'delArrayInfo', '删除社区活动信息', '127.0.0.1', '2018-04-03 14:44:06');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1408', '管理员', 'ActivCat', 'publishArrayInfo', '发布社区活动信息', '127.0.0.1', '2018-04-03 14:46:15');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1409', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-03 15:07:16');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1410', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-03 15:07:28');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1411', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-03 15:07:39');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1412', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-03 16:40:54');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1413', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-03 16:40:55');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1414', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-03 16:40:59');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1415', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-03 16:42:53');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1416', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-03 16:46:15');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1417', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-03 16:47:12');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1418', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-03 16:47:25');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1419', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-03 16:47:31');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1420', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-03 17:00:54');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1421', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-03 17:01:09');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1422', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-03 17:02:33');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1423', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 08:47:55');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1424', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 09:05:25');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1425', '管理员', 'SysUserInfo', 'delArrUserInfo', '删除用户信息', '127.0.0.1', '2018-04-04 09:09:49');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1426', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-04 09:11:15');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1427', '管理员', 'ActivCat', 'publishArrayInfo', '发布社区活动信息', '127.0.0.1', '2018-04-04 09:11:21');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1428', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-04 09:16:46');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1429', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-04 13:09:00');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1430', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 13:09:26');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1431', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-04 13:12:08');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1432', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 13:12:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1433', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 13:12:52');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1434', '翠景北里-管理员', 'ActivCat', 'showJoinList', '查看参加活动人数', '127.0.0.1', '2018-04-04 13:41:44');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1435', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-04 14:06:07');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1436', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-04 14:12:00');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1437', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-04 14:12:01');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1438', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-04 14:12:01');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1439', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-04 14:12:05');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1440', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-04 14:12:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1441', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-04 14:14:50');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1442', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-04 14:30:45');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1443', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-04 14:30:51');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1444', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-04 14:30:55');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1445', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-04 14:34:05');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1446', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-04 14:34:10');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1447', '翠景北里-管理员', 'ActivCat', 'showJoinList', '查看参加活动人数', '127.0.0.1', '2018-04-04 14:46:27');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1448', '翠景北里-管理员', 'ActivCat', 'showJoinList', '查看参加活动人数', '127.0.0.1', '2018-04-04 14:46:30');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1449', '翠景北里-管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-04 14:46:40');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1450', '翠景北里-管理员', 'ActivCat', 'delArrayInfo', '删除社区活动信息', '127.0.0.1', '2018-04-04 14:47:25');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1451', '翠景北里-管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '127.0.0.1', '2018-04-04 14:58:28');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1452', '翠景北里-管理员', 'NoticeInfo', 'publNoticeInfo', '发布通知信息', '127.0.0.1', '2018-04-04 14:59:09');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1453', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-04 15:03:14');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1454', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 15:03:25');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1455', '翠景北里-管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '127.0.0.1', '2018-04-04 15:04:08');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1456', '翠景北里-管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '127.0.0.1', '2018-04-04 15:14:49');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1457', '翠景北里-管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '127.0.0.1', '2018-04-04 15:18:02');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1458', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-04 15:18:06');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1459', '翠屏北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 15:18:15');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1460', '翠屏北里-管理员', 'NoticeInfo', 'publNoticeInfo', '发布通知信息', '127.0.0.1', '2018-04-04 15:18:24');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1461', '翠屏北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-04 15:26:38');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1462', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 15:26:42');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1463', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-04 15:40:41');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1464', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 15:40:47');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1465', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-04 15:41:55');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1466', '云景里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 15:42:06');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1467', '云景里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-04 16:14:59');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1468', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 16:15:03');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1469', '管理员', 'NoticeInfo', 'delArrayInfo', '删除通知信息', '127.0.0.1', '2018-04-04 16:15:27');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1470', '管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '127.0.0.1', '2018-04-04 16:15:53');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1471', '管理员', 'NoticeInfo', 'publNoticeInfo', '发布通知信息', '127.0.0.1', '2018-04-04 16:16:00');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1472', '管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '127.0.0.1', '2018-04-04 16:17:11');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1473', '管理员', 'NoticeInfo', 'publNoticeInfo', '发布通知信息', '127.0.0.1', '2018-04-04 16:17:51');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1474', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-04 16:19:02');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1475', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 16:19:13');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1476', '翠景北里-管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '127.0.0.1', '2018-04-04 16:19:35');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1477', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-04 16:25:04');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1478', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 16:25:09');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1479', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-04 16:29:20');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1480', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 16:29:38');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1481', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-04 16:44:32');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1482', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-04 16:53:45');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1483', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-04 16:56:52');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1484', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 16:57:08');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1485', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-04 16:57:48');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1486', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-04 16:57:58');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1487', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 16:58:20');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1488', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-04 17:35:08');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1489', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-08 08:41:19');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1490', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-08 09:31:24');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1491', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-08 09:31:38');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1492', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-08 09:34:46');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1493', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-08 09:34:50');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1494', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-08 09:41:24');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1495', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-08 09:41:40');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1496', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-08 09:44:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1497', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-08 10:38:45');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1498', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-08 10:55:26');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1499', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-08 10:56:16');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1500', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-08 10:56:19');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1501', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-08 10:56:22');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1502', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-08 10:58:03');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1503', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-08 10:58:19');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1504', '翠景北里-管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-08 11:35:59');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1505', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-08 11:53:43');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1506', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-08 15:15:41');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1507', '翠景北里-管理员', 'ActivCat', 'publishArrayInfo', '发布社区活动信息', '127.0.0.1', '2018-04-08 15:57:35');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1508', '翠景北里-管理员', 'ActivInfo', 'overArrayInfo', '批量结束活动信息', '127.0.0.1', '2018-04-08 16:46:27');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1509', '翠景北里-管理员', 'ActivInfo', 'overArrayInfo', '批量结束活动信息', '127.0.0.1', '2018-04-08 16:46:35');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1510', '翠景北里-管理员', 'ActivCat', 'publishArrayInfo', '发布社区活动信息', '127.0.0.1', '2018-04-08 16:46:47');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1511', '翠景北里-管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-08 17:37:42');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1512', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-09 08:52:44');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1513', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-09 09:44:25');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1514', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-09 09:44:36');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1515', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-09 09:45:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1516', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-09 09:57:50');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1517', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-09 10:04:12');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1518', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-09 10:04:17');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1519', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-09 14:16:10');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1520', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-09 14:16:27');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1521', '翠景北里-管理员', 'NoticeInfo', 'delArrayInfo', '删除通知信息', '127.0.0.1', '2018-04-09 14:46:00');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1522', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-09 14:49:22');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1523', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-09 14:49:27');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1524', '管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '127.0.0.1', '2018-04-09 14:49:43');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1525', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-09 14:49:49');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1526', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-09 14:49:56');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1527', '翠景北里-管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-09 16:38:15');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1528', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-10 08:50:19');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1529', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-10 09:19:43');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1530', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-10 09:19:53');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1531', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-10 10:03:40');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1532', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-10 10:03:49');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1533', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 10:09:25');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1534', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 10:09:28');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1535', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 10:09:35');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1536', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 10:09:48');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1537', '管理员', 'NoticeCat', 'saveNoticeCat', '添加/编辑通知分类', '127.0.0.1', '2018-04-10 10:25:34');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1538', '管理员', 'NoticeCat', 'saveNoticeCat', '添加/编辑通知分类', '127.0.0.1', '2018-04-10 10:25:39');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1539', '管理员', 'NoticeCat', 'saveNoticeCat', '添加/编辑通知分类', '127.0.0.1', '2018-04-10 10:25:45');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1540', '管理员', 'NoticeCat', 'saveNoticeCat', '添加/编辑通知分类', '127.0.0.1', '2018-04-10 10:26:09');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1541', '管理员', 'NoticeCat', 'saveNoticeCat', '添加/编辑通知分类', '127.0.0.1', '2018-04-10 10:26:14');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1542', '管理员', 'NoticeCat', 'saveNoticeCat', '添加/编辑通知分类', '127.0.0.1', '2018-04-10 10:26:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1543', '管理员', 'ActivCat', 'delActivCat', '删除社区活动分类', '127.0.0.1', '2018-04-10 10:37:04');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1544', '管理员', 'ActivCat', 'saveActivCat', '添加/编辑社区活动分类', '127.0.0.1', '2018-04-10 10:37:10');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1545', '管理员', 'ActivCat', 'saveActivCat', '添加/编辑社区活动分类', '127.0.0.1', '2018-04-10 10:37:15');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1546', '管理员', 'SellerInfo', 'checkArrayInfo', '审核商家信息', '127.0.0.1', '2018-04-10 11:02:09');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1547', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-10 11:19:57');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1548', '管理员', 'SellerInfo', 'checkArrayInfo', '审核商家信息', '127.0.0.1', '2018-04-10 11:20:15');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1549', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 11:43:08');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1550', '管理员', 'SysUserInfo', 'delArrUserInfo', '删除用户信息', '127.0.0.1', '2018-04-10 11:46:38');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1551', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 11:47:15');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1552', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 11:50:42');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1553', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 11:53:13');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1554', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 11:53:29');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1555', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 11:53:29');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1556', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 11:53:35');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1557', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 11:53:40');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1558', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 11:55:52');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1559', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 11:55:58');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1560', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-10 11:56:05');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1561', '管理员', 'ActivCat', 'showJoinList', '查看参加活动人数', '127.0.0.1', '2018-04-10 13:16:12');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1562', '管理员', 'ActivCat', 'showJoinList', '查看参加活动人数', '127.0.0.1', '2018-04-10 13:16:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1563', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-11 09:44:03');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1564', '管理员', 'ActivInfo', 'overArrayInfo', '批量结束活动信息', '127.0.0.1', '2018-04-11 09:45:42');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1565', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-11 10:07:08');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1566', '翠景北里-管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 10:18:13');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1567', '翠景北里-管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 10:28:43');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1568', '翠景北里-管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 10:30:04');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1569', '翠景北里-管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 10:36:10');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1570', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-11 11:05:05');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1571', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-11 11:07:30');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1572', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-11 11:07:36');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1573', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-11 11:38:46');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1574', '管理员', 'ActivCat', 'publishArrayInfo', '发布社区活动信息', '127.0.0.1', '2018-04-11 11:38:52');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1575', '管理员', 'ActivCat', 'publishArrayInfo', '发布社区活动信息', '127.0.0.1', '2018-04-11 13:14:44');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1576', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 13:29:58');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1577', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 13:56:14');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1578', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 13:56:22');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1579', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 13:56:52');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1580', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 13:58:52');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1581', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-11 14:03:13');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1582', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-11 14:03:26');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1583', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-11 14:05:12');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1584', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-11 14:05:20');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1585', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 14:19:24');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1586', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 14:19:33');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1587', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 14:25:16');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1588', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 14:30:32');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1589', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 14:30:51');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1590', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 14:33:27');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1591', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 14:34:55');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1592', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 14:35:24');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1593', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 14:40:17');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1594', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 15:02:51');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1595', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 15:10:22');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1596', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 15:12:44');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1597', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 15:13:57');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1598', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 15:15:04');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1599', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-11 15:23:13');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1600', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 15:33:36');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1601', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 15:46:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1602', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-11 15:47:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1603', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-11 16:32:21');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1604', '管理员', 'ActivCat', 'showJoinList', '查看参加活动人数', '127.0.0.1', '2018-04-11 16:48:21');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1605', '管理员', 'ActivCat', 'showJoinList', '查看参加活动人数', '127.0.0.1', '2018-04-11 16:48:28');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1606', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-11 16:52:57');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1607', '管理员', 'ActivCat', 'publishArrayInfo', '发布社区活动信息', '127.0.0.1', '2018-04-11 16:53:02');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1608', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-11 16:53:46');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1609', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-11 17:12:54');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1610', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-11 17:28:38');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1611', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-12 09:21:02');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1612', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-12 09:21:57');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1613', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-12 09:32:48');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1614', '管理员', 'NoticeInfo', 'publNoticeInfo', '发布通知信息', '127.0.0.1', '2018-04-12 09:38:36');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1615', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-12 11:59:25');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1616', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-12 13:35:05');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1617', '管理员', 'SellerInfo', 'delArraySellerInfo', '删除商家信息', '127.0.0.1', '2018-04-12 13:36:43');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1618', '管理员', 'ActivInfo', 'saveActivInfo', '添加/编辑社区活动信息', '127.0.0.1', '2018-04-12 13:45:59');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1619', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-12 15:57:40');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1620', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-12 15:58:07');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1621', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-12 15:59:46');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1622', '翠屏南里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-12 15:59:56');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1623', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-13 08:44:39');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1624', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-13 11:52:06');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1625', '管理员', 'SysUserInfo', 'delArrUserInfo', '删除用户信息', '127.0.0.1', '2018-04-13 11:52:13');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1626', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-13 11:56:23');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1627', '管理员', 'SysUserInfo', 'delArrUserInfo', '删除用户信息', '127.0.0.1', '2018-04-13 13:21:53');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1628', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-13 13:26:08');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1629', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-13 13:44:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1630', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-13 13:45:29');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1631', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-13 13:49:20');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1632', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-13 13:49:26');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1633', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-13 13:51:57');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1634', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑用户信息', '127.0.0.1', '2018-04-13 14:07:07');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1635', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-13 14:08:05');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1636', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-13 14:08:08');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1637', '管理员', 'SysUserInfo', 'saveUserInfo', '添加/编辑居民用户信息', '127.0.0.1', '2018-04-13 14:08:36');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1638', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-13 15:43:27');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1639', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-13 15:43:36');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1640', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-13 15:46:17');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1641', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-13 16:53:30');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1642', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-13 17:04:13');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1643', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-13 18:52:26');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1644', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 09:46:13');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1645', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-15 10:27:27');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1646', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-15 10:33:51');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1647', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-15 11:14:04');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1648', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 11:15:07');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1649', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 11:15:55');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1650', '翠景北里-管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-15 11:20:44');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1651', '翠景北里-管理员', 'SellerInfo', 'checkArrayInfo', '审核商家信息', '127.0.0.1', '2018-04-15 11:21:22');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1652', '翠景北里-管理员', 'SellerInfo', 'delArraySellerInfo', '删除商家信息', '127.0.0.1', '2018-04-15 11:22:45');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1653', '翠景北里-管理员', 'SellerCat', 'saveSellerCat', '添加/编辑商家分类', '127.0.0.1', '2018-04-15 11:37:25');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1654', '翠景北里-管理员', 'SellerCat', 'saveSellerCat', '添加/编辑商家分类', '127.0.0.1', '2018-04-15 11:37:39');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1655', '翠景北里-管理员', 'SellerCat', 'delSellerCat', '删除商家分类', '127.0.0.1', '2018-04-15 11:37:44');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1656', '翠景北里-管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-15 11:39:24');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1657', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 11:43:06');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1658', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 11:43:11');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1659', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 12:54:55');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1660', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 12:55:00');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1661', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 12:59:58');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1662', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 13:00:02');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1663', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 13:05:19');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1664', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 13:05:23');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1665', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 13:15:01');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1666', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 13:15:05');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1667', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 14:03:12');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1668', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 14:03:15');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1669', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 14:09:04');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1670', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 14:09:08');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1671', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 14:21:04');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1672', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 14:21:10');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1673', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 14:21:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1674', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 14:21:21');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1675', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-15 14:29:06');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1676', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-15 14:36:42');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1677', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 14:36:51');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1678', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 14:36:53');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1679', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 14:37:01');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1680', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 14:37:04');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1681', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 14:46:57');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1682', '京洲园-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 14:47:01');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1683', '京洲园-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 14:47:32');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1684', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 14:47:36');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1685', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-15 14:47:50');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1686', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 14:47:56');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1687', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 14:47:59');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1688', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 14:48:23');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1689', '京洲园-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 14:48:26');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1690', '京洲园-管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-15 14:49:32');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1691', '京洲园-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 14:49:53');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1692', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 14:49:57');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1693', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 15:03:15');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1694', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 15:03:18');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1695', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 15:03:39');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1696', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 15:03:42');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1697', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-15 16:13:06');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1698', '管理员', 'SellerInfo', 'checkArrayInfo', '审核商家信息', '127.0.0.1', '2018-04-15 16:15:43');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1699', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 17:05:53');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1700', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 17:05:56');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1701', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 17:08:32');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1702', '京洲园-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 17:08:35');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1703', '京洲园-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 17:09:32');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1704', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 17:09:35');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1705', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 17:35:12');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1706', '京洲园-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 17:35:16');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1707', '京洲园-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 18:14:30');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1708', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 18:14:35');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1709', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-15 18:16:12');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1710', '管理员', 'SellerInfo', 'checkArrayInfo', '审核商家信息', '127.0.0.1', '2018-04-15 18:16:32');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1711', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 19:02:26');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1712', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-15 19:02:30');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1713', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-15 19:03:16');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1714', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-16 10:03:27');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1715', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-16 11:16:16');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1716', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-16 11:16:27');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1717', '翠景北里-管理员', 'SysUserInfo', 'setUserAppUfNum', '居民用户绑定实体卡', '127.0.0.1', '2018-04-16 14:05:51');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1718', '翠景北里-管理员', 'SysUserInfo', 'setUserAppUfNum', '居民用户绑定实体卡', '127.0.0.1', '2018-04-16 14:06:41');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1719', '翠景北里-管理员', 'SysUserInfo', 'setUserAppUfNum', '居民用户绑定实体卡', '127.0.0.1', '2018-04-16 14:07:31');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1720', '翠景北里-管理员', 'SysUserInfo', 'setUserAppUfNum', '居民用户绑定实体卡', '127.0.0.1', '2018-04-16 14:12:20');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1721', '翠景北里-管理员', 'SysUserInfo', 'setUserAppUfNum', '居民用户绑定实体卡', '127.0.0.1', '2018-04-16 14:13:13');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1722', '翠景北里-管理员', 'SysUserInfo', 'setUserAppUfNum', '居民用户绑定实体卡', '127.0.0.1', '2018-04-16 14:16:05');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1723', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-16 14:52:24');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1724', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-16 14:52:30');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1725', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-16 15:20:06');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1726', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-16 15:25:34');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1727', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-16 15:25:47');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1728', '翠景北里-管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-16 15:26:00');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1729', '翠景北里-管理员', 'SysUserInfo', 'setUserAppUfNum', '居民用户绑定实体卡', '127.0.0.1', '2018-04-16 15:26:40');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1730', '翠景北里-管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2018-04-16 15:43:13');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1731', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-16 15:43:20');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1732', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2018-04-16 17:28:23');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1733', '管理员', 'SellerInfo', 'saveSellerInfo', '添加/编辑商家信息', '127.0.0.1', '2018-04-16 17:32:17');
INSERT INTO `qs_sqk_sys_action_log` VALUES ('1734', '管理员', 'SellerInfo', 'checkArrayInfo', '审核商家信息', '127.0.0.1', '2018-04-16 17:32:30');

-- ----------------------------
-- Table structure for `qs_sqk_sys_all_attach`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_sys_all_attach`;
CREATE TABLE `qs_sqk_sys_all_attach` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `module_name` varchar(50) NOT NULL COMMENT '控制器名称',
  `module_info_id` int(11) NOT NULL DEFAULT '0' COMMENT '模块内容id',
  `file_path` tinytext NOT NULL COMMENT '附件路径',
  `file_real_name` varchar(100) NOT NULL COMMENT '附件真实名称',
  `file_ext` varchar(10) NOT NULL COMMENT '附件后缀',
  `file_size` varchar(50) NOT NULL COMMENT '附件大小',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=259 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_sys_all_attach
-- ----------------------------
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('148', 'activity', '1', 'Public/Upload/activity/2017-04-21/58f9d1ba87922.jpg', '10856797.jpg', 'jpg', '244555');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('149', 'activity', '2', 'Public/Upload/activity/2017-04-21/58f9d1dcf146b.jpg', '10856798.jpg', 'jpg', '167945');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('150', 'activity', '3', 'Public/Upload/activity/2017-04-21/58f9d1f43f9f7.jpg', '10856799.jpg', 'jpg', '191036');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('151', 'activity', '4', 'Public/Upload/activity/2017-04-21/58f9d20bdc727.jpg', '14345487.jpg', 'jpg', '144067');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('155', 'activity', '7', 'Public/Upload/activity/2018-04-04/5ac4261fa91b3.jpg', '02.jpg', 'jpg', '162884');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('156', 'activity', '7', 'Public/Upload/activity/2018-04-04/5ac42622103f3.jpg', '2a5ac85aaaa2d951-48ebc1dba4f3112d-7022ab585b7468744cee99e7cfc47231.jpg', 'jpg', '28323');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('157', 'activity', '7', 'Public/Upload/activity/2018-04-04/5ac426250f2c2.png', '003.png', 'png', '622227');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('167', 'activity', '5', 'Public/Upload/activity/2018-04-04/5ac474ced03e2.jpg', '04.jpg', 'jpg', '103203');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('168', 'activity', '8', 'Public/Upload/activity/2018-04-04/5ac4906eb9f32.png', '004.png', 'png', '732789');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('169', 'activity', '9', 'Public/Upload/activity/2018-04-04/5ac493895406d.png', '004.png', 'png', '732789');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('170', 'activity', '9', 'Public/Upload/activity/2018-04-04/5ac49389bb18e.jpg', '7.jpg', 'jpg', '181972');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('171', 'activity', '9', 'Public/Upload/activity/2018-04-04/5ac49389d43c1.jpg', '08.jpg', 'jpg', '89214');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('176', 'activity', '11', 'Public/Upload/activity/2018-04-11/5acd833d494d2.PNG', '002.PNG', 'PNG', '877563');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('177', 'activity', '11', 'Public/Upload/activity/2018-04-11/5acd8343259be.jpg', '03.jpg', 'jpg', '104996');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('178', 'activity', '11', 'Public/Upload/activity/2018-04-11/5acd83434031a.png', '003.png', 'png', '622227');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('179', 'activity', '11', 'Public/Upload/activity/2018-04-11/5acd8343bbc9c.jpg', '3c28af542f2d49f7-da1566425074a021-9c373de8439e52c5d885c8459d285946.jpg', 'jpg', '15588');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('180', 'activity', '11', 'Public/Upload/activity/2018-04-11/5acd83440c117.jpg', '3.jpg', 'jpg', '751728');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('216', 'activity', '12', 'Public/Upload/activity/2018-04-11/5acdb7de3801b.jpg', '8.jpg', 'jpg', '270735');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('217', 'activity', '12', 'Public/Upload/activity/2018-04-11/5acdb7de71f82.jpg', '9.jpg', 'jpg', '480117');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('218', 'activity', '12', 'Public/Upload/activity/2018-04-11/5acdb7dee15a4.jpg', '10.jpg', 'jpg', '533355');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('219', 'activity', '12', 'Public/Upload/activity/2018-04-11/5acdb7df11047.jpg', '11.jpg', 'jpg', '395180');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('221', 'sellerInfo', '26', 'Public/Upload/sellerInfo/2018-04-11/5acdba4d42ca9.jpg', '8.jpg', 'jpg', '270735');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('222', 'sellerInfo', '26', 'Public/Upload/sellerInfo/2018-04-11/5acdba4d8d0a0.jpg', '9.jpg', 'jpg', '480117');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('229', 'sellerInfo', '23', 'Public/Upload/sellerInfo/2018-04-11/5acdbd8302577.jpg', '8.jpg', 'jpg', '270735');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('230', 'activity', '10', 'Public/Upload/activity/2018-04-11/5acdc813d89e4.jpg', '8501654.jpg', 'jpg', '179644');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('231', 'activity', '6', 'Public/Upload/activity/2018-04-11/5acdd19397ddb.jpg', 'u=3131094046,435481623&fm=27&gp=0.jpg', 'jpg', '36398');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('232', 'activity', '6', 'Public/Upload/activity/2018-04-11/5acdd193b1d3e.jpg', 'W020170605399560934416.jpg', 'jpg', '50251');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('233', 'activity', '6', 'Public/Upload/activity/2018-04-11/5acdd193d05bb.jpg', 'W020170605401650901537.jpg', 'jpg', '85703');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('234', 'activity', '6', 'Public/Upload/activity/2018-04-11/5acdd193f1afc.jpg', 'W020170605418321621706.jpg', 'jpg', '69188');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('239', 'sellerInfo', '0', 'Public/Upload/sellerInfo/2018-04-13/5ad089d675e93.jpeg', '身份证.jpeg', 'jpeg', '95033');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('240', 'sellerInfo', '0', 'Public/Upload/sellerInfo/2018-04-13/5ad089df57c09.jpeg', '身份证2.jpeg', 'jpeg', '25616');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('241', 'sellerInfo', '0', 'Public/Upload/sellerInfo/2018-04-13/5ad093da34d6d.png', '图片2.png', 'png', '30856');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('242', 'sellerInfo', '0', 'Public/Upload/sellerInfo/2018-04-13/5ad0947e0ea98.png', '图片1.png', 'png', '571839');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('243', 'sellerInfo', '0', 'Public/Upload/sellerInfo/2018-04-13/5ad094ea1300e.png', '图片2.png', 'png', '30856');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('244', 'sellerInfo', '26', 'Public/Upload/sellerInfo/2018-04-15/5ad2b853cfe0c.png', '图片2.png', 'png', '30856');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('245', 'sellerInfo', '0', 'Public/Upload/sellerInfo/2018-04-15/5ad2c214796d3.jpeg', '身份证2.jpeg', 'jpeg', '25616');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('246', 'sellerInfo', '0', 'Public/Upload/sellerInfo/2018-04-15/5ad2c225aef1b.png', '图片2.png', 'png', '30856');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('247', 'sellerInfo', '27', 'Public/Upload/sellerInfo/2018-04-15/5ad2c36d49b67.jpeg', '身份证.jpeg', 'jpeg', '95033');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('248', 'sellerInfo', '27', 'Public/Upload/sellerInfo/2018-04-15/5ad2c371d5bbb.jpeg', '身份证2.jpeg', 'jpeg', '25616');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('249', 'sellerInfo', '0', 'Public/Upload/sellerInfo/2018-04-15/5ad2c4e2a24a3.jpeg', '身份证.jpeg', 'jpeg', '95033');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('250', 'sellerInfo', '0', 'Public/Upload/sellerInfo/2018-04-15/5ad2c4e7306ac.jpeg', '身份证2.jpeg', 'jpeg', '25616');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('251', 'sellerInfo', '28', 'Public/Upload/sellerInfo/2018-04-15/5ad2c50609be7.jpeg', '身份证.jpeg', 'jpeg', '95033');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('252', 'sellerInfo', '28', 'Public/Upload/sellerInfo/2018-04-15/5ad2c509e10a1.jpeg', '身份证2.jpeg', 'jpeg', '25616');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('256', 'prop', '0', 'Public/Upload/prop/2018-04-16/5ad443e8c8d41.jpg', 'IMG_20180414_200916.jpg', 'jpg', '550655');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('257', 'sellerInfo', '33', 'Public/Upload/sellerInfo/2018-04-16/5ad44ea45a75c.png', '004.png', 'png', '732789');
INSERT INTO `qs_sqk_sys_all_attach` VALUES ('258', 'sellerInfo', '29', 'Public/Upload/sellerInfo/2018-04-16/5ad46d9f1cf52.jpg', '05.jpg', 'jpg', '89382');

-- ----------------------------
-- Table structure for `qs_sqk_sys_community_info`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_sys_community_info`;
CREATE TABLE `qs_sqk_sys_community_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '系统名称',
  `com_name` varchar(50) NOT NULL COMMENT '分类名称',
  `timestamp` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `uf_num` varchar(20) NOT NULL COMMENT '卡片串号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_sys_community_info
-- ----------------------------
INSERT INTO `qs_sqk_sys_community_info` VALUES ('1', '1', '翠景北里', '1523848460', 'asdfasdfasdf');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('2', '2', '翠屏北里', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('3', '3', '翠屏南里', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('4', '4', '大方居', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('5', '5', '格瑞雅居', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('6', '6', '葛布店东里', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('7', '7', '金侨时代', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('8', '8', '京洲园', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('9', '9', '靓景明居', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('10', '10', '梨园东里', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('11', '11', '龙鼎园', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('12', '12', '曼城家园', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('13', '13', '群芳园', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('14', '14', '万盛北里', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('15', '15', '欣达园', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('16', '16', '新城乐居', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('17', '17', '新华联南区', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('18', '18', '颐瑞东里', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('19', '19', '颐瑞西里', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('20', '20', '云景北里', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('21', '21', '云景东里', '1523241400', '00000000');
INSERT INTO `qs_sqk_sys_community_info` VALUES ('22', '22', '云景里', '1523241400', '00000000');

-- ----------------------------
-- Table structure for `qs_sqk_sys_config_def`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_sys_config_def`;
CREATE TABLE `qs_sqk_sys_config_def` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) NOT NULL COMMENT '系统名称',
  `set_key` varchar(50) NOT NULL COMMENT '配置键',
  `set_value` varchar(500) NOT NULL COMMENT '配置值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_sys_config_def
-- ----------------------------
INSERT INTO `qs_sqk_sys_config_def` VALUES ('2', 'system_name', 'system_name', '北京通州区梨园镇社区卡管理系统');
INSERT INTO `qs_sqk_sys_config_def` VALUES ('3', 'db_fix', 'db_fix', 'qs_sqk_');
INSERT INTO `qs_sqk_sys_config_def` VALUES ('4', 'system_token', 'system_token', 'qs_sqk');

-- ----------------------------
-- Table structure for `qs_sqk_sys_db_backup`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_sys_db_backup`;
CREATE TABLE `qs_sqk_sys_db_backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `db_path` tinytext NOT NULL COMMENT '备份路径',
  `db_name` varchar(100) NOT NULL,
  `backup_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '备份时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_sys_db_backup
-- ----------------------------
INSERT INTO `qs_sqk_sys_db_backup` VALUES ('14', 'E:\\wamp\\www\\qskj_project_sqk_debug\\trunk\\dbsql', 'qs_sqk_db_debug-20180411-111141.sql', '2018-04-11 11:11:42');
INSERT INTO `qs_sqk_sys_db_backup` VALUES ('15', 'E:/wamp/www/qskj_project_sqk_debug/trunk/dbsql/', 'qs_sqk_db_debug-20180411-111326.sql', '2018-04-11 11:13:26');
INSERT INTO `qs_sqk_sys_db_backup` VALUES ('16', 'E:/wamp/www/qskj_project_sqk_debug/trunk/dbsql/', 'qs_sqk_db_debug-20180411-111534.sql', '2018-04-11 11:15:35');
INSERT INTO `qs_sqk_sys_db_backup` VALUES ('17', 'E:/wamp/www/qskj_project_sqk_debug/trunk/dbsql/', 'qs_sqk_db_debug-20180411-111850.sql', '2018-04-11 11:18:51');

-- ----------------------------
-- Table structure for `qs_sqk_sys_priv_cat`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_sys_priv_cat`;
CREATE TABLE `qs_sqk_sys_priv_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) DEFAULT NULL COMMENT '系统名称',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `parent_id_path` varchar(50) NOT NULL DEFAULT '' COMMENT '所属上级目录',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用 0：禁用，1：启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_sys_priv_cat
-- ----------------------------
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('2', 'notice', '通知公告', '', '0', '2017-03-17 11:36:09', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('3', 'sellerManage', '商家管理', '', '0', '2017-03-21 09:53:24', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('4', 'wy', '物业服务', '', '0', '2017-03-21 09:53:39', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('5', 'activity', '社区活动服务', '', '0', '2017-03-21 09:53:55', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('6', 'system', '系统设置', '', '0', '2017-03-21 09:54:09', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('7', 'noticeCat', '通知分类', '2.', '2', '2017-03-21 09:54:39', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('8', 'noticeInfo', '通知信息', '2.', '2', '2017-03-21 09:54:58', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('9', 'sellerCat', '商家分类', '3.', '3', '2017-03-21 09:55:21', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('10', 'sellerInfo', '商家信息', '3.', '3', '2017-03-27 15:13:44', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('11', 'itemsCat', '服务项目分类', '3.', '3', '2017-03-27 15:31:35', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('12', 'itemsInfo', '服务项目信息', '3.', '3', '2017-03-27 15:31:54', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('13', 'orderInfo', '订单信息', '3.', '3', '2017-03-29 09:51:42', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('14', 'promInfo', '促销信息', '3.', '3', '2017-03-29 09:51:59', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('15', 'dangerCat', '险情/隐患分类', '4.', '4', '2017-03-29 11:52:17', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('16', 'dangerInfo', '险情信息', '4.', '4', '2017-03-29 11:52:40', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('17', 'probInfo', '问题/诉求信息', '4.', '4', '2017-03-29 11:53:07', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('18', 'activCat', '活动分类', '5.', '5', '2017-03-29 11:58:09', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('19', 'activInfo', '活动信息', '5.', '5', '2017-03-29 11:58:29', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('20', 'privCat', '权限分类', '6.', '6', '2017-03-29 13:03:52', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('21', 'privInfo', '权限信息', '6.', '6', '2017-03-29 13:04:12', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('22', 'userGroup', '角色管理', '6.', '6', '2017-03-29 13:04:28', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('23', 'userInfo', '用户信息', '6.', '6', '2017-03-29 13:04:45', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('24', 'dbBack', '数据备份', '6.', '6', '2017-03-29 13:05:03', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('25', 'actionLog', '系统日志', '6.', '6', '2017-03-29 13:05:21', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('26', 'menuSet', '菜单设置', '', '0', '2017-03-29 16:10:19', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('27', 'menu', '菜单列表', '26.', '26', '2017-03-29 16:12:02', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('30', 'helpServer', '应急服务', '', '0', '2017-04-10 11:39:21', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('31', 'showHelpInfo', '社区电话', '30.', '30', '2017-04-10 11:40:54', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('32', 'showMyHelpInfo', '紧急联系人', '30.', '30', '2017-04-10 14:10:02', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('33', 'appuser', '会员管理', '', '0', '2018-04-03 15:14:27', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('34', 'apperMenu', '居民管理', '33.', '33', '2018-04-03 15:19:31', '1');
INSERT INTO `qs_sqk_sys_priv_cat` VALUES ('35', 'cleanTemPic', '清理缓存', '6.', '6', '2018-04-03 17:11:58', '1');

-- ----------------------------
-- Table structure for `qs_sqk_sys_priv_info`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_sys_priv_info`;
CREATE TABLE `qs_sqk_sys_priv_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限分类id',
  `pri_name` varchar(50) NOT NULL COMMENT '权限名称',
  `pri_value` varchar(50) NOT NULL COMMENT '权限值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_sys_priv_info
-- ----------------------------
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('2', '7', '新增分类', 'addNoticeCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('3', '7', '编辑分类', 'editNoticeCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('4', '8', '新增信息', 'addNoticeInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('5', '8', '编辑信息', 'editNoticeInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('6', '7', '删除分类', 'delNoticeCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('7', '8', '删除信息', 'delNoticeInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('8', '8', '发布信息', 'pubNoticeInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('9', '7', '查看分类', 'showNoticeCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('10', '8', '查看信息', 'showNoticeInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('11', '9', '新增分类', 'addSellerCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('12', '9', '编辑分类', 'editSellerCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('13', '9', '删除分类', 'delSellerCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('14', '9', '查看分类', 'showSellerCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('15', '10', '新增信息', 'addSellerInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('16', '10', '编辑信息', 'editSellerInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('17', '10', '删除信息', 'delSellerInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('18', '10', '查看信息', 'showSellerInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('19', '10', '审核信息', 'checkSellerInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('20', '10', '完善信息', 'perfectInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('21', '11', '新增分类', 'addItemsCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('22', '11', '编辑分类', 'editItemsCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('23', '11', '删除分类', 'delItemsCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('24', '11', '查看分类', 'showItemsCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('25', '12', '新增信息', 'addItemsInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('26', '12', '编辑信息', 'editItemsInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('27', '12', '删除信息', 'delItemsInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('28', '12', '查看信息', 'showItemsInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('29', '12', '审核信息', 'checkItemsInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('30', '13', '处理订单', 'dealOrderInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('31', '14', '新增信息', 'addPromInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('32', '14', '编辑信息', 'editPromInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('33', '14', '删除信息', 'delPromInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('34', '14', '查看信息', 'showPromInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('35', '15', '新增分类', 'addDangerCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('36', '15', '编辑分类', 'editDangerCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('37', '15', '删除分类', 'delDangerCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('38', '15', '查看分类', 'showDangerCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('39', '16', '处理险情', 'dealDangerInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('40', '16', '删除险情', 'delDangerInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('41', '16', '查看险情', 'showDangerInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('42', '17', '处理问题/诉求', 'dealProbInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('43', '17', '删除问题/诉求', 'delProbInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('44', '17', '查看问题/诉求', 'showProbInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('45', '18', '新增分类', 'addActivCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('46', '18', '编辑分类', 'editActivCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('47', '18', '删除分类', 'delActivCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('48', '19', '新增信息', 'addActivInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('49', '19', '编辑信息', 'editActivInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('50', '19', '删除信息', 'delActivInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('51', '19', '查看信息', 'showActivInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('52', '20', '新增分类', 'addPrivCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('53', '20', '编辑分类', 'editPrivCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('54', '20', '删除分类', 'delPrivCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('55', '20', '查看分类', 'showPrivCat');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('56', '21', '新增信息', 'addPrivInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('57', '21', '编辑信息', 'editPrivInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('58', '21', '删除信息', 'delPrivInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('59', '21', '查看信息', 'showPrivInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('60', '22', '新增信息', 'addUserGroup');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('61', '22', '编辑信息', 'editUserGroup');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('62', '22', '删除信息', 'delUserGroup');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('63', '22', '查看信息', 'showUserGroup');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('64', '23', '新增信息', 'addUserInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('65', '23', '编辑信息', 'editUserInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('66', '23', '删除信息', 'delUserInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('67', '23', '查看信息', 'showUserInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('68', '19', '发布信息', 'pubActivInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('69', '13', '查看信息', 'showOrderInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('70', '27', '通知公告', 'noticeMenu');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('71', '27', '生活圈服务', 'sellerMenu');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('72', '27', '物业服务', 'wyMenu');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('73', '27', '社区活动服务', 'activMenu');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('74', '27', '系统设置', 'systemMenu');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('75', '12', '商家查看服务项目', 'showSellerItems');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('76', '13', '商家查看订单信息', 'showSellerOrder');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('77', '14', '商家查看促销信息', 'showSellerProm');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('78', '27', '应急服务', 'helpMenu');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('79', '31', '新增联系人', 'addHelpInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('80', '31', '编辑联系人', 'editHelpInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('81', '31', '删除联系人', 'delHelpInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('82', '32', '编辑紧急', 'editMyHelpInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('83', '24', '查看备份', 'showDbBack');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('84', '25', '查看日志', 'showLogInfo');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('85', '35', '清理缓存图片', 'cleanTemPic');
INSERT INTO `qs_sqk_sys_priv_info` VALUES ('86', '18', '查看分类', 'showActivCat');

-- ----------------------------
-- Table structure for `qs_sqk_sys_userapp_info`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_sys_userapp_info`;
CREATE TABLE `qs_sqk_sys_userapp_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '社区id',
  `usr` varchar(50) NOT NULL COMMENT '用户名',
  `realname` varchar(50) DEFAULT NULL COMMENT '真实姓名',
  `gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别 0男 1女',
  `birthday` date NOT NULL DEFAULT '1970-01-01' COMMENT '生日',
  `tel` varchar(20) DEFAULT NULL COMMENT '手机',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '订单提交时间',
  `last_ip` varchar(15) DEFAULT NULL COMMENT '最新一次登录IP',
  `last_login_time` datetime DEFAULT NULL,
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用状态 0：未启用，1：启用',
  `keycode` varchar(8) DEFAULT NULL COMMENT '标识码',
  `rns_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '实名制状态 0未审核，1审核通过，2审核不通过',
  `address` varchar(100) DEFAULT NULL COMMENT '地址',
  `integral_num` int(11) NOT NULL DEFAULT '0' COMMENT '积分数',
  `exp_num` int(11) NOT NULL DEFAULT '0' COMMENT '经验值',
  `joined_act_num` int(11) NOT NULL DEFAULT '0' COMMENT '参加活动次数',
  `liked_act_num` int(11) NOT NULL DEFAULT '0' COMMENT '收藏活动数目',
  `shared_act_num` int(11) NOT NULL DEFAULT '0' COMMENT '分享活动次数',
  `card_num` int(11) NOT NULL DEFAULT '0' COMMENT '卡券数',
  `liked_card_num` int(11) NOT NULL DEFAULT '0' COMMENT '收藏的卡券',
  `used_card_num` int(11) NOT NULL DEFAULT '0' COMMENT '使用过的卡券数',
  `iccard_num` varchar(20) NOT NULL DEFAULT '00000000' COMMENT 'IC卡卡号',
  `iccard_ufnum` varchar(20) NOT NULL DEFAULT 'FFFFFFFF' COMMENT 'IC卡串号',
  `wx_num` varchar(50) NOT NULL DEFAULT '00000000' COMMENT '绑定的微信号',
  `qrcode_path` varchar(50) NOT NULL DEFAULT '123',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_sys_userapp_info
-- ----------------------------
INSERT INTO `qs_sqk_sys_userapp_info` VALUES ('105', '1', '13521447597', '123', '0', '2018-04-11', '13521447597', '2018-04-10 11:43:08', null, null, '1', null, '0', '123123', '0', '0', '0', '0', '0', '0', '0', '0', '0000236', 'asdfasdfasdf', '00000000', 'Public/Temfile/qrcode/20180410114308.png');
INSERT INTO `qs_sqk_sys_userapp_info` VALUES ('106', '1', '13521447599', '张晓炜', '0', '2018-04-18', '13521447599', '2018-04-10 11:47:15', null, null, '1', null, '0', '234234234234', '0', '0', '0', '0', '0', '0', '0', '0', '1231231', 'asdfasdfasdf', '00000000', 'Public/Temfile/qrcode/20180410114715.png');
INSERT INTO `qs_sqk_sys_userapp_info` VALUES ('107', '1', '13521445632', '张张张', '0', '2018-04-13', '13521445632', '2018-04-10 11:50:42', null, null, '1', null, '0', '士大夫撒旦法', '0', '0', '0', '0', '0', '0', '0', '0', '00000000', 'FFFFFFFF', '00000000', 'Public/Temfile/qrcode/20180410115042.png');
INSERT INTO `qs_sqk_sys_userapp_info` VALUES ('108', '1', '13521447598', '撒旦发撒旦', '0', '2018-04-11', '13521447598', '2018-04-10 11:53:40', null, null, '1', null, '0', '32423423423', '0', '0', '0', '0', '0', '0', '0', '0', '00000000', 'FFFFFFFF', '00000000', 'Public/Temfile/qrcode/20180410115340.png');
INSERT INTO `qs_sqk_sys_userapp_info` VALUES ('109', '1', '13569856324', '123', '0', '2018-04-04', '13569856324', '2018-04-10 11:55:58', null, null, '1', null, '0', '所发生的发生', '0', '0', '0', '0', '0', '0', '0', '0', '00000000', 'FFFFFFFF', '00000000', 'Public/Temfile/qrcode/20180410115558.png');
INSERT INTO `qs_sqk_sys_userapp_info` VALUES ('113', '1', '', '渣渣辉', '0', '2018-04-13', '13521447896', '2018-04-13 13:26:07', null, null, '1', null, '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '00000000', 'FFFFFFFF', '00000000', 'Public/Temfile/qrcode/20180413132607.png');

-- ----------------------------
-- Table structure for `qs_sqk_sys_user_group`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_sys_user_group`;
CREATE TABLE `qs_sqk_sys_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) DEFAULT NULL COMMENT '系统名称',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `parent_id_path` varchar(50) NOT NULL DEFAULT '' COMMENT '所属上级目录',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `priviledges` text COMMENT '组权限',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否禁用 0：禁用，1：启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_sys_user_group
-- ----------------------------
INSERT INTO `qs_sqk_sys_user_group` VALUES ('8', 'sqAdmin', '社区', '', '0', '2018-04-03 14:57:49', 'addNoticeInfo,editNoticeInfo,delNoticeInfo,pubNoticeInfo,showNoticeInfo,addSellerCat,editSellerCat,delSellerCat,showSellerCat,addSellerInfo,editSellerInfo,delSellerInfo,showSellerInfo,checkSellerInfo,perfectInfo,addActivInfo,editActivInfo,delActivInfo,showActivInfo,pubActivInfo,addUserInfo,editUserInfo,delUserInfo,showUserInfo,noticeMenu,sellerMenu,activMenu,', '1');
INSERT INTO `qs_sqk_sys_user_group` VALUES ('5', 'sysAdmin', '系统', '', '0', '2017-03-30 13:37:28', 'addNoticeCat,editNoticeCat,delNoticeCat,showNoticeCat,addNoticeInfo,editNoticeInfo,delNoticeInfo,pubNoticeInfo,showNoticeInfo,addSellerCat,editSellerCat,delSellerCat,showSellerCat,addSellerInfo,editSellerInfo,delSellerInfo,showSellerInfo,checkSellerInfo,perfectInfo,addPromInfo,editPromInfo,delPromInfo,showPromInfo,showSellerProm,addDangerCat,editDangerCat,delDangerCat,showDangerCat,dealDangerInfo,delDangerInfo,showDangerInfo,dealProbInfo,delProbInfo,showProbInfo,addActivCat,editActivCat,delActivCat,showActivCat,addActivInfo,editActivInfo,delActivInfo,showActivInfo,pubActivInfo,addPrivCat,editPrivCat,delPrivCat,showPrivCat,addPrivInfo,editPrivInfo,delPrivInfo,showPrivInfo,addUserGroup,editUserGroup,delUserGroup,showUserGroup,addUserInfo,editUserInfo,delUserInfo,showUserInfo,showDbBack,showLogInfo,cleanTemPic,noticeMenu,sellerMenu,wyMenu,activMenu,systemMenu,helpMenu,addHelpInfo,editHelpInfo,delHelpInfo,editMyHelpInfo,', '1');

-- ----------------------------
-- Table structure for `qs_sqk_sys_user_info`
-- ----------------------------
DROP TABLE IF EXISTS `qs_sqk_sys_user_info`;
CREATE TABLE `qs_sqk_sys_user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户组id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '社区id',
  `usr` varchar(50) NOT NULL COMMENT '用户名',
  `pwd` varchar(40) NOT NULL DEFAULT '123' COMMENT '密码',
  `realname` varchar(50) DEFAULT NULL COMMENT '真实姓名',
  `gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别 0男 1女',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `tel` varchar(20) DEFAULT NULL COMMENT '手机',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '订单提交时间',
  `last_ip` varchar(15) DEFAULT NULL COMMENT '最新一次登录IP',
  `last_login_time` datetime DEFAULT NULL,
  `priviledges` text COMMENT '用户权限',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用状态 0：未启用，1：启用',
  `keycode` varchar(8) DEFAULT NULL COMMENT '标识码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qs_sqk_sys_user_info
-- ----------------------------
INSERT INTO `qs_sqk_sys_user_info` VALUES ('1', '5', '0', 'super', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '管理员', '0', 'super@qq.com', '15823695896', '010-60551593', '2017-03-30 09:06:21', '127.0.0.1', '2018-04-16 17:28:23', '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('73', '8', '1', 'sqgl-1', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '翠景北里-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', '127.0.0.1', '2018-04-16 15:26:00', 'systemMenu,', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('74', '8', '2', 'sqgl-2', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '翠屏北里-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', '127.0.0.1', '2018-04-04 15:18:15', '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('75', '8', '3', 'sqgl-3', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '翠屏南里-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', '127.0.0.1', '2018-04-12 15:59:56', '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('76', '8', '4', 'sqgl-4', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '大方居-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('77', '8', '5', 'sqgl-5', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '格瑞雅居-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('78', '8', '6', 'sqgl-6', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '葛布店东里-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('79', '8', '7', 'sqgl-7', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '金侨时代-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('80', '8', '8', 'sqgl-8', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '京洲园-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', '127.0.0.1', '2018-04-15 17:35:16', '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('81', '8', '9', 'sqgl-9', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '靓景明居-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('82', '8', '10', 'sqgl-10', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '梨园东里-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('83', '8', '11', 'sqgl-11', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '龙鼎园-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('84', '8', '12', 'sqgl-12', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '曼城家园-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('85', '8', '13', 'sqgl-13', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '群芳园-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('86', '8', '14', 'sqgl-14', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '万盛北里-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('87', '8', '15', 'sqgl-15', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '欣达园-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('88', '8', '16', 'sqgl-16', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '新城乐居-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('89', '8', '17', 'sqgl-17', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '新华联南区-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('90', '8', '18', 'sqgl-18', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '颐瑞东里-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('91', '8', '19', 'sqgl-19', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '颐瑞西里-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('92', '8', '20', 'sqgl-20', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '云景北里-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('93', '8', '21', 'sqgl-21', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '云景东里-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', null, null, '', '1', null);
INSERT INTO `qs_sqk_sys_user_info` VALUES ('94', '8', '22', 'sqgl-22', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '云景里-管理员', '0', '', '13521447599', '010-12345678', '2018-04-03 15:07:39', '127.0.0.1', '2018-04-04 15:42:06', '', '1', null);