<?php
class EntryMetasController extends AppController {

	var $name = 'EntryMetas';

	function index() {
		$this->EntryDetail->recursive = 0;
		$this->set('entryDetails', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid entry detail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('entryDetail', $this->EntryDetail->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->EntryDetail->create();
			if ($this->EntryDetail->save($this->data)) {
				$this->Session->setFlash(__('The entry detail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entry detail could not be saved. Please, try again.', true));
			}
		}
		$entries = $this->EntryDetail->Entry->find('list');
		$attributes = $this->EntryDetail->Attribute->find('list');
		$this->set(compact('entries', 'attributes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid entry detail', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->EntryDetail->save($this->data)) {
				$this->Session->setFlash(__('The entry detail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entry detail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EntryDetail->read(null, $id);
		}
		$entries = $this->EntryDetail->Entry->find('list');
		$attributes = $this->EntryDetail->Attribute->find('list');
		$this->set(compact('entries', 'attributes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for entry detail', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EntryDetail->delete($id)) {
			$this->Session->setFlash(__('Entry detail deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Entry detail was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
