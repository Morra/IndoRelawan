<?php
class GetHelper extends AppHelper
{
    var $helpers = array('Form', 'Html', 'Js', 'Time', 'Ajax');
	var $data = NULL;
	var $countListPerPage = 15;

	// DATABASE MODEL...
	var $Entry = NULL;
	var $Type = NULL;
	var $Setting = NULL;
	var $EntryMeta = NULL;

	/**
	* as a constructor for this helper class
	* @param array $data contains source data from the controller
	* @return true
	* @public
	**/
	function create($data)
	{
		$this->data = $data;
		// set needed database model ...
		$this->Entry = ClassRegistry::init('Entry');
		$this->Type = ClassRegistry::init('Type');
		$this->Setting = ClassRegistry::init('Setting');
		$this->EntryMeta = ClassRegistry::init('EntryMeta');
	}

	/**
	* for echoing our data to the view with specific html tag
	* @param array $result contains the data want to be echoed
	* @param string $open_tag the beginning html tag
 	* @param string $close_tag the ending html tag
	* @return true
	* @public
	**/
	private function _echo_list($result = array() , $open_tag = NULL , $close_tag = NULL)
	{
		if(!empty($open_tag))
		{
			foreach ($result as $key => $value)
			{
				echo $open_tag.$value.$close_tag;
			}
		}
	}

	function host_name()
	{
		return parent::get_host_name();
	}

	function isAjax()
	{
		return ($this->data['isAjax'] == 0?'no':'yes');
	}

	/**
	* get our specific site settings
	* @param string $key contains type of settings you want to retrieve
	* @param string $open_tag[optional] the beginning html tag
 	* @param string $close_tag[optional] the ending html tag
	* @return string your request specific settings
	* @public
	**/
	function sites($passData)
	{
		extract($passData , EXTR_OVERWRITE);
		$result = '';
		foreach ($this->data['mySetting'] as $key10 => $value10)
		{
			if(!empty($value10[strtolower($key)]))
			{
				$result = $value10[strtolower($key)];
				break;
			}
		}
		echo (empty($open_tag)?'':$open_tag.$result.$close_tag);
		return $result;
	}

	/**
	* get specific field value from the certain entry
	* @param string $key contains certain field label you want to retrieve its value
	* @param string $open_tag[optional] the beginning html tag
 	* @param string $close_tag[optional] the ending html tag
	* @param string $order_num[optional] the offset
	* @return string $result value you'd requested
	* @public
	**/
    function entry($passData)
	{
		extract($passData , EXTR_OVERWRITE);
		$myEntry = (empty($order_num)?$this->data['myEntry']:$this->data['myList'][$order_num]);
		$key = strtolower($key);
		$result = $myEntry['Entry'][$key];
		if(empty($result))
		{
			foreach ($myEntry['EntryMeta'] as $key10 => $value10)
			{
				if($value10['key'] == 'form-'.$key)
				{
					$result = $value10['value'];
					break;
				}
			}
		}
		echo (empty($open_tag)?'':$open_tag.$result.$close_tag);
		return $result;
	}

	/**
	* get specific field value from the last entry list
	* @param string $key contains certain field label you want to retrieve its value
	* @param string $open_tag[optional] the beginning html tag
 	* @param string $close_tag[optional] the ending html tag
	* @return string $result value you'd requested
	* @public
	**/
	function last_entry($passData)
	{
		$passData['order_num'] = count($this->data['myList'])-1;
		return $this->entry($passData);
	}

