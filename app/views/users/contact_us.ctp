<?php
	echo $this->Html->script('contact',false);
?>

<!-- Page: Contacts -->
<div class="">
	
	<!-- Left Column -->
	<div class="mr_LeftColumn">
	
		<!-- Heading Block -->
		<div class="mr_Block adjustBlockBG">
			<h1><?php echo $atribut['Page Heading'] ?></h1>
			<?php echo $content; ?>
			<ul id="mr_SocMedList" class="isLarge">
				<li class="isFacebook"><a href="http://www.facebook.com/pages/Hello-Morra/153783458055914" target="_blank">Like us</a></li>
				<li class="isTwitter"><a href="http://twitter.com/hellomorra" target="_blank">Follow us</a></li>
			</ul>
			<div class="clearFix"></div>
		</div>	
	</div>

	<!-- Right Column -->
	<div class="mr_RightColumn">
	
		<!-- Block -->
		<div class="mr_Block adjustBG byEmail">
			<h5 class="isLast"><a href="mailto:hello@morrastudio.com">hello@morrastudio.com</a></h5>
		</div>
		
		<!-- Block -->
		<div class="mr_Block adjustBG byPhone">
			<h4 class="isLast">+62 031.561.5620</h4>
		</div>
		
		<!-- Block -->
		<div class="mr_Block adjustBG byPostal">
			<p class="isLast">Pandegiling 209, Second Floor<br/>Surabaya, East Java, Indonesia</p>
		</div>
		
		<!-- Block -->
		<div id="mr_Form" class="mr_Block adjustBG theForm">
			<?php echo $this->Form->create('User',array('action'=>'sendmail')); ?>
				<input name="data[contact][page_id]" type="hidden" value="<?php echo $id; ?>">
				<div><label>Name</label><input name="data[contact][name]" type="text" size="24" id="name"></div>
				<div><label>E-mail</label><input name="data[contact][email]" type="text" size="24" id="email"></div>
				<div><label>Subject</label><input name="data[contact][subject]" type="text" size="24" id="subject"></div>
				<textarea name="data[contact][body]" rows="5"></textarea>
				<input type="image" src="<?php echo Router::url("/"); ?>img/icon/send_button.png" class="mr_SendButton">
				
				<span class="error" style="display:none"> Please Enter Valid Data</span>
				<span class="success" style="display:none"> Sent Successfully</span>
				
				<div class="clearFix"></div>
			<?php echo $this->Form->end(); ?>
		</div>

	</div>
	<div class="clearFix"></div>
	
</div>