<?php

class Actor {
	public $primaryKey = 'id';

	protected $actorsFile;
	protected $fieldsFile;
	
	protected $actors = array();
	protected $fields = array();
	
	public $installed = false;
	public $working   = true;
	public $errors    = array();

	public function __construct() {
		if ($this->_init()) {
		}
	}
	
	public function hasErrors() {
		return (empty($this->errors)) ? false : true;
	}
	
	private function _init() {
		// Load the actors data
		$this->actorsFile = Configure::read('Actor.dbFile');
		$this->fieldsFile = Configure::read('Actor.fieldsFile');
		
		if (!empty($this->actorsFile) && !empty($this->fieldsFile)) {
			if (!file_exists($this->actorsFile) || !file_Exists($this->fieldsFile)) {
				$this->installed = true;
				$this->_initData();
			}

			$this->_loadFields();
			$this->_loadActors();
		} else {
			$this->errors[] = "Unable to use the actors/fields db file. Please configure these in app/Config/core.php";
		}
		
		if (!$this->hasErrors()) {
			$this->working   = true;
			return true;
		} else {
			return false;
		}
		
		return $this->hasErrors();
	}
	
	public function schema() {
		return $this->fields;
	}
	
	private function _initData() {
		$actors = array();
		
		$actors[1] = array('id'            => 1,
						   'firstName'     => 'Tim',
						   'lastName'      => 'Crider',
						   'role'          => 'Developer',
						   'billingRate'   => '19.99/hr',
						   'interviewDate' => time(),
						   'notes'         => '');

		$this->writeDatafile($this->actorsFile, $actors);

		$fields = array();
		
		$fields['id'] = array(
			'name'       => 'id',
			'label'      => 'ID',
			'type'       => 'int',
			'hidden'     => true,
			'validation' => 'numeric',
			'maxLength'  => 0,
			'required'   => true,
			'core'       => true
		);

		$fields['firstName'] = array(
			'name'       => 'firstName',
			'label'      => 'First name',
			'type'       => 'string',
			'hidden'     => false,
			'validation' => 'notempty',
			'maxLength'  => 255,
			'required'   => true,
			'core'       => true
		);

		$fields['lastName'] = array(
			'name'       => 'lastName',
			'label'      => 'Last name',
			'type'       => 'string',
			'hidden'     => false,
			'validation' => 'notempty',
			'maxLength'  => 255,
			'required'   => true,
			'core'       => true
		);

		$fields['role'] = array(
			'name'       => 'role',
			'label'      => 'Role',
			'type'       => 'string',
			'hidden'     => false,
			'validation' => 'notempty',
			'maxLength'  => 255,
			'required'   => true,
			'core'       => true
		);

		$fields['billingRate'] = array(
			'name'       => 'billingRate',
			'label'      => 'Billing rate',
			'type'       => 'string',
			'hidden'     => false,
			'validation' => 'notempty',
			'maxLength'  => 0,
			'required'   => true,
			'core'       => true
		);

		$fields['interviewDate'] = array(
			'name'       => 'interviewDate',
			'label'      => 'Interview Date',
			'type'       => 'timestamp',
			'hidden'     => false,
			'validation' => 'timestamp',
			'maxLength'  => 0,
			'required'   => true,
			'core'       => true
		);

		$fields['notes'] = array(
			'name'       => 'notes',
			'label'      => 'Notes',
			'type'       => 'text',
			'hidden'     => false,
			'validation' => 'nohtml',
			'maxLength'  => 500,
			'required'   => true,
			'core'       => true
		);

		$this->writeDatafile($this->fieldsFile, $fields);
	}

	private function writeDatafile($file, $data = array()) {
		file_put_contents($file, json_encode($data));
	}

	private function openDatafile($file) {
		$data = file_get_contents($file);
		
		if (empty($data)) {
			$this->errors[] = "Unable to open data file: {$file}\n";
			return array();
		}
		
		if (!$data = json_decode($data)) {
			$this->errors[] = "Unable to fetch data from file: {$file}\n";
			return array();
		}
		
		$records = array();

		foreach ($data AS $key=>$val) {
			$tmp = array();
			
			foreach ($val AS $subKey=>$subVal) {
				$tmp[$subKey] = $subVal;
			}
			
			// Numeric keys mean records
			if (is_numeric($key)) {
				$records[$tmp['id']] = $tmp;
			} else {
				$records[$key] = $tmp;
			}
		}
		
		return $records;
	}


	private function _loadFields() {
		$this->fields = $this->openDataFile($this->fieldsFile);
	}
	
	private function _loadActors() {
		$this->actors = $this->openDataFile($this->actorsFile);
	}

	public function getNextId($data = array()) {
	
	}
	
	public function fetchAll() {
		return $this->actors;
	}
	
	public function fetchFields() {
		return $this->fields;
	}
	
	
	public function find() {
	
	}

	public function add($record = null) {
	
	}
	
	public function update($record = null) {
	
	}
	
	public function delete($recordId) {
	
	}

}
