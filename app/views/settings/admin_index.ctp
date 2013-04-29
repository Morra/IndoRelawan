<?php
	//$_SESSION['now'] = htmlentities($_SERVER['HTTP_REFERER']);
	$_SESSION['now'] = htmlentities($_SERVER['REQUEST_URI']);
	$this->Html->addCrumb('Settings', '/admin/settings');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$.fn.add_new_lang = function(src){
			var content = '<div class="control-group group-checkbox">';
			content += '<input type="hidden" value="'+src+'">';
			content += '<div class="controls inline">';
			content += '<input class="normal-checkbox" type="checkbox" name="data[Setting][21][optlang]['+src+']" value="nofixed" CHECKED />';
			content += '<label class="control-label label-checkbox">'+lang_unslug(src)+'</label>';
			content += '</div>';
			content += '</div>';
			return content;
		}

		$.fn.validate_lang = function(mycode , mylang){
			// FIRST CHECK !!
			if(mycode.length <= 0 || !isNaN(mycode) || mylang.length <= 0 || !isNaN(mylang))
			{
				return false;
			}
			// SECOND CHECK !!
			var state = 1;
			$("div#optlang div.group-checkbox").each(function(){
				var temp = $(this).find('input[type=hidden]').val().split('_');
				if($.trim(temp[0]).toLowerCase() == mycode.toLowerCase() || $.trim(temp[1]).toLowerCase() == mylang.toLowerCase())
				{
					state = 0;
					return;
				}
			});
			return (state==1?true:false);
		}

		$("a#settings").addClass("active");
		$("input[type=checkbox]#multilanguage").change(function(){
			if($(this).is(':checked'))
			{
				$("div#optlang").slideDown('fast',function(){
					$("a.cancel_lang").click();
				});
			}
			else
			{
				$("div#optlang").slideUp('fast');
			}
		});
		$("select#default_language").change(function(){
			var value = $(this).val();
			$("div#optlang div.group-checkbox input[type=checkbox]").attr('disabled' , false);
			$("div#optlang div.group-checkbox").each(function(){
				if($(this).find('input[type=hidden]').val() == value)
				{
					$(this).find('input[type=checkbox]').attr('disabled' , true);
					$(this).find('input[type=checkbox]').attr('checked' , true);
					return;
				}
			});
		});
		$(document).delegate("div#optlang div.group-checkbox input[type=checkbox][value=nofixed]","change",function(){
			if(!$(this).is(':checked'))
			{
				$(this).parents('div.group-checkbox').animate({opacity : 0 , height : 0, marginBottom : 0},1000,function(){
					$("select#default_language").find("option[value="+$(this).find('input[type=hidden]').val()+"]").detach();
					$(this).detach();
				});
			}
		});
		$("a.add_lang").click(function(){
			if($("div#lang_interaction a.cancel_lang").css('display') == 'none')
			{
				$("div#lang_interaction").find('input[type=text]').show();
				$("div#lang_interaction a.add_lang").html('Save');
				$("div#lang_interaction a.cancel_lang").show();
			}
			else
			{
				var mycode = $.fn.slug($.trim($("div#lang_interaction").find('input[type=text]').eq(0).val()));
				var mylang = $.fn.slug($.trim($("div#lang_interaction").find('input[type=text]').eq(1).val()));
				if($.fn.validate_lang(mycode , mylang))
				{
					var result = mycode.toLowerCase()+'_'+mylang.toLowerCase();
					$("select#default_language").append("<option value='"+result+"'>"+lang_unslug(result)+"</option>");
					$("div#optlang div.container-box.small").append($.fn.add_new_lang(result));
				}
				else
				{
					alert('Invalid Language! Please try again..');
					return;
				}
				$("a.cancel_lang").click();
			}
		});
		$("a.cancel_lang").click(function(){
			$("div#lang_interaction").find('input[type=text]').hide();
			$("div#lang_interaction").find('input[type=text]').val('');
			$("div#lang_interaction a.add_lang").html('Add More Language...');
			$("div#lang_interaction a.cancel_lang").hide();
		});
	});
