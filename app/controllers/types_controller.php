<?php
class TypesController extends AppController {
	public $name = 'Types';
	public $components = array('Email','RequestHandler','Session','Image','Validation','Auth');
	public $helpers = array('Form', 'Html', 'Js', 'Time', 'Ajax' , 'Get');
	private $countListPerPage = 15;

	function index() {
		$this->Dbtype->recursive = 0;
		$this->set('dbtypes', $this->paginate());
	}

	/**
	 * fork our target routes for Type(database) CRUD
	 * @return void
	 * @public
	 **/
	function admin_master()
	{
		// Tree of division beginsss !!
		$myRenderFile = '';
		if(empty($this->params['pass']))
		{
			// IF THIS WANT TO LIST ALL TYPES...
			$this->_admin_default();
			$myRenderFile = 'admin_default';
		}
		else if(empty($this->params['pass'][1]))
		{
			// IF THIS WANT TO ADD NEW PARENT TYPES...
			if($this->params['pass'][0] == 'add')
			{
				$this->_admin_default_add();
				$myRenderFile = 'admin_default_add';
			}
			else // IF THIS WANT TO LIST ALL CHILD TYPES...
			{
				$tesType = $this->Type->findBySlug($this->params['pass'][0]);
				if(!empty($tesType))
				{
					$this->_admin_default(1 , $tesType);
					$myRenderFile = 'admin_default';
				}
			}
		}
		else if(empty($this->params['pass'][2]))
		{
			// IF THIS WANT TO LIST ALL TYPES WITH PAGINATION ...
			if($this->params['pass'][0] == 'index' && is_numeric($this->params['pass'][1]))
			{
				$this->_admin_default($this->params['pass'][1]);
				$myRenderFile = 'admin_default';
			}
			// IF THIS WANT TO EDIT PARENT TYPES...
			else if($this->params['pass'][0] == 'edit')
			{
				$tesType = $this->Type->findBySlug($this->params['pass'][1]);
				if(!empty($tesType))
				{
					$this->_admin_default_edit($tesType);
					$myRenderFile = 'admin_default_add';
				}
			}
			// IF THIS WANT TO ADD NEW CHILD TYPES...
			else if($this->params['pass'][1] == 'add')
			{
				$tesType = $this->Type->findBySlug($this->params['pass'][0]);
				if(!empty($tesType))
				{
					$this->_admin_default_add($tesType);
					$myRenderFile = 'admin_default_add';
				}
			}
		}
		else  // MAX LEVEL...
		{
			$tesType = $this->Type->findBySlug($this->params['pass'][0]);
			if(!empty($tesType))
			{
				// IF THIS WANT TO LIST ALL CHILD TYPES WITH PAGINATION ...
				if($this->params['pass'][1] == 'index' && is_numeric($this->params['pass'][2]))
				{
					$this->_admin_default( $this->params['pass'][2] , $tesType );
					$myRenderFile = 'admin_default';
				}
				// IF THIS WANT TO EDIT CHILD TYPES...
				else if($this->params['pass'][1] == 'edit')
				{
					$childType = $this->Type->findBySlug($this->params['pass'][2]);
					if(!empty($childType))
					{
						$this->_admin_default_edit($childType , $tesType);
						$myRenderFile = 'admin_default_add';
					}
				}
			}
		}
		$this->render($myRenderFile);
	}

