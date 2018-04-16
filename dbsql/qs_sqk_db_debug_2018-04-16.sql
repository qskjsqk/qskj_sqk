# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.20)
# Database: qs_sqk_db_debug
# Generation Time: 2018-04-16 02:09:28 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table qs_sqk_activ_cat
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_activ_cat` WRITE;
/*!40000 ALTER TABLE `qs_sqk_activ_cat` DISABLE KEYS */;

INSERT INTO `qs_sqk_activ_cat` (`id`, `sys_name`, `cat_name`, `parent_id_path`, `parent_id`, `add_time`, `is_enable`)
VALUES
	(1,'shequhuodong','社区','',0,'2017-04-01 15:46:03',1),
	(2,'gongyihuodong','公益','',0,'2017-04-01 15:57:44',1);

/*!40000 ALTER TABLE `qs_sqk_activ_cat` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_activ_comm
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_activ_comm`;

CREATE TABLE `qs_sqk_activ_comm` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `activity_id` int(11) NOT NULL DEFAULT '0' COMMENT '活动id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '评论人id',
  `content` varchar(2000) NOT NULL COMMENT '评论内容',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提交时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_activ_comm` WRITE;
/*!40000 ALTER TABLE `qs_sqk_activ_comm` DISABLE KEYS */;

INSERT INTO `qs_sqk_activ_comm` (`id`, `activity_id`, `user_id`, `content`, `add_time`)
VALUES
	(1,5,58,'不错不错','2017-06-09 09:55:16'),
	(2,5,61,'味道好极了','2017-06-28 09:00:56'),
	(3,9,109,'hxbxbxnsnn','2018-04-11 11:32:30'),
	(4,11,109,'公积金理解','2018-04-11 11:51:56'),
	(5,12,109,'吉里吉里控制','2018-04-12 09:22:40');

/*!40000 ALTER TABLE `qs_sqk_activ_comm` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_activ_info
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_activ_info` WRITE;
/*!40000 ALTER TABLE `qs_sqk_activ_info` DISABLE KEYS */;

INSERT INTO `qs_sqk_activ_info` (`id`, `cat_id`, `address_id`, `user_id`, `title`, `content`, `add_time`, `start_time`, `end_time`, `link_name`, `link_tel`, `read_ids`, `read_num`, `join_ids`, `join_num`, `like_ids`, `like_num`, `integral`, `qrcode_path`, `is_publish`, `is_open`, `is_over`, `address`, `initiator`)
VALUES
	(7,1,0,1,'asdfasd','12312312','2018-04-04 09:11:15','2018-04-05 00:00:00','2018-04-05 00:00:00','123123123','13521445899','',0,'',0,'',0,0,'',1,0,0,'',''),
	(5,2,0,73,'通州启动春季义务植树活动','<p><img src=\"/ueditor/php/upload/image/20170421/1492767551607651.jpg\" title=\"1492767551607651.jpg\" alt=\"14658619.jpg\"/></p><p>参加义务植树活动的人员中，有400余名通州区劳动模范、优秀青年和优秀妇女代表，他们是通州发展的见证者和亲历者，今天更是以实际行动为城市副中心园林绿化建设贡献自己的一份力量。<br/><br/>义务植树活动所在的宋庄公园，中坝河穿园而过，规划面积882亩。公园规划范围内原为养殖小区、垃圾渣土和部分平原造林地块。根据总体规划，结合产业结构调整和环境综合整治，共拆除违法建设3.5万平方米，同时提升平原造林的景观效果和服务功能。<br/><br/>公园内栽植白皮松、油松、银杏、樱花、西府海棠等各类苗木2.2万余株，主要以“银杏千株，樱花万枝”为景观特色，3月下旬到4月下旬樱花盛放，着力打造“京东第一樱花园”。宋庄公园建成后，将与东郊森林公园、永顺刘庄公园、减河公园等公园绿地共同围合成56公里长的环城绿色休闲游憩环，为北京城市副中心打造绿色生态屏障。<br/><br/>下一步，区园林绿化局将以春季义务植树活动为序曲，围绕城市副中心的功能定位，将以创建国家森林城市和国家生态园林城市为目标，加快完成2016年42个续建工程建设，在此基础上，再启动实施园林绿化重点项目23个，加大城市副中心园林绿化建设力度，着力打造“水韵林海、蓝绿交织”的优美画卷，进一步彰显城市特色、提高城市魅力，增强城市吸引力。</p>','2017-04-21 17:39:32','2017-04-01 00:00:00','2017-04-30 00:00:00','张先生','13000000000',',31,58,61,62,68,',12,'',0,'',0,0,'',1,0,0,'',''),
	(6,1,0,1,'中央军委领导在通州参加义务植树活动','<p><br/>公园内栽植白皮松、油松、银杏、樱花、西府海棠等各类苗木2.2万余株，主要以“银杏千株，樱花万枝”为景观特色，3月下旬到4月下旬樱花盛放，着力打造“京东第一樱花园”。宋庄公园建成后，将与东郊森林公园、永顺刘庄公园、减河公园等公园绿地共同围合成56公里长的环城绿色休闲游憩环，为北京城市副中心打造绿色生态屏障。<br/><br/>下一步，区园林绿化局将以春季义务植树活动为序曲，围绕城市副中心的功能定位，将以创建国家森林城市和国家生态园林城市为目标，加快完成2016年42个续建工程建设，在此基础上，再启动实施园林绿化重点项目23个，加大城市副中心园林绿化建设力度，着力打造“水韵林海、蓝绿交织”的优美画卷，进一步彰显城市特色、提高城市魅力，增强城市吸引力。</p><p><br/></p>','2017-04-21 17:41:46','2017-04-01 00:00:00','2017-04-20 00:00:00','李主任','13022228888',',31,58,61,62,63,68,109,',28,',61,',1,',58,61,',2,50,'',1,0,0,'',''),
	(8,1,6,1,'1231231231','<p>13231</p>','2018-04-04 16:44:32','2018-04-14 00:00:00','2018-04-18 00:00:00','123','13521447599','',0,'',0,'',0,0,'',1,0,0,'',''),
	(9,2,1,73,'123123','<p>sdfasdfas</p>','2018-04-04 16:57:48','2018-04-05 07:11:00','2018-04-18 00:00:00','12312','13526985632',',109,',3,'',0,'',0,50,'',1,0,0,'',''),
	(10,1,0,1,'如何在程序留下彩蛋？','<p>上周末，我叫了个滴滴顺风车，从杭州去绍兴乔波滑雪。因为有个较大的雪板行李，因此我选择了不拼车。并增加了15元感谢费。没一会儿一个东北口音的司机打我电话称他比较远，需要我额外添加感谢费才能来接我。</p><p>我说我已经添加了感谢费15元，如果你没办法接的话，可以不用接单，我等下个顺路的司机即可。 该司机挂了选择了接了我的单。</p><p>上车后，司机问我怎么走， 我说我不赶时间，国道和高速都可。因司机的确从很远的地方赶来接我，我本着希望司机也能更早到家的心态，承诺如果走高速的话愿意承担15元过路费。</p><p>到达终点后，司机说过路费35元，需要我出。于是就有了视频中的那一幕。</p><p>司机扣着我的行李，不让我下车，并强行要我给他35元。并在我找人求助的时候，手持螺丝刀对我进行人生威胁。 我因而选择了报警。 注意看下面的视频 可以清晰的看到司机手持螺丝刀。</p><p><br/><br/>作者：LeonLuoJ<br/>链接：https://www.zhihu.com/question/26607538/answer/313040467<br/>来源：知乎<br/>著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。</p><p><br/></p>','2018-04-08 11:35:59','2018-04-08 00:00:00','2018-04-12 00:00:00','发生大幅','13521447599',',109,',2,'',0,NULL,0,50,NULL,1,0,0,'',''),
	(11,2,0,1,'关于开展工会文体活动的通知','<p style=\"text-indent: 43px\"><strong><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">二、比赛方法及规则</span></strong></p><p style=\"text-indent: 43px\"><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">比赛方法及规则附后。如有问题可向各活动负责人咨询。</span></p><p style=\"text-indent: 43px\"><strong><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">三、奖项设置</span></strong></p><p style=\"text-indent: 43px\"><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">各项目均分别设置一定奖品。</span></p><p style=\"text-indent: 43px\"><strong><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">四、其他事项</span></strong></p><p style=\"text-indent: 43px\"><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">1</span><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">、</span><strong><span style=\"font-family: 仿宋_GB2312;font-size: 24px\">除拔河、套圈比赛外，参加其余各项活动，须在今日向各活动负责人报名。</span></strong></p><p style=\"text-indent: 43px\"><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">2</span><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">、室外活动完毕后，再开展室内活动。</span></p><p style=\"text-indent: 43px\"><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">3</span><span style=\"font-family: 仿宋_GB2312;font-size: 21px\">、所有参赛者都要本着友谊第一、比赛第二的原则，既要赛出水平，又要赛出风格</span></p>','2018-04-11 11:38:46','2018-04-13 12:00:00','2018-04-28 00:00:00','zhangsdjl','13521445789',',109,',16,',109,',1,',109,',1,50,NULL,1,0,0,'',''),
	(12,2,0,1,'小米Max2怎么样？小米Max2评测小米Max2怎么样？小米Max2评测','<p style=\"margin: 20px 0px 0px; padding: 0px; color: rgb(0, 0, 0); font-family: 宋体, arial; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial;\">我们知道，小米Max2主打大屏长续航，搭载骁龙625八核处理器，前置500W+后置1200W像素摄像头，配备了一块6.44英寸的大屏幕，内置5300mAh充电宝级大电池，支持18W快充，深受很多大屏爱好者的喜欢。</p><p style=\"margin: 20px 0px 0px; padding: 0px; color: rgb(0, 0, 0); font-family: 宋体, arial; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial;\">　　该机推出了4+64GB和4+128GB两个版本，前者售价1699元，后者售价1999元，性价比还是非常不错的，不过有人希望还能够再便宜一点，毕竟很多人拿来做备用机+充电宝不需要太贵，那么或许你的愿望很快就能实现了。</p><p><br/></p>','2018-04-11 15:23:12','2018-04-21 10:25:00','2018-04-27 08:29:00','张晓炜','13521447599',',109,',7,'',0,',109,',1,400,NULL,1,0,0,'北京市通州区玉带河东街','北京科协');

/*!40000 ALTER TABLE `qs_sqk_activ_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_emer_serv_cat
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_emer_serv_cat`;

CREATE TABLE `qs_sqk_emer_serv_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) DEFAULT NULL COMMENT '系统名称',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `parent_id_path` varchar(50) NOT NULL DEFAULT '' COMMENT '所属上级目录',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用 0：禁用，1：启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table qs_sqk_emer_serv_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_emer_serv_info`;

CREATE TABLE `qs_sqk_emer_serv_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属分类id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布人id',
  `realname` varchar(50) NOT NULL COMMENT '真实姓名',
  `tel` varchar(20) NOT NULL COMMENT '联系方式',
  `department` varchar(50) DEFAULT NULL COMMENT '工作单位',
  `phone` varchar(20) DEFAULT NULL COMMENT '座机号码',
  `comment` text COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_emer_serv_info` WRITE;
/*!40000 ALTER TABLE `qs_sqk_emer_serv_info` DISABLE KEYS */;

INSERT INTO `qs_sqk_emer_serv_info` (`id`, `cat_id`, `user_id`, `realname`, `tel`, `department`, `phone`, `comment`)
VALUES
	(2,0,0,'物业小刘','13000000000','格瑞雅居社区物业管理处','010-66668888','物业事宜请找我~~~'),
	(3,0,0,'居委会张大妈','13011111111','格瑞雅居居委会','010-66668888','大小事情帮您解决'),
	(4,0,0,'保安小李','13022220000','格瑞雅居社区保卫处','010-66668888','全心全意为您服务~~'),
	(5,1,68,'陈晨','15632123654','保定','','');

/*!40000 ALTER TABLE `qs_sqk_emer_serv_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_health_cat
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_health_cat`;

CREATE TABLE `qs_sqk_health_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) DEFAULT NULL COMMENT '系统名称',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `parent_id_path` varchar(50) NOT NULL DEFAULT '' COMMENT '所属上级目录',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用 0：禁用，1：启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_health_cat` WRITE;
/*!40000 ALTER TABLE `qs_sqk_health_cat` DISABLE KEYS */;

INSERT INTO `qs_sqk_health_cat` (`id`, `sys_name`, `cat_name`, `parent_id_path`, `parent_id`, `add_time`, `is_enable`)
VALUES
	(28,'baojian','养生保健','',0,'2017-04-05 14:40:25',1),
	(27,'jijiu','急救常识','',0,'2017-04-05 14:39:44',1),
	(29,'','指标讲解','',0,'2017-05-26 11:30:00',0);

/*!40000 ALTER TABLE `qs_sqk_health_cat` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_health_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_health_info`;

CREATE TABLE `qs_sqk_health_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属分类id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布人id',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `content` text COMMENT '内容',
  `is_publish` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布 0：未发布，1：发布',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读人数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_health_info` WRITE;
/*!40000 ALTER TABLE `qs_sqk_health_info` DISABLE KEYS */;

