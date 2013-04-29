<?php $get->create($data); //dpr($data); ?>
<div class="idrw-headline">
	<div class="idrw-headline-top">
		<img class="idrw-trans" src="<?php echo $imagePath; ?>img/upload/<?php echo $data['myEntry']['Entry']['main_image'].'.'.$data['myImageTypeList'][$data['myEntry']['Entry']['main_image']]; ?>" alt="Headline" />
		<div class="idrw-headline-util">
			<h2>Luangkan waktu anda sejenak untuk membantu anak jalanan</h2>
			<div class="idrw-inline">
				<a class="idrw-btn idrw-btn-red" href="#">Cari Aktivitas</a>
				<a class="idrw-btn" href="<?php echo $imagePath; ?>tentang-kami">Apa itu Indorelawan ?</a>
			</div>
		</div>
	</div>
	<div class="idrw-headline-btm container_16">
		<?php echo $data['myEntry']['Entry']['description']; ?>
		<div class="clear"></div>
	</div>
</div>

<div class="idrw-idcon">
	<div class="container_16">
		<div class="idrw-idcon-head idrw-inline grid_8 first_title">
			<img class="idrw-vtop" src="<?php echo $imagePath; ?>images/icon-man.png" alt="Sukarelawan" />
			<h2 class="idrw-vbtm">Sukarelawan</h2>
		</div>
		<div class="idrw-idcon-head idrw-inline grid_8 last_title">
			<img class="idrw-vtop" src="<?php echo $imagePath; ?>images/icon-home.png" alt="Organisasi" />
			<h2 class="idrw-vbtm">Organisasi</h2>
		</div>
		<div class="clear"></div>
	</div>
	
	<?php
	$argsFeatured = array(
		"entry_type" => "activity-members",
		"parent_id" => 0,
		"recursive" => -1,
		"offset" => null,
		"limit" => 1,
		"field_order" => "sort_order",
		"order" => "DESC"
	);
	$featured = $get->featured($argsFeatured);
	?>
	<?php
	foreach($featured as $feat)
	{
		$activityId = $get->meta_detail($feat['Entry']['id'],'activity-id');
		$argsDetailActivity = array(
			"entry_type" => "activities",
			"id" => $activityId,
			"recursive" => -1
		);
		$detailActivity = $get->entry_detail($argsDetailActivity);
		
		$detailActivityLocation = $get->meta_detail($detailActivity['Entry']['id'],'form-lokasi');
		$detailActivityJenis = $get->meta_detail($detailActivity['Entry']['id'],'form-jenis');
		
		$organizationId = $get->meta_detail($detailActivity['Entry']['id'],'organization-id');
		$argsDetailOrg = array(
			"entry_type" => "organizations",
			"id" => $organizationId,
			"recursive" => -1
		);
		$detailOrg = $get->entry_detail($argsDetailOrg);
		
		$argsDetailVolunteer = array(
			"entry_type" => "volunteers",
			"id" => $feat['Entry']['created_by'],
			"recursive" => -1
		);
		$detailVolunteer = $get->entry_detail($argsDetailVolunteer);
		$detailActivityKerja = $get->meta_detail($detailVolunteer['Entry']['id'],'form-kerja');
	?>
	<div class="idrw-idcon-row container_16 featured" rel="<?php echo $feat['Entry']['slug']; ?>">
		<div class="idrw-idcon-box grid_8 first">
			<div class="idrw-idcon-boxse idrw-bgred container_16">
				<div class="grid_1">&nbsp;</div>
				<div class="idrw-idcon-boxtil grid_14">
					<blockquote class="idrw-idcon-box-quo">
						<p><?php echo strip_tags($feat['Entry']['description']); ?></p>
					</blockquote>
					<div class="idrw-idcon-box-said">
						<p class="bold"><a class="idrw-proa idrw-trans" href="<?php echo $imagePath.$detailVolunteer['Entry']['entry_type'].'/'.$detailVolunteer['Entry']['slug']; ?>"><?php echo $detailVolunteer['Entry']['title']; ?></a></p>
						<p><?php echo $detailActivityKerja; ?></p>
						<p>dengan <span class="idrw-red"><a class="idrw-orga idrw-trans" href="<?php echo $imagePath.$detailOrg['Entry']['entry_type'].'/'.$detailOrg['Entry']['slug']; ?>"><?php echo $detailOrg['Entry']['title']; ?></a></span></p>
					</div>
				</div>
				<div class="grid_1">&nbsp;</div>
			</div>
			<div class="idrw-idcon-boxse-poin"></div>
			<div class="idrw-idcon-boximgwr">
				<?php
				if($feat['Entry']['main_image'] == 0)
				{
				?>
				<a href="<?php echo $imagePath.$detailVolunteer['Entry']['entry_type'].'/'.$detailVolunteer['Entry']['slug']; ?>"><img class="idrw-trans" src="<?php echo $imagePath.'images/volunteer.jpg'; ?>" alt="PLTMH" /></a>
				<?php		
				}
				else
				{
				?>
				<a href="<?php echo $imagePath.$detailVolunteer['Entry']['entry_type'].'/'.$detailVolunteer['Entry']['slug']; ?>"><img class="idrw-trans" src="<?php echo $imagePath.'img/upload/'.$feat['Entry']['main_image'].'.'.$data['myImageTypeList'][$feat['Entry']['main_image']]; ?>" alt="PLTMH" /></a>
				<?php
				}
				?>
			</div>
		</div> 						
		<div class="idrw-idcon-box grid_8 last">
			<div class="idrw-idcon-boxse idrw-bgred container_16">
				<div class="grid_1">&nbsp;</div>
				<div class="idrw-idcon-boxtil grid_14">
					<h3 class="idrw-trans"><a href="<?php echo $imagePath.$detailActivity['Entry']['entry_type'].'/'.$detailActivity['Entry']['slug']; ?>"><?php echo $detailOrg['Entry']['title']; ?></a></h3>
					<p class="idrw-idcon-boxtil-for"><span class="idrw-red idrw-trans"><a class="idrw-orga idrw-trans" href="<?php echo $imagePath.$detailOrg['Entry']['entry_type'].'/'.$detailOrg['Entry']['slug']; ?>"><?php echo strtoupper($detailActivity['Entry']['title']); ?></a></span></p>
					<?php
					if(!empty($detailActivityLocation) and !empty($detailActivityJenis))
						$sub = $detailOrg['Entry']['title'].' | '.$detailActivityLocation.' | '.$detailActivityJenis;
					else
						$sub = "";
					?>
					<p class="idrw-idcon-boxtil-location"><?php echo $sub; ?></p>
				</div>
				<div class="grid_1">&nbsp;</div>
			</div>
			<div class="idrw-idcon-boxse-poin"></div>
			<div class="idrw-idcon-boximgwr">
				<?php
				if($detailActivity['Entry']['main_image'] == 0)
				{
				?>
				<a href="<?php echo $imagePath.$detailActivity['Entry']['entry_type'].'/'.$detailActivity['Entry']['slug']; ?>"><img class="idrw-trans" src="<?php echo $imagePath.'images/organization.jpg'; ?>" alt="PLTMH" /></a>
				<?php		
				}
				else
				{
				?>
				<a href="<?php echo $imagePath.$detailActivity['Entry']['entry_type'].'/'.$detailActivity['Entry']['slug']; ?>"><img class="idrw-trans" src="<?php echo $imagePath.'img/upload/'.$detailActivity['Entry']['main_image'].'.'.$data['myImageTypeList'][$detailActivity['Entry']['main_image']]; ?>" alt="PLTMH" /></a>
				<?php
				}
				?>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<?php
	}
	?>
	<center id="loader"><img src="<?php echo $imagePath; ?>images/ajax-loader.gif"></center>
	<div class="idrw-idcon-row idrw-idcon-thanks container_16 thanks">
		<div class="idrw-idcon-thank grid_8">
			THANK YOU.
		</div>
		<div class="idrw-idcon-thankdesc grid_8">
			<p><img src="<?php echo $imagePath; ?>images/idrw-logo.png" alt="dummy" width="96" /> tidak akan dapat terealisasikan tanpa dukungan dari orang-orang luar biasa ini:</p>
			<p><strong>ANGEL INVESTORS:</strong> OCBC NISP, Karadi Hamam, Suradi Hamam, Yayasan Pendidikan Mandiri, Nico Krisnanto</p>
			<p class="idrw-idcon-thankdesc-vol"><strong>VOLUNTEERS AND INDIVIDUAL CONTRIBUTORS :</strong></p>
			<p>Andi Taufan, Asep Iwan Gunawan, Arie Satria, Astrid Felicia, Bagus Satria, Christina Messakh, Diana Baely, Eric Dinardi, Freddy Ang, Ika Krisnadi, I G Ngurah Satria Kusu, Jurist Tan, Lusy Yulianti, Ricky Sugiarto, Ridwan Permana,Suahasil Nazara, Shana Fatina, Slamet Kurniawan, Widya Wirawan</p>
		</div>
		<div class="clear"></div>
	</div>
	
</div>
<script type="text/javascript">
$(document).ready(function()
{	
	<?php
	$argsFeaturedFirst = array(
		"entry_type" => "activity-members",
		"parent_id" => 0,
		"recursive" => -1,
		"offset" => null,
		"limit" => 1,
		"field_order" => "sort_order",
		"order" => "ASC"
	);
	$featuredFirst = $get->first_featured($argsFeaturedFirst);
	?>
	
	$("#loader").hide();
	var first = "<?php echo $featuredFirst['Entry']['slug']; ?>";
	
	function lastPostFunc() 
	{ 
		var lastFeatured = $(".featured").last().attr("rel");
		if(lastFeatured != first)
		{
			if(killAjax == false)
			{
				killAjax = true;
				$("#loader").show();
				$.post(site+"entries/ajax_load_more", { lastFeatured: lastFeatured },
					function(data){
						// $(".thanks").before(data);
						$("#loader").before(data);
						$("#loader").hide();
						killAjax = false;
				});
			}
		}
	};  
	
	var killAjax = false;
	$(window).scroll(function(){
		
		if  ($(window).scrollTop() == $(document).height() - $(window).height()){
			lastPostFunc();
		}
	}); 	
});
</script>