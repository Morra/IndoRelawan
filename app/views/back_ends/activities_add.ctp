<?php
	$get->create($data);
	extract($data , EXTR_OVERWRITE);
	if($isAjax == 0)
	{
		echo $this->element('admin_header_add');
		echo '<div id="ajaxed" class="inner-content">';
	}
	else
	{
		?>
		<script>
			$(document).ready(function(){
				$('#cmsAlert').css('display' , 'none');
			});
		</script>
		<?php
	}
	$myChildTypeLink = (!empty($myParentEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'');
	$myTranslation = ( empty($lang) ? '' : (empty($myChildTypeLink)?'?':'&').'lang='.$lang);
	$targetSubmit = (empty($myType)?'pages':$myType['Type']['slug']).(empty($myChildType)?'':'/'.$myParentEntry['Entry']['slug']).(empty($myEntry)?'/add':'/edit/'.$myEntry['Entry']['slug']).$myChildTypeLink.$myTranslation;
	$saveButton = (empty($myEntry)?'Add New':(empty($lang)?'Save Changes':'Add Translation'));
	echo $form->create('Entry', array('action'=>$targetSubmit,'type'=>'file','class'=>'notif-change form-horizontal fl','inputDefaults' => array('label' =>false , 'div' => false)));
?>
	<fieldset>
		<script>
			$(document).ready(function(){
				if($('p#id-title-description').length > 0)
				{
					$('p#id-title-description').html('Last updated by <a href="#"><?php echo $myEntry['UserModifiedBy']['firstname'].' '.$myEntry['UserModifiedBy']['lastname'].'</a> on '.date_converter($myEntry['Entry']['modified'], $setting[5]['Setting']['value'] , $setting[6]['Setting']['value']); ?>');
					$('p#id-title-description').css('display','<?php echo (!empty($lang)?'none':'block'); ?>');
				}
				// inject delete func !!
				$('a.delete-entry').attr('href' , 'entries/delete/<?php echo $myEntry['Entry']['id']; ?>');
				$('a.delete-entry').click(function(e){
					e.preventDefault();
					var url = $(this).attr('href');
					if (confirm('Are you sure want to delete this entry ?'))
					{
						window.location = site+url;
					}
				});
				// disable language selector ONLY IF one language available !!
				if($('div.lang-selector ul.dropdown-menu li').length <= 1)
				{
					$('div.lang-selector').hide();
				}
			});
		</script>
		<p class="notes important">* Required fields.</p>
		<input type="hidden" value="<?php echo $lang; ?>" name="data[language]" id="myLanguage"/>
		<input type="hidden" value="<?php echo (empty($myEntry)?'0':$myEntry['Entry']['main_image']); ?>" name="data[Entry][2][value]" id="mySelectCoverId"/>
		<?php
			$value['key'] = 'form-Title';
			$value['validation'] = 'not_empty';
			$value['value'] = $myEntry['Entry']['title'];
			$value['model'] = 'Entry';
			$value['counter'] = 0;
			if(empty($myEntry) || !empty($lang))
			{
				$value['input_type'] = 'text';
				echo $this->element('input_'.$value['input_type'] , $value);
			}
			else
			{
				$value['input_type'] = 'slug';
				$value['p'] = $get->host_name().(empty($myType)?'':$myType['Type']['slug'].'/').(empty($myParentEntry)?'':$myParentEntry['Entry']['slug'].'/').$myEntry['Entry']['slug'];
				$value['id'] = $myEntry['Entry']['id'];
				echo $this->element('special_'.$value['input_type'] , $value);
			}
			unset($value['p']);
			
			if(empty($myEntry['Entry']['slug']) and !empty($myType) and $myType['Type']['slug'] == 'activities')
			{
				$body = '<div class="idrw-titcon">';
				$body .= '<h3>TUGAS SUKARELAWAN :</h3>';
				$body .= '<p>-</p>';
				$body .= '</div>';
				$body .= '<div class="idrw-titcon">';
				$body .= '<h3>TUJUAN :</h3>';
				$body .= '-';
				$body .= '</div>';
				
				$myEntry['Entry']['description'] = $body;
			}
			
			$value['key'] = 'form-Description';
			$value['validation'] = '';
			$value['value'] = $myEntry['Entry']['description'];
			$value['model'] = 'Entry';
			$value['counter'] = 1;
			$value['input_type'] = 'ckeditor';
			echo $this->element('input_'.$value['input_type'] , $value);
			
			// $value['key'] = 'form-Cover_Image';
			// $value['validation'] = '';
			// $value['value'] = (empty($myEntry)?0:$myEntry['Entry']['main_image']);
			// $value['model'] = 'Entry';
			// $value['counter'] = 2;
			// $value['input_type'] = 'image';
			// $value['image_type'] = (empty($myEntry)?'jpg':$myImageTypeList[$myEntry['Entry']['main_image']]);
			// echo $this->element('input_'.$value['input_type'] , $value);
		?>
		<div class="control-group">            
			<label class="control-label">Organization</label>
			<div class="controls">
				<select name="data[Activity][organization]">
					<?php
					$argsOrganizations = array(
						"entry_type" => "organizations",
						"parent_id" => 0,
						"recursive" => -1,
						"offset" => null,
						"limit" => null,
						"field_order" => "title",
						"order" => "ASC"
					);
					$organizations = $get->simple_list_entry($argsOrganizations);
					?>
					<?php
					if(!empty($organizations))
					{
						foreach($organizations as $organization)
						{
							if(isset($orgId) and $orgId == $organization['Entry']['id'])
							{
							?>
							<option value="<?php echo $organization['Entry']['id']; ?>" selected><?php echo $organization['Entry']['title']; ?></option>
							<?php
							}
							else
							{
							?>
							<option value="<?php echo $organization['Entry']['id']; ?>"><?php echo $organization['Entry']['title']; ?></option>
							<?php
							}
						}
					}
					else
					{
					?>
					<option value="">- Select Organization -</option>
					<?php
					}
					?>
				</select>
			</div>
		</div>
		
		<!-- BEGIN TO LIST META ATTRIBUTES -->
		<?php
			$counter = 3;
			$myAutomatic = (empty($myChildType)?$myType['TypeMeta']:$myChildType['TypeMeta']);
			foreach ($myAutomatic as $key => $value)
			{
				$value = $value['TypeMeta']; // SPECIAL CASE, COZ IT'S BEEN MODIFIED IN CONTROLLER !!
				if(substr($value['key'], 0 , 5) == 'form-')
				{
					$value['optionlist'] = $value['value'];
					unset($value['value']);
					// now get value from EntryMeta if existed !!
					foreach ($myEntry['EntryMeta'] as $key10 => $value10)
					{
						if($value['key'] == $value10['key'])
						{
							$value['value'] = $value10['value'];
							break;
						}
					}
					$value['model'] = 'EntryMeta';
					$value['counter'] = $counter++;
					$value['p'] = $value['instruction'];
					switch ($value['input_type'])
					{
						case 'checkbox':
						case 'radio':
						case 'dropdown':
							$temp = explode(chr(13).chr(10), $value['optionlist']);
							foreach ($temp as $key50 => $value50)
							{
								$value['list'][$key50]['id'] = $value50;
								$value['list'][$key50]['name'] = string_unslug($value50);
							}
							break;
						default:
							break;
					}
					echo $this->element('input_'.$value['input_type'] , $value);
				}
			}
			// HIDE THE BROKEN INPUT TYPE !!!!!!!!!!!!!
			foreach ($myEntry['EntryMeta'] as $key => $value)
			{
				if(substr($value['key'], 0 , 5) == 'form-')
				{
					$broken = 1;
					foreach ($myAutomatic as $key20 => $value20)
					{
						$value20 = $value20['TypeMeta']; // SPECIAL CASE, COZ IT'S BEEN MODIFIED IN CONTROLLER !!
						if($value['key'] == $value20['key'])
						{
							$broken = 0;
							break;
						}
					}
					if($broken == 1)
					{
						$value['display'] = 'none';
						$value['model'] = 'EntryMeta';
						$value['counter'] = $counter++;
						echo $this->element('input_textarea' , $value);
					}
				}
			}
		?>
		<!-- END OF META ATTRIBUTES -->
		
		<?php
		// START CUSTOM //
		if($myEntry['Entry']['entry_type'] == 'activities' or $myType['Type']['slug'] == 'activities')
		{
		?>
			<!-- START PAGE GALLERY -->
			<strong id="galleryCount"><?php echo (empty($myEntry)?'0':$myEntry['Entry']['count']); ?> Pictures</strong>

			<?php echo $form->Html->link('Add Picture',array('action'=>'media_popup_single',1,'myPictureWrapper',(empty($myChildType)?$myType['Type']['slug']:$myChildType['Type']['slug']),'admin'=>false),array('class'=>'btn btn-inverse fr2g get-from-library', 'style'=>'float: right;')); ?>

			<div class="inner-content pictures" id="myPictureWrapper">
				<?php
					if(!empty($myEntry))
					{
						foreach ($myEntry['ChildEntry'] as $index => $findDetail)
						{
							$findDetail = $findDetail['Entry']; // SPECIAL CASE, COZ IT'S BEEN MODIFIED IN CONTROLLER !!
							?>
								<div class="photo">
									<div class="image">
										<?php echo $this->Html->image('upload/setting/'.$findDetail['main_image'].'.'.$myImageTypeList[$findDetail['main_image']], array('width'=>150,'alt'=>$findDetail['title'],'title'=>$findDetail['title'])); ?>
									</div>
									<div class="description">
										<p><?php echo $findDetail['title']; ?></p>
										<a href="javascript:void(0)" onclick="deleteChildPic(this);" class="icon-remove icon-white"></a>
									</div>
									<input type="hidden" value="<?php echo $findDetail['main_image']; ?>" size="50" name="data[Entry][image][]" />
								</div>
							<?php
						}
					}
				?>
			</div>
			
			<div class="clear"></div>
			<!-- END PAGE GALLERY -->
		<?php
		}
		// END CUSTOM //
		?>
		
		<h6>Search Engine Optimization (SEO)</h6>
		<?php
		// INPUT FIELD FOR SEO META KEYWORDS AND DESCRIPTION //
			
		$arr_seo = array('SEO_Title','SEO_Description','SEO_Keywords');
		
		foreach($arr_seo as $key=> $as)
		{
			$seo['key'] = $arr_seo[$key];
			$seo['validation'] = '';
			
			if($as == 'SEO_Title')
				$seo['value'] = $seoTitle;
			else if($as == 'SEO_Keywords')
				$seo['value'] = $seoKeywords;
			else if($as == 'SEO_Description')
				$seo['value'] = $seoDescription;
				
			$seo['model'] = 'EntryMeta';
			$seo['counter'] = $key+1;
			
			if($as == 'SEO_Keywords')
				$seo['p'] = 'Separate keywords by commas';
			else
				$seo['p'] = '';
				
			$seo['input_type'] = 'seo_meta';
			echo $this->element('input_'.$seo['input_type'] , $seo);
			unset($seo['p']);
		}
		
		//===================== END OF SEO META =====================//
		?>

		<!-- myTypeSlug is for media upload settings purpose !! -->
		<input type="hidden" value="<?php echo (empty($myChildType)?$myType['Type']['slug']:$myChildType['Type']['slug']); ?>" size="100" id="myTypeSlug"/>
	<!-- SAVE BUTTON -->
		<div class="control-action">
			<button type="submit" class="btn btn-primary"><?php echo $saveButton; ?></button>
        	<button type="button" class="btn" onclick="javascript: window.location=site+'admin/entries/<?php echo (empty($myType)?'pages':$myType['Type']['slug']).(empty($myChildType)?'':'/'.$myParentEntry['Entry']['slug']).$myChildTypeLink.(empty($myEntry)?'':(empty($myChildTypeLink)?'?':'&').'lang='.(empty($lang)?substr($myEntry['Entry']['lang_code'], 0,2):$lang)); ?>'">Cancel</button>
		</div>
	</fieldset>
<?php echo $form->end(); ?>
	<input type='hidden' id="now_language" value="<?php echo strtoupper(empty($lang)?substr($myEntry['Entry']['lang_code'], 0,2):$lang); ?>" />
	<input type='hidden' id="entry_id" value="<?php echo $myEntry['Entry']['id']; ?>" />
	<input type='hidden' id="entry_status" value="<?php echo $myEntry['Entry']['status']; ?>" />
	<input type='hidden' id="entry_title" value="<?php echo $myEntry['Entry']['title']; ?>" />
	<input type='hidden' id="entry_image_id" value="<?php echo $myEntry['Entry']['main_image']; ?>" />
	<input type='hidden' id="entry_image_type" value="<?php echo $myImageTypeList[$myEntry['Entry']['main_image']]; ?>" />
	<div class="clear"></div>
<?php
	if($isAjax == 0)
	{
		echo '</div>';
	}
?>