<div class="forgot_pass_page">
    <div class="forgot_pass_box">
        <div class="forgot_pass_content">
            <div class="flash">
                <?php //echo $this->Session->flash('flash3'); ?>
            </div>
            <h2>Forgot Password</h2>
            <p>Enter your email address to receive the password reset email. <br />
            If you don't receive an email from pay4food, <br />
            please make sure to check your junk mail folder.</p>
            <?php
            echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'forgot_password', 'admin' => false), 'class' => 'form_style_1'));
                echo $this->Form->input(
                    'email',
                    array('label' => 'Email:', 'class' => 'js-highlight js-hide-tip')
                );
                echo $this->Form->submit('Recover Password', array('class' => 'request_pass_btn'));
            echo $this->Form->end();
            ?>
            
            <div class="clear"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#UserForgotPasswordForm').validate({
        focusInvalid: false,
        ignore: false,
        errorClass: 'error-message',
    	errorElement: 'div',
        rules: {
            'data[User][email]': 'required'
		},
		messages: {
            'data[User][email]': '* This field is required'
		},
        onfocusin: function(element, event) { return false; },
        onfocusout: function(element, event) { return false; },
        onkeyup: function(element, event) { return false; },
        onclick: function(element, event) { return false; },
        highlight: function(element, errorClass, validClass) { return false; },
        unhighlight: function(element, errorClass, validClass) { return false; }
	});
    <?php if ($show_popup) : ?>
        Popup.load($('#forgot_password_success_message').html(), true, true);
    <?php endif; ?>
});
</script>