	/**
	* querying to get list of available database types.
	* @param integer $paging[optional] contains selected page of lists you want to retrieve
	* @param array $myParentType[optional] contains record query result of parent database type(used if want to search that child database types)
	* @return void
	* @public
	**/
	function _admin_default($paging = 1 , $myParentType = array())
	{
		if ($this->RequestHandler->isAjax())
		{
			$this->layout = 'ajax';
			$data['isAjax'] = 1;
		}
		else
		{
			$data['isAjax'] = 0;
		}
		$data['paging'] = $paging;
		$data['myParentType'] = $myParentType;
		$countPage = $this->countListPerPage;

		// set page title
		$this->setTitle(empty($myParentType)?'Database Master':$myParentType['Type']['name']);

		// our list conditions... ----------------------------------------------------------------------------------////
		$options['conditions'] = array(
			'Type.parent_id' => (empty($myParentType)?array(-1,0):$myParentType['Type']['id'])
		);
		// find last modified... ----------------------------------------------------------------------------------////
		$options['order'] = array('Type.modified DESC');
		$lastModified = $this->Type->find('first' , $options);
		$data['lastModified'] = $lastModified;
		// end of last modified...

		$resultTotalList = $this->Type->find('count' , $options);
		$data['totalList'] = $resultTotalList;

		$options['order'] = array('Type.created DESC');
		$options['offset'] = ($paging-1) * $countPage;
		$options['limit'] = $countPage;

		$mysql = $this->Type->find('all' ,$options);
		$data['myList'] = $mysql;

		// set New countPage
		$newCountPage = ceil($resultTotalList * 1.0 / $countPage);
		$data['countPage'] = $newCountPage;

		// set the paging limitation...
		$left_limit = 1;
		$right_limit = 5;
		if($newCountPage <= 5)
		{
			$right_limit = $newCountPage;
		}
		else
		{
			$left_limit = $paging-2;
			$right_limit = $paging+2;
			if($left_limit < 1)
			{
				$left_limit = 1;
				$right_limit = 5;
			}
			else if($right_limit > $newCountPage)
			{
				$right_limit = $newCountPage;
				$left_limit = $newCountPage - 4;
			}
		}
		$data['left_limit'] = $left_limit;
		$data['right_limit'] = $right_limit;

		// FINAL TOUCH !!
		$data['mySetting'] = $this->Setting->get_settings();
		$this->set('data' , $data);
	}

	/**
	* add new database type
	* @param array $myParentType[optional] contains record query result of parent database type(used if want to add new database child for that type)
	* @return void
	* @public
	**/
	function _admin_default_add($myParentType = array())
	{
		$this->setTitle('Add New Database');
		$data['myParentType'] = $myParentType;

		// FINAL TOUCH !!
		$data['mySetting'] = $this->Setting->get_settings();
		$this->set('data' , $data);

		// if form submit is taken...
		if (!empty($this->data))
		{
			$this->data['Type']['name'] = $this->data['Type'][0]['value'];
			$this->data['Type']['slug'] = $this->get_slug($this->data['Type']['name']);
			$this->data['Type']['description'] = $this->data['Type'][1]['value'];
			// write my creator...
			$myCreator = $this->Auth->user();
			$this->data['Type']['created_by'] = $myCreator['Account']['user_id'];
			$this->data['Type']['modified_by'] = $myCreator['Account']['user_id'];
			// write time created manually !!
			$nowDate = $this->getNowDate();
			$this->data['Type']['created'] = $nowDate;
			$this->data['Type']['modified'] = $nowDate;
			// set parent_id
			$this->data['Type']['parent_id'] = (empty($myParentType)?-1:$myParentType['Type']['id']);

			// now for validation !!
			$this->Type->set($this->data);
			if($this->Type->validates())
			{
				// SPECIAL CASE FOR CHECKING MEDIA SETTINGS ...
				if(empty($this->data['TypeMeta'][2]['value']) && !empty($this->data['TypeMeta'][3]['value']) || !empty($this->data['TypeMeta'][2]['value']) && empty($this->data['TypeMeta'][3]['value']) || empty($this->data['TypeMeta'][5]['value']) && !empty($this->data['TypeMeta'][6]['value']) || !empty($this->data['TypeMeta'][5]['value']) && empty($this->data['TypeMeta'][6]['value']))
				{
					$this->Session->setFlash('Please add media settings correctly.','failed');
					$this->redirect (array('controller'=>'master','action' => 'types'.(empty($myParentType)?'':'/'.$myParentType['Type']['slug']),'add'));
				}
				$this->Type->create();
				$this->Type->save($this->data);
				$typeId = $this->Type->id;
				if(!empty($myParentType))
				{
					// add COUNT to parent Type...
					$this->Type->id = $myParentType['Type']['id'];
					$this->Type->saveField('count' , $myParentType['Type']['count'] + 1);
				}

				// NOW ADD TYPE METAS !!
				$this->data['TypeMeta']['type_id'] = $typeId;

				// save our MEDIA SETTINGS !!
				for ($i=2; $i <= 5 ; $i+=3)
				{
					if(!empty($this->data['TypeMeta'][$i]['value']))
					{
						$this->data['TypeMeta']['key'] = strtolower(substr($this->data['TypeMeta'][$i]['key'], 5));
						$this->data['TypeMeta']['value'] = $this->data['TypeMeta'][$i]['value'];
						$this->TypeMeta->create();
						$this->TypeMeta->save($this->data);
						$this->data['TypeMeta']['key'] = strtolower(substr($this->data['TypeMeta'][$i+1]['key'], 5));
						$this->data['TypeMeta']['value'] = $this->data['TypeMeta'][$i+1]['value'];
						$this->TypeMeta->create();
						$this->TypeMeta->save($this->data);
						$this->data['TypeMeta']['key'] = strtolower(substr($this->data['TypeMeta'][$i+2]['key'], 5));
						$this->data['TypeMeta']['value'] = (empty($this->data['TypeMeta'][$i+2]['value'])?0:1);
						$this->TypeMeta->create();
						$this->TypeMeta->save($this->data);
					}
				}
				// NOW SAVE OTHER INPUT TYPES...
				$i = 8;
				while(!empty($this->data['TypeMeta'][$i]))
				{
					$this->data['TypeMeta']['key'] = $this->data['TypeMeta'][$i++]['key'];
					$this->data['TypeMeta']['value'] = $this->slug_option_value($this->data['TypeMeta'][$i++]['value']);
					$this->data['TypeMeta']['input_type'] = $this->data['TypeMeta'][$i++]['input_type'];
					$this->data['TypeMeta']['validation'] = $this->data['TypeMeta'][$i++]['validation'];
					$this->data['TypeMeta']['instruction'] = $this->data['TypeMeta'][$i++]['instruction'];
					$this->TypeMeta->create();
					$this->TypeMeta->save($this->data);
				}
				// NOW finally setFlash ^^
				$this->Session->setFlash($this->data['Type']['name'].' has been added.','success');
				$this->redirect (array('controller'=>'master','action' => 'types'.(empty($myParentType)?'':'/'.$myParentType['Type']['slug'])));
			}
			else
			{
				$this->Session->setFlash('Please complete all required fields.','failed');
				$this->redirect (array('controller'=>'master','action' => 'types'.(empty($myParentType)?'':'/'.$myParentType['Type']['slug']),'add'));
			}
		}
	}

