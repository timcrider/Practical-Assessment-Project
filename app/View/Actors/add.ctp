<h1>Create A New Actor</h1>
<?php
print $this->Form->create('Actor');

foreach ($fields AS $field) {
	// Hidden form fields aren't needed in adds
	if (!$field['hidden']) {
       	if ($field['required']) {
            $required = '<span class="required">Field Required</span>';
       	} else {
            $required = '';
       	}

		switch ($field['type']) {
			case 'string':
			case 'text':
				print $this->Form->input($field['name'],
										 array(
										 	'before' => $required
										 ));
				break;

			case 'timestamp':
				print $this->Form->input($field['name'], 
										 array(
										 	'label'      => $field['label'], 
										 	'before'     => $required,
										 	'dateFormat' => 'DMY', 
										 	'minYear'    => date('Y'),
										 	'value'      => time(), 
										 	'maxYear'    => date('Y') + 5));
				break;
				
			default:
				pr($field);
				die("Unknown field type");
		}
	}
}

print $this->Form->button('Reset', array('type' => 'reset'));
print $this->Form->end('Create Actor');
