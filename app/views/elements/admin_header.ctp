<?php
	extract($data , EXTR_OVERWRITE);
	$this->Html->addCrumb($myType['Type']['name'], '/admin/entries/'.$myType['Type']['slug']);
	if(!empty($myEntry))
	{
		$this->Html->addCrumb($myEntry['Entry']['title'], '/admin/entries/'.$myType['Type']['slug'].'/'.$myEntry['Entry']['slug'].($myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:''));
	}
?>
<script type="text/javascript">
	$("a#<?php echo $myType['Type']['slug']; ?>").addClass("active");
	$(document).ready(function(){
		var orderFlag = '';
		switch('<?php echo $_SESSION['order_by']; ?>')
		{
			case 'modified DESC':
				orderFlag = 'latest_first';
				break;
			case 'modified ASC':
				orderFlag = 'oldest_first';
				break;
			default:
				orderFlag = 'by_order';
				break;
		}
		$('a[alt='+orderFlag+'].order_by').html(string_unslug(orderFlag)+' <i class="icon-ok"></i>');
		
		// SEARCH SCRIPT !!
		$('input#searchMe').change(function(){
			$('a.searchMeLink').click();
		});
		$('a.searchMeLink').html('<i class="icon-search"></i>');
	});
</script>

<div class="inner-header">
	<div class="title">
		<h2></h2>
		<p id="id-title-description" class="title-description"></p>
	</div>
	<?php
		if(!($myType['Type']['slug'] == 'pages' && $user['Role']['id'] >= 3))
		{
			echo $form->Html->link('Add '.(empty($myEntry)?$myType['Type']['name']:$myChildType['Type']['name']),array('action'=>$myType['Type']['slug'],(empty($myEntry)?'':$myEntry['Entry']['slug'].'/').'add'.(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')),array('class'=>'btn btn-primary fr right-btn get-started'));
		}
	?>
	<div class="btn-group">
		<a class="btn" href="#"><i class="icon-cog"></i>&nbsp;<?php //echo ($_SESSION['order_by']=='modified DESC'?'Latest First':($_SESSION['order_by']=='modified ASC'?'Oldest First':'By Order')); ?></a>
		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;</a>
		<ul class="dropdown-menu">
			<?php
				echo '<li>';
				echo $form->Html->link("By Order",array("action"=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']),'index',$paging.(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')) , array("class"=>"ajax_mypage order_by" , "alt"=>"by_order"));
				echo '</li>';
				echo '<li>';
				echo $form->Html->link("Latest First",array("action"=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']),'index',$paging.(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')) , array("class"=>"ajax_mypage order_by" , "alt"=>"latest_first"));
				echo '</li>';
				echo '<li>';
				echo $form->Html->link("Oldest First",array("action"=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']),'index',$paging.(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')) , array("class"=>"ajax_mypage order_by" , "alt"=>"oldest_first"));
				echo '</li>';
			?>
		</ul>
	</div>
	<?php
		if(count($mySetting['sites']['language']) > 1)
		{
			?>
	<div class="btn-group lang-selector" style="margin-right: 10px;">
		<a id="lang_identifier" class="btn" href="#"><?php echo (empty($this->params['url']['lang'])?substr($mySetting['sites']['language'][0], 0,2):strtoupper($this->params['url']['lang'])); ?></a>
		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;</a>
		<ul class="dropdown-menu">
		<?php
			foreach ($mySetting['sites']['language'] as $key => $value) 
			{
				$this_lang = strtolower(substr($value, 0,2));
				if(empty($myEntry) || !empty($myEntry) && !empty($parent_language[$this_lang]))
				{
					echo '<li>';
					echo $form->Html->link($value,array("action"=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$parent_language[$this_lang]),'index','1?lang='.$this_lang.(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'&type='.$myChildType['Type']['slug']:'')) , array("class"=>"ajax_mypage langLink"));
					echo '</li>';
				}
			}					
		?>
		</ul>
	</div>		
			<?php
		}
	?>
	<div class="input-prepend">
		<span class="add-on">
			<?php
				echo $form->Html->link("tes",array("action"=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']),'index','1'.(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')) , array("class"=>"ajax_mypage searchMeLink"));
			?>
		</span>
		<input id="searchMe" class="span2" type="text" size="16" placeholder="Search...">
	</div>
</div>