<?php
	$this->Html->addCrumb('Users', '/admin/users');
	$this->Html->addCrumb($myData['User']['firstname'].' '.$myData['User']['lastname'], '/admin/users/edit/'.$id);	
?>
<script type="text/javascript">
	$("a#aus").addClass("active");
</script>

<div class="inner-header">
	<div class="title">
		<h2><?php echo $myData['User']['firstname'].' '.$myData['User']['lastname']; ?></h2>
		<p id="id-title-description" class="title-description">Last updated by <a href="#"><?php echo $myData['ParentModifiedBy']['firstname'].' '.$myData['ParentModifiedBy']['lastname'].'</a> on '.date_converter($myData['User']['modified'], $setting[5]['Setting']['value'] , $setting[6]['Setting']['value']); ?></p>				
	</div>
</div>

<div class="inner-content">		
	
<?php
	echo $form->create('User', array('action'=>'edit/'.$id,'type'=>'file','class'=>'notif-change form-horizontal fl','inputDefaults' => array('label' =>false , 'div' => false)));	
?>
	<fieldset>
		<p class="notes important">* Required fields.</p>
		<div class="control-group">            
			<label class="control-label">Firstname*</label>
			<div class="controls">
				<input class="input-xlarge" value="<?php echo $myData['User']['firstname']; ?>" type="text" size="40" name="data[User][firstname]"/>								
			</div>
		</div>
		
		<div class="control-group">            
			<label class="control-label">Lastname</label>
			<div class="controls">				
				<input class="input-xlarge" value="<?php echo $myData['User']['lastname']; ?>" type="text" size="40" name="data[User][lastname]"/>
			</div>
		</div>
		
		<?php
			foreach ($myData['UserMeta'] as $key => $value):
				?>
					<div class="control-group">
						<label class="control-label"><?php echo (strtolower($value['key']) == 'email'?'E-mail Address':$value['key']); ?></label>
						<div class="controls">				
							<input class="input-xlarge" value="<?php echo $value['value']; ?>" type="text" size="40" name="data[UserMeta][<?php echo $key; ?>][value]"/>
							<input type="hidden" value="<?php echo $value['key']; ?>" name="data[UserMeta][<?php echo $key; ?>][key]" />								
						</div>
					</div>
				<?php
			endforeach;
		?>
		
	<!-- SAVE BUTTON -->
		<div class="control-action">
			<button type="submit" class="btn btn-primary">Save Changes</button>
        	<button type="button" class="btn" onclick="javascript: window.location=site+'admin/users'">Cancel</button>
		</div>
	</fieldset>
<?php echo $form->end(); ?>	
	
</div>