	/**
	* get a bunch of entries(link) based on parameter given
	* @param string $type[optional] contains slug database type
	* @param string $passKey[optional] contains specific key that entries must have
	* @param string $passValue[optional] contains specific value from certain key that entries must have
	* @param string $open_tag[optional] the beginning html tag
 	* @param string $close_tag[optional] the ending html tag
	* @param string $entry[optional] contains slug of the parent Entry (used if want to search certain child Entry)
	* @param string $childType[optional] contains slug of child type database (used if want to search certain child Entry)
	* @param string $orderField[optional] order field
	* @param string $orderDirection[optional] contains 'ASC' or 'DESC'
	* @param string $language[optional] contains language of the entries that want to be retrieved
	* @param integer $raw[optional] result given in raw or print mode(ignore if print mode)
	* @return array $result certain bunch of entries(link) you'd requested
	* @public
	**/
	function list_entry($passData = array())
	{
		extract($passData , EXTR_OVERWRITE);
		if( (empty($orderField) || empty($orderDirection)) && ($this->data['myType']['Type']['slug'] == strtolower($type) || empty($type)) && $this->data['language'] == strtolower($language))
		{
			$data = $this->data;
		}
		else
		{
			if(empty($entry))
			{
				$data = $this->_get_list_entry($type , NULL , NULL , $orderField , $orderDirection , $language);
			}
			else
			{
				$data = $this->_get_list_entry($type , $entry , (empty($childType)?$type:$childType) , $orderField , $orderDirection , $language);
			}
		}
		if(empty($raw))
		{
			$passKey = strtolower($passKey);
			$result = array();
			foreach ($data['myList'] as $key => $value)
			{
				$counter = 0;
				$totalCount = count($value['EntryMeta']);
				do
				{
					$temp = $value['EntryMeta'][$counter++];
					if(empty($passKey) && empty($passValue) || $temp['key'] == 'form-'.$passKey && $temp['value'] == $passValue)
					{
						if(empty($entry))
						{
							$result[] = $this->Html->link($value['Entry']['title'],
							array(
							'controller'=>$data['myType']['Type']['slug'],
							'action'=>$value['Entry']['slug']
							));
						}
						else
						{
							$result[] = $this->Html->link($value['Entry']['title'],
							array(
							'controller'=>$data['myType']['Type']['slug'],
							'action'=>$value['ParentEntry']['slug'],
							$value['Entry']['slug'].(empty($childType)?'':'?type='.$childType)
							));
						}
						break;
					}
				}
				while($counter < $totalCount);
			}
			$this->_echo_list($result , $open_tag , $close_tag);
		}
		else
		{
			$result = $data;
		}
		return $result;
	}

	/**
	* retrieve link lists of certain key category owned by entries based on certain type database
	* @param string $type[optional] contains slug database type
	* @param string $passKey contains specific key that entries must have
	* @param string $language[optional] contains language of the entries that want to be retrieved
	* @param string $open_tag[optional] the beginning html tag
 	* @param string $close_tag[optional] the ending html tag
	* @param integer $raw[optional] result given in raw or print mode(ignore if print mode)
	* @return array $result certain bunch of category lists you'd requested
	* @public
	**/
	function list_meta($passData)
	{
		extract($passData , EXTR_OVERWRITE);
		if(($this->data['myType']['Type']['slug'] == strtolower($type) || empty($type)) && $this->data['language'] == strtolower($language))
		{
			$data = $this->data;
		}
		else
		{
			$data = $this->_get_list_entry($type,NULL,NULL,NULL,NULL,$language);
		}

		if(empty($raw))
		{
			$temps = array();
			$result = array();
			$passKey = strtolower($passKey);
			foreach ($data['myList'] as $key => $value)
			{
				foreach ($value['EntryMeta'] as $key10 => $value10)
				{
					if($value10['key'] == 'form-'.$passKey && !in_array($value10['value'], $temps))
					{
						$temps[] = $value10['value'];
						$result[] = $this->Html->link($value10['value'],
						array(
						'controller'=>$data['myType']['Type']['slug'],
						'action'=>'?key='.$passKey.'&value='.parent::get_slug($value10['value'])
						));
					}
				}
			}
			$this->_echo_list($result , $open_tag , $close_tag);
		}
		else
		{
			$result = $data;
		}
		return $result;
	}