INSERT INTO `qs_sqk_health_info` (`id`, `cat_id`, `user_id`, `title`, `content`, `is_publish`, `add_time`, `read_num`)
VALUES
	(3,28,1,'剩青菜加热吃有害身体健康','<p>&nbsp;<span style=\"font-family: 宋体; font-size: 13px;\">&nbsp; 在人们的心目中，大都认为剩饭菜只要不变质发馊，吃时再加热就万事大吉了。殊不知，加热不仅消除不了剩青菜中含有的毒素，还会使毒性增强，吃后极易发生中毒。</span><span style=\"font-family:;\">&nbsp;<br/>&nbsp;</span><span style=\"font-family: 宋体; font-size: 13px;\">&nbsp; 原来，在各种绿叶蔬菜中都含有不同量的硝酸盐，尤其是如今大量使用化肥，致使菜中含的硝酸盐增多。买回的青菜放的时间长了，或烧熟的菜放置过久，菜中的硝酸盐在细菌的作用下会被还原为亚硝酸盐。</span></p><p><span style=\"font-family: 宋体; font-size: 13px;\"></span><span style=\"font-family:;\"><img title=\"1491456482130928.jpg\" alt=\"timg.jpg\" src=\"/ueditor/php/upload/image/20170406/1491456482130928.jpg\"/>&nbsp;<br/></span><span style=\"font-family: 宋体; font-size: 13px;\">&nbsp; 不及时抢救可造成死亡</span><span style=\"font-family:;\"><br/>&nbsp;<br/></span><span style=\"font-family: 宋体; font-size: 13px;\">&nbsp;&nbsp; 对这种含有亚硝酸盐的剩菜，即使放入冰箱内的冷藏室也不管用。将剩菜拿出来进行加热，不仅不能除掉有毒的亚硝酸盐，反而会使菜中剩余的硝酸盐在高温的作用下分解为更多的亚硝酸盐，加剧了毒性。过多的亚硝酸盐进入人体被吸收到血液后，可使血中的低铁血红蛋白转化为高铁血红蛋白，失去携带和运送氧的能力，各组织器官得不到充足的氧，机体就会出现缺氧症状，轻者口唇及指甲青紫、恶心呕吐、腹痛腹泻，若缺氧严重，大脑神经受损，全身皮肤变得青紫，陷入昏迷、抽搐，抢救不及时可造成死亡。看来，今后不能再随便吃剩菜了。</span><span style=\"font-family:;\"><br/>&nbsp;<br/></span><span style=\"font-family: 宋体; font-size: 13px;\">&nbsp;&nbsp; 加热不是万能消毒法</span><span style=\"font-family:;\"><br/>&nbsp;<br/>&nbsp; &nbsp; &nbsp;</span><span style=\"font-family: 宋体; font-size: 13px;\">人们普遍认为：东西只要经过加热蒸煮，就可消毒。其实，有些毒素是加热破坏不了的。</span><span style=\"font-family:;\">&nbsp;<br/></span><span style=\"font-family: 宋体; font-size: 13px;\">&nbsp;&nbsp; 通常所说的食物中毒可分为</span><span style=\"font-family:;\">“</span><span style=\"font-family: 宋体; font-size: 13px;\">生物型</span><span style=\"font-family:;\">”</span><span style=\"font-family: 宋体; font-size: 13px;\">和</span><span style=\"font-family:;\">“</span><span style=\"font-family: 宋体; font-size: 13px;\">化学型</span><span style=\"font-family:;\">”</span><span style=\"font-family: 宋体; font-size: 13px;\">两类。</span><span style=\"font-family:;\">“</span><span style=\"font-family: 宋体; font-size: 13px;\">生物型</span><span style=\"font-family:;\">”</span><span style=\"font-family: 宋体; font-size: 13px;\">中毒主要是指被细菌、病毒、寄生虫等污染过，通过食物或接触引起急性传染病。比如腐败食物中的霉菌，这一类食品可用高温蒸煮进行</span><span style=\"font-family:;\">“</span><span style=\"font-family: 宋体; font-size: 13px;\">消毒</span><span style=\"font-family:;\">”</span><span style=\"font-family: 宋体; font-size: 13px;\">，因为细菌、病毒、寄生虫卵等，在</span><span style=\"font-family:;\">100</span><span style=\"font-family: 宋体; font-size: 13px;\">℃</span><span style=\"font-family: 宋体; font-size: 13px;\">时几分钟就会死亡，即使留有少量毒素也不会造成显著危害。但</span><span style=\"font-family:;\">“</span><span style=\"font-family: 宋体; font-size: 13px;\">化学型</span><span style=\"font-family:;\">”</span><span style=\"font-family: 宋体; font-size: 13px;\">中毒，却不是高温处理能</span><span style=\"font-family:;\">“</span><span style=\"font-family: 宋体; font-size: 13px;\">消毒</span><span style=\"font-family:;\">”</span><span style=\"font-family: 宋体; font-size: 13px;\">的，有时煮沸反而使毒物浓度增大。比如鲜白菜中含无毒的硝酸盐，由于细菌分解，白菜中产生大量亚硝酸盐毒物。此外，还有发芽和未成熟土豆中的龙葵碱、油料中的黄曲霉素等，均是高温不能破坏的毒物。还有其他被化学毒品污染过的食品，加热也是去不掉毒素的。</span><span style=\"font-family:;\">&nbsp;<br/></span><span style=\"font-family: 宋体; font-size: 13px;\">&nbsp;&nbsp; 由此可见，要想避免中毒，不可用</span><span style=\"font-family:;\">“</span><span style=\"font-family: 宋体; font-size: 13px;\">加热消毒法</span><span style=\"font-family:;\">”</span><span style=\"font-family: 宋体; font-size: 13px;\">作为惟一去毒办法。要特别重视预防，切断可能的毒物污染源，更不可轻视慢性食物中毒。</span></p>',1,'2017-04-06 13:28:31',7),
	(4,28,1,'专家称少吃饭多吃菜不利健康 每天应吃六两米','<p>&nbsp;<img title=\"1491456849943600.jpg\" alt=\"timg (1).jpg\" src=\"/ueditor/php/upload/image/20170406/1491456849943600.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">每到吃饭时只要</span><span style=\"font-family: Times New Roman;\">1</span><span style=\"font-family: 宋体;\">两的饭，最后还剩下半两，而菜却吃很多，这是不少都市人的惯常做法。近日专家明确表示，长期不吃或少吃米饭等主食，对身体健康极其不利。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">据介绍，米饭以及面食的主要成分是碳水化合物，它是既经济又能直接转化的热量营养。从人体的物质结构来说，人体以及身上的器官</span><span style=\"font-family: Times New Roman;\">99%</span><span style=\"font-family: 宋体;\">是由水组成的，碳水化合物正是我们身体所需的主要</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">基础原料</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">。在合理的饮食中，人一天所需要的总热能的</span><span style=\"font-family: Times New Roman;\">50%</span><span style=\"font-family: 宋体;\">至</span><span style=\"font-family: Times New Roman;\">60%</span><span style=\"font-family: 宋体;\">来自于碳水化合物。米饭同菜中的大鱼大肉相比，要容易消化得多，饭也有着其他营养成分不可代替的必需性。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">按照中国人的体质状况，一个成人每天应当至少吃</span><span style=\"font-family: Times New Roman;\">6</span><span style=\"font-family: 宋体;\">两米饭，否则，如果长期吃含有高蛋白、高脂肪、低纤维的菜，极容易得高血压、心血管病和肥胖病。即便没有，亚健康也会悄悄袭向你的身体。而有关调查数据表明，在白领群体中，亚健康者已经达到</span><span style=\"font-family: Times New Roman;\">9</span><span style=\"font-family: 宋体;\">成。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">为了尽快从亚健康状态中走出来，傅教授建议，白领族们应当纠正不吃或少吃米饭的习惯，改善维生素摄入不足的情况。首先要调整膳食结构，改变粮食越吃越白、饭越吃越少的不良习惯，在适当增加动物血、动物肝脏、胡萝卜摄入量的同时，建议白领青年每人每天摄入一定量的维生素，以满足人体健康对维生素的需要。</span></p>',1,'2017-04-06 13:34:18',1),
	(5,28,1,'饮用不合格水桶盛装的水可能会致癌','<p>&nbsp;<img title=\"1491457023688336.jpg\" alt=\"timg (2).jpg\" src=\"/ueditor/php/upload/image/20170406/1491457023688336.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">饮用水安全问题一直引起消费者的强烈关注。食用不合格水桶盛装的饮用水可能致癌。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">不合格水桶多数是以回收的各种废旧塑料经过二次加工制成。据专家介绍，这种水桶本身就是一个巨大的污染源，它所包含的有害物质乙醛溶于水中，使水质发生化学变化，饮用这种水对人体危害性极大，特别容易伤害饮用者的神经系统并引起癌症。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">根据资料，一个新的合格水桶的价格一般不超过</span><span style=\"font-family: Times New Roman;\">30</span><span style=\"font-family: 宋体;\">元，而且在使用了</span><span style=\"font-family: Times New Roman;\">2</span><span style=\"font-family: 宋体;\">－</span><span style=\"font-family: Times New Roman;\">3</span><span style=\"font-family: 宋体;\">年后就必须淘汰更新。此外每发展一个客户同时还需要</span><span style=\"font-family: Times New Roman;\">22</span><span style=\"font-family: 宋体;\">－</span><span style=\"font-family: Times New Roman;\">25</span><span style=\"font-family: 宋体;\">个水桶的储备量。由于需求量大、耗损率高，用于水桶的投资常常超过其它生产设备的投资。所以降低水桶的成本成了桶装水生产厂家控制总成本的关键，而过高的水桶成本就成为制约杂牌桶装水企业经营的瓶颈。这种情形为不合格水桶的大量出现提供了市场。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">据专业人士介绍，普通消费者可以通过目测、手感、按压等方式识别真伪。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">首先可通过目测。正规水桶桶底标有生产厂家和生产日期，一些新投放市场的水桶上还贴着用激光防伪技术制作的产品合格证。桶体透明度高，颜色为蓝色或白色。不合格水桶透明度差，颜色为深蓝色或紫色，有时还会有黑点，这是经过二次加工的塑料的特有外观。有的桶上贴有假冒的激光防伪合格证，但用指甲刮几下就会脱落。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">其次，可通过手感。正规桶表面光滑。不合格水桶摸上去高低不平，特别是瓶口摸着会感到扎手。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">再次，可通过按压。将空桶放在地上用力往下按，正规桶弹性较好，受压形成的形变松手后即可恢复，而用二次加工塑料制成的不合格水桶弹性很差，变形后难以恢复。</span></p>',1,'2017-04-06 13:37:06',1),
	(6,28,1,'老年人应多摄取卵磷脂','<p>&nbsp;<img title=\"1491457152797551.jpg\" alt=\"timg (3).jpg\" src=\"/ueditor/php/upload/image/20170406/1491457152797551.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">卵磷脂，又称蛋黄素，是一种天然物质。它既不是维生素，又不是矿物质，在营养素家族中，它好比是一个养子。卵磷脂在人体内不能自行合成，只能从食物中摄取。卵磷脂是构成脑神经组织、脑脊髓的主要成分，约占脑组织的</span><span style=\"font-family: Times New Roman;\">1/5</span><span style=\"font-family: 宋体;\">。有很强的健脑作用，也是形成血细胞和细胞膜所必需的原料，并能促进血细胞的新生和发育，对衰老的细胞有振奋和补血作用。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">卵磷脂既有亲水性，又有亲油性。因此，它能溶解胆固醇，洗刷附着于血管壁上的废物，防止动脉粥样硬化。此外，它还能促使血液中的油脂、糖类和水分亲和、游离，使血液变得相对稀薄、流畅。卵磷脂的这两种功能，十分有益于对心血管疾病的防治。由于血液变得相对稀薄、流畅，使营养和氧气源源不断供给大脑，故能有效地改善人脑的记忆力，提高思维能力。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">因此，老年人在日常膳食中，要多食些大豆、玉米、蛋黄、葵花籽、鱼肉、鹌鹑肉和鹌鹑蛋、动物脑等营养食物，摄取其中的卵磷脂，补充大脑所需，以改善老年人心脏和大脑功能。</span></p>',1,'2017-04-06 13:39:14',0),
	(7,28,1,'大豆，天然的雌激素','<p>&nbsp;<img title=\"1491457511126788.jpg\" alt=\"timg (4).jpg\" src=\"/ueditor/php/upload/image/20170406/1491457511126788.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">在对更年期妇女进行雌激素替代疗法的危险性被揭开以后，大豆已经成为更年期妇女的天然药物，它既能起到雌激素的作用，又不会有致癌危险。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">大豆营养价值很高，主要含有</span><span style=\"font-family: Times New Roman;\">35</span><span style=\"font-family: 宋体;\">％的植物蛋白质及约</span><span style=\"font-family: Times New Roman;\">20</span><span style=\"font-family: 宋体;\">％的植物油脂、淀粉、大豆卵磷脂、维他命</span><span style=\"font-family: Times New Roman;\">E</span><span style=\"font-family: 宋体;\">、异黄酮、矿物质等健康物质，饱和脂肪酸含量少而不含胆固醇。大豆具有预防心血管疾病、抗癌抗衰老的作用。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">更重要的是大豆中含有天然植物性雌激素。大豆中的天然植物雌激素主要包括异黄酮（</span><span style=\"font-family: Times New Roman;\">Isoflavones</span><span style=\"font-family: 宋体;\">）、植物固醇、皂素以及木酚等，它们集中在一起后，效用明显，并且非常柔和，不像直接服用雌激素会产生副作用。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">妇女停经后，卵巢萎缩，雌激素分泌不足，骨钙容易流失而造成骨质疏松，冠状动脉硬化而造成心脏病。对于更年期或切除卵巢后停经的妇女，从植物中摄取足够的植物雌激素，便能预防停经后的各种症状。据研究发现，东方人食用大豆是西方人的两倍，所以统计发现，大豆喜好者的子宫癌与心脏病发生率都比较低，而这些人，如日本人发生更年期症状也比较缓和。流行病学调查结果显示，在日本有</span><span style=\"font-family: Times New Roman;\">25</span><span style=\"font-family: 宋体;\">％的更年期女性有潮热、出汗等症状，但在北美这种女性则高达</span><span style=\"font-family: Times New Roman;\">85</span><span style=\"font-family: 宋体;\">％。世界卫生组织对日本和欧美绝经女性骨质疏松发病率进行比较，发现日本骨质疏松和髋骨骨折发病率明显低于欧美等国。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">据研究，一杯大豆大约含有</span><span style=\"font-family: Times New Roman;\">300</span><span style=\"font-family: 宋体;\">毫克异黄酮，药理作用相当于西药雌激素</span><span style=\"font-family: Times New Roman;\">0.4</span><span style=\"font-family: 宋体;\">毫克。停经妇女每日摄食含有</span><span style=\"font-family: Times New Roman;\">200</span><span style=\"font-family: 宋体;\">毫克异黄酮的大豆或大豆食品，即可显现雌激素的功效，产生如下效果：阴道内表层细胞数增多，分泌液增加，抵消停经后阴道萎缩、干燥所引起的不适感。此外研究还发现，大豆中的植物雌激素还能预防某些受荷尔蒙影响的癌症，如女性的乳腺癌和男性的前列腺癌等。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">如何摄取大豆中的植物激素？现在西方有从大豆中提取高纯度的大豆异黄酮类保健品，而对于东方人来说就很简单了，豆腐、豆浆、豆花、豆。</span></p>',1,'2017-04-06 13:45:14',0),
	(8,28,1,'五种开水不能喝','<p>&nbsp;<img title=\"1491457980653652.jpg\" alt=\"timg (5).jpg\" src=\"/ueditor/php/upload/image/20170406/1491457980653652.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">研究表明，饮用开水的重新煮沸会造成水中亚硝酸含量的超标。医学专家介绍，水中的亚硝酸过量、超标，可不同程度地引起人的身体倦怠、乏力、嗜睡、昏迷、全身青紫、血压下降、腹痛、腹泻、呕吐，日久还能引起恶性病。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">如此说来，开水也不可随便乱喝，而防治开水污染的方法很简单，即坚决杜绝开水的重复利用，重复煮沸。具体有以下几种：</span><span style=\"font-family: Times New Roman;\">1.</span><span style=\"font-family: 宋体;\">在炉灶上烧了一整夜或很长时间，饮用时已经是不冷不热的开水。</span><span style=\"font-family: Times New Roman;\">2.</span><span style=\"font-family: 宋体;\">自动热水器中隔夜重煮的开水。</span><span style=\"font-family: Times New Roman;\">3.</span><span style=\"font-family: 宋体;\">经过多次反复煮沸的残留开水。</span><span style=\"font-family: Times New Roman;\">4.</span><span style=\"font-family: 宋体;\">盛在保温瓶中已非是当天的水。</span><span style=\"font-family: Times New Roman;\">5.</span><span style=\"font-family: 宋体;\">蒸过饭肉等食物的剩开水。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">此外，专家还提醒人们，凉白开水不能在空气中暴露太久，否则会失去生物活性，从而失去很多特殊功能。</span><span style=\"font-family: Times New Roman;\">&nbsp;</span></p>',1,'2017-04-06 13:53:04',0),
	(9,28,1,'选择怎样的食用油最合理','<p>&nbsp;<img title=\"1491458074108831.jpg\" alt=\"timg (6).jpg\" src=\"/ueditor/php/upload/image/20170406/1491458074108831.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">花生油、大豆油、粟米油、橄榄油</span><span style=\"font-family: Times New Roman;\">……</span><span style=\"font-family: 宋体;\">面对各种各样的食用油，你知道怎样选择才是最合理的吗？</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">营养学家告诉我们，选油首先要看营养成分。植物油的成分主要分为饱和脂肪酸、单不饱和脂肪酸和多不饱和脂肪酸，不同的脂肪酸，对人体健康有不同的影响。早在上世纪</span><span style=\"font-family: Times New Roman;\">70</span><span style=\"font-family: 宋体;\">年代，世界卫生组织、联合国粮农组织就提出了</span><span style=\"font-family: Times New Roman;\">“1</span><span style=\"font-family: 宋体;\">∶</span><span style=\"font-family: Times New Roman;\">1</span><span style=\"font-family: 宋体;\">∶</span><span style=\"font-family: Times New Roman;\">1”</span><span style=\"font-family: 宋体;\">的概念，因为营养学家经过长期研究后认为，膳食中三种脂肪酸达到</span><span style=\"font-family: Times New Roman;\">1</span><span style=\"font-family: 宋体;\">∶</span><span style=\"font-family: Times New Roman;\">1</span><span style=\"font-family: 宋体;\">∶</span><span style=\"font-family: Times New Roman;\">1</span><span style=\"font-family: 宋体;\">的比例时，能够保证营养平衡，更有利于人体健康。中国营养学会在</span><span style=\"font-family: Times New Roman;\">2000</span><span style=\"font-family: 宋体;\">年也提出了类似的标准。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">由于不同植物油的脂肪酸含量和比例不同，营养专家提出：各种油轮换着吃，或者搭配着吃最好，这样才能接近</span><span style=\"font-family: Times New Roman;\">1</span><span style=\"font-family: 宋体;\">∶</span><span style=\"font-family: Times New Roman;\">1</span><span style=\"font-family: 宋体;\">∶</span><span style=\"font-family: Times New Roman;\">1</span><span style=\"font-family: 宋体;\">的比例，而且减少因某种脂肪酸摄入不均衡对人体产生的危害。不过，这一切说来容易，做却不简单。让老百姓拿着一份油谱，拿着计算器换算，然后轮换买不同的油，真是勉为其难，毕竟大家是在过日子，不是在做实验。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">根据上述需要，金龙鱼推出了</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">第二代调和油</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">，这种调和油用</span><span style=\"font-family: Times New Roman;\">8</span><span style=\"font-family: 宋体;\">种植物油按照独特配方调和，能够帮助人体膳食脂肪酸到达</span><span style=\"font-family: Times New Roman;\">1</span><span style=\"font-family: 宋体;\">∶</span><span style=\"font-family: Times New Roman;\">1</span><span style=\"font-family: 宋体;\">∶</span><span style=\"font-family: Times New Roman;\">1</span><span style=\"font-family: 宋体;\">的完美比例，并符合中国营养学会</span><span style=\"font-family: Times New Roman;\">DRI</span><span style=\"font-family: 宋体;\">标准，最大限度地满足消费者的健康需求，你不妨试一试。</span><span style=\"font-family: Times New Roman;\">&nbsp;</span></p>',1,'2017-04-06 13:54:36',0),
	(10,28,1,'鸡蛋蛋黄中的抗体混合物可能阻止病菌传播','<p>&nbsp;<img title=\"1491458695449079.jpg\" alt=\"timg (7).jpg\" src=\"/ueditor/php/upload/image/20170406/1491458695449079.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">科学家称，一种从普通鸡蛋蛋黄中培养出的抗体混合物，可能阻止源于食品、且每年导致数千美国人丧生的病菌传播。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">加拿大阿尔伯塔大学的研究者发现，注射过大肠杆菌等食物产生的病原体的母鸡，可以产生对该病菌的抗体。这种抗体会在该母鸡产下的鸡蛋蛋黄中积累。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">该研究由阿尔伯塔大学的食品化学家负责，报告发表在美国化学学会的年会上。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">在给母鸡注射过不同病原体之後，研究者对蛋黄中产生的每一种抗体进行了提取、处理并乾燥冷冻。然後将这些抗体混合在一起；科学家认为这样配制成的混合液可以对付大多数源于食品的病菌。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">在试管内的初步研究中，与抗体有过接触的食品源病菌无法进行繁殖。科学家称，进一步的研究有望显示，将抗体喷洒在食物表面，它们便可以阻止病菌。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">用于更广泛的食物种类，如肉类、水果和蔬菜的实验预计在六个月之内进行；人体实验会在一年内实施。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">科学家正在进行研究，这种混合制剂是否适用于生产肉类产品的各个阶段。例如，牛只屠宰後就在上面喷洒制剂以防污染，或者在切割包装时再进行处理。</span></p>',1,'2017-04-06 14:04:58',0),
	(11,28,1,'韭菜叶壮色鲜要多留神可能农药超标','<p><img title=\"1491458842636224.jpg\" alt=\"timg (8).jpg\" src=\"/ueditor/php/upload/image/20170406/1491458842636224.jpg\"/>&nbsp;</p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">韭菜一直是市民春天饭桌上的佳蔬，但今后食用时要当心了！卫生局卫生监督所近日对</span><span style=\"font-family: 宋体;\">集贸市场的</span><span style=\"font-family: Times New Roman;\">15</span><span style=\"font-family: 宋体;\">件韭菜样品抽检时，发现</span><span style=\"font-family: Times New Roman;\">3</span><span style=\"font-family: 宋体;\">件样品上有机磷农药残留量严重超标。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">据卫生监督人员说，这些韭菜叶茎又粗又壮、颜色鲜绿，很可能在生长过程中使用了国家禁止在蔬菜上使用的呋喃丹、甲基对硫磷等高毒有机磷农药。由于韭菜是多年生蔬菜，占地时间长，其根部容易遭到虫害侵袭，一些不懂农药危害及喷洒知识的韭农便将这种农药随着水流灌浇根茎部，这样不但可以有效地去除害虫，而且还能促进根系发育，让韭菜长得粗壮肥大，色泽鲜亮，在市场上卖个好价钱。市民如果食用了含有大量这种农药的韭菜后，会引起神经功能紊乱，出现多汗、语言失常、头晕、头痛、腹痛、流涎、痉挛等症状，严重者还会出现惊厥、昏迷、肺水肿，甚至突然停止呼吸而死亡。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">卫生监督人员提醒广大市民：在购买韭菜时别光注意其</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">美丽外表</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">，还要多仔细观察叶茎部；食用韭菜前要用流动水反复冲洗，或者用淡盐水浸泡半天以上，以确保将残留的农药冲洗干净。</span></p>',1,'2017-04-06 14:07:35',0),
	(12,28,1,'饮茶四季有别','<p>&nbsp;<img title=\"1491459367106473.jpg\" alt=\"timg (9).jpg\" src=\"/ueditor/php/upload/image/20170406/1491459367106473.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">我国民间有句老话：</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">当家度日七件事，柴米油盐酱醋茶</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">，这话说明茶在我国人民生活中必不可少。然而人们只知道饮茶很有乐趣，而且对人体健康有益，却不知道饮茶还有学问，如不同季节饮什么茶就大有讲究。祖国医学主张：春饮花茶，夏饮绿茶，秋饮青茶，冬饮红茶。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">春饮花茶</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\"><img title=\"1491459440539661.jpg\" alt=\"timg (10).jpg\" src=\"/ueditor/php/upload/image/20170406/1491459440539661.jpg\"/></span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">我国大部分地区是季风气候，春温、夏热、秋凉、冬寒，四季极为分明。在春天的日子里，春风复苏，阳气生发，给万物带来了生机，但这时人们却普遍感到困倦乏力，表现为春困现象。人喝花茶，能缓解春困带来的不良影响。花茶甘凉而兼芳香辛散之气，有利于散发积聚在人体内的冬季寒邪、促进体内阳气生发，令人神清气爽，可使</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">春困</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">自消。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">花茶是集茶味之美、鲜花之香于一体的茶中珍品。</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">花引茶香，相得益彰</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">，它是利用烘青毛茶及其他茶类毛茶的吸味特性和鲜花的吐香特性的原理，将茶叶和鲜花拌和窨制而成，以茉莉花茶最为有名。这是因为，茉莉花香气清婉，入茶饮之浓醇爽口，馥郁宜人。高档花茶的泡饮，应选用透明玻璃盖杯，取花茶</span><span style=\"font-family: Times New Roman;\">3</span><span style=\"font-family: 宋体;\">克</span><span style=\"font-family: 宋体;\">，放入杯里，用初沸开水稍凉至</span><span style=\"font-family: Times New Roman;\">90</span><span style=\"font-family: 宋体;\">℃</span><span style=\"font-family: 宋体;\">左右冲泡，随即盖上杯盖，以防香气散失。二三分钟后，即可品饮，顿觉芬芳扑鼻，令人心旷神怡。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">夏饮绿茶</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\"><img title=\"1491459468106043.jpg\" alt=\"timg (11).jpg\" src=\"/ueditor/php/upload/image/20170406/1491459468106043.jpg\"/></span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">夏日炎热，骄阳似火，人在其中，挥汗如雨，人的体力消耗很多，精神不振，这时以品绿茶为好。因绿茶属未发酵茶，性寒，</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">寒可清热</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">，最能去火，生津止渴，消食化痰，对口腔和轻度胃溃疡有加速愈合的作用。而且它营养成分较高，还具有降血脂、防血管硬化等药用价值。这种茶冲泡后水色清冽，香气清幽，滋味鲜爽，夏日常饮，清热解暑，强身益体。绿茶中的珍品，有浙江杭州狮峰的龙井，汤色碧绿，清香宜人，被誉为</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">中国绿茶魁首</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">；江苏太湖碧螺春，茶色碧翠嫩绿，香气浓郁；安徽黄山毛峰，茶味清香。　　冲泡绿茶，直取</span><span style=\"font-family: Times New Roman;\">90</span><span style=\"font-family: 宋体;\">℃</span><span style=\"font-family: 宋体;\">开水泡之，高级绿茶和细嫩的名茶，其芽叶细嫩，香气也多为低沸点的清香型，用</span><span style=\"font-family: Times New Roman;\">80</span><span style=\"font-family: 宋体;\">℃</span><span style=\"font-family: 宋体;\">开水冲泡即可，冲泡时不必盖上杯盖，以免产生热闷气，影响茶汤的鲜爽度。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">秋饮青茶</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\"><img title=\"1491459502105724.jpg\" alt=\"timg (12).jpg\" src=\"/ueditor/php/upload/image/20170406/1491459502105724.jpg\"/></span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">秋天，天高云淡，金风萧瑟，花木凋落，气候干燥，令人口干舌燥，嘴唇干裂，中医称之</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">秋燥</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">，这时宜饮用青茶。青茶，又称乌龙茶，属半发酵茶，介于绿、红茶之间。色泽青褐，冲泡后可看到叶片中间呈青色，叶缘呈红色，素有</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">青叶镶边</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">美称，既有绿茶的清香和天然花香，又有红茶醇厚的滋味，不寒不热，温热适中，有润肤、润喉、生津、清除体内积热，让机体适应自然环境变化的作用。常见的乌龙茶名品有福建乌龙、广东乌龙、台湾乌龙，以闽北武夷岩茶、闽南安溪铁观音为著名。但乌龙茶类很多以茶树品种而分，有铁观音、奇兰、梅占、水仙、桃仁、毛蟹等。乌龙茶习惯浓饮，注重品味闻香，冲泡乌龙茶需</span><span style=\"font-family: Times New Roman;\">100</span><span style=\"font-family: 宋体;\">℃</span><span style=\"font-family: 宋体;\">沸水，泡后片刻将茶壶里的茶水倒入茶杯里，品时香气浓郁，齿颊留香。</span> </p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">冬饮红茶</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\"><img title=\"1491459537678826.jpg\" alt=\"timg (13).jpg\" src=\"/ueditor/php/upload/image/20170406/1491459537678826.jpg\"/></span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">冬天，天寒地冻，万物蛰伏，寒邪袭人，人体生理功能减退，阳气渐弱，中医认为：</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">时届寒冬，万物生机闭藏，人的机体生理活动处于抑制状态。养生之道，贵乎御寒保暖</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">，因而冬天喝茶以红茶为上品。红茶甘温，可养人体阳气；红茶含有丰富的蛋白质和糖，生热暧腹，增强人体的抗寒能力，还可助消化，去油腻。红茶类在加工过程中经过充分发酵，使茶鞣质氧化，故又称全发酵茶。茶鲜叶经过氧化后形成红色的氧化聚合产物</span><span style=\"font-family: Times New Roman;\">———</span><span style=\"font-family: 宋体;\">茶黄素、茶红素、茶褐素，这些色素一部分溶于水，冲泡形成了红色茶汤。传统工夫红茶名品有湖红、宜红、宁红、闽红、台红、祁红，以安徽祁门县的祁红为著名。冲泡红茶，宜用刚煮沸的水冲泡，并加以杯盖，以免释放香味。英国人普遍有饮</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">午后茶</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">习惯，常将祁红和印度红茶拼配，再加牛奶、砂糖饮用。在我国一些地方，也有将红茶加糖、奶、芝麻饮用的习惯，这样既能生热暖腹，又可增添营养，强身健体。</span></p>',1,'2017-04-06 14:19:00',0),
	(13,28,1,'食品不宜冷冻过久','<p>&nbsp;<img title=\"1491460379400195.jpg\" alt=\"timg (14).jpg\" src=\"/ueditor/php/upload/image/20170406/1491460379400195.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">据消化内科专家介绍，冷冻食品存放时间过长很容易变质，食品中的蛋白质可分解产生</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">可溶性毒蛋白</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">、</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">胺类</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">、</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">恶臭素</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">等，而这些毒素即便高温加热也很难被破坏，食用后会造成胃肠道感染。他提醒市民：食用冷冻食品时应注意辨别其色、状是否有变化，特别是食用冷冻时间超过两个月的食品时要更加谨慎。</span></p>',1,'2017-04-06 14:33:01',0),
	(14,28,1,'这样吃菜有害健康','<p>&nbsp;<img title=\"1491461813874147.jpg\" alt=\"timg (15).jpg\" src=\"/ueditor/php/upload/image/20170406/1491461813874147.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">久存蔬菜：新鲜的青菜，买来存在家里不吃，便会慢慢损失一些维生素，如菠菜在</span><span style=\"font-family: Times New Roman;\">20</span><span style=\"font-family: 宋体;\">度时，维生素</span><span style=\"font-family: Times New Roman;\">C</span><span style=\"font-family: 宋体;\">损失达</span><span style=\"font-family: Times New Roman;\">84%</span><span style=\"font-family: 宋体;\">。若要保存蔬菜，应在避光，通风，干燥的地方贮存。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">丢弃了含维生素最丰富的部分　　例如豆芽，有人在吃时只吃上面的芽而将豆子丢掉。事实上，豆中含维生素</span><span style=\"font-family: Times New Roman;\">C</span><span style=\"font-family: 宋体;\">比芽的部分多</span><span style=\"font-family: Times New Roman;\">2-3</span><span style=\"font-family: 宋体;\">倍。再就是做饺子馅把菜汁挤掉，维生素会损失</span><span style=\"font-family: Times New Roman;\">70%</span><span style=\"font-family: 宋体;\">以上。正确的方法是，切好菜后用油拌好，再加盐和调料，这样油包菜就不会出汤。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">用铜炊具烧菜　　因为铜会促进维生素</span><span style=\"font-family: Times New Roman;\">C</span><span style=\"font-family: 宋体;\">，</span><span style=\"font-family: Times New Roman;\">B1</span><span style=\"font-family: 宋体;\">都怕热，怕煮，据测定，大火快炒的菜，维生素</span><span style=\"font-family: Times New Roman;\">C</span><span style=\"font-family: 宋体;\">损失仅</span><span style=\"font-family: Times New Roman;\">17%</span><span style=\"font-family: 宋体;\">，若炒后再焖，菜里的</span><span style=\"font-family: Times New Roman;\">C</span><span style=\"font-family: 宋体;\">损失</span><span style=\"font-family: Times New Roman;\">59%</span><span style=\"font-family: 宋体;\">，所以炒菜要用旺火，这样炒出来的菜，不仅色美味好，而且营养损失少。烧菜时加少许醋，也有利于维生素的保存。还有些蔬菜如黄瓜、西红柿等，最好生拌吃。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">烧好的菜不马上吃：有人为节省时间，喜欢提前把菜烧好，然后在锅里温着等人来齐再吃或下顿热着吃。其实蔬菜中的维生素</span><span style=\"font-family: Times New Roman;\">B1</span><span style=\"font-family: 宋体;\">，在烧好后温热的过程中可损失</span><span style=\"font-family: Times New Roman;\">25%</span><span style=\"font-family: 宋体;\">。烧好的白菜若温热</span><span style=\"font-family: Times New Roman;\">15</span><span style=\"font-family: 宋体;\">分钟可损失维生素</span><span style=\"font-family: Times New Roman;\">C25%</span><span style=\"font-family: 宋体;\">，保温</span><span style=\"font-family: Times New Roman;\">30</span><span style=\"font-family: 宋体;\">分钟会损失</span><span style=\"font-family: Times New Roman;\">10%</span><span style=\"font-family: 宋体;\">，若长到</span><span style=\"font-family: Times New Roman;\">1</span><span style=\"font-family: 宋体;\">小时，就会损失</span><span style=\"font-family: Times New Roman;\">20%</span><span style=\"font-family: 宋体;\">。假若青菜中的维生素</span><span style=\"font-family: Times New Roman;\">C</span><span style=\"font-family: 宋体;\">在烹调过程中损失</span><span style=\"font-family: Times New Roman;\">20%</span><span style=\"font-family: 宋体;\">，溶解在菜汤中损失</span><span style=\"font-family: Times New Roman;\">25%</span><span style=\"font-family: 宋体;\">，再在火上温热</span><span style=\"font-family: Times New Roman;\">15</span><span style=\"font-family: 宋体;\">分钟会再损失</span><span style=\"font-family: Times New Roman;\">20%</span><span style=\"font-family: 宋体;\">，共计</span><span style=\"font-family: Times New Roman;\">65%</span><span style=\"font-family: 宋体;\">。那么我们从青菜中得到的维生素就所剩无几了。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">吃菜不渴汤：许多人爱吃青菜却不爱喝汤，事实上，烧菜时，大部分维生素溶解在菜汤里。以维生素</span><span style=\"font-family: Times New Roman;\">C</span><span style=\"font-family: 宋体;\">为例，小白菜炒好后，维生素</span><span style=\"font-family: Times New Roman;\">C</span><span style=\"font-family: 宋体;\">会有</span><span style=\"font-family: Times New Roman;\">70%</span><span style=\"font-family: 宋体;\">溶解在菜汤里，新鲜豌豆放在水里煮沸</span><span style=\"font-family: Times New Roman;\">3</span><span style=\"font-family: 宋体;\">分钟，维生素</span><span style=\"font-family: Times New Roman;\">C</span><span style=\"font-family: 宋体;\">有</span><span style=\"font-family: Times New Roman;\">50%</span><span style=\"font-family: 宋体;\">溶在汤里。在洗切青菜时，若将菜切了再冲洗，大量维生素就会流失到水中。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\"><img title=\"1491461823775604.jpg\" alt=\"timg.jpg\" src=\"/ueditor/php/upload/image/20170406/1491461823775604.jpg\"/></span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">偏爱吃炒菜：有些人为了减肥不食脂肪而偏爱吃加在肉里的蔬菜。最近据研究人员发现，凡是含水分丰富的蔬菜，其细胞之间充满空气，而肉类的细胞之间却充满了水，所以蔬菜更容易吸收油脂，一碟炒菜所吸入的油脂比一碟炸鱼或炸排骨所含的油脂更多。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">吃素不吃荤：时下素食的人越来越多，这对防止动脉硬化无疑是有益的。但是不注意搭配、一味吃素也并非是福。现代发现吃素至少有四大害处：一是缺少必要的胆固醇，而适量的胆固醇具有抗癌作用；二是蛋白质摄入不足，这是引起消化道肿瘤的危险因素；三是核黄素摄入量不足，导致维生素缺乏；四是严重缺锌。锌是保证机体免疫功能健全的一种十分重要的微量元素，而一般蔬菜中都缺乏锌。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">喜欢生吃而清洗：蔬菜的污染一是农药，二是霉菌。进食蔬菜发生农药中毒而见诸报端的事件已经屡见不鲜。蔬菜是霉菌的寄生体，大都不溶于水，甚至有的在沸水中安然无恙。它能进入蔬菜的表面几毫米深。因此蔬菜必须用清水多洗多泡，去皮，多丢掉一些老黄腐叶，切勿吝惜，特别是生吃更应该如此，不然，会给你的身体健康带来危害。</span></p>',1,'2017-04-06 14:57:05',0),
	(15,28,1,'检验查出DEHA，当心你家的保鲜膜','<p>&nbsp;<img title=\"1491461973544782.jpg\" alt=\"timg (16).jpg\" src=\"/ueditor/php/upload/image/20170406/1491461973544782.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">在直接用来包装食品的保鲜膜内检出</span><span style=\"font-family: Times New Roman;\">DEHA</span><span style=\"font-family: 宋体;\">（乙基己基胺），可以说是食品安全方面的一种潜在威胁。聚氯乙烯保鲜膜如果被用来包装外卖的食品，</span><span style=\"font-family: Times New Roman;\">DEHA</span><span style=\"font-family: 宋体;\">有可能会传给食品。安全的保鲜膜用的是低密度聚乙烯。购买保鲜膜时，最简单的鉴别方法就是</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">一看、二摸、三火烧</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">塑料袋造成的</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">白色恐怖</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">尚未解除，与其同属一个家族、名字却好听得多的保鲜膜又开始源源不断地从超市流入一个个家庭。保鲜膜的一个</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">鲜</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">字给人一种易于接受的安全感，而一个</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">膜</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">字所暗示的微弱程度又让人放松了对它的警惕。殊不知它们都是来自乙烯母料，塑料袋带来的环境灾难，保鲜膜也不同程度地存在。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">前不久，韩国</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">解决垃圾问题市民运动协议会</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">针对消费行为中的环境安全问题组织了一次调查，两个多月以来，他们收集了汉城市内主要食品商场内使用的</span><span style=\"font-family: Times New Roman;\">20</span><span style=\"font-family: 宋体;\">种保鲜膜，并对其所含的重金属及环境激素状况进行了检测，在</span><span style=\"font-family: Times New Roman;\">3</span><span style=\"font-family: 宋体;\">种保鲜膜中检测出</span><span style=\"font-family: Times New Roman;\">210000~260000ppm</span><span style=\"font-family: 宋体;\">的乙基己基胺（</span><span style=\"font-family: Times New Roman;\">DEHA</span><span style=\"font-family: 宋体;\">）。</span><span style=\"font-family: Times New Roman;\">1998</span><span style=\"font-family: 宋体;\">年，美国消费者权益组织对奶酪包装用聚氯乙烯保鲜膜也做过一次检测，结果表明其</span><span style=\"font-family: Times New Roman;\">DEHA</span><span style=\"font-family: 宋体;\">含量为</span><span style=\"font-family: Times New Roman;\">5500~21700ppm</span><span style=\"font-family: 宋体;\">，韩国的检测结果是这一数字的</span><span style=\"font-family: Times New Roman;\">10~40</span><span style=\"font-family: 宋体;\">倍。日本国立医药品食品卫生研究所早在</span><span style=\"font-family: Times New Roman;\">6</span><span style=\"font-family: 宋体;\">年前就已将</span><span style=\"font-family: Times New Roman;\">DEHA</span><span style=\"font-family: 宋体;\">定为环境激素物质，美国环境保护局也将其划入环境激素怀疑物质。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">解决垃圾问题市民运动协议会</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">强调指出，</span><span style=\"font-family: Times New Roman;\">DEHA</span><span style=\"font-family: 宋体;\">不同于铅、镉，但目前在《食品卫生法》上尚无任何限制规定，在直接用来包装食品的保鲜膜内检出</span><span style=\"font-family: Times New Roman;\">DEHA</span><span style=\"font-family: 宋体;\">，可以说是食品安全方面的一种潜在威胁。聚氯乙烯保鲜膜如果被用来包装外卖的食品，</span><span style=\"font-family: Times New Roman;\">DEHA</span><span style=\"font-family: 宋体;\">有可能会传给食品。协议会呼吁政府应进行细致地调查，采取限制措施，流通领域和食品店也应改用低密度聚乙烯（</span><span style=\"font-family: Times New Roman;\">PE</span><span style=\"font-family: 宋体;\">）保鲜膜。那么，依然在使用中的保鲜膜，如果从卫生安全上考虑应该怎样识别呢？</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">目前市售的保鲜膜有两种，不安全的保鲜膜其实就是聚氯乙烯，亦即常说的</span><span style=\"font-family: Times New Roman;\">PVC</span><span style=\"font-family: 宋体;\">，有毒；安全的保鲜膜用的是低密度聚乙烯。一种简单的鉴别方法就是</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">一看、二摸、三火烧</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">。首先，购买保鲜膜时，要看包装上的说明，正规厂家生产的保鲜膜，外盒上都会注明保鲜膜的材质，如果是</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">线性低密度聚乙烯</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">，就可以放心使用。如果注明是用</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">聚氯乙烯</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">或者</span><span style=\"font-family: Times New Roman;\">“PVC”</span><span style=\"font-family: 宋体;\">材料制成，就不要买；其次是手摸，安全材料制成的保鲜膜，弹性很好，贴在食品、碗口上又紧又薄，如果用力拉扯，即使扯得很长也不易破断。而</span><span style=\"font-family: Times New Roman;\">PVC</span><span style=\"font-family: 宋体;\">保鲜膜就没有这么好的韧性，摸上去手感偏厚、弹性较差；最后一招是火烧，可以剪一块保鲜膜点火试一试。</span><span style=\"font-family: Times New Roman;\">PVC</span><span style=\"font-family: 宋体;\">不容易点燃，燃烧时有一股刺鼻的塑料臭味。线性低密度聚乙烯则很容易燃烧，而且边烧边滴落，散发出类似蜡烛的气味。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">安全的保鲜膜其生产过程严格有别于工业包装用的聚氯乙烯，比如，加工具有复合功能的果蔬保鲜膜时，要调配抗氧化剂、抑制剂、灭菌剂、护色剂、成膜剂等多种成分，其中的抑菌剂、灭菌剂配合，可杀灭采摘后果蔬表面残留的有害病菌，并抑制其繁殖，防止果蔬腐烂；抗氧化剂与护色剂配合，可抑制果蔬各种生物酶的生理活性，减缓果蔬老化，并维持果蔬原有的鲜嫩色泽；成膜剂的主要功能则是抑制果蔬呼吸，减少和除去乙烯气体，防止水分挥发。涂膜法果蔬保鲜操作时只需将果蔬放入事先配制好的涂膜保鲜液中浸泡数秒钟，取出后自然晾干或用自然风吹干，果蔬表面即可形成一层半透气性、透明质保鲜膜，放在阴凉房间或地窖中即可长期保鲜贮存。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">同塑料袋一样，保鲜膜也属于将被绿色生活淘汰的对象。但是，在尚未找到合适的替代品之前，学会对它们安全性的鉴别，无论于内于外，都是必不可少的一项保护措施。</span></p>',1,'2017-04-06 14:59:38',0),
	(16,28,1,'怎样饮水最科学','<p>&nbsp;<img title=\"1491462503548052.jpg\" alt=\"timg (17).jpg\" src=\"/ueditor/php/upload/image/20170406/1491462503548052.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">要定时饮水，不要只在口渴时才想起饮水。要知道，当身体特别想喝水时，身体的器官已经在一种极限的情况下运行了，也就是说非常缺水了，应当在想喝水之前的很长时间就补充水分。专家建议，最好养成定时饮水的习惯。一般而言，最好清晨起来，刷牙后喝一杯白开水，上午十点喝一杯，午饭前再喝一杯，下午三点左右喝一杯，晚上睡觉前再来一杯。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">要多喝开水，不要喝生水。煮开并沸腾</span><span style=\"font-family: Times New Roman;\">3</span><span style=\"font-family: 宋体;\">分钟的开水，可以使水中的氯气及一些有害物质被蒸发掉，同时又能保持水中对人体必须的营养物质。喝生水的害处很多，因为自来水中的氯可以和没烧开水中的残留的有机物质相互作用，导致膀胱癌、直肠癌的机会增加。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">要喝新鲜开水，不要喝放置时间过长的水。新鲜开水，不但无菌，还含有人体所需的十几种矿物质。但如果时间过长或者饮用自动热水器中隔夜重煮的水，不仅没有了各种矿物质，而且还有可能含有某些有害物质，如亚硝酸盐等。由此引起的亚硝酸盐中毒并不鲜见。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">要多喝加盐的温热水，不要喝冰水。在夏季，不少人在大量出汗后，选择饮用冰水或冷饮。其实这是不科学的。因为这样虽然会带来暂时的舒适感，但大量饮用冰水或冷饮，会导致汗毛孔宣泄不畅，肌体散热困难，余热蓄积，极易引发中暑。正确的方法是，多喝一些加少许盐的盐水，以补充丢失的盐和水。盐水进入肌体后，会迅速渗入细胞，使不断出汗而缺水的肌体及时得到水分的补充。</span></p>',1,'2017-04-06 15:08:25',1),
	(17,28,1,'抗营养因子是什么','<p>&nbsp;<img title=\"1491462873298210.jpg\" alt=\"u=2307550950,1634816432&amp;fm=23&amp;gp=0.jpg\" src=\"/ueditor/php/upload/image/20170406/1491462873298210.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">据报道，所谓抗营养因子，是指以</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">抗胰蛋白酶</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">为主的一系列生物因子，在鲜活的动植物体内及分泌物等中广泛存在，比如生的豆浆、鸡蛋等。这些因子，一般含量极微，而且大部分人对此并不过敏，但是如果超过一定标准，也会导致人体不适，甚至死亡。尤其要注意的是，有些人，如少数儿童，会对此类因子极敏感，一有接触就有反应。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">营养与食品科学专家介绍说，豆制品中存在很多营养物质，如蛋白质、无机盐等，但同时也有不少有害的天然抗营养因子，主要是蛋白酶抑制剂、皂素、红细胞凝结素等，它们可以抑制蛋白酶的消化，其中皂素对胃肠道有刺激作用，会导致胃肠道红肿、充血。只有把这些因子去掉后豆奶才能又安全又有营养。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">有害的因子起初存在于生产豆奶的原料豆粉中，如果在加工过程中温度、时间不够，这些有害的因子就不会被消灭，人食用后就会出现中毒症状，主要表现为腹痛、恶心、头晕等症状。在加工时应以煮熟为标准，煮熟后再加热</span><span style=\"font-family: Times New Roman;\">5</span><span style=\"font-family: 宋体;\">分钟以上，这样，有害的因子就会被消灭。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">专家介绍，不仅在大豆中，四季豆、扁豆也存在这些天然抗营养因子，如果没有加工熟，人食用后也会出现中毒症状，重者可以造成生命危险，以前曾经出现的豆浆中毒、豆奶中毒、四季豆中毒均是天然抗营养因子惹的祸。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">但专家们也指出，市民绝对不要过分担心，这些因子一加热就被分解，所以加热过的奶类、鸡蛋等，可放心食用。一般鸡蛋、牛奶等煎、煮或者在微波炉中加热</span><span style=\"font-family: Times New Roman;\">3</span><span style=\"font-family: 宋体;\">到</span><span style=\"font-family: Times New Roman;\">5</span><span style=\"font-family: 宋体;\">分钟，都可以完全分解掉因子。一些市民爱食用的</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">稀黄煎鸡蛋</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">，只要时间够了，也大可以放心吃。</span></p>',1,'2017-04-06 15:14:35',0),
	(18,28,1,'选用饮料健康提示','<p>&nbsp;<img title=\"1491463041145275.jpg\" alt=\"timg (19).jpg\" src=\"/ueditor/php/upload/image/20170406/1491463041145275.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">目前中国饮料市场的大众消费是以</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">解渴</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">为主要目的，兼顾饮料营养与保健功能的</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">健康消费</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">已经开始被认同。营养强化饮料、保健饮料、茶饮料、果蔬汁饮料、植物蛋白饮料等正处于强势发展的态势，运动饮料将有较大需求。本周，由中国保健科技学会健康产业促进会、中国医科大学营养与食品卫生教研室、中国健康月刊社联合主办的</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">中国市场饮料健康价值专家研讨会</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">分别在北京和沈阳举行。与会专家提出，健康饮料成为消费趋势，但饮料不是无所不能的营养品，需要科学选用，</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">知情选择</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">才能提高生活质量。</span></p><p><span style=\"font-family: Times New Roman;\"></span><span style=\"font-family: 宋体;\">选用饮料健康提示</span> </p><p><span style=\"font-family: Times New Roman;\"></span><span style=\"font-family: 宋体;\">选用饮料应以天然、卫生、安全为原则，注意感观、颜色和味道。饮料消费时必须看清楚标签上明示的产品名称、产品成分构成、生产日期、保质期、厂名、厂址以及一些注意事项，按其明示标准把握产品质量、卫生标准。同时还要注意：</span></p><p><span style=\"font-family: Times New Roman;\"></span><span style=\"font-family: 宋体;\">１．用餐时不宜喝汽水。吃饭时饮水可减少食物在口腔内的停留时间，使食物得不到充分咀嚼。这不仅影响食欲，还会影响食物消化，胃内产生气体。久而久之，容易导致慢性食道炎、慢性胃炎等疾病。</span></p><p><span style=\"font-family: Times New Roman;\"></span><span style=\"font-family: 宋体;\">２．只喝饮料不喝开水不利健康。饮料是补充体液的一种方法，但绝不是惟一的或最理想的。因为饮料中含有糖或糖精、合成色素、香精和防腐剂等，它们在体内排泄慢，会加重胃肠道和肾脏的负担。</span></p><p><span style=\"font-family: Times New Roman;\"></span><span style=\"font-family: 宋体;\">３．长期喝纯净水易缺钙。纯净水在生产过程中，经过过滤、蒸馏、吸附或反渗透等工艺，确实除去了一部分有害物质，但同时也除去了人体所需的某些微量元素和钙、镁等元素，特别是对钙离子流失的影响值得重视。</span></p><p><span style=\"font-family: Times New Roman;\"></span><span style=\"font-family: 宋体;\">４．果汁不能代替水果。果汁中虽然含有许多营养物质，但也缺少一种重要的成分，这种成分就是水果的粗纤维。因此，果汁不能代替水果。</span></p><p><span style=\"font-family: Times New Roman;\"></span><span style=\"font-family: 宋体;\">５．固体饮料不能用开水冲调。饮料中所含的糖化酵素和一些营养素在高温条件下很容易被破坏。实验证明，当温度达到６０℃至８０℃时，饮料中的某些营养成分就会被破坏。饮用这种饮料，很难从中获得全面的营养，这是经济上的浪费，也是营养上的浪费。</span></p>',1,'2017-04-06 15:17:27',0),
	(19,28,1,'水果放入冰箱前不要洗','<p><img title=\"1491463380841185.jpg\" alt=\"timg (21).jpg\" src=\"/ueditor/php/upload/image/20170406/1491463380841185.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">水果买回家后一时不吃或吃不完，放进冰箱是最好的保存方式。然而，在放入冰箱之前注意不要清洗，否则容易变质腐烂，并应尽量在一个星期内吃完。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">每种水果都有其最适合的贮藏温度、保存期限。放得愈久，水果的营养及风味也就愈差。有些水果像香蕉、凤梨、芒果、木瓜、柠檬等，其实只要摆在室内阴凉角落处即可，不宜长时间冷藏。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">另外，苹果、梨、香蕉、木瓜、桃子或一些易腐烂的水果，容易产生乙烯，最好不要同其他水果放在一起。</span></p>',1,'2017-04-06 15:23:02',0),
	(20,28,1,'警惕：用塑料袋盛装高温食品当心中毒','<p>&nbsp;<img title=\"1491463529139070.jpg\" alt=\"timg (22).jpg\" src=\"/ueditor/php/upload/image/20170406/1491463529139070.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">环保局日前曾就一次性塑料袋使用状况作过调查，结果显示，目前市场上尤其是肉菜市场中普遍使用的一次性塑料袋，８０％以上是个体作坊用低价回收的各种废弃塑料、利用垃圾站收集的废旧塑料、工业废弃物甚至是医疗机构丢弃的塑料垃圾回收加工的，未经消毒处理就私自将其加工制成食品袋投入市场。质量技术监督局有关人士也称，肉菜市场上那些菜贩子使用的一次性塑料袋几乎都是不合格的。一些小卖部使用的一次性塑料袋的不合格率也在８０％以上。有些塑料制品中加入了稳定剂，而这些添加的稳定剂主要成分是硬脂酸铅，会造成积蓄性铅中毒。因此，建议市民在买菜时特别是买熟食时一定不要使用此类塑料袋。特别值得注意的是，废弃塑料的主要成分是聚氯乙烯，在加工过程中会产生大量的氯离子，若与不符合国家规定或严重超标的劣质添加剂结合，会产生很强的致癌物。而这些塑料袋用来包装食品、瓜果蔬菜，有害物就会吸附在食物上，即使冲洗也难以清除。如果用聚氯乙烯塑料袋盛装含油、含酒精类食品及温度超过５０℃的食品，袋中的铅就会溶入食品中，塑料袋还会释放有毒气体，侵入到食品当中。人体长期摄入会严重损害身体健康，导致疾病缠身。</span></p>',1,'2017-04-06 15:25:32',1),
	(21,28,1,'大蒜可防疫病','<p>&nbsp;<img title=\"1491464439707528.jpg\" alt=\"timg (23).jpg\" src=\"/ueditor/php/upload/image/20170406/1491464439707528.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">中国中医研究院北京西苑医院疑难病专家张世筠主任医师日前在接受记者采访时说，大蒜可防疫病，在临床治疗中主要用于：</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">抗病毒大蒜具有广谱的抗病毒活性，对多种病毒有较强的杀灭和抑制作用。如对脊髓灰质炎病毒有</span><span style=\"font-family: Times New Roman;\">90</span><span style=\"font-family: 宋体;\">％的杀灭作用，而对疱疹病毒、人类鼻病毒等有</span><span style=\"font-family: Times New Roman;\">100</span><span style=\"font-family: 宋体;\">％的杀灭作用，并能抑制与呼吸道感染有关的腺病毒和柯萨奇病毒等。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">抗细菌前两年曾一度流行干日本的病原菌</span><span style=\"font-family: Times New Roman;\">“O</span><span style=\"font-family: 宋体;\">－</span><span style=\"font-family: Times New Roman;\">157”</span><span style=\"font-family: 宋体;\">，因没有特效药治疗，曾使人闻之色变。后来发现，大蒜是它的克星，具有很强的杀菌作用。大蒜还能抑制、杀灭多种致病菌，特别是对真菌的作用格外明显。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">常吃大蒜可提高机体的免疫功能，这正是近段时期防治疫病过程中所需要的。实验证明，大蒜注射液能增强小鼠腹腔巨噬细胞的吞噬病毒、细菌的功能，同时，大蒜还具有诱发人淋巴细胞的作用，使机体免疫细胞数量增加，增强免疫力。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">大蒜药用的记载始于梁代陶弘景著《本草经集注》，但它用来治病的历史可追溯到</span><span style=\"font-family: Times New Roman;\">5000</span><span style=\"font-family: 宋体;\">年前。明代李时珍在《本草纲目》一书中称大蒜有</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">化腐朽为神奇</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">的作用，能</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">辟邪恶，消痈肿</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">，防治多种烈性传染病功效卓著。还称若将大蒜</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">携之旅途，则炎风瘴雨不能加，食餲腊毒不能害。</span><span style=\"font-family: Times New Roman;\">”</span></p>',1,'2017-04-06 15:40:42',2),
	(22,28,1,'专家称多吃菠菜可保护视网膜','<p>&nbsp;<img title=\"1491464518906421.jpg\" alt=\"timg (24).jpg\" src=\"/ueditor/php/upload/image/20170406/1491464518906421.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">医学研究证实，菠菜有助于提高人的记忆力，它含有的抗氧化剂可对人体有害分子起阻挡作用。中医学认为菠菜根可治便秘、痔疮出血和夜盲症，也认定对视力有很好的辅助疗效。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">美国哈佛大学的医学专家说，菠菜中有一组称为</span><span style=\"font-family: Times New Roman;\">“</span><span style=\"font-family: 宋体;\">类胡萝卜素</span><span style=\"font-family: Times New Roman;\">”</span><span style=\"font-family: 宋体;\">的物质，它可以有效防止太阳光所引起的视网膜损害。因此，专家建议每周应至少吃两次菠菜。</span></p>',1,'2017-04-06 15:42:00',2),
	(23,28,1,'当心可致人中毒的七种食品','<p>&nbsp;<img title=\"1491464736982415.jpg\" alt=\"timg (25).jpg\" src=\"/ueditor/php/upload/image/20170406/1491464736982415.jpg\"/></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">随着天气的变热，食物中毒的可能性又增加了许多，因而有必要提醒人们注意：以下可能导致中毒的七种食物千万别吃。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">绿色土豆　绿色土豆有的是被阳光晒绿的，有的是土豆发芽后产生大量的龙葵素而发绿的，人食用后会因龙葵素而中毒。食用发芽土豆时，应先将芽和芽根及土豆表皮变绿的部分挖去，放于清水中浸泡</span><span style=\"font-family: Times New Roman;\">2</span><span style=\"font-family: 宋体;\">小时以上。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">鲜蚕豆：有的人体内缺少某种酶，食用鲜蚕豆后会引起过敏性溶血综合征。症状为全身乏力、贫血、黄疸、肝肿大、呕吐、发热等，若不及时抢救，会因极度贫血而死亡。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">未炒熟的四季豆：未炒熟的四季豆中含有皂甙，人食用后会中毒。炒熟的四季豆无毒。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">鲜黄花菜：鲜黄花菜又名金针菜。其中的有毒物质秋水仙碱进入人体后，会使人嗓子发干、口渴，胃有烧灼感、恶心、呕吐、腹痛、腹泻。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">青西红柿：未成熟的西红柿含生物碱，人食用后可导致中毒。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">鲜木耳：鲜木耳中含有一种光感物质，人食用后，会随血液循环分布到人体表皮细胞中，受太阳照射后，会引发日光性皮炎。这种有毒光感物质还易被咽喉黏膜吸收，导致咽喉水肿。</span></p><p style=\"text-indent: 28px;\"><span style=\"font-family: 宋体;\">变质白木耳：腐烂变质的白木耳会产生大量的酵米面黄杆菌，食用后胃部会感到不适，严重者可出现中毒性休克。</span></p>',1,'2017-04-06 15:45:40',3),
	(24,27,1,'头痛的急救方法与注意事项','<p><img src=\"/ueditor/php/upload/image/20170407/1491527231567718.jpg\" title=\"1491527231567718.jpg\" alt=\"58c76a6a1bc8e05264000004_640.jpg\"/></p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#D82821;background:white;font-weight:normal\">急救办法</span></strong></h2><p style=\";margin-bottom:0\"><span style=\";color:#3E3E3E;background:white\">1</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、让患者在清净的房间卧床休息，并且保持室内空气流通，多饮开水，进流质或半流质食物。</span></p><p style=\";margin-bottom:0\"><span style=\";color:#3E3E3E;background:white\">2</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、无论偏头痛部位在何处，均可用冷水毛巾或热水毛巾敷前额止痛。</span></p><p style=\";margin-bottom:0\"><span style=\";color:#3E3E3E;background:white\">3</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、头痛难忍时，用双手手指按压左右两侧的太阳、合谷等穴位，通常可以减轻头痛。</span></p><p style=\";margin-bottom:0\"><span style=\";color:#3E3E3E;background:white\">4</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、止痛药对头痛通常有效，但要观察服用止痛药是否会掩盖病情，同时注意引起过敏性皮疹。</span></p><p style=\";margin-bottom:0\">&nbsp;</p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#C00000;background:white;font-weight:normal\">禁止</span></strong></h2><p style=\";margin-bottom:0\">　　<span style=\";font-family:宋体;color:#3E3E3E;background:white\">忌吃油腻煎炸食物；可进食清淡半流质食物及葱姜热汤麵、香菜肉末粥等具发散解表作用的食品。保持室内空气新鲜，温湿度适宜，防止病人直接吹风。</span> </p><p style=\";margin-bottom:0\">&nbsp;</p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#D82821;background:white;font-weight:normal\">注意事项</span></strong></h2><p style=\";margin-bottom:0\"><span style=\";color:#3E3E3E;background:white\">1</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、可喝一杯热牛奶或一小碗热稀粥，加盖衣被，静卧休息。</span></p><p style=\";margin-bottom:0\"><span style=\";color:#3E3E3E;background:white\">2</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、轻度头痛可服用止痛药而不用休息。如有剧烈头痛，则必须卧床休息。环境要安静，室内光线要柔和。另外，还要注意观察病人的神志是否清醒，有无面部及口眼歪斜等症状的出现。</span></p>',1,'2017-04-07 09:07:16',1),
	(25,27,1,'外伤出血处理方法','<p><span style=\"font-family:宋体\"><img src=\"/ueditor/php/upload/image/20170407/1491527488114288.png\" title=\"1491527488114288.png\" alt=\"a07248.0525.6.png\"/></span></p><p><span style=\"font-family:宋体\">止血法：</span></p><p style=\"text-indent:28px\">1.<span style=\"font-family:宋体\">直接加压法</span>:<span style=\"font-family:宋体\">直接在伤口或周围施以压力而止血。</span></p><p style=\"text-indent:28px\">2.<span style=\"font-family:宋体\">升高止血法</span>:<span style=\"font-family:宋体\">将伤肢或受伤部位高举</span>,<span style=\"font-family:宋体\">使其超过心脏高度。</span></p><p style=\"text-indent:28px\">3.<span style=\"font-family:宋体\">止血点止血法</span>:<span style=\"font-family:宋体\">直接施压于伤口近端的动脉上。</span></p><p style=\"text-indent:28px\">4.<span style=\"font-family:宋体\">强屈患肢止血法</span>:<span style=\"font-family:宋体\">只可使用于肘关节或膝关节以下的肢体</span>,<span style=\"font-family:宋体\">将棉垫置於肘窝或膝窝</span>,<span style=\"font-family:宋体\">再强屈其关节</span>,<span style=\"font-family:宋体\">并以绷带紧缚之</span>,<span style=\"font-family:宋体\">每二十分钟要放松十五秒。</span></p><p style=\"text-indent:28px\">5.<span style=\"font-family:宋体\">止血带止血法：由于该法可能对末梢神经有害，一般不用此法。</span></p><p><span style=\"font-family:宋体\">要诀</span>:</p><p style=\"text-indent:28px\">a.<span style=\"font-family:宋体\">止血带系於伤口上端</span>,<span style=\"font-family:宋体\">不可过紧</span>,<span style=\"font-family:宋体\">也不可过松。</span></p><p style=\"text-indent:28px\">b.<span style=\"font-family:宋体\">止血带不可直接缠绕於皮肤</span>,<span style=\"font-family:宋体\">其间应垫以布片或棉花</span>,<span style=\"font-family:宋体\">并置一卷垫物于动脉位置上</span>,<span style=\"font-family:宋体\">以加强效果</span>;<span style=\"font-family:宋体\">缠绕时</span>,<span style=\"font-family:宋体\">不容有皮肤皱折摺存在。</span></p><p style=\"text-indent:28px\">c.<span style=\"font-family:宋体\">每隔</span>15<span style=\"font-family:宋体\">至</span>20<span style=\"font-family:宋体\">分钟要放松</span>15<span style=\"font-family:宋体\">秒。放松时应在伤口上用敷料压迫止血</span>,<span style=\"font-family:宋体\">凡经</span>15<span style=\"font-family:宋体\">秒不复出血时</span>,<span style=\"font-family:宋体\">可将止血带放松置於原位</span>,<span style=\"font-family:宋体\">以备不虞。</span></p>',1,'2017-04-07 09:11:31',1),
	(26,27,1,'外伤现场急救','<p><span style=\"font-family:宋体\"><img src=\"/ueditor/php/upload/image/20170407/1491527788787481.jpg\" title=\"1491527788787481.jpg\" alt=\"QQ截图20170407091649.jpg\"/></span></p><p><span style=\"font-family:宋体\">外伤的临床表现：</span></p><p>&nbsp;</p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">伤口。局部组织完整性被破坏，包括局部组织器官的毁损，脱离。出血。包括外出血、内出血。骨折。包括脱臼、其中有闭合性和开放性。休克。由于失血或疼痛等原因造成。由于严重损伤引起心跳、呼吸停止，如不及时抢救则可能死亡。其他严重损害。如内脏破裂、气胸、脑及脊髓损伤等。</span></p><p><span style=\"font-family:宋体\">外伤四大急救技术：</span></p><p>&nbsp;</p><p><span style=\"font-family:宋体\">止血</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">成年人大约有</span>5000<span style=\"font-family:宋体\">毫升血液，当伤员出血量达</span>2000<span style=\"font-family:宋体\">毫升左右，就会有生命危险，必须紧急对伤员止血。止血的方法有直接压迫止血法、加压包扎法、填塞止血法、指压动脉止血法</span>(<span style=\"font-family:宋体\">用手掌或手指压迫伤口近心端动脉</span>)<span style=\"font-family:宋体\">。止血用物品要干净，防止污染伤口；止血带使用不能超过</span>1<span style=\"font-family:宋体\">小时，不能用金属丝、线带等作止血带。</span> <span style=\"font-family:宋体\">包扎是为了保护伤口减少污染、止血止痛、固定敷料。包扎材料可用绷带、三角巾或干净的衣服、床单、毛巾等。</span></p><p style=\"text-indent:28px\">&nbsp;</p><p><span style=\"font-family:宋体\">包扎方法</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">固定是为了防止骨折部位移</span>(<span style=\"font-family:宋体\">骨折端部移动时会损伤血管、神经、肌肉</span>)<span style=\"font-family:宋体\">，减轻伤员痛苦。需要注意的是：伤员休克或大出血时，先要</span>(<span style=\"font-family:宋体\">或同时</span>)<span style=\"font-family:宋体\">处理休克、止血；刺出伤口骨头不要送回伤口；体位受伤肢体畸形要按照畸形进行固定；固定时动作要轻、牢，松紧要适度，皮肤与夹板间要垫～些衣服或毛巾之类的东西，防止因局部受压而引起坏死。</span></p><p style=\"text-indent:28px\">&nbsp;</p><p><span style=\"font-family:宋体\">搬运</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">搬运是急救的重要步骤，搬运方法要根据伤情和各种具体情况而定。但要特别小心保护受伤处，不能使伤口创伤加重；要先固定好再搬运；对昏迷、休克、内出血、内脏损坏和头部创伤的必须用担架或木板搬运；尤其是颈、胸、腰段骨折的伤员，一定要保证受伤部位平直，不能随意摆动。</span></p>',1,'2017-04-07 09:16:31',0),
	(27,27,1,'吸入毒物怎么办','<p style=\"text-indent:28px\"><span style=\"font-family:宋体\"><img src=\"/ueditor/php/upload/image/20170407/1491528404228369.jpg\" title=\"1491528404228369.jpg\" alt=\"42524efaaf51f3deafe96f8896eef01f3b29794c.jpg\"/></span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">此种情况包括进入下水道、地下管道、地下的或密封的仓库、化粪池等密闭不通风的地方施工，或环境中有有毒、有害气体以及焊割作业、乙炔（电石）气中的磷化氢、硫化氢、煤气（一氧化碳）泄漏，二氧化碳过量，油漆、涂料、保温、粘合等施工时，苯气体、铅蒸气等作业产生的有毒有害气体吸入人体造成中毒。</span></p><p style=\"text-indent:28px\">&nbsp;</p><p><span style=\"font-family:宋体\">急救要点：</span></p><p style=\"text-indent:28px\">1<span style=\"font-family:宋体\">应立即使中毒人员脱离现场，在抢救和救治时应加强通风及吸氧。</span></p><p style=\"text-indent:28px\">2<span style=\"font-family:宋体\">及早向附近的人求助或打</span>120<span style=\"font-family:宋体\">电话呼救。</span></p><p style=\"text-indent:28px\">3<span style=\"font-family:宋体\">神志不清的中毒病人必须尽快抬出中毒环境。平放在地上，将其头转向一侧。</span></p><p style=\"text-indent:28px\">4<span style=\"font-family:宋体\">轻度中毒患者应安静休息，避免活动后加重心肺负担及增加氧的消耗量。</span></p><p style=\"text-indent:28px\">5<span style=\"font-family:宋体\">病情稳定后，将病人护送到医院进一步检查治疗。</span></p>',1,'2017-04-07 09:26:46',0),
	(28,27,1,'现场急救原则','<p><span style=\"font-family:宋体\"><img src=\"/ueditor/php/upload/image/20170407/1491530153134293.jpg\" title=\"1491530153134293.jpg\" alt=\"1259273210_540109864a6942da05f26d518778b01d.jpg\"/></span></p><p><span style=\"font-family:宋体\">机智、果断</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">发生伤亡或意外伤害后</span>4<span style=\"font-family:宋体\">～</span>8<span style=\"font-family:宋体\">分钟是紧急抢救的关键时刻，失去这段宝贵时</span> <span style=\"font-family:宋体\">间，伤员或受害者的伤势会急剧变化，甚至发生死亡。所以要争分夺秒地进行抢救，冷静科学地进行紧急处理。发生重大，恶性或意外事故后，当时在现场或赶到现场的人员要立即进行紧急呼救，立即向有关部门拨打呼救电话，讲清事发地点、简要概况和紧急救援内容，同时要迅速了解事故或现场情况，机智、果断、迅速和因地制宜地采取有效应急措施和安全对策，防止事故、事态和当事人伤害的进一步扩大。</span></p><p style=\"text-indent:28px\">&nbsp;</p><p><span style=\"font-family:宋体\">及时、稳妥</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">当事故或灾害现场十分危险或危急，伤亡或灾情可能会进一步扩大时，要及时稳妥地帮助伤</span>(<span style=\"font-family:宋体\">病</span>)<span style=\"font-family:宋体\">员或受害者脱离危险区域或危险源，在紧急救援或急救过程中，要防止发生二次事故或次生事故，并要采取措施确保急救人员自身和伤病员或受害者的安全。</span></p><p style=\"text-indent:28px\">&nbsp;</p><p><span style=\"font-family:宋体\">正确、迅速</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">要正确迅速地检查伤</span>(<span style=\"font-family:宋体\">病</span>)<span style=\"font-family:宋体\">员、受害者的情况，如发现心跳呼吸停止，要立即进行人工呼吸、心脏按摩，一直要坚持到医生到来；如伤</span>(<span style=\"font-family:宋体\">病</span>)<span style=\"font-family:宋体\">员和受害者出现大出血，要立即进行止血；如发生骨折，要设法进行固定等等。医生到后，要简要反映伤</span>(<span style=\"font-family:宋体\">病</span>)<span style=\"font-family:宋体\">员的情况、急救过程和采取的措施，并协助医生继续进行抢救。</span></p><p style=\"text-indent:28px\">&nbsp;</p><p><span style=\"font-family:宋体\">细致、全面</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">对伤</span>(<span style=\"font-family:宋体\">病</span>)<span style=\"font-family:宋体\">员或受害者的检查要细致、全面，特别是当伤</span>(<span style=\"font-family:宋体\">病</span>)<span style=\"font-family:宋体\">员或受害者暂时没有生命危险时，要再次进行检查，不能粗心大意，防止临阵慌乱、疏忽漏项。对头部伤害的人员，要注意跟踪观察和对症处理。</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">在给伤员急救处理之前，首先必须了解伤员受伤的部位和伤势，观察伤情的变化。需急救的人员伤情往往比较严重，要对伤员重要的体症、症状、伤情进行了解，绝不能疏忽遗漏。通常在现场要作简单的体检。</span></p><p style=\"text-indent:28px\">&nbsp;</p><p><span style=\"font-family:宋体\">现场简单体检：</span></p><p><span style=\"font-family:宋体\">心跳检查</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">正常人每分钟心跳为</span>60<span style=\"font-family:宋体\">～</span>80<span style=\"font-family:宋体\">次，严重创伤，失血过多的伤员，心跳增快，且力量较弱，脉细而快。</span></p><p style=\"text-indent:28px\">&nbsp;</p><p><span style=\"font-family:宋体\">呼吸检查</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">正常人每分钟呼吸数为</span>16<span style=\"font-family:宋体\">～</span>18<span style=\"font-family:宋体\">次，重危伤员，呼吸变快，变浅不规则。当伤员临死前，呼吸变得缓慢，不规则，直至呼吸停止。通过观察伤员胸廓起伏可知有无呼吸。有呼吸极其微弱，不易看到胸廓明显的起伏，可以用一小片棉花或薄纸片、较轻的小树叶等放在伤员鼻孔旁，看这些物体是否随呼吸飘动。</span></p><p style=\"text-indent:28px\">&nbsp;</p><p><span style=\"font-family:宋体\">瞳孔检查</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">正常人两眼的瞳孔等大、等圆，遇光线能迅速收缩。受到严重伤害的伤员，两瞳孔大小不一，可能缩小或放大，用电筒光线刺激时，瞳孔不收缩或收缩迟钝。当其瞳孔逐步散大，固定不动，对光的反应消失时，伤员陷于死亡。</span></p><p style=\"text-indent:28px\">&nbsp;</p><p><span style=\"font-family:宋体\">人体的正常值</span></p><p><span style=\"font-family:宋体\">进行现场急救前的简单检查</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">体温：腋下</span>36<span style=\"font-family:宋体\">～</span>37~C<span style=\"font-family:宋体\">心搏频率</span>(<span style=\"font-family:宋体\">一般情况同脉搏</span>)<span style=\"font-family:宋体\">：</span>60<span style=\"font-family:宋体\">～</span>80<span style=\"font-family:宋体\">次／分呼吸频率：</span>16<span style=\"font-family:宋体\">～</span>18<span style=\"font-family:宋体\">次／分血压：舒张压</span>60<span style=\"font-family:宋体\">～</span>90mmHg(8<span style=\"font-family:宋体\">～</span>12kpa)<span style=\"font-family:宋体\">收缩压</span>90<span style=\"font-family:宋体\">～</span>140mmHg(12<span style=\"font-family:宋体\">～</span>16kpa)<span style=\"font-family:宋体\">日细胞计数：</span>(4<span style=\"font-family:宋体\">～</span>10)×10g<span style=\"font-family:宋体\">／</span>L<span style=\"font-family:宋体\">嗜中性粒细胞：</span>O<span style=\"font-family:宋体\">．</span>50<span style=\"font-family:宋体\">～</span>O<span style=\"font-family:宋体\">．</span>70(50<span style=\"font-family:宋体\">％～</span>70<span style=\"font-family:宋体\">％</span>)<span style=\"font-family:宋体\">血红蛋白：男，</span>120<span style=\"font-family:宋体\">～</span>160g<span style=\"font-family:宋体\">／</span>L <span style=\"font-family:宋体\">女，</span>110<span style=\"font-family:宋体\">～</span>150g<span style=\"font-family:宋体\">／</span>L<span style=\"font-family:宋体\">红细胞沉降率：男，</span>O<span style=\"font-family:宋体\">～</span>15mm<span style=\"font-family:宋体\">／</span>h <span style=\"font-family:宋体\">女，</span>O<span style=\"font-family:宋体\">～</span>20mm<span style=\"font-family:宋体\">／</span>h</p>',1,'2017-04-07 09:55:56',0),
	(29,27,1,'小挫伤与小擦伤','<p style=\"text-indent:28px;line-height:150%\"><span style=\"font-family:宋体\"><img src=\"/ueditor/php/upload/image/20170407/1491533743106942.jpg\" title=\"1491533743106942.jpg\" alt=\"136362500038576496991981610.jpg\"/></span></p><p style=\"text-indent:28px;line-height:150%\"><span style=\"font-family:宋体\">（</span>1<span style=\"font-family:宋体\">）小挫伤即皮肤表面受钝力撞击后，皮肤完整无伤口，皮下小血管破裂出血形成青紫或者小包叫做挫伤。范围小的又名为小挫伤。小挫伤应作如下处理：</span></p><p style=\"margin-left:0;text-indent:28px;line-height:150%\">1．<span style=\"font-family: 宋体\">用肥皂水、清水洗净伤处。</span></p><p style=\"margin-left:0;text-indent:28px;line-height:150%\">2．<span style=\"font-family: 宋体\">局部用冷水袋冷敷，达到局部止血目的。</span></p><p style=\"margin-left:0;text-indent:28px;line-height:150%\">3．<span style=\"font-family: 宋体\">受伤后</span>24<span style=\"font-family:宋体\">小时后可改用热敷，促进吸收。</span></p><p style=\"margin-left:0;text-indent:28px;line-height:150%\">4．<span style=\"font-family: 宋体\">发生关节附近的小挫伤宜请医生诊治。</span> </p><p style=\"margin-left:0;text-indent:28px;line-height:150%\">（2）<span style=\"font-family: 宋体\">、小擦伤</span>&nbsp; <span style=\"font-family:宋体\">小擦伤即皮面受钝力擦伤，伤处有渗出，无伤口，称这种伤为擦伤，易感染，处理要注意：</span></p><p style=\"text-indent:28px;line-height:150%\">1<span style=\"font-family:宋体\">．特别要注意清洁伤处：处理者要洗净自己的手，用棉球蘸肥皂水反复擦干净伤处及伤处周围后用消毒水或凉开水多次清洗后，再用酒精消毒伤处周围，使周围皮面上的细菌无法生长。</span></p><p style=\"text-indent:28px;line-height:150%\">2<span style=\"font-family:宋体\">．伤处处理好后包扎。</span></p><p style=\"text-indent:28px;line-height:150%\">3<span style=\"font-family:宋体\">．关节附近擦伤更应包扎，最好限制伤处活动</span>3<span style=\"font-family:宋体\">～</span>4<span style=\"font-family:宋体\">天。</span></p>',1,'2017-04-07 10:55:45',0),
	(30,27,1,'心绞痛的急救方法与注意事项','<p><img src=\"/ueditor/php/upload/image/20170407/1491534966114309.jpg\" title=\"1491534966114309.jpg\" alt=\"2016121763625678.jpg\"/>&nbsp;</p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#D82821;background:white;font-weight:normal\">急救办法</span></strong></h2><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">1</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、停止一切活动，平静心情，可就地站立休息，无须躺下，以免增加回心血量而加重心脏负担。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">2</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、随身携带急救药物，如：硝酸甘油片一片，嚼碎后含於舌下，通常两分鐘左右疼痛即可缓解。</span> <span style=\";font-family:宋体;color:#3E3E3E;background:white\">如果效果不佳，十分鐘后可再在舌下含服一片，以加大药量。注意，无论心绞痛是否缓解，或再次发作，都不宜连续含服叁片以上的硝酸甘油片。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">3</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、及时呼唤医疗人员救护。</span></p><p style=\";margin-bottom:0\">&nbsp;</p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#D82821;background:white;font-weight:normal\">禁止</span></strong></h2><p style=\";margin-bottom:0\"><span style=\";font-family:宋体;color:#494429;background:white\">避免进食高脂肪、高胆固醇的食物，少量饮啤酒、养生酒、低度酒。</span></p><p style=\";margin-bottom:0\">&nbsp;</p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#D82821;background:white;font-weight:normal\">注意事项</span></strong></h2><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">1</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、多吃水果、新鲜蔬菜，减少刺激性饮食。适当喝食用醋，以软化血管，减少心绞痛发作。伴有心绞痛的冠心病患者，应适当休息，减轻工作量，如发生心肌梗塞，立即住院治疗。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">2</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、初发心绞痛的患者，往往未随身携带急救药物，避免情绪慌乱，及时到医院救治即可。</span></p>',1,'2017-04-07 11:16:09',0),
	(31,27,1,'心脏骤停心脏骤停的抢救必须争分夺秒','<p style=\"text-indent: 32px\"><span style=\"font-size: 16px;font-family:宋体;color:#3E3E3E;background:white\"><img src=\"/ueditor/php/upload/image/20170407/1491536163393095.jpg\" title=\"1491536163393095.jpg\" alt=\"201408081849108416224_HCAxFAG.jpg\"/></span></p><p style=\"text-indent: 32px\"><span style=\"font-size: 16px;font-family:宋体;color:#3E3E3E;background:white\">心脏骤停的抢救必须争分夺秒，千万不要坐等救护车到来再送医院救治。要当机立断采取以下急救措施进行心肺复苏。</span></p><p style=\";margin-bottom:0\">&nbsp;</p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#D82821;background:white;font-weight:normal\">急救办法</span></strong></h2><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">1</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、叩击心前区：一手托病人颈后向上托，另一手按住病人前额向后稍推，使下颌上翘，头部后仰，有利于通气。用拳头底部多肉部分，在胸骨中段上方，离胸壁</span><span style=\";color:#3E3E3E;background:white\">20</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">～</span><span style=\";color:#3E3E3E;background:white\">30</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">厘米处，突然、迅速地捶击一次。若无反应，当即做胸外心脏按压。让病人背垫一块硬板，同时做口对口人工呼吸。观察病人的瞳孔，若瞳孔缩小（是最灵敏、最有意义的生命征象），颜面、口唇转红润，说明抢救有效。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">2</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、针刺人中穴或手心的劳宫穴、足心涌泉穴，起到抢救作用。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">3</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、迅速掏出咽部呕吐物，以免堵塞呼吸道或倒流入肺，引起窒息和吸入性肺炎。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">4</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、头敷冰袋降温。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">5</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、急送医院救治。</span></p>',1,'2017-04-07 11:31:06',0),
	(32,27,1,'休克和失神','<p style=\"text-indent:32px;line-height:150%\"><span style=\"font-size:16px;line-height:150%;font-family: 宋体\"><img src=\"/ueditor/php/upload/image/20170407/1491536719418871.jpg\" title=\"1491536719418871.jpg\" alt=\"b78bc4ba85_2.jpg\"/></span></p><p style=\"text-indent:32px;line-height:150%\"><span style=\"font-size:16px;line-height:150%;font-family: 宋体\">（1）病人于短时间内出现意识模糊，全身软弱无力，面色苍白，冷汗淋漓，脉微数，血压急骤下降，这就是休克。休克的原因很多，如身体突然受外力打击，除局部有损伤外，全身亦可发生各种不同反应，就是休克，失神等。其他如心脏病人，因某种原因而发生心力衰竭亦可发生休克。如遇到这种情况，应分别临时处理。</span></p><p style=\"text-indent:32px;line-height:150%\"><span style=\"font-size:16px;line-height:150%;font-family: 宋体\">（2）临时处理休克方法如下：</span></p><p style=\"text-indent:32px;line-height:150%\"><span style=\"font-size:16px;line-height:150%;font-family: 宋体\">①在伤处应立刻止血；</span></p><p style=\"text-indent:32px;line-height:150%\"><span style=\"font-size:16px;line-height:150%;font-family: 宋体\">②使伤者仰卧于适当的位置上，如果面色苍白，应将头部降低，潮红则将其抬高；</span></p><p style=\"text-indent:32px;line-height:150%\"><span style=\"font-size:16px;line-height:150%;font-family: 宋体\">③将胸部衣服或纽扣解开，便呼吸通畅，成分得到新鲜空气；</span></p><p style=\"text-indent:32px;line-height:150%\"><span style=\"font-size:16px;line-height:150%;font-family: 宋体\">④在症状尚未消失前，或有继续恶化的现象，不要随便移动或施行手术；</span></p><p style=\"text-indent:32px;line-height:150%\"><span style=\"font-size:16px;line-height:150%;font-family: 宋体\">⑤伤者有呕吐时，应使其头部偏向一侧，使呕吐物易于吐出；</span></p><p style=\"text-indent:32px;line-height:150%\"><span style=\"font-size:16px;line-height:150%;font-family: 宋体\">⑥应安静休息，保持温暖（温度不宜超过21度）再给患者盖上轻暖的薄被或毯子等；</span></p><p style=\"text-indent:32px;line-height:150%\"><span style=\"font-size:16px;line-height:150%;font-family: 宋体\">⑦室内空气须流通，可给姜糖水或浓茶；</span></p><p style=\"text-indent:32px;line-height:150%\"><span style=\"font-size:16px;line-height:150%;font-family: 宋体\">⑧摩擦皮肤，借摩擦的刺激，使患者易于恢复；</span></p><p style=\"text-indent:32px;line-height:150%\"><span style=\"font-size:16px;line-height:150%;font-family: 宋体\">⑨以上方法无效时，应施人工呼吸及输氧。</span></p><p style=\"text-indent:32px;line-height:150%\"><span style=\"font-size:16px;line-height:150%;font-family: 宋体\">（3）中草药及针灸治疗：昏迷时可用通关散：皂角1钱，细辛5分共研细末，以少量吹入鼻孔使打喷嚏，针刺十宣及两侧内关，可持续捻转；亦可针刺人中、合谷、足三里等穴，对休克有一定疗效。</span></p>',1,'2017-04-07 11:45:50',2),
	(33,27,1,'眼外伤的急救','<p style=\"text-indent:28px;line-height:150%\"><span style=\"font-family:宋体\"><img src=\"/ueditor/php/upload/image/20170407/1491537053825693.png\" title=\"1491537053825693.png\" alt=\"88m58PIC7Kr_1024.png\"/></span></p><p style=\"text-indent:28px;line-height:150%\"><span style=\"font-family:宋体\">小孩在玩耍时，会不经意间弄伤自己的眼睛。这时切不可慌张，掌握正确的儿童眼外伤急救方法，可助孩子顺利避免眼伤。眼内进入沙尘类异物时，用两个手指头捏住上眼皮，轻轻向前提起，往患儿眼内吹气，刺激流泪冲出沙尘；也可翻开眼皮查找，用干净的纱布或手绢轻轻沾出沙尘。</span> </p><p style=\"margin-left:0;text-indent:28px;line-height:150%\">1.<span style=\"font-family: 宋体\">生石灰溅入眼睛内，一不能用手揉，二不能直接用水冲洗。因为生石灰遇水会生成碱性的熟石灰，同时产生大量热量，反而会烧伤眼睛。正确的方法是，用棉签或干净的手绢一角将生石灰粉拨出，然后再用清水反复冲洗伤眼至少</span>15<span style=\"font-family:宋体\">分钟，冲洗后需立即去医院检查和治疗。</span></p><p style=\"margin-left:0;text-indent:28px;line-height:150%\">2.3.<span style=\"font-family:宋体\">眼内进入的是铁屑类或玻璃、瓷器类的危险颗粒，切忌揉搓或来回擦拭眼睛，尤其是黑眼球上有嵌入物时。应让孩子闭上眼睛，然后用干净酒杯扣在有异物的眼上，再盖上纱布，用绷带固定去求医，让孩子尽量不要转动眼球。</span> </p><p style=\"text-indent:28px;line-height:150%\">4.<span style=\"font-family:宋体\">有硫酸、烧碱等具有强烈腐蚀性的化学物品溅入眼内，现场急救时对眼睛及时、正规的冲洗是避免失明的首要保证。要立即就近寻找清水冲洗受伤的眼睛。冲洗时将伤眼一侧朝向下方，用食指和拇指扒开眼皮，尽可能使眼内的腐蚀性化学物品全部冲出。若附近有一盆水，让孩子立即将眼睛浸人水中并不停眨眼。如果孩子太小，可以用手帮助孩子做眼皮开合的动作。</span></p>',1,'2017-04-07 11:50:55',0),
	(34,27,1,'腰部扭伤','<p style=\"margin-right:20px;text-align:justify;text-justify:inter-ideograph;text-indent:32px;line-height:30px;background:white\"><span style=\"font-family: 宋体;color: rgb(34, 34, 34)\"><img src=\"/ueditor/php/upload/image/20170407/1491537375133123.png\" title=\"1491537375133123.png\" alt=\"mp36509010_1445244114116_1_th.png\"/></span></p><p style=\"margin-right:20px;text-align:justify;text-justify:inter-ideograph;text-indent:32px;line-height:30px;background:white\"><span style=\"font-family: 宋体;color: rgb(34, 34, 34)\">急救方法：仰卧在床上，腰下垫一些柔软的垫子</span></p><p style=\"margin-right:20px;text-align:justify;text-justify:inter-ideograph;text-indent:32px;line-height:30px;background:white\"><span style=\"font-family: 宋体;color: rgb(34, 34, 34)\">扭伤伤及的是软组织，肌肉、韧带都可能受累。足踝扭伤时要先冷敷一至两天，待淤血稍散，再热敷，可以用绷带将足踝缠绕包扎，休息时注意将伤脚垫高</span><span style=\"font-family: Arial, sans-serif;color: rgb(34, 34, 34)\">;</span><span style=\"font-family: 宋体;color: rgb(34, 34, 34)\">手腕扭伤时，将伤手抬高，用硬纸板或小木条固定托举，只用冷敷</span><span style=\"font-family: Arial, sans-serif;color: rgb(34, 34, 34)\">;</span><span style=\"font-family: 宋体;color: rgb(34, 34, 34)\">腰扭伤时，可以仰卧在厚床垫上，腰下再垫一些柔软的垫子，须先经过两至三天的冷敷再改为热敷</span><span style=\"font-family: Arial, sans-serif;color: rgb(34, 34, 34)\">;</span><span style=\"font-family: 宋体;color: rgb(34, 34, 34)\">肩扭伤的人卧床时应该将受伤的关节垫高，手臂略处于外伸位置，伤处冷敷，三天后改为热敷。如果症状依旧不见好转，就得去看医生了。</span></p>',1,'2017-04-07 11:56:17',0),
	(35,27,1,'有毒气体急救','<p><span style=\"font-family:宋体\"><img src=\"/ueditor/php/upload/image/20170407/1491541513888821.jpg\" title=\"1491541513888821.jpg\" alt=\"2121530.jpg\"/></span></p><p><span style=\"font-family:宋体\">有毒气体急救的方法：</span></p><p style=\"text-indent:28px\">1<span style=\"font-family:宋体\">、用湿毛巾等捂住口、鼻，躬身弯腰向与烟气相反方向的安全出口逃出</span>;</p><p style=\"text-indent:28px\">2<span style=\"font-family:宋体\">、中毒者抢救出来后，放在空气新鲜、流通的地方实施抢救</span>;</p><p style=\"text-indent:28px\">3<span style=\"font-family:宋体\">、伤员停止呼吸时，应立即进行人工呼吸，可能时供给氧气，并迅速送往医院。</span></p>',1,'2017-04-07 13:05:16',1),
	(37,27,1,'遇到地铁火灾乘客要牢记两点','<p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\"><img src=\"/ueditor/php/upload/image/20170407/1491542528714456.jpg\" title=\"1491542528714456.jpg\" alt=\"res03_attpic_brief.jpg\"/></span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">1</span><span style=\";font-family:宋体\">、不要贪恋财物。不要因为顾及贵重物品，而浪费宝贵的逃生时间。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">2</span><span style=\";font-family:宋体\">、要镇定。受到火势威胁时，千万不要盲目地相互拥挤、乱冲乱撞。要听从工作人员指挥或广播指引，要注意朝明亮处、迎着新鲜空气跑。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:宋体\">地铁都有哪些</span><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">&quot;</span><span style=\";font-family:宋体\">守护神</span><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">&quot;?</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:宋体\">地铁一般都有完善的防火、灭火设施：在每节车厢前后部位，均贴有红底黄字的</span><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">&quot;</span><span style=\";font-family:宋体\">报警开关</span><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">&quot;</span><span style=\";font-family:宋体\">标志，箭头指向位置即按钮位置。乘客将按钮向上扳动就能通知地铁列车司机，地铁司机就能及时采取相关措施进行处理。另外，干粉灭火器配备在每节车厢的两个内侧车门的中间座位下，上面贴有红色</span><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">&quot;</span><span style=\";font-family:宋体\">灭火器</span><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">&quot;</span><span style=\";font-family:宋体\">标志。每个地铁站都设有事故照明灯，随处可见清晰的</span><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">“</span><span style=\";font-family:宋体\">紧急出口</span><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">”</span><span style=\";font-family:宋体\">标志。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:宋体\">遇到火灾如何正确逃生</span><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">?</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:宋体\">乘客首先要及时报警，可以用自己的手机拨打</span><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">119</span><span style=\";font-family:宋体\">，也可按列车车厢内的紧急报警按钮。再用车厢内的干粉灭火器进行扑火自救。旋转拉手</span><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">90</span><span style=\";font-family:宋体\">度，开门取出灭火器后，先要拉出保险销，然后对准火源，将灭火器手柄压下，尽量将火扑灭在萌芽状态。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:宋体\">如果火势蔓延迅速，乘客无法灭火自救，应该有序地安全逃生。应将老、弱、妇、幼先行疏散至安全的车厢，关闭车厢门，防止火势蔓延以赢得逃生时间。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:宋体\">地铁列车两站之间的平均到达时间为两分钟。列车到站时，要听从车站工作人员的统一指挥，沿正确逃生方向进行疏散。在疏散过程中要注意脚下异物，千万不能进入另一条隧道（地铁是双隧道）。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:宋体\">如果火灾引起停电，可按照应急灯的指示标志进行有序逃生。注意要朝背离火源的方向逃生。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:宋体\">司机应尽快打开车门疏散人员，若车门开启不了，乘客可利用身边的物品击打破门。同时，将携带的衣物、毛巾沾湿，捂住口鼻，身体贴近地面，再有序地向外疏散。一旦身上着火，千万不要奔跑，可就地打滚或请其他人协助用厚重的衣物压灭火苗。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:宋体\">专家支招地铁列车一旦着火，地铁自身的防灾系统和控制指挥系统对于人员逃生、疏散起着至关重要的作用。此外，个人是否具有消防安全意识和逃生自救知识也很重要。在这场火灾中，如果有人能够利用应急装置，手动打开车门，将有更多的人生存下来。另外，有的人虽然从车厢中逃出，但是没有到达地面就被烟气熏倒了。如果这些人能够采取正确措施，如用</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:宋体\">湿毛巾或者湿衣袖捂住口鼻，低姿势迅速穿过烟气区，也许能够获救。</span></p>',1,'2017-04-07 13:22:10',2),
	(38,27,1,'在野外时遇到火灾的应急措施','<p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\"><img src=\"/ueditor/php/upload/image/20170407/1491543575949969.jpg\" title=\"1491543575949969.jpg\" alt=\"66G58PICb5r_1024.jpg\"/></span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">1</span><span style=\";font-family:宋体\">、是退入安全区。扑火队在扑火时，要观察火场变化，万一出现飞火和气旋时，织扑火人员进入火烧迹地、植被少、火焰低的地区。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">2</span><span style=\";font-family:宋体\">、是按规范点火自救。要统一指挥，选择在比较平坦的地方，一边点顺风火，一边打两侧的火，一边跟着火头方向前进，进入到点火自救产生的火烧迹地内避火。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">3</span><span style=\";font-family:宋体\">、是按规范俯卧避险。发生危险时，应就近选择植被少的地方卧倒，脚朝火冲来的方向，扒开浮土直到见着湿土，八脸放进小坑里面，用衣服包住头，双手放在身体正面。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">4</span><span style=\";font-family:宋体\">、是按规范迎风突围。当风向突变，火掉头时，指挥员要果断下达突围命令，队员自己要当机立断，选择草较小、较少的地方，用衣服包住头，憋住一口气，迎火猛冲突围。人在</span><span style=\"font-family: ˎ̥, serif;\">7.5</span><span style=\"font-family: 宋体;\">秒内应当可以突围。千万不能与火赛跑，只能对着火冲。</span></p>',1,'2017-04-07 13:39:38',2),
	(39,27,1,'怎样预防火灾事故','<p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\"><img src=\"/ueditor/php/upload/image/20170407/1491544069314734.png\" title=\"1491544069314734.png\" alt=\"56bb875ab18c7c535ae0729030c79f49.png\"/></span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">1</span><span style=\";font-family:宋体\">、不能随意乱扔火种，小孩不能玩火，家长应妥善放置火柴、打火机等物品，不要让小孩拿来玩耍。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">2</span><span style=\";font-family:宋体\">、不要在酒后、疲劳时或临睡前躺在沙发上或床上吸烟。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">3</span><span style=\";font-family:宋体\">、要在规定的区域、时间内安全燃放烟花爆竹。小孩燃放烟花爆竹时应有大人监护。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">4</span><span style=\";font-family:宋体\">、外出时、临睡前要熄灭室内外的火种，关闭燃气（煤气、天然气、液化气）的总阀门。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">5</span><span style=\";font-family:宋体\">、要保持居室的走道、楼梯畅通，不随意堆物；不允许以防盗为名，擅自安装铁门封堵楼层通道、安全出口。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">6</span><span style=\";font-family:宋体\">、不应乱拉乱接电线；使用电熨斗、电吹风、电热杯、电取暖器等家用电热器具时，人不能离开；也不能用灯泡取暖或烘烤衣物。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">7</span><span style=\";font-family:宋体\">、不能用明火（火柴、打火机等）查找煤气、液化气、天然气的泄漏处，应使用肥皂水涂抹的方法来查漏。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">8</span><span style=\";font-family:宋体\">、勿在火种处按压式喷雾罐，否则易引起燃烧、爆炸，酿成火灾。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">9</span><span style=\";font-family:宋体\">、夏季使用燃烧型蚊香时，点燃的蚊香不要贴靠在床沿、窗帘等易燃物品处。</span></p><p style=\"text-indent: 28px;line-height: 22px\"><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">10</span><span style=\";font-family:宋体\">、家中存储的汽油、煤油不要超过</span><span style=\";font-family:&#39;ˎ̥&#39;,&#39;serif&#39;\">5</span><span style=\";font-family:宋体\">升，且应使用规定的容器。助动车加油时，应远离明火，也不能吸烟，否则极其危险，可能随时引起燃烧爆炸，导致火灾。</span></p>',1,'2017-04-07 13:47:51',1),
	(40,27,1,'怎样正确使用灭火器','<p style=\"text-indent:28px\"><span style=\"font-family:宋体\"><img src=\"/ueditor/php/upload/image/20170407/1491544767254317.jpg\" title=\"1491544767254317.jpg\" alt=\"4fcb37b4-e10c-4595-a4ac-71ba34138682.jpg\"/></span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">灭火器是扑灭火灾的有效器具。常见的有：手提式轻水泡沫灭火器、手提式干粉灭火器、手提式二氧化碳灭火器、手提式</span>&quot;1211&quot;<span style=\"font-family:宋体\">灭火器等。如果你正确掌握了各类灭火器的使用方法，就能正确、快速地处置初起火灾。</span></p><p style=\"text-indent:28px\">1<span style=\"font-family:宋体\">、灭火器的一般使用方法</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">用手握住灭火器的提把，平稳、快捷地提往火场。在距离燃烧物</span>5<span style=\"font-family:宋体\">米左右的地方，拔出保险销，一手握住开启压把，另一手握住喷射喇叭筒，喷嘴对准火源。喷射时，应采取由近而远，由外而里的方法。另外，注意以下五点：</span></p><p style=\"text-indent:28px\">(1)<span style=\"font-family:宋体\">灭火时，人应站在上风处。</span></p><p style=\"text-indent:28px\">(2)<span style=\"font-family:宋体\">不要将灭火器的盖与底对着人体，防止盖、底弹出伤人。</span></p><p style=\"text-indent:28px\">(3)<span style=\"font-family:宋体\">不要与水同时喷射在一起，以免影响灭火效果。</span></p><p style=\"text-indent:28px\">(4)<span style=\"font-family:宋体\">扑灭电器火灾时，应先切断电源，防止人员触电。</span></p><p style=\"text-indent:28px\">(5)<span style=\"font-family:宋体\">持喷筒的手应握在胶质喷管处，防止冻伤。</span></p><p style=\"text-indent:28px\">2<span style=\"font-family:宋体\">、常见灭火器的适用场合</span></p><p style=\"text-indent:28px\">(1)<span style=\"font-family:宋体\">干粉灭火器适用于扑救石油及其产品、可燃气体和电器设备的初起火灾。</span></p><p style=\"text-indent:28px\">(2)CO2<span style=\"font-family:宋体\">器适用于扑救</span>600<span style=\"font-family: 宋体\">伏以下的带电电器、贵重设备、图书资料、仪器仪表等场所的初起火灾。</span></p><p style=\"text-indent:28px\">(3)&quot;1211&quot;<span style=\"font-family:宋体\">灭火器主要用于油类、贵重仪表、电子仪器及文物、图书档案等物品的初起火灾。</span></p><p style=\"text-indent:28px\">(4)<span style=\"font-family:宋体\">小型家用电器灭火器使用于扑灭厨房、客厅、居室内的初起火灾。这类灭火器有喷射型及投掷型两种：</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">喷射型家用灭火器使用方法：按下灭火器顶端弹簧按钮，将喷嘴对准着火处。</span></p><p style=\"text-indent:28px\"><span style=\"font-family:宋体\">投掷型家用灭火器使用方法：只需将其投入火中，容器破碎，干粉泻出灭火。</span></p>',1,'2017-04-07 13:57:32',3),
	(41,27,1,'中风的急救办法与注意事项','<p style=\"text-indent: 32px\"><span style=\"font-size: 16px;font-family:宋体;color:#3E3E3E;background:white\"><img src=\"/ueditor/php/upload/image/20170407/1491544870414137.jpg\" title=\"1491544870414137.jpg\" alt=\"323_151257_1.jpg\"/></span></p><p style=\"text-indent: 32px\"><span style=\"font-size: 16px;font-family:宋体;color:#3E3E3E;background:white\">大多由情绪波动、忧思恼怒、饮酒、精神过度紧张等因素诱发。在中风发生之前常可出现一些典型或非典型的中风预兆。</span></p><p style=\";margin-bottom:0\">&nbsp;</p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#D82821;background:white;font-weight:normal\">急救办法</span></strong></h2><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">1</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、有人突然发生中风，家属千万不能惊慌失措，应立即请求援助。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">2</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、在救护车到来之前，若病人意识尚清醒，应立即停止活动，处平卧位，家属要注意安慰病人，解除其紧张情绪。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">3</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、若病人意识已丧失，则设法将病人抬到床上，宜有二至叁人同时抬，避免病人头部受到震动，让病人安静躺下，抬高床头。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">4</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、病情稍稳定，呕吐减轻后再送医院抢救，但在送医院途中应特别小心，搬运过程中动作要轻柔稳健，头部要专人保护，减少震动。</span></p><p style=\";margin-bottom:0\">&nbsp;</p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#D82821;background:white;font-weight:normal\">注意事项</span></strong></h2><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">1</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、保持居室洁净和空气流通，注意保暖；保持口腔卫生，随时清除呼吸道分泌物，鼓励病人做胸部扩张、深呼吸及咳嗽等运动；定时为病人更换姿势，按摩皮肤受压处；大便失禁者於臀下置吸水性强的布垫，并及时清除排泄物，清洗局部，以保持外阴部清洁乾燥，防止泌尿道感染。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">2</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、中风首次发病后有可能再发，尤其是短暂脑缺血发作者；应尽力排除各种中风危险因素，定期復查身体。</span></p>',1,'2017-04-07 14:01:12',6),
	(42,27,1,'中暑的现场救护','<p style=\"text-indent:28px\"><img src=\"/ueditor/php/upload/image/20170407/1491545479378679.png\" title=\"1491545479378679.png\" alt=\"9_160712195346_1.png\"/></p><p style=\"text-indent:28px\">1<span style=\"font-family:宋体\">轻度中暑进行自我调理．由于热丽感到头疼、乏力、口渴等时，应自行离开高温环境到阴凉通风的建方适当休息，并可饮冷盐开水、洗冷水脸，进行通风降漫等。</span></p><p style=\"text-indent:28px\">2<span style=\"font-family:宋体\">对中暑症状较重者，救护人员应将萁移到阴凉通风处，平卧、揭开衣服。立即采取冷湿毛巾敷头部．冷水擦身体及通风降温等方法给患者降温。</span></p><p style=\"text-indent:28px\">3<span style=\"font-family:宋体\">对严重中暑者</span>(<span style=\"font-family:宋体\">体温较高者</span>)<span style=\"font-family:宋体\">还可角冷水冲淋或在头、颈、腋下、大腿放置冰袋等方法迅速降温。如中暑者能饮水，则应让其喝冷盐开水或其他清凉饮料，以补充水分和盐分。对病情较重者，应迅速转送医院作进一步急救治疗。</span></p>',1,'2017-04-07 14:11:22',6),
	(43,27,1,'中暑急救办法及注意事项','<p><img src=\"/ueditor/php/upload/image/20170407/1491546493820874.jpg\" title=\"1491546493820874.jpg\" alt=\"20150610104954_0729.jpg\"/></p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#D82821;background:white;font-weight:normal\">急救办法</span></strong></h2><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">1</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、出现中暑先兆时，立即撤离高温环境。在阴凉处安静休息，并补充含盐饮料。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">2</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、将患者抬到阴凉处或者空调供冷的房间平卧休息，解松或者脱去衣服。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">3</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、用湿水浸透的毛巾擦拭全身，不断摩擦四肢及皮肤。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">4</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、如降温处理不能缓解病情，及时送往医院救治。</span></p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#C00000;background:white;font-weight:normal\">禁止</span></strong></h2><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";font-family:宋体;color:#494429;background:white\">不要大量食用生冷瓜果。中暑患者大多脾胃虚弱，大量食用生冷食物和寒性食物会进一步损伤脾胃阳气，重者会出现腹泻、腹痛等症状。</span></p><p style=\";margin-bottom:0\">&nbsp;</p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#D82821;background:white;font-weight:normal\">注意事项</span></strong></h2><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">1</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、人中暑之后很虚弱，在恢復过程中，饮食应清淡、比较容易消化。补充必要的水分、盐、热量、维生素、蛋白质等所需养分。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">2</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、中暑后不要一次大量饮水。中暑患者应采用少量多次的饮水方法，每次以不超过三百亳升为宜。</span></p><p style=\";margin-bottom:0;text-indent:32px\"><span style=\";color:#3E3E3E;background:white\">3</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、少吃油腻食物，以适应夏季肠胃的消化能力。</span></p>',1,'2017-04-07 14:28:16',9),
	(44,27,1,'鱼骨刺喉的急救方法与注意事项','<p>&nbsp;<img src=\"/ueditor/php/upload/image/20170407/1491546853161197.jpg\" title=\"1491546853161197.jpg\" alt=\"4487fcd7fb6816e4f30203.jpg\"/></p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#D82821;background:white;font-weight:normal\">急救办法</span></strong></h2><p style=\";margin-bottom:0\"><span style=\";color:#3E3E3E;background:white\">1</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、用手指或筷子刺激咽后壁，诱发呕吐动作，以帮助排除咽部异物。</span></p><p style=\";margin-bottom:0\"><span style=\";color:#3E3E3E;background:white\">2</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、实行腹部挤压</span><span style=\";color:#3E3E3E;background:white\">(</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">如病人怀孕或过肥胖，则实施胸部压挤</span><span style=\";color:#3E3E3E;background:white\">)</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">。如患者无法站立，将其平放在坚固平面上，跨坐在病患腿上作腹部推挤五次，再检查有无将异物咳出。</span></p><p style=\";margin-bottom:0\"><span style=\";color:#3E3E3E;background:white\">3</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、若发现异物，可用长镊子或筷子夹住异物，轻轻地拨出即可。</span></p><p style=\";margin-bottom:0\">&nbsp;</p><h2 style=\"margin-top:0;line-height:20px;border:none;padding:0;padding:0 0 0 0\"><strong><span style=\"font-size: 18px;color:#D82821;background:white;font-weight:normal\">注意事项</span></strong></h2><p style=\";margin-bottom:0\"><span style=\";color:#3E3E3E;background:white\">1</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、较大或扎得较深的鱼刺，无论如何做吞咽动作都会疼痛不减。如果喉咙的入口两边及四周均不见鱼刺，就应去医院治疗。</span></p><p style=\";margin-bottom:0\"><span style=\";color:#3E3E3E;background:white\">2</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、当鱼刺卡在嗓子里时，不能让患者囫圇吞咽大块馒头、烙饼等食物，虽然有时这种方法可以把鱼刺除掉，但有时这种不恰当的处理方式，不仅没把鱼刺除掉，反而使其刺得更深，更不易取出，严重时感染发炎麻烦更大。</span></p><p style=\";margin-bottom:0\"><span style=\";color:#3E3E3E;background:white\">3</span><span style=\";font-family:宋体;color:#3E3E3E;background:white\">、鱼刺除不掉，自己仍感到不适。到医院请医生诊治，这也是鱼刺刺伤时最恰当的处理方法。</span></p>',1,'2017-04-07 14:34:25',13),
	(45,29,1,'血氧','血氧饱和度(SpO2)是血液中被氧结合的氧合血红蛋白(HbO2)的容量占全部可结合的血红蛋白(Hb，hemoglobin)容量的百分比，即血液中血氧的浓度，它是呼吸循环的重要生理参数。而功能性氧饱和度为HbO2浓度与HbO2+Hb浓度之比，有别于氧合血红蛋白所占百分数。因此，监测动脉血氧饱和度(SaO2)可以对肺的氧合和血红蛋白携氧能力进行估计。正常人体动脉血的血氧饱和度为98% ，静脉血为75%。<br/><br/>人体的新陈代谢过程是生物氧化过程，而新陈代谢过程中所需要的氧，是通过呼吸系统进入人体血液，与血液红细胞中的血红蛋白(Hb)，结合成氧合血红蛋白(HbO2)，再输送到人体各部分组织细胞中去。血液携带输送氧气的能力即用血氧饱和度来衡量。<br/><br/>血氧不足：一般就是贫血的一些个表现，常见的比如大脑的供血供氧不足的头晕，目眩，意识模糊，视力下降，身体的疲乏，指甲的淡白，呼吸的急促等等，一般常见的呼吸功能异常和血液中的贫血是多见血氧供应不足，还有冬季常见的一氧化碳的中毒。<br/>',1,'2017-05-26 11:32:36',3),
	(46,29,1,'血压','<p style=\"text-align:center\"><img src=\"/ueditor/php/upload/image/20170526/1495769702190286.png\" title=\"1495769702190286.png\" alt=\"QQ截图20170526113427.png\"/></p><p>血压的高低不仅与心脏功能、血管阻力和血容量密切相关，而且还受到神经、体液等因素的影响，年龄、季节、气候和职业的不同，血压值也会有所不同，运动、吃饭、情绪变化、大便等均会导致血压的升高，而休息、睡眠则会使血压下降。</p><p>精神刺激、情绪变化如兴奋、恐惧等常可导致收缩压的明显上升，运动也可使收缩压明显增加，特别是剧烈运动常使收缩压上升达24.0-6.7千帕(180-200毫米汞柱)，运动停止后血压可下降。环境温度升高如洗温水浴等可使舒张压降低，而温度降低如冬天洗冷水浴等可使收缩压升高，血压高的人注意饮食，血压是随着人们的年纪增长升高。</p><p>高血压主要是由不良的生活习惯导致，比如说，不运动、吃得过咸、抽烟、喝酒等。其中，吃盐多是我国高血压发病的主要因素。不过，更大的隐忧是人们对高血压的疏忽和缺乏认识。大约七成高血压患者不知道自己患病，只有14%的高血压患者得到治疗，不到一成高血压患者的血压能够得到有效控制。因此，尽早发现和控制对于预防和治疗高血压非常重要，早期预防、稳定治疗以及健康的生活方式可以使75%的高血压及其并发症得到控制。</p>',1,'2017-05-26 11:35:18',3),
	(47,29,1,'血糖','<p><strong>空腹血糖(fasting blood glucose, FBG)正常值</strong></p><p>①一般空腹全血血糖为3.9～6.1毫摩尔/升(70～110毫克/分升)，血浆血糖为3.9～6.9毫摩尔/升(70～125毫克/分升)。</p><p>②空腹全血血糖≥6.7毫摩尔/升(120毫克/分升)、血浆血糖≥7.8毫摩尔/升(140毫克/分升)，2次重复测定可诊断为糖尿病。</p><p>③当空腹全血血糖在5.6毫摩尔/升(100毫克/分升)以上，血浆血糖在6.4毫摩尔/升(115毫克/分升)以上，应做糖耐量试验。</p><p>④当空腹全血血糖超过11.1毫摩尔/升(200毫克/分升)时，表示胰岛素分泌极少或缺乏。因此，空腹血糖显著增高时，不必进行其它检查，即可诊断为糖尿病。</p><p><strong>餐后血糖正常值</strong></p><p>① 餐后1小时：血糖6.7-9.4毫摩/升。最多也不超过11.1mmol/L（200mg/dl）</p><p>② 餐后2小时：血糖≤7.8毫摩/升。</p><p>③餐后3小时：第三小时后恢复正常，各次尿糖均为阴性</p><p><strong>孕妇血糖正常值</strong></p><p>①孕妇空腹不超过5.1mmol/L</p><p>②孕妇餐后1小时：餐后1小时血糖值一般用于检测孕妇糖尿病检测中，权威数据表明孕妇餐后1小时不得超过10.0mmol/L才是血糖的正常水平;</p><p>③孕妇餐后2小时：餐后正常血糖值一般规定不得超过11.1mmol/L，而孕妇餐后2小时正常血糖值规定不得超过8.5mmol/L。<br/>通过对血糖正常值的检测，了解血糖标准值有助于您提高做好糖尿病防治。</p>',1,'2017-05-26 11:38:27',0),
	(48,29,1,'体温','<p>在人们的体内有专门负责管理体温调节的部位（大脑皮质与丘脑下部），我们将其称之为体温调节中枢，它通过神经、体液等因素调节机体的产热和散热过程，使体温波动于正常范围之内，所以健康人的体温就能保持相对恒定。一些外来的或内生的物质均可作用于体温调节中枢，破坏产热与散热之间的动态平衡，机体就表现为发热，医学将这些能引起发热的物质统称为致热原。当然，体温调节中枢自身功能紊乱也可引起发热。根据发热程度的高低（口腔温度），可以区分为：低热：37.4℃～38℃；中等度热：38.1℃～39℃：高热：39.1℃～41℃；超高热：41℃以上。</p><p><br/></p><p>由于机体的热能主要来源于骨骼肌，在致热原的作用下，骨骼肌收缩特别强烈，所以在体温升高前患者往往有怕冷、寒战，继之高热。发热本身不是一种病，它只是某种疾病的一种临床表现，在对发热采取对症治疗时，不要忘记根据发热的病因，做进一步处理，必要时上医院就诊治疗。</p>',1,'2017-05-26 11:40:56',0),
	(49,29,1,'体重','<p><strong>成人BMI 法</strong></p><p><strong><br/></strong></p><p><span style=\"color: rgb(255, 0, 0);\"><strong>体重指数 =体重（公斤） 除以 身高（米）的平方 kg/m2</strong></span></p><p><span style=\"color: rgb(255, 0, 0);\"><strong><br/></strong></span></p><p>正常体重 ： 体重指数 = 18 - 25</p><p><br/></p><p>超重 ： 体重指数 = 25 - 30</p><p><br/></p><p>轻度肥胖 ： 体重指数 &gt; 30</p><p><br/></p><p>中度肥胖 ： 体重指数 &gt; 35</p><p><br/></p><p>重度肥胖 ：体重指数 &gt; 40</p><p><br/></p>',1,'2017-05-26 11:42:33',0);

