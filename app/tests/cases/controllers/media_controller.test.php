<?php
/* Media Test cases generated on: 2012-06-13 02:44:50 : 1339548290*/
App::import('Controller', 'Media');

class TestMediaController extends MediaController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class MediaControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.media', 'app.entry', 'app.setting', 'app.media_setting');

	function startTest() {
		$this->Media =& new TestMediaController();
		$this->Media->constructClasses();
	}

	function endTest() {
		unset($this->Media);
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
