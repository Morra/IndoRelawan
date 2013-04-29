<?php
/* EntryDetails Test cases generated on: 2012-06-13 02:47:31 : 1339548451*/
App::import('Controller', 'EntryDetails');

class TestEntryDetailsController extends EntryDetailsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class EntryDetailsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.entry_detail', 'app.entry', 'app.dbtype', 'app.media', 'app.setting', 'app.media_setting', 'app.attribute', 'app.user_detail', 'app.user', 'app.account');

	function startTest() {
		$this->EntryDetails =& new TestEntryDetailsController();
		$this->EntryDetails->constructClasses();
	}

	function endTest() {
		unset($this->EntryDetails);
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
