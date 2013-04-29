<?php extract($data , EXTR_OVERWRITE); ?>
<div class="control-group" <?php echo (empty($display)?'':'style="display:none"'); ?>>            
	<label class="control-label">
		<?php
			echo string_unslug(substr($key, 5 ));
			if(strpos(strtolower($validation), 'not_empty') !== FALSE)
			{
				echo '*';
			} 
		?>
	</label>
	<div class="controls radio">
		<?php
			$pertama = 1;
			foreach ($list as $key10 => $value10)
			{	
				if($value10['id'] == $value || $pertama == 1)
				{
					$pertama = 0;
					echo "<input CHECKED value='".$value10['id']."' name='data[".$model."][".$counter."][value]' type='radio' /><label>".$value10['name']."</label>";
				}
				else
				{
					echo "<input value='".$value10['id']."' name='data[".$model."][".$counter."][value]' type='radio' /><label>".$value10['name']."</label>";
				}
			}
			if(!empty($p))
			{
				echo '<p class="help-block">'.$p.'</p>';
			}
		?>
	</div>
	<input type="hidden" value="<?php echo $key; ?>" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][key]"/>
	<input type="hidden" value="<?php echo $optionlist; ?>" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][optionlist]"/>	
	<input type="hidden" value="<?php echo $input_type; ?>" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][input_type]"/>
	<input type="hidden" value="<?php echo $validation; ?>" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][validation]"/>
	<input type="hidden" value="<?php echo $p; ?>" name="data[<?php echo $model; ?>][<?php echo $counter; ?>][instruction]"/>
</div>