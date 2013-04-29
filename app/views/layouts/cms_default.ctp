<?php
	echo $html->docType('html4-trans');
?>

<html lang="en">

	<head>
		<?php echo $this->Html->charset(); ?>
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
		<title><?php echo $title_for_layout; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <!-- <meta name="description" content="<?php //echo (!empty($metaDescription))?$metaDescription:$setting[2]['Setting']['value']; ?>"> -->
		<meta name="description" content="<?php echo $metaDescription; ?>">
		<meta name="keywords" content="<?php echo (!empty($metaKeywords))?$metaKeywords:$setting[25]['Setting']['value']; ?>">
		<meta name="author" content="Morra">
<!-- 		FAVICON IMAGE -->
		<link rel="shortcut icon" href="<?php echo $imagePath.$setting[8]['Setting']['value']; ?>" type="image/x-icon" />

<!-- 		SITE & LINKPATH SETTING FOR GLOBAL JAVASCRIPT -->
		<script type="text/javascript">
		  var site = '<?php echo $site; ?>';
		  var linkpath = '<?php echo $imagePath; ?>';
		</script>

		<?php
			// load our css script...
			echo $html->css('jqueryui/jquery-ui');
			//echo $html->css('style');

			// Le styles
			echo $html->css('bootstrap');
			echo $html->css('colorbox');
			echo $html->css('jquery.fileupload-ui');
			echo $html->css('admin/style');
			echo $html->css('bootstrap-responsive');

			// load our js script...
			//echo $html->script('define');
			echo $html->script('jquery');
			// echo $html->script('jquery.color');
			echo $html->script('jquery-ui');
			echo $html->script('admin');
			echo $html->script('ajax');
			echo $scripts_for_layout;
		?>

		<!-- Le javascript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster -->
	    <script src="<?php echo $imagePath; ?>js/bootstrap-transition.js"></script>
	    <script src="<?php echo $imagePath; ?>js/bootstrap-alert.js"></script>
	    <script src="<?php echo $imagePath; ?>js/bootstrap-modal.js"></script>
	    <script src="<?php echo $imagePath; ?>js/bootstrap-dropdown.js"></script>
	    <script src="<?php echo $imagePath; ?>js/bootstrap-scrollspy.js"></script>
	    <script src="<?php echo $imagePath; ?>js/bootstrap-tab.js"></script>
	    <script src="<?php echo $imagePath; ?>js/bootstrap-tooltip.js"></script>
	    <script src="<?php echo $imagePath; ?>js/bootstrap-popover.js"></script>
	    <script src="<?php echo $imagePath; ?>js/bootstrap-button.js"></script>
	    <script src="<?php echo $imagePath; ?>js/bootstrap-collapse.js"></script>
	    <script src="<?php echo $imagePath; ?>js/bootstrap-carousel.js"></script>
	    <script src="<?php echo $imagePath; ?>js/bootstrap-typeahead.js"></script>
		<script src="<?php echo $imagePath; ?>js/jquery.imagesloaded.js"></script>
		<script src="<?php echo $imagePath; ?>js/jquery.colorbox.js"></script>
		<script src="<?php echo $imagePath; ?>js/validation.js"></script>
		<script src="<?php echo $imagePath; ?>js/script.js"></script>
		<script src="<?php echo $imagePath; ?>js/media.js"></script>
		<script src="<?php echo $imagePath; ?>js/jquery.bxSlider.js"></script>

<!-- 		for CK Editor -->
<?php /*		<link type="text/css" href="<?php echo $imagePath; ?>css/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />*/ ?>
	    <script type="text/javascript" src="<?php echo $imagePath; ?>js/ckeditor/ckeditor.js"></script>
	    <script type="text/javascript" src="<?php echo $imagePath; ?>js/ckeditor/adapters/jquery.js"></script>
	    <script type="text/javascript" src="<?php echo $imagePath; ?>js/ckfinder/ckfinder.js"></script>

