<div class="entryDetails view">
<h2><?php  __('Entry Detail');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entryDetail['EntryDetail']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Entry'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($entryDetail['Entry']['title'], array('controller' => 'entries', 'action' => 'view', $entryDetail['Entry']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Attribute'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($entryDetail['Attribute']['id'], array('controller' => 'attributes', 'action' => 'view', $entryDetail['Attribute']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Value'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $entryDetail['EntryDetail']['value']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Entry Detail', true), array('action' => 'edit', $entryDetail['EntryDetail']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Entry Detail', true), array('action' => 'delete', $entryDetail['EntryDetail']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $entryDetail['EntryDetail']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Entry Details', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry Detail', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entries', true), array('controller' => 'entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entry', true), array('controller' => 'entries', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Attributes', true), array('controller' => 'attributes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Attribute', true), array('controller' => 'attributes', 'action' => 'add')); ?> </li>
	</ul>
</div>
