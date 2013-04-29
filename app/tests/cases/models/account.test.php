<?php
/* Account Test cases generated on: 2012-06-13 02:47:05 : 1339548425*/
App::import('Model', 'Account');

class AccountTestCase extends CakeTestCase {
	var $fixtures = array('app.account', 'app.user', 'app.user_detail', 'app.attribute', 'app.entry_detail');

	function startTest() {
		$this->Account =& ClassRegistry::init('Account');
	}

	function endTest() {
		unset($this->Account);
		ClassRegistry::flush();
	}

}
