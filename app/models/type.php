<?php
class Type extends AppModel {
	var $name = 'Type';
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
		
		'created_by' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'modified_by' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'slug' => array(
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
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'ChildType' => array(
			'className' => 'Type',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'TypeMeta' => array(
			'className' => 'TypeMeta',
			'foreignKey' => 'type_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	var $belongsTo = array(
		'ParentType' => array(
			'className' => 'Type',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserCreatedBy' => array(
			'className' => 'User',
			'foreignKey' => 'created_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UserModifiedBy' => array(
			'className' => 'User',
			'foreignKey' => 'modified_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	/**
	 * to get a valid slug database process
	 * @param string $slug contains source slug want to be processed
	 * @param integer $id contains id of the database
	 * @return string $mySlug contains new generated slug
	 * @public
	 **/
	function get_valid_slug($slug , $id = NULL)
	{
		$counter = 0;
		$mySlug = $slug;
		if(!empty($id))
		{
			$options['conditions']['Type.id <>'] = $id;
		}
		while(TRUE)
		{
			$options['conditions']['Type.slug'] = $mySlug;
			$findSlug = $this->find('first' , $options);
			if(empty($findSlug))
			{
				break;
			}
			else
			{
				$mySlug = $slug.'-'.(++$counter);
			}
		}
		return $mySlug;
	}
	
	/**
	 * function that be executed before save an entry (automated by cakephp)
	 * @return boolean
	 * @public
	 **/
	function beforeSave()
	{		
		if(!empty($this->data['Type']['slug']))
		{
			$this->data['Type']['slug'] = $this->get_valid_slug($this->data['Type']['slug']);
		}
		return true;
	}
}
