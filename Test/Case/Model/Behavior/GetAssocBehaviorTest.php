<?php
/**
 * 
 * GetAssocBehaviorTest file
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
 * GetAssocBehaviorTest class
 *
 */
class GetAssocBehaviorTest extends CakeTestCase {

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
		$this->CustomerProfile->Behaviors->attach('UtilityBehaviors.GetAssoc');
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
 * testBelongsTo method
 *
 * @return void
 */
	public function testBelongsTo() {
		// WHEN we find list of Customer via $this->CustomerProfile
		$result = $this->CustomerProfile->getAssoc('Customer', 'list');

		// THEN we expect
		$expected = array(
			'2' => 'Zend',
			'4' => 'CodeIgniter'
		);

		$this->assertEquals($expected, $result);
	}
}
