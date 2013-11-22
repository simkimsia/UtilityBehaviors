<?php
/**
 * GroupFixture
 *
 * Fixtures for a Group model that hasMany User as the relationship User
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
class GroupFixture extends CakeTestFixture {

	public $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'name' => array('type' => 'string', 'length' => 255, 'null' => false),
		'total_profile_count' => array('type' => 'integer', 'length' => 8, 'null' => false)
	);

	public $records = array(
		array('id' => 1, 'name' => 'Administrators', 'total_profile_count' => 0),
		array('id' => 2, 'name' => 'Customers', 'total_profile_count' => 0),
	);
}