	/**
	* retrieve list of pages
	* @param string $language[optional] contains language of the entries that want to be retrieved
	* @param string $open_tag[optional] the beginning html tag
 	* @param string $close_tag[optional] the ending html tag
	* @param integer $raw[optional] result given in raw or print mode(ignore if print mode)
	* @return array $result list of pages
	* @public
	**/
	function navigation($passData = array())
	{
		extract($passData , EXTR_OVERWRITE);
		$data = $this->_get_list_entry('pages',NULL,NULL,NULL,NULL,$language);
		if(empty($raw))
		{
			$result = array();
			foreach ($data['myList'] as $key => $value)
			{
				$result[] = $this->Html->link($value['Entry']['title'],
				array(
				'controller'=>$value['Entry']['slug']
				));
			}
			$this->_echo_list($result , $open_tag , $close_tag);
		}
		else
		{
			$result = $data;
		}
		return $result;
	}

	/**
	* get images link based on image ID (original, display, and thumbnail)
	* @param integer $id contains image id
	* @param integer $raw[optional] result given in raw or print mode(ignore if print mode)
	* @return array $result contains all images link from selected id
	* @public
	**/
	function image_link($passData)
	{
		extract($passData , EXTR_OVERWRITE);
		$data = $this->_get_detail_entry($id);
		if(empty($raw))
		{
			$result['display'] = parent::get_host_name().'img/upload/'.$data['myEntry']['Entry']['id'].'.'.$data['myImageTypeList'][$data['myEntry']['Entry']['id']];
			$result['original'] = parent::get_host_name().'img/upload/original/'.$data['myEntry']['Entry']['id'].'.'.$data['myImageTypeList'][$data['myEntry']['Entry']['id']];
			$result['thumbnail'] = parent::get_host_name().'img/upload/thumb/'.$data['myEntry']['Entry']['id'].'.'.$data['myImageTypeList'][$data['myEntry']['Entry']['id']];
		}
		else
		{
			$result = $data;
		}
		return $result;
	}

	/**
	* get specific entry(link) from entry lists based on entry id
	* @param integer $id contains id of the entry
	* @param integer $raw[optional] result given in raw or print mode(ignore if print mode)
	* @return mixed $result a selected entry you'd requested
	* @public
	**/
	function entry_link($passData)
	{
		extract($passData , EXTR_OVERWRITE);
		if($this->data['myEntry']['Entry']['id'] == $id)
		{
			$data = $this->data;
		}
		else
		{
			$data = $this->_get_detail_entry($id);
		}
		if(empty($raw))
		{
			// IF THIS IS A CHILD ENTRY...
			if($data['myEntry']['Entry']['parent_id'] > 0)
			{
				$result = parent::get_host_name().$data['myEntry']['ParentEntry']['entry_type'].'/'.$data['myEntry']['ParentEntry']['slug'].'/'.$data['myEntry']['Entry']['slug'];
			}
			else // IF THIS IS A PARENT ENTRY...
			{
				$result = parent::get_host_name().$data['myEntry']['Entry']['entry_type'].'/'.$data['myEntry']['Entry']['slug'];
			}
		}
		else
		{
			$result = $data;
		}
		return $result;
	}

