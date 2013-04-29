/*
SQLyog Community v10.0 
MySQL - 5.1.41 : Database - morra_cms
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `cms_accounts` */

DROP TABLE IF EXISTS `cms_accounts`;

CREATE TABLE `cms_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(500) DEFAULT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `last_login` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `cms_accounts` */

insert  into `cms_accounts`(`id`,`user_id`,`username`,`email`,`password`,`last_login`,`created`,`modified`) values (2,2,'morra','hello@morrastudio.com','169e781bd52860b584879cbe117085da596238f3','2012-08-15 15:28:44','2012-06-13 00:00:00','2012-06-20 11:37:55');

/*Table structure for table `cms_entries` */

DROP TABLE IF EXISTS `cms_entries`;

CREATE TABLE `cms_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_type` varchar(500) NOT NULL,
  `title` varchar(500) NOT NULL,
  `slug` varchar(500) NOT NULL,
  `description` text,
  `main_image` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `count` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `lang_code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `cms_entries` */

insert  into `cms_entries`(`id`,`entry_type`,`title`,`slug`,`description`,`main_image`,`parent_id`,`status`,`count`,`created`,`created_by`,`modified`,`modified_by`,`sort_order`,`lang_code`) values (1,'pages','Home','home','<p>\r\n	Ini Home</p>\r\n',0,0,1,0,'2012-08-29 15:04:44',2,'2012-08-29 15:04:44',2,1,'en-1'),(2,'user-guides','Overview','overview','<h2 class=\"title-guide\">\r\n	Overview</h2>\r\n<p>\r\n	<img src=\"/img/user_guide/overview.png\" style=\"margin: 0 20px 20px 0; float: left;\" /> Morra Content Management System is built with flexibilities to adapt to every project. We have default CMS pages and interface that can be used straight out of the box. In addition, we can modify some interfaces to help site administrators to easily manage their site.</p>\r\n<p>\r\n	We must admit that not everyone has the experience with online content management system. Therefore, we will ensure the learning process to be as fast, and as simple as possible.</p>\r\n',0,0,1,0,'2012-07-20 16:10:17',2,'2012-07-24 10:46:52',2,2,'en-2'),(3,'user-guides','Users & Accounts','users-accounts','<h2 class=\"title-guide\">\r\n	Users &amp; Accounts</h2>\r\n<p>\r\n	<img src=\"/img/user_guide/user-n-account.png\" style=\"margin: 0 20px 20px 0; float: left;\" />In Morra CMS, we separate users and accounts, in order to maintain flexibilities to accomodate guest accounts.</p>\r\n<p>\r\n	A common example would be a newsletter feature that you may have upfront. It will collect the user information and store it as participants or subscribers. Some of them may not even complete the form. Additionally, they don&#39;t need complex registration steps.</p>\r\n<p>\r\n	Depending on the roles, only users with accounts are able to log into the site. Additionally, only accounts with admin roles are allowed in the Admin Panel area.</p>\r\n<h3>\r\n	Other Accounts</h3>\r\n<p>\r\n	You may see System and Morra Support in Accounts. The system account will be used for possible automated tasks that you may have, usually involving server settings.</p>\r\n<p>\r\n	While Morra Support will be used by our team to access your site, while you have problems with the site. If you demand privacy, you can always disable the the Morra Support account. You can reactivate the account whenever you need help again in the future.</p>\r\n',0,0,1,0,'2012-07-20 18:27:24',2,'2012-07-24 10:45:44',2,3,'en-3'),(4,'user-guides','General Interface','general-interface','<h2 class=\"title-guide\">\r\n	General Interface</h2>\r\n<p>\r\n	<img src=\"/img/user_guide/general-interfaces.png\" style=\"margin: 0 20px 20px 0; float: left;\" /> In Morra CMS, main navigation is always located on the left-hand side. It contains all the necessary site settings, user and account management, page management, and databases used in dynamic contents.</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Depending on the scope and scale of the site, you may have more than one databases listed.</p>\r\n<p>\r\n	&nbsp;</p>\r\n',0,0,1,0,'2012-07-20 16:51:19',2,'2012-07-24 10:46:40',2,4,'en-4'),(5,'user-guides','Settings','settings','<h2 class=\"title-guide\">\r\n	Settings</h2>\r\n<p>\r\n	The Settings menu contains all the necessary site settings and preferences available.</p>\r\n<h3>\r\n	Basic Profile</h3>\r\n<p>\r\n	Here you can edit your site title, tagline, descriptions. These information will be the main identity of your site, and will be used in all pages and meta description.</p>\r\n<h3>\r\n	Domain Name and Path URL</h3>\r\n<p>\r\n	The domain name and path URL will be used as references related to URL structure, and the locations of the CSS and graphic assets. Just to be safe, if you don&#39;t know anything about server settings, it is best not to change anything on these two fields.</p>\r\n<h3>\r\n	Time and Date Format</h3>\r\n<p>\r\n	You may choose the time and date format, it will be used throughout the site.</p>\r\n<h3>\r\n	Google Analytics Code</h3>\r\n<p>\r\n	We love Google Analytics to measure our site performance. Just drop is the Google Analytics code, and check your stats. Please note that sometimes there may have delay on the stats report.</p>\r\n<h3>\r\n	Page Inserts</h3>\r\n<p>\r\n	In some cases, you may need to insert more codes for whatever the purpose might be. Depends on where you wan to put it, we allow three spots to insert the code. For security reason, these are the only places you can add additional codes or scripts.</p>\r\n<h3>\r\n	Media Settings</h3>\r\n<p>\r\n	On every image uploaded, we can determine the sizes to be converted on upload. You don&#39;t have to</p>\r\n',0,0,1,0,'2012-07-20 18:26:38',2,'2012-07-24 10:46:28',2,5,'en-5'),(6,'user-guides','Media Library','media-library','<h2 class=\"title-guide\">\r\n	Media Library</h2>\r\n<p>\r\n	<img src=\"/img/user_guide/media-library.png\" style=\"margin: 0 20px 20px 0; float: left;\" />All content images being used on the site will be gathered in a media library. The goal is to minimize duplicate files, and ability to reuse the same image for other content.</p>\r\n<p>\r\n	The system may prevent you from deleting associated images. However, it may not be able to detect images being inserted into contents directly. For example, in an article body.</p>\r\n',0,0,1,0,'2012-07-20 18:27:45',2,'2012-07-24 10:44:03',2,6,'en-6'),(7,'user-guides','Managing Pages','managing-pages','<h2 class=\"title-guide\">\r\n	Managing Pages</h2>\r\n<p>\r\n	<img src=\"/img/user_guide/managing-pages.png\" style=\"margin: 0 20px 20px 0; float: left;\" />As a basic feature, you are able to manage pages and its content. However, in some cases, the layout may prevent you to display additional pages that you created. It may be due to limited space on the navigation bar or other reasons.</p>\r\n<p>\r\n	Some pages and its content may not even appear on the navigation, or accesible by URL directly. Also, not every fields will appear on the front page and usable. The page may appear as container for possible dynamic contents from the database.</p>\r\n',0,0,1,0,'2012-07-20 18:28:00',2,'2012-07-24 10:43:48',2,7,'en-7'),(8,'user-guides','Sorting Feature','sorting-feature','<h2 class=\"title-guide\">\r\n	Sorting Feature</h2>\r\n<p>\r\n	<img src=\"/img/user_guide/sorting-feature.png\" style=\"margin: 0 20px 20px 0; float: left;\" />By default there are 3 sorting options feature:</p>\r\n<p>\r\n	&nbsp;</p>\r\n<h3>\r\n	Oldest First</h3>\r\n<p>\r\n	This would be the ideal sorting for chronological entries. May be a storytelling gallery?</p>\r\n<h3>\r\n	Latest First</h3>\r\n<p>\r\n	For blogs and often updated content, visitors often prefer to see the latest items upfront.</p>\r\n<h3>\r\n	By Order</h3>\r\n<p>\r\n	Just in case you want something different, we also enable admin to manage orders of entries, as they wish. Just drag and drop the item as you desired, and the front-end will adjust by itself.</p>\r\n',0,0,1,0,'2012-07-20 18:28:15',2,'2012-07-24 10:43:25',2,8,'en-8'),(9,'user-guides','Visibility Check','visibility-check','<h2 class=\"title-guide\">\r\n	Visibility Check</h2>\r\n<p>\r\n	<img src=\"/img/user_guide/visibility-check.png\" style=\"margin: 0 20px 20px 0; float: left;\" />All pages and entries will have visibilty settings, in order to control their ... well, visibility. Disabled items will not exist, nor accessible by URL.</p>\r\n',0,0,1,0,'2012-07-20 18:28:46',2,'2012-07-24 10:43:04',2,9,'en-9'),(10,'user-guides','Content Editing','content-editing','<h2 class=\"title-guide\">\r\n	Content Editing</h2>\r\n<p>\r\n	<img src=\"/img/user_guide/content-editing.png\" style=\"margin: 0 20px 20px 0; float: left;\" />Any content editing that uses What-You-See-Is-What-You-Get (WYSIWYG) editors can be formatted in certain way. Here&#39;s a few tips that you may not know.</p>\r\n<h3>\r\n	SHIFT+ENTER</h3>\r\n<p>\r\n	Hitting &#39;Enter&#39; button in WYSISWYG editor creates a new paragraph by default. Just in case you want to jump to the next line without creating a new paragraph, you will have to hit SHIFT+ENTER.</p>\r\n<h3>\r\n	Inserting Images</h3>\r\n<p>\r\n	Using the editor, you can also add images already existing images from the Media Library, which means you can use your product photos or portfolios to create articles. New images will be added into the library as well.</p>\r\n',0,0,1,0,'2012-07-20 18:29:09',2,'2012-07-24 12:15:06',2,10,'en-10'),(11,'user-guides','Multi-Language Support','multi-language-support','<h2 class=\"title-guide\">\r\n	Multi-Language Support</h2>\r\n<p>\r\n	If you have multi-language support enabled, then you can manage the language options in Settings.</p>\r\n<p>\r\n	For every content that can be translated will have the selections on the right-hand side, while in editing mode.</p>\r\n<p>\r\n	Once enabled, automatically the URL will include the language code right after the domain, such as http://www.domain.com/en/page-name</p>\r\n',0,0,1,0,'2012-07-20 18:29:38',2,'2012-07-24 12:14:46',2,11,'en-11');

