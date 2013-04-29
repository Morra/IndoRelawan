<?php
	extract($data , EXTR_OVERWRITE);
	$this->Html->addCrumb($myType['Type']['name'], '/admin/entries/'.$myType['Type']['slug']);
	if(!empty($myEntry))
	{
		$this->Html->addCrumb($myEntry['Entry']['title'], '/admin/entries/'.$myType['Type']['slug'].'/'.$myEntry['Entry']['slug'].($myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:''));
	}
?>

<div class="inner-header">
	<button class="btn fr right-btn next" type="submit">Next<i class="icon-chevron-right"></i></button>
	<button class="btn fr right-btn prev" type="submit"><i class="icon-chevron-left"></i>Prev</button>
	
	<div class="title">
		<h2><?php echo strtoupper(empty($myEntry)?$myType['Type']['name']:$myEntry['Entry']['title'].' '.$myChildType['Type']['name']); ?></h2>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('.next').click(function(){
			$('.bx-next').trigger('click');
		});
		
		$('.prev').click(function(){
			$('.bx-prev').trigger('click');
		});
	});
</script>