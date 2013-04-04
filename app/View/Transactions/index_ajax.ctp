<?php if(!empty($transactions)):
foreach($transactions as $transaction):?>
<div class="transaction">
  <div class="user left"><?php echo $users[$transaction['Transaction']['user_id']]['User']['name'];?></strong></div>
  <div class="paid left"><?php echo number_format($transaction['Transaction']['paid'],2).' '.$groups[$group_id]['currency'];?></div>
  <div class="date right"><?php echo $this->Date->emailTime($transaction['Transaction']['created']);?></div>
  <div class="clear"></div>
  <div class="details">
  <?php foreach($transaction['Debt'] as $debt):?>
    <?php echo $users[$debt['user_id']]['User']['name'];?>&nbsp;(<?php echo number_format($debt['debt'],2).' '.$groups[$group_id]['currency'];?>)&nbsp;&nbsp;&nbsp;
  <?php endforeach;?>
  </div>
</div>
<?php endforeach;?>


<div class="paging">
<?php
	echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
	//echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next(__('next') . ' >', array('class'=>'right'), null, array('class' => 'next disabled'));
?>
</div>
<?php endif;?>