/*Table structure for table `cms_entry_metas` */

DROP TABLE IF EXISTS `cms_entry_metas`;

CREATE TABLE `cms_entry_metas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_id` int(11) NOT NULL,
  `key` varchar(500) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `cms_entry_metas` */

insert  into `cms_entry_metas`(`id`,`entry_id`,`key`,`value`) values (1,1,'SEO_Title',''),(2,1,'SEO_Keywords',''),(3,1,'SEO_Description','');

/*Table structure for table `cms_roles` */

DROP TABLE IF EXISTS `cms_roles`;

CREATE TABLE `cms_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `description` text,
  `count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `cms_roles` */

insert  into `cms_roles`(`id`,`name`,`description`,`count`) values (1,'System','Anything automated by the system',NULL),(2,'Morra Support','Actually human editing the record',NULL),(3,'Admins','Administrator from the clients',NULL),(4,'Regular Users','Anyone with no access to admin panel',NULL),(5,'Participants','Anyone added without proper credentials and no access priviledges',NULL);

/*Table structure for table `cms_settings` */

DROP TABLE IF EXISTS `cms_settings`;

CREATE TABLE `cms_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `key` varchar(500) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `cms_settings` */

insert  into `cms_settings`(`id`,`name`,`key`,`value`) values (1,'sites','title','Morra'),(2,'sites','tagline','The best you can trust.'),(3,'sites','description','Deskripsi Morra Studio Company in Indonesia Country'),(4,'sites','domain_name','http://morracms.com'),(5,'sites','path_url','/'),(6,'sites','date_format','F d, Y'),(7,'sites','time_format','h:i A'),(8,'sites','logo','images/logo.png'),(9,'sites','favicon','images/favicon.ico'),(10,'sites','header',''),(11,'sites','top_insert',''),(12,'sites','bottom_insert',''),(13,'sites','modified','2012-8-15 19:11:0'),(14,'sites','modified_by','2'),(15,'sites','google_analytics_code','UA-33194544-1'),(16,'sites','display_width','1000'),(17,'sites','display_height','1000'),(18,'sites','display_crop','1'),(19,'sites','thumb_width','120'),(20,'sites','thumb_height','120'),(21,'sites','thumb_crop','1'),(22,'sites','language','en_english'),(23,'sites','facebook_app_id','458489887517120'),(24,'sites','twitter_consumer_key','e7tsBZhOviPIJxBCf8in2A'),(25,'sites','twitter_consumer_secret','Pecfu8vK38UhDjq2QHZ8gYqTEbKi8robmQGOXbOB38'),(26,'sites','keywords','morra,hellomorra,morrastudio');

/*Table structure for table `cms_type_metas` */

DROP TABLE IF EXISTS `cms_type_metas`;

CREATE TABLE `cms_type_metas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `key` varchar(500) NOT NULL,
  `value` text,
  `input_type` varchar(500) DEFAULT NULL,
  `validation` text,
  `instruction` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `cms_type_metas` */