</script>
<div class="inner-header">
	<div class="title">
		<h2>SETTINGS</h2>
		<p class="title-description">Last updated by <a href="#"><?php echo $myEditor['User']['firstname'].' '.$myEditor['User']['lastname']; ?></a> on <?php echo date_converter($lastModified, $setting[5]['Setting']['value'] , $setting[6]['Setting']['value']); ?></p>
	</div>
</div>

<div class="inner-content">
<?php
	echo $form->create('Setting', array('action'=>'index','type'=>'file','class'=>'notif-change form-horizontal fl','inputDefaults' => array('label' =>false , 'div' => false)));
?>
	<fieldset>
		<p class="notes important">* Required fields.</p>
<!-- 		Basic Setting -->
		<h6>Basic Setting</h6>
		<?php
			// Title...
			$value['counter'] = 0;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = 'not_empty';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'text';
			echo $this->element('input_'.$value['input_type'] , $value);

			// Tagline...
			$value['counter'] = 1;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = '';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'text';
			echo $this->element('input_'.$value['input_type'] , $value);

			// Domain Name...
			$value['counter'] = 3;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = 'not_empty';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'text';
			$value['p'] = 'http://www.domain.com';
			echo $this->element('input_'.$value['input_type'] , $value);
			unset($value['p']);

			// Path URL...
			$value['counter'] = 4;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = 'not_empty';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'text';
			$value['p'] = 'http://www.domain.com/path_url';
			echo $this->element('input_'.$value['input_type'] , $value);
			unset($value['p']);
			
			// Description...
			$value['counter'] = 2;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = '';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'textarea';
			$value['p'] = 'About 150 words recommended';
			echo $this->element('input_'.$value['input_type'] , $value);
			unset($value['p']);
			
			// Keyword...
			$value['counter'] = 25;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = '';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'text';
			$value['p'] = 'Separate keywords by commas';
			echo $this->element('input_'.$value['input_type'] , $value);
			unset($value['p']);

			// Date Format...
			$value['counter'] = 5;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = 'not_empty';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'dropdown';
			$value['list'][0]['id'] = 'Y-m-d';
			$value['list'][1]['id'] = 'd-m-Y';
			$value['list'][2]['id'] = 'm-d-Y';
			$value['list'][3]['id'] = 'Y F d';
			$value['list'][4]['id'] = 'd F Y';
			$value['list'][5]['id'] = 'F d, Y';
			for ($i=0; $i <= 5 ; $i++) $value['list'][$i]['name'] = date($value['list'][$i]['id']);
			echo $this->element('input_'.$value['input_type'] , $value);
			unset($value['list']);

			// Time Format...
			$value['counter'] = 6;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = 'not_empty';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'dropdown';
			$value['list'][0]['id'] = 'H:i:s';
			$value['list'][1]['id'] = 'H:i';
			$value['list'][2]['id'] = 'h:i:s A';
			$value['list'][3]['id'] = 'h:i A';
			for ($i=0; $i <= 3 ; $i++) $value['list'][$i]['name'] = date($value['list'][$i]['id']);
			echo $this->element('input_'.$value['input_type'] , $value);
			unset($value['list']);
		?>
