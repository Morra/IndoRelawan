<script type="text/javascript">
$(document).ready(function(){
	if($('div#cmsAlert').length > 0) {
		$('div#cmsAlert').removeClass('full');
		$('div#cmsAlert').removeClass('fl');
	}
});
</script>
<div class="login">
	<div class="header">
		<img src="<?php echo $imagePath; ?>images/logo.png" />
	</div>

	<div class="layout-header">
		<div class="sidebar-title">
			<h4>Forget Password</h4>
		</div>
	</div>

	<div class="layout-body">
		<div class="content">
			<?php
				 echo $form->create('Account', array('type'=>'file','inputDefaults' => array('label' =>false , 'div' => false)));
			?>
				<fieldset>
					<?php
						echo $this->Session->flash();
					?>
					<div class="control-group">
						<div class="controls">
							<?php echo $this->Form->input('email',array('label' => false, 'placeholder'=>'Email', 'class' => 'input-xlarge')); ?>
						</div>
					</div>
					<div class="control-action">
						<button type="submit" class="btn btn-primary">Reset Password</button>
						<?php echo $this->Html->link('Back to Login','/'.(empty($is_admin)?'':'admin').'/login'); ?>
					</div>
					<input type="hidden" value="<?php echo (empty($is_admin) ? 0 : 1); ?>" name="is_admin">
				</fieldset>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>