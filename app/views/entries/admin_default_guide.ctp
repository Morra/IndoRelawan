<?php
	extract($data , EXTR_OVERWRITE);
	$_SESSION['now'] = htmlentities($_SERVER['REQUEST_URI']);
	if($isAjax == 0)
	{
		echo $this->element('admin_header_guide');
		echo '<div class="inner-content">';
		echo '<div id="ajaxed">';
	}
	else
	{
		?>
			<script>
				$(document).ready(function(){
					$('#cmsAlert').css('display' , 'none');
				});
			</script>
		<?php
	}
?>

<script>
$(document).ready(function(){
	$("a#<?php echo $myType['Type']['slug']; ?>").addClass("active");

    $('#slider1').bxSlider({
		onNextSlide: function(){
			
		},
		onPrevSlide: function(){
			
		}
	});
 });
</script>

<div id="slider1">
	<?php
		foreach ($userGuides as $value)
		{
		?>
			<div>
				<?php echo $value['Entry']['description']; ?>
				<input type="hidden" value="<?php echo $value['Entry']['id']; ?>" class="user-count">
			</div>
		<?php
		}
	?>
</div>