/*!40000 ALTER TABLE `qs_sqk_health_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_notice_cat
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_notice_cat` WRITE;
/*!40000 ALTER TABLE `qs_sqk_notice_cat` DISABLE KEYS */;

INSERT INTO `qs_sqk_notice_cat` (`id`, `sys_name`, `cat_name`, `parent_id_path`, `parent_id`, `add_time`, `is_enable`)
VALUES
	(1,'meiyuetongzhi','每月通知','',0,'2017-04-01 15:33:03',1),
	(2,'linshitongzhi','临时通知','',0,'2017-04-01 15:33:19',1),
	(3,'jinjitongzhi','紧急通知','',0,'2017-04-01 15:34:02',1);

/*!40000 ALTER TABLE `qs_sqk_notice_cat` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_notice_info
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_notice_info` WRITE;
/*!40000 ALTER TABLE `qs_sqk_notice_info` DISABLE KEYS */;

INSERT INTO `qs_sqk_notice_info` (`id`, `cat_id`, `address_id`, `user_id`, `title`, `content`, `is_publish`, `add_time`, `edit_time`, `read_ids`, `read_num`)
VALUES
	(13,1,1,73,'234234','234234',1,'2018-04-04 16:19:35','2018-04-12 09:38:36',',',0),
	(14,1,0,1,'fasdfa','fasdfasd',0,'2018-04-09 14:49:43','2018-04-09 14:49:43',',',0),
	(12,2,1,1,'崔静北里','发射点发',1,'2018-04-04 16:17:11','2018-04-11 11:35:53',',109,',1);

