<?php
/**
 * 
 * AgnosticDataArrayBehaviorTest file
 *
 * PHP 5
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
 * @subpackage UtilityBehaviors.Test.Case.Model.Behavior
 * @filesource
 * @version 0.1
 * @lastmodified 2013-11-07
 */

App::uses('Model', 'Model');
App::uses('AppModel', 'Model');
require_once dirname(dirname(__FILE__)) . DS . 'mock_models.php';
/**
 * AgnosticDataArrayTest class
 *
 */
class AgnosticDataArrayTest extends CakeTestCase {
	public $fixtures = array(
		'plugin.utility_behaviors.user',
		'plugin.utility_behaviors.customer_profile',
		'plugin.utility_behaviors.group',
	);

/**
 * Method executed before each test
 *
 */
	public function setUp() {
		parent::setUp();
		$this->User = ClassRegistry::init('User');
		$this->CustomerProfile = ClassRegistry::init('CustomerProfile');

		$this->CustomerProfile->bindModel(array(
			'belongsTo' => array(
				'Customer' => array(
					'className' => 'User',
					'foreignKey' => 'customer_id',
					'conditions' => array('Customer.group_id' => 2),
				)
			)
		), false);
		$this->CustomerProfile->Behaviors->attach('UtilityBehaviors.AgnosticDataArray');
		$this->User->Behaviors->attach('UtilityBehaviors.AgnosticDataArray');
	}

/**
 * Method executed after each test
 *
 */
	public function tearDown() {
		unset($this->User);
		unset($this->CustomerProfile);
		parent::tearDown();
	}


/**
 * testExtractByAlias method
 *
 * @return void
 */
	public function testExtractByAlias() {
		// GIVEN the following data array
		$data = array(
			'CustomerProfile' => array (
				'customer_id' => 2, 
				'biography' => 'Another Customer Profile'
			),
			'User' => array(
				'id' => 2,
			)
		);
		// WHEN we find extractByAlias
		$result = $this->CustomerProfile->extractByAlias($data);

		// THEN we expect
		$expected = array(
			'customer_id' => 2,
			'biography' => 'Another Customer Profile'
		);

		$this->assertEquals($expected, $result);
	}
}
