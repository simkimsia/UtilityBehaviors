<?php
/**
 * Bindable Behavior class file.
 *
 * Adds convenient unbindAll and bind methods
 *
 *
 * Usage is straightforward:
 * From model: $this->unbindAll('hasMany'); to unbind all the hasMany
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
class BindableBehavior extends ModelBehavior {

/**
 * Behavior settings
 *
 * @access public
 * @var array
 */
	public $settings = array();

/**
 * Configuration method.
 *
 * @param object $Model Model object
 * @param array $config Config array
 * @access public
 * @return boolean
 */
	public function setup(Model $Model, $config = array()) {
		return true;
	}

/**
 * Unbind associated relations based on the mode
 *
 * @param model class $model 
 * @param string $mode Default is 'all'. Accepts hasMany, hasOne
 * belongsTo, hasAndBelongsToMany, and all
 * @return void
 */
	public function unbindAll(Model $model, $mode = 'all') {
		$hasMany = array_keys($model->hasMany);
		$belongsTo = array_keys($model->belongsTo);
		$hasOne = array_keys($model->hasOne);
		$habtm = array_keys($model->hasAndBelongsToMany);
		switch($mode) {
			case 'hasMany' :
				$model->unbindModel(array('hasMany' => $hasMany));
				break;
			case 'hasOne' :
				$model->unbindModel(array('hasOne' => $hasOne));
				break;
			case 'belongsTo' :
				$model->unbindModel(array('belongsTo' => $belongsTo));
				break;
			case 'hasAndBelongsToMany' :
				$model->unbindModel(array('hasAndBelongsToMany' => $habtm));
				break;
			case 'all' :
				$model->unbindModel(array('hasMany' => $hasMany));
				$model->unbindModel(array('hasOne' => $hasOne));
				$model->unbindModel(array('belongsTo' => $belongsTo));
				$model->unbindModel(array('hasAndBelongsToMany' => $habtm));
				break;
		}
	}
}