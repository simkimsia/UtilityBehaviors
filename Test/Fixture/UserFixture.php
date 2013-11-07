<?php
/**
 * UserFixture
 *
 * Fixtures for a User model that belongsTo Group as the relationship Group
 * and hasOne CustomerProfuile as the relationship CustomerProfile
 *
 * Copyright 2013, Kim Stacks
 * Singapore
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2013, Kim Stacks.
 * @link http://stacktogether.com
 * @author Kim Stacks <kim@stacktogether.com>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package UtilityBehaviors
 * @subpackage UtilityBehaviors.Test.Fixture
 * @filesource
 * @version 0.1
 * @lastmodified 2013-11-07 
 */
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
