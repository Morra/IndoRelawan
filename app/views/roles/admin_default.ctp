<?php
	extract($data , EXTR_OVERWRITE);
	$_SESSION['now'] = htmlentities($_SERVER['REQUEST_URI']);
	$this->Html->addCrumb('Master', '#');
	$this->Html->addCrumb('Role', '/admin/master/roles');
?>
<script type="text/javascript">
	$("a#master").addClass("active");
</script>
<div class="inner-header">	
	<div id="child-menu">
		<?php echo $form->Html->link('Add New Role',array('controller'=>'master', 'action'=>'roles','add'),array('class'=>'btn btn-primary fr right-btn')); ?>
		<div class="btn-group fr">
			<?php echo $form->Html->link('Databases',array('controller'=>'master', 'action'=>'types'), array('class'=>'btn')); ?>			
			<?php echo $form->Html->link('Roles',array('controller'=>'master', 'action'=>'roles'), array('class'=>'btn active')); ?>
		</div>
	</div>		
	<div class="title">
		<h2><?php echo $totalList.' ROLES'; ?></h2>
	</div>
</div>		
<div class="inner-content">
	<table id="myTableList" class="list" style="cursor: default;">
		<tr>
			<th>NAME</th>
			<th></th>
		</tr>
		
		<?php		
			foreach ($myList as $value):
		?>	
		<tr>
			<td>
				<h5><?php echo $form->Html->link($value['Role']['name'],array('controller'=>'master' , 'action'=>'roles' ,'edit',$value['Role']['id'])); ?></h5>
				<p>
					<?php
						if(!empty($value['Role']['description'])) 
						{
							echo substr(strip_tags($value['Role']['description']),0,100);
						}
						echo "...";
					?>
				</p>
			</td>
			<td>						
				<?php
					if($value['Role']['id'] >= 6)
					{
						?>
						<a href="javascript:void(0)" onclick="show_confirm('Are you sure want to delete <?php echo $value['Role']['name']; ?> ?','roles/delete/<?php echo $value['Role']['id']; ?>')" class="btn btn-danger"><i class="icon-trash icon-white"></i></a>
						<?php
					}
				?>
			</td>
		</tr>
		
		<?php
			endforeach;
		?>
	</table>
</div>