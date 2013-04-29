<?php
/* EntryDetail Test cases generated on: 2012-06-13 02:47:31 : 1339548451*/
App::import('Model', 'EntryDetail');

class EntryDetailTestCase extends CakeTestCase {
	var $fixtures = array('app.entry_detail', 'app.entry', 'app.dbtype', 'app.media', 'app.setting', 'app.media_setting', 'app.attribute', 'app.user_detail', 'app.user', 'app.account');

	function startTest() {
		$this->EntryDetail =& ClassRegistry::init('EntryDetail');
	}

	function endTest() {
		unset($this->EntryDetail);
		ClassRegistry::flush();
	}

}
