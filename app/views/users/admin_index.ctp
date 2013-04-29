<?php
	$_SESSION['now'] = htmlentities($_SERVER['REQUEST_URI']);
	if($isAjax == 0)
	{
		?>
<!--      ----------------------------------------------------------------------------------------------------------		 -->
<?php
	$this->Html->addCrumb('Users', '/admin/users');
?>
<script type="text/javascript">
	$("a#aus").addClass("active");
</script>

<div class="inner-header">	
	<?php 
		echo $form->Html->link('Add New User',array('controller'=>'accounts','action'=>'add'),array('class'=>'btn btn-primary fr right-btn')); 
		echo $form->Html->link("Export to CSV", "/entries/export", array('class'=>'btn fr right-btn'));
	?>
	<div class="title">
		<h2><?php echo $totalList; ?> USERS</h2>
		<p id="id-title-description" class="title-description">Last updated by <a href="#"><?php echo $lastModified['ParentModifiedBy']['firstname'].' '.$lastModified['ParentModifiedBy']['lastname'].'</a> on '.date_converter($lastModified['User']['modified'], $setting[5]['Setting']['value'] , $setting[6]['Setting']['value']); ?></p>
	</div>
</div>

<div class="inner-content">
	<div id="ajaxed">
<!--      ----------------------------------------------------------------------------------------------------------		 -->		
		<?php
	}
?>

<?php
	if($isAjax == 1)
	{
		?>
			<script type="text/javascript">
				$(document).ready(function(){
					$('#cmsAlert').css('display' , 'none');		
				});
			</script>
		<?php
	}
?>

<table id="myTableList" class="list">
	<thead>
	<tr>
		<th>NAME</th>
		<th>ROLE</th>
		<th>LAST LOGIN</th>
		<th>LAST MODIFIED</th>
		<th>STATUS</th>
		<th></th>
	</tr>
	</thead>
	
	<tbody>
	<?php		
		foreach ($myList as $value):
	?>	
	<tr>
		<td>
			<h5>
				<?php
					if($value['Role']['id'] == 2 && $user['User']['role_id'] != 2)
					{
						echo $value['User']['firstname'].' '.$value['User']['lastname'];
					}
					else 
					{
						if($value['Role']['id'] == 5)
							echo $form->Html->link($value['User']['firstname'].' '.$value['User']['lastname'],array('action'=>'edit', $value['User']['id']));
						else
							echo $form->Html->link($value['User']['firstname'].' '.$value['User']['lastname'],array('controller'=>'accounts','action'=>'edit', $value['Account']['id']));
					} 
				?>
			</h5>
			<p></p>
		</td>
		<td><?php echo $value['Role']['name']; ?></td>
		<td>
			<?php
				if(substr($value['Account']['last_login'], 0 , 4) == '0000' || empty($value['Account']['last_login']))
				{
					echo '-';
				}
				else
				{
					echo date_converter($value['Account']['last_login'], $setting[5]['Setting']['value'] , $setting[6]['Setting']['value']);
				}
			?>
		</td>
		<td><?php echo date_converter($value['User']['modified'], $setting[5]['Setting']['value'] , $setting[6]['Setting']['value']); ?></td>
		<td>
			<span class="label <?php echo $value['User']['status']==0?'label-important':'label-success'; ?>">
				<?php
					if($value['User']['status'] == 0)
						echo "Disabled";					
					else
						echo "Active";
				?>
			</span>
		</td>
		<td>
			<?php
				if($value['Role']['id'] >= 3)
				{
					$confirm = null;
					$targetURL = 'users/change_status/'.$value['User']['id'];
					if($value['User']['status'] == 0)
					{
						echo '<a href="javascript:void(0)" onclick="changeLocation(\''.$targetURL.'\')" class="btn btn-info"><i class="icon-ok icon-white"></i></a>';					
					}
					else
					{
						$confirm = 'Are you sure want to disable this user ?';
						echo '<a href="javascript:void(0)" onclick="show_confirm(\''.$confirm.'\',\''.$targetURL.'\')" class="btn btn-warning"><i class="icon-ban-circle icon-white"></i></a>';
					}
					?>
					<a href="javascript:void(0)" onclick="show_confirm('Are you sure want to delete this user ?','users/delete/<?php echo $value['User']['id']; ?>')" class="btn btn-danger"><i class="icon-trash icon-white"></i></a>
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
<div class="clear"></div>
<input type="hidden" value="<?php echo $countPage; ?>" size="50" id="myCountPage"/>
<input type="hidden" value="<?php echo $left_limit; ?>" size="50" id="myLeftLimit"/>
<input type="hidden" value="<?php echo $right_limit; ?>" size="50" id="myRightLimit"/>

<?php
	if($isAjax == 0)
	{
		?>
<!--      ----------------------------------------------------------------------------------------------------------		 -->
	</div>	
	<?php
		if($totalList > 0 && $countPage >= 2) {
			?>
				<!-- per 15 content -->
				<div class="pagination fr">
					<ul>
						<?php
							echo '<li id="myPagingFirst" class="'.($paging<=1?"disabled":"").'">';
							echo $form->Html->link("First",array("action"=>"index",1) , array("class"=>"ajax_mypage"));
							echo '</li>';
							
							echo '<li id="myPagingPrev" class="'.($paging<=1?"disabled":"").'">';
							echo str_replace("amp;", "", $form->Html->link("&laquo;",array("action"=>"index",$paging-1), array("class"=>"ajax_mypage")));
							echo '</li>';
							
							for ($i = $left_limit , $index = 1; $i <= $right_limit; $i++ , $index++)
							{
								echo '<li id="myPagingNum'.$index.'" class="'.($i==$paging?"active":"").'">';
								echo $form->Html->link($i,array("action"=>"index",$i) , array("class"=>"ajax_mypage"));				
								echo '</li>';
							}
						
							echo '<li id="myPagingNext" class="'.($paging>=$countPage?"disabled":"").'">';
							echo str_replace("amp;", "", $form->Html->link("&raquo;",array("action"=>"index",$paging+1) , array("class"=>"ajax_mypage")));
							echo '</li>';
							
							echo '<li id="myPagingLast" class="'.($paging>=$countPage?"disabled":"").'">';
							echo $form->Html->link("Last",array("action"=>"index",$countPage), array("class"=>"ajax_mypage"));
							echo '</li>';
						?>
					</ul>
				</div>
			<?php
		}
	?>	
</div>	
<!--      ----------------------------------------------------------------------------------------------------------		 -->		
		<?php
	}
?>
