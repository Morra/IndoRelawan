<div class="entries index">
	<h2><?php __('Entries');?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('dbtype_id');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('slug');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('media_id');?></th>
			<th><?php echo $this->Paginator->sort('parent_id');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th><?php echo $this->Paginator->sort('count');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('created_by');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('modified_by');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	$i = 0;
	foreach ($entries as $entry):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $entry['Entry']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($entry['Dbtype']['name'], array('controller' => 'dbtypes', 'action' => 'view', $entry['Dbtype']['id'])); ?>
		</td>
		<td><?php echo $entry['Entry']['title']; ?>&nbsp;</td>
		<td><?php echo $entry['Entry']['slug']; ?>&nbsp;</td>
		<td><?php echo $entry['Entry']['description']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($entry['Media']['title'], array('controller' => 'media', 'action' => 'view', $entry['Media']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($entry['ParentEntry']['title'], array('controller' => 'entries', 'action' => 'view', $entry['ParentEntry']['id'])); ?>
		</td>
		<td><?php echo $entry['Entry']['status']; ?>&nbsp;</td>
		<td><?php echo $entry['Entry']['count']; ?>&nbsp;</td>
		<td><?php echo $entry['Entry']['created']; ?>&nbsp;</td>
		<td><?php echo $entry['Entry']['created_by']; ?>&nbsp;</td>
		<td><?php echo $entry['Entry']['modified']; ?>&nbsp;</td>
		<td><?php echo $entry['Entry']['modified_by']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $entry['Entry']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $entry['Entry']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $entry['Entry']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $entry['Entry']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Entry', true), array('action' => 'add')); ?></li>
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