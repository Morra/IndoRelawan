<!DOCTYPE HTML>
<html>
<head lang="en">
<?php
	foreach($data['myEntry']['EntryMeta'] as $seo)
	{
		if($seo['key'] == 'SEO_Keywords')
			$metaKeywords = $seo['value'];
		else if($seo['key'] == 'SEO_Description')
		{
			$metaDescription = $seo['value'];
			if(empty($metaDescription))
			{
				if(!empty($data['myEntry']['Entry']['description']))
					$metaDescription = strip_tags($data['myEntry']['Entry']['description']);
				else
					$metaDescription = $setting[2]['Setting']['value'];
			}
		}
	}
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <meta name="description" content="<?php //echo (!empty($metaDescription))?$metaDescription:$setting[2]['Setting']['value']; ?>"> -->
<meta name="description" content="<?php echo $metaDescription; ?>">
<meta name="keywords" content="<?php echo (!empty($metaKeywords))?$metaKeywords:$setting[25]['Setting']['value']; ?>">
<meta name="author" content="Morra">

<title><?php echo $title_for_layout; ?></title>
<!-- FAVICON IMAGE -->
<link rel="shortcut icon" href="<?php echo $imagePath.$setting[8]['Setting']['value']; ?>" type="image/x-icon" />

<!-- SITE & LINKPATH SETTING FOR GLOBAL JAVASCRIPT -->
<script type="text/javascript">
	var site = '<?php echo $site; ?>';
	var linkpath = '<?php echo $imagePath; ?>';
</script>

<link rel="stylesheet" href="<?php echo $imagePath; ?>css/frontend/_style.css">
<script src="<?php echo $imagePath; ?>js/frontend/jquery-1.9.0.min.js"></script>
<script src="<?php echo $imagePath; ?>js/frontend/jquery-ias.js"></script>
<script src="<?php echo $imagePath; ?>js/frontend/jquery.sharrre-1.3.4.min.js"></script>
<script src="<?php echo $imagePath; ?>js/frontend/jquery.bxslider.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// jQuery.ias({
			// container : '.idrw-idcon',
			// item: '.idrw-idcon-row',
			// pagination: '#idrw-content .navigation',
			// next: '.next-posts a',
			// loader: '<img src="<?php echo $imagePath; ?>images/loader.gif"/>',
			// triggerPageTreshold: 2,
		// });
		
		$("#demo1").sharrre({
			share: {
				facebook: true,
				twitter: true
			},
			enableHover: false,
			enableCounter: false,
			enableTracking: true,
			buttons: {
				facebook: {layout: 'button_count', count: 'horizontal'},
				twitter: {count: 'horizontal'}
			}
		});
		
		$("#demo2").sharrre({
			share: {
				facebook: true,
				twitter: true
			},
			enableHover: false,
			enableCounter: false,
			enableTracking: true,
			buttons: {
				facebook: {layout: 'button_count', count: 'horizontal'},
				twitter: {count: 'horizontal'}
			}
		});
	});
</script>

<?php
if (!empty($setting[14]['Setting']['value'])) {
?>
<!-- GOOGLE ANALYTICS CODES -->
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?php echo $setting[14]['Setting']['value']; ?>']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
<?php
}
?>
</head>
<body>
	<div id="idrw-root">
		<div id="idrw-header">
			<div class="idrw-wrap">
				<div class="idrw-header-share idrw-flr idrw-inline">
					<?php //<a href="#"><img src="http://dummyimage.com/70x20/1589B8/fff.png&amp;text=share" alt="dummy"></a>
					//<a href="#"><img src="http://dummyimage.com/70x20/1589B8/fff.png&amp;text=share" alt="dummy"></a> ?>
					<div id="demo1" data-url="<?php echo $site; ?>" data-text="Indorelawan"></div>
				</div>
				<div class="idrw-logo">
					<a href="<?php echo $imagePath; ?>"><img src="<?php echo $imagePath; ?>images/idrw-logo.png" alt="Indorelawan" /></a>
				</div>
				<div class="idrw-menu">
					<ul class="idrw-menu-list">
						<li><a href="#">Untuk Sukarelawan<img src="<?php echo $imagePath; ?>images/redcaret.png" alt="caret" /></a>
						<ul class="submenu-list">
							<li><a href="#">Cari Aktivitas</a></li>
							<li><a href="#">Cari Organisasi</a></li>
						</ul>
						</li>
						<!-- li class="non-active" -->
						<li><a href="#">Untuk Organisasi<img src="<?php echo $imagePath; ?>images/redcaret.png" alt="caret" /></a>
						 <ul class="submenu-list last_">
							<li><a href="#">Buat Aktivitas</a></li>
							<li><a href="#">Profil Sukarelawan</a></li>
						</ul>
						</li>
						<li><a href="<?php echo $imagePath; ?>tentang-kami">Tentang Kami<img src="<?php echo $imagePath; ?>images/redcaret.png" alt="caret" /></a></li>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div id="idrw-content">
			<div class="idrw-wrap">
				<!-- indorelawan container wrap -->
				<?php echo $content_for_layout; ?>
				<!-- indorelawan container wrap -->
			</div>
		</div>
		<div id="idrw-footer">
			<div class="idrw-wrap">
				<div class="idrw-flr idrw-inline" id="share">
					<?php //<a href="#"><img src="http://dummyimage.com/70x20/1589B8/fff.png&amp;text=share" alt="dummy"></a>
					//<a href="#"><img src="http://dummyimage.com/70x20/1589B8/fff.png&amp;text=share" alt="dummy"></a> ?>
					<div id="demo2" data-url="<?php echo $site; ?>" data-text="Indorelawan"></div>
				</div>
				<ul class="idrw-list">
					<li><a href="#">TEAM</a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
					<li><a href="#">SPONSOR</a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
					<li><a href="#">KONTAK KAMI</a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
					<li><a href="#">PRESS</a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
					<li><a href="#">TERMS</a></li>
				</ul>
				<br class="clear" />
				<div class="idrw-footer-btm">
					<p>PUBLISHED BY &copy; INDORELAWAN <?php echo date("Y"); ?>.</p>
					<p>ALL RIGHTS RESERVED.</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>