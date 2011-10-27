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
			pr($this->request->data['Actor']);
			die("here");
		}
	}
}


