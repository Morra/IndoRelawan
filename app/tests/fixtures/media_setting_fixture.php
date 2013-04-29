<?php
/* MediaSetting Fixture generated on: 2012-06-13 02:45:04 : 1339548304 */
class MediaSettingFixture extends CakeTestFixture {
	var $name = 'MediaSetting';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => 'Default Setting', 'length' => 40, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'max_upload_width' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'max_upload_height' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'display_width' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'display_height' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'display_crop' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'thumb_width' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'thumb_height' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'thumb_crop' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 4),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'max_upload_width' => 1,
			'max_upload_height' => 1,
			'display_width' => 1,
			'display_height' => 1,
			'display_crop' => 1,
			'thumb_width' => 1,
			'thumb_height' => 1,
			'thumb_crop' => 1
		),
	);
}
