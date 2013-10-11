<?php

class UserFixture extends CakeTestFixture {

	public $fields = array(
		'id'			=> array('type' => 'integer', 'key' => 'primary'),
		'username'	=> array('type' => 'string', 'length' => 255, 'null' => false),
		'group_id'	=> array('type' => 'integer', 'length' => 11, 'null' => false)
	);

	public $records = array(
		array('id' => 1, 'username' => 'CakePHP', 'group_id' => 1),
		array('id' => 2, 'username' => 'Zend', 'group_id' => 2),
		array('id' => 3, 'username' => 'Symfony', 'group_id' => 1),
		array('id' => 4, 'username' => 'CodeIgniter', 'group_id' => 2)
	);
}
