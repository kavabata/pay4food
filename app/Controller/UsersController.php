<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

    function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

/**
 * index login
 *
 * @return void
 */
    public function login(){
        $this->User->validate = $this->User->loginValidate;

        $url_params = array('?' => false);
        
        if (isset($this->request->query['f']))
            $url_params['?']['f'] = $this->request->query['f'];
        
        if (isset($this->request->query['anchor']))
            $url_params['?']['anchor'] = $this->request->query['anchor'];
        
        $this->set('url_params', $url_params);

        header('Cache-Control: no-cache, no-store, must-revalidate'); 
        header('Pragma: no-cache'); 
        header('Expires: 0');

        //if user post login form when he is logged in already
        if(!empty($this->user_data['id'])){
            $this->redirect('/Dashboard');
            die();
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            
            //if user post login form when he is logged in already
            if(!empty($this->user_data['id'])){
                $this->redirect('/Dashboard/');
                die();
			}
			           
            $this->User->set($this->request->data);
            $this->User->validates();
            
            if (empty($this->User->validationErrors)) {
                if ($this->Auth->login()) {
                    $user = $this->User->getUserDetails($this->Auth->user('id'));
                    $this->user_data = $user['User'];

                    //remember user
                    if ($this->request->data['User']['remember_me']) {
                        $this->Cookie->write('User.remembered', 1, false, '+100 days');
                    }
                    //-/remember user
                    
                    
                    $redirect_str = '';
                    
                    if (isset($this->request->query['f']))
                        $redirect_str .= $this->request->query['f'];
                    
                    if (isset($this->request->query['anchor']))
                        $redirect_str .= '#' . $this->request->query['anchor'];
                        
                    if (!empty($redirect_str))
                        $this->redirect($redirect_str);
                    
                    $this->redirect($this->Auth->redirect());
                } else
                    $this->Session->setFlash(__('The username/password combination doesn\'t match.'), 'default', array(), 'auth');
            }
        } elseif ($this->Auth->user()) {
            $this->redirect($this->Auth->redirect());
        }
    }

/**
 * forgot_password method
 *
 * @return void
 */
    public function forgot_password(){
        die('fp');
        $this->set('show_popup', $this->Session->read('ForgotPasswordSuccess'));
        $this->Session->write('ForgotPasswordSucess', false);

        if ($this->request->is('post') || $this->request->is('put')) {

            $fp_res = $this->User->forgotPassword($this->request->data);

            if($fp_res['status'] == 'ok') {
                $this->Session->write('ForgotPasswordSuccess', true);
                $this->redirect(array('controller' => 'users', 'action' => 'forgot_password'));
            }
        }

        $this->Session->write('ForgotPasswordSuccess', false);
    }
    
/**
 * get_new_password method
 * 
 * @param string $hash
 * @return void
 */
    public function get_new_password($hash = null) {
        if (empty($hash)) {
            $this->Session->setFlash('This user does not exist.', 'default', array(), 'flash2');
            $this->redirect(array('action' => 'login'));
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.hash' => $hash,
                'User.is_active' => 1,
                'User.is_deleted' => 0
            ),
            'fields' => array(
                'User.id',
                'User.email'
            ),
            'recursive' => -1
        ));
        if (!$user) {
            $this->Session->setFlash('This user does not exist.', 'default', array(), 'flash2');
            $this->redirect(array('action' => 'login'));
        }
        $password_hash = md5($user['User']['email'] . (time() + microtime()));
        $new_password = substr($password_hash, 0, 8);
        
        $data = array(
            'User' => array(
                'password' => $new_password,
                'modified' => date('Y-m-d H:i:s'),
                'hash' => null
            )
        );
        
        $this->User->id = $user['User']['id'];
        if (!$this->User->save($data, false)) {
            $this->Session->setFlash(__('New password was not sent. Please try again later.'));
            $this->redirect(array('action' => 'login'));
        }
        
        if (!$this->User->sendNewPassword($user, $new_password)) {
            $this->Session->setFlash(__('New password was not sent. Please try again later.'));
            $this->redirect(array('action' => 'login'));
        }
        
        $this->Session->setFlash('Your password has been reset. Your username and password have been sent to the email address.', 'default', array(), 'flash2');
        $this->redirect(array('action' => 'login'));
    }
    public function signup(){
        $this->render('signup');
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