/*!40000 ALTER TABLE `qs_sqk_notice_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_seller_cat
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_seller_cat` WRITE;
/*!40000 ALTER TABLE `qs_sqk_seller_cat` DISABLE KEYS */;

INSERT INTO `qs_sqk_seller_cat` (`id`, `sys_name`, `cat_name`, `parent_id_path`, `parent_id`, `add_time`, `is_enable`)
VALUES
	(2,'fandian','饭店类','',0,'2017-04-01 17:22:18',1),
	(3,'fuwu','服务类','',0,'2017-04-01 17:22:41',1),
	(4,'hunqing','婚庆类','',0,'2017-04-01 17:23:08',1),
	(5,'jiazheng','家政类','',0,'2017-04-01 17:23:33',1),
	(6,'lingshou','零售类','',0,'2017-04-01 17:23:48',1),
	(7,'yaodian','药店类','',0,'2017-04-01 17:24:04',1),
	(8,'zaojiao','早教类','',0,'2017-04-01 17:24:27',1),
	(9,'yule','娱乐类','',0,'2017-04-01 17:24:40',1),
	(10,'lvguan','旅馆类','',0,'2017-04-01 17:24:58',1),
	(11,'meirong','美容类','',0,'2017-04-01 17:25:13',1),
	(12,'qita','其他类','',0,'2017-04-01 17:25:25',1);

