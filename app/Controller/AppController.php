<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    public $components = array(
        'DebugKit.Toolbar',
    	'Acl',
        'Auth',
        'Session', 
    	'Cookie',
        'Captcha',
    );
    
    public $helpers = array(
        'Html',
        'Session',
        'Form',
        'Js',
    );
    
    public $uses = array(
        'User',
    );
    public $user_data = array();
    public $user_id = null;
    public $js_vars = array();
    
	function beforeFilter() {
        $this->Cookie->httpOnly = false;
        $this->Cookie->secure = false;       
        
        //default title
	    $this->set('title_for_layout', 'Pay4Food - You always can get your debts back');
        $this->layout = 'default';
        
        $this->Auth->authenticate = array('Form' => array(
            'userModel' => 'Users.User',
            'scope' => array('User.is_active' => 1),
            'fields' => array('username' => 'email', 'password' => 'password')
        ));
        
        #if ($this->request->admin)
        #    $this->layout = 'admin';
                
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'transactions', 'action' => 'dashboard');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        
        $user_data = array();
        if($this->Auth->user()) {
            $user_data = $this->User->getUserDetails($this->Auth->user('id'));
            $this->user_data = $user_data['User'];
            $this->user_id = $user_data['User']['id'];
        } else {
            
            // login remembered user
            $is_remembered = $this->Cookie->read('User.remembered');
            
            if(empty($this->user_data) && !empty($is_remembered)) {
                $uhash = $this->Cookie->read('User.hash');
                $uid = substr($uhash,0,-30);
                if (!empty($uid)) {
                    $user_data = $this->User->getUserDetails($uid);
                    if (!empty($user_data) && $this->validateUser($user_data['User'],$uhash)) {
                        $this->Cookie->write('User.remembered', 1, false, '+100 days');
                        $this->Auth->loginRedirect = false;
                        if($this->Auth->login($user_data['User'])) {
                            $this->user_data = $user_data['User'];
                            $this->user_id = $user_data['User']['id'];
                            $this->Cookie->write('User.hash', $uhash, false, '+100 days');
                        }
                    }
                }
            }
            //-/ login remembered user
        }
        Configure::write('user_data', $this->user_data);
        $this->set('user_data',$this->user_data);
        $this->js_vars['servers']['main'] = Configure::read('Servers.main');
        $this->js_vars['path']['relative'] = Router::url('/');
        $this->js_vars['path']['absolute'] = Router::url('/', true);
        $this->js_vars['user']['is_logged_in'] = !empty($this->user_data);
	}
    public function validateUser($user_data,$uhash) {
        $user_key = $this->generateSID($user_data);
        if ($uhash != $user_key)
            return false;
        return true;
    }
    public function generateSID($user_data = null) {
        if (!$user_data)
            return false;
        return $user_data['id'] . substr(md5($user_data['email'] . $user_data['password'] . Configure::read('Security.salt')), 0, 30);
    }

}
