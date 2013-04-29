<script type="text/javascript">
$(document).ready(function() {
	if($('div#cmsAlert').length > 0) {
		$('div#cmsAlert').removeClass('full');
		$('div#cmsAlert').removeClass('fl');
	}

	// validation start
	var validation_option = {
		validClass: "val_ok",
		errorClass: "val_error",
		ignore: ".val_ignore",
		onkeyup: false,
		onclick: false,
		rules: {
			"data[Account][email]": {
				required: true,
				email: true,
			},
			"data[User][firstname]": "required"
		},
		submitHandler: function(form) {
			$("#form-registration button[type=\"submit\"]").prop("disabled", true);
			form.submit();
		}
	};
	$("#form-registration").validate(validation_option);
	// validation end
});
</script>
<div class="login">
	<div class="header">
		<img src="<?php echo $imagePath; ?>images/logo.png" />
	</div>

	<div class="layout-header">
		<div class="sidebar-title">
			<h4>Subscribe</h4>
		</div>
	</div>

	<div class="layout-body">
		<div class="content">
			<form method="post" id="form-registration">
				<fieldset>
					<?php echo $this->Session->flash(); ?>

					<p class="notes important">* Required fields.</p>
					<div class="control-group">
						<label class="control-label">E-mail*</label>
						<div class="controls">
							<input class="input-xlarge" type="text" size="40" name="data[Account][email]" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Firstname*</label>
						<div class="controls">
							<input class="input-xlarge" type="text" size="40" name="data[User][firstname]" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Lastname</label>
						<div class="controls">
							<input class="input-xlarge" type="text" size="40" name="data[User][lastname]" />
						</div>
					</div>
					<div class="control-action">
						<button type="submit" class="btn btn-primary">Subscribe</button>
						<?php echo $this->Html->link('Back to Login','/'.(empty($is_admin)?'':'admin').'/login'); ?>
					</div>
				</fieldset>
			</form>
		</div>
	</div><!--/row-->
</div>