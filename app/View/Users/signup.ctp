<div class="signup_page">
    <div class="signup_page_box">
        <div class="signup_page_content">
            
<?php echo $this->Form->create('User'); ?>
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
<script type="text/javascript">
$(document).ready(function() {
    $('#UserSignupForm').validate({
        focusInvalid: false,
        ignore: false,
        errorClass: 'error-message',
    	errorElement: 'div',
        rules: {
            'data[User][email]': {
                'required': true,
                'email': true
            },
            'data[User][email_confirm]': {
                'required': true,
                'email': true,
                'equalTo': '#UserEmail'
            },
            'data[User][username]': {
                'required': true,
                'alphaNumeric': true,
                'minlength': 4,
                'maxlength': 20
            },
            'data[User][password]': 'required',
            'data[User][password_confirm]': {
                'required': true,
                'equalTo': '#UserPassword'
            },
            'data[UsersProfile][country_id]': 'required',
            'data[UsersProfile][grade_level]': 'required',
            'data[UsersProfile][subjectarea]': 'required',
            'data[User][terms]': {
                'required': true
            }
		},
		messages: {
            'data[User][email]': {
                'required': '* This field is required',
                'email': '* Invalid email address'
            },
            'data[User][email_confirm]': {
                'required': '* This field is required',
                'email': '* Invalid email address',
                'equalTo': '* This field is different from email'
            },
            'data[User][username]': {
                'required': '* This field is required',
                'alphaNumeric': '* Alphabets and numbers only',
                'minlength' : '* The length is incorrect, it must be between 4-20',
                'maxlength': '* The length is incorrect, it must be between 4-20'
            },
            'data[User][password]': '* This field is required',
            'data[User][password_confirm]': {
                'required': '* This field is required',
                'equalTo': '* This field is different from password'
            },
            'data[UsersProfile][country_id]': '* This field is required',
            'data[UsersProfile][grade_level]': '* This field is required',
            'data[UsersProfile][subjectarea]': '* This field is required',
            'data[User][terms]': { 'required': '* This checkbox is required' }
		},
        onfocusin: false,
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        highlight: function(element, errorClass, validClass) { return false; },
        unhighlight: function(element, errorClass, validClass) { return false; }
	});
    
    $('#UserEmail').focus();
});
</script>