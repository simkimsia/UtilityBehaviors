<?php

class GroupFixture extends CakeTestFixture {

	public $fields = array(
		'id'			=> array('type' => 'integer', 'key' => 'primary'),
		'name'	=> array('type' => 'string', 'length' => 255, 'null' => false)
	);
	
	public $records = array(
		array('id' => 1, 'name' => 'Administrators'),
		array('id' => 2, 'name' => 'Customers'),
	);
}
