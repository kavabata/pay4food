<?php
App::uses('Debt', 'Model');

/**
 * Debt Test Case
 *
 */
class DebtTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.debt'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Debt = ClassRegistry::init('Debt');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Debt);

		parent::tearDown();
	}

}
