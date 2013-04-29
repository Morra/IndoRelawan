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
	echo $html->script('jquery.validate.min');
	echo $scripts_for_layout;
?>
<?php
	if (!empty($setting[22]['Setting']['value'])) {
?>
<script type="text/javascript">
var is_allow_fb = true;
$(document).ready(function() {
	//=======Add facebook's javascript(all.js)==========
	//Create element <script>
	var e = document.createElement('script'); e.async = true;
	//Get create the link
	e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
	//Append to #fb-root
	document.getElementById('fb-root').appendChild(e);

	//Init fb object
	window.fbAsyncInit = function() {
		FB.init({
			appId: '<?php echo $setting[22]['Setting']['value']; ?>',
			status: true,
			cookie: true,
			xfbml: true,
			oauth: true
		});

		// put anything FB thing here
		$(".fb_connect").click(function(e) {
			e.preventDefault();
			if (is_allow_fb) {
				is_allow_fb = false;
				FB.login(function(response) {
					// allowed
					if (response.authResponse) {
						FB.api("/me", function(response) {
							$.post(site + 'users/fb_connect', {"data[fbdata]": response}, function(data) {
								location.href = site;
							});
						});
					}
					// disallowed
					else {
						// do nothing
						is_allow_fb = true;
					}
				}, {scope: 'email'});
			}
		});
	}
});
</script>
<?php
	}
	if (!empty($setting[23]['Setting']['value'])) {
?>
<script type="text/javascript">
var is_allow_tw = true;
var status_twitter = "normal";
$(document).ready(function() {
	$(".tw_connect").click(function(e) {
		e.preventDefault();
		if (is_allow_tw) {
			is_allow_tw = false;

			var win = open(site + "twitter", "TwitterOAuthConnect", "location=0,status=0,width=1000,height=640");
			var timer = setInterval(function() {
				if (win.closed) {
					clearInterval(timer);

					// do something
					$.get(site + "twitter/1", function(data) {
						if (data) {
							switch (status_twitter) {
								case "register":
									location = site + "register?twitter";
									break;
								case "reload":
									location.reload();
									break;
								default:
									alert("Error")
									is_allow_tw = true;
									break;
							}
						}
						else
							is_allow_tw = true;
					});
				}
			}, 1000);
		}
	});
});
</script>
<?php
	}
?>
</head>
<body>
<?php
	if (!empty($setting[22]['Setting']['value'])) {
?>
<div id="fb-root"></div>
<?php
	}
?>
<div id="flash_message_container"><?php echo $this->Session->flash(); ?></div>

<?php
if($needThumbBrowser){
	echo $this->element('thumb',array('mediaForElement',$mediaForElement));
}
?>

<?php echo $content_for_layout; ?>
</body>
</html>