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
	<div class="controls">
		<select name="data[<?php echo $model; ?>][<?php echo $counter; ?>][value]">
			<?php
				foreach ($list as $key10 => $value10)
				{
					if($value10['id'] == $value)
					{
						echo "<option SELECTED value=\"".$value10['id']."\">".$value10['name']."</option>";
					}
					else
					{
						echo "<option value=\"".$value10['id']."\">".$value10['name']."</option>";
					}
				}
			?>
		</select>
		<?php
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