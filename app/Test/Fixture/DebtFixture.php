<?php
/**
 * DebtFixture
 *
 */
class DebtFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'key' => 'primary'),
		'transaction_id' => array('type' => 'biginteger', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'biginteger', 'null' => false, 'default' => null),
		'debt' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => 5),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '',
			'transaction_id' => '',
			'user_id' => '',
			'debt' => 1
		),
	);

}