	/**
	* update certain database type
	* @param array $myType contains record query result of database type which is want to be edited
	* @param array $myParentType[optional] contains record query result of parent database type(used if want to update its certain database child)
	* @return void
	* @public
	**/
	function _admin_default_edit($myType = array() , $myParentType = array())
	{
		$this->setTitle('Edit '.$myType['Type']['name'].' Database');
		// GENERATE TYPEMETA AGAIN WITH SORT ORDER !!
		$metaOrder = $this->TypeMeta->find('all' , array(
			'conditions' => array(
				'TypeMeta.type_id' => $myType['Type']['id']
			),
			'order' => array('TypeMeta.id ASC')
		));
		$myType['TypeMeta'] = $metaOrder;
		foreach ($metaOrder as $key => $value)
		{
			$myType['TypeMeta'][$value['TypeMeta']['key']][0] = $value['TypeMeta']['value'];
		}
		$data['myType'] = $myType;

		$data['myParentType'] = $myParentType;
		// FINAL TOUCH !!
		$data['mySetting'] = $this->Setting->get_settings();
		$this->set('data' , $data);

		// if form submit is taken...
		if (!empty($this->data))
		{
			$this->data['Type']['name'] = $this->data['Type'][0]['value'];
			$this->data['Type']['description'] = $this->data['Type'][1]['value'];
			// write my creator...
			$myCreator = $this->Auth->user();
			$this->data['Type']['modified_by'] = $myCreator['Account']['user_id'];
			// write time created manually !!
			$nowDate = $this->getNowDate();
			$this->data['Type']['modified'] = $nowDate;

			// now for validation !!
			$this->Type->set($this->data);
			if($this->Type->validates())
			{
				// SPECIAL CASE FOR CHECKING MEDIA SETTINGS ...
				if(empty($this->data['TypeMeta'][2]['value']) && !empty($this->data['TypeMeta'][3]['value']) || !empty($this->data['TypeMeta'][2]['value']) && empty($this->data['TypeMeta'][3]['value']) || empty($this->data['TypeMeta'][5]['value']) && !empty($this->data['TypeMeta'][6]['value']) || !empty($this->data['TypeMeta'][5]['value']) && empty($this->data['TypeMeta'][6]['value']))
				{
					$this->Session->setFlash('Please edit media settings correctly.','failed');
					$this->redirect (array('controller'=>'master','action' => 'types'.(empty($myParentType)?'':'/'.$myParentType['Type']['slug']),'edit',$myType['Type']['slug']));
				}
				$this->Type->id = $myType['Type']['id'];
				$this->Type->save($this->data);

				// delete all the attributes, and then add again !!
				$this->TypeMeta->deleteAll(array('TypeMeta.type_id' => $this->Type->id ,
					'OR' => array(
						array('TypeMeta.key LIKE' => 'form%'),
						array('TypeMeta.key LIKE' => 'thumb%'),
						array('TypeMeta.key LIKE' => 'display%'),
					)
				));

				// NOW ADD TYPE METAS !!
				$this->data['TypeMeta']['type_id'] = $this->Type->id;

				// save our MEDIA SETTINGS !!
				for ($i=2; $i <= 5 ; $i+=3)
				{
					if(!empty($this->data['TypeMeta'][$i]['value']))
					{
						$this->data['TypeMeta']['key'] = strtolower(substr($this->data['TypeMeta'][$i]['key'], 5));
						$this->data['TypeMeta']['value'] = $this->data['TypeMeta'][$i]['value'];
						$this->TypeMeta->create();
						$this->TypeMeta->save($this->data);
						$this->data['TypeMeta']['key'] = strtolower(substr($this->data['TypeMeta'][$i+1]['key'], 5));
						$this->data['TypeMeta']['value'] = $this->data['TypeMeta'][$i+1]['value'];
						$this->TypeMeta->create();
						$this->TypeMeta->save($this->data);
						$this->data['TypeMeta']['key'] = strtolower(substr($this->data['TypeMeta'][$i+2]['key'], 5));
						$this->data['TypeMeta']['value'] = (empty($this->data['TypeMeta'][$i+2]['value'])?0:1);
						$this->TypeMeta->create();
						$this->TypeMeta->save($this->data);
					}
				}
				// NOW SAVE OTHER INPUT TYPES...
				$i = 8;
				while(!empty($this->data['TypeMeta'][$i]))
				{
					$this->data['TypeMeta']['key'] = $this->data['TypeMeta'][$i++]['key'];
					$this->data['TypeMeta']['value'] = $this->slug_option_value($this->data['TypeMeta'][$i++]['value']);
					$this->data['TypeMeta']['input_type'] = $this->data['TypeMeta'][$i++]['input_type'];
					$this->data['TypeMeta']['validation'] = $this->data['TypeMeta'][$i++]['validation'];
					$this->data['TypeMeta']['instruction'] = $this->data['TypeMeta'][$i++]['instruction'];
					$this->TypeMeta->create();
					$this->TypeMeta->save($this->data);
				}
				// NOW finally setFlash ^^
				$this->Session->setFlash($this->data['Type']['name'].' has been updated.','success');
				$this->redirect (array('controller'=>'master','action' => 'types'.(empty($myParentType)?'':'/'.$myParentType['Type']['slug'])));
			}
			else
			{
				$this->Session->setFlash('Update failed. Please try again','failed');
				$this->redirect (array('controller'=>'master','action' => 'types'.(empty($myParentType)?'':'/'.$myParentType['Type']['slug']),'edit',$myType['Type']['slug']));
			}
		}
	}

