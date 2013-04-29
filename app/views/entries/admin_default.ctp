<?php
	extract($data , EXTR_OVERWRITE);
	$_SESSION['now'] = str_replace('&amp;','&',htmlentities($_SERVER['REQUEST_URI']));
	if($isAjax == 0)
	{
		echo $this->element('admin_header');
		echo '<div class="inner-content" id="inner-content">';
		echo '<div id="ajaxed">';
	}
	else
	{
		if($search == "yes")
		{
			echo '<div id="ajaxed">';
		}
		?>
			<script>
				$(document).ready(function(){
					$('#cmsAlert').css('display' , 'none');
				});
			</script>
		<?php
	}
?>
<script>
	$(document).ready(function(){
		// table sortable
		if(<?php echo $isOrderChange; ?> == 1)
		{
			$("table.list tbody").sortable({ opacity: 0.6, cursor: 'move',
				stop: function(event, ui) {
					var tmp = '';
					// construct
					$('table.list tbody tr.orderlist').each(function(){
						tmp += $(this).attr('alt') + ',';
					});
					
	//				console.log(tmp);
									
					$.ajaxSetup({cache: false});
					$.post(site+'entries/reorder_list',{
						src_order: $('input[type=hidden]#determine').val(),
						dst_order: tmp
					});
				}
			});
		}
		else
		{
			$('table#myTableList tr').css('cursor' , 'default');
		}
		
		$('p#id-title-description').html('Last updated by <a href="#"><?php echo $lastModified['UserModifiedBy']['firstname'].' '.$lastModified['UserModifiedBy']['lastname'].'</a> on '.date_converter($lastModified['Entry']['modified'], $setting[5]['Setting']['value'] , $setting[6]['Setting']['value']); ?>');
		$('p#id-title-description').css('display','<?php echo (empty($totalList)?'none':'block'); ?>');
		
		// UPDATE SEARCH LINK !!
		$('a.searchMeLink').attr('href',site+'admin/entries/<?php echo $myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']); ?>/index/1<?php echo (!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:''); ?>');
		
		// UPDATE TITLE HEADER !!
		$('div.title > h2').html('<?php echo $totalList.' '.strtoupper(empty($myEntry)?$myType['Type']['name']:$myEntry['Entry']['title'].' '.$myChildType['Type']['name']); ?>');
		
		// UPDATE ADD NEW DATABASE LINK !!
		$('a.get-started').attr('href',site+'admin/entries/<?php echo $myType['Type']['slug'].'/'.(empty($myEntry)?'':$myEntry['Entry']['slug'].'/').'add'.(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:''); ?>');
		
		// disable language selector ONLY IF one language available !!
		if($('div.lang-selector ul.dropdown-menu li').length <= 1)
		{
			$('div.lang-selector').hide();
		}
	});
