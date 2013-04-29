<?php
/* Dbtypes Test cases generated on: 2012-06-13 02:43:10 : 1339548190*/
App::import('Controller', 'Dbtypes');

class TestDbtypesController extends DbtypesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class DbtypesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.dbtype', 'app.entry');

	function startTest() {
		$this->Dbtypes =& new TestDbtypesController();
		$this->Dbtypes->constructClasses();
	}

	function endTest() {
		unset($this->Dbtypes);
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
