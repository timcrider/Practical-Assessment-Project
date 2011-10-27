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
	
	public function flush() {
		unlink($this->actorsFile);
		unlink($this->fieldsFile);
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
						   'address'       => '1234 Main Str',
						   'address2'      => 'Apt 123',
						   'city'		   => 'Anytown',
						   'state'		   => 'MD',
						   'zipCode'       => '12345-5555',
						   'phone'		   => '555-123-1234',
						   'email'         => 'timcrider@gmail.com',
						   'role'          => 'Developer',
						   'billingRate'   => '19.99/hr',
						   'interviewDate' => time(),
						   'notes'         => 'This is an example note.');

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

		$fields['address'] = array(
			'name'       => 'address',
			'label'      => 'Address',
			'type'       => 'string',
			'hidden'     => false,
			'validation' => 'notempty',
			'maxLength'  => 255,
			'required'   => true,
			'core'       => true
		);

		$fields['address2'] = array(
			'name'       => 'address2',
			'label'      => 'Address 2',
			'type'       => 'string',
			'hidden'     => false,
			'validation' => 'notempty',
			'maxLength'  => 255,
			'required'   => false,
			'core'       => true
		);

		$fields['city'] = array(
			'name'       => 'city',
			'label'      => 'City',
			'type'       => 'string',
			'hidden'     => false,
			'validation' => 'notempty',
			'maxLength'  => 255,
			'required'   => true,
			'core'       => true
		);

		$fields['state'] = array(
			'name'       => 'state',
			'label'      => 'State',
			'type'       => 'string',
			'hidden'     => false,
			'validation' => 'notempty',
			'maxLength'  => 255,
			'required'   => true,
			'core'       => true
		);

		$fields['zipCode'] = array(
			'name'       => 'zipCode',
			'label'      => 'Zip Code',
			'type'       => 'string',
			'hidden'     => false,
			'validation' => 'notempty',
			'maxLength'  => 255,
			'required'   => true,
			'core'       => true
		);

		$fields['phone'] = array(
			'name'       => 'phone',
			'label'      => 'Phone',
			'type'       => 'string',
			'hidden'     => false,
			'validation' => 'notempty',
			'maxLength'  => 255,
			'required'   => true,
			'core'       => true
		);

		$fields['email'] = array(
			'name'       => 'email',
			'label'      => 'Email',
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
		$maxid = 0;
		foreach ($data AS $record) {
			if ($record['id'] > $maxid) {
				$maxid = $record['id'];
			}
		}
		$maxid++;
		
		if (!empty($data[$maxid])) {
			$this->errors[] = "Id collision for {$maxid}, cannot create record.";
			return false;
		}
		return $maxid;
	}
	
	protected function filter($filter, $value, $actors = array(), $exclude=true) {
		// ignore empty filters
		if (empty($value)) {
			return $actors;
		}
		
		// hacking in clean up for goofy post var passing
		$filter = trim($filter, "'");
		$matches = array();

		foreach ($actors AS $id=>$actor) {
			switch ($filter) {
				case 'LastName':
					if (preg_match("/{$value}/i", $actor['lastName'])) {
						$matches[$id] = $id;
					} else {
						// @todo Make this work to allow matching any
						if ($exclude) {
							break;
						}
					}
			
				case 'BillingRate':
					if (preg_match("/{$value}/i", $actor['billingRate'])) {
						$matches[$id] = $id;
					} else {
						// @todo Make this work to allow matching any
						if ($exclude) {
							break;
						}
					}
			}		
		}

		$out = array();

		foreach ($matches AS $match) {
			$out[$match] = $actors[$match];
		}
		
		return $out;
	}
	
	public function fetchAll($filters = array()) {
		if (empty($filters)) {
			return $this->actors;
		}
		
		$matches = $this->actors;
		
		foreach ($filters AS $filter=>$value) {
			$matches = $this->filter($filter, $value, $matches, true);
		}
		return $matches;
	}
	
	public function fetchFields() {
		return $this->fields;
	}
	
	
	public function find($id = null) {
		if (empty($this->actors[$id])) {
			$this->errors[] = "Record {$id} does not exist";
			return false;
		}
		
		return $this->actors[$id];
	}
	
	public function date2timestamp($date = array()) {
		if ($date['meridian'] == 'pm') {
			$date['hour'] += 12;
		}

		return mktime($date['hour'], $date['min'], 0, $date['month'], $date['day'], $date['year']);
	}

	public function add($record = null) {
		$record['id']            = $this->getNextId($this->actors);
		$record['interviewDate'] = $this->date2timestamp($record['interviewDate']);
		$record['notes']         = substr(strip_tags($record['notes']), 0, 500);
		
		if (!$record['id']) {
			$this->errors[] = "Unable to create record";
			return false;
		}
		
		$this->actors[$record['id']] = $record;
		$this->writeDatafile($this->actorsFile, $this->actors);
		return $record;
	}
	
	public function update($id = null, $record = null) {
		if (empty($this->actors[$id])) {
			$this->errors[] = "Record {$id} does not exist";
			return false;
		}
	
		$record['id']            = $id;
		$record['interviewDate'] = $this->date2timestamp($record['interviewDate']);
        $record['notes']         = substr(strip_tags($record['notes']), 0, 500);
		$this->actors[$id]       = $record;
		
		$this->writeDatafile($this->actorsFile, $this->actors);
		return true;
	}
	
	public function delete($id = null) {
		if (empty($this->actors[$id])) {
			$this->errors[] = "Record {$id} does not exist";
			return false;
		}
		
		unset($this->actors[$id]);
		$this->writeDatafile($this->actorsFile, $this->actors);
		return true;
	
	}

}
