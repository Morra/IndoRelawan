<?php $get->create($data); //dpr($this->params); ?>
<div class="idrw-onecon">
	<div class="idrw-orgpro idrw-block idrw-alc container_16">
		<h1><?php echo $data['myEntry']['Entry']['title']; ?></h1>
		<?php
		$subtitle = $get->meta_detail($data['myEntry']['Entry']['id'],'form-sub_title');
		?>
		<h3><?php echo $subtitle; ?></h3>
		<div class="grid_8">
			<ul class="bxslider">
				<?php
				if(count($data['myEntry']['ChildEntry']) > 1)
				{
					foreach($data['myEntry']['ChildEntry'] as $gallery)
					{
					?>
					<li><img src="<?php echo $imagePath.'img/upload/'.$gallery['Entry']['main_image'].'.'.$data['myImageTypeList'][$gallery['Entry']['main_image']]; ?>" alt="Jumbo Shell" width="440" /></li>
					<?php
					}
				}
				?>
			</ul>
		</div>
		<div class="idrw-all grid_8 lft-1">
			<?php echo $data['myEntry']['Entry']['description']; ?>
			<div class="idrw-org-pro-spacer2"></div>
			
			
			
			<div class="idrw-inline idrw-alr">
				<small>Bantu sebarkan aktivitas Ini :</small>
				<?php /* <a href="#"><img src="http://dummyimage.com/70x20/1589B8/fff.png&amp;text=share" alt="dummy"></a>
				<a href="#"><img src="http://dummyimage.com/70x20/1589B8/fff.png&amp;text=share" alt="dummy"></a> */ ?>
				<div id="act1" class="actv" data-url="<?php echo $site.$this->params['url']['url']; ?>" data-text="<?php echo $data['myEntry']['Entry']['title']; ?>"></div>
			</div>
			<br class="clear" />
			<div class="idrw-block idrw-alr idrw-bt-m">
				<a class="idrw-btn idrw-btn-red" href="<?php echo $imagePath; ?>registration">JADI INDORELAWAN</a>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="container_16">
	<div class="grid_11 alpha">
		<div class="idrw-onecon idrw-guttermin">
			<div class="idrw-onecon-title">
				<h2>RINCIAN AKTIVITAS</h2>
			</div>
			<div class="idrw-onecon-content idrw-orgpro-far container_16">
				<?php
				foreach($data['myEntry']['EntryMeta'] as $detail)
				{
					if($detail['key'] == 'form-jenis')
						$jenis = $detail['value'];
					else if($detail['key'] == 'form-fokus')
						$fokus = $detail['value'];
					else if($detail['key'] == 'form-hari_atau_tanggal')
						$waktu = $detail['value'];
					else if($detail['key'] == 'form-jam')
						$durasi = $detail['value'];
					else if($detail['key'] == 'form-penanggung_jawab')
						$penanggung_jawab = $detail['value'];
					else if($detail['key'] == 'form-batasan_usia')
						$batasan_usia = $detail['value'];
					else if($detail['key'] == 'form-english_speaker')
						$english_speaker = $detail['value'];
					else if($detail['key'] == 'form-kualifikasi_khusus_sukarelawan')
						$kualifikasi_khusus_sukarelawan = $detail['value'];
					else if($detail['key'] == 'form-perlu_disiapkan')
						$perlu_disiapkan = $detail['value'];
					else if($detail['key'] == 'form-organization_id')
						$orgId = $detail['value'];
					else if($detail['key'] == 'form-nama_lokasi')
						$namaLokasi = $detail['value'];
					else if($detail['key'] == 'form-jalan')
						$jalan = $detail['value'];
					else if($detail['key'] == 'form-kelurahan')
						$kelurahan = $detail['value'];
					else if($detail['key'] == 'form-kecamatan')
						$kecamatan = $detail['value'];
					else if($detail['key'] == 'form-kabupaten_atau_kota')
						$kabupaten = $detail['value'];
					else if($detail['key'] == 'form-kode_pos')
						$kodepos = $detail['value'];
					
				}
				
				if(!isset($namaLokasi))
					$namaLokasi = '';
				if(!isset($jalan))
					$jalan = '';
				if(!isset($kelurahan))
					$kelurahan = '';
				if(!isset($kecamatan))
					$kecamatan = '';
				if(!isset($kabupaten))
					$kabupaten = '';
				if(!isset($kodepos))
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
				 <div class="grid_8">
					<div class="idrw-titcon">
						<h3>Jenis:</h3>
						<p><?php if(isset($jenis) and !empty($jenis)) echo $jenis; else echo '-'; ?></p>
					</div>
					<div class="idrw-titcon">
						<h3>Fokus:</h3>
						<p><?php if(isset($fokus) and !empty($fokus)) echo $fokus; else echo '-'; ?></p>
					</div>
					<div class="idrw-titcon">
						<h3>Lokasi:</h3>
						<p><?php if(isset($finalLokasi) and !empty($finalLokasi)) echo $finalLokasi; else echo '-'; ?></p>
					</div>
					<div class="idrw-titcon">
						<h3>Hari/Tanggal:</h3>
						<p><?php if(isset($waktu) and !empty($waktu)) echo $waktu; else echo '-'; ?></p>
					</div>
					<div class="idrw-titcon">
						<h3>Jam:</h3>
						<p><?php if(isset($durasi) and !empty($durasi)) echo $durasi; else echo '-'; ?></p>
					</div>
					<div class="idrw-titcon">
						<h3>Penanggung Jawab:</h3>
						<p><?php if(isset($penanggung_jawab) and !empty($penanggung_jawab)) echo $penanggung_jawab; else echo '-'; ?></p>
					</div>
				 </div>
				 <div class="grid_8">
					<div class="idrw-titcon">
						<h3>Batasan Usia:</h3>
						<p><?php if(isset($batasan_usia) and !empty($batasan_usia)) echo $batasan_usia; else echo '-'; ?></p>
					</div>
					<div class="idrw-titcon">
						<h3>Cocok untuk English Speaker:</h3>
						<p><?php if(isset($english_speaker) and !empty($english_speaker)) echo $english_speaker; else echo '-'; ?></p>
					</div>
					<div class="idrw-titcon">
						<h3>Kualifikasi khusus Sukarelawan:</h3>
						<p><?php if(isset($kualifikasi_khusus_sukarelawan) and !empty($kualifikasi_khusus_sukarelawan)) echo $kualifikasi_khusus_sukarelawan; else echo '-'; ?></p>
					</div>
					<div class="idrw-titcon">
						<h3>Perlu Disiapkan:</h3>
						<p><?php if(isset($perlu_disiapkan) and !empty($perlu_disiapkan)) echo $perlu_disiapkan; else echo '-'; ?></p>
					</div>
					<div class="idrw-inline idrw-mt60">
						<a class="idrw-btn idrw-btn-red" href="<?php echo $imagePath; ?>registration">Jadi Indorelawan</a>
					</div>
				 </div>
				 <div class="clear"></div>
			</div>
		</div>
	</div>
	<div class="grid_5 omega idrw-orgpro-gr5">
		<div class="idrw-onecon idrw-guttermin">
			<div class="idrw-onecon-title">
				<h2>ORGANISASI</h2>
			</div>
			<div class="idrw-onecon-content idrw-orgpro-shr">
				<?php
				$argsOrganizations = array(
					"entry_type" => "organizations",
					"id" => $orgId,
					"recursive" => 1
				);
				$organizations = $get->entry_detail($argsOrganizations);
				
				foreach($organizations['EntryMeta'] as $organization)
				{
					if($organization['key'] == 'form-person_in_charge')
						$pic = $organization['value'];
					else if($organization['key'] == 'form-picture')
						$picture = $organization['value'];
					
					if(!isset($pic) or empty($pic)) $pic = '-';
					if(!isset($picture) or empty($picture)) $picture = '0';
				}
				
				?>
				<div class="idrw-inline idrw-orgpro-logoh">
					<?php
					if($organizations['Entry']['main_image'] == 0)
					{
					?>
					<a href="<?php echo $imagePath.$organizations['Entry']['entry_type'].'/'.$organizations['Entry']['slug']; ?>"><img src="<?php echo $imagePath.'images/organization.jpg'; ?>" alt="Ibeka" width="100%" /></a>
					<?php		
					}
					else
					{
					?>
					<a href="<?php echo $imagePath.$organizations['Entry']['entry_type'].'/'.$organizations['Entry']['slug']; ?>"><img src="<?php echo $imagePath.'img/upload/'.$organizations['Entry']['main_image'].'.'.$data['myImageTypeList'][$organizations['Entry']['main_image']]; ?>" alt="Ibeka" width="100%" /></a>
					<?php
					}
					?>
				</div>
				<div>
					<h3><?php echo $organizations['Entry']['title']; ?></h3>
				</div>
				<div class="rating">
					<span class="star">&nbsp;</span><span class="star">&nbsp;</span><span class="star">&nbsp;</span><span class="star">&nbsp;</span><span class="star">&nbsp;</span>

				</div>
				<div class="idrw-inline">
					<p><?php echo substr(strip_tags($organizations['Entry']['description']),0,155); ?>..</p>
				</div>
				<div class="idrw-inline idrw-all">
					<h3 class="idrw-vtop">Penanggung Jawab</h3>
				</div>
				<div class="idrw-inline idrw-all">
					<?php
					if($picture == 0)
					{
					?>
					<img src="<?php echo $imagePath.'images/organization.jpg'; ?>" alt="Lily Allen" width="72">
					<?php		
					}
					else
					{
					?>
					<img src="<?php echo $imagePath.'img/upload/thumb/'.$picture.'.'.$data['myImageTypeList'][$picture]; ?>" alt="Lily Allen" width="72">
					<?php
					}
					?>
					 <div class="idrw-block idrw-vtop idrw-all idrw-onecon-lefttitle">
						<h3 class="idrw-mb5"><?php echo $pic; ?></h3>
						<a class="idrw-btn" href="#" style="padding: 5px 15px;">Contact</a>
					</div> 
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<div class="container_16">
	<div class="grid_5 alpha idrw-orgpro-gr5">
		<div class="idrw-onecon idrw-guttermin">
			<div class="idrw-onecon-title">
				<h2>SUKARELAWAN</h2>
			</div>
			<div class="idrw-onecon-content idrw-orgpro-member idrw-orgpro-shr">
				<?php
				$argsVolunteers = array(
					"entry_type" => "activity-members",
					"parent_id" => 0,
					"recursive" => 1,
					"offset" => null,
					"limit" => 4,
					"field_order" => "created",
					"order" => "DESC",
					"key" => "activity-id",
					"value" => $data['myEntry']['Entry']['id']
				);
				$volunteers = $get->simple_list_entry_and_meta($argsVolunteers);
				?>
				<?php
				foreach($volunteers as $volunteer)
				{
					$argsDetails = array(
						"id" => $volunteer['Entry']['created_by'],
						"entry_type" => "volunteers",
						"recursive" => -1
					);
					$details = $get->entry_detail($argsDetails);
					
					$volKerja = $get->meta_detail($details['Entry']['id'],'form-kerja');
				?>
				<div class="idrw-inline idrw-ib">
					<?php
					if($details['Entry']['main_image'] == 0)
					{
					?>
					<a href="<?php echo $imagePath.$details['Entry']['entry_type'].'/'.$details['Entry']['slug']; ?>"><img class="idrw-vtop" src="<?php echo $imagePath.'images/volunteer.jpg'; ?>" alt="Lily Allen" width="64"></a>
					<?php		
					}
					else
					{
					?>
					<a href="<?php echo $imagePath.$details['Entry']['entry_type'].'/'.$details['Entry']['slug']; ?>"><img class="idrw-vtop" src="<?php echo $imagePath.'img/upload/thumb/'.$details['Entry']['main_image'].'.'.$data['myImageTypeList'][$details['Entry']['main_image']]; ?>" alt="Lily Allen" width="64"></a>
					<?php
					}
					?>
					<div class="idrw-onecon-procon idrw-vtop">
						<h3><?php echo $details['Entry']['title']; ?></h3>
						<a href="#"><?php if(isset($volKerja) and !empty($volKerja)) echo $volKerja; else echo '-'; ?></a>
					</div>
				</div>
				<?php
				}
				?>
			</div>
			<div class="idrw-onecon-foot">
				<span><a class="idrw-trans" href="#">Lihat Semua</a></span>
			</div>
		</div>
	</div>
	<div class="grid_11 omega">
		<div class="idrw-onecon idrw-guttermin">
			<div class="idrw-onecon-title">
				<h2>REVIEW & CHAT</h2>
			</div>
			<div class="idrw-onecon-content idrw-orgpro-far" style="min-height: 420px;">
				<div class="fb-comments" data-href="<?php echo $site.$this->params['url']['url']; ?>" data-width="610" data-num-posts="2"></div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$(".bxslider").bxSlider({
			auto: true,
			mode: "fade",
			pager: false,
			controls: false
		});
	
		$("#act1").sharrre({
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