<?php $get->create($data); //dpr($data); ?>
<div class="idrw-onecon volunteers">
	<div class="idrw-onecon-title">
		<h2>PROFIL SUKARELAWAN</h2>
	</div>
	<div class="idrw-onecon-content container_16">
		<div class="grid_4">
			<div class="grid_1">&nbsp;</div>
			<div class="grid_14">
				<?php
				if($data['myEntry']['Entry']['main_image'] == 0)
				{
				?>
				<img src="<?php echo $imagePath.'images/volunteer.jpg'; ?>" alt="Ibeka" width="100%" />
				<?php		
				}
				else
				{
				?>
				<img src="<?php echo $imagePath.'img/upload/thumb/'.$data['myEntry']['Entry']['main_image'].'.'.$data['myImageTypeList'][$data['myEntry']['Entry']['main_image']]; ?>" alt="Lilyallen" />
				<?php
				}
				?>
			</div>
			
			<div class="clear"></div>
		</div>
		<div class="idrw-onecon-profile grid_10">
			<h1><?php echo $data['myEntry']['Entry']['title']; ?></h1>
			<?php
			foreach($data['myEntry']['EntryMeta'] as $meta)
			{
				if($meta['key'] == 'form-minat')
					$minat = $meta['value'];
				else if($meta['key'] == 'form-tinggal')
					$tinggal = $meta['value'];
				else if($meta['key'] == 'form-kerja')
					$kerja = $meta['value'];
				else if($meta['key'] == 'form-sekolah')
					$sekolah = $meta['value'];
				else if($meta['key'] == 'form-kualifikasi')
					$kualifikasi = $meta['value'];
				else if($meta['key'] == 'form-fokus')
					$fokus1 = $meta['value'];
				else if($meta['key'] == 'form-dapat_berkontribusi_dalam')
					$kontribusi1 = $meta['value'];
				else if($meta['key'] == 'form-partisipasi')
					$partisipasi1 = $meta['value'];
			}
			?>
			<!-- <div class="idrw-inline">
				 <strong>Memiliki Minat pada : </strong>
				<p><?php // if(isset($minat) and !empty($minat)) echo $minat; else echo '-'; ?></p> 
			</div> -->
			<!-- <div class="idrw-inline">
				<strong>Tinggal di : </strong>
				<p><?php // if(isset($tinggal) and !empty($tinggal)) echo $tinggal; else echo '-'; ?></p>
			</div> --> 
			<div class="idrw-inline">
				<strong>Kerja di : </strong>
				<p><?php if(isset($kerja) and !empty($kerja)) echo $kerja; else echo '-'; ?></p>
			</div>
			<div class="idrw-inline">
				<strong>Sekolah di : </strong>
				<p><?php if(isset($sekolah) and !empty($sekolah)) echo $sekolah; else echo '-'; ?></p>
			</div>
			<div class="idrw-inline">
				<strong>Fokus : </strong>
				<p><?php if(isset($fokus1) and !empty($fokus1)) echo $fokus1; else echo '-'; ?></p>
			</div>
			<div class="idrw-inline">
				<strong>Dapat berkontribusi dalam : </strong>
				<p><?php if(isset($kontribusi1) and !empty($kontribusi1)) echo $kontribusi1; else echo '-'; ?></p>
			</div>
			<div class="idrw-inline">
				<strong>Partisipasi : </strong>
				<p><?php if(isset($partisipasi1) and !empty($partisipasi1)) echo $partisipasi1; else echo '-'; ?></p>
			</div>
			 <!-- <div class="idrw-inline">
				<strong>Kualifikasi : </strong>
				<p><?php //  if(isset($kualifikasi) and !empty($kualifikasi)) echo $kualifikasi; else echo '-'; ?></p>
			</div> -->
			<div class="idrw-inline">
				<?php
				$argsActivities = array(
					"entry_type" => "activity-members",
					"parent_id" => 0,
					"created_by" => $data['myEntry']['Entry']['id'],
					"recursive" => 1,
					"offset" => null,
					"limit" => 3,
					"field_order" => "created",
					"order" => "DESC"
				);
				$activities = $get->count_total_activity($argsActivities);
				?>
				<!-- <strong>Total Aktivitas : </strong>
				<p><?php // echo count($activities); ?> Aktivitas</p> -->
			</div>
			<!-- <div class="idrw-inline">
				<strong>Total Jam : </strong>
				<p>0 Jam</p>
			</div> -->
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="idrw-onecon idrw-guttermin">
	<div class="idrw-onecon-title">
		<h2>AKTIVITAS OLEH SUKARELAWAN INI</h2>
	</div>
	<div class="idrw-onecon-content idrw-onecon-lactivity container_16">
	<?php
	foreach($activities as $activity)
	{
		$activityId = $get->meta_detail($activity['Entry']['id'],'activity-id');
		$argsDetailActivity = array(
			"entry_type" => "activities",
			"id" => $activityId,
			"recursive" => -1
		);
		$detailActivity = $get->entry_detail($argsDetailActivity);
	?>
	<div class="idrw-onecon-activity idrw-well grid_5 ad8">
		<?php
		if($detailActivity['Entry']['main_image'] == 0)
		{
		?>
		<a href="<?php echo $imagePath.$detailActivity['Entry']['entry_type'].'/'.$detailActivity['Entry']['slug']; ?>"><img src="<?php echo $imagePath.'images/organization.jpg'; ?>" alt="Rig" width="100%" /></a>
		<?php		
		}
		else
		{
		?>
		<a href="<?php echo $imagePath.$detailActivity['Entry']['entry_type'].'/'.$detailActivity['Entry']['slug']; ?>"><img src="<?php echo $imagePath.'img/upload/thumb/'.$detailActivity['Entry']['main_image'].'.'.$data['myImageTypeList'][$detailActivity['Entry']['main_image']]; ?>" alt="Rig" width="100%" /></a>
		<?php
		}
		?>
		<div class="idrw-onecon-activity-title">
			<h3><?php echo $detailActivity['Entry']['title']; ?></h3>
		</div>
		<?php
		$fokus = $get->meta_detail($detailActivity['Entry']['id'],'form-fokus');
		$jenis = $get->meta_detail($detailActivity['Entry']['id'],'form-jenis');
		$lokasi = $get->meta_detail($detailActivity['Entry']['id'],'form-lokasi');
		$waktu = $get->meta_detail($detailActivity['Entry']['id'],'form-waktu');
		$english_speaker = $get->meta_detail($detailActivity['Entry']['id'],'form-english_speaker');
		
		$namaLokasi = $get->meta_detail($detailActivity['Entry']['id'],'form-nama_lokasi');
		$jalan = $get->meta_detail($detailActivity['Entry']['id'],'form-jalan');
		$kelurahan = $get->meta_detail($detailActivity['Entry']['id'],'form-kelurahan');
		$kecamatan = $get->meta_detail($detailActivity['Entry']['id'],'form-kecamatan');
		$kabupaten = $get->meta_detail($detailActivity['Entry']['id'],'form-kabupaten_atau_kota');
		$kodepos = $get->meta_detail($detailActivity['Entry']['id'],'form-kode_pos');
		
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
			<div class="org2" data-url="<?php echo $site.$detailActivity['Entry']['entry_type'].'/'.$detailActivity['Entry']['slug']; ?>" data-text="<?php echo $detailActivity['Entry']['title']; ?>"></div>
		</div>
	</div>
	<?php
	}
	?>
	<div class="clear"></div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
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