<?php
class Setting extends AppModel {
	var $name = 'Setting';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'key' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	/**
	 * retrieve all template settings based on name and key in indexing array
	 * @return array $mySetting contains array of indexing settings
	 * @public
	 **/
	public function get_settings()
	{
		$mysql = $this->find('all');
		foreach ($mysql as $key => $value)
		{
			$mySetting[$value['Setting']['name']][$value['Setting']['key']] = $value['Setting']['value'];
		}
		$mySetting['sites']['language'] = parse_lang($mySetting['sites']['language']);
		return $mySetting;
	}
}
