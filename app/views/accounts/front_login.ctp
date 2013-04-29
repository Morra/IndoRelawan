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
			<h4>LOGIN</h4>
		</div>
	</div>

	<div class="layout-body">
		<div class="content">
			<?php echo $this->Form->create('Account', array ('action'=>'login'), array('class' => 'form-horizontal'));?>
				<fieldset>
					<?php
						$status=$this->Session->flash('auth');
						if($status!==false):
					?>
					<div class="alert alert-error">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<?php echo $status; ?>
					</div>
					<?php endif; ?>
					<?php echo $this->Session->flash(); ?>

					<div class="control-group">
						<div class="controls">
							<?php echo $this->Form->input('email',array('label' => false, 'placeholder'=>'Email', 'class' => 'input-xlarge')); ?>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<?php echo $this->Form->input('password',array('label' => false, 'placeholder'=>'Password', 'class' => 'input-xlarge')); ?>
						</div>
					</div>
					<div class="control-action">
						<button type="submit" class="btn btn-primary">Login</button>
						<?php echo $this->Html->link('Forget password?',(empty($is_admin)?'':'/admin').'/forget'); ?>
					</div>
					<div class="control-action">
						<?php echo $this->Html->link('Register new account?', '/register'); ?>
					</div>
					<div class="control-action">
						<?php echo $this->Html->link('Subscribe as participant?', '/subscribe'); ?>
					</div>
					<input type="hidden" value="<?php echo (empty($is_admin) ? 0 : 1); ?>" name="is_admin">
<?php
	if (!empty($setting[22]['Setting']['value']) or !empty($setting[23]['Setting']['value'])) {
?>
					<div class="control-action" style="margin-top: 10px">
<?php
		if (!empty($setting[22]['Setting']['value'])) {
?>
						<button type="button" class="btn btn-primary fb_connect">Facebook Connect</button>
<?php
		}
		if (!empty($setting[23]['Setting']['value'])) {
?>
						<button type="button" class="btn btn-primary tw_connect" style="float: right">Twitter Connect</button>
<?php
		}
?>
					</div>
<?php
	}
?>
				</fieldset>
			<?php echo $this->Form->end(); ?>
		</div>
	</div><!--/row-->
</div>