	/**
	* retrieve meta values from selected entry based on specific meta key
	* @param integer $id contains id of the entry
	* @param string $passKey contains specific key that entries must have
	* @param integer $raw[optional] result given in raw or print mode(ignore if print mode)
	* @return array $result contains meta values you'd requested
	* @public
	**/
	function meta_value($passData)
	{
		extract($passData , EXTR_OVERWRITE);
		$passKey = strtolower($passKey);
		if($this->data['myEntry']['Entry']['id'] == $id)
		{
			$data = $this->data;
		}
		else
		{
			$data = $this->_get_detail_entry($id);
		}

		if(empty($raw))
		{
			$result = array();
			foreach ($data['myEntry']['EntryMeta'] as $key => $value)
			{
				if($value['key'] == 'form-'.$passKey)
				{
					$result[] = $value['value'];
				}
			}
		}
		else
		{
			$result = $data;
		}
		return $result;
	}
	// ---------------------------------------------------------------------------------------------------------------------------- //
	// ------------------------------------------------- DATABASE FUNCTION -------------------------------------------------------- //
	// ---------------------------------------------------------------------------------------------------------------------------- //
	/**
	* get a bunch of entries based on parameter given
	* @param string $myTypeSlug contains slug database type
	* @param string $myEntrySlug[optional] contains slug of the parent Entry (used if want to search certain child Entry)
	* @param string $myChildTypeSlug[optional] contains slug of child type database (used if want to search certain child Entry)
	* @param string $orderField[optional] order field
	* @param string $orderDirection[optional] contains 'ASC' or 'DESC'
	* @param string $lang[optional] contains language of the entries that want to be retrieved
	* @return array $result certain bunch of entries you'd requested
	* @public
	**/
	function _get_list_entry($myTypeSlug , $myEntrySlug = NULL , $myChildTypeSlug = NULL , $orderField = NULL , $orderDirection = NULL , $lang = NULL)
	{
		if($myTypeSlug == 'pages')
		{
			// manually set pages data !!
			$myType['Type']['name'] = 'Pages';

			$myType['Type']['slug'] = 'pages';
			$myType['Type']['parent_id'] = -1;
		}
		else
		{
			$myType = $this->Type->findBySlug($myTypeSlug);
		}
		$myEntry = (empty($myEntrySlug)?NULL:$this->Entry->findBySlug($myEntrySlug));
		return $this->_admin_default($myType , 0 , $myEntry , NULL , NULL , $myChildTypeSlug , $orderField , $orderDirection , $lang);
	}

	/**
	* get specific entry from entry lists based on entry id
	* @param integer $myEntryId contains id of the entry
	* @return array $result a selected entry you'd requested
	* @public
	**/
	function _get_detail_entry($myEntryId)
	{
		$myEntry = $this->Entry->findById($myEntryId);

		// if this is a child Entry...
		if($myEntry['Entry']['parent_id'] > 0)
		{
			$myParentEntry = $this->Entry->findById($myEntry['Entry']['parent_id']);
			$myType = $this->Type->findBySlug($myParentEntry['Entry']['entry_type']); // PARENT TYPE...

			$myChildTypeSlug = $myEntry['Entry']['entry_type'];
		}
		else // if this is a parent Entry ...
		{
			$myType = $this->Type->findBySlug($myEntry['Entry']['entry_type']);
		}
		return $this->_admin_default_edit($myType , $myEntry , $myParentEntry , $myChildTypeSlug);
	}