<!-- 		LANGUAGE SETTINGS -->
		<div class="control-group">
			<label class="control-label">Default Language*</label>
			<div class="controls inline">
				<select id="default_language" name="data[Setting][21][value]" class="field_type">
					<?php
						$langlist = get_list_lang($setting[21]['Setting']['value']);
						foreach ($langlist as $key10 => $value10)
						{
							if(strtolower(substr($setting[21]['Setting']['value'], 0 , 2))==strtolower(substr($value10, 0,2)))
							{
								echo "<option SELECTED value=\"".$value10."\">".lang_unslug($value10)."</option>";
							}
							else
							{
								echo "<option value=\"".$value10."\">".lang_unslug($value10)."</option>";
							}
						}
					?>
				</select>
				<p class="help-block">For more languages, please refer to <a target="_blank" href="http://www.w3schools.com/tags/ref_language_codes.asp">ISO Language Codes</a></p>
			</div>

			<div class="controls inline">
				<input class="normal-checkbox" id="multilanguage" type="checkbox" name="data[Setting][21][multilanguage]" value="yes" <?php echo (strpos($setting[21]['Setting']['value'] , chr(13).chr(10))===FALSE?'':'CHECKED'); ?>/>
				<label class="control-label label-checkbox">Multi Language</label>
			</div>
		</div>

		<div id="optlang" <?php echo (strpos($setting[21]['Setting']['value'] , chr(13).chr(10))===FALSE?'style="display:none"':''); ?>>
			<div class="container-box small" style="margin-top: -10px;">
				<?php
					foreach ($langlist as $key10 => $value10)
					{
						echo '<div class="control-group group-checkbox">';
						echo '<input type="hidden" value="'.$value10.'">';
						echo '<div class="controls inline">';
						echo '<input class="normal-checkbox" type="checkbox" name="data[Setting][21][optlang]['.$value10.']" value="fixed" '.(stripos($setting[21]['Setting']['value'], $value10)===FALSE?'':'CHECKED '.(strtolower(substr($setting[21]['Setting']['value'], 0 , 2))==strtolower(substr($value10, 0,2))?'DISABLED':'')).'/>';
						echo '<label class="control-label label-checkbox">'.lang_unslug($value10).'</label>';
						echo '</div>';
						echo '</div>';
					}
				?>
			</div>

			<div id="lang_interaction" class="control-group">
				<div class="controls">
					<input style="display: none" maxlength="2" class="input-xmini" type="text" size="200" value="" placeholder="Code"/>
					<input style="display: none" class="input-medium" type="text" size="200" value="" placeholder="Language"/>
					<a class="btn btn-info add_lang" href="javascript:void(0)">Add More Language...</a>
					<a style="display: none" class="btn cancel_lang" href="javascript:void(0)">Cancel</a>
				</div>
			</div>
		</div>
<!-- 		END OF LANGUAGE SETTINGS -->
		<?php
			// Google Analytics Code ...
			$value['counter'] = 14;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = '';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'text';
			echo $this->element('input_'.$value['input_type'] , $value);
		?>
<!-- 		Page Meta & Script -->
		<h6>Page Inserts</h6>
		<?php
			// HEADER ...
			$value['counter'] = 9;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = '';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'textarea';
			$value['p'] = 'Usually you can add external CSS or JavaScript. HTML is OK.';
			echo $this->element('input_'.$value['input_type'] , $value);
			unset($value['p']);

			// TOP INSERT...
			$value['counter'] = 10;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = '';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'textarea';
			$value['p'] = 'Insert codes right after the body tag starts.';
			echo $this->element('input_'.$value['input_type'] , $value);
			unset($value['p']);

			// BOTTOM INSERT ...
			$value['counter'] = 11;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = '';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'textarea';
			$value['p'] = 'Insert codes right before the body tag end.';
			echo $this->element('input_'.$value['input_type'] , $value);
			unset($value['p']);
		?>
	<!-- PAGE STATUS -->
		<h6>Media Settings</h6>
		<div class="control-group">
			<label class="control-label">Display Image*</label>
			<div class="controls dimension">
				<input name="data[Setting][15][value]" type="text" class="small" value="<?php echo $setting[15]['Setting']['value']; ?>" placeholder="Width" /> <span>x</span>
				<input type="hidden" value="not_empty|is_numeric" size="100" name="data[Setting][15][validation]"/>
				<input name="data[Setting][16][value]" type="text" class="small" value="<?php echo $setting[16]['Setting']['value']; ?>" placeholder="Height" />
				<input type="hidden" value="not_empty|is_numeric" size="100" name="data[Setting][16][validation]"/>
				<p class="help-block">Width x Height (px)</p>
			</div>
			<div class="controls inline" style="position: relative; left: -85px;">
				<input <?php echo (empty($setting[17]['Setting']['value'])?'':'CHECKED'); ?> type="checkbox" name="data[Setting][17][value]" value="1"/><label>Enable Cropping</label>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label">Thumbnail Image*</label>
			<div class="controls dimension">
				<input name="data[Setting][18][value]" type="text" class="small" value="<?php echo $setting[18]['Setting']['value']; ?>" placeholder="Width" /> <span>x</span>
				<input type="hidden" value="not_empty|is_numeric" size="100" name="data[Setting][18][validation]"/>
				<input name="data[Setting][19][value]" type="text" class="small" value="<?php echo $setting[19]['Setting']['value']; ?>" placeholder="Height" />
				<input type="hidden" value="not_empty|is_numeric" size="100" name="data[Setting][19][validation]"/>
				<p class="help-block">Width x Height (px)</p>
			</div>
			<div class="controls inline" style="position: relative; left: -85px;">
				<input <?php echo (empty($setting[20]['Setting']['value'])?'':'CHECKED'); ?> type="checkbox" name="data[Setting][20][value]" value="1"/><label>Enable Cropping</label>
			</div>
		</div>

		<?php
			// DISPLAY IMAGE SETTINGS ...
			// $value['counter'] = 15;
			// $value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			// $value['validation'] = 'not_empty|is_numeric';
			// $value['value'] = $setting[$value['counter']]['Setting']['value'];
			// $value['model'] = 'Setting';
			// $value['input_type'] = 'text';
			// $value['p'] = 'Maximum width for display image.';
			// echo $this->element('input_'.$value['input_type'] , $value);
			// unset($value['p']);
