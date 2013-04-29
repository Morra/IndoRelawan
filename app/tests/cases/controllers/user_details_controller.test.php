<?php
/* UserDetails Test cases generated on: 2012-06-13 02:46:51 : 1339548411*/
App::import('Controller', 'UserDetails');

class TestUserDetailsController extends UserDetailsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class UserDetailsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.user_detail', 'app.user', 'app.account', 'app.attribute', 'app.entry_detail');

	function startTest() {
		$this->UserDetails =& new TestUserDetailsController();
		$this->UserDetails->constructClasses();
	}

	function endTest() {
		unset($this->UserDetails);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
