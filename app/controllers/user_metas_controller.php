<?php
class UserMetasController extends AppController {

	var $name = 'UserMetas';

	function index() {
		$this->UserDetail->recursive = 0;
		$this->set('userDetails', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user detail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('userDetail', $this->UserDetail->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->UserDetail->create();
			if ($this->UserDetail->save($this->data)) {
				$this->Session->setFlash(__('The user detail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user detail could not be saved. Please, try again.', true));
			}
		}
		$users = $this->UserDetail->User->find('list');
		$attributes = $this->UserDetail->Attribute->find('list');
		$this->set(compact('users', 'attributes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user detail', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->UserDetail->save($this->data)) {
				$this->Session->setFlash(__('The user detail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user detail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UserDetail->read(null, $id);
		}
		$users = $this->UserDetail->User->find('list');
		$attributes = $this->UserDetail->Attribute->find('list');
		$this->set(compact('users', 'attributes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user detail', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UserDetail->delete($id)) {
			$this->Session->setFlash(__('User detail deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User detail was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
