<?php
App::uses('AppController', 'Controller');
/**
 * Transactions Controller
 *
 * @property Transaction $Transaction
 */
class TransactionsController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Js');
  public $uses = array('Transaction','Debt');

    public function dashboard(){
    }


    public function payout(){
        
    }
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Transaction->recursive = 0;
		$this->set('transactions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Transaction->exists($id)) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
		$this->set('transaction', $this->Transaction->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
	    $groups = array();
        foreach($this->User->getGroups($this->user_id) as $group) {
            $groups[$group['id']] = $group['name'].' ['.$group['currency'].']';
        }
	    $this->set(compact('groups'));
       
		if ($this->request->is('post')) {
      if ($this->data['Transaction']['personal'] == '0') {
  			$this->Transaction->create();
  			if ($this->Transaction->save($this->request->data)) {
              $transaction_id = $this->Transaction->id;
              $part = round($this->data['Transaction']['paid']/sizeof($this->data['Debt']['user_id']),2);
      		    foreach($this->data['Debt']['user_id'] as $userid=>$on) {
      		       $debt = array('Debt'=>array(
                          'transaction_id'=>$transaction_id,
                          'group_id'=>$this->data['Transaction']['group_id'],
                          'user_id'=>$userid,
                          'debt'=>$part                          
                     ));
                $this->Debt->create();
                $this->Debt->save($debt);
      		    }
  				$this->Session->setFlash(__('The transaction has been saved'));
  				$this->redirect(array('action' => 'index'));
  			} else {
  				$this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
  			}
     }else{
        $total = 0;
        foreach($this->data['Debt']['debt'] as $userid=>$debt) {
           $total = $total + (float)$debt;
        }
        $this->request->data['Transaction']['paid'] = $total;
      	$this->Transaction->create();
  			if ($this->Transaction->save($this->request->data)) {
          $transaction_id = $this->Transaction->id;
          foreach($this->data['Debt']['debt'] as $userid=>$debt) {
               if((float)$debt <= 0) continue;
               $debt = array('Debt'=>array(
                        'transaction_id'=>$transaction_id,
                        'group_id'=>$this->data['Transaction']['group_id'],
                        'user_id'=>$userid,
                        'debt'=>(float)$debt
                   ));
              $this->Debt->create();
              $this->Debt->save($debt);
          }
 				   $this->Session->setFlash(__('The transaction has been saved'));
  				$this->redirect(array('action' => 'index'));
        }else{
          $this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
        }
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
		if (!$this->Transaction->exists($id)) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Transaction->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
			$this->request->data = $this->Transaction->find('first', $options);
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
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Transaction->delete()) {
			$this->Session->setFlash(__('Transaction deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transaction was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Transaction->recursive = 0;
		$this->set('transactions', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Transaction->exists($id)) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
		$this->set('transaction', $this->Transaction->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Transaction->create();
			if ($this->Transaction->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
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
		if (!$this->Transaction->exists($id)) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Transaction->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
			$this->request->data = $this->Transaction->find('first', $options);
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
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Transaction->delete()) {
			$this->Session->setFlash(__('Transaction deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transaction was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
