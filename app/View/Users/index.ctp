<div>
    <?php echo $this->Html->link(__('New Group'), array('controller'=>'groups','action' => 'add')); ?>
</div><br /><br />
<div id="groups">
<?php 
$newinvite = false;
foreach($groups as $group): 
    if($group['confirmed'] != '1') {
        $newinvite = true;
        continue;
    }
?>
    <a href="javascript:loadGroup(<?php echo $group['id'];?>);"><?php echo $group['name'];?></a>
<?php endforeach;?>
<br /><br />
<?php if($newinvite):?>
Also u have invitation to, clicking on link, u confirm your join:
<?php
foreach($groups as $group): 
    if($group['confirmed'] == '1') continue;
    echo $this->Html->link($group['name'],array('controller'=>'groups','action'=>'confirm',$group['id']));
endforeach;
endif;
?>


</div>

<div id="users"></div>


<script>
function loadGroup(group_id){
   loadPiece("<?php echo Router::url(array('controller'=>'users','action'=>'ajax_list'),true);?>/"+group_id,"#users"); 
};
</script>