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
		<script type="text/javascript">
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
					if (confirm('Are you sure want to delete this gallery ?'))
					{
						window.location = site+url;
					}
				});
				// disable language selector ONLY IF one language available !!
				if($('div.lang-selector ul.dropdown-menu li').length <= 1)
				{
					$('div.lang-selector').hide();
				}
				// media sortable
				$("div#myPictureWrapper").sortable({ opacity: 0.6, cursor: 'move'});
			});
		</script>
		<p class="notes important">* Required fields.</p>
		<input type="hidden" value="<?php echo $lang; ?>" name="data[language]" id="myLanguage"/>
		<input type="hidden" value="<?php echo (empty($myEntry)?'0':$myEntry['Entry']['main_image']); ?>" name="data[Entry][main_image]" id="mySelectCoverId"/>

		<div class="control-group">
			<label class="control-label">Title*</label>
			<div class="controls">
				<input class="input-xlarge" type="text" value="<?php echo $myEntry['Entry']['title']; ?>" size="50" name="data[Entry][title]" id="title" />
			</div>
		</div>

		<strong id="galleryCount"><?php echo (empty($myEntry)?'0':$myEntry['Entry']['count']); ?> Pictures</strong>

		<?php echo $form->Html->link('Add Picture',array('action'=>'media_popup_single',1,'myPictureWrapper',(empty($myChildType)?$myType['Type']['slug']:$myChildType['Type']['slug']),'admin'=>false),array('class'=>'btn btn-inverse fr get-from-library')); ?>

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
									<?php echo $this->Html->image('upload/thumb/'.$findDetail['main_image'].'.'.$myImageTypeList[$findDetail['main_image']], array('width'=>150,'alt'=>$findDetail['title'],'title'=>$findDetail['title'])); ?>
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