<div class="login_page">
    <div class="login_page_content">
        <?php echo $this->Session->flash('auth'); ?>
        <?php echo $this->Session->flash('flash2'); ?>
        
        <div class="login_block left">
            <h3>Login</h3>
            <?php
            echo $this->Form->create('User', array('url' => $url_params, 'class' => 'form_style_1'));
                echo $this->Form->input('email', array('label' => 'Email:', 'class' => 'js-hide-tip'));
                echo $this->Form->input('password', array('label' => 'Password:', 'class' => 'js-hide-tip'));
                echo $this->Form->input('remember_me', array('type' => 'checkbox', 'label' => 'Remember me'));
            echo $this->Form->end('Login');
            ?>
        </div>
        
        <div class="signup_block left">
            <h3>Not Yet a Member?</h3>
            <p>Registration is free and easy</p>
            <?php
            echo $this->Html->link(
                'Signup',
                array('controller' => 'users', 'action' => 'signup', 'admin' => false),
                array('escape' => false)
            );
            ?>
        </div>
        <div class="forgot_block left">
            <h3>Having Trouble?</h3>
            <?php
            echo $this->Html->link(
                'I forgot my password',
                array('controller' => 'users', 'action' => 'forgot_password', 'admin' => false)
            );
            ?>
        </div>
        
        <div class="clear"> </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#UserLoginForm').validate({
        focusInvalid: false,
        ignore: false,
        errorClass: 'error-message',
    	errorElement: 'div',
        rules: {
            'data[User][username]': {
                'required' : true,
                'alphaNumeric' : true
            },
            'data[User][password]': 'required'
		},
		messages: {
			'data[User][username]': {
			    'required' : 'The username is missing!',
                'alphaNumeric' : 'Incorrect username! Only alpha-numeric characters allowed. No spaces allowed.' 
			},
            'data[User][password]': 'The password is missing!'
		},
        onfocusin: function(element, event) { return false; },
        onfocusout: function(element, event) { return false; },
        onkeyup: function(element, event) { return false; },
        onclick: function(element, event) { return false; },
        highlight: function(element, errorClass, validClass) { return false; },
        unhighlight: function(element, errorClass, validClass) { return false; }
	});
    
    $('#UserUsername').focus();
    
    setInterval(function(){
        if ($('.error-message').length > 1) {
                $('.error-message:first').css({'marginTop': '-4px'});
            }
        }, 
        200);
    
//      if ($.browser.msie && $.browser.version == '7.0') {
//        setInterval(function(){
//            if ($('.error-message').length > 1) {
//                $('.error-message:eq(1)').css({'marginTop':'-22px', 'marginLeft': '-4px'});
//            } else if ($('.error-message').length == 1 && $('#UserPassword').val() == '' && /^[a-zA-Z0-9]+$/.test($('#UserUsername').val())) {
//                $('.error-message:eq(0)').css({'marginTop':'-22px', 'marginLeft': '-4px'});
//            }
//        },
//        200);
//    }
    
    
});
</script>