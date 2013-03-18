<div class="debts form">
<?php echo $this->Form->create('Debt'); ?>
	<fieldset>
		<legend><?php echo __('Add Debt'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Debts'), array('action' => 'index')); ?></li>
	</ul>
</div>
