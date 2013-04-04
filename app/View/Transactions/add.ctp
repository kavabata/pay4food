<script>
function personalMode(mode){
    if(mode == '1'){
        $("#personal_link_1, #user_list .check input").hide();
        $("#personal_link_0").show();
        $(".transactions fieldset legend").html('<?php echo __('Someone should pay for that! For each person separatly!'); ?>');
        $("#TransactionPaid").val('0.00').attr("disabled", "disabled");
        $("#user_list .summ input").removeAttr("disabled");
        $("#user_list .summ input").val('0.00');
        $("#TransactionPersonal").val('1');
    }else{
        $("#personal_link_0").hide();
        $("#personal_link_1, #user_list .check input").show();
        $(".transactions fieldset legend").html('<?php echo __('Someone should pay for that! Equal for all checked!'); ?>');
        $("#user_list .summ input").val('0.00').attr("disabled", "disabled");
        $("#TransactionPaid").val('0.00');
        $("#TransactionPersonal").val('0');
        $("#TransactionPaid").removeAttr("disabled");
    }
}
function updatePaid(){
    if ($("#TransactionPersonal").val() == '1') {
        //personal, separate
        var total = 0;
        $("#user_list .summ input").each(function(){
            var fieldval = parseFloat($(this).val());
            total = total + fieldval;
            $(this).val(fieldval.toFixed(2));
        });
        $("#TransactionPaid").val(total.toFixed(2));
    } else {
        //equal betwwen checked
        var total = parseFloat($("#TransactionPaid").val());
        var inpay = $("#user_list .check input:checked").length;
        var perone = total/inpay;
        $("#TransactionPaid").val(total.toFixed(2));
        $("#user_list div.user").each(function(){
           if($(this).find(".check input").is(':checked')){
               $(this).find(".summ input").val(perone.toFixed(2));
           }else{
                $(this).find(".summ input").val('0.00');
           }
        });
    }
}
</script>
<?php echo $this->Form->create('Transaction'); ?>
<div class="transactions form">
	<?php
		echo $this->Form->input('group_id',array('options'=>$groups,'type'=>'select'));
    echo $this->Form->input('user_id',array('options'=>array($user_data['id']=>$user_data['name']),'type'=>'select'));
		echo $this->Form->input('paid',array('value'=>'0.00'));
    echo $this->Form->input('personal',array('type'=>'hidden','value'=>0));
	?>
    <div class="clear"></div>
</div>

<a href="javascript:personalMode('1')" id="personal_link_1"><?php echo __('Each have personal debt');?></a>
<a href="javascript:personalMode('0')" id="personal_link_0"><?php echo __('One for all');?></a>
<br /><br />
       
<div id="user_list"></div>
<?php echo $this->Form->end(__('Submit')); ?>

<script>
var user_id = <?php echo $user_data['id'];?>;
$(document).ready(function(){
    $("#TransactionGroupId").bind("change",function(){
        var group_id = $(this).val();
        $.ajax('<?php echo Router::url(array('controller'=>'users','action'=>'ajax_select'));?>/'+group_id,{dataType : 'json',success: function(data){
            $("#TransactionUserId, #user_list").html('');
            $.each(data['users'],function(index,value){
                var selected = '';
                if(value['User']['id'] == user_id){
                    var selected = ' selected="selected"';
                }
                $("#TransactionUserId").append('<option value="'+value['User']['id']+'"'+selected+'>'+value['User']['name']+'</option>');
                $("#user_list").append(
                    $('<div class="user"></div>').attr('id','user_div_'+value['User']['id'])
                        .append($('<div></div>').attr('class','check left').html('<input type="checkbox" name="data[Debt][user_id]['+value['User']['id']+']"/>'))
                        .append($('<div></div>').attr('class','balance left').html(value['GroupUser']['balance']+' '+data['groups'][group_id]['currency']))
                        .append($('<div></div>').attr('class','name left').html(value['User']['name']))
                        .append($('<div></div>').attr('class','summ right').html('<input type="text" name="data[Debt][debt]['+value['User']['id']+']" value="0.00"/>'))
                        .append($('<div></div>').attr('class','clear'))
                );
                $("#user_list input").on("change",{},updatePaid);
            });
            ;
            personalMode($("#TransactionPersonal").val());
        }}); 
    });
    $("#TransactionGroupId").trigger("change");
    personalMode(0);
    $("#TransactionPaid").on("change",{},updatePaid);
});
</script>