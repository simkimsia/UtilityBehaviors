<?php
/**
 * FindXORCreatableBehavior Behavior class file.
 *
 * Within a single method, we can run a find if exists, else create function.
 *
 * Usage is straightforward:
 * From model: $this->findXORCreate($data, $findFields = array())
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
 * @subpackage UtilityBehaviors.Model.Behavior
 * @filesource
 * @version 0.1
 * @lastmodified 2013-11-07 
 */
class FindXORCreatableBehavior extends ModelBehavior {

/**
 * Behavior settings
 *
 * @access public
 * @var array
 */
	public $settings = array();

/**
 * Cake Model
 *
 * @access public
 * @var array
 */
	public $model = null;

/**
 * Configuration method.
 *
 * @param object $Model Model object
 * @param array $config Config array
 * @access public
 * @return boolean
 */
	public function setup(Model $Model, $config = array()) {
		$this->model = $Model;

		return true;
	}

/**
 *
 * Find a record XOR create a new record of this model
 * @param array $data. Should not contain data within the subarray of the mode.
 * @return array Either the found or newly created Model data 
 */
	public function findXORCreate(Model $model, $data = array(), $findFields = array()) {
		$suppliedData = array();
		if (isset($data[$model->alias])) {
			$suppliedData = $data[$model->alias];
		} else {
			$suppliedData = $data;
		}
		$conditions = array();
		if (empty($findFields)) {
			$conditions = $suppliedData;
		} else {
			foreach ($findFields as $field) {
				if (array_key_exists($field, $suppliedData)) {
					$conditions[$field] = $suppliedData[$field];
				} else {
					$conditions[$field] = null;
				}
			}
		}
		if (!$model->Behaviors->enabled('UtilityBehaviors.ValidateFields')) {
			$model->Behaviors->load('UtilityBehaviors.ValidateFields');
		}

		$validFindFields = $model->validateFields(array_keys($conditions), array('return' => 'valid'));

		foreach ($conditions as $field => $value) {
			if (!in_array($field, $validFindFields)) {
				unset($conditions[$field]);
			}
		}

		$found = $model->find('first', array(
			'conditions' => $conditions
		));
		if ($found) {
			return $found;
		} else {
			$model->create();
			$created = $model->save($suppliedData);
			return $created;
		}
	}
}