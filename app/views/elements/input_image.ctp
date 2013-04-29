<?php
	extract($data , EXTR_OVERWRITE);
	$value = (empty($value)?0:$value);
	$p = (empty($p)?'JPG, PNG, or GIF and 1MB max':$p);
?>
<div class="control-group control-image" <?php echo (empty($display)?'':'style="display:none"'); ?>>            
	<label class="control-label">
		<?php
			echo string_unslug(substr($key, 5 ));
			if(strpos(strtolower($validation), 'not_empty') !== FALSE)
			{
				echo '*';
			} 
		?>
	</label>
	<div class="controls">
		<?php
			echo $this->Html->image('upload/thumb/'.$value.'.'.(empty($value)?'jpg':$myImageTypeList[$value]),array('id'=>'myEditCoverImage_'.$counter));
		?>
	</div>
	<div class="controls" style="margin-top:10px">
		<?php echo $form->Html->link('Change',array('controller'=>'entries','action'=>'media_popup_single','1','myEditCoverImage_'.$counter,(empty($myChildType)?$myType['Type']['slug']:$myChildType['Type']['slug']),'admin'=>false),array('class'=>'btn btn-info get-from-library'));	?>
		<a class="btn btn-danger" onclick="javascript : $.fn.removePicture(<?php echo $counter; ?>);" href="javascript:void(0)">Remove</a>
		<p class="help-block"><?php echo $p; ?></p>
	</div>
	<input type="hidden" value="<?php echo $value; ?>" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][value]" id="myEditCoverId_<?php echo $counter; ?>"/>
	<input type="hidden" value="<?php echo $key; ?>" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][key]"/>
	<input type="hidden" value="<?php echo $input_type; ?>" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][input_type]"/>
	<input type="hidden" value="<?php echo $validation; ?>" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][validation]"/>
	<input type="hidden" value="<?php echo $p; ?>" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][instruction]"/>
</div>