/*!40000 ALTER TABLE `qs_sqk_seller_cat` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_seller_info
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_seller_info` WRITE;
/*!40000 ALTER TABLE `qs_sqk_seller_info` DISABLE KEYS */;

INSERT INTO `qs_sqk_seller_info` (`id`, `cat_id`, `address_id`, `name`, `address`, `introduction`, `tel`, `logo_icon`, `admin_id`, `add_time`, `is_checked`, `is_rest`, `work_start`, `work_end`, `business_license`, `tax_registration`)
VALUES
	(22,6,8,'京客隆','北京市朝阳区管庄','','15010808823','/seller/logo/2017-04-21/58f9cafc3ced7.jpg',0,'2017-04-21 17:03:56',1,0,'08:00:00','19:00:00',NULL,NULL),
	(23,12,2,'聚龙电器','三河市燕郊富地广场','','010-7896541','',0,'2017-04-21 17:15:43',1,0,'10:00:00','18:00:00',NULL,NULL),
	(24,2,3,'好味道','河北省保定市定兴县','','15010808823','/seller/logo/2017-04-21/58f9d22277eeb.jpg',0,'2017-04-21 17:34:26',1,0,'10:00:00','21:00:00',NULL,NULL),
	(25,3,4,'张晓炜','s短发散发的','<p>发射点发生</p>','010-1234567','/seller/logo/2018-04-11/5acd72db221f0.jpg',0,'2018-04-10 11:19:57',1,0,'00:16:00','00:29:00',NULL,NULL),
	(29,2,8,'田老师炖牛肉','北京市海淀区苏州街5号','<p>666</p><p>666</p><p>666</p>','15687433456','/seller/logo/2018-04-15/5ad2c96ca5e7c.png',0,'2018-04-15 11:39:24',1,0,'06:00:00','18:00:00',NULL,NULL),
	(28,5,6,'大河庄园','北京市海淀区苏州街4号','<p>666</p><p>666</p><p>666</p>','15823456543','/seller/logo/2018-04-15/5ad2c50c4356f.png',0,'2018-04-15 11:20:44',1,0,'07:00:00','17:17:00',NULL,NULL),
	(30,2,8,'2222','fvfvfvf','<p>666</p>','15678434567','/seller/logo/2018-04-15/5ad2f13219975.png',0,'2018-04-15 14:29:06',1,0,'14:28:00','15:00:00',NULL,NULL),
	(31,3,8,'京洲园商家1','北京市海淀区苏州街6号','<p>666</p>','15673453457','/seller/logo/2018-04-15/5ad2f5fc0f303.jpg',0,'2018-04-15 14:49:32',1,0,'14:48:00','21:00:00',NULL,NULL),
	(32,3,6,'葛布店东里商家1','北京市丰台区纪通东路55号','<p>哈哈哈哈</p><p>哈哈哈哈</p><p>哈哈哈哈</p>','18934562345','/seller/logo/2018-04-15/5ad30992c7a5c.jpg',0,'2018-04-15 16:13:06',1,0,'08:00:00','18:00:00',NULL,NULL),
	(33,2,1,'肯德基','北京市通州区通州北苑万达广场','<p>666<br/></p><p>666</p><p>666</p>','15723457865','/seller/logo/2018-04-15/5ad3266c3c567.jpg',0,'2018-04-15 18:16:12',1,0,'08:00:00','21:00:00',NULL,NULL);

