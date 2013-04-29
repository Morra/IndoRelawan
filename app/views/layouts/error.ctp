<?php
	echo $html->docType('html4-trans');
?>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="author" content="Morra">
        <?php
			
//			echo $html->meta('icon', $html->url('/img/icon/favicon.png'));
			echo $html->css('user_reset');
			echo $html->css('user_cr');
            //echo $html->css('user_default');
            echo $html->script('jquery');
			// echo $html->script('jquery.color');
			// echo $html->script('jquery.ba-hashchange.min');
			// echo $html->script('frontpage');
			// echo $html->script('plugins');
			// echo $html->script('initPlugins');
            echo $scripts_for_layout;
			// echo $siteProfile['SiteProfile']['header'];
        ?>
	
</head>
<body>
	<?php //echo $siteProfile['SiteProfile']['top']; ?>
	
	<div id="mr_Canvas" class="isHome">
		
		<!-- Header -->
		
		
		<!-- Body: Main content area -->
		
		<div id="main-content">
		
			<?php echo $content_for_layout; ?>
			
		</div>
		
		<!-- Footer -->
		
	</div>
	<?php //echo $siteProfile['SiteProfile']['bottom']; ?>
</body>
</html>
