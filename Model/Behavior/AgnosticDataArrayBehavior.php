<?php
/**
 * Treat data array as agnostic. Behavior class file extracts
 * the data for the correct model or fields.
 *
 * Adds ability to extract the right data for the right model or fields
 * regardless how the data array is formatted
 *
 * Usage is straightforward:
 * From model: $this->extractByAlias($array); // array = the array which you may or may not have subarray
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
 */
App::uses('Hash', 'Utility');
class AgnosticDataArrayBehavior extends ModelBehavior {

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
 * Extract all relevant data based on Model alias
 * @param array $data. Data array
 * @param string $alias. Optional. Default null. If null, we use the $model->alias
 * @return array Either the subarray or the entire array.
 */
	public function extractByAlias(Model $model, $data, $alias = null) {
		if ($alias == null) {
			$alias = $model->alias;
		}
		$suppliedData = array();
		if (isset($data[$alias])) {
			$suppliedData = $data[$alias];
		} else {
			$suppliedData = $data;
		}
		return $suppliedData;
	}

/**
 *
 * Extract relevant data based on Model alias
 * @param array $data. Data array
 * @param array $options Options array that contains the following 2 keys
 	- fields: array of the fields we want to extract
 	- alias: string $alias. Optional. Default null. If null, we use the $model->alias
 * @param array pass by reference. &$missingFields is array listing all the fields that are missing
 * @return array Extracted fields and their values.
 */
	public function extractByFields(Model $model, $data, $options = array(), Array $missingFields) {
		$defaultOptions = array(
			'alias' => null,
			'fields' => array()
		);
		$options = array_merge($defaultOptions, $options);
		extract($options);
		if ($alias == null) {
			$alias = $model->alias;
		}
		if (empty($fields)) {
			return $this->extractByAlias($model, $data, $alias);
		}

		$mainModelData = $this->extractByAlias($model, $data, $alias);
		$results = array();
		foreach($fields as $field) {
			$model->log($field);
			$lookForMainModelField = (strpos($field, '.') === false);
			if ($lookForMainModelField) {
				$alternativeField = $alias . '.' . $field;
				if (Hash::check($mainModelData, $field)) {
					$results[$field] = $mainModelData[$field];
				} else if (Hash::check($data, $alternativeField)) {
					$results[$field] = Hash::get($data, $alternativeField);
				} else {
					$missingFields[] = $field;
				}
			} else {
				if (Hash::check($data, $field)) {
					$results[$field] = Hash::get($data, $field);
				} else {
					$missingFields[] = $field;
				}
			}
		}
		return $results;
	}
}