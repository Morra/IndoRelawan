-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2013 at 12:12 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `indorelawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `cms_accounts`
--

CREATE TABLE IF NOT EXISTS `cms_accounts` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cms_accounts`
--

INSERT INTO `cms_accounts` (`id`, `user_id`, `username`, `email`, `password`, `last_login`, `created`, `modified`) VALUES
(2, 2, 'morra', 'hello@morrastudio.com', '169e781bd52860b584879cbe117085da596238f3', '2013-02-06 05:04:21', '2012-06-13 00:00:00', '2012-06-20 11:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `cms_entries`
--

CREATE TABLE IF NOT EXISTS `cms_entries` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `cms_entries`
--

INSERT INTO `cms_entries` (`id`, `entry_type`, `title`, `slug`, `description`, `main_image`, `parent_id`, `status`, `count`, `created`, `created_by`, `modified`, `modified_by`, `sort_order`, `lang_code`) VALUES
(1, 'pages', 'Home', 'home', '<div class="idrw-headline-title">\r\n	<h1>\r\n		Kami Mempertemukan Organisasi Sosial dan Sukarelawan</h1>\r\n</div>\r\n<div class="idrw-headline-section grid_8">\r\n	<p>\r\n		Indorelawan memiliki visi untuk menggerakkan 100.000 sukarelawan di Indonesia dalam beragam kegiatan sosial. Kami percaya bahwa masih banyak orang di Indonesia yang ingin membantu orang lain yang memerlukannya. Kami yakin anda sendiri ingin membantu jika ada kesempatan yang tepat.</p>\r\n</div>\r\n<div class="idrw-headline-section grid_8">\r\n	<p>\r\n		Indorelawan secara aktif bekerja dengan organisasi-organisasi yang sudah ada untuk menciptakan aktivitas yang bermakna untuk sukarelawan dan mengkomunikasikannya melalui situs ini. Indorelawan juga secara aktif mengajak masyarakat dari beragam kalangan untuk berpartisipasi sebagai sukarelawan.</p>\r\n</div>\r\n', 0, 0, 1, 0, '2012-08-29 15:04:44', 2, '2013-02-06 11:52:00', 2, 1, 'en-1'),
(2, 'user-guides', 'Overview', 'overview', '<h2 class="title-guide">\r\n	Overview</h2>\r\n<p>\r\n	<img src="/img/user_guide/overview.png" style="margin: 0 20px 20px 0; float: left;" /> Morra Content Management System is built with flexibilities to adapt to every project. We have default CMS pages and interface that can be used straight out of the box. In addition, we can modify some interfaces to help site administrators to easily manage their site.</p>\r\n<p>\r\n	We must admit that not everyone has the experience with online content management system. Therefore, we will ensure the learning process to be as fast, and as simple as possible.</p>\r\n', 0, 0, 1, 0, '2012-07-20 16:10:17', 2, '2012-07-24 10:46:52', 2, 2, 'en-2'),
(3, 'user-guides', 'Users & Accounts', 'users-accounts', '<h2 class="title-guide">\r\n	Users &amp; Accounts</h2>\r\n<p>\r\n	<img src="/img/user_guide/user-n-account.png" style="margin: 0 20px 20px 0; float: left;" />In Morra CMS, we separate users and accounts, in order to maintain flexibilities to accomodate guest accounts.</p>\r\n<p>\r\n	A common example would be a newsletter feature that you may have upfront. It will collect the user information and store it as participants or subscribers. Some of them may not even complete the form. Additionally, they don&#39;t need complex registration steps.</p>\r\n<p>\r\n	Depending on the roles, only users with accounts are able to log into the site. Additionally, only accounts with admin roles are allowed in the Admin Panel area.</p>\r\n<h3>\r\n	Other Accounts</h3>\r\n<p>\r\n	You may see System and Morra Support in Accounts. The system account will be used for possible automated tasks that you may have, usually involving server settings.</p>\r\n<p>\r\n	While Morra Support will be used by our team to access your site, while you have problems with the site. If you demand privacy, you can always disable the the Morra Support account. You can reactivate the account whenever you need help again in the future.</p>\r\n', 0, 0, 1, 0, '2012-07-20 18:27:24', 2, '2012-07-24 10:45:44', 2, 3, 'en-3'),
(4, 'user-guides', 'General Interface', 'general-interface', '<h2 class="title-guide">\r\n	General Interface</h2>\r\n<p>\r\n	<img src="/img/user_guide/general-interfaces.png" style="margin: 0 20px 20px 0; float: left;" /> In Morra CMS, main navigation is always located on the left-hand side. It contains all the necessary site settings, user and account management, page management, and databases used in dynamic contents.</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	Depending on the scope and scale of the site, you may have more than one databases listed.</p>\r\n<p>\r\n	&nbsp;</p>\r\n', 0, 0, 1, 0, '2012-07-20 16:51:19', 2, '2012-07-24 10:46:40', 2, 4, 'en-4'),
(5, 'user-guides', 'Settings', 'settings', '<h2 class="title-guide">\r\n	Settings</h2>\r\n<p>\r\n	The Settings menu contains all the necessary site settings and preferences available.</p>\r\n<h3>\r\n	Basic Profile</h3>\r\n<p>\r\n	Here you can edit your site title, tagline, descriptions. These information will be the main identity of your site, and will be used in all pages and meta description.</p>\r\n<h3>\r\n	Domain Name and Path URL</h3>\r\n<p>\r\n	The domain name and path URL will be used as references related to URL structure, and the locations of the CSS and graphic assets. Just to be safe, if you don&#39;t know anything about server settings, it is best not to change anything on these two fields.</p>\r\n<h3>\r\n	Time and Date Format</h3>\r\n<p>\r\n	You may choose the time and date format, it will be used throughout the site.</p>\r\n<h3>\r\n	Google Analytics Code</h3>\r\n<p>\r\n	We love Google Analytics to measure our site performance. Just drop is the Google Analytics code, and check your stats. Please note that sometimes there may have delay on the stats report.</p>\r\n<h3>\r\n	Page Inserts</h3>\r\n<p>\r\n	In some cases, you may need to insert more codes for whatever the purpose might be. Depends on where you wan to put it, we allow three spots to insert the code. For security reason, these are the only places you can add additional codes or scripts.</p>\r\n<h3>\r\n	Media Settings</h3>\r\n<p>\r\n	On every image uploaded, we can determine the sizes to be converted on upload. You don&#39;t have to</p>\r\n', 0, 0, 1, 0, '2012-07-20 18:26:38', 2, '2012-07-24 10:46:28', 2, 5, 'en-5'),
(6, 'user-guides', 'Media Library', 'media-library', '<h2 class="title-guide">\r\n	Media Library</h2>\r\n<p>\r\n	<img src="/img/user_guide/media-library.png" style="margin: 0 20px 20px 0; float: left;" />All content images being used on the site will be gathered in a media library. The goal is to minimize duplicate files, and ability to reuse the same image for other content.</p>\r\n<p>\r\n	The system may prevent you from deleting associated images. However, it may not be able to detect images being inserted into contents directly. For example, in an article body.</p>\r\n', 0, 0, 1, 0, '2012-07-20 18:27:45', 2, '2012-07-24 10:44:03', 2, 6, 'en-6'),
(7, 'user-guides', 'Managing Pages', 'managing-pages', '<h2 class="title-guide">\r\n	Managing Pages</h2>\r\n<p>\r\n	<img src="/img/user_guide/managing-pages.png" style="margin: 0 20px 20px 0; float: left;" />As a basic feature, you are able to manage pages and its content. However, in some cases, the layout may prevent you to display additional pages that you created. It may be due to limited space on the navigation bar or other reasons.</p>\r\n<p>\r\n	Some pages and its content may not even appear on the navigation, or accesible by URL directly. Also, not every fields will appear on the front page and usable. The page may appear as container for possible dynamic contents from the database.</p>\r\n', 0, 0, 1, 0, '2012-07-20 18:28:00', 2, '2012-07-24 10:43:48', 2, 7, 'en-7'),
(8, 'user-guides', 'Sorting Feature', 'sorting-feature', '<h2 class="title-guide">\r\n	Sorting Feature</h2>\r\n<p>\r\n	<img src="/img/user_guide/sorting-feature.png" style="margin: 0 20px 20px 0; float: left;" />By default there are 3 sorting options feature:</p>\r\n<p>\r\n	&nbsp;</p>\r\n<h3>\r\n	Oldest First</h3>\r\n<p>\r\n	This would be the ideal sorting for chronological entries. May be a storytelling gallery?</p>\r\n<h3>\r\n	Latest First</h3>\r\n<p>\r\n	For blogs and often updated content, visitors often prefer to see the latest items upfront.</p>\r\n<h3>\r\n	By Order</h3>\r\n<p>\r\n	Just in case you want something different, we also enable admin to manage orders of entries, as they wish. Just drag and drop the item as you desired, and the front-end will adjust by itself.</p>\r\n', 0, 0, 1, 0, '2012-07-20 18:28:15', 2, '2012-07-24 10:43:25', 2, 8, 'en-8'),
(9, 'user-guides', 'Visibility Check', 'visibility-check', '<h2 class="title-guide">\r\n	Visibility Check</h2>\r\n<p>\r\n	<img src="/img/user_guide/visibility-check.png" style="margin: 0 20px 20px 0; float: left;" />All pages and entries will have visibilty settings, in order to control their ... well, visibility. Disabled items will not exist, nor accessible by URL.</p>\r\n', 0, 0, 1, 0, '2012-07-20 18:28:46', 2, '2012-07-24 10:43:04', 2, 9, 'en-9'),
(10, 'user-guides', 'Content Editing', 'content-editing', '<h2 class="title-guide">\r\n	Content Editing</h2>\r\n<p>\r\n	<img src="/img/user_guide/content-editing.png" style="margin: 0 20px 20px 0; float: left;" />Any content editing that uses What-You-See-Is-What-You-Get (WYSIWYG) editors can be formatted in certain way. Here&#39;s a few tips that you may not know.</p>\r\n<h3>\r\n	SHIFT+ENTER</h3>\r\n<p>\r\n	Hitting &#39;Enter&#39; button in WYSISWYG editor creates a new paragraph by default. Just in case you want to jump to the next line without creating a new paragraph, you will have to hit SHIFT+ENTER.</p>\r\n<h3>\r\n	Inserting Images</h3>\r\n<p>\r\n	Using the editor, you can also add images already existing images from the Media Library, which means you can use your product photos or portfolios to create articles. New images will be added into the library as well.</p>\r\n', 0, 0, 1, 0, '2012-07-20 18:29:09', 2, '2012-07-24 12:15:06', 2, 10, 'en-10'),
(11, 'user-guides', 'Multi-Language Support', 'multi-language-support', '<h2 class="title-guide">\r\n	Multi-Language Support</h2>\r\n<p>\r\n	If you have multi-language support enabled, then you can manage the language options in Settings.</p>\r\n<p>\r\n	For every content that can be translated will have the selections on the right-hand side, while in editing mode.</p>\r\n<p>\r\n	Once enabled, automatically the URL will include the language code right after the domain, such as http://www.domain.com/en/page-name</p>\r\n', 0, 0, 1, 0, '2012-07-20 18:29:38', 2, '2012-07-24 12:14:46', 2, 11, 'en-11'),
(12, 'pages', 'Cari Aktifitas', 'cari-aktifitas', '', 0, 0, 1, 0, '2013-02-05 04:05:13', 2, '2013-02-05 04:05:13', 2, 12, 'en-12'),
(13, 'pages', 'Cari Sukarelawan', 'cari-sukarelawan', '', 0, 0, 1, 0, '2013-02-05 04:05:28', 2, '2013-02-05 04:05:28', 2, 13, 'en-13'),
(14, 'pages', 'Tentang Kami', 'tentang-kami', '', 0, 0, 1, 0, '2013-02-05 04:05:39', 2, '2013-02-05 04:05:39', 2, 14, 'en-14'),
(15, 'pages', 'Team', 'team', '', 0, 0, 1, 0, '2013-02-05 04:05:57', 2, '2013-02-05 04:05:57', 2, 15, 'en-15'),
(16, 'pages', 'Sponsor', 'sponsor', '', 0, 0, 1, 0, '2013-02-05 04:06:11', 2, '2013-02-05 04:06:11', 2, 16, 'en-16'),
(17, 'pages', 'Kontak Kami', 'kontak-kami', '', 0, 0, 1, 0, '2013-02-05 04:06:20', 2, '2013-02-05 04:06:20', 2, 17, 'en-17'),
(18, 'pages', 'Press', 'press', '', 0, 0, 1, 0, '2013-02-05 04:06:31', 2, '2013-02-05 04:06:31', 2, 18, 'en-18'),
(19, 'pages', 'Terms', 'terms', '', 0, 0, 1, 0, '2013-02-05 04:06:43', 2, '2013-02-05 04:06:43', 2, 19, 'en-19'),
(20, 'organizations', 'Nymphea Bali', 'nymphea-bali', '<div class="idrw-inline">\r\n	<p>\r\n	<h3>\r\n		Fokus :</h3>\r\n	Ekonomi, Lingkungan\r\n	</p>\r\n</div>\r\n<div class="idrw-titcon">\r\n	<h3>\r\n		Visi :</h3>\r\n	<p>\r\n		Meningkatkan kodisi sosial ekonomi dari komunitas di daerah pedesaan dan terpencil. IBEKA didirikan untuk membantu masyarakat dalam bidang energy dan ekonomi kerakyatan.</p>\r\n</div>\r\n<div class="idrw-titcon">\r\n	<h3>\r\n		Misi :</h3>\r\n	<p>\r\n		Implementasi dan promosi teknologi tepat guna, terutama teknologi pembangkit listrik mikro hidro, termasuk pengembangan program yang membuat masyarakat menjadi mandiri secala sosial dan ekonomi.</p>\r\n</div>\r\n', 0, 0, 1, 0, '2013-02-06 05:16:51', 3, '2013-02-06 06:14:35', 2, 20, 'en-20'),
(21, 'activities', 'Pembangunan Base Camp', 'pembangunan-base-camp', '<div class="idrw-titcon"><h3>TUGAS SUKARELAWAN :</h3><p>Memperhitungkan kebutuhan bahan, membeli bahan-bahan, dan membangun pembangkit listrik tenaga pikohidro</p></div><div class="idrw-titcon"><h3>TUJUAN :</h3><p>Membangun pembangkit listrik tenaga mikrohidro guna membantu masyarakat yang belum mendapatkan listrik. Karena listrik (minimal untuk penerangan) di saat sekarang ini sudah menjadi kebutuhan primer.</p></div>', 0, 0, 1, 0, '2013-02-06 05:20:02', 2, '2013-02-06 05:20:02', 2, 21, 'en-21'),
(23, 'volunteers', 'Hayley Williams', 'hayley-williams', '<div class="idrw-inline"><strong>Memiliki Minat pada : </strong><label>-</label></div><div class="idrw-inline"><strong>Tinggal di : </strong><label>-</label></div><div class="idrw-inline"><strong>Kerja di : </strong><label>-</label></div><div class="idrw-inline"><strong>Sekolah di : </strong><label>-</label></div><div class="idrw-inline"><strong>Kualifikasi : </strong><label>-</label></div>', 0, 0, 1, 0, '2013-02-06 08:39:19', 4, '2013-02-06 08:39:19', 4, 23, 'en-23'),
(22, 'media', 'lilyallen', 'lilyallen', NULL, 0, 0, 1, 0, '2013-02-06 06:14:27', 2, '2013-02-06 06:14:27', 2, 22, '');

-- --------------------------------------------------------

--
-- Table structure for table `cms_entry_metas`
--

CREATE TABLE IF NOT EXISTS `cms_entry_metas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_id` int(11) NOT NULL,
  `key` varchar(500) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `cms_entry_metas`
--

INSERT INTO `cms_entry_metas` (`id`, `entry_id`, `key`, `value`) VALUES
(4, 21, 'organization-id', '20'),
(5, 22, 'image_type', 'png'),
(6, 22, 'image_size', '111295'),
(7, 20, 'form-person_in_charge', 'Sari'),
(8, 20, 'form-picture', '22'),
(9, 21, 'form-jenis', '');

-- --------------------------------------------------------

--
-- Table structure for table `cms_roles`
--

CREATE TABLE IF NOT EXISTS `cms_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `description` text,
  `count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cms_roles`
--

INSERT INTO `cms_roles` (`id`, `name`, `description`, `count`) VALUES
(1, 'System', 'Anything automated by the system', NULL),
(2, 'Morra Support', 'Actually human editing the record', NULL),
(3, 'Admins', 'Administrator from the clients', NULL),
(4, 'Regular Users', 'Anyone with no access to admin panel', NULL),
(5, 'Participants', 'Anyone added without proper credentials and no access priviledges', NULL),
(6, 'Organization', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_settings`
--

CREATE TABLE IF NOT EXISTS `cms_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `key` varchar(500) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `cms_settings`
--

INSERT INTO `cms_settings` (`id`, `name`, `key`, `value`) VALUES
(1, 'sites', 'title', 'Indorelawan'),
(2, 'sites', 'tagline', 'The best you can trust.'),
(3, 'sites', 'description', 'Deskripsi Indorelawan in Indonesia Country'),
(4, 'sites', 'domain_name', 'http://192.168.1.17'),
(5, 'sites', 'path_url', '/'),
(6, 'sites', 'date_format', 'F d, Y'),
(7, 'sites', 'time_format', 'h:i A'),
(8, 'sites', 'logo', 'images/idrw-logo.png'),
(9, 'sites', 'favicon', 'images/idrw-logo.png'),
(10, 'sites', 'header', ''),
(11, 'sites', 'top_insert', ''),
(12, 'sites', 'bottom_insert', ''),
(13, 'sites', 'modified', '2013-2-5 3:57:35'),
(14, 'sites', 'modified_by', '2'),
(15, 'sites', 'google_analytics_code', ''),
(16, 'sites', 'display_width', '1000'),
(17, 'sites', 'display_height', '1000'),
(18, 'sites', 'display_crop', '1'),
(19, 'sites', 'thumb_width', '120'),
(20, 'sites', 'thumb_height', '120'),
(21, 'sites', 'thumb_crop', '1'),
(22, 'sites', 'language', 'en_english'),
(23, 'sites', 'facebook_app_id', ''),
(24, 'sites', 'twitter_consumer_key', ''),
(25, 'sites', 'twitter_consumer_secret', ''),
(26, 'sites', 'keywords', 'indorelawan');

-- --------------------------------------------------------

--
-- Table structure for table `cms_types`
--

CREATE TABLE IF NOT EXISTS `cms_types` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `cms_types`
--

INSERT INTO `cms_types` (`id`, `name`, `slug`, `description`, `parent_id`, `count`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'User Guides', 'user-guides', 'This is how to guide our users to use our CMS.', -1, 0, '2012-07-17 12:39:37', 2, '2012-07-19 10:56:00', 2),
(2, 'Media Library', 'media', 'This is media library', -1, 0, '2012-08-29 11:26:18', 2, '2012-08-29 11:26:18', 2),
(3, 'Organizations', 'organizations', '', -1, 0, '2013-02-05 04:48:13', 2, '2013-02-06 06:08:00', 2),
(4, 'Volunteers', 'volunteers', '', -1, 0, '2013-02-05 10:05:44', 2, '2013-02-06 08:55:52', 2),
(5, 'Activities', 'activities', '', -1, 0, '2013-02-06 03:43:34', 2, '2013-02-06 10:23:59', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cms_type_metas`
--

CREATE TABLE IF NOT EXISTS `cms_type_metas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `key` varchar(500) NOT NULL,
  `value` text,
  `input_type` varchar(500) DEFAULT NULL,
  `validation` text,
  `instruction` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `cms_type_metas`
--

INSERT INTO `cms_type_metas` (`id`, `type_id`, `key`, `value`, `input_type`, `validation`, `instruction`) VALUES
(1, 1, 'form-site_tour', 'yes', 'checkbox', '', 'Include as Site Tour.'),
(2, 3, 'form-person_in_charge', '', 'text', '', ''),
(3, 3, 'form-picture', '', 'image', '', ''),
(4, 4, 'thumb_width', '256', NULL, NULL, NULL),
(5, 4, 'thumb_height', '256', NULL, NULL, NULL),
(6, 4, 'thumb_crop', '1', NULL, NULL, NULL),
(8, 5, 'form-jenis', '', 'text', '', ''),
(9, 5, 'form-fokus', '', 'text', '', ''),
(10, 5, 'form-lokasi', '', 'text', '', ''),
(11, 5, 'form-waktu', '', 'text', '', ''),
(12, 5, 'form-durasi', '', 'text', '', ''),
(13, 5, 'form-penanggung_jawab', '', 'text', '', ''),
(14, 5, 'form-batasan_usia', '', 'text', '', ''),
(15, 5, 'form-english_speaker', '', 'text', '', ''),
(16, 5, 'form-kualifikasi_khusus_sukarelawan', '', 'text', '', ''),
(17, 5, 'form-perlu_disiapkan', '', 'text', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cms_users`
--

CREATE TABLE IF NOT EXISTS `cms_users` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cms_users`
--

INSERT INTO `cms_users` (`id`, `firstname`, `lastname`, `role_id`, `created`, `created_by`, `modified`, `modified_by`, `status`) VALUES
(1, 'system', NULL, 1, '2012-06-12 17:42:10', 2, '2012-06-12 17:42:16', 2, 1),
(2, 'Morra', 'Support', 2, '2012-06-12 18:15:17', 2, '2012-07-12 17:26:33', 2, 1),
(3, 'nymph.corp', '', 6, '2013-02-06 05:16:51', 2, '2013-02-06 05:16:51', 2, 0),
(4, 'hayley.williams', '', 4, '2013-02-06 08:39:19', 2, '2013-02-06 08:39:19', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cms_user_metas`
--

CREATE TABLE IF NOT EXISTS `cms_user_metas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(500) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cms_user_metas`
--

INSERT INTO `cms_user_metas` (`id`, `user_id`, `key`, `value`) VALUES
(1, 2, 'email', 'hello@morrastudio.com'),
(2, 3, 'email', 'nymph.corp@test.com'),
(3, 4, 'email', 'hayley.williams@test.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
