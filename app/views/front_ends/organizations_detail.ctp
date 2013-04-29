<?php $get->create($data); //dpr($data); ?>
<?php
$argsActivities = array(
	"entry_type" => "activities",
	"parent_id" => 0,
	"recursive" => 1,
	"offset" => null,
	"limit" => 3,
	"field_order" => "created",
	"order" => "DESC",
	"key" => "organization-id",
	"value" => $data['myEntry']['Entry']['id']
);
$activities = $get->simple_list_entry_and_meta($argsActivities);
$volunteers = $get->volunteers_of_organization($data['myEntry']['Entry']['id']);
?>
<div class="idrw-onecon">
<div class="idrw-onecon-title">
	<h2>PROFIL ORGANISASI</h2>
</div>
<div class="idrw-onecon-content container_16">
	<div class="grid_5">
		<div class="grid_1">&nbsp;</div>
		<div class="idrw-onecon-left idrw-alc grid_14">
			<div class="idrw-inline">
				<?php
				if($data['myEntry']['Entry']['main_image'] == 0)
				{
				?>
				<img src="<?php echo $imagePath.'images/organization.jpg'; ?>" alt="Ibeka" width="100%" />
				<?php		
				}
				else
				{
				?>
				<img src="<?php echo $imagePath.'img/upload/'.$data['myEntry']['Entry']['main_image'].'.'.$data['myImageTypeList'][$data['myEntry']['Entry']['main_image']]; ?>" alt="Ibeka" width="100%" />
				<?php
				}
				?>
			</div>
			<?php
			foreach($data['myEntry']['EntryMeta'] as $orgMeta)
			{
				if($orgMeta['key'] == 'form-person_in_charge')
					$pic = $orgMeta['value'];
				else if($orgMeta['key'] == 'form-picture')
					$picture = $orgMeta['value'];
					
				if(!isset($pic)) $pic = '-';
				if(!isset($picture)) $picture = 1;
			}
			?>
			<?php
			if($pic != '-')
			{
			?>
			<div class="idrw-inline idrw-all">
				<h3 class="idrw-vtop">Penanggung Jawab</h3>
			</div>
			<div class="idrw-inline idrw-all">
				<?php
				if($picture == 0)
				{
				?>
				<img src="<?php echo $imagePath.'images/organization.jpg'; ?>" alt="Ibeka" width="72" />
				<?php		
				}
				else
				{
				?>
				<img src="<?php echo $imagePath.'img/upload/thumb/'.$picture.'.'.$data['myImageTypeList'][$picture]; ?>" alt="Lily Allen" width="72" />
				<?php
				}
				?>
				<h3 class="idrw-onecon-lefttitle idrw-vtop"><?php echo $pic; ?></h3>
			</div>
			<?php
			}
			?>
			<div class="idrw-inline idrw-all inf">
				<span class="idrw-vtop">Jumlah Aktivitas: <b><?php echo count($activities); ?></b></span>
			</div>
			<div class="idrw-inline idrw-all inf">
				<span class="idrw-vtop">Jumlah Sukarelawan: <b><?php echo count($volunteers); ?></b></span>
			</div>
			<br class="clear" />
			
		</div>
		<div class="grid_1">&nbsp;</div>
		<div class="clear"></div>
	</div>
	<div class="idrw-onecon-profile grid_11">
		<div class="rating">
			 <span class="star">&nbsp;</span><span class="star">&nbsp;</span><span class="star">&nbsp;</span><span class="star">&nbsp;</span><span class="star">&nbsp;</span>
		</div>
		
		<h1><?php echo strtoupper($data['myEntry']['Entry']['title']); ?></h1>
		<?php
		$fokus = $get->meta_detail($data['myEntry']['Entry']['id'],'form-fokus');
		$visi = $get->meta_detail($data['myEntry']['Entry']['id'],'form-visi');
		$misi = $get->meta_detail($data['myEntry']['Entry']['id'],'form-misi');
		?>
		<div class="idrw-titcon">
			<h3>Fokus :</h3>
			<p><?php echo $fokus; ?></p>
		</div>
		<div class="idrw-titcon">
			<h3>Visi :</h3>
			<p><?php echo $visi; ?></p>
		</div>
		<div class="idrw-titcon">
			<h3>Misi :</h3>
			<p><?php echo $misi; ?></p>
		</div>
	</div>
	
			<div class="idrw-onecon-trol idrw-alr idrw-lf">
				<a class="idrw-btn idrw-btn-gray" href="<?php echo $imagePath; ?>registration">Usul Aktivitas</a> 
				<a class="idrw-btn idrw-btn-red idrw-bt-m" href="#">Kontak Kami</a>
			</div>
			<div class="idrw-inline idrw-alr idrw-lf">
				<?php /* <a href="#"><img src="http://dummyimage.com/70x20/1589B8/fff.png&amp;text=share" alt="dummy"></a>
				<a href="#"><img src="http://dummyimage.com/70x20/1589B8/fff.png&amp;text=share" alt="dummy"></a> */ ?>
				<div id="org1" data-url="<?php echo $site.$this->params['url']['url']; ?>" data-text="<?php echo $data['myEntry']['Entry']['title']; ?>">
				<span class="mobile"><a href="#">&nbsp;</a></span></div>
			</div>
	<div class="clear"></div>
