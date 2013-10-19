<?php
/**
 * Mock models file
 *
 * Mock classes for use in Model and related test cases
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
 * @lastmodified 2013-10-19
 */

App::uses('Model', 'Model');
App::uses('AppModel', 'Model');


/**
 * User class
 *
 * @package       UtilityBehaviors.Test.Case.Model.Behavior
 */
class User extends CakeTestModel {

/**
 * name property
 *
 * @var string
 */
	public $name = 'User';

/**
 * useTable property
 *
 * @var string
 */
	public $useTable = 'users';

/**
 * displayField property
 *
 * @var string
 */
	public $displayField = 'username';
}

/**
 * Group class
 *
 * @package       UtilityBehaviors.Test.Case.Model.Behavior
 */
class Group extends CakeTestModel {

/**
 * name property
 *
 * @var string
 */
	public $name = 'Group';

/**
 * useTable property
 *
 * @var string
 */
	public $useTable = 'groups';


}

class CustomerProfile extends CakeTestModel {

/**
 * name property
 *
 * @var string
 */
	public $name = 'CustomerProfile';

/**
 * useTable property
 *
 * @var string
 */
	public $useTable = 'customer_profiles';

}
