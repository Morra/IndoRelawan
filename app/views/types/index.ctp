<div class="dbtypes index">
	<h2><?php __('Dbtypes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
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
	foreach ($dbtypes as $dbtype):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $dbtype['Dbtype']['id']; ?>&nbsp;</td>
		<td><?php echo $dbtype['Dbtype']['name']; ?>&nbsp;</td>
		<td><?php echo $dbtype['Dbtype']['description']; ?>&nbsp;</td>
		<td><?php echo $dbtype['Dbtype']['count']; ?>&nbsp;</td>
		<td><?php echo $dbtype['Dbtype']['created']; ?>&nbsp;</td>
		<td><?php echo $dbtype['Dbtype']['created_by']; ?>&nbsp;</td>
		<td><?php echo $dbtype['Dbtype']['modified']; ?>&nbsp;</td>
		<td><?php echo $dbtype['Dbtype']['modified_by']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $dbtype['Dbtype']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $dbtype['Dbtype']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $dbtype['Dbtype']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $dbtype['Dbtype']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Dbtype', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Entries', true), array('controller' => 'entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry', true), array('controller' => 'entries', 'action' => 'add')); ?> </li>
	</ul>
</div>