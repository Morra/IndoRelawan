<?php
/* Entries Test cases generated on: 2012-06-13 02:47:18 : 1339548438*/
App::import('Controller', 'Entries');

class TestEntriesController extends EntriesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class EntriesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.entry', 'app.dbtype', 'app.media', 'app.setting', 'app.media_setting', 'app.entry_detail');

	function startTest() {
		$this->Entries =& new TestEntriesController();
		$this->Entries->constructClasses();
	}

	function endTest() {
		unset($this->Entries);
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
