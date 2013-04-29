<div class="control-group">
	<label class="control-label">
		<?php echo str_replace("_"," ",$key); ?>
	</label>
	<div class="controls">
		<input class="input-xlarge" type="text" size="200" value="<?php if(!empty($value)) echo $value; ?>" name="data[EntryMetaSeo][<?php echo $counter; ?>][value]">
		<?php
			if(!empty($p))
			{
				echo '<p class="help-block">'.$p.'</p>';
			}
		?>
	</div>
	<input type="hidden" value="<?php echo $key; ?>" name="data[EntryMetaSeo][<?php echo $counter; ?>][key]">
</div>