<?php
	$this->Html->addCrumb('Accounts', '/admin/accounts');
	$this->Html->addCrumb('Add New', '/admin/accounts/add');
?>
<script type="text/javascript">
	$("a#aus").addClass("active");
	
	$(document).ready(function(){
		$("#mail-participation").hide();
		
		$("#role").change(function(event) { 
			event.preventDefault();
			if($(this).val() == "5")
			{
				$("#username").hide();
				$("#password").hide();
				$("#confirm").hide();
				$("#mail-participation").show();
				$("#mail-account").hide();
			}
			else
			{
				$("#username").show();
				$("#password").show();
				$("#confirm").show();
				$("#mail-participation").hide();
				$("#mail-account").show();
			}
		});
	});
</script>

<div class="inner-header">
	<div class="title">
		<h2>ADD USER</h2>
		<p class="title-description">Manage user accounts for login purposes.</p>
	</div>
</div>

<div class="inner-content">

<?php
	echo $form->create('Account', array('action'=>'add','type'=>'file','class'=>'notif-change form-horizontal fl','inputDefaults' => array('label' =>false , 'div' => false)));
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
			<label class="control-label" id="mail-account">E-mail*</label>
			<label class="control-label" id="mail-participation">E-mail</label>
			<div class="controls">
				<input class="input-xlarge" type="text" size="40" name="data[Account][email]"/>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Role</label>
			<div class="controls">
				<select name="data[User][role_id]" id="role">
					<?php
						foreach ($listRoles as $key => $value)
						{
							echo "<option value=\"".$value['Role']['id']."\">".$value['Role']['name']."</option>";
						}
					?>
				</select>
				<p class="help-block">Admin (Only admin can access admin panel)</p>
			</div>
		</div>

		<div class="control-group" id="username">
			<label class="control-label">Username</label>
			<div class="controls">
				<input class="input-xlarge" type="text" size="40" name="data[Account][username]"/>
			</div>
		</div>
		
		<div class="control-group" id="password">
			<label class="control-label">Password*</label>
			<div class="controls">
				<input type="password" style="display: none;">
				<input class="input-xlarge" type="password" size="40" name="data[Account][password]"/>
				<p class="help-block">5 Characters minimum. No funny characters.</p>
			</div>
		</div>

		<div class="control-group" id="confirm">
			<label class="control-label">Confirm Password*</label>
			<div class="controls">
				<input class="input-xlarge" type="password" size="40" name="data[Account][confirm]"/>
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