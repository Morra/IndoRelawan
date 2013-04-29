<?php
	$this->Html->addCrumb('Accounts', '/admin/accounts');
	$this->Html->addCrumb($myData['User']['firstname'].' '.$myData['User']['lastname'], '/admin/accounts/edit/'.$id);	
?>
<script type="text/javascript">
	$("a#aus").addClass("active");
</script>

<div class="inner-header">
	<div class="title">
		<h2><?php echo $myData['User']['firstname'].' '.$myData['User']['lastname']; ?> ACCOUNT</h2>
		<p id="id-title-description" class="title-description">Last updated by <a href="#"><?php echo $myData['ParentModifiedBy']['firstname'].' '.$myData['ParentModifiedBy']['lastname'].'</a> on '.date_converter($myData['Account']['modified'], $setting[5]['Setting']['value'] , $setting[6]['Setting']['value']); ?></p>				
	</div>
</div>

<div class="inner-content">		
	
<?php
	echo $form->create('Account', array('action'=>'edit/'.$id,'type'=>'file','class'=>'notif-change form-horizontal fl','inputDefaults' => array('label' =>false , 'div' => false)));	
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
	
		<div class="control-group">            
			<label class="control-label">Username</label>
			<div class="controls">				
				<input class="input-xlarge" value="<?php echo $myData['Account']['username']; ?>" type="text" size="40" name="data[Account][username]"/>								
			</div>
		</div>
		
		<div class="control-group">            
			<label class="control-label">E-mail*</label>
			<div class="controls">				
				<input class="input-xlarge" value="<?php echo $myData['Account']['email']; ?>" type="text" size="40" name="data[Account][email]"/>								
			</div>
		</div>
		
		<div class="control-group">            
			<label class="control-label">New Password</label>
			<div class="controls">
				<input type="password" style="display: none;">				
				<input class="input-xlarge" type="password" size="40" name="data[Account][password]"/>
				<p class="help-block">5 Characters minimum. No funny characters.</p>				
			</div>
		</div>
		
		<div class="control-group">            
			<label class="control-label">Confirm Password</label>
			<div class="controls">				
				<input class="input-xlarge" type="password" size="40" name="data[Account][confirm]"/>								
			</div>
		</div>
		
	<!-- SAVE BUTTON -->
		<div class="control-action">
			<button type="submit" class="btn btn-primary">Save Changes</button>
        	<button type="button" class="btn" onclick="javascript: window.location=site+'admin/users'">Cancel</button>
		</div>
	</fieldset>
<?php echo $form->end(); ?>	
	
</div>