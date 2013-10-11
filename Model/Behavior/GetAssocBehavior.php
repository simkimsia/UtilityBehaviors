<?php 
/** 
 * GetAssoc Behavior 
 * 
 * Usage: 
 * public $actsAs = array('UtilityBehaviors.GetAssoc'); 
 * 
 * Example: 
 * class Batch extends AppModel { 
 *   public $name = 'Batch'; 
 *
 *   public $actsAs = array('UtilityBehaviors.GetAssoc'); 
 *   public $belongsTo = array(
 *      'Customer' => array(
 *           'className' => 'User',
 *           'foreignKey' => 'customer_id',
 *           'conditions' => array('Customer.group_id' => 7),
 *           'fields' => '',
 *           'order' => '', 
 *       ),
 *   ); 
 * }
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
 * @lastmodified 2013-10-12
 */ 
class GetAssocBehavior extends ModelBehavior { 

    var $config = array(); 

    public function setup(Model $model, $config = array()) {
        foreach ($config as $k => $value) { 
            $this->config[$k] = $value; 
        }
        return true;
    } 

    public function getAssoc(Model $model, $assocName, $findType, $query = array()) { 
        $defaultQuery = array(
            'conditions' => array()
        );
        $query = array_merge($defaultQuery, $query);
        $assoc = $this->_determineAssociation($model, $assocName);
        if (empty($assoc['className'])) {
            $className = $assocName;
        } else {
            $className = $assoc['className'];
        }
        $assocModel = $model->{$assocName};
        if (is_string($assoc['conditions'])) {
            $assoc['conditions'] = array($assoc['conditions']);
        }
        $query['conditions'] = array_merge($query['conditions'], $assoc['conditions']);
        return $assocModel->find($findType, $query);
    }

    protected function _determineAssociation(Model $model, $assocName) {
        $inBelongsTo = array_key_exists($assocName, $model->belongsTo);
        $inHasMany = array_key_exists($assocName, $model->hasMany);
        $inHasOne = array_key_exists($assocName, $model->hasOne);
        $inHabtm = array_key_exists($assocName, $model->hasAndBelongsToMany);
        $noSuchAssoc = !$inBelongsTo && !$inHasMany && !$inHasOne && !$inHabtm;
        if ($noSuchAssoc) {
            throw new Exception("No such association");
        }
        if ($inBelongsTo) {
            return $model->belongsTo[$assocName];
        }
        if ($inHasMany) {
            return $model->hasMany[$assocName];
        }
        if ($inHabtm) {
            return $model->hasAndBelongsToMany[$assocName];
        }
        if ($inHasOne) {
            return $model->hasOne[$assocName];
        }
    }

}