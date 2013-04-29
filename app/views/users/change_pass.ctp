<?php //pr($list_user); 
echo $this->Html->script(array('project','cancel'));
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
						if($ls['User']['roles']==0) 
						{
							$roles = "Be Admin";
						} 
						else 
						{
							$roles = "Be Regular";
						}
					?>
					
					<?php
					
						if ($ls['User']['id'] == $id)
						{
						?>
							
							<?php echo $form->create('User',array('action'=>'change_pass')); ?>
							<!-- <table> 
								<colgroup>
									<col/>
									<col class="isTimestamp"/>
									<col class="isStatus"/>
								</colgroup> -->
								
								<tr id="" class="cms_InlineForm">
									<td>
										<h6>Change Password : <? echo $user_id['User']['username'];?></h6>
										<?php if($user['User']['roles']!=1): ?>
										<span class="alignLeft space10">
											<input type="hidden" name="data[User][id]" value="<? echo $user_id['User']['id'];?>" size="14">
											<input type="hidden" name="data[User][password]" value="<? echo $user_id['User']['password'];?>" size="14">
											<input type="password"  name="data[User][old]" size="14">
											<label>Old Password</label>
										</span>
										<?php endif; ?>
										<span class="alignLeft space10">

											<input type="password"  name="data[User][new]" size="14" id="cPassword1">
											<label>New Password</label>
										</span>
										<span class="alignLeft space10">
											<input type="password" name="data[User][confirm]" size="10" id="cPassword2">
											<label>Confirm Password</label>
										</span>

										<span class="alignLeft">
											<input type="submit" value="Save">
											<input id="" type="button" value="Cancel" class="isOff" onclick="javascript: window.location=site+'Users/add/'">
										</span>
										<div class="clearFix"></div>
									</td>
									
									<td><?php echo date('d-m-Y @ H:i',$jakarta+strtotime($ls['User']['created'])); ?></td>
									<td>
										<span class="cms_Status <?php echo $ls['User']['roles']==0?'isBad':'isGood'; ?>">
											<?php
											
												if ($ls['User']['roles'] ==0)
												{
													echo "Regular";
												}
												else
												{
													echo "Admin";
												}
											?>
										</span>
									</td>
									
								</tr>
							<!-- </table> -->
							<? echo $form->end(); ?>
							
						<?php
						}
						else
						{
						?>
							
							<tr>
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
								<td>
									<span class="cms_Status <?php echo $ls['User']['roles']==0?'isBad':'isGood'; ?>">
										<?php
										
											if ($ls['User']['roles'] ==0)
											{
												echo "Regular";
											}
											else
											{
												echo "Admin";
											}
										?>
									</span>
								</td>
								
							</tr>
							
						<?php
						}
					
					?>
					
					
					<? } ?>
	
				</tbody>
				
			</table>
			
		<div class="clearFix"></div>