//
			// $value['counter'] = 16;
			// $value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			// $value['validation'] = 'not_empty|is_numeric';
			// $value['value'] = $setting[$value['counter']]['Setting']['value'];
			// $value['model'] = 'Setting';
			// $value['input_type'] = 'text';
			// $value['p'] = 'Maximum height for display image.';
			// echo $this->element('input_'.$value['input_type'] , $value);
			// unset($value['p']);
//
			// $value['counter'] = 17;
			// $value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			// $value['validation'] = '';
			// $value['value'] = $setting[$value['counter']]['Setting']['value'];
			// $value['model'] = 'Setting';
			// $value['input_type'] = 'radio';
			// $value['list'][0]['id'] = '0';
			// $value['list'][0]['name'] = 'No Cropping';
			// $value['list'][1]['id'] = '1';
			// $value['list'][1]['name'] = 'With Cropping';
			// $value['p'] = 'Decide if in resizing mode, use crop method or not.';
			// echo $this->element('input_'.$value['input_type'] , $value);
			// unset($value['p']);
			// unset($value['list']);

			// THUMB IMAGE SETTINGS...
			// $value['counter'] = 18;
			// $value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			// $value['validation'] = 'not_empty|is_numeric';
			// $value['value'] = $setting[$value['counter']]['Setting']['value'];
			// $value['model'] = 'Setting';
			// $value['input_type'] = 'text';
			// $value['p'] = 'Default width for thumbnails.';
			// echo $this->element('input_'.$value['input_type'] , $value);
			// unset($value['p']);
//
			// $value['counter'] = 19;
			// $value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			// $value['validation'] = 'not_empty|is_numeric';
			// $value['value'] = $setting[$value['counter']]['Setting']['value'];
			// $value['model'] = 'Setting';
			// $value['input_type'] = 'text';
			// $value['p'] = 'Default height for thumbnails.';
			// echo $this->element('input_'.$value['input_type'] , $value);
			// unset($value['p']);
//
			// $value['counter'] = 20;
			// $value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			// $value['validation'] = '';
			// $value['value'] = $setting[$value['counter']]['Setting']['value'];
			// $value['model'] = 'Setting';
			// $value['input_type'] = 'radio';
			// $value['list'][0]['id'] = '0';
			// $value['list'][0]['name'] = 'No Cropping';
			// $value['list'][1]['id'] = '1';
			// $value['list'][1]['name'] = 'With Cropping';
			// $value['p'] = 'Decide if in resizing mode, use crop method or not.';
			// echo $this->element('input_'.$value['input_type'] , $value);
			// unset($value['p']);
			// unset($value['list']);
		?>

<!-- Social Media -->
		<h6>Social Media</h6>
		<?php
			// Facebook
			$value['counter'] = 22;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = '';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'text';
			echo $this->element('input_'.$value['input_type'] , $value);

			// Twitter
			$value['counter'] = 23;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = '';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'text';
			echo $this->element('input_'.$value['input_type'] , $value);

			$value['counter'] = 24;
			$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
			$value['validation'] = '';
			$value['value'] = $setting[$value['counter']]['Setting']['value'];
			$value['model'] = 'Setting';
			$value['input_type'] = 'text';
			echo $this->element('input_'.$value['input_type'] , $value);
		?>