	/**
	* querying to get a bunch of entries based on parameter given (core function)
	* @param array $myType contains record query result of database type
	* @param integer $paging[optional] contains selected page of lists you want to retrieve
	* @param array $myEntry[optional] contains record query result of the parent Entry (used if want to search certain child Entry)
	* @param string $myMetaKey[optional] contains specific key that entries must have
	* @param string $myMetaValue[optional] contains specific value from certain key that entries must have
	* @param string $myChildTypeSlug[optional] contains slug of child type database (used if want to search certain child Entry)
	* @param string $orderField[optional] order field
	* @param string $orderDirection[optional] contains 'ASC' or 'DESC'
	* @param string $lang[optional] contains language of the entries that want to be retrieved
	* @return array $data certain bunch of entries you'd requested
	* @public
	**/
	function _admin_default($myType = array(),$paging = 1 , $myEntry = array() , $myMetaKey = NULL , $myMetaValue = NULL , $myChildTypeSlug = NULL , $orderField = NULL , $orderDirection = NULL , $lang = NULL)
	{
		$data['mySetting'] = $this->Setting->get_settings();
		$data['myType'] = $myType;
		$data['paging'] = $paging;
		if(!empty($myEntry))
		{
			$data['myEntry'] = $myEntry;
			$myChildType = $this->Type->findBySlug($myChildTypeSlug);
			$data['myChildType'] = $myChildType;
		}
		$countPage = $this->countListPerPage;

		// our list conditions... ----------------------------------------------------------------------------------////
		if(empty($myEntry))
		{
			$options['conditions'] = array(
				'Entry.parent_id' => 0,
				'Entry.status' => 1,
				'Entry.entry_type' => $myType['Type']['slug']
			);
		}
		else
		{
			$options['conditions'] = array(
				'Entry.parent_id' => $myEntry['Entry']['id'],
				'Entry.status' => 1,
				'Entry.entry_type' => $myChildTypeSlug
			);
		}
		if($myType['Type']['slug'] != 'media')
		{
			$options['conditions']['Entry.lang_code LIKE'] = (empty($lang)?substr($data['mySetting']['sites']['language'][0], 0,2):$lang).'-%';
		}
		// find last modified... ----------------------------------------------------------------------------------////
		$options['order'] = array('Entry.modified DESC');
		$lastModified = $this->Entry->find('first' , $options);
		$data['lastModified'] = $lastModified;
		// end of last modified...

		$resultTotalList = $this->Entry->find('count' , $options);
		$data['totalList'] = $resultTotalList;

		$options['order'] = (empty($orderField)||empty($orderDirection)?array('Entry.sort_order DESC'):array('Entry.'.strtolower($orderField).' '.$orderDirection));
		if($paging > 0)
		{
			$options['offset'] = ($paging-1) * $countPage;
			$options['limit'] = $countPage;
		}
		$mysql = $this->Entry->find('all' ,$options);
		$data['myList'] = $mysql;

		// set New countPage
		$newCountPage = ceil($resultTotalList * 1.0 / $countPage);
		$data['countPage'] = $newCountPage;

		// for image input type reason...
		$data['myImageTypeList'] = $this->EntryMeta->embedded_img_meta('type');

		// FINAL TOUCH !!
		if(!empty($myMetaKey) && !empty($myMetaValue))
		{
			$data = $this->_admin_meta_options($data , $myMetaKey , $myMetaValue);
		}
		return $data;
	}

	function _admin_meta_options($data , $myMetaKey , $myMetaValue)
	{
		$lastModified = 0;
		$data['totalList'] = 0;
		foreach ($data['myList'] as $key => $value)
		{
			$state = 0;
			foreach ($value['EntryMeta'] as $key10 => $value10)
			{
				if(substr($value10['key'], 5) == $myMetaKey && parent::get_slug($value10['value']) == $myMetaValue)
				{
					$state = 1;
					break;
				}
			}
			if($state == 0)
			{
				unset($data['myList'][$key]);
			}
			else // if it is a valid list, ...
			{
				$data['totalList']++;
				// get our last Modified !!
				if($value['Entry']['modified'] > $lastModified)
				{
					$data['lastModified'] = $value;
					$lastModified = $value['Entry']['modified'];
				}
			}
		}
		$data['countPage'] = ceil($data['totalList'] * 1.0 / $this->countListPerPage);
		return $data;
	}

	/**
	* querying to get specific entry from entry lists based on parameter given (core function)
	* @param array $myType contains record query result of database type
	* @param array $myEntry contains record query result of the selected Entry
	* @param array $myParentEntry[optional] contains record query result of the parent Entry (used if want to search certain child Entry)
	* @param string $myChildTypeSlug[optional] contains slug of child type database (used if want to search certain child Entry)
	* @return array $result a selected entry with all of its attributes you'd requested
	* @public
	**/
	function _admin_default_edit($myType = array() , $myEntry = array() , $myParentEntry = array() , $myChildTypeSlug = NULL)
	{
		$data['myType'] = $myType;
		$data['myEntry'] = $myEntry;
		if(!empty($myParentEntry))
		{
			$data['myParentEntry'] = $myParentEntry;
			$myChildType = $this->Type->findBySlug($myChildTypeSlug);
			$data['myChildType'] = $myChildType;
		}
		// for image input type reason...
		$data['myImageTypeList'] = $this->EntryMeta->embedded_img_meta('type');

		// FINAL TOUCH !!
		$data['mySetting'] = $this->Setting->get_settings();
		return $data;
	}
	
