<div id="cms_Body">
<!--FORGET PASSWORD FORM-->
	<div id="cms_Main" class="isLoginForm">
		    <?php echo $this->Session->flash(); ?>
	    <?php echo $this->Session->flash('auth'); ?>

	<form>

		<h3>Forget Password</h3>
		<div>
			<label>E-mail Address</label>
			<input type="text" size="36">
		</div>
		<div>
			<input type="button" value="Send Me My Password">
			<input type="button" value="Cancel" class="isOff">

		</div>
	</form>
	</div>
	</div>