	/**
	 * retrieve all input elements from element directory
	 * @return array $inputType contains all available input elements
	 * @public
	 **/
	function get_input_types()
	{
		// get bunch of input types...
		$src = $this->get_view_dir().DS.'elements';
		$src = scandir($src);
		foreach ($src as $key => $value)
		{
			if(substr($value, 0 , 6) == 'input_')
			{
				$inputType[] = substr($value, 6 , strlen($value) - 10);
			}
		}
		return $inputType;
	}

	/**
	 * render popup form in add/update input field database type
	 * @param string $state "add" or "edit" state
	 * @return void
	 * @public
	 **/
	function form_popup($state)
	{
		$this->layout='ajax';
		$this->set('inputType' , $this->get_input_types());
		$this->set('state' , $state);
		// if form submit is taken...
		if (!empty($this->data))
		{
			$result = array();
			$this->autoRender = FALSE;
			$src = $this->data['TypeMeta'];

			$src['value']['option'] = trim($src['value']['option']); // SPECIAL CASE !!!

			// VALIDATE FIRST !!
			if(empty($src['key']) || $src['value']['state'] == 'exist' && empty($src['value']['option']) || $src['validation']['min_length']['state'] == 'yes' && (empty($src['validation']['min_length']['value']) || !is_numeric($src['validation']['min_length']['value']) || $src['validation']['min_length']['value'] == 0) || $src['validation']['max_length']['state'] == 'yes' && (empty($src['validation']['max_length']['value']) || !is_numeric($src['validation']['max_length']['value']) || $src['validation']['max_length']['value'] == 0))
			{
				$result['state'] = 'failed';
			}
			else if($src['validation']['max_length']['value'] < $src['validation']['min_length']['value'] && !empty($src['validation']['max_length']['value']) && !empty($src['validation']['min_length']['value']))
			{
				$result['state'] = 'minmax';
			}
			else
			{
				$src['key'] = strtolower(Inflector::slug($src['key']));
				$result['key'] = 'form-'.$src['key'];
				$result['frontKey'] = string_unslug($src['key']);

				$result['value'] = ($src['value']['state']=='exist'?$src['value']['option']:'');
				$result['input_type'] = $src['input_type'];
				$result['instruction'] = $src['instruction'];
				$result['validation'] = '';
				foreach ($src['validation'] as $key => $value)
				{
					if($key == 'min_length' || $key == 'max_length')
					{
						$result['validation'] .= ( $value['state'] == 'yes' ?$key.'_'.$value['value'].'|':'');
					}
					else
					{
						$result['validation'] .= ( $value == 'yes' ?$key.'|':'');
					}
				}
			}
			echo json_encode($result);
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid dbtype', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('dbtype', $this->Dbtype->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Dbtype->create();
			if ($this->Dbtype->save($this->data)) {
				$this->Session->setFlash(__('The dbtype has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dbtype could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid dbtype', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Dbtype->save($this->data)) {
				$this->Session->setFlash(__('The dbtype has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dbtype could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Dbtype->read(null, $id);
		}
	}

	/**
	 * delete database type
	 * @param integer $id contains id of the database type
	 * @return void
	 * @public
	 **/
	function delete($id = null)
	{
		$this->autoRender = FALSE;
		if (!$id) {
			$this->Session->setFlash('Invalid id for type', 'failed');
			header("Location: ".$_SESSION['now']);
			return;
		}
		$title = $this->Type->findById($id);

		$test = $this->Entry->find('first' , array(
			'conditions' => array(
				'Entry.entry_type' => $title['Type']['slug'],
				'Entry.status' => array(0,1)
			)
		));

		if(!empty($test))
		{
			$this->Session->setFlash('This type is in used by certain entry. Please remove them first!', 'failed');
			header("Location: ".$_SESSION['now']);
			return;
		}
		$this->TypeMeta->deleteAll(array('TypeMeta.type_id' => $id));
		$this->Type->delete($id);
		$myChildren = $this->Type->findAllByParentId($id);
		foreach ($myChildren as $key => $value)
		{
			$this->TypeMeta->deleteAll(array('TypeMeta.type_id' => $value['Type']['id']));
		}
		$this->Type->deleteAll(array('Type.parent_id' => $id));

		// minus the count of parent Type...
		if($title['Type']['parent_id'] > 0)
		{
			$myParent = $this->Type->findById($title['Type']['parent_id']);
			$this->Type->id = $myParent['Type']['id'];
			$this->Type->saveField('count' , $myParent['Type']['count'] - 1);
		}
		$this->Session->setFlash($title['Type']['name'].' has been deleted', 'success');
		header("Location: ".$_SESSION['now']);
	}

	/**
	 * generate slug for input option values for checkbox, radio, or pulldown input type field
	 * @param string $src contains source of input option values
	 * @return string $result input option values that already slugged
	 * @public
	 **/
	function slug_option_value($src)
	{
		$temp = explode(chr(13).chr(10), $src);
		foreach ($temp as $key => $value)
		{
			$temp[$key] = Inflector::slug($value);
		}
		$result = implode(chr(13).chr(10), $temp);
		return $result;
	}
}
