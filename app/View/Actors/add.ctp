<h1>Create A New Author</h1>
<?php
print $this->Form->create('Actor');

foreach ($fields AS $field) {
	// Hidden form fields aren't needed in adds
	if (!$field['hidden']) {
		switch ($field['type']) {
			case 'string':
			case 'text':
				print $this->Form->input($field['name']);
				break;

			case 'timestamp':
				print $this->Form->input($field['name'], 
										 array(
										 	'label'      => $field['label'], 
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

print $this->Form->end('Create Author');
?>
