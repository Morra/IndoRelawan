<div class="entries view">
<h2><?php  __('Entry');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entry['Entry']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Dbtype'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($entry['Dbtype']['name'], array('controller' => 'dbtypes', 'action' => 'view', $entry['Dbtype']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entry['Entry']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Slug'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entry['Entry']['slug']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entry['Entry']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Media'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($entry['Media']['title'], array('controller' => 'media', 'action' => 'view', $entry['Media']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent Entry'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($entry['ParentEntry']['title'], array('controller' => 'entries', 'action' => 'view', $entry['ParentEntry']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entry['Entry']['status']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Count'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entry['Entry']['count']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entry['Entry']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created By'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entry['Entry']['created_by']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entry['Entry']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified By'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entry['Entry']['modified_by']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Entry', true), array('action' => 'edit', $entry['Entry']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Entry', true), array('action' => 'delete', $entry['Entry']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $entry['Entry']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Entries', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dbtypes', true), array('controller' => 'dbtypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dbtype', true), array('controller' => 'dbtypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Media', true), array('controller' => 'media', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Media', true), array('controller' => 'media', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entries', true), array('controller' => 'entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Entry', true), array('controller' => 'entries', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Details', true), array('controller' => 'entry_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Detail', true), array('controller' => 'entry_details', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Entries');?></h3>
	<?php if (!empty($entry['ChildEntry'])):?>
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
		foreach ($entry['ChildEntry'] as $childEntry):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $childEntry['id'];?></td>
			<td><?php echo $childEntry['dbtype_id'];?></td>
			<td><?php echo $childEntry['title'];?></td>
			<td><?php echo $childEntry['slug'];?></td>
			<td><?php echo $childEntry['description'];?></td>
			<td><?php echo $childEntry['media_id'];?></td>
			<td><?php echo $childEntry['parent_id'];?></td>
			<td><?php echo $childEntry['status'];?></td>
			<td><?php echo $childEntry['count'];?></td>
			<td><?php echo $childEntry['created'];?></td>
			<td><?php echo $childEntry['created_by'];?></td>
			<td><?php echo $childEntry['modified'];?></td>
			<td><?php echo $childEntry['modified_by'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'entries', 'action' => 'view', $childEntry['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'entries', 'action' => 'edit', $childEntry['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'entries', 'action' => 'delete', $childEntry['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $childEntry['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Entry', true), array('controller' => 'entries', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Entry Details');?></h3>
	<?php if (!empty($entry['EntryDetail'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Entry Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($entry['EntryDetail'] as $entryDetail):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $entryDetail['id'];?></td>
			<td><?php echo $entryDetail['entry_id'];?></td>
			<td><?php echo $entryDetail['attribute_id'];?></td>
			<td><?php echo $entryDetail['value'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'entry_details', 'action' => 'view', $entryDetail['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'entry_details', 'action' => 'edit', $entryDetail['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'entry_details', 'action' => 'delete', $entryDetail['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $entryDetail['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Entry Detail', true), array('controller' => 'entry_details', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
