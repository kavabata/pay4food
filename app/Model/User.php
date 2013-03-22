<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
     public $loginValidate = array(
        'email' => array(
			'notempty' => array(
				'rule' => array('email'),
				'message' => 'The email is missing!',
				'allowEmpty' => false,
				'required' => true,
			)
		),
        'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'The password is missing!',
				'allowEmpty' => false,
				'required' => true,
			),
		)
    );
    public $forgotValidate = array(
        'email' => array(
			'rule' => array('email'),
			'message' => '* This field is required',
			'allowEmpty' => false,
			'required' => true
		)
    );

    public function forgotPassword($data)
    {
        $result = array(
            'status' => 'ok',
            'validationErrors' => array()
        );

        $this->validate = $this->forgotValidate;

        $this->set($data);
        $this->validates();


        if(!empty($this->validationErrors)) {
            $result['status'] = 'validation_error';
            $result['validationErrors'] = $this->validationErrors;
            return $result;
        }

        $user = $this->find('first', array(
            'conditions' => array(
                'User.email' => $data['User']['email'],
                'User.is_active' => 1
            ),
            'fields' => array(
                'User.id',
                'User.email'
            ),
            'recursive' => -1
        ));

        if(empty($user)) {
            $this->invalidate('email', 'The email address you\'ve entered does not belong to any account');
            $result['status'] = 'validation_error';
            $result['validationErrors'] = $this->validationErrors;
            return $result;
        }

        $hash = md5($user['User']['email'] . (time() + microtime()));

        $this->id = $user['User']['id'];
        if(!$this->saveField('hash', $hash)) {
            $this->User->invalidate('email', 'Email was not sent!');
            $result['status'] = 'validation_error';
            $result['validationErrors'] = $this->validationErrors;
            return $result;
        }

        $user['User']['hash'] = $hash;

        if (!$this->sendPasswordRequest($user)) {
            $this->invalidate('email', 'Email was not sent!');
            $result['status'] = 'validation_error';
            $result['validationErrors'] = $this->validationErrors;
            return $result;
        }

        return $result;
    }
    public function sendPasswordRequest($user = null) {
        if (!$user)
            return false;

        App::uses('CakeEmail', 'Network/Email');

        $Email = new CakeEmail();
        $Email->template('forgot_password', 'default');
        $Email->emailFormat('html');
        $Email->subject('Pay4Food forgotten password request');
        $Email->from(array('notreply@fay4food.com' => 'TeachersPayTeachers.com'));
        $Email->to($user['User']['email']);
        $Email->viewVars(array('username' => $user['User']['username'], 'hash' => $user['User']['hash']));
        return true;
    }
    public function sendNewPassword($user = null, $password = null) {
        $this->autoRender = false;

        if (!$user || !$password)
            return false;
        
        App::uses('CakeEmail', 'Network/Email');
        
        $Email = new CakeEmail();
        $Email->template('new_password', 'default');
        $Email->emailFormat('html');
        $Email->subject('Your Temporary Password for Pay4Food');
        $Email->from(array('notreply@pay4food.com' => 'Pay4Food.com'));
        $Email->to($user['User']['email']);
        $Email->viewVars(array('username' => $user['User']['email'], 'password' => $password));
        
        $Email->send();
        
        return true;
    }
}
