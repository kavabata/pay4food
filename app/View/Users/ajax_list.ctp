<div class="users index">
	<h2><?php echo __('Users'); ?></h2>
	<table cellpadding="5" cellspacing="5">
	<tr>
			<th>Email</th>
			<th>Name</th>
			<th>Balance</th>
            <?php if($groups[$group_id]['owner']) : ?>
			<th class="actions"><?php echo __('Actions'); ?></th>
            <?php endif; ?>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
		<td><?php echo h($user['GroupUser']['balance']); ?>&nbsp;</td>
        <?php if($groups[$group_id]['owner']) : ?>
		<td class="actions">
			<?php if($user['User']['id'] != $user_data['id']) echo $this->Form->postLink(__('Delete'), array('controller'=>'groups','action' => 'removeuser', 'user'=>$user['User']['id'],$group_id), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
		</td>
        <?php endif; ?>
	</tr>
    <?php endforeach; ?>
	</table><br /><br />
</div>
<?php if($groups[$group_id]['owner']) : ?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Invite User'), array('action' => 'invite',$group_id)); ?></li>
	</ul>
</div>
<?php endif; ?>