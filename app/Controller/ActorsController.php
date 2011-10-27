<?php

App::import('Model', 'Actor');

class ActorsController extends AppController {
	public $helpers = array('Html', 'Form');
	public $name    = 'Actors';
	
	public function beforeFilter() {
		// Setup Actors
		$this->Actor = new Actor;
		
		if ($this->Actor->installed) {
			$this->Session->setFlash('No data was found, default dataset loaded');
		}

		$fields = $this->Actor->fetchFields();
		$this->set('fields', $fields);

		parent::beforeFilter();
	}
	
	/**
	* Starter page for viewing authors
	*/	
	public function index() {
		$actors = $this->Actor->fetchAll();
		$this->set('actors', $actors);
	}
	
	/**
	* Create a new author
	*/
	public function add() {
		if ($this->request->is('post')) {
			if ($this->Actor->add($this->request->data['Actor'])) {
				$this->Session->setFlash("Record Created");
			} else {
				$this->Session->setFlash("Unable to create record");
			}

			$this->redirect(array('action' => 'index'));
		}
	}
	
	/**
	*
	*/
	public function flush() {
		$this->Actor->flush();
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	*
	*/
	public function delete($id = null) {
		if ($this->Actor->delete($id)) {
			$this->Session->setFlash("Record {$id} deleted");
		} else {
			$this->Session->setFlash("Unable to delete record {$id} ");
		}
		
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	*
	*/
	public function edit($id = null) {
		$actor = $this->Actor->find($id);

		if (empty($id) || empty($actor)) {
			$this->Session->setFlash("Unable to edit record '{$id}'");
			$this->redirect(array('action' => 'index'));
			return;
		}

		if ($this->request->is('post')) {
			if ($this->Actor->update($id, $this->request->data['Actor'])) {
				$this->Session->setFlash("Record Updated");
			} else {
				$this->Session->setFlash("Unable to update record");
			}

			$this->redirect(array('action' => "edit/{$id}"));
		} else {
			$this->set('actor', $actor);
		}
	}
}


