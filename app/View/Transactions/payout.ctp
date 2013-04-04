<div class="transactions index">
<?php echo $this->Form->create('Transaction',array('url' => '/transactions/add')); ?>
	<fieldset>
	<?php
		echo $this->Form->input('group_id',array('options'=>$groups,'type'=>'select'));
    echo $this->Form->input('user_id',array('options'=>array($user_data['id']=>$user_data['name']),'type'=>'select'));
		echo $this->Html->image('arrow-right.png',array('class'=>'left'));
    echo $this->Form->input('to_id',array('options'=>array($user_data['id']=>$user_data['name']),'type'=>'select'));
    echo $this->Form->input('paid',array('value'=>'0.00'));
	?>
  <div class="clear"></div>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
  <div id="user_list_payout"></div>
</div>

<script>

var user_id = <?php echo $user_data['id'];?>;

function changeFromTo(change){
   if ($("#TransactionUserId").val() == $("#TransactionToId").val()){
      if(change == 'to') {
        $("#TransactionToId option").each(function(){
          if( $(this).attr('value') != $("#TransactionUserId").val()){
            $("#TransactionToId").val($(this).attr('value'));
            return false;
          }
        });
      }else{
        $("#TransactionUserId option").each(function(){
          if( $(this).attr('value') != $("#TransactionToId").val()){
            $("#TransactionUserId").val($(this).attr('value'));
            return false;
          }
        });
      }
   }
}


$(document).ready(function(){
    $("#TransactionUserId").bind("change",function(){changeFromTo('to');});
    $("#TransactionToId").bind("change",function(){changeFromTo('user');});
    $("#TransactionGroupId").bind("change",function(){
        var group_id = $(this).val();
        $.ajax('<?php echo Router::url(array('controller'=>'users','action'=>'ajax_select'));?>/'+group_id,{dataType : 'json',success: function(data){
            $("#TransactionUserId, #user_list_payout, #TransactionToId").html('');
            $.each(data['users'],function(index,value){
                var selected = '';
                if(value['User']['id'] == user_id){
                    var selected = ' selected="selected"';
                }
                $("#TransactionUserId,#TransactionToId").append('<option value="'+value['User']['id']+'"'+selected+'>'+value['User']['name']+'</option>');
            });
            if($.isArray(data['payouts'])) {
              $.each(data['payouts'],function(index,value){
                 $("#user_list_payout").append("<div class='payout'><div class='from'>"+value['userfrom']+"</div><div class='to'>"+value['userto']+"</div><div class='money'>"+value['money']+" "+data['groups'][group_id]['currency']+"</div></div><div class='clear'></div>");
              });
            }
            $("#TransactionUserId").trigger("change");
        }}); 
    });
    $("#TransactionGroupId").trigger("change");
});
</script>