<?php
/* Setting Test cases generated on: 2012-06-13 02:46:18 : 1339548378*/
App::import('Model', 'Setting');

class SettingTestCase extends CakeTestCase {
	var $fixtures = array('app.setting', 'app.media', 'app.entry', 'app.media_setting');

	function startTest() {
		$this->Setting =& ClassRegistry::init('Setting');
	}

	function endTest() {
		unset($this->Setting);
		ClassRegistry::flush();
	}

}
