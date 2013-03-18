<div class="debts view">
<h2><?php  echo __('Debt'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($debt['Debt']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Transaction Id'); ?></dt>
		<dd>
			<?php echo h($debt['Debt']['transaction_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($debt['Debt']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Debt'); ?></dt>
		<dd>
			<?php echo h($debt['Debt']['debt']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Debt'), array('action' => 'edit', $debt['Debt']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Debt'), array('action' => 'delete', $debt['Debt']['id']), null, __('Are you sure you want to delete # %s?', $debt['Debt']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Debts'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Debt'), array('action' => 'add')); ?> </li>
	</ul>
</div>