	/**
	* @param int $id value from entry id
	* @param string $key meta key
	**/
	function meta_detail($id=null,$key=null)
	{
		$entry = $this->EntryMeta->find('first', array(
			'conditions' => array(
				'EntryMeta.entry_id' => $id,
				'EntryMeta.key' => $key
			)
		));
		$value = $entry['EntryMeta']['value'];
		unset($entry);
		
		return $value;
	}
	
	function simple_list_entry($args=array())
	{
		if(isset($args['field_order']) and isset($args['order']))
			$order = 'Entry.'.$args['field_order'].' '.$args['order'];
		else
			$order = null;

		// find all product
		$entry = $this->Entry->find('all', array(
			'conditions' => array(
				'Entry.entry_type' => $args['entry_type'],
				'Entry.status' => 1,
				'Entry.parent_id' => $args['parent_id']
			),
			'recursive' => $args['recursive'],
			'offset' => $args['offset'],
			'limit' => $args['limit'],
			'order' => $order
		));
		return $entry;
	}

	function simple_list_entry_and_meta($args=array())
	{
		if(isset($args['field_order']) and isset($args['order']))
			$order = 'Entry.'.$args['field_order'].' '.$args['order'];
		else
			$order = null;

		// find all product
		$entry = $this->EntryMeta->find('all', array(
			'conditions' => array(
				'Entry.entry_type' => $args['entry_type'],
				'Entry.status' => 1,
				'Entry.parent_id' => $args['parent_id'],
				'EntryMeta.key' => $args['key'],
				'EntryMeta.value' => $args['value']
			),
			'recursive' => $args['recursive'],
			'offset' => $args['offset'],
			'limit' => $args['limit'],
			'order' => $order
		));
		return $entry;
	}

	function entry_detail($args=array())
	{
		$conditions = array(
			'Entry.status' => 1
		);

		if (array_key_exists("id", $args))
			$conditions["Entry.id"] = $args["id"];
		if (array_key_exists("entry_type", $args))
			$conditions["Entry.entry_type"] = $args["entry_type"];
		if (array_key_exists("slug", $args))
			$conditions["Entry.slug"] = $args["slug"];

		$entry = $this->Entry->find('first', array(
			'conditions' => $conditions,
			'recursive' => $args['recursive']
		));
		return $entry;
	}
	
	function type_detail($args=array())
	{
		$conditions = array();

		if (array_key_exists("id", $args))
			$conditions["Type.id"] = $args["id"];
		if (array_key_exists("slug", $args))
			$conditions["Type.slug"] = $args["slug"];

		$type = $this->Type->find('first', array(
			'conditions' => $conditions,
			'recursive' => $args['recursive']
		));
		return $type;
	}
	
	function count_total_activity($args=array())
	{
		if(isset($args['field_order']) and isset($args['order']))
			$order = 'Entry.'.$args['field_order'].' '.$args['order'];
		else
			$order = null;

		// find all product
		$entry = $this->Entry->find('all', array(
			'conditions' => array(
				'Entry.entry_type' => $args['entry_type'],
				'Entry.status' => 1,
				'Entry.parent_id' => $args['parent_id'],
				'Entry.created_by' => $args['created_by']
			),
			'recursive' => $args['recursive'],
			'offset' => $args['offset'],
			'limit' => $args['limit'],
			'order' => $order
		));
		return $entry;
	}
	