insert  into `cms_type_metas`(`id`,`type_id`,`key`,`value`,`input_type`,`validation`,`instruction`) values (1,1,'form-site_tour','yes','checkbox','','Include as Site Tour.');

/*Table structure for table `cms_types` */

DROP TABLE IF EXISTS `cms_types`;

CREATE TABLE `cms_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `slug` varchar(500) NOT NULL,
  `description` text,
  `parent_id` int(11) NOT NULL DEFAULT '-1',
  `count` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `cms_types` */

insert  into `cms_types`(`id`,`name`,`slug`,`description`,`parent_id`,`count`,`created`,`created_by`,`modified`,`modified_by`) values (1,'User Guides','user-guides','This is how to guide our users to use our CMS.',-1,0,'2012-07-17 12:39:37',2,'2012-07-19 10:56:00',2),(2,'Media Library','media','This is media library',-1,0,'2012-08-29 11:26:18',2,'2012-08-29 11:26:18',2);

/*Table structure for table `cms_user_metas` */

DROP TABLE IF EXISTS `cms_user_metas`;

CREATE TABLE `cms_user_metas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(500) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `cms_user_metas` */

insert  into `cms_user_metas`(`id`,`user_id`,`key`,`value`) values (1,2,'email','hello@morrastudio.com');

/*Table structure for table `cms_users` */

DROP TABLE IF EXISTS `cms_users`;

CREATE TABLE `cms_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(500) NOT NULL,
  `lastname` varchar(500) DEFAULT NULL,
  `role_id` tinyint(4) NOT NULL DEFAULT '4',
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `cms_users` */

insert  into `cms_users`(`id`,`firstname`,`lastname`,`role_id`,`created`,`created_by`,`modified`,`modified_by`,`status`) values (1,'system',NULL,1,'2012-06-12 17:42:10',2,'2012-06-12 17:42:16',2,1),(2,'Morra','Support',2,'2012-06-12 18:15:17',2,'2012-07-12 17:26:33',2,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
