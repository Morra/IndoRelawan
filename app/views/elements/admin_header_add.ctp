<?php
	extract($data , EXTR_OVERWRITE);
	if(!empty($myType))
	{
		$this->Html->addCrumb($myType['Type']['name'], '/admin/entries/'.$myType['Type']['slug']);
	}
	else
	{
		$this->Html->addCrumb('Pages', '/admin/entries/pages');
	}
	if(!empty($myChildType))
	{
		$this->Html->addCrumb($myParentEntry['Entry']['title'], '/admin/entries/'.(empty($myType)?'pages':$myType['Type']['slug']).'/'.$myParentEntry['Entry']['slug'].($myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:''));
	}
	if(empty($myEntry))
	{
		$this->Html->addCrumb('Add New', '/admin/entries/'.(empty($myType)?'pages':$myType['Type']['slug']).(empty($myChildType)?'':'/'.$myParentEntry['Entry']['slug']).'/add'.(!empty($myChildType)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:''));
	}
	else
	{
		$this->Html->addCrumb('Edit '.$myEntry['Entry']['title'], '/admin/entries/'.(empty($myType)?'pages':$myType['Type']['slug']).(empty($myChildType)?'':'/'.$myParentEntry['Entry']['slug']).'/edit/'.$myEntry['Entry']['slug'].(!empty($myChildType)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:''));
	}	
?>
<script type="text/javascript">
	$("a#<?php echo (empty($myType)?'pages':$myType['Type']['slug']); ?>").addClass("active");
</script>
<div class="inner-header">
	<?php
		if(!empty($myEntry) && !(empty($myType) && $user['Role']['id'] >= 3))
		{
			?>
			<div class="btn-group action-in-form">
				<a class="btn" href="#">Actions</a>
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;</a>
				<ul class="dropdown-menu">
				<?php
					$statusClass = ($myEntry['Entry']['status'] == 0?'icon-eye-open':'icon-eye-close');
					$statusLabel = ($myEntry['Entry']['status'] == 0?'Active':'Disable');
					if(!empty($myType) && $myType['Type']['slug'] != 'user-guides')
					{
						?>
						<li><a class="ajaxActivate" href="entries/change_status/<?php echo $myEntry['Entry']['id']; ?>"><i class="<?php echo $statusClass; ?>"></i> <?php echo $statusLabel; ?></a></li>
						<?php
					}
				?>	
					<li><a class="delete-entry" href="#"><i class="icon-trash"></i> Delete</a></li>
				</ul>
			</div>
			<?php
		}
	?>
	<?php
		if(count($mySetting['sites']['language']) > 1)
		{
			?>
	<div class="btn-group lang-selector" style="margin-right: 10px;">
		<a id="lang_identifier" class="btn" href="#"><?php echo strtoupper(empty($lang)?substr((empty($myEntry)?$mySetting['sites']['language'][0]:$myEntry['Entry']['lang_code']), 0,2):$lang); ?></a>
		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span>&nbsp;</a>
		<ul class="dropdown-menu">
		<?php
			foreach ($mySetting['sites']['language'] as $key => $value) 
			{
				$default_lang = strtolower(substr($mySetting['sites']['language'][0], 0,2));
				$this_lang = strtolower(substr($value, 0,2));
				if(empty($myParentEntry) || !empty($myParentEntry) && !empty($parent_language[$this_lang]))
				{	
					echo '<li>';
					$myChildTypeLink = (!empty($myParentEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'');
					$myTranslation = ( empty($language_link[$this_lang]) ?  (empty($myChildTypeLink)?'?':'&').'lang='.$this_lang  :'');
					echo $form->Html->link($value,(empty($myEntry)?"#":array('action'=>$myType['Type']['slug'].(empty($myParentEntry)?'':'/'.$parent_language[$this_lang]),'edit',(empty($language_link[$this_lang])?(empty($language_link[$default_lang])? $language_link[substr($myEntry['Entry']['lang_code'],0,2)]:$language_link[$default_lang]):$language_link[$this_lang]).$myChildTypeLink.$myTranslation)),array("class"=>"ajax_myform"));
					echo '</li>';
				}
			}					
		?>
		</ul>
	</div>		
			<?php
		}
	?>
	<div class="title">
		<div class="thumbs">
			<?php				
				echo $this->Html->image('upload/setting/'.(empty($myEntry)?'0.jpg':$myEntry['Entry']['main_image'].'.'.$myImageTypeList[$myEntry['Entry']['main_image']]),array('id'=>'mySelectCoverAlbum'));
			?>			
		</div>
		<?php
			if(empty($myEntry))
			{
				echo '<h2>ADD '.(empty($myChildType)?(empty($myType)?'PAGES':$myType['Type']['name']):$myParentEntry['Entry']['title'].' '.$myChildType['Type']['name']).'</h2>';
			}
			else
			{
				echo '<h2 id="form-title-entry">'.$myEntry['Entry']['title'].'</h2>';
				?>
				<p id="id-title-description" class="title-description"></p>
				<?php
			}
		?>
		<div class="change-pic">
			<i class="icon-cog"></i>			
			<?php 
				if(empty($myEntry) || $myEntry['Entry']['main_image'] == 0)
				{
				?>
					<a href='javascript:void(0)' class='remove' onclick='javascript : $.fn.removePicture();' style="display:none">Remove / </a> <?php echo $form->Html->link('Select Cover',array('action'=>'media_popup_single',1,'mySelectCoverAlbum',(empty($myChildType)?$myType['Type']['slug']:$myChildType['Type']['slug']),'admin'=>false),array('class'=>'get-from-library select cboxElement')); ?>
				<?php
				}
				else
				{
				?>
					<a href='javascript:void(0)' class='remove' onclick='javascript : $.fn.removePicture();'>Remove /</a> <?php echo $form->Html->link('Change Cover',array('action'=>'media_popup_single',1,'mySelectCoverAlbum',(empty($myChildType)?$myType['Type']['slug']:$myChildType['Type']['slug']),'admin'=>false),array('class'=>'get-from-library select cboxElement')); ?>
				<?php
				}
			?>			
		</div>
	</div>
</div>