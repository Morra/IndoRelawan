<?php
/* Media Test cases generated on: 2012-06-13 02:44:50 : 1339548290*/
App::import('Model', 'Media');

class MediaTestCase extends CakeTestCase {
	var $fixtures = array('app.media', 'app.entry', 'app.setting', 'app.media_setting');

	function startTest() {
		$this->Media =& ClassRegistry::init('Media');
	}

	function endTest() {
		unset($this->Media);
		ClassRegistry::flush();
	}

}