</div>
</div>

<div class="idrw-onecon idrw-guttermin">
<div class="idrw-onecon-title">
	<h2>AKTIVITAS OLEH ORGANISASI INI</h2>
</div>
<div class="idrw-onecon-content idrw-onecon-lactivity container_16">
	<?php
	foreach($activities as $activity)
	{
	?>
	<div class="idrw-onecon-activity idrw-well grid_5">
		<?php
		if($activity['Entry']['main_image'] == 0)
		{
		?>
		<a href="<?php echo $imagePath.$activity['Entry']['entry_type'].'/'.$activity['Entry']['slug']; ?>"><img src="<?php echo $imagePath.'images/organization.jpg'; ?>" alt="Rig" width="100%" /></a>
		<?php		
		}
		else
		{
		?>
		<a href="<?php echo $imagePath.$activity['Entry']['entry_type'].'/'.$activity['Entry']['slug']; ?>"><img src="<?php echo $imagePath.'img/upload/thumb/'.$activity['Entry']['main_image'].'.'.$data['myImageTypeList'][$activity['Entry']['main_image']]; ?>" alt="Rig" width="100%" /></a>
		<?php
		}
		?>
		<div class="idrw-onecon-activity-title">
			<h3><?php echo $activity['Entry']['title']; ?></h3>
		</div>
		<?php
		$fokus = $get->meta_detail($activity['Entry']['id'],'form-fokus');
		$jenis = $get->meta_detail($activity['Entry']['id'],'form-jenis');
		$lokasi = $get->meta_detail($activity['Entry']['id'],'form-lokasi');
		$waktu = $get->meta_detail($activity['Entry']['id'],'form-waktu');
		$english_speaker = $get->meta_detail($activity['Entry']['id'],'form-english_speaker');
		
		$namaLokasi = $get->meta_detail($activity['Entry']['id'],'form-nama_lokasi');
		$jalan = $get->meta_detail($activity['Entry']['id'],'form-jalan');
		$kelurahan = $get->meta_detail($activity['Entry']['id'],'form-kelurahan');
		$kecamatan = $get->meta_detail($activity['Entry']['id'],'form-kecamatan');
		$kabupaten = $get->meta_detail($activity['Entry']['id'],'form-kabupaten_atau_kota');
		$kodepos = $get->meta_detail($activity['Entry']['id'],'form-kode_pos');
		
		if(empty($namaLokasi))
			$namaLokasi = '';
		if(empty($jalan))
			$jalan = '';
		if(empty($kelurahan))
			$kelurahan = '';
		if(empty($kecamatan))
			$kecamatan = '';
		if(empty($kabupaten))
			$kabupaten = '';
		if(empty($kodepos))
			$kodepos = '';
			
		$arrLokasi = array($namaLokasi,$jalan,$kelurahan,$kecamatan,$kabupaten,$kodepos);
		$finalLokasi = '';
		foreach($arrLokasi as $index => $al)
		{
			if($al[$index] != '')
			{
				if($index == count($arrLokasi)-1)
					$finalLokasi = $finalLokasi.$al;
				else
					$finalLokasi = $finalLokasi.$al.', ';
			}
		}
		?>
		<div class="idrw-onecon-trol">
			<p><b>Fokus: </b></p>
			<p><?php if(!empty($fokus)) echo $fokus; else echo '-'; ?></p>
		</div>
		<div class="idrw-onecon-trol">
			<p><b>Jenis: </b></p>
			<p><?php if(!empty($jenis)) echo $jenis; else echo '-'; ?></p>
		</div>
		<div class="idrw-onecon-trol">
			<p><b>Lokasi:</b> </p>
			<p><?php if(!empty($finalLokasi)) echo $finalLokasi; else echo '-'; ?></p>
		</div>
		<div class="idrw-onecon-trol">
			<p><b>Waktu:</b> </p>
			<p><?php if(!empty($waktu)) echo $waktu; else echo '-'; ?></p>
		</div>
		<div class="idrw-onecon-trol">
			<p><b>English Speaker:</b> </p>
			<p><?php if(!empty($english_speaker)) echo $english_speaker; else echo '-'; ?></p>
		</div>
		<div class="idrw-onecon-trol">
			<p>&nbsp;</p>
		</div>
		<div class="idrw-onecon-trol idrw-alr">
			<a class="idrw-btn idrw-btn-red" href="<?php echo $imagePath; ?>registration">Jadi Indorelawan</a>
		</div>
		<div class="idrw-inline idrw-alr">
			<?php /* <a href="#"><img src="http://dummyimage.com/70x20/1589B8/fff.png&amp;text=share" alt="dummy"></a>
			<a href="#"><img src="http://dummyimage.com/70x20/1589B8/fff.png&amp;text=share" alt="dummy"></a> */ ?>
			<div class="org2" data-url="<?php echo $site.$activity['Entry']['entry_type'].'/'.$activity['Entry']['slug']; ?>" data-text="<?php echo $activity['Entry']['title']; ?>"></div>
		</div>
	</div>
	<?php
	}
	?>
	<div class="clear"></div>