/*!40000 ALTER TABLE `qs_sqk_seller_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_seller_items_cat
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_seller_items_cat`;

CREATE TABLE `qs_sqk_seller_items_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) DEFAULT NULL COMMENT '系统名称',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `parent_id_path` varchar(50) NOT NULL DEFAULT '' COMMENT '所属上级目录',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用 0：禁用，1：启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_seller_items_cat` WRITE;
/*!40000 ALTER TABLE `qs_sqk_seller_items_cat` DISABLE KEYS */;

INSERT INTO `qs_sqk_seller_items_cat` (`id`, `sys_name`, `cat_name`, `parent_id_path`, `parent_id`, `add_time`, `is_enable`)
VALUES
	(21,'shipin','食品','',0,'2017-04-21 17:04:44',1),
	(22,'richangyongpin','日常用品','',0,'2017-04-21 17:05:21',1),
	(23,'jiayongdianqi','家用电器','',0,'2017-04-21 17:16:20',1),
	(24,'canyin','餐饮','',0,'2017-04-21 17:35:50',1);

/*!40000 ALTER TABLE `qs_sqk_seller_items_cat` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_seller_items_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_seller_items_info`;

CREATE TABLE `qs_sqk_seller_items_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属服务分类id',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `name` varchar(50) NOT NULL COMMENT '服务项目名称',
  `price` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `introduction` text COMMENT '介绍',
  `logo_img` varchar(200) NOT NULL DEFAULT '/common/nopic.jpg' COMMENT '服务项目logo',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `count_num` int(11) NOT NULL DEFAULT '0' COMMENT '库存量',
  `sold_num` int(11) NOT NULL DEFAULT '0' COMMENT '销量',
  `is_checked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否审核 0：未审核，1：审核',
  `quantifier` varchar(20) NOT NULL DEFAULT '件' COMMENT '量词',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_seller_items_info` WRITE;
/*!40000 ALTER TABLE `qs_sqk_seller_items_info` DISABLE KEYS */;

INSERT INTO `qs_sqk_seller_items_info` (`id`, `cat_id`, `seller_id`, `name`, `price`, `introduction`, `logo_img`, `add_time`, `count_num`, `sold_num`, `is_checked`, `quantifier`)
VALUES
	(33,21,22,'可口可乐',3.00,'','/seller/logo/2017-04-21/58f9cc142a602.jpg','2017-04-21 17:08:36',0,0,1,'瓶'),
	(34,22,22,'垃圾桶',15.00,'','/seller/logo/2017-04-21/58f9cc9a40fff.png','2017-04-21 17:10:50',0,0,1,'个'),
	(35,23,23,'电视',1299.00,'','/seller/logo/2017-04-21/58f9ce9e4f87c.jpg','2017-04-21 17:19:26',0,0,1,'台'),
	(36,23,23,'空调',2688.00,'','/seller/logo/2017-04-21/58f9ceecace90.jpg','2017-04-21 17:20:44',0,0,1,'台'),
	(37,23,23,'洗衣机',2400.00,'','/seller/logo/2017-04-21/58f9cf3e3c477.jpg','2017-04-21 17:22:06',0,0,1,'台'),
	(38,24,24,'鱼香肉丝',30.00,'','/seller/logo/2017-04-21/58f9d2bbcc596.jpg','2017-04-21 17:36:59',0,0,1,'盘'),
	(39,24,24,'宫保鸡丁',15.00,'','/seller/logo/2017-04-21/58f9d3167f3f1.jpg','2017-04-21 17:38:30',0,0,1,'盘');

/*!40000 ALTER TABLE `qs_sqk_seller_items_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_seller_order_eval
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_seller_order_eval`;

CREATE TABLE `qs_sqk_seller_order_eval` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `buyer_id` int(11) NOT NULL DEFAULT '0' COMMENT '买家id',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `evaluation_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '评价等级 0:好评，1：中评，2：差评',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '评价时间',
  `item_score` float(2,1) NOT NULL DEFAULT '0.0' COMMENT '项目商品评分',
  `send_score` float(2,1) NOT NULL DEFAULT '0.0' COMMENT '配送评分',
  `service_score` float(2,1) NOT NULL DEFAULT '0.0' COMMENT '服务评分',
  `content` varchar(2000) DEFAULT NULL COMMENT '评价内容',
  `reply` varchar(2000) DEFAULT NULL COMMENT '回复',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table qs_sqk_seller_order_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_seller_order_info`;

CREATE TABLE `qs_sqk_seller_order_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `order_no` varchar(50) NOT NULL COMMENT '订单编号',
  `buyer_id` int(11) NOT NULL DEFAULT '0' COMMENT '买家id',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `deal_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '处理状态：0取消，1已提交，2处理中，3交易完成',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '订单提交时间',
  `pay_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付方式 0：自提付款，1：货到付款',
  `send_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '配送方式 0：自提，1：送货上门',
  `buyer_note` varchar(2000) DEFAULT NULL COMMENT '买家留言',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_seller_order_info` WRITE;
/*!40000 ALTER TABLE `qs_sqk_seller_order_info` DISABLE KEYS */;

INSERT INTO `qs_sqk_seller_order_info` (`id`, `order_no`, `buyer_id`, `seller_id`, `deal_type`, `add_time`, `pay_type`, `send_type`, `buyer_note`)
VALUES
	(1,'D1493279717591',58,24,2,'2017-04-27 15:55:17',0,0,''),
	(2,'D1495349910102',61,24,1,'2017-05-21 14:58:29',1,1,''),
	(3,'D1495432032883',61,24,1,'2017-05-22 13:47:12',1,1,''),
	(4,'D1495432246744',58,24,1,'2017-05-22 13:50:46',1,1,''),
	(5,'D1495432333975',61,24,1,'2017-05-22 13:52:13',1,1,''),
	(6,'D1495432876956',58,24,0,'2017-05-22 14:01:16',0,0,''),
	(7,'D1495433129057',61,24,1,'2017-05-22 14:05:29',1,1,'');

/*!40000 ALTER TABLE `qs_sqk_seller_order_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_seller_order_item_rel
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_seller_order_item_rel`;

CREATE TABLE `qs_sqk_seller_order_item_rel` (
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务项目id',
  `item_num` int(11) NOT NULL DEFAULT '0' COMMENT '总数',
  `item_price` float(10,1) NOT NULL DEFAULT '0.0' COMMENT '价格'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_seller_order_item_rel` WRITE;
/*!40000 ALTER TABLE `qs_sqk_seller_order_item_rel` DISABLE KEYS */;

INSERT INTO `qs_sqk_seller_order_item_rel` (`order_id`, `item_id`, `item_num`, `item_price`)
VALUES
	(1,39,3,15.0),
	(1,38,2,30.0),
	(2,39,1,15.0),
	(3,38,1,30.0),
	(4,39,1,15.0),
	(5,39,1,15.0),
	(6,39,1,15.0),
	(7,39,1,15.0);

/*!40000 ALTER TABLE `qs_sqk_seller_order_item_rel` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_seller_prom_info
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_seller_prom_info` WRITE;
/*!40000 ALTER TABLE `qs_sqk_seller_prom_info` DISABLE KEYS */;

INSERT INTO `qs_sqk_seller_prom_info` (`id`, `seller_id`, `address_id`, `title`, `content`, `read_num`, `read_ids`, `item_ids`, `add_time`, `start_time`, `end_time`)
VALUES
	(7,31,8,'限时秒杀','<p>优惠不要错过哦</p>',6,',',',39,','2017-04-21 17:39:22','2017-04-21 00:00:00','2017-04-30 00:00:00'),
	(14,22,8,'京客隆促销1','<p>666</p>',0,',','','2018-04-15 18:02:43','2018-04-01 00:00:00','2018-04-26 00:00:00'),
	(13,31,5,'新大院','<p>666</p>',0,',','','2018-04-15 17:21:01','2018-04-04 00:00:00','2018-04-04 00:00:00'),
	(11,24,3,'好味道促销','<p>666</p>',0,',',',','2018-04-15 15:42:14','2018-04-01 00:00:00','2018-04-15 00:00:00'),
	(12,32,6,'双十一半价','<p>双十一半价，抓紧时间抢购啦！</p>',0,',','','2018-04-15 16:16:33','2018-04-08 00:00:00','2018-04-29 00:00:00'),
	(15,31,8,'京洲园商家1促销1','<p>666</p>',0,',','','2018-04-15 18:06:46','2018-04-01 00:00:00','2018-04-03 00:00:00'),
	(16,29,8,'田老师红烧肉促销2','<p>666</p>',0,',','','2018-04-15 18:09:01','2018-04-05 00:00:00','2018-04-30 00:00:00'),
	(17,33,1,'田老师红烧肉促销1','<p>666</p>',0,',','','2018-04-15 18:11:11','2018-04-01 00:00:00','2018-04-30 00:00:00'),
	(18,33,1,'肯德基五一促销','<p>肯德基五一促销啦！</p>',0,',','','2018-04-15 18:17:27','2018-04-30 00:00:00','2018-05-02 00:00:00');

/*!40000 ALTER TABLE `qs_sqk_seller_prom_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_sys_action_log
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_sys_action_log` WRITE;
/*!40000 ALTER TABLE `qs_sqk_sys_action_log` DISABLE KEYS */;

