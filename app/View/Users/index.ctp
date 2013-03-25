<div>
    <?php echo $this->Html->link(__('New Group'), array('controller'=>'groups','action' => 'add')); ?>
</div><br /><br />
<div id="groups">
<?php foreach($groups as $group): ?>
    <a href="javascript:loadGroup(<?php echo $group['id'];?>);"><?php echo $group['name'];?></a>
<?php endforeach;?>
</div>
<div id="users"></div>

<script>
function loadGroup(group_id){
   loadPiece("<?php echo Router::url(array('controller'=>'users','action'=>'ajax_list'),true);?>/"+group_id,"#users"); 
};
</script>