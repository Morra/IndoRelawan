<?php 
	$this->Html->addCrumb('User Account', '/admin/users');
	echo $this->Html->script(array('project','cancel'),false);
?>
<script type="text/javascript">
	$("a#users").addClass("active");
</script>
<div class="inner-header">
	<div class="title">
		<h2>USER ACCOUNT</h2>
		<p class="title-description">Last updated on <?php echo $user['User']['modified']; ?></p>
	</div>
</div>
	
<div class="inner-content">		
<?php
	echo $form->create('User', array('action'=>'save','type'=>'file','class'=>'notif-change form-horizontal fl','inputDefaults' => array('label' =>false , 'div' => false)));
?>		
	<fieldset>		
		<div class="control-group">            
			<label class="control-label">Username</label>
			<div class="controls">
				<input class="input-xlarge" name="data[User][username]" value="<?php echo $user['User']['username']; ?>" size="55" type="text" id="tUsername">
				<input name="data[User][id]" value="<?php echo $user['User']['id'];?>" type="hidden">				
			</div>
		</div>
		
		<div class="control-group">            
			<label class="control-label">E-mail Address</label>
			<div class="controls">				
				<input class="input-xlarge" name="data[User][email]" value="<?php echo $user['User']['email']; ?>" size="55" type="text" id="tEmail">
			</div>
		</div>
		
		<div class="control-group">            
			<label class="control-label">New Password</label>
			<div class="controls">
				<input type="password" style="display: none;">
				<input class="input-xlarge" name="data[User][password]" value="" size="55" type="password" id="tPassword1">
				<p class="help-block">Leave blank if not edited.</p>
			</div>
		</div>
		
		<div class="control-group">            
			<label class="control-label">Confirm Password</label>
			<div class="controls">				
				<input class="input-xlarge" name="data[User][confirm]" value="" size="55" type="password" id="tPassword2">				
			</div>
		</div>
				
	<!-- SAVE BUTTON -->
		<button type="submit" class="btn btn-primary">Save Changes</button>
        <button type="button" class="btn" onclick="javascript: window.location=site+'users'">Cancel</button>
        <input type="hidden" name="data[User][editpass]" value = "0" id = "editpass" />
	</fieldset>
<?php echo $form->end(); ?>
</div>