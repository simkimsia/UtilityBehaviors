<?php
/**
 *
 * ValidateFieldsBehaviorTest file
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
 * @version 0.1
 */

App::uses('Model', 'Model');
App::uses('AppModel', 'Model');
require_once dirname(dirname(__FILE__)) . DS . 'mock_models.php';
/**
 * ValidateFieldsTest class
 *
 */
class ValidateFieldsBehaviorTest extends CakeTestCase {

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
		$this->Group = ClassRegistry::init('Group');

		$this->User->bindModel(array(
			'belongsTo' => array(
			'Group' => array(
				'className' => 'Group',
				'foreignKey' => 'group_id',
			)
			)
		), false);
		$this->User->Behaviors->attach('UtilityBehaviors.ValidateFields');
	}

/**
 * Method executed after each test
 *
 */
	public function tearDown() {
		unset($this->User);
		unset($this->Group);
		parent::tearDown();
	}

/**
 * testCheckUniqueFields method
 *
 * @return void
 */
	public function testCheckUniqueFields() {
	}
}
