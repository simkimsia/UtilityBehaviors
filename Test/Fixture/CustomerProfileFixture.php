<?php
/**
 * CustomerProfileFixture
 *
 * Fixtures for a CustomerProfile model that belongsTo User as the relationship Customer
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
