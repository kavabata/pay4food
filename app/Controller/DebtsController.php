<?php
App::uses('AppController', 'Controller');
/**
 * Debts Controller
 *
 * @property Debt $Debt
 */
class DebtsController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Js');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Debt->recursive = 0;
		$this->set('debts', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Debt->exists($id)) {
			throw new NotFoundException(__('Invalid debt'));
		}
		$options = array('conditions' => array('Debt.' . $this->Debt->primaryKey => $id));
		$this->set('debt', $this->Debt->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Debt->create();
			if ($this->Debt->save($this->request->data)) {
				$this->Session->setFlash(__('The debt has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The debt could not be saved. Please, try again.'));
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
		if (!$this->Debt->exists($id)) {
			throw new NotFoundException(__('Invalid debt'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Debt->save($this->request->data)) {
				$this->Session->setFlash(__('The debt has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The debt could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Debt.' . $this->Debt->primaryKey => $id));
			$this->request->data = $this->Debt->find('first', $options);
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
		$this->Debt->id = $id;
		if (!$this->Debt->exists()) {
			throw new NotFoundException(__('Invalid debt'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Debt->delete()) {
			$this->Session->setFlash(__('Debt deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Debt was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Debt->recursive = 0;
		$this->set('debts', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Debt->exists($id)) {
			throw new NotFoundException(__('Invalid debt'));
		}
		$options = array('conditions' => array('Debt.' . $this->Debt->primaryKey => $id));
		$this->set('debt', $this->Debt->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Debt->create();
			if ($this->Debt->save($this->request->data)) {
				$this->Session->setFlash(__('The debt has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The debt could not be saved. Please, try again.'));
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
		if (!$this->Debt->exists($id)) {
			throw new NotFoundException(__('Invalid debt'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Debt->save($this->request->data)) {
				$this->Session->setFlash(__('The debt has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The debt could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Debt.' . $this->Debt->primaryKey => $id));
			$this->request->data = $this->Debt->find('first', $options);
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
		$this->Debt->id = $id;
		if (!$this->Debt->exists()) {
			throw new NotFoundException(__('Invalid debt'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Debt->delete()) {
			$this->Session->setFlash(__('Debt deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Debt was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
