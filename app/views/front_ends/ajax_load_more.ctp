<?php $get->create($data); ?>
<?php
if($status == 1)
{
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
					<p class="idrw-idcon-boxtil-for">Untuk <span class="idrw-red idrw-trans"><a class="idrw-orga idrw-trans" href="<?php echo $imagePath.$detailOrg['Entry']['entry_type'].'/'.$detailOrg['Entry']['slug']; ?>"><?php echo strtoupper($detailActivity['Entry']['title']); ?></a></span></p>
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
<?php	
}
?>