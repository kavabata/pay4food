<div class="debts form">
<?php echo $this->Form->create('Debt'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Debt'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('transaction_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('debt');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Debt.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Debt.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Debts'), array('action' => 'index')); ?></li>
	</ul>
</div>
