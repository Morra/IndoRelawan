<?php
App::import('Component','Image');
App::import('Component', 'JqImgcrop');

class Entry extends AppModel {
	var $name = 'Entry';
	private $Image=null;
	private $Resize=null;
	
	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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
		'main_image' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'parent_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'ParentEntry' => array(
			'className' => 'Entry',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ParentImageEntry' => array(
			'className' => 'Entry',
			'foreignKey' => 'main_image',
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

	var $hasMany = array(
		'ChildEntry' => array(
			'className' => 'Entry',
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
		'ChildMainEntry' => array(
			'className' => 'Entry',
			'foreignKey' => 'main_image',
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
		'EntryMeta' => array(
			'className' => 'EntryMeta',
			'foreignKey' => 'entry_id',
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
	
	public function __construct( $id = false, $table = NULL, $ds = NULL )
	{
		parent::__construct($id, $table, $ds);
		$this->Image=new ImageComponent();
		$this->Resize=new JqImgcropComponent();        
	}
	
	/**
	 * to get a valid slug entry process
	 * @param string $slug contains source slug want to be processed
	 * @param integer $id contains id of the entry
	 * @return string $mySlug contains new generated slug.
	 * @public
	 **/
	function get_valid_slug($slug , $id = NULL)
	{	
		$counter = 0;
		$mySlug = $slug;
		if(!empty($id))
		{
			$options['conditions']['Entry.id <>'] = $id;
		}
		while(TRUE)
		{
			$options['conditions']['Entry.slug'] = $mySlug;
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
		if(!empty($this->data['Entry']['slug']))
		{
			$this->data['Entry']['slug'] = $this->get_valid_slug($this->data['Entry']['slug']);
		}
		return true;
	}

	/**
	 * function that be executed after save an entry (automated by cakephp)
	 * @return boolean
	 * @public
	 **/
	function afterSave()
	{	
		$temp = $this->field('sort_order');
		if($temp == 0)
		{
			$this->saveField('sort_order' , $this->id);
		}
		// lang_code update
		$temp = $this->field('lang_code');
		if(strlen($temp) == 2)
		{
			$this->saveField('lang_code' , $temp.'-'.$this->id);
		}		
	}
	
	/**
	* delete selected media from database and dir img/upload
	* @param integer $id get media id
	* @return boolean
	* @public
	**/
	public function deleteMedia($id = NULL)
	{	
		if($id!=NULL)
		{
			$row=$this->findById($id);
			foreach ($row['EntryMeta'] as $key => $value) 
			{
				if($value['key'] == 'image_type')
				{
					$imageType = $value['value'];
					break;
				}
			}
			
			$file=sprintf('%s.%s',$row['Entry']['id'],$imageType);
			
			// Delete File from directory first
			$dest=sprintf('%simg'.DS.'upload'.DS.'original'.DS.'%s',WWW_ROOT,$file);
			$destDisplay=sprintf('%simg'.DS.'upload'.DS.'%s',WWW_ROOT,$file);
			$destThumb=sprintf('%simg'.DS.'upload'.DS.'thumb'.DS.'%s',WWW_ROOT,$file);
			$destThumbnails=sprintf('%simg'.DS.'upload'.DS.'thumbnails'.DS.'%s.%s',WWW_ROOT,$row['Entry']['title'],$imageType);
			$destSettingThumb=sprintf('%simg'.DS.'upload'.DS.'setting'.DS.'%s',WWW_ROOT,$file);
			
			// Delete file
			unlink($dest);
			unlink($destThumb);
			unlink($destDisplay);
			unlink($destThumbnails);
			unlink($destSettingThumb);
			
			// special case deleter !!
			if(strtolower($imageType) == 'jpg' || strtolower($imageType) == 'jpeg')
			{
				unlink(sprintf('%simg'.DS.'upload'.DS.'thumbnails'.DS.'%s.jpg',WWW_ROOT,$row['Entry']['title']));
				unlink(sprintf('%simg'.DS.'upload'.DS.'thumbnails'.DS.'%s.jpeg',WWW_ROOT,$row['Entry']['title']));
			}
			
			$this->delete($id);
			$this->EntryMeta = ClassRegistry::init('EntryMeta');
			$this->EntryMeta->deleteAll(array('EntryMeta.entry_id' => $id));
			return true;
		}		
		return false;
	}
	
	/**
	 * create a setting thumbnail image
	 * @param integer $myid contains id of the image entry
	 * @param string $mytype contains extension type of the image (like .jpg, .png, etc)
	 * @param string $myMediaSettings contains array of media settings want to be used
	 * @return true
	 * @public
	 **/
	public function createSettingThumb($myid , $mytype , $width, $height, $crop)
	{		
		$src = WWW_ROOT.'img'.DS.'upload'.DS.'original'.DS.$myid.'.'.$mytype;
		$dest = WWW_ROOT.'img'.DS.'upload'.DS.'setting'.DS.$myid.'.'.$mytype;
		$this->Resize->thumb_resize($src, $dest, $width, $height , $crop);
	}
	
	/**
	 * create a thumbnail image
	 * @param integer $myid contains id of the image entry
	 * @param string $mytype contains extension type of the image (like .jpg, .png, etc)
	 * @param string $myMediaSettings contains array of media settings want to be used
	 * @return true
	 * @public
	 **/
	public function createThumb($myid , $mytype , $myMediaSettings)
	{		
		$src = WWW_ROOT.'img'.DS.'upload'.DS.'original'.DS.$myid.'.'.$mytype;
		$dest = WWW_ROOT.'img'.DS.'upload'.DS.'thumb'.DS.$myid.'.'.$mytype;
		$this->Resize->thumb_resize($src, $dest, $myMediaSettings['thumb_width'], $myMediaSettings['thumb_height'] , $myMediaSettings['thumb_crop']);
	}

	/**
	 * create a display image
	 * @param integer $myid contains id of the image entry
	 * @param string $mytype contains extension type of the image (like .jpg, .png, etc)
	 * @param string $myMediaSettings contains array of media settings want to be used
	 * @return true
	 * @public
	 **/
	public function createDisplay($myid , $mytype , $myMediaSettings)
	{	
		$src = WWW_ROOT.'img'.DS.'upload'.DS.'original'.DS.$myid.'.'.$mytype;
		$dest = WWW_ROOT.'img'.DS.'upload'.DS.$myid.'.'.$mytype;
		$this->Resize->image_resize($src, $dest, $myMediaSettings['display_width'], $myMediaSettings['display_height'] , $myMediaSettings['display_crop']);
	}
	
	/**
	 * retrieve media settings from certain type meta, if doesn't exist, then retrieve from global settings.
	 * @param array $myType contains query data from selected entry type
	 * @return array $result contains all the media settings will be used
	 * @public
	 **/
	public function getMediaSettings($myType = array())
	{
		// choose from settings first...
		$this->Setting = ClassRegistry::init('Setting');
		$mySetting = $this->Setting->findAllByName('sites');
		foreach ($mySetting as $key => $value) 
		{
			if($value['Setting']['key'] == 'display_width')
			{
				$result['display_width'] = $value['Setting']['value'];
			}
			else if($value['Setting']['key'] == 'display_height')
			{
				$result['display_height'] = $value['Setting']['value'];
			}
			else if($value['Setting']['key'] == 'display_crop')
			{
				$result['display_crop'] = $value['Setting']['value'];
			}
			else if($value['Setting']['key'] == 'thumb_width')
			{
				$result['thumb_width'] = $value['Setting']['value'];
			}
			else if($value['Setting']['key'] == 'thumb_height')
			{
				$result['thumb_height'] = $value['Setting']['value'];
			}
			else if($value['Setting']['key'] == 'thumb_crop')
			{
				$result['thumb_crop'] = $value['Setting']['value'];
			}
		}
		
		// if in type meta exist, use that :D
		$this->TypeMeta = ClassRegistry::init('TypeMeta');
		$myTypeMeta = $this->TypeMeta->findAllByTypeId($myType['Type']['id']);
		foreach ($myTypeMeta as $key => $value) 
		{
			if($value['TypeMeta']['key'] == 'display_width')
			{
				$result['display_width'] = $value['TypeMeta']['value'];
			}
			else if($value['TypeMeta']['key'] == 'display_height')
			{
				$result['display_height'] = $value['TypeMeta']['value'];
			}
			else if($value['TypeMeta']['key'] == 'display_crop')
			{
				$result['display_crop'] = $value['TypeMeta']['value'];
			}
			else if($value['TypeMeta']['key'] == 'thumb_width')
			{
				$result['thumb_width'] = $value['TypeMeta']['value'];
			}
			else if($value['TypeMeta']['key'] == 'thumb_height')
			{
				$result['thumb_height'] = $value['TypeMeta']['value'];
			}
			else if($value['TypeMeta']['key'] == 'thumb_crop')
			{
				$result['thumb_crop'] = $value['TypeMeta']['value'];
			}
		}
		return $result;
	}

/*	public function getEntries
	($dbtypeId, $labelname, $entryDetailValue = array() , $createdBy = NULL , $startDate = NULL , $endDate = NULL , $parentId = 0)
	{
		$this->Attribute = ClassRegistry::init('Attribute');
		$labelname = $this->Attribute->findByValue($labelname);
		
		if(empty($labelname))
		{
			return 0;
		}
		
		// $options['joins'] = array(
			// array(
				// 'table' => 'entry_details',
				// 'alias' => 'EntryDetail2',
				// 'type' => 'inner',
				// 'conditions' => array(
					// 'EntryDetail2.entry_id = Entry.id'
				// )
			// )
		// );
		
		$options['conditions'] = array(
			'Entry.dbtype_id' => $dbtypeId,
			'EntryDetail.attribute_id' => $labelname['Attribute']['id'],
			'EntryDetail.value' => $entryDetailValue,
			'Entry.parent_id' => $parentId
		);
		
		if(!empty($createdBy))
		{
			$options['conditions']['Entry.created_by'] = $createdBy;
		}

		if(!empty($startDate))
		{
			$options['conditions']['Entry.modified >='] = $startDate;
			$options['conditions']['Entry.modified <='] = $endDate;
		}
		
		$options['order'] = array('Entry.id DESC');
		$options['group'] = array('Entry.id');
		
		return $this->find('all' , $options);
	}	*/
}
