<?php //pr($list_user); 
echo $this->Html->script(array('project','cancel'),false);
//var_dump($user);
?>
		<h2>Users</h2>
		<p class="isMeta">List of Users</p>
		
			<table>

				<colgroup>
					<col/>
					<col class="isTimestamp"/>
					<col class="isStatus"/>
				</colgroup>
				<thead>
					<tr>
						<th>Username</th>
						<th>Created</th>
						<th>Roles</th>
					</tr>
				</thead>
				<tbody>
				
				<? foreach ($list_user as $ls) { ?>
				<?php
						if($ls['User']['roles']==0) {
						$roles = "Be Admin";
						} 
						else $roles = "Be Regular";
				?>
				
					<tr class="edit_user_<?php $ls['User']['id'] ?>">
						<td>
						<span class="isAction">
						<?php
						//Jika statusnya admin
						if($user['User']['roles']==1)
						{
								//die();
								//Untuk dirinya sendiri
								if($user['User']['id']==$ls['User']['id'])
								{
										echo $form->Html->link('edit',array('action'=>'edit_user', $ls['User']['id']));
										echo ' | ';
										echo $form->Html->link('change password',array('action'=>'change_pass', $ls['User']['id']));
								}
								else
								{ //Untuk yang lainnya
										echo $form->Html->link('edit',array('action'=>'edit_user', $ls['User']['id']));
										echo ' | ';
										echo $form->Html->link('change password',array('action'=>'change_pass', $ls['User']['id']));
										echo ' | '; 
										echo $form->Html->link('Delete',array('action'=>'delete', $ls['User']['id']),
										null,'Are you sure want to delete this User?');
								}
						}
						else
						{
								//Untuk dirinya sendiri
								if($user['User']['id']==$ls['User']['id'])
								{
										echo $form->Html->link('edit',array('action'=>'edit_user', $ls['User']['id']));
										echo ' | ';
										echo $form->Html->link('change password',array('action'=>'change_pass', $ls['User']['id']));
								}
						}
						?>
						</span>

							<? $b = $ls['User']['username']; ?>
						<h5><?php echo $b;?></h5>
							
							<p><?php echo $ls['User']['email']; ?></p>
						</td>
						<td><?php echo date('d-m-Y @ H:i',$jakarta+strtotime($ls['User']['created'])); ?></td>
						<td><span class="cms_Status <?php echo $ls['User']['roles']==0?'isBad':'isGood'; ?>">
						<?php
						if($ls['User']['roles'] ==0){
							echo "Regular";
						}else
							echo "Admin";
					?></span></td>
						
					</tr>
					<? } ?>
	
					<?php if($user['User']['roles']==1): ?>
					<tr class="add_new_user"><td colspan="3"><input id="add_new_user" type="button" value="Add New User"></td></tr>
					
					<?php echo $form->create('User',array('action'=>'add')); ?>
						<tr id="form_user" class="cms_InlineForm">
							<td colspan="3">
								<h6>Add New User</h6>
								<span class="alignLeft space10">
									<input type="text" name="data[User][username]" size="25" id="tUsername">
									<label>Username</label>
								</span>
								<span class="alignLeft space10">

									<input type="text" name="data[User][email]" size="25" id="tEmail">
									<label>E-mail Address</label>
								</span>
								<span class="alignLeft space10">
									<input name="data[User][password]" type="password" size="20" id="tPassword1">
									<input name="data[User][confirm]" type="password" size="20" id="tPassword2">
									<label>Password (and Repeat)</label>
								</span>

								<span class="alignLeft">
									<input type="submit" value="Add">
									<input id="cancel_user" type="button" value="Cancel" class="isOff">
								</span>
								<div class="clearFix"></div>
							</td>
						</tr>
				    <? echo $form->end(); ?>
					
					<?php endif; ?>
					 
					
				</tbody>
			</table>
		
		
		<div class="clearFix"></div>
		
		<div>
			<a href="<?php echo $_SESSION['back']; ?>">Back to Previous Page</a>
			<?php $_SESSION['back'] = htmlentities($_SERVER['REQUEST_URI']); ?>
		</div>