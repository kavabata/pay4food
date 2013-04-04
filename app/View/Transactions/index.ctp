<?php echo $this->Form->create('Transaction');?>
<div class="transactions index">
<?php echo $this->Form->input('group_id',array('options'=>$groups,'type'=>'select')); ?>
<div class="clear"></div>
</div>
</form>

<div id="transaction_history"></div>
  
<script>
var user_id = <?php echo $user_data['id'];?>;

$(document).ready(function(){
  $("#TransactionGroupId").bind("change",function(){
    loadPiece("/transactions/index_ajax/"+$(this).val(),"#transaction_history");
  });
  $("#TransactionGroupId").trigger("change");
});

</script>
