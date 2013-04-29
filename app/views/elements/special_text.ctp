<div class="control-group">            
	<label class="control-label">
		<?php
			echo str_replace('_', ' ', substr($key, 5 ));
			if(strpos(strtolower($validation), 'not_empty') !== FALSE)
			{
				echo '*';
			} 
		?>
	</label>
	<div class="controls">
		<input class="input-xlarge" type="text" size="200" value="<?php echo $value; ?>" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][value]"/>
		<?php
			if(!empty($p))
			{
				echo '<p class="help-block">'.$p.'</p>';
			}
		?>
		<a alt="<?php echo $counter+1; ?>" href="javascript:void(0)" class="btn del_setting">Remove</a>
	</div>
	<input type="hidden" value="<?php echo $key; ?>" size="100" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][key]"/>	
	<input type="hidden" value="<?php echo $input_type; ?>" size="100" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][input_type]"/>	
	<textarea type="text" style="display: none" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][validation]"><?php echo $validation; ?></textarea>
</div>