</script>
<?php if($totalList <= 0){ ?>
	<div class="empty-state item">
		<div class="wrapper-empty-state">
			<div class="pic"></div>
			<h2>No Items Found!</h2>
			<!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ante nisi, fermentum eu mattis id, vehicula dapibus sapien.</p>-->
			<?php echo $form->Html->link('Get Started',array('action'=>$myType['Type']['slug'],(empty($myEntry)?'':$myEntry['Entry']['slug'].'/').'add'.(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')),array('class'=>'btn btn-primary')); ?>
		</div>
	</div>
<?php }else{ ?>
<table id="myTableList" class="list">
	<thead>
	<tr>
		<th>TITLE</th>
		<?php
			if(empty($myEntry)) // if this is a parent Entry !!
			{
				if($myType['Type']['parent_id'] == 0)
				{
					echo '<th>'.strtoupper($myType['Type']['name']).'</th>';
				}
				else
				{						
					foreach ($myType['ChildType'] as $key10 => $value10)
					{
						echo '<th>'.strtoupper($value10['name']).'</th>';
					}
				}
			}	
		?>
		<th>LAST MODIFIED</th>
		<th>STATUS</th>
		<th></th>
	</tr>
	</thead>
	
	<tbody>
	<?php		
		$orderlist = "";
		foreach ($myList as $value):
		$orderlist .= $value['Entry']['sort_order'].",";
	?>	
	<tr class="orderlist" alt="<?php echo $value['Entry']['id']; ?>">
		<td>
			<?php
				if($imageUsed == 1)
				{
					echo '<div class="thumbs">';
					echo $this->Html->link($this->Html->image('upload/thumb/'.$value['Entry']['main_image'].'.'.$myImageTypeList[$value['Entry']['main_image']], array('alt'=>$value['ParentImageEntry']['title'],'title' => $value['ParentImageEntry']['title'])),array('action'=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']),'edit',$value['Entry']['slug'].(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:'')),array("escape"=>false));
					echo '</div>';
				}
			?>
			<h5><?php echo $form->Html->link($value['Entry']['title'],array('action'=>$myType['Type']['slug'].(empty($myEntry)?'':'/'.$myEntry['Entry']['slug']),'edit',$value['Entry']['slug'].(!empty($myEntry)&&$myType['Type']['slug']!=$myChildType['Type']['slug']?'?type='.$myChildType['Type']['slug']:''))); ?></h5>
			<p>
				<?php
					if($descriptionUsed == 1 && !empty($value['Entry']['description']))
					{
						$description = strip_tags($value['Entry']['description']);
						echo (strlen($description) > 50? substr($description,0,50)."..." : $description);
					}
				?>
			</p>
		</td>
		<?php
			if(empty($myEntry)) // if this is a parent Entry !!
			{
				if($myType['Type']['parent_id'] == 0)
				{
					echo '<td><span class="badge badge-info">'.$form->Html->link($value['Entry']['count'],array('action'=>$myType['Type']['slug'],$value['Entry']['slug'].'?lang='.$_SESSION['lang'])).'</span></td>';
				}
				else
				{						
					foreach ($myType['ChildType'] as $key10 => $value10)
					{
						$childCount = 0;
						foreach ($value['EntryMeta'] as $key20 => $value20) 
						{
							if($value20['key'] == 'count-'.$value10['slug'])
							{
								$childCount = $value20['value'];
								break;
							}
						}							
						echo '<td><span class="badge badge-info">'.$form->Html->link($childCount,array('action'=>$myType['Type']['slug'],$value['Entry']['slug'].'?type='.$value10['slug'].'&lang='.$_SESSION['lang'])).'</span></td>';
					}
				}
			}	
		?>
		<td><?php echo date_converter($value['Entry']['modified'], $setting[5]['Setting']['value'] , $setting[6]['Setting']['value']); ?></td>
		<td>
			<span class="label <?php echo $value['Entry']['status']==0?'label-important':'label-success'; ?>">
				<?php
					if($value['Entry']['status'] == 0)
						echo "Disabled";					
					else
						echo "Active";
				?>
			</span>
		</td>	
		<td>
			<?php
				if($myType['Type']['slug'] != 'pages' && $myType['Type']['slug'] != 'user-guides')
				{
					$confirm = null;
					$targetURL = 'entries/change_status/'.$value['Entry']['id'];
					if($value['Entry']['status'] == 0)
					{
						echo '<a href="javascript:void(0)" onclick="changeLocation(\''.$targetURL.'\')" class="btn btn-info"><i class="icon-ok icon-white"></i></a>';					
					}
					else
					{
						$confirm = 'Are you sure want to disable '.$value['Entry']['title'].' ?';
						echo '<a href="javascript:void(0)" onclick="show_confirm(\''.$confirm.'\',\''.$targetURL.'\')" class="btn btn-warning"><i class="icon-ban-circle icon-white"></i></a>';					
					}
				}
				if(!($myType['Type']['slug'] == 'pages' && $user['Role']['id'] >= 3))
				{
					?>
						<a href="javascript:void(0)" onclick="show_confirm('Are you sure want to delete <?php echo $value['Entry']['title']; ?> ?','entries/delete/<?php echo $value['Entry']['id']; ?>')" class="btn btn-danger"><i class="icon-trash icon-white"></i></a>
					<?php
				}				
			?>
		</td>
	</tr>
	
	<?php
		endforeach;
	?>
	</tbody>
</table>
<?php } ?>
<input type="hidden" id="determine" value="<?php echo $orderlist; ?>" />
<div class="clear"></div>
<input type="hidden" value="<?php echo $countPage; ?>" id="myCountPage"/>
<input type="hidden" value="<?php echo $left_limit; ?>" id="myLeftLimit"/>
<input type="hidden" value="<?php echo $right_limit; ?>" id="myRightLimit"/>
<?php
	if($isAjax == 0)
	{
		echo '</div>';
		echo $this->element('admin_footer');
		echo '<div class="clear"></div>';
		echo '</div>';
	}
	else
	{
		if($search == "yes")
		{
			echo '</div>';
			echo $this->element('admin_footer');
			echo '<div class="clear"></div>';
		}
	}
?>