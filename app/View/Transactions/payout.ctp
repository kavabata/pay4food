<div class="signup_page">
    <div class="signup_page_box">
        <div class="signup_page_content">
            
<?php echo $this->Form->create('Transaction'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('User.email', array('label' => 'Email Address:', 'class' => 'js-highlight js-hide-tip'));
        echo $this->Form->input('User.email_confirm', array('label' => 'Confirm Email Address:', 'class' => 'js-highlight js-hide-tip'));
		echo $this->Form->input('User.password', array('label' => 'Password:', 'class' => 'js-highlight js-hide-tip', 'error' => false, 'after' => $this->Form->error('User.password') . '<span class="info">Passwords are case sensitive.</span>'));
        echo $this->Form->input('User.password_confirm', array('label' => 'Repeat Password:', 'type' => 'password', 'class' => 'js-highlight js-hide-tip'));
		echo $this->Form->input('name', array('label' => 'Your Name', 'type' => 'text'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>

            <div class="clear"></div>
        </div>
        
        <div class="clear"></div>
    </div>
</div>