</div>
</div>

<div class="idrw-onecon idrw-guttermin">
	<div class="idrw-onecon-title">
		<h2>SUKARELAWAN DI ORGANISASI INI</h2>
	</div>
	
	<div class="idrw-onecon-content container_16 skrw">
		
<?php
$cnt = 1;
$total = count($volunteers);
foreach($volunteers as $index => $volunteer)
{
	$argsDetail = array(
		"id" => $volunteer,
		"entry_type" => "volunteers",
		"recursive" => -1
	);
	$detail = $get->entry_detail($argsDetail);
	$kerja = $get->meta_detail($detail['Entry']['id'],'form-kerja');
?>
		<div class="idrw-inline idrw-ib grid_5">
			<?php
			if($detail['Entry']['main_image'] == 0)
			{
			?>
			<a href="<?php echo $imagePath.$detail['Entry']['entry_type'].'/'.$detail['Entry']['slug']; ?>"><img class="idrw-vtop" src="<?php echo $imagePath.'images/volunteer.jpg'; ?>" alt="Lily Allen" width="80" /></a>
			<?php		
			}
			else
			{
			?>
			<a href="<?php echo $imagePath.$detail['Entry']['entry_type'].'/'.$detail['Entry']['slug']; ?>"><img class="idrw-vtop" src="<?php echo $imagePath.'img/upload/thumb/'.$detail['Entry']['main_image'].'.'.$data['myImageTypeList'][$detail['Entry']['main_image']]; ?>" alt="Lily Allen" width="80" /></a>
			<?php
			}
			?>
			<div class="idrw-onecon-procon idrw-vtop">
				<h3><?php echo $detail['Entry']['title']; ?></h3>
				<a href="#"><?php if(!empty($kerja)) echo $kerja; else echo '-'; ?></a>
			</div>
		</div>
<?php
	if ($cnt % 3 == 0 and $cnt < $total) {
?>
	</div>
	<div class="idrw-onecon-content container_16">
<?php
	}
	$cnt ++;
}
?>
		<div class="clear"></div>
	</div>
	
	<?php /*
	<div class="idrw-onecon-content container_16">
		<div class="grid_1">&nbsp;</div>
		<div class="idrw-inline idrw-ib grid_5">
			<img class="idrw-vtop" src="<?php echo $imagePath; ?>images/lilyallen.png" alt="Lily Allen" width="64" />
			<div class="idrw-onecon-procon idrw-vtop">
				<h3>Lily James Allen</h3>
				<a href="#">BP Indonesia, Indonesia</a>
			</div>
		</div>
		<div class="idrw-inline idrw-ib grid_5">
			<img class="idrw-vtop" src="<?php echo $imagePath; ?>images/lilyallen.png" alt="Lily Allen" width="64" />
			<div class="idrw-onecon-procon idrw-vtop">
				<h3>Lily James Allen</h3>
				<a href="#">BP Indonesia, Indonesia</a>
			</div>
		</div>
		<div class="idrw-inline idrw-ib grid5">
			<img class="idrw-vtop" src="<?php echo $imagePath; ?>images/lilyallen.png" alt="Lily Allen" width="64" />
			<div class="idrw-onecon-procon idrw-vtop">
				<h3>Lily James Allen</h3>
				<a href="#">BP Indonesia, Indonesia</a>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="idrw-onecon-content container_16">
		<div class="grid_1">&nbsp;</div>
		<div class="idrw-inline idrw-ib grid_5">
			<img class="idrw-vtop" src="<?php echo $imagePath; ?>images/lilyallen.png" alt="Lily Allen" width="80" />
			<div class="idrw-onecon-procon idrw-vtop">
				<h3>Lily James Allen</h3>
				<a href="#">BP Indonesia, Indonesia</a>
			</div>
		</div>
		<div class="idrw-inline idrw-ib grid_5">
			<img class="idrw-vtop" src="<?php echo $imagePath; ?>images/lilyallen.png" alt="Lily Allen" width="80" />
			<div class="idrw-onecon-procon idrw-vtop">
				<h3>Lily James Allen</h3>
				<a href="#">BP Indonesia, Indonesia</a>
			</div>
		</div>
		<div class="idrw-inline idrw-ib grid5">
			<img class="idrw-vtop" src="<?php echo $imagePath; ?>images/lilyallen.png" alt="Lily Allen" width="80" />
			<div class="idrw-onecon-procon idrw-vtop">
				<h3>Lily James Allen</h3>
				<a href="#">BP Indonesia, Indonesia</a>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	*/ ?>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#org1").sharrre({
			share: {
				facebook: true,
				twitter: true
			},
			enableHover: false,
			enableCounter: false,
			enableTracking: true,
			buttons: {
				facebook: {layout: 'button_count', count: 'horizontal'},
				twitter: {count: 'horizontal', via: '_JulienH'}
			}
		});
		
		$(".org2").sharrre({
			share: {
				facebook: true,
				twitter: true
			},
			enableHover: false,
			enableCounter: false,
			enableTracking: true,
			buttons: {
				facebook: {layout: 'button_count', count: 'horizontal'},
				twitter: {count: 'horizontal'}
			}
		});
	});
</script>