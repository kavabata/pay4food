<div class="signup_page">
    <div class="signup_page_box">
        <div class="signup_page_content">
            
<?php 


echo $this->JqueryValidation->create('User'); 
?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
  echo $this->JqueryValidation->input('User.email', array('label' => 'Email Address:', 'class' => 'js-highlight js-hide-tip jquery-validation'));
  echo $this->JqueryValidation->input('User.email_confirm', array('label' => 'Confirm Email Address:', 'class' => 'js-highlight js-hide-tip'));
  echo $this->JqueryValidation->input('User.password', array('label' => 'Password:', 'class' => 'js-highlight js-hide-tip', 'error' => false, 'after' => $this->Form->error('User.password') ));
  echo $this->JqueryValidation->input('User.password_confirm', array('label' => 'Repeat Password:', 'type' => 'password', 'class' => 'js-highlight js-hide-tip'));
  echo $this->JqueryValidation->input('name', array('label' => 'Your Name', 'type' => 'text'));
	?>
	</fieldset>
<?php

 $validate =  $this->JqueryValidation->validationArray('User');
 debug($validate);
 echo $this->JqueryValidation->end(__('Submit')); 
 ?>

            <div class="clear"></div>
        </div>
        
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  $('#UserSig//nupForm').validate(<?php echo $validate;?>);
 
    $('#UserEmail').focus();
});
</script>