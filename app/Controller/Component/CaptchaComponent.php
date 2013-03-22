<?php

App::import('Vendor', 'phpcaptcha/phpcaptcha');

class CaptchaComponent extends Component {
	var $name = 'Captcha';
    
    function initialize($controller, $settings = array()) {
        // saving the controller reference for later use
        $this->controller = $controller;
    }
    
    function image() {
        
        $imagesPath = APP . 'Vendor' . DS . 'phpcaptcha' . '/fonts/';
        
        $aFonts = array(
            $imagesPath . 'VeraBd.ttf',
            $imagesPath . 'VeraIt.ttf',
            $imagesPath . 'Vera.ttf'
        );
        
        $oVisualCaptcha = new PhpCaptcha($aFonts, 150, 40);
        
        $oVisualCaptcha->UseColour(true);
        //$oVisualCaptcha->SetOwnerText('Source: '.FULL_BASE_URL);
        //$oVisualCaptcha->SetNumChars(6);
        $oVisualCaptcha->Create();
    }
    
    function audio() {
        $oAudioCaptcha = new AudioPhpCaptcha('/usr/bin/flite', '/tmp/');
        $oAudioCaptcha->Create();
    }
    
    function check($userCode, $caseInsensitive = true) {
        if ($caseInsensitive)
            $userCode = strtoupper($userCode);
        
        if (empty($_SESSION[CAPTCHA_SESSION_ID]) || $userCode != $_SESSION[CAPTCHA_SESSION_ID])
            return false;
        
        // clear to prevent re-use
        unset($_SESSION[CAPTCHA_SESSION_ID]);

        return true;
    }
}
