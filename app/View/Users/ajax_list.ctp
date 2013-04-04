<div class="users index">
	<table cellpadding="5" cellspacing="5">
  <thead>
	<tr>
			<th>Email</th>
			<th>Name</th>
			<th>Balance</th>
      <?php if($groups[$group_id]['owner']) : ?>
			<th class="actions"><?php echo __('Actions'); ?></th>
      <?php endif; ?>
	</tr>
  </thead>
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
<script>
$(".transactions .clear").before('<a href="/users/invite/<?php echo $group_id;?>" class="invite_link right">Invite User</a>');
</script>
<?php endif; ?>