<!-- 		for Cropping Image -->
		<link rel="stylesheet" href="<?php echo $imagePath; ?>css/jquery.jcrop.css" type="text/css" />
		<script type="text/javascript" src="<?php echo $imagePath; ?>js/jquery.jcrop.js"></script>

<!-- 		for copy to clipboard -->
		<script type="text/javascript" src="<?php echo $imagePath; ?>js/ZeroClipboard/ZeroClipboard.js"></script>

<!-- 		for jquery uploading file -->
		<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<?php /*		<script src="<?php echo $imagePath; ?>uploadfile/js/vendor/jquery.ui.widget.js"></script>*/ ?>
		<!-- The Templates plugin is included to render the upload/download listings -->
		<script src="<?php echo $imagePath; ?>uploadfile/js/tmpl.min.js"></script>
		<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
		<script src="<?php echo $imagePath; ?>uploadfile/js/load-image.min.js"></script>
		<!-- The Canvas to Blob plugin is included for image resizing functionality -->
		<script src="<?php echo $imagePath; ?>uploadfile/js/canvas-to-blob.min.js"></script>
		<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
		<script src="<?php echo $imagePath; ?>uploadfile/js/jquery.iframe-transport.js"></script>
		<!-- The basic File Upload plugin -->
		<script src="<?php echo $imagePath; ?>uploadfile/js/jquery.fileupload.js"></script>
		<!-- The File Upload file processing plugin -->
		<script src="<?php echo $imagePath; ?>uploadfile/js/jquery.fileupload-fp.js"></script>
		<!-- The File Upload user interface plugin -->
		<script src="<?php echo $imagePath; ?>uploadfile/js/jquery.fileupload-ui.js"></script>

