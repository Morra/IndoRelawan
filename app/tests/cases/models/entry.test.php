<?php
/* Entry Test cases generated on: 2012-06-13 02:47:18 : 1339548438*/
App::import('Model', 'Entry');

class EntryTestCase extends CakeTestCase {
	var $fixtures = array('app.entry', 'app.dbtype', 'app.media', 'app.setting', 'app.media_setting', 'app.entry_detail');

	function startTest() {
		$this->Entry =& ClassRegistry::init('Entry');
	}

	function endTest() {
		unset($this->Entry);
		ClassRegistry::flush();
	}

}
