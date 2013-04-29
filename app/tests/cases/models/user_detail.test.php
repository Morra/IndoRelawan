<?php
/* UserDetail Test cases generated on: 2012-06-13 02:46:50 : 1339548410*/
App::import('Model', 'UserDetail');

class UserDetailTestCase extends CakeTestCase {
	var $fixtures = array('app.user_detail', 'app.user', 'app.account', 'app.attribute', 'app.entry_detail');

	function startTest() {
		$this->UserDetail =& ClassRegistry::init('UserDetail');
	}

	function endTest() {
		unset($this->UserDetail);
		ClassRegistry::flush();
	}

}
