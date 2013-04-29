<?php
$description = $data['myEntry']['Entry']['description'];
$description = explode("<!-- separate -->",$description = $data['myEntry']['Entry']['description']);
?>
<div class="idrw-onecon rgstr">
	<div class="idrw-orgpro">
		<?php echo $description[0]; ?>
	</div>
</div>

<div class="idrw-onecon idrw-guttermin rgstr">
	<div class="idrw-orgpro">
		<?php
		if(isset($_SESSION['register']))
		{
		?>
		<h3 class="idrw-no-m">
			<span class="idrw-red"><?php echo $_SESSION['register']; ?></span>
		</h3>
		<?php
			unset($_SESSION['register']);
		}
		else
		{
		?>
		<?php echo $description[1]; ?>
		<form action="<?php echo $imagePath; ?>ajax_send_organization" method="POST" class="idrw-form">
			<div class="idrw-formcon">
				<label class="idrw-formcon-tit"><b>Anda adalah :</b></label>
				<div class="idrw-formcon-xob">
					<div class="idrw-inline">
						<div class="idrw-customcheck">
							<input type="radio" value="Organisasi" id="idrw-customcheck" name="data[Organization][check1]" checked>
							<label for="idrw-customcheck"></label>
						</div>
						<h4>Organisasi</h4>
					</div>
				</div>
				<div class="idrw-formcon-xob">
					<div class="idrw-inline">
						<div class="idrw-customcheck">
							<input type="radio" value="Sukarelawan" id="idrw-customcheck2" name="data[Organization][check1]">
							<label for="idrw-customcheck2"></label>
						</div>
						<h4>Sukarelawan</h4>
					</div>
				</div>
			</div>
			<div class="idrw-formcon">
				<label class="idrw-formcon-tit">Alamat Email</label>
				<div class="idrw-formcon-xob">
					<input type="text" placeholder="" name="data[Organization][email]" id="email" />
				</div>
			</div>
			<div class="idrw-flr">
				<a id="btn-daftar" class="idrw-btn idrw-btn-red" href="#">Daftar</a>
			</div>
			<div class="idrw-formcon">
				<label class="idrw-formcon-tit">Nama</label>
				<div class="idrw-formcon-xob">
					<input type="text" placeholder="" name="data[Organization][name]" id="name" />
				</div>
			</div>
			<div class="idrw-formcon auto-hide">
				<label class="idrw-formcon-tit"></label>
				<div class="idrw-formcon-xob" id="response">
					
				</div>
			</div>
		</form>
		<?php
		}
		?>
	</div>
</div>

<div class="idrw-onecon idrw-guttermin rgstr">
	<div class="idrw-orgpro">
		<?php echo $description[2]; ?>
	</div>
	<div class="idrw-brgh">
		<a class="idrw-brgh-child idrw-inline" href="mailto:someone@example.com?Subject=Indorelawan">
			<span class="idrw-brgh-img idrw-brgh-envelope"></span>
			<h4>Email Teman Anda</h4>
		</a>
	</div>
	<div class="idrw-brgh" id="fb-share">
		<a class="idrw-brgh-child idrw-inline" href="#">
			<span class="idrw-brgh-img idrw-brgh-fb"></span>
			<h4>Update Status Facebook</h4>
		</a>
	</div>
	<div class="idrw-brgh" id="twitter-share">
		<a class="idrw-brgh-child idrw-inline" href="http://twitter.com/intent/tweet?text=@Indorelawan%20" target="_blank">
			<span class="idrw-brgh-img idrw-brgh-tw"></span>
			<h4>Tweet Indorelawan</h4>
		</a>
	</div>
	<div class="clear"></div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#btn-daftar").on("click", function(event){
			var email = $("#email").val();
			var name = $("#name").val();
			var checkEmail = !email.match(/^([a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,4}$)/i);
			
			if(checkEmail == true || name == "")
			{
				event.preventDefault();
				$(".auto-hide").fadeIn();
				$("#response").html("* Pendaftaran gagal! Ada kesalahan pengisian.");
			}
			else
			{
				var action = $(".idrw-form").attr("action");
				var form = $(".idrw-form").serialize();
				$("#response").html("<img src='"+site+'images/loader.gif'+"'>");
				$.post(action, form, function(data) {
					$("#response").html(data);
					$("input").val("");
				});
			}
		});
		
		$("#fb-share").on("click", function(event){
			event.preventDefault();
			fb_share("Indorelawan", "http://indorelawan.org", "");
		});
		
		function fb_share(title, url, summary)
		{
			window.open('http://www.facebook.com/sharer.php?s=100&amp;p%5btitle%5d='+title+'&amp;p%5bsummary%5d='+summary+'&amp;p%5burl%5d='+url, 'sharer', 'toolbar=0,status=0,width=548,height=325', '_blank');
		}
	});
</script>