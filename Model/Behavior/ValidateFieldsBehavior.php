<?php
/**
 * ValidateFields Behavior class file.
 *
 * Within a single method, we can run a validateFields function.
 *
 * Usage is straightforward:
 * using default options
 * From model: $this->validateFields($fields)
 * if you want to stop at the first invalid field
 * From model: $this->validateFields($fields, array('stop' => 'first'));
 * if you don't want to stop at the first invalid field
 * From model: $this->validateFields($fields, array('stop' => false));
 * if you want to stop at the first invalid field and you want to know which fields are invalid
 * From model: $this->validateFields($fields, array('stop' => false), $invalidFields);
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
class ValidateFieldsBehavior extends ModelBehavior {

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
 * Inspired by http://api.cakephp.org/2.3/source-class-Model.html#1386
 * Validates all fields in the given array
 * @param array $fields. An array of field names. 
 * 				If supplied a single string, will attempt to cast as array
 * 				if neither string nor array, will always return false;
 * @param array $options. Array with following keys
 *			'stop' : either false or 'first' Default false
 *			'checkVirtual' : boolean Will check virtual fields. Default false.
 *			'return' : either 'valid' or 'boolean'. Default 'boolean' If there is invalid fields, we return boolean or valid fields
 * @param array &$invalidFields. An array of invalid fields. Pass by reference.
 * @return mixed.	If we have at least 1 invalid field and the return option is valid, return array of valid fields.
 *			If we have at least 1 invalid field and the return option is boolean, return false.
 * 			If no invalid fields, returns the entire $fields array.
 */
	public function validateFields(Model $model, $fields, $options = array(), &$invalidFields = array()) {
		$defaults = array(
			'stop' => false,
			'checkVirtual' => false,
			'return' => 'boolean'
		);
		$options = array_merge($defaults, $options);
		if (is_string($fields)) {
			$fields = array($fields);
		}
		if (is_array($fields)) {
			foreach ($fields as $field) {
				if ($model->hasField($field, $options['checkVirtual']) === false) {
					if ($options['stop'] === 'first') {
						return false;
					}
					if ($options['stop'] === false) {
						$invalidFields[] = $field;
					}
				}
			}
			if (empty($invalidFields)) {
				return $fields;
			} else {
				if ($options['return'] === 'boolean') {
					return false;
				}
				if ($options['return'] === 'valid') {
					return array_diff($fields, $invalidFields);
				}
			}
		}
		return false;
	}
}