INSERT INTO `qs_sqk_sys_action_log` (`id`, `user_name`, `c_name`, `a_name`, `action_info`, `ip`, `log_time`)
VALUES
	(1283,'管理员','login','loginSys','登录系统','192.168.1.12','2017-04-21 16:50:16'),
	(1284,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','192.168.1.10','2017-04-21 17:03:56'),
	(1285,'管理员','SellerInfo','checkArrayInfo','审核商家信息','192.168.1.10','2017-04-21 17:04:02'),
	(1286,'管理员','SellerItemsCat','saveSellerItemsCat','添加/编辑商家服务项目分类','192.168.1.10','2017-04-21 17:04:44'),
	(1287,'管理员','SellerItemsCat','saveSellerItemsCat','添加/编辑商家服务项目分类','192.168.1.10','2017-04-21 17:05:21'),
	(1288,'管理员','SellerItemsInfo','saveSellerItems','添加/编辑商家服务项目信息','192.168.1.10','2017-04-21 17:08:36'),
	(1289,'管理员','SellerItemsInfo','saveSellerItems','添加/编辑商家服务项目信息','192.168.1.10','2017-04-21 17:10:50'),
	(1290,'管理员','SellerItemsInfo','checkArrayItemsInfo','审核商家服务项目信息','192.168.1.10','2017-04-21 17:10:56'),
	(1291,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','192.168.1.10','2017-04-21 17:15:43'),
	(1292,'管理员','SellerInfo','checkArrayInfo','审核商家信息','192.168.1.10','2017-04-21 17:15:50'),
	(1293,'管理员','SellerItemsCat','saveSellerItemsCat','添加/编辑商家服务项目分类','192.168.1.10','2017-04-21 17:16:20'),
	(1294,'管理员','SellerItemsInfo','saveSellerItems','添加/编辑商家服务项目信息','192.168.1.10','2017-04-21 17:19:26'),
	(1295,'管理员','SellerItemsInfo','checkArrayItemsInfo','审核商家服务项目信息','192.168.1.10','2017-04-21 17:19:32'),
	(1296,'管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','192.168.1.12','2017-04-21 17:19:45'),
	(1297,'管理员','SellerItemsInfo','saveSellerItems','添加/编辑商家服务项目信息','192.168.1.10','2017-04-21 17:20:44'),
	(1298,'管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','192.168.1.12','2017-04-21 17:20:53'),
	(1299,'管理员','NoticeInfo','publNoticeInfo','发布通知信息','192.168.1.12','2017-04-21 17:21:00'),
	(1300,'管理员','NoticeInfo','publNoticeInfo','发布通知信息','192.168.1.12','2017-04-21 17:21:04'),
	(1301,'管理员','SellerItemsInfo','saveSellerItems','添加/编辑商家服务项目信息','192.168.1.10','2017-04-21 17:22:06'),
	(1302,'管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','192.168.1.12','2017-04-21 17:22:22'),
	(1303,'管理员','NoticeInfo','publNoticeInfo','发布通知信息','192.168.1.12','2017-04-21 17:22:30'),
	(1304,'管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','192.168.1.12','2017-04-21 17:24:24'),
	(1305,'管理员','NoticeInfo','publNoticeInfo','发布通知信息','192.168.1.12','2017-04-21 17:24:38'),
	(1306,'管理员','login','loginSys','登录系统','192.168.1.12','2017-04-21 17:30:18'),
	(1307,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','192.168.1.12','2017-04-21 17:32:44'),
	(1308,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','192.168.1.12','2017-04-21 17:33:18'),
	(1309,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','192.168.1.12','2017-04-21 17:33:42'),
	(1310,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','192.168.1.12','2017-04-21 17:34:05'),
	(1311,'管理员','ActivCat','publishArrayInfo','发布社区活动信息','192.168.1.12','2017-04-21 17:34:10'),
	(1312,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','192.168.1.10','2017-04-21 17:34:26'),
	(1313,'管理员','SellerInfo','checkArrayInfo','审核商家信息','192.168.1.10','2017-04-21 17:34:33'),
	(1314,'管理员','SellerItemsInfo','checkArrayItemsInfo','审核商家服务项目信息','192.168.1.10','2017-04-21 17:34:47'),
	(1315,'管理员','HelpInfo','saveHelpInfo','添加/编辑联系人信息','192.168.1.12','2017-04-21 17:35:06'),
	(1316,'管理员','SellerItemsCat','saveSellerItemsCat','添加/编辑商家服务项目分类','192.168.1.10','2017-04-21 17:35:50'),
	(1317,'管理员','HelpInfo','saveHelpInfo','添加/编辑联系人信息','192.168.1.12','2017-04-21 17:35:55'),
	(1318,'管理员','HelpInfo','saveHelpInfo','添加/编辑联系人信息','192.168.1.12','2017-04-21 17:36:46'),
	(1319,'管理员','SellerItemsInfo','saveSellerItems','添加/编辑商家服务项目信息','192.168.1.10','2017-04-21 17:36:59'),
	(1320,'管理员','SellerItemsInfo','checkArrayItemsInfo','审核商家服务项目信息','192.168.1.10','2017-04-21 17:37:07'),
	(1321,'管理员','SellerItemsInfo','saveSellerItems','添加/编辑商家服务项目信息','192.168.1.10','2017-04-21 17:38:30'),
	(1322,'管理员','SellerItemsInfo','checkArrayItemsInfo','审核商家服务项目信息','192.168.1.10','2017-04-21 17:38:36'),
	(1323,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','192.168.1.12','2017-04-21 17:39:32'),
	(1324,'管理员','ActivCat','publishArrayInfo','发布社区活动信息','192.168.1.12','2017-04-21 17:39:39'),
	(1325,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','192.168.1.12','2017-04-21 17:41:46'),
	(1326,'管理员','ActivCat','publishArrayInfo','发布社区活动信息','192.168.1.12','2017-04-21 17:41:51'),
	(1327,'管理员','login','loginSys','登录系统','222.128.67.79','2017-04-24 10:09:39'),
	(1328,'管理员','login','logout','退出系统','222.128.67.79','2017-04-24 15:19:04'),
	(1329,'管理员','login','loginSys','登录系统','222.128.67.79','2017-04-27 10:56:22'),
	(1330,'管理员','login','loginSys','登录系统','123.115.0.239','2017-04-27 14:57:06'),
	(1331,'管理员','login','logout','退出系统','123.115.0.239','2017-04-27 14:59:35'),
	(1332,'管理员','login','loginSys','登录系统','123.115.0.239','2017-04-27 15:16:23'),
	(1333,'管理员','SellerOrderInfo','dealSellerOrderInfo','处理商家订单','123.115.0.239','2017-04-27 15:56:42'),
	(1334,'管理员','login','loginSys','登录系统','222.128.67.79','2017-04-28 16:03:19'),
	(1335,'管理员','DeviceInfo','saveDeviceInfoCat','添加/编辑体检设备','222.128.67.79','2017-04-28 16:04:09'),
	(1336,'管理员','login','loginSys','登录系统','61.49.252.140','2017-05-08 14:11:34'),
	(1337,'管理员','login','logout','退出系统','61.49.252.140','2017-05-08 14:13:54'),
	(1338,'管理员','login','loginSys','登录系统','61.49.252.140','2017-05-08 14:14:12'),
	(1339,'管理员','login','loginSys','登录系统','222.128.67.79','2017-05-09 10:39:20'),
	(1340,'管理员','login','loginSys','登录系统','222.128.67.79','2017-05-09 10:39:21'),
	(1341,'管理员','login','loginSys','登录系统','123.113.246.130','2017-05-09 13:39:51'),
	(1342,'管理员','login','loginSys','登录系统','222.128.67.79','2017-05-09 14:25:17'),
	(1343,'管理员','login','loginSys','登录系统','222.128.67.79','2017-05-15 11:32:17'),
	(1344,'管理员','login','loginSys','登录系统','222.128.67.79','2017-05-15 11:33:01'),
	(1345,'管理员','login','loginSys','登录系统','125.34.161.23','2017-05-23 14:00:53'),
	(1346,'管理员','login','loginSys','登录系统','222.128.67.79','2017-05-24 15:02:36'),
	(1347,'管理员','login','logout','退出系统','222.128.67.79','2017-05-24 16:24:35'),
	(1348,'社区管理员69','login','loginSys','登录系统','222.128.67.79','2017-05-24 16:25:11'),
	(1349,'管理员','login','loginSys','登录系统','221.216.15.75','2017-05-24 17:20:52'),
	(1350,'管理员','login','loginSys','登录系统','221.216.15.75','2017-05-24 17:33:48'),
	(1351,'管理员','login','loginSys','登录系统','222.128.67.79','2017-05-26 10:44:43'),
	(1352,'管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','222.128.67.79','2017-05-26 11:01:35'),
	(1353,'管理员','NoticeInfo','publNoticeInfo','发布通知信息','222.128.67.79','2017-05-26 11:01:39'),
	(1354,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','222.128.67.79','2017-05-26 11:05:34'),
	(1355,'管理员','login','logout','退出系统','222.128.67.79','2017-05-26 11:05:40'),
	(1356,'物业测试001','login','loginSys','登录系统','222.128.67.79','2017-05-26 11:05:54'),
	(1357,'物业测试001','login','logout','退出系统','222.128.67.79','2017-05-26 11:07:06'),
	(1358,'管理员','login','loginSys','登录系统','222.128.67.79','2017-05-26 11:07:28'),
	(1359,'管理员','HealthnCat','saveHealthCat','添加/编辑健康知识分类','222.128.67.79','2017-05-26 11:30:00'),
	(1360,'管理员','HealthnInfo','saveHealthInfo','添加/编辑健康知识信息','222.128.67.79','2017-05-26 11:32:36'),
	(1361,'管理员','HealthnInfo','publHealthInfo','发布健康知识信息','222.128.67.79','2017-05-26 11:32:42'),
	(1362,'管理员','HealthnInfo','saveHealthInfo','添加/编辑健康知识信息','222.128.67.79','2017-05-26 11:35:18'),
	(1363,'管理员','HealthnInfo','publHealthInfo','发布健康知识信息','222.128.67.79','2017-05-26 11:35:22'),
	(1364,'管理员','HealthnInfo','saveHealthInfo','添加/编辑健康知识信息','222.128.67.79','2017-05-26 11:35:53'),
	(1365,'管理员','HealthnInfo','saveHealthInfo','添加/编辑健康知识信息','222.128.67.79','2017-05-26 11:36:24'),
	(1366,'管理员','HealthnInfo','saveHealthInfo','添加/编辑健康知识信息','222.128.67.79','2017-05-26 11:38:28'),
	(1367,'管理员','HealthnInfo','saveHealthInfo','添加/编辑健康知识信息','222.128.67.79','2017-05-26 11:39:12'),
	(1368,'管理员','HealthnInfo','saveHealthInfo','添加/编辑健康知识信息','222.128.67.79','2017-05-26 11:39:36'),
	(1369,'管理员','HealthnInfo','publHealthInfo','发布健康知识信息','222.128.67.79','2017-05-26 11:39:58'),
	(1370,'管理员','HealthnInfo','saveHealthInfo','添加/编辑健康知识信息','222.128.67.79','2017-05-26 11:40:56'),
	(1371,'管理员','HealthnInfo','publHealthInfo','发布健康知识信息','222.128.67.79','2017-05-26 11:41:06'),
	(1372,'管理员','HealthnInfo','saveHealthInfo','添加/编辑健康知识信息','222.128.67.79','2017-05-26 11:42:33'),
	(1373,'管理员','HealthnInfo','publHealthInfo','发布健康知识信息','222.128.67.79','2017-05-26 11:42:42'),
	(1374,'管理员','HealthnCat','saveHealthCat','添加/编辑健康知识分类','222.128.67.79','2017-05-26 11:43:38'),
	(1375,'管理员','login','loginSys','登录系统','123.114.249.207','2017-05-26 13:15:31'),
	(1376,'管理员','HealthnCat','saveHealthCat','添加/编辑健康知识分类','123.114.249.207','2017-05-26 13:20:13'),
	(1377,'管理员','login','loginSys','登录系统','123.114.249.207','2017-05-26 13:27:42'),
	(1378,'管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','123.114.249.207','2017-05-26 13:28:10'),
	(1379,'管理员','login','loginSys','登录系统','123.114.249.207','2017-05-26 16:03:28'),
	(1380,'管理员','login','logout','退出系统','222.128.67.79','2017-06-01 09:12:03'),
	(1381,'管理员','login','loginSys','登录系统','222.128.67.79','2017-06-09 08:48:51'),
	(1382,'管理员','login','loginSys','登录系统','222.128.67.79','2017-06-09 16:51:19'),
	(1383,'管理员','login','loginSys','登录系统','222.128.67.79','2017-06-12 08:41:04'),
	(1384,'管理员','login','loginSys','登录系统','222.128.67.79','2017-06-13 10:52:46'),
	(1385,'管理员','login','loginSys','登录系统','222.128.67.79','2017-06-15 14:33:41'),
	(1386,'管理员','login','loginSys','登录系统','222.128.67.79','2017-06-16 08:57:20'),
	(1387,'管理员','login','loginSys','登录系统','123.127.181.171','2017-06-27 15:57:19'),
	(1388,'管理员','login','loginSys','登录系统','123.127.181.171','2017-06-27 16:16:55'),
	(1389,'管理员','login','loginSys','登录系统','222.128.67.79','2017-06-28 08:40:02'),
	(1390,'管理员','login','loginSys','登录系统','127.0.0.1','2017-07-24 10:08:05'),
	(1391,'管理员','login','loginSys','登录系统','127.0.0.1','2017-11-13 14:47:09'),
	(1392,'管理员','login','logout','退出系统','127.0.0.1','2017-11-13 14:48:29'),
	(1393,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-03 11:44:11'),
	(1394,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-03 13:11:49'),
	(1395,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-03 13:12:27'),
	(1396,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-03 13:14:04'),
	(1397,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-03 13:14:54'),
	(1398,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-03 13:16:00'),
	(1399,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-03 13:16:24'),
	(1400,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-03 13:44:41'),
	(1401,'管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','127.0.0.1','2018-04-03 14:18:16'),
	(1402,'管理员','NoticeInfo','publNoticeInfo','发布通知信息','127.0.0.1','2018-04-03 14:18:20'),
	(1403,'管理员','login','logout','退出系统','127.0.0.1','2018-04-03 14:20:55'),
	(1404,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-03 14:21:01'),
	(1405,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-03 14:22:21'),
	(1406,'管理员','ActivCat','showJoinList','查看参加活动人数','127.0.0.1','2018-04-03 14:43:44'),
	(1407,'管理员','ActivCat','delArrayInfo','删除社区活动信息','127.0.0.1','2018-04-03 14:44:06'),
	(1408,'管理员','ActivCat','publishArrayInfo','发布社区活动信息','127.0.0.1','2018-04-03 14:46:15'),
	(1409,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-03 15:07:16'),
	(1410,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-03 15:07:28'),
	(1411,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-03 15:07:39'),
	(1412,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-03 16:40:54'),
	(1413,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-03 16:40:55'),
	(1414,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-03 16:40:59'),
	(1415,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-03 16:42:53'),
	(1416,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-03 16:46:15'),
	(1417,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-03 16:47:12'),
	(1418,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-03 16:47:25'),
	(1419,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-03 16:47:31'),
	(1420,'管理员','login','logout','退出系统','127.0.0.1','2018-04-03 17:00:54'),
	(1421,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-03 17:01:09'),
	(1422,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-03 17:02:33'),
	(1423,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 08:47:55'),
	(1424,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 09:05:25'),
	(1425,'管理员','SysUserInfo','delArrUserInfo','删除用户信息','127.0.0.1','2018-04-04 09:09:49'),
	(1426,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-04 09:11:15'),
	(1427,'管理员','ActivCat','publishArrayInfo','发布社区活动信息','127.0.0.1','2018-04-04 09:11:21'),
	(1428,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-04 09:16:46'),
	(1429,'管理员','login','logout','退出系统','127.0.0.1','2018-04-04 13:09:00'),
	(1430,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 13:09:26'),
	(1431,'管理员','login','logout','退出系统','127.0.0.1','2018-04-04 13:12:08'),
	(1432,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 13:12:18'),
	(1433,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 13:12:52'),
	(1434,'翠景北里-管理员','ActivCat','showJoinList','查看参加活动人数','127.0.0.1','2018-04-04 13:41:44'),
	(1435,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-04 14:06:07'),
	(1436,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-04 14:12:00'),
	(1437,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-04 14:12:01'),
	(1438,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-04 14:12:01'),
	(1439,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-04 14:12:05'),
	(1440,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-04 14:12:18'),
	(1441,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-04 14:14:50'),
	(1442,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-04 14:30:45'),
	(1443,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-04 14:30:51'),
	(1444,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-04 14:30:55'),
	(1445,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-04 14:34:05'),
	(1446,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-04 14:34:10'),
	(1447,'翠景北里-管理员','ActivCat','showJoinList','查看参加活动人数','127.0.0.1','2018-04-04 14:46:27'),
	(1448,'翠景北里-管理员','ActivCat','showJoinList','查看参加活动人数','127.0.0.1','2018-04-04 14:46:30'),
	(1449,'翠景北里-管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-04 14:46:40'),
	(1450,'翠景北里-管理员','ActivCat','delArrayInfo','删除社区活动信息','127.0.0.1','2018-04-04 14:47:25'),
	(1451,'翠景北里-管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','127.0.0.1','2018-04-04 14:58:28'),
	(1452,'翠景北里-管理员','NoticeInfo','publNoticeInfo','发布通知信息','127.0.0.1','2018-04-04 14:59:09'),
	(1453,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-04 15:03:14'),
	(1454,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 15:03:25'),
	(1455,'翠景北里-管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','127.0.0.1','2018-04-04 15:04:08'),
	(1456,'翠景北里-管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','127.0.0.1','2018-04-04 15:14:49'),
	(1457,'翠景北里-管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','127.0.0.1','2018-04-04 15:18:02'),
	(1458,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-04 15:18:06'),
	(1459,'翠屏北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 15:18:15'),
	(1460,'翠屏北里-管理员','NoticeInfo','publNoticeInfo','发布通知信息','127.0.0.1','2018-04-04 15:18:24'),
	(1461,'翠屏北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-04 15:26:38'),
	(1462,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 15:26:42'),
	(1463,'管理员','login','logout','退出系统','127.0.0.1','2018-04-04 15:40:41'),
	(1464,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 15:40:47'),
	(1465,'管理员','login','logout','退出系统','127.0.0.1','2018-04-04 15:41:55'),
	(1466,'云景里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 15:42:06'),
	(1467,'云景里-管理员','login','logout','退出系统','127.0.0.1','2018-04-04 16:14:59'),
	(1468,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 16:15:03'),
	(1469,'管理员','NoticeInfo','delArrayInfo','删除通知信息','127.0.0.1','2018-04-04 16:15:27'),
	(1470,'管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','127.0.0.1','2018-04-04 16:15:53'),
	(1471,'管理员','NoticeInfo','publNoticeInfo','发布通知信息','127.0.0.1','2018-04-04 16:16:00'),
	(1472,'管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','127.0.0.1','2018-04-04 16:17:11'),
	(1473,'管理员','NoticeInfo','publNoticeInfo','发布通知信息','127.0.0.1','2018-04-04 16:17:51'),
	(1474,'管理员','login','logout','退出系统','127.0.0.1','2018-04-04 16:19:02'),
	(1475,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 16:19:13'),
	(1476,'翠景北里-管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','127.0.0.1','2018-04-04 16:19:35'),
	(1477,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-04 16:25:04'),
	(1478,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 16:25:09'),
	(1479,'管理员','login','logout','退出系统','127.0.0.1','2018-04-04 16:29:20'),
	(1480,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 16:29:38'),
	(1481,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-04 16:44:32'),
	(1482,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-04 16:53:45'),
	(1483,'管理员','login','logout','退出系统','127.0.0.1','2018-04-04 16:56:52'),
	(1484,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 16:57:08'),
	(1485,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-04 16:57:48'),
	(1486,'管理员','login','logout','退出系统','127.0.0.1','2018-04-04 16:57:58'),
	(1487,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 16:58:20'),
	(1488,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-04 17:35:08'),
	(1489,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-08 08:41:19'),
	(1490,'管理员','login','logout','退出系统','127.0.0.1','2018-04-08 09:31:24'),
	(1491,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-08 09:31:38'),
	(1492,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-08 09:34:46'),
	(1493,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-08 09:34:50'),
	(1494,'管理员','login','logout','退出系统','127.0.0.1','2018-04-08 09:41:24'),
	(1495,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-08 09:41:40'),
	(1496,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-08 09:44:18'),
	(1497,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-08 10:38:45'),
	(1498,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-08 10:55:26'),
	(1499,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-08 10:56:16'),
	(1500,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-08 10:56:19'),
	(1501,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-08 10:56:22'),
	(1502,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-08 10:58:03'),
	(1503,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-08 10:58:19'),
	(1504,'翠景北里-管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-08 11:35:59'),
	(1505,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-08 11:53:43'),
	(1506,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-08 15:15:41'),
	(1507,'翠景北里-管理员','ActivCat','publishArrayInfo','发布社区活动信息','127.0.0.1','2018-04-08 15:57:35'),
	(1508,'翠景北里-管理员','ActivInfo','overArrayInfo','批量结束活动信息','127.0.0.1','2018-04-08 16:46:27'),
	(1509,'翠景北里-管理员','ActivInfo','overArrayInfo','批量结束活动信息','127.0.0.1','2018-04-08 16:46:35'),
	(1510,'翠景北里-管理员','ActivCat','publishArrayInfo','发布社区活动信息','127.0.0.1','2018-04-08 16:46:47'),
	(1511,'翠景北里-管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-08 17:37:42'),
	(1512,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-09 08:52:44'),
	(1513,'管理员','login','logout','退出系统','127.0.0.1','2018-04-09 09:44:25'),
	(1514,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-09 09:44:36'),
	(1515,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-09 09:45:18'),
	(1516,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-09 09:57:50'),
	(1517,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-09 10:04:12'),
	(1518,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-09 10:04:17'),
	(1519,'管理员','login','logout','退出系统','127.0.0.1','2018-04-09 14:16:10'),
	(1520,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-09 14:16:27'),
	(1521,'翠景北里-管理员','NoticeInfo','delArrayInfo','删除通知信息','127.0.0.1','2018-04-09 14:46:00'),
	(1522,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-09 14:49:22'),
	(1523,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-09 14:49:27'),
	(1524,'管理员','NoticeInfo','saveNoticeInfo','添加/编辑通知信息','127.0.0.1','2018-04-09 14:49:43'),
	(1525,'管理员','login','logout','退出系统','127.0.0.1','2018-04-09 14:49:49'),
	(1526,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-09 14:49:56'),
	(1527,'翠景北里-管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-09 16:38:15'),
	(1528,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-10 08:50:19'),
	(1529,'管理员','login','logout','退出系统','127.0.0.1','2018-04-10 09:19:43'),
	(1530,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-10 09:19:53'),
	(1531,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-10 10:03:40'),
	(1532,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-10 10:03:49'),
	(1533,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 10:09:25'),
	(1534,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 10:09:28'),
	(1535,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 10:09:35'),
	(1536,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 10:09:48'),
	(1537,'管理员','NoticeCat','saveNoticeCat','添加/编辑通知分类','127.0.0.1','2018-04-10 10:25:34'),
	(1538,'管理员','NoticeCat','saveNoticeCat','添加/编辑通知分类','127.0.0.1','2018-04-10 10:25:39'),
	(1539,'管理员','NoticeCat','saveNoticeCat','添加/编辑通知分类','127.0.0.1','2018-04-10 10:25:45'),
	(1540,'管理员','NoticeCat','saveNoticeCat','添加/编辑通知分类','127.0.0.1','2018-04-10 10:26:09'),
	(1541,'管理员','NoticeCat','saveNoticeCat','添加/编辑通知分类','127.0.0.1','2018-04-10 10:26:14'),
	(1542,'管理员','NoticeCat','saveNoticeCat','添加/编辑通知分类','127.0.0.1','2018-04-10 10:26:18'),
	(1543,'管理员','ActivCat','delActivCat','删除社区活动分类','127.0.0.1','2018-04-10 10:37:04'),
	(1544,'管理员','ActivCat','saveActivCat','添加/编辑社区活动分类','127.0.0.1','2018-04-10 10:37:10'),
	(1545,'管理员','ActivCat','saveActivCat','添加/编辑社区活动分类','127.0.0.1','2018-04-10 10:37:15'),
	(1546,'管理员','SellerInfo','checkArrayInfo','审核商家信息','127.0.0.1','2018-04-10 11:02:09'),
	(1547,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-10 11:19:57'),
	(1548,'管理员','SellerInfo','checkArrayInfo','审核商家信息','127.0.0.1','2018-04-10 11:20:15'),
	(1549,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 11:43:08'),
	(1550,'管理员','SysUserInfo','delArrUserInfo','删除用户信息','127.0.0.1','2018-04-10 11:46:38'),
	(1551,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 11:47:15'),
	(1552,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 11:50:42'),
	(1553,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 11:53:13'),
	(1554,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 11:53:29'),
	(1555,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 11:53:29'),
	(1556,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 11:53:35'),
	(1557,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 11:53:40'),
	(1558,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 11:55:52'),
	(1559,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 11:55:58'),
	(1560,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-10 11:56:05'),
	(1561,'管理员','ActivCat','showJoinList','查看参加活动人数','127.0.0.1','2018-04-10 13:16:12'),
	(1562,'管理员','ActivCat','showJoinList','查看参加活动人数','127.0.0.1','2018-04-10 13:16:18'),
	(1563,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-11 09:44:03'),
	(1564,'管理员','ActivInfo','overArrayInfo','批量结束活动信息','127.0.0.1','2018-04-11 09:45:42'),
	(1565,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-11 10:07:08'),
	(1566,'翠景北里-管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 10:18:13'),
	(1567,'翠景北里-管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 10:28:43'),
	(1568,'翠景北里-管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 10:30:04'),
	(1569,'翠景北里-管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 10:36:10'),
	(1570,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-11 11:05:05'),
	(1571,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-11 11:07:30'),
	(1572,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-11 11:07:36'),
	(1573,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-11 11:38:46'),
	(1574,'管理员','ActivCat','publishArrayInfo','发布社区活动信息','127.0.0.1','2018-04-11 11:38:52'),
	(1575,'管理员','ActivCat','publishArrayInfo','发布社区活动信息','127.0.0.1','2018-04-11 13:14:44'),
	(1576,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 13:29:58'),
	(1577,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 13:56:14'),
	(1578,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 13:56:22'),
	(1579,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 13:56:52'),
	(1580,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 13:58:52'),
	(1581,'管理员','login','logout','退出系统','127.0.0.1','2018-04-11 14:03:13'),
	(1582,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-11 14:03:26'),
	(1583,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-11 14:05:12'),
	(1584,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-11 14:05:20'),
	(1585,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 14:19:24'),
	(1586,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 14:19:33'),
	(1587,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 14:25:16'),
	(1588,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 14:30:32'),
	(1589,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 14:30:51'),
	(1590,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 14:33:27'),
	(1591,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 14:34:55'),
	(1592,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 14:35:24'),
	(1593,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 14:40:17'),
	(1594,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 15:02:51'),
	(1595,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 15:10:22'),
	(1596,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 15:12:44'),
	(1597,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 15:13:57'),
	(1598,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 15:15:04'),
	(1599,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-11 15:23:13'),
	(1600,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 15:33:36'),
	(1601,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 15:46:18'),
	(1602,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-11 15:47:18'),
	(1603,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-11 16:32:21'),
	(1604,'管理员','ActivCat','showJoinList','查看参加活动人数','127.0.0.1','2018-04-11 16:48:21'),
	(1605,'管理员','ActivCat','showJoinList','查看参加活动人数','127.0.0.1','2018-04-11 16:48:28'),
	(1606,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-11 16:52:57'),
	(1607,'管理员','ActivCat','publishArrayInfo','发布社区活动信息','127.0.0.1','2018-04-11 16:53:02'),
	(1608,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-11 16:53:46'),
	(1609,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-11 17:12:54'),
	(1610,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-11 17:28:38'),
	(1611,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-12 09:21:02'),
	(1612,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-12 09:21:57'),
	(1613,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-12 09:32:48'),
	(1614,'管理员','NoticeInfo','publNoticeInfo','发布通知信息','127.0.0.1','2018-04-12 09:38:36'),
	(1615,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-12 11:59:25'),
	(1616,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-12 13:35:05'),
	(1617,'管理员','SellerInfo','delArraySellerInfo','删除商家信息','127.0.0.1','2018-04-12 13:36:43'),
	(1618,'管理员','ActivInfo','saveActivInfo','添加/编辑社区活动信息','127.0.0.1','2018-04-12 13:45:59'),
	(1619,'管理员','login','logout','退出系统','127.0.0.1','2018-04-12 15:57:40'),
	(1620,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-12 15:58:07'),
	(1621,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-12 15:59:46'),
	(1622,'翠屏南里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-12 15:59:56'),
	(1623,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-13 08:44:39'),
	(1624,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-13 11:52:06'),
	(1625,'管理员','SysUserInfo','delArrUserInfo','删除用户信息','127.0.0.1','2018-04-13 11:52:13'),
	(1626,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-13 11:56:23'),
	(1627,'管理员','SysUserInfo','delArrUserInfo','删除用户信息','127.0.0.1','2018-04-13 13:21:53'),
	(1628,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-13 13:26:08'),
	(1629,'管理员','login','logout','退出系统','127.0.0.1','2018-04-13 13:44:18'),
	(1630,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-13 13:45:29'),
	(1631,'管理员','login','logout','退出系统','127.0.0.1','2018-04-13 13:49:20'),
	(1632,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-13 13:49:26'),
	(1633,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-13 13:51:57'),
	(1634,'管理员','SysUserInfo','saveUserInfo','添加/编辑用户信息','127.0.0.1','2018-04-13 14:07:07'),
	(1635,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-13 14:08:05'),
	(1636,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-13 14:08:08'),
	(1637,'管理员','SysUserInfo','saveUserInfo','添加/编辑居民用户信息','127.0.0.1','2018-04-13 14:08:36'),
	(1638,'管理员','login','logout','退出系统','127.0.0.1','2018-04-13 15:43:27'),
	(1639,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-13 15:43:36'),
	(1640,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-13 15:46:17'),
	(1641,'管理员','login','logout','退出系统','127.0.0.1','2018-04-13 16:53:30'),
	(1642,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-13 17:04:13'),
	(1643,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-13 18:52:26'),
	(1644,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 09:46:13'),
	(1645,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-15 10:27:27'),
	(1646,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-15 10:33:51'),
	(1647,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-15 11:14:04'),
	(1648,'管理员','login','logout','退出系统','127.0.0.1','2018-04-15 11:15:07'),
	(1649,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 11:15:55'),
	(1650,'翠景北里-管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-15 11:20:44'),
	(1651,'翠景北里-管理员','SellerInfo','checkArrayInfo','审核商家信息','127.0.0.1','2018-04-15 11:21:22'),
	(1652,'翠景北里-管理员','SellerInfo','delArraySellerInfo','删除商家信息','127.0.0.1','2018-04-15 11:22:45'),
	(1653,'翠景北里-管理员','SellerCat','saveSellerCat','添加/编辑商家分类','127.0.0.1','2018-04-15 11:37:25'),
	(1654,'翠景北里-管理员','SellerCat','saveSellerCat','添加/编辑商家分类','127.0.0.1','2018-04-15 11:37:39'),
	(1655,'翠景北里-管理员','SellerCat','delSellerCat','删除商家分类','127.0.0.1','2018-04-15 11:37:44'),
	(1656,'翠景北里-管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-15 11:39:24'),
	(1657,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-15 11:43:06'),
	(1658,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 11:43:11'),
	(1659,'管理员','login','logout','退出系统','127.0.0.1','2018-04-15 12:54:55'),
	(1660,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 12:55:00'),
	(1661,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-15 12:59:58'),
	(1662,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 13:00:02'),
	(1663,'管理员','login','logout','退出系统','127.0.0.1','2018-04-15 13:05:19'),
	(1664,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 13:05:23'),
	(1665,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-15 13:15:01'),
	(1666,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 13:15:05'),
	(1667,'管理员','login','logout','退出系统','127.0.0.1','2018-04-15 14:03:12'),
	(1668,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 14:03:15'),
	(1669,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-15 14:09:04'),
	(1670,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 14:09:08'),
	(1671,'管理员','login','logout','退出系统','127.0.0.1','2018-04-15 14:21:04'),
	(1672,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 14:21:10'),
	(1673,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-15 14:21:18'),
	(1674,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 14:21:21'),
	(1675,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-15 14:29:06'),
	(1676,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-15 14:36:42'),
	(1677,'管理员','login','logout','退出系统','127.0.0.1','2018-04-15 14:36:51'),
	(1678,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 14:36:53'),
	(1679,'管理员','login','logout','退出系统','127.0.0.1','2018-04-15 14:37:01'),
	(1680,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 14:37:04'),
	(1681,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-15 14:46:57'),
	(1682,'京洲园-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 14:47:01'),
	(1683,'京洲园-管理员','login','logout','退出系统','127.0.0.1','2018-04-15 14:47:32'),
	(1684,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 14:47:36'),
	(1685,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-15 14:47:50'),
	(1686,'管理员','login','logout','退出系统','127.0.0.1','2018-04-15 14:47:56'),
	(1687,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 14:47:59'),
	(1688,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-15 14:48:23'),
	(1689,'京洲园-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 14:48:26'),
	(1690,'京洲园-管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-15 14:49:32'),
	(1691,'京洲园-管理员','login','logout','退出系统','127.0.0.1','2018-04-15 14:49:53'),
	(1692,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 14:49:57'),
	(1693,'管理员','login','logout','退出系统','127.0.0.1','2018-04-15 15:03:15'),
	(1694,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 15:03:18'),
	(1695,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-15 15:03:39'),
	(1696,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 15:03:42'),
	(1697,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-15 16:13:06'),
	(1698,'管理员','SellerInfo','checkArrayInfo','审核商家信息','127.0.0.1','2018-04-15 16:15:43'),
	(1699,'管理员','login','logout','退出系统','127.0.0.1','2018-04-15 17:05:53'),
	(1700,'翠景北里-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 17:05:56'),
	(1701,'翠景北里-管理员','login','logout','退出系统','127.0.0.1','2018-04-15 17:08:32'),
	(1702,'京洲园-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 17:08:35'),
	(1703,'京洲园-管理员','login','logout','退出系统','127.0.0.1','2018-04-15 17:09:32'),
	(1704,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 17:09:35'),
	(1705,'管理员','login','logout','退出系统','127.0.0.1','2018-04-15 17:35:12'),
	(1706,'京洲园-管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 17:35:16'),
	(1707,'京洲园-管理员','login','logout','退出系统','127.0.0.1','2018-04-15 18:14:30'),
	(1708,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 18:14:35'),
	(1709,'管理员','SellerInfo','saveSellerInfo','添加/编辑商家信息','127.0.0.1','2018-04-15 18:16:12'),
	(1710,'管理员','SellerInfo','checkArrayInfo','审核商家信息','127.0.0.1','2018-04-15 18:16:32'),
	(1711,'管理员','login','logout','退出系统','127.0.0.1','2018-04-15 19:02:26'),
	(1712,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-15 19:02:30'),
	(1713,'管理员','login','logout','退出系统','127.0.0.1','2018-04-15 19:03:16'),
	(1714,'管理员','login','loginSys','登录系统','127.0.0.1','2018-04-16 10:03:27');

/*!40000 ALTER TABLE `qs_sqk_sys_action_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_sys_all_attach
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_sys_all_attach` WRITE;
/*!40000 ALTER TABLE `qs_sqk_sys_all_attach` DISABLE KEYS */;

INSERT INTO `qs_sqk_sys_all_attach` (`id`, `module_name`, `module_info_id`, `file_path`, `file_real_name`, `file_ext`, `file_size`)
VALUES
	(148,'activity',1,'Public/Upload/activity/2017-04-21/58f9d1ba87922.jpg','10856797.jpg','jpg','244555'),
	(149,'activity',2,'Public/Upload/activity/2017-04-21/58f9d1dcf146b.jpg','10856798.jpg','jpg','167945'),
	(150,'activity',3,'Public/Upload/activity/2017-04-21/58f9d1f43f9f7.jpg','10856799.jpg','jpg','191036'),
	(151,'activity',4,'Public/Upload/activity/2017-04-21/58f9d20bdc727.jpg','14345487.jpg','jpg','144067'),
	(155,'activity',7,'Public/Upload/activity/2018-04-04/5ac4261fa91b3.jpg','02.jpg','jpg','162884'),
	(156,'activity',7,'Public/Upload/activity/2018-04-04/5ac42622103f3.jpg','2a5ac85aaaa2d951-48ebc1dba4f3112d-7022ab585b7468744cee99e7cfc47231.jpg','jpg','28323'),
	(157,'activity',7,'Public/Upload/activity/2018-04-04/5ac426250f2c2.png','003.png','png','622227'),
	(167,'activity',5,'Public/Upload/activity/2018-04-04/5ac474ced03e2.jpg','04.jpg','jpg','103203'),
	(168,'activity',8,'Public/Upload/activity/2018-04-04/5ac4906eb9f32.png','004.png','png','732789'),
	(169,'activity',9,'Public/Upload/activity/2018-04-04/5ac493895406d.png','004.png','png','732789'),
	(170,'activity',9,'Public/Upload/activity/2018-04-04/5ac49389bb18e.jpg','7.jpg','jpg','181972'),
	(171,'activity',9,'Public/Upload/activity/2018-04-04/5ac49389d43c1.jpg','08.jpg','jpg','89214'),
	(176,'activity',11,'Public/Upload/activity/2018-04-11/5acd833d494d2.PNG','002.PNG','PNG','877563'),
	(177,'activity',11,'Public/Upload/activity/2018-04-11/5acd8343259be.jpg','03.jpg','jpg','104996'),
	(178,'activity',11,'Public/Upload/activity/2018-04-11/5acd83434031a.png','003.png','png','622227'),
	(179,'activity',11,'Public/Upload/activity/2018-04-11/5acd8343bbc9c.jpg','3c28af542f2d49f7-da1566425074a021-9c373de8439e52c5d885c8459d285946.jpg','jpg','15588'),
	(180,'activity',11,'Public/Upload/activity/2018-04-11/5acd83440c117.jpg','3.jpg','jpg','751728'),
	(216,'activity',12,'Public/Upload/activity/2018-04-11/5acdb7de3801b.jpg','8.jpg','jpg','270735'),
	(217,'activity',12,'Public/Upload/activity/2018-04-11/5acdb7de71f82.jpg','9.jpg','jpg','480117'),
	(218,'activity',12,'Public/Upload/activity/2018-04-11/5acdb7dee15a4.jpg','10.jpg','jpg','533355'),
	(219,'activity',12,'Public/Upload/activity/2018-04-11/5acdb7df11047.jpg','11.jpg','jpg','395180'),
	(221,'sellerInfo',26,'Public/Upload/sellerInfo/2018-04-11/5acdba4d42ca9.jpg','8.jpg','jpg','270735'),
	(222,'sellerInfo',26,'Public/Upload/sellerInfo/2018-04-11/5acdba4d8d0a0.jpg','9.jpg','jpg','480117'),
	(229,'sellerInfo',23,'Public/Upload/sellerInfo/2018-04-11/5acdbd8302577.jpg','8.jpg','jpg','270735'),
	(230,'activity',10,'Public/Upload/activity/2018-04-11/5acdc813d89e4.jpg','8501654.jpg','jpg','179644'),
	(231,'activity',6,'Public/Upload/activity/2018-04-11/5acdd19397ddb.jpg','u=3131094046,435481623&fm=27&gp=0.jpg','jpg','36398'),
	(232,'activity',6,'Public/Upload/activity/2018-04-11/5acdd193b1d3e.jpg','W020170605399560934416.jpg','jpg','50251'),
	(233,'activity',6,'Public/Upload/activity/2018-04-11/5acdd193d05bb.jpg','W020170605401650901537.jpg','jpg','85703'),
	(234,'activity',6,'Public/Upload/activity/2018-04-11/5acdd193f1afc.jpg','W020170605418321621706.jpg','jpg','69188'),
	(239,'sellerInfo',0,'Public/Upload/sellerInfo/2018-04-13/5ad089d675e93.jpeg','身份证.jpeg','jpeg','95033'),
	(240,'sellerInfo',0,'Public/Upload/sellerInfo/2018-04-13/5ad089df57c09.jpeg','身份证2.jpeg','jpeg','25616'),
	(241,'sellerInfo',0,'Public/Upload/sellerInfo/2018-04-13/5ad093da34d6d.png','图片2.png','png','30856'),
	(242,'sellerInfo',0,'Public/Upload/sellerInfo/2018-04-13/5ad0947e0ea98.png','图片1.png','png','571839'),
	(243,'sellerInfo',0,'Public/Upload/sellerInfo/2018-04-13/5ad094ea1300e.png','图片2.png','png','30856'),
	(244,'sellerInfo',26,'Public/Upload/sellerInfo/2018-04-15/5ad2b853cfe0c.png','图片2.png','png','30856'),
	(245,'sellerInfo',0,'Public/Upload/sellerInfo/2018-04-15/5ad2c214796d3.jpeg','身份证2.jpeg','jpeg','25616'),
	(246,'sellerInfo',0,'Public/Upload/sellerInfo/2018-04-15/5ad2c225aef1b.png','图片2.png','png','30856'),
	(247,'sellerInfo',27,'Public/Upload/sellerInfo/2018-04-15/5ad2c36d49b67.jpeg','身份证.jpeg','jpeg','95033'),
	(248,'sellerInfo',27,'Public/Upload/sellerInfo/2018-04-15/5ad2c371d5bbb.jpeg','身份证2.jpeg','jpeg','25616'),
	(249,'sellerInfo',0,'Public/Upload/sellerInfo/2018-04-15/5ad2c4e2a24a3.jpeg','身份证.jpeg','jpeg','95033'),
	(250,'sellerInfo',0,'Public/Upload/sellerInfo/2018-04-15/5ad2c4e7306ac.jpeg','身份证2.jpeg','jpeg','25616'),
	(251,'sellerInfo',28,'Public/Upload/sellerInfo/2018-04-15/5ad2c50609be7.jpeg','身份证.jpeg','jpeg','95033'),
	(252,'sellerInfo',28,'Public/Upload/sellerInfo/2018-04-15/5ad2c509e10a1.jpeg','身份证2.jpeg','jpeg','25616'),
	(253,'sellerInfo',29,'Public/Upload/sellerInfo/2018-04-15/5ad2c962a0526.jpeg','身份证.jpeg','jpeg','95033'),
	(254,'sellerInfo',33,'Public/Upload/sellerInfo/2018-04-15/5ad326627fcfb.jpeg','身份证.jpeg','jpeg','95033'),
	(255,'sellerInfo',33,'Public/Upload/sellerInfo/2018-04-15/5ad32666d00ff.jpeg','身份证2.jpeg','jpeg','25616');

/*!40000 ALTER TABLE `qs_sqk_sys_all_attach` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_sys_community_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_sys_community_info`;

CREATE TABLE `qs_sqk_sys_community_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '系统名称',
  `com_name` varchar(50) NOT NULL COMMENT '分类名称',
  `timestamp` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `uf_num` varchar(20) NOT NULL COMMENT '卡片串号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_sys_community_info` WRITE;
/*!40000 ALTER TABLE `qs_sqk_sys_community_info` DISABLE KEYS */;

INSERT INTO `qs_sqk_sys_community_info` (`id`, `address_id`, `com_name`, `timestamp`, `uf_num`)
VALUES
	(1,1,'翠景北里',1523415889,'uasfjwe213'),
	(2,2,'翠屏北里',1523241400,'00000000'),
	(3,3,'翠屏南里',1523241400,'00000000'),
	(4,4,'大方居',1523241400,'00000000'),
	(5,5,'格瑞雅居',1523241400,'00000000'),
	(6,6,'葛布店东里',1523241400,'00000000'),
	(7,7,'金侨时代',1523241400,'00000000'),
	(8,8,'京洲园',1523241400,'00000000'),
	(9,9,'靓景明居',1523241400,'00000000'),
	(10,10,'梨园东里',1523241400,'00000000'),
	(11,11,'龙鼎园',1523241400,'00000000'),
	(12,12,'曼城家园',1523241400,'00000000'),
	(13,13,'群芳园',1523241400,'00000000'),
	(14,14,'万盛北里',1523241400,'00000000'),
	(15,15,'欣达园',1523241400,'00000000'),
	(16,16,'新城乐居',1523241400,'00000000'),
	(17,17,'新华联南区',1523241400,'00000000'),
	(18,18,'颐瑞东里',1523241400,'00000000'),
	(19,19,'颐瑞西里',1523241400,'00000000'),
	(20,20,'云景北里',1523241400,'00000000'),
	(21,21,'云景东里',1523241400,'00000000'),
	(22,22,'云景里',1523241400,'00000000');

/*!40000 ALTER TABLE `qs_sqk_sys_community_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_sys_config_def
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_sys_config_def`;

CREATE TABLE `qs_sqk_sys_config_def` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) NOT NULL COMMENT '系统名称',
  `set_key` varchar(50) NOT NULL COMMENT '配置键',
  `set_value` varchar(500) NOT NULL COMMENT '配置值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_sys_config_def` WRITE;
/*!40000 ALTER TABLE `qs_sqk_sys_config_def` DISABLE KEYS */;

INSERT INTO `qs_sqk_sys_config_def` (`id`, `sys_name`, `set_key`, `set_value`)
VALUES
	(2,'system_name','system_name','北京通州区梨园镇社区卡管理系统'),
	(3,'db_fix','db_fix','qs_sqk_'),
	(4,'system_token','system_token','qs_sqk');

/*!40000 ALTER TABLE `qs_sqk_sys_config_def` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_sys_db_backup
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_sys_db_backup`;

CREATE TABLE `qs_sqk_sys_db_backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `db_path` tinytext NOT NULL COMMENT '备份路径',
  `db_name` varchar(100) NOT NULL,
  `backup_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '备份时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_sys_db_backup` WRITE;
/*!40000 ALTER TABLE `qs_sqk_sys_db_backup` DISABLE KEYS */;

INSERT INTO `qs_sqk_sys_db_backup` (`id`, `db_path`, `db_name`, `backup_time`)
VALUES
	(14,'E:\\wamp\\www\\qskj_project_sqk_debug\\trunk\\dbsql','qs_sqk_db_debug-20180411-111141.sql','2018-04-11 11:11:42'),
	(15,'E:/wamp/www/qskj_project_sqk_debug/trunk/dbsql/','qs_sqk_db_debug-20180411-111326.sql','2018-04-11 11:13:26'),
	(16,'E:/wamp/www/qskj_project_sqk_debug/trunk/dbsql/','qs_sqk_db_debug-20180411-111534.sql','2018-04-11 11:15:35'),
	(17,'E:/wamp/www/qskj_project_sqk_debug/trunk/dbsql/','qs_sqk_db_debug-20180411-111850.sql','2018-04-11 11:18:51');

/*!40000 ALTER TABLE `qs_sqk_sys_db_backup` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_sys_priv_cat
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_sys_priv_cat` WRITE;
/*!40000 ALTER TABLE `qs_sqk_sys_priv_cat` DISABLE KEYS */;

INSERT INTO `qs_sqk_sys_priv_cat` (`id`, `sys_name`, `cat_name`, `parent_id_path`, `parent_id`, `add_time`, `is_enable`)
VALUES
	(2,'notice','通知公告','',0,'2017-03-17 11:36:09',1),
	(3,'sellerManage','商家管理','',0,'2017-03-21 09:53:24',1),
	(4,'wy','物业服务','',0,'2017-03-21 09:53:39',1),
	(5,'activity','社区活动服务','',0,'2017-03-21 09:53:55',1),
	(6,'system','系统设置','',0,'2017-03-21 09:54:09',1),
	(7,'noticeCat','通知分类','2.',2,'2017-03-21 09:54:39',1),
	(8,'noticeInfo','通知信息','2.',2,'2017-03-21 09:54:58',1),
	(9,'sellerCat','商家分类','3.',3,'2017-03-21 09:55:21',1),
	(10,'sellerInfo','商家信息','3.',3,'2017-03-27 15:13:44',1),
	(11,'itemsCat','服务项目分类','3.',3,'2017-03-27 15:31:35',1),
	(12,'itemsInfo','服务项目信息','3.',3,'2017-03-27 15:31:54',1),
	(13,'orderInfo','订单信息','3.',3,'2017-03-29 09:51:42',1),
	(14,'promInfo','促销信息','3.',3,'2017-03-29 09:51:59',1),
	(15,'dangerCat','险情/隐患分类','4.',4,'2017-03-29 11:52:17',1),
	(16,'dangerInfo','险情信息','4.',4,'2017-03-29 11:52:40',1),
	(17,'probInfo','问题/诉求信息','4.',4,'2017-03-29 11:53:07',1),
	(18,'activCat','活动分类','5.',5,'2017-03-29 11:58:09',1),
	(19,'activInfo','活动信息','5.',5,'2017-03-29 11:58:29',1),
	(20,'privCat','权限分类','6.',6,'2017-03-29 13:03:52',1),
	(21,'privInfo','权限信息','6.',6,'2017-03-29 13:04:12',1),
	(22,'userGroup','角色管理','6.',6,'2017-03-29 13:04:28',1),
	(23,'userInfo','用户信息','6.',6,'2017-03-29 13:04:45',1),
	(24,'dbBack','数据备份','6.',6,'2017-03-29 13:05:03',1),
	(25,'actionLog','系统日志','6.',6,'2017-03-29 13:05:21',1),
	(26,'menuSet','菜单设置','',0,'2017-03-29 16:10:19',1),
	(27,'menu','菜单列表','26.',26,'2017-03-29 16:12:02',1),
	(30,'helpServer','应急服务','',0,'2017-04-10 11:39:21',1),
	(31,'showHelpInfo','社区电话','30.',30,'2017-04-10 11:40:54',1),
	(32,'showMyHelpInfo','紧急联系人','30.',30,'2017-04-10 14:10:02',1),
	(33,'appuser','会员管理','',0,'2018-04-03 15:14:27',1),
	(34,'apperMenu','居民管理','33.',33,'2018-04-03 15:19:31',1),
	(35,'cleanTemPic','清理缓存','6.',6,'2018-04-03 17:11:58',1);

/*!40000 ALTER TABLE `qs_sqk_sys_priv_cat` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_sys_priv_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qs_sqk_sys_priv_info`;

CREATE TABLE `qs_sqk_sys_priv_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限分类id',
  `pri_name` varchar(50) NOT NULL COMMENT '权限名称',
  `pri_value` varchar(50) NOT NULL COMMENT '权限值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_sys_priv_info` WRITE;
/*!40000 ALTER TABLE `qs_sqk_sys_priv_info` DISABLE KEYS */;

INSERT INTO `qs_sqk_sys_priv_info` (`id`, `cat_id`, `pri_name`, `pri_value`)
VALUES
	(2,7,'新增分类','addNoticeCat'),
	(3,7,'编辑分类','editNoticeCat'),
	(4,8,'新增信息','addNoticeInfo'),
	(5,8,'编辑信息','editNoticeInfo'),
	(6,7,'删除分类','delNoticeCat'),
	(7,8,'删除信息','delNoticeInfo'),
	(8,8,'发布信息','pubNoticeInfo'),
	(9,7,'查看分类','showNoticeCat'),
	(10,8,'查看信息','showNoticeInfo'),
	(11,9,'新增分类','addSellerCat'),
	(12,9,'编辑分类','editSellerCat'),
	(13,9,'删除分类','delSellerCat'),
	(14,9,'查看分类','showSellerCat'),
	(15,10,'新增信息','addSellerInfo'),
	(16,10,'编辑信息','editSellerInfo'),
	(17,10,'删除信息','delSellerInfo'),
	(18,10,'查看信息','showSellerInfo'),
	(19,10,'审核信息','checkSellerInfo'),
	(20,10,'完善信息','perfectInfo'),
	(21,11,'新增分类','addItemsCat'),
	(22,11,'编辑分类','editItemsCat'),
	(23,11,'删除分类','delItemsCat'),
	(24,11,'查看分类','showItemsCat'),
	(25,12,'新增信息','addItemsInfo'),
	(26,12,'编辑信息','editItemsInfo'),
	(27,12,'删除信息','delItemsInfo'),
	(28,12,'查看信息','showItemsInfo'),
	(29,12,'审核信息','checkItemsInfo'),
	(30,13,'处理订单','dealOrderInfo'),
	(31,14,'新增信息','addPromInfo'),
	(32,14,'编辑信息','editPromInfo'),
	(33,14,'删除信息','delPromInfo'),
	(34,14,'查看信息','showPromInfo'),
	(35,15,'新增分类','addDangerCat'),
	(36,15,'编辑分类','editDangerCat'),
	(37,15,'删除分类','delDangerCat'),
	(38,15,'查看分类','showDangerCat'),
	(39,16,'处理险情','dealDangerInfo'),
	(40,16,'删除险情','delDangerInfo'),
	(41,16,'查看险情','showDangerInfo'),
	(42,17,'处理问题/诉求','dealProbInfo'),
	(43,17,'删除问题/诉求','delProbInfo'),
	(44,17,'查看问题/诉求','showProbInfo'),
	(45,18,'新增分类','addActivCat'),
	(46,18,'编辑分类','editActivCat'),
	(47,18,'删除分类','delActivCat'),
	(48,19,'新增信息','addActivInfo'),
	(49,19,'编辑信息','editActivInfo'),
	(50,19,'删除信息','delActivInfo'),
	(51,19,'查看信息','showActivInfo'),
	(52,20,'新增分类','addPrivCat'),
	(53,20,'编辑分类','editPrivCat'),
	(54,20,'删除分类','delPrivCat'),
	(55,20,'查看分类','showPrivCat'),
	(56,21,'新增信息','addPrivInfo'),
	(57,21,'编辑信息','editPrivInfo'),
	(58,21,'删除信息','delPrivInfo'),
	(59,21,'查看信息','showPrivInfo'),
	(60,22,'新增信息','addUserGroup'),
	(61,22,'编辑信息','editUserGroup'),
	(62,22,'删除信息','delUserGroup'),
	(63,22,'查看信息','showUserGroup'),
	(64,23,'新增信息','addUserInfo'),
	(65,23,'编辑信息','editUserInfo'),
	(66,23,'删除信息','delUserInfo'),
	(67,23,'查看信息','showUserInfo'),
	(68,19,'发布信息','pubActivInfo'),
	(69,13,'查看信息','showOrderInfo'),
	(70,27,'通知公告','noticeMenu'),
	(71,27,'生活圈服务','sellerMenu'),
	(72,27,'物业服务','wyMenu'),
	(73,27,'社区活动服务','activMenu'),
	(74,27,'系统设置','systemMenu'),
	(75,12,'商家查看服务项目','showSellerItems'),
	(76,13,'商家查看订单信息','showSellerOrder'),
	(77,14,'商家查看促销信息','showSellerProm'),
	(78,27,'应急服务','helpMenu'),
	(79,31,'新增联系人','addHelpInfo'),
	(80,31,'编辑联系人','editHelpInfo'),
	(81,31,'删除联系人','delHelpInfo'),
	(82,32,'编辑紧急','editMyHelpInfo'),
	(83,24,'查看备份','showDbBack'),
	(84,25,'查看日志','showLogInfo'),
	(85,35,'清理缓存图片','cleanTemPic'),
	(86,18,'查看分类','showActivCat');

/*!40000 ALTER TABLE `qs_sqk_sys_priv_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_sys_user_group
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_sys_user_group` WRITE;
/*!40000 ALTER TABLE `qs_sqk_sys_user_group` DISABLE KEYS */;

INSERT INTO `qs_sqk_sys_user_group` (`id`, `sys_name`, `cat_name`, `parent_id_path`, `parent_id`, `add_time`, `priviledges`, `is_enable`)
VALUES
	(8,'sqAdmin','社区','',0,'2018-04-03 14:57:49','addNoticeInfo,editNoticeInfo,delNoticeInfo,pubNoticeInfo,showNoticeInfo,addSellerCat,editSellerCat,delSellerCat,showSellerCat,addSellerInfo,editSellerInfo,delSellerInfo,showSellerInfo,checkSellerInfo,perfectInfo,addActivInfo,editActivInfo,delActivInfo,showActivInfo,pubActivInfo,addUserInfo,editUserInfo,delUserInfo,showUserInfo,noticeMenu,sellerMenu,activMenu,',1),
	(5,'sysAdmin','系统','',0,'2017-03-30 13:37:28','addNoticeCat,editNoticeCat,delNoticeCat,showNoticeCat,addNoticeInfo,editNoticeInfo,delNoticeInfo,pubNoticeInfo,showNoticeInfo,addSellerCat,editSellerCat,delSellerCat,showSellerCat,addSellerInfo,editSellerInfo,delSellerInfo,showSellerInfo,checkSellerInfo,perfectInfo,addPromInfo,editPromInfo,delPromInfo,showPromInfo,showSellerProm,addDangerCat,editDangerCat,delDangerCat,showDangerCat,dealDangerInfo,delDangerInfo,showDangerInfo,dealProbInfo,delProbInfo,showProbInfo,addActivCat,editActivCat,delActivCat,showActivCat,addActivInfo,editActivInfo,delActivInfo,showActivInfo,pubActivInfo,addPrivCat,editPrivCat,delPrivCat,showPrivCat,addPrivInfo,editPrivInfo,delPrivInfo,showPrivInfo,addUserGroup,editUserGroup,delUserGroup,showUserGroup,addUserInfo,editUserInfo,delUserInfo,showUserInfo,showDbBack,showLogInfo,cleanTemPic,noticeMenu,sellerMenu,wyMenu,activMenu,systemMenu,helpMenu,addHelpInfo,editHelpInfo,delHelpInfo,editMyHelpInfo,',1);

/*!40000 ALTER TABLE `qs_sqk_sys_user_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_sys_user_info
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_sys_user_info` WRITE;
/*!40000 ALTER TABLE `qs_sqk_sys_user_info` DISABLE KEYS */;

INSERT INTO `qs_sqk_sys_user_info` (`id`, `cat_id`, `address_id`, `usr`, `pwd`, `realname`, `gender`, `email`, `tel`, `phone`, `add_time`, `last_ip`, `last_login_time`, `priviledges`, `is_enable`, `keycode`)
VALUES
	(1,5,0,'super','592d510020d3eacdc3d5c89e2e148f7467de3e82','管理员',0,'super@qq.com','15823695896','010-60551593','2017-03-30 09:06:21','127.0.0.1','2018-04-16 10:03:27','',1,NULL),
	(73,8,1,'sqgl-1','592d510020d3eacdc3d5c89e2e148f7467de3e82','翠景北里-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39','127.0.0.1','2018-04-15 17:05:56','systemMenu,',1,NULL),
	(74,8,2,'sqgl-2','592d510020d3eacdc3d5c89e2e148f7467de3e82','翠屏北里-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39','127.0.0.1','2018-04-04 15:18:15','',1,NULL),
	(75,8,3,'sqgl-3','592d510020d3eacdc3d5c89e2e148f7467de3e82','翠屏南里-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39','127.0.0.1','2018-04-12 15:59:56','',1,NULL),
	(76,8,4,'sqgl-4','592d510020d3eacdc3d5c89e2e148f7467de3e82','大方居-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(77,8,5,'sqgl-5','592d510020d3eacdc3d5c89e2e148f7467de3e82','格瑞雅居-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(78,8,6,'sqgl-6','592d510020d3eacdc3d5c89e2e148f7467de3e82','葛布店东里-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(79,8,7,'sqgl-7','592d510020d3eacdc3d5c89e2e148f7467de3e82','金侨时代-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(80,8,8,'sqgl-8','592d510020d3eacdc3d5c89e2e148f7467de3e82','京洲园-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39','127.0.0.1','2018-04-15 17:35:16','',1,NULL),
	(81,8,9,'sqgl-9','592d510020d3eacdc3d5c89e2e148f7467de3e82','靓景明居-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(82,8,10,'sqgl-10','592d510020d3eacdc3d5c89e2e148f7467de3e82','梨园东里-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(83,8,11,'sqgl-11','592d510020d3eacdc3d5c89e2e148f7467de3e82','龙鼎园-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(84,8,12,'sqgl-12','592d510020d3eacdc3d5c89e2e148f7467de3e82','曼城家园-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(85,8,13,'sqgl-13','592d510020d3eacdc3d5c89e2e148f7467de3e82','群芳园-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(86,8,14,'sqgl-14','592d510020d3eacdc3d5c89e2e148f7467de3e82','万盛北里-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(87,8,15,'sqgl-15','592d510020d3eacdc3d5c89e2e148f7467de3e82','欣达园-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(88,8,16,'sqgl-16','592d510020d3eacdc3d5c89e2e148f7467de3e82','新城乐居-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(89,8,17,'sqgl-17','592d510020d3eacdc3d5c89e2e148f7467de3e82','新华联南区-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(90,8,18,'sqgl-18','592d510020d3eacdc3d5c89e2e148f7467de3e82','颐瑞东里-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(91,8,19,'sqgl-19','592d510020d3eacdc3d5c89e2e148f7467de3e82','颐瑞西里-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(92,8,20,'sqgl-20','592d510020d3eacdc3d5c89e2e148f7467de3e82','云景北里-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(93,8,21,'sqgl-21','592d510020d3eacdc3d5c89e2e148f7467de3e82','云景东里-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39',NULL,NULL,'',1,NULL),
	(94,8,22,'sqgl-22','592d510020d3eacdc3d5c89e2e148f7467de3e82','云景里-管理员',0,'','13521447599','010-12345678','2018-04-03 15:07:39','127.0.0.1','2018-04-04 15:42:06','',1,NULL);

/*!40000 ALTER TABLE `qs_sqk_sys_user_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qs_sqk_sys_userapp_info
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `qs_sqk_sys_userapp_info` WRITE;
/*!40000 ALTER TABLE `qs_sqk_sys_userapp_info` DISABLE KEYS */;

INSERT INTO `qs_sqk_sys_userapp_info` (`id`, `address_id`, `usr`, `realname`, `gender`, `birthday`, `tel`, `add_time`, `last_ip`, `last_login_time`, `is_enable`, `keycode`, `rns_type`, `address`, `integral_num`, `exp_num`, `joined_act_num`, `liked_act_num`, `shared_act_num`, `card_num`, `liked_card_num`, `used_card_num`, `iccard_num`, `iccard_ufnum`, `wx_num`, `qrcode_path`)
VALUES
	(105,1,'13521447597','123',0,'2018-04-11','13521447597','2018-04-10 11:43:08',NULL,NULL,1,NULL,0,'123123',0,0,0,0,0,0,0,0,'00000000','FFFFFFFF','00000000','Public/Temfile/qrcode/20180410114308.png'),
	(106,1,'13521447599','张晓炜',0,'2018-04-18','13521447599','2018-04-10 11:47:15',NULL,NULL,1,NULL,0,'234234234234',0,0,0,0,0,0,0,0,'00000000','FFFFFFFF','00000000','Public/Temfile/qrcode/20180410114715.png'),
	(107,1,'13521445632','张张张',0,'2018-04-13','13521445632','2018-04-10 11:50:42',NULL,NULL,1,NULL,0,'士大夫撒旦法',0,0,0,0,0,0,0,0,'00000000','FFFFFFFF','00000000','Public/Temfile/qrcode/20180410115042.png'),
	(108,1,'13521447598','撒旦发撒旦',0,'2018-04-11','13521447598','2018-04-10 11:53:40',NULL,NULL,1,NULL,0,'32423423423',0,0,0,0,0,0,0,0,'00000000','FFFFFFFF','00000000','Public/Temfile/qrcode/20180410115340.png'),
	(109,1,'13569856324','123',0,'2018-04-04','13569856324','2018-04-10 11:55:58',NULL,NULL,1,NULL,0,'所发生的发生',0,0,0,0,0,0,0,0,'00000000','FFFFFFFF','00000000','Public/Temfile/qrcode/20180410115558.png'),
	(113,1,'','渣渣辉',0,'2018-04-13','13521447896','2018-04-13 13:26:07',NULL,NULL,1,NULL,0,'',0,0,0,0,0,0,0,0,'00000000','FFFFFFFF','00000000','Public/Temfile/qrcode/20180413132607.png');

/*!40000 ALTER TABLE `qs_sqk_sys_userapp_info` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;