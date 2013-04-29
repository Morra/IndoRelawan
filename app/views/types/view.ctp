<div class="dbtypes view">
<h2><?php  __('Dbtype');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dbtype['Dbtype']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dbtype['Dbtype']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dbtype['Dbtype']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Count'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dbtype['Dbtype']['count']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dbtype['Dbtype']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created By'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dbtype['Dbtype']['created_by']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dbtype['Dbtype']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified By'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dbtype['Dbtype']['modified_by']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dbtype', true), array('action' => 'edit', $dbtype['Dbtype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Dbtype', true), array('action' => 'delete', $dbtype['Dbtype']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $dbtype['Dbtype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dbtypes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dbtype', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entries', true), array('controller' => 'entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry', true), array('controller' => 'entries', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Entries');?></h3>
	<?php if (!empty($dbtype['Entry'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Dbtype Id'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Slug'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Media Id'); ?></th>
		<th><?php __('Parent Id'); ?></th>
		<th><?php __('Status'); ?></th>
		<th><?php __('Count'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Created By'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Modified By'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($dbtype['Entry'] as $entry):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $entry['id'];?></td>
			<td><?php echo $entry['dbtype_id'];?></td>
			<td><?php echo $entry['title'];?></td>
			<td><?php echo $entry['slug'];?></td>
			<td><?php echo $entry['description'];?></td>
			<td><?php echo $entry['media_id'];?></td>
			<td><?php echo $entry['parent_id'];?></td>
			<td><?php echo $entry['status'];?></td>
			<td><?php echo $entry['count'];?></td>
			<td><?php echo $entry['created'];?></td>
			<td><?php echo $entry['created_by'];?></td>
			<td><?php echo $entry['modified'];?></td>
			<td><?php echo $entry['modified_by'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'entries', 'action' => 'view', $entry['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'entries', 'action' => 'edit', $entry['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'entries', 'action' => 'delete', $entry['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $entry['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Entry', true), array('controller' => 'entries', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
