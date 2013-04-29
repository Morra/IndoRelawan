<?php
	$this->Html->addCrumb('Users', '/admin/users');
	$this->Html->addCrumb('Add New', '/admin/users/add');	
?>
<script type="text/javascript">
	$("a#users").addClass("active");
</script>

<div class="inner-header">
	<div class="title">
		<h2>ADD NEW USER</h2>
		<p class="title-description">Add new users without creating login accounts. By default, the following users will be added as Participants. It's useful when you have a newsletter box upfront.</p>				
	</div>
</div>

<div class="inner-content">		

<?php
	echo $form->create('User', array('action'=>'add','type'=>'file','class'=>'notif-change form-horizontal fl','inputDefaults' => array('label' =>false , 'div' => false)));	
?>
	<fieldset>
		<p class="notes important">* Required fields.</p>
	
		<div class="control-group">            
			<label class="control-label">Firstname*</label>
			<div class="controls">
				<input class="input-xlarge" type="text" size="40" name="data[User][firstname]"/>								
			</div>
		</div>
		
		<div class="control-group">            
			<label class="control-label">Lastname</label>
			<div class="controls">				
				<input class="input-xlarge" type="text" size="40" name="data[User][lastname]"/>
			</div>
		</div>
		
		<div class="control-group">            
			<label class="control-label">E-mail Address</label>
			<div class="controls">				
				<input class="input-xlarge" type="text" size="40" name="data[UserMeta][0][value]"/>
				<input type="hidden" value="email" name="data[UserMeta][0][key]" />			
			</div>
		</div>
		
	<!-- SAVE BUTTON -->
		<div class="control-action">
			<button type="submit" class="btn btn-primary">Add New</button>
        	<button type="button" class="btn" onclick="javascript: window.location=site+'admin/users'">Cancel</button>
		</div>
	</fieldset>
<?php echo $form->end(); ?>
	
</div>