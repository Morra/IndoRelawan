<?php
/* Dbtype Test cases generated on: 2012-06-13 02:43:10 : 1339548190*/
App::import('Model', 'Dbtype');

class DbtypeTestCase extends CakeTestCase {
	var $fixtures = array('app.dbtype', 'app.entry');

	function startTest() {
		$this->Dbtype =& ClassRegistry::init('Dbtype');
	}

	function endTest() {
		unset($this->Dbtype);
		ClassRegistry::flush();
	}

}