	function volunteers_of_organization($idOrg)
	{
		// find all activity
		$activities = $this->EntryMeta->find('all', array(
			'conditions' => array(
				'Entry.entry_type' => 'activities',
				'Entry.status' => 1,
				'EntryMeta.key' => 'organization-id',
				'EntryMeta.value' => $idOrg
			)
		));
		
		foreach($activities as $activity)
		{
			// find all volunteer
			$volunteers = $this->EntryMeta->find('all', array(
				'conditions' => array(
					'Entry.entry_type' => 'activity-members',
					'Entry.status' => 1,
					'EntryMeta.key' => 'activity-id',
					'EntryMeta.value' => $activity['Entry']['id']
				)
			));
			
			$temp = array();
			foreach($volunteers as $volunteer)
			{
				array_push($temp, $volunteer['Entry']['created_by']);
			}
		}
		
		return $temp;
	}
	
	function featured($args=array())
	{
		if(isset($args['field_order']) and isset($args['order']))
			$order = 'Entry.'.$args['field_order'].' '.$args['order'];
		else
			$order = null;

		// find all product
		$entry = $this->Entry->find('all', array(
			'conditions' => array(
				'Entry.description <>' => "",
				'Entry.entry_type' => $args['entry_type'],
				'Entry.status' => 1,
				'Entry.parent_id' => $args['parent_id']
			),
			'recursive' => $args['recursive'],
			'offset' => $args['offset'],
			'limit' => $args['limit'],
			'order' => $order
		));
		return $entry;
	}
	
	function first_featured($args=array())
	{
		if(isset($args['field_order']) and isset($args['order']))
			$order = 'Entry.'.$args['field_order'].' '.$args['order'];
		else
			$order = null;

		// find all product
		$entry = $this->Entry->find('first', array(
			'conditions' => array(
				'Entry.description <>' => "",
				'Entry.entry_type' => $args['entry_type'],
				'Entry.status' => 1,
				'Entry.parent_id' => $args['parent_id']
			),
			'recursive' => $args['recursive'],
			'offset' => $args['offset'],
			'limit' => $args['limit'],
			'order' => $order
		));
		return $entry;
	}
	
	// ---------------------------------------------------------------------------------------------------------------------------- //
	// ---------------------------------------------- END OF DATABASE FUNCTION ---------------------------------------------------- //
	// ---------------------------------------------------------------------------------------------------------------------------- //
	
	
	// ---------------------------------------------- START OF STORE HELPER ---------------------------------------------------- //
	
	function categories($lang=null)
	{
		$entry = $this->Entry->find('all', array(
			'conditions' => array(
				'Entry.entry_type' => 'categories',
				'Entry.status' => 1,
				'Entry.lang_code LIKE' => $lang."%"
			),
			'recursive' => 1,
			'order' => 'Entry.title ASC'
		));
		
		$main = array();
		$sub = array();
		foreach($entry as $e)
		{
			foreach($e['ChildEntry'] as $index => $ce)
			{
				$sub[$index]['title'] = $ce['title'];
				$sub[$index]['slug'] = $ce['slug'];
				$sub[$index]['link'] = $e['Entry']['entry_type'].'/'.$e['Entry']['slug'].'/'.$ce['slug'];
			}
			array_push($main, array(
				"title" => $e['Entry']['title'],
				"slug" => $e['Entry']['slug'],
				"link" => $e['Entry']['entry_type'].'/'.$e['Entry']['slug'],
				"sub" => $sub
			));
			unset($sub);
		}
		unset($entry);
		
		return $main;
	}
	
	function item_by_category($lang=null,$order=null,$limit=null)
	{
		$options['conditions'] = array(
			'Entry.entry_type' => 'products',
			'Entry.status' => 1,
			'Entry.parent_id' => 0,
			'Entry.lang_code LIKE' => $lang."%"
		);
		
		if(!empty($order)) $order = "'order' => 'Entry.sort_order ".$order."'";
		if(!empty($limit)) $limit = "'limit' => ".$limit;
		$recursive = "'recursive' => 1";
		
		$entry = $this->Entry->find('all', $options, $order, $limit, $recursive);
		
		return $entry;
	}
	
	// ---------------------------------------------- END OF STORE HELPER ---------------------------------------------------- //
	
}
?>
