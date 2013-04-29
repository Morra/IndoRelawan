<!--<div class="idrw-onecon ">
	<div class="idrw-onecon-title">
		<h2>PROFIL ORGANISASI</h2>
	</div>
	<div class="idrw-onecon-content container_16">
		<img src="http://dummyimage.com/920x1500/787878/fff.png&text=infographic" alt="dummy" style="margin-left: 2%;" />
		<div class="clear"></div>
	</div>
</div>

<div class="idrw-learnmore idrw-inline idrw-alc">
	<h1>Berminat Untuk Membantu Kami ?</h1>
	<a class="idrw-space-l idrw-btn idrw-btn-red" href="<?php echo $imagePath; ?>registration">Daftar Sekarang</a>
</div>-->


<div class="idrw-onecon ">
	<div class="idrw-onecon-title">
		<h1>BAGAIMANA CARA KERJA INDORELAWAN ?</h1>
	</div>
	<div class="idrw-onecon-content container_16">
		<div class="container_16">
			<div class="grid_8 idrw-alr idrw-lft">
				<h2 class="idrw-red">Untuk apa bekerja dengan sukarelawan?</h2>
				<p class="idrw-mb5">Membangun kemampuan organisasi dalam</p>
				<p class="idrw-mb5">melaksanakan misinya</p>
			</div>
			<div class="grid_8 idrw-all idrw-rgt">
				<h2 class="idrw-red">Untuk apa menjadi sukarelawan?</h2>
				<p class="idrw-mb5">Berbagi dan menjalankan</p>
				<p class="idrw-mb5">hidup lebih bermakna</p>
			</div>
			<div class="clear"></div>
		</div>
		<div>
		<div class="tentang_1">&nbsp;</div>
		<div class="tentang_2">&nbsp;</div>
		<div class="tentang_3">&nbsp;</div>
		<div class="tentang_4">&nbsp;</div>
		<div class="tentang_5">&nbsp;</div>
		<div class="tentang_6">&nbsp;</div>
		<div class="tentang_7">&nbsp;</div>
		<div class="tentang_8">&nbsp;</div>
		<center><img class="loader" src="<?php echo $imagePath; ?>images/ajax-loader.gif" /></center>
		<img class="idrw-infoimg" src="<?php echo $imagePath; ?>images/infographic.jpg" alt="Learn Indorelawan" />
		</div>
		<div class="idrw-infofoot idrw-alc">
			<div class="idrw-red">...<br />Mulai Aktivitas yang baru!</div>
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="idrw-learnmore idrw-inline idrw-alc">
	<span class="help">BERMINAT UNTUK MEMBANTU KAMI ?</span>
	<a class="idrw-space-l idrw-btn idrw-btn-red" href="<?php echo $imagePath; ?>registration">Daftar Sekarang</a>
</div>

<script>
$(".idrw-infoimg").hide();
var $dfd = $("body").imagesLoaded();
$dfd.always(function(){ 
	console.log('success');
	$(".loader").remove();
	$(".idrw-infoimg").show();
});
</script>