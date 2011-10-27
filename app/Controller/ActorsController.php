<?php
/**
* Main application controller
*/

// This requires the Actor model
App::import('Model', 'Actor');

class ActorsController extends AppController {
	// Uses HTML Forms
	public $helpers = array('Html', 'Form');
	public $name    = 'Actors';
	
    /**
    *  This method is called before the calling of any specific front end method.
    * Adding in all data prep work here and calling the parent after done
    */
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
		if ($this->request->is('post')) {
			$filters = $this->request->data['Filter'];
			$actors = $this->Actor->fetchAll($filters);
		} else {
			$actors = $this->Actor->fetchAll();
			$filters = array(
				'LastName'    => '',
				'BillingRate' => ''
			);
		}
		
		// hack for wild apostrophes
		foreach ($filters AS $key=>$val) {
			$filters[trim($key, "'")] = $val;
		}

		$this->set('filters', $filters);
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
	*  Reset the json database to default data. This is purely a testing function and should not
	* be active when the site launches.
	* @launch REMOVE ACCESS TO THIS FUNCTION
	*/
	public function flush() {
		$this->Actor->flush();
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	* Remove an actor based on the ID, and send the user back to the front page with a status.
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
	* Update an actor based on the ID, and send the user back to the front page with a status.
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


