<?php
/* MediaSetting Test cases generated on: 2012-06-13 02:45:04 : 1339548304*/
App::import('Model', 'MediaSetting');

class MediaSettingTestCase extends CakeTestCase {
	var $fixtures = array('app.media_setting');

	function startTest() {
		$this->MediaSetting =& ClassRegistry::init('MediaSetting');
	}

	function endTest() {
		unset($this->MediaSetting);
		ClassRegistry::flush();
	}

}
