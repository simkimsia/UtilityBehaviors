<?php
/**
 * 
 * AggregateCacheBehaviorTest file
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
 * AggregateCacheTest class
 *
 */
class AggregateCacheBehaviorTest extends CakeTestCase {

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
		$this->User->Behaviors->attach('UtilityBehaviors.AggregateCache', array(
				array(
					'field' => 'profile_count',
					'model' => 'Group',
					'sum' => 'total_profile_count',
					'sum_default_when_null' => 0,
				)
		));
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
 * testAggregateCacheWorksAfterSaveChild method
 *
 * @return void
 */
	public function testAggregateCacheWorksAfterSaveChild() {
		// GIVEN the following data array
		$data = array(
			'User' => array(
				'id' => 2,
				'group_id' => 2
			)
		);
		// WHEN we find extractByAlias
		$this->User->save($data);
		$group = $this->Group->read(null, 2);

		// THEN we expect
		$expected = array(
			'Group' =>
				array(
					'id' => 2, 'name' => 'Customers', 'total_profile_count' => 2
				)
		);

		$this->assertEquals($expected, $group);
	}
}