<!-- Store Settings -->
		<?php
		if($setting[26]['Setting']['key'] == 'store_format')
		{
		?>
			<h6>Store Settings</h6>
			<?php
				// Store Format
				$value['counter'] = 26;
				$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
				$value['validation'] = '';
				$value['value'] = $setting[$value['counter']]['Setting']['value'];
				$value['model'] = 'Setting';
				$value['input_type'] = 'dropdown';
				$value['list'][0]['id'] = 'Retail';
				$value['list'][1]['id'] = 'Private';
				for ($i=0; $i <= 1 ; $i++) $value['list'][$i]['name'] = $value['list'][$i]['id'];
				echo $this->element('input_'.$value['input_type'] , $value);
				unset($value['list']);
				
				// Store Stockout
				$value['counter'] = 27;
				$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
				$value['validation'] = '';
				$value['value'] = $setting[$value['counter']]['Setting']['value'];
				$value['model'] = 'Setting';
				$value['input_type'] = 'dropdown';
				$value['list'][0]['id'] = 'Hide';
				$value['list'][1]['id'] = 'Display item only';
				$value['list'][2]['id'] = 'Display item & price';
				for ($i=0; $i <= 2 ; $i++) $value['list'][$i]['name'] = $value['list'][$i]['id'];
				echo $this->element('input_'.$value['input_type'] , $value);
				unset($value['list']);
			?>
			
			<div class="control-group">
				<label class="control-label">Store Backorder</label>
				<div class="controls inline">
					<input <?php echo (empty($setting[28]['Setting']['value'])?'':'CHECKED'); ?> type="checkbox" name="data[Setting][28][value]" value="1"/><label>Allow</label>
				</div>
			</div>
			
			<?php
				// Store Recent Items
				$value['counter'] = 30;
				$value['key'] = 'form-'.string_unslug($setting[$value['counter']]['Setting']['key']);
				$value['validation'] = '';
				$value['value'] = $setting[$value['counter']]['Setting']['value'];
				$value['model'] = 'Setting';
				$value['input_type'] = 'text';
				echo $this->element('input_'.$value['input_type'] , $value);
			?>
		<?php
		}
		?>
		
	<!-- ADDITIONAL INFO -->
		<h6>Additional Info</h6>

		<div id="inputWrapper">
		<?php
			// ADDITIONAL INFO ...
			$value['validation'] = '';
			$n = 0;

			foreach ($setting as $key10 => $value10)
			{
				if($value10['Setting']['name'] == 'info')
				{
					$value['counter'] = $value10['Setting']['id'] - 1;
					$value['key'] = 'form-'.string_unslug($value10['Setting']['key']);
					$value['value'] = $value10['Setting']['value'];
					$value['model'] = 'Setting';
					$value['input_type'] = 'text';
					$initial = ($user['Role']['id'] <= 2?'special':'input');
					echo $this->element($initial.'_'.$value['input_type'] , $value);

					$n++;
				}
			}
		?>
		</div>
		<?php
			if($user['Role']['id'] <= 2)
			{
				?>
				<div id="additional_info" class="control-group">
					<div class="<?php echo ($n<=0?'well':''); ?>">
						<p><?php echo ($n<=0?'Create global variables that you can use anywhere on the site.':''); ?></p>
						<label class="control-label"></label>
						<div class="controls">
							<input style="display: none" class="input-medium" type="text" size="200" value="" placeholder="Key"/>
							<a <?php echo ($n<=0?'style="margin-left: -150px;"':''); ?> class="btn add_setting" href="javascript:void(0)">Add More Settings</a>
							<a style="display: none" class="cancel_setting" href="javascript:void(0)">Cancel</a>
						</div>
					</div>
				</div>
				<?php
			}
		?>

	<!-- SAVE BUTTON -->
		<div class="control-action">
			<button type="submit" class="btn btn-primary">Save Changes</button>
	        <button type="button" class="btn" onclick="javascript: window.location=site+'admin/settings'">Cancel</button>
	    </div>
	</fieldset>
<?php echo $form->end(); ?>
</div>