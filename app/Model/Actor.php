<?php
/**
* Actor Model
*/

class Actor {
	// Needed for framework
	public $primaryKey = 'id';

	// Location of the json db files, this must be changed in app/Config/core.php
	protected $actorsFile;
	protected $fieldsFile;
	
	// Holders for the data
	protected $actors = array();
	protected $fields = array();
	
	// States of the model, and an error stack
	// @todo Error stack is populated but not displayed on the front end. Should have option to enable
	public $installed = false;
	public $working   = true;
	public $errors    = array();

	/**
	* Initialize our model and data set
	*/
	public function __construct() {
		$this->_init();
	}
	
	/**
	* Destroy the json data files
	*/
	public function flush() {
		unlink($this->actorsFile);
		unlink($this->fieldsFile);
	}
	
	/**
	* Quick test for checking if we have had any errors in the model
	*/
	public function hasErrors() {
		return (empty($this->errors)) ? false : true;
	}
	
	/**
	* Initialze the data. This method is the core of how the json database would work
	* @todo Remove this and move it to a DataSource so it could easily be ported to other datatypes
	*/
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

	/**
	* This is needed by the framework
	*/	
	public function schema() {
		return $this->fields;
	}

	/**
	* Populate the default data sets
	* @note This is where you add new fields to the data sets.
	* @todo Cleanup this method and add a few more test records
	*/	
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

	/**
	* Convert the current recordset into a data store
	* @todo Move this into a datasource
	*/
	private function writeDatafile($file, $data = array()) {
		file_put_contents($file, json_encode($data));
	}

	/**
	* Convert the current data store into a record set
	* @todo Move this into a datasource
	*/
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


	/**
	* Calls the loader and stores fields locally
	* @todo Add in better integrity tests here
	*/
	private function _loadFields() {
		$this->fields = $this->openDataFile($this->fieldsFile);
	}
	
	/**
	* Calls the loader and stores actor locally
	* @todo Add in better integrity tests here
	*/
	private function _loadActors() {
		$this->actors = $this->openDataFile($this->actorsFile);
	}

	/**
	* Fetch the next available sequence ID
	* @note This is only valid for records, not fields since fields have text keys
	*/
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

	/**
	* Limit records based on a filter
	* @todo Add date range
	* @todo Work on making exclude toggle work in allowing ANY match instead of ALL match
	*/	
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

	/**
	* Fetch all the actors, and if a filters array is specified filter out data
	* @todo Allow passing of filter type
	*/	
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

	/**
	* Feth the current field stack
	*/	
	public function fetchFields() {
		return $this->fields;
	}
	
	/**
	* Fetch a single actor record based on the id
	*/	
	public function find($id = null) {
		if (empty($this->actors[$id])) {
			$this->errors[] = "Record {$id} does not exist";
			return false;
		}
		
		return $this->actors[$id];
	}

	/**
	* Convert the cake time array into a stamp we can use
	*/	
	public function date2timestamp($date = array()) {
		if ($date['meridian'] == 'pm') {
			$date['hour'] += 12;
		}

		return mktime($date['hour'], $date['min'], 0, $date['month'], $date['day'], $date['year']);
	}

	/**
	* Create an actor
	*/
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
	
	/**
	* Update actor based on id
	* @todo Work on moving updates to a backup data store to enable versioning
	*/
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

	/**
	* Remove actor based on id
	* @todo Work on moving removals to a backup data store in order to pull records out of the trash
	*/	
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
