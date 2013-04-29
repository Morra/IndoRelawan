<?php
/* Attribute Fixture generated on: 2012-06-13 02:42:51 : 1339548171 */
class AttributeFixture extends CakeTestFixture {
	var $name = 'Attribute';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'value' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'value' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-06-13 02:42:51',
			'modified' => '2012-06-13 02:42:51'
		),
	);
}
