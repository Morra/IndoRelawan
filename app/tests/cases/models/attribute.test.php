<?php
/* Attribute Test cases generated on: 2012-06-13 02:42:51 : 1339548171*/
App::import('Model', 'Attribute');

class AttributeTestCase extends CakeTestCase {
	var $fixtures = array('app.attribute', 'app.entry_detail', 'app.user_detail');

	function startTest() {
		$this->Attribute =& ClassRegistry::init('Attribute');
	}

	function endTest() {
		unset($this->Attribute);
		ClassRegistry::flush();
	}

}
