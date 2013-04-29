<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="author" content="Morra">
<!-- 		FAVICON IMAGE -->
	<link rel="shortcut icon" href="<?php echo $imagePath.$setting[8]['Setting']['value']; ?>" type="image/x-icon" />

<!-- 		SITE & LINKPATH SETTING FOR GLOBAL JAVASCRIPT -->
	<script type="text/javascript">
	  var site = '<?php echo $site; ?>';
	  var linkpath = '<?php echo $imagePath; ?>';
	</script>
<?php
	echo $html->css('bootstrap');
	echo $html->css('admin/style');
	echo $html->css('bootstrap-responsive');

	echo $html->script('jquery');
	echo $html->script('jquery.color');
	echo $scripts_for_layout;
?>
</head>
<body>
<div id="flash_message_container"><?php echo $this->Session->flash(); ?></div>

<?php
if($needThumbBrowser){
	echo $this->element('thumb',array('mediaForElement',$mediaForElement));
}
?>

<?php echo $content_for_layout; ?>
</body>
</html>