<?php
// use this commented part for Google Analytics
/*
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
}*/
?>
		<?php echo $setting[9]['Setting']['value']; ?>
	</head>

	<body>
		<?php echo $setting[10]['Setting']['value']; ?>
		<div class="container-fluid">
      		<div class="header row-fluid">
				<div class="span9">

					<a target="_blank" href="<?php echo $imagePath; ?>"><img src="<?php echo $imagePath.$setting[7]['Setting']['value']; ?>" /></a>
				</div>

				<div class="username span3">

				</div>
			</div>

			<div class="layout-header row-fluid">
				<div class="span12">
					<div class="row-fluid">
						<div class="breadcrumbs">
							<a class="icon" href="<?php echo $imagePath; ?>"><i class="icon-globe icon-white"></i></a> <span>|</span>
							<a class="icon" href="<?php echo $imagePath; ?>admin"><i class="icon-home icon-white"></i></a> <span>&rsaquo;</span>
							<p><?php echo $this->Html->getCrumbs(' &rsaquo; ',''); ?></p>
						</div>
						<div class="actions">
							<!--
							<?php echo $this->Html->link('Logout',array('controller'=>'accounts','action'=>'logout','admin'=>false, "plugin" => false), array('class' => 'btn btn-mini btn-danger fr')); ?>
							<div class="language btn-group fr">
								<a class="btn btn-mini" href="#">EN</a>
								<a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;</a>
								<ul class="dropdown-menu">
									<li><a href="#">EN</a></li>
									<li><a href="#">ID</a></li>
								</ul>
							-->
							<div class="account btn-group fr">
								<a class="btn btn-mini" href="#"><i class="icon-user"></i>&nbsp;<?php echo $user['User']['firstname']; ?></a>
								<a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;</a>
								<ul class="dropdown-menu">
									<li><a href="#"><i class="icon-pencil"></i>&nbsp;Edit</a></li>
									<li><a href="<?php echo $imagePath; ?>accounts/logout/<?php echo ($this->params['admin']==1?1:0); ?>"><i class="icon-off"></i>&nbsp;Logout</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="layout-body row-fluid">

				<!--HEADER-->
				<div class="sidebar span2">
					<ul>
						<?php
							// echo "<li>";
							// echo $this->Html->link('Dashboard','#',array('id'=>'dashboard'));
							// echo "</li>";
						?>
						<?php
							if($user['User']['role_id'] <= 2)
							{
								echo "<li>";
								echo $this->Html->link('Master',array('controller'=>'master','action'=>'types', "plugin" => false),array('id'=>'master'));
								echo "</li>";
							}
						?>
						<li>
							<?php
								echo $this->Html->link('Settings',array('controller'=>'settings','action'=>'index', "plugin" => false),array('id'=>'settings'));
							?>
						</li>
						<li>
							<?php
								echo $this->Html->link('Users & Accounts',array('controller'=>'users','action'=>'index', "plugin" => false),array('id'=>'aus'));
							?>
						</li>
						<?php //<li> ?>
							<?php
								//echo $this->Html->link('Accounts',array('controller'=>'accounts','action'=>'index', "plugin" => false),array('id'=>'accounts'));
							?>
						<?php //</li> ?>
						<?php //<li> ?>
							<?php
								//echo $this->Html->link('Users',array('controller'=>'users','action'=>'index', "plugin" => false),array('id'=>'users'));
							?>
						<?php //</li> ?>
						<li>
							<?php
								echo $this->Html->link('Media Library',array('controller'=>'entries','action'=>'media', "plugin" => false),array('id'=>'media'));
							?>
						</li>
						<?php
							// if($user['User']['role_id'] <= 2)
							// {
								echo "<li>";
								echo $this->Html->link('User Guides',array('controller'=>'entries','action'=>'user-guides', "plugin" => false),array('id'=>'user-guides'));
								echo "</li>";
							// }
						?>
						<li>
							<?php
								echo $this->Html->link('Pages',array('controller'=>'entries','action'=>'pages', "plugin" => false),array('id'=>'pages'));
							?>
						</li>
						<?php
							// foreach ($pages as $key => $value)
							// {
								// echo "<li>";
								// echo $this->Html->link($value['Entry']['title'] ,array('controller'=>'pages','action'=>$value['Entry']['slug']) ,array('id'=>$value['Entry']['slug']));
								// echo "</li>";
							// }
						?>
						
						<?php
						if($setting[26]['Setting']['key'] == 'store_format')
						{
						?>
						<li class='separator'><?php echo $this->Html->link('Store','#'); ?></li>
						<?php
							foreach ($types as $key => $value)
								if($value['Type']['slug'] == 'categories') {
						?>
						<li>
							<?php echo $this->Html->link($value['Type']['name'] ,array('controller'=>'entries','action'=>$value['Type']['slug'], "plugin" => false) ,array('id'=>$value['Type']['slug'])); ?>
						</li>
						<?php
								}
						?>
						<li>
							<?php echo $this->Html->link('Products',array('controller'=>'catalog','action'=>'index', "plugin" => 'commerce'),array('id'=>'products')); ?>
						</li>
						<li>
							<?php echo $this->Html->link('Orders',array('controller'=>'orders','action'=>'index', "plugin" => 'commerce'),array('id'=>'orders')); ?>
						</li>
						<?php
						}
						?>
						
						<li class='separator'><?php echo $this->Html->link('Databases','#'); ?></li>
						<?php
							foreach ($types as $key => $value)
							{
								if($value['Type']['slug'] != 'media' && $value['Type']['slug'] != 'user-guides' && $value['Type']['slug'] != 'products' && $value['Type']['slug'] != 'upgrades' && $value['Type']['slug'] != 'categories')
								{
									echo "<li>";
									echo $this->Html->link($value['Type']['name'] ,array('controller'=>'entries','action'=>$value['Type']['slug'], "plugin" => false) ,array('id'=>$value['Type']['slug']));
									echo "</li>";
								}
							}
						?>

					</ul>
				</div>

				<!--BODY-->
				<div class="content">
					<div id="child-content" class="media inner-content">
						<?php echo $this->Session->flash(); ?>
						<?php echo $content_for_layout; ?>
					</div>
					<div class="clear"></div>
				</div>
      		</div><!--/row-->
	    </div><!--/.fluid-container-->
		<?php echo $setting[11]['Setting']['value']; ?>
	</body>
</html>
