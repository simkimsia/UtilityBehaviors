<?php 
/** 
 * AggregateCache Behavior 
 * 
 * Usage: 
 * public $actsAs = array('UtilityBehaviors.AggregateCache'=>array(array( 
 *   'field'=>'name of the field to aggregate', 
 *   'model'=>'belongsTo model alias to store the cached values', 
 *   'min'=>'field name to store the minimum value', 
 *   'max'=>'field name to store the maximum value', 
 *   'sum'=>'field name to store the sum value', 
 *   'avg'=>'field name to store the average value' 
 *   'conditions'=>array(), // conditions to use in the aggregate query 
 *   'recursive'=>-1 // recursive setting to use in the aggregate query 
 *  ))); 
 * 
 * Example: 
 * class QuotationLineItem extends AppModel { 
 *   public $name = 'QuotationLineItem'; 
 *
 *'UtilityBehaviors.AggregateCache' => array( 
 *               array(
 *                   'field' => 'total_value',
 *                   'model' =>'Quotation', 
 *                  'sum'   =>'applied_voucher_value',
 *                  'sum_default_when_null' => 0,
 *                  'conditions' => array('QuotationLineItem.voucher_applied' => 1),
 *              ),
 *              array(
 *                  'field' => 'total_value',
 *                  'model' =>'Quotation', 
 *                  'sum'   =>'total_value',
 *              ),
 *      ),
 *   public $belongsTo = array('Quotation'); 
 * } 
 * 
 * Each element of the configuration array should be an array that specifies: 
 * A field on which the aggregate values should be calculated. The field name may instead be given as a key in the configuration array.
 * A model that will store the cached aggregates. The model name must match the alias used for the model in the belongsTo array.
 * At least one aggregate function to calculate and the field in the related model that will store the calculated value.
 *    Aggregates available are: min, max, avg, sum. 
 * A conditions array may be provided to filter the query used to calculate aggregates. 
 *    If not specified, the conditions of the belongsTo association will be used. 
 * A recursive value may be specified for the aggregate query. If not specified Cake's default will be used. 
 *    If it's not necessary to use conditions involving a related table, setting recursive to -1 will make the aggregate query more efficient.
 * 
 * @author Vincent Lizzi 
 * @version 2010-07-17 
 * @link http://bakery.cakephp.org/articles/vincentm8/2010/08/23/aggregatecache-behavior
 */ 
class AggregateCacheBehavior extends ModelBehavior { 

    var $foreignTableIDs = array(); 
    var $config = array(); 
    var $functions = array('min', 'max', 'avg', 'sum'); 
    var $defaultWhenNulls = array(
        'min_default_when_null',
        'max_default_when_null',
        'avg_default_when_null',
        'sum_default_when_null',
    );

    public function setup(Model $model, $config = array()) {
        foreach ($config as $k => $aggregate) { 
            if (empty($aggregate['field'])) { 
                $aggregate['field'] = $k; 
            } 
            if (!empty($aggregate['field']) && !empty($aggregate['model'])) { 
                $this->config[] = $aggregate; 
            }
        } 
    } 

    private function __updateCache(Model $model, $aggregate, $foreignKey, $foreignId) { 
        $assocModel = $model->{$aggregate['model']}; 
        $calculations = array();
        foreach ($aggregate as $function => $cacheField) { 
            if (!in_array($function, $this->functions)) { 
                continue; 
            }
            $calculations[] = $function . '(' . $model->name . '.' . $aggregate['field'] . ') ' . $function . '_value'; 
        }
        $defaultWhenNulls = array();
        foreach ($aggregate as $functionDefaultWhenNull => $defaultValue) { 
            if (!in_array($functionDefaultWhenNull, $this->defaultWhenNulls)) { 
                continue; 
            }
            $defaultWhenNulls[$functionDefaultWhenNull] = $defaultValue; 
        }
        if (count($calculations) > 0) { 
            $conditions = array($model->name . '.' . $foreignKey => $foreignId); 
            if (array_key_exists('conditions', $aggregate)) { 
                $conditions = am($conditions, $aggregate['conditions']); 
            } else { 
                $conditions = am($conditions, $model->belongsTo[$aggregate['model']]['conditions']); 
            } 
            $recursive = (array_key_exists('recursive', $aggregate)) ? $aggregate['recursive'] : null; 
            $results = $model->find('first', array( 
                        'fields' => $calculations, 
                        'conditions' => $conditions, 
                        'recursive' => $recursive, 
                        'group' => $model->name . '.' . $foreignKey, 
                    )); 
            $newValues = array(); 
            foreach ($aggregate as $function => $cacheField) { 
                if (!in_array($function, $this->functions)) { 
                    continue; 
                }
                if ((!isset($results[0]) || $results[0][$function . '_value'] == null) && array_key_exists($function . '_default_when_null', $defaultWhenNulls)) {
                    $newValues[$cacheField] = $defaultWhenNulls[$function . '_default_when_null'];
                } else if (isset($results[0])) {
                    $newValues[$cacheField] = $results[0][$function . '_value']; 
                } else {
                    $newValues[$cacheField] = null;
                }
            }
            $assocModel->id = $foreignId; 
            $assocModel->save($newValues, false, array_keys($newValues)); 
        } 
    } 

    public function afterSave(Model $model, $created) { 
        foreach ($this->config as $aggregate) { 
            if (!array_key_exists($aggregate['model'], $model->belongsTo)) { 
                continue; 
            } 
            $foreignKey = $model->belongsTo[$aggregate['model']]['foreignKey']; 
            if (isset($model->data[$model->name][$foreignKey])) {
                $foreignId = $model->data[$model->name][$foreignKey]; 
                $this->__updateCache($model, $aggregate, $foreignKey, $foreignId); 
            }
        } 
    } 

    public function beforeDelete(Model $model, $cascade = true) { 
        foreach ($model->belongsTo as $assocKey => $assocData) { 
            if (isset($assocData['className']) && isset($assocData['foreignKey'])) {
                $this->foreignTableIDs[$assocData['className']] = $model->field($assocData['foreignKey']); 
            }
        } 
        return true; 
    } 

    public function afterDelete(Model $model) { 
        foreach ($this->config as $aggregate) { 
            if (!array_key_exists($aggregate['model'], $model->belongsTo)) { 
                continue; 
            } 
            $foreignKey = $model->belongsTo[$aggregate['model']]['foreignKey']; 
            if (!empty($this->foreignTableIDs[$aggregate['model']])) {
                $foreignId = $this->foreignTableIDs[$aggregate['model']]; 
                $this->__updateCache($model, $aggregate, $foreignKey, $foreignId); 
            }
        }
    }

} 