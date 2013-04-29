<?php
/* MediaSettings Test cases generated on: 2012-06-13 02:45:04 : 1339548304*/
App::import('Controller', 'MediaSettings');

class TestMediaSettingsController extends MediaSettingsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class MediaSettingsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.media_setting');

	function startTest() {
		$this->MediaSettings =& new TestMediaSettingsController();
		$this->MediaSettings->constructClasses();
	}

	function endTest() {
		unset($this->MediaSettings);
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
