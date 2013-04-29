<?php
/* Attributes Test cases generated on: 2012-06-13 02:42:52 : 1339548172*/
App::import('Controller', 'Attributes');

class TestAttributesController extends AttributesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class AttributesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.attribute', 'app.entry_detail', 'app.user_detail');

	function startTest() {
		$this->Attributes =& new TestAttributesController();
		$this->Attributes->constructClasses();
	}

	function endTest() {
		unset($this->Attributes);
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
