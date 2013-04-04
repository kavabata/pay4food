<?php echo $this->Form->create('Transaction'); ?>
<div class="transactions index">
<?php 
echo $this->Form->input('group_id',array('options'=>$groups,'type'=>'select'));
echo $this->Html->link(__('New Group'), array('controller'=>'groups','action' => 'add'),array('class'=>'right new_group'));
?>
  <div class="clear"></div>
</div>
</form>
<?php 
$newinvite = false;
foreach($groups_list as $group): 
    if($group['confirmed'] != '1') {
        $newinvite = true;
        continue;
    }
endforeach;
if($newinvite):?>
<div id="groups">You have invitation to new groups. When you click on link, you confirm your join:
<?php
foreach($groups as $group): 
    if($group['confirmed'] == '1') continue;
    echo $this->Html->link($group['name'],array('controller'=>'groups','action'=>'confirm',$group['id']));
endforeach;
?>
</div>
<?php endif;?>

<div id="users"></div>
  
<script>
var user_id = <?php echo $user_data['id'];?>;

$(document).ready(function(){
  $("#TransactionGroupId").bind("change",function(){
    $(".transactions .invite_link").remove();
    loadPiece("/users/ajax_list/"+$("#TransactionGroupId").val(),"#users");
  });
  $("#TransactionGroupId").trigger("change");
});
</script>
