<?php

class CustomerProfileFixture extends CakeTestFixture {

	public $fields = array(
		'id'			=> array('type' => 'integer', 'key' => 'primary'),
		'customer_id'	=> array('type' => 'integer'),
		'biography'		=> array('type' => 'string', 'length' => 255, 'null' => false)
	);

	public $records = array(
		array ('id' => 1, 'customer_id' => 2, 'biography' => ''),
		array ('id' => 2, 'customer_id' => 4, 'biography' => ''),
	);
}
