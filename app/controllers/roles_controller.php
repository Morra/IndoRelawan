<?php
class RolesController extends AppController {	
	public $name = 'Roles';
	public $components = array('Email','RequestHandler','Session','Image','Validation','Auth');
	public $helpers = array('Form', 'Html', 'Js', 'Time', 'Ajax' , 'Get');
	private $countListPerPage = 15;

	function index() {
		$this->Role->recursive = 0;
		$this->set('roles', $this->paginate());
	}
	
	/**
	 * fork our target routes for Role CRUD
	 * @return void
	 * @public
	 **/
	function admin_master()
	{
		// Tree of division beginsss !!
		$myRenderFile = '';
		if(empty($this->params['pass']))
		{
			// IF THIS WANT TO LIST ALL ROLES...
			$this->_admin_default();
			$myRenderFile = 'admin_default';
		}
		else if(empty($this->params['pass'][1]))
		{
			// IF THIS WANT TO ADD NEW ROLES...
			if($this->params['pass'][0] == 'add')
			{
				$this->_admin_default_add();
				$myRenderFile = 'admin_default_add';
			}
		}
		else // MAX LEVEL ...
		{			
			// IF THIS WANT TO EDIT ROLES...
			if($this->params['pass'][0] == 'edit')
			{	
				$myRole = $this->Role->findById($this->params['pass'][1]);
				if(!empty($myRole))
				{
					$this->_admin_default_edit($myRole);
					$myRenderFile = 'admin_default_add';
				}
			}			
		}
		$this->render($myRenderFile);
	}
	
	/**
	* querying to get list of available roles.
	* @return void
	* @public
	**/
	function _admin_default()
	{	
		// set page title
		$this->setTitle('Role Master');
		
		$resultTotalList = $this->Role->find('count');
		$data['totalList'] = $resultTotalList;
			
		$mysql = $this->Role->find('all');
		$data['myList'] = $mysql;
		
		// FINAL TOUCH !!
		$data['mySetting'] = $this->Setting->get_settings();
		$this->set('data' , $data);
	}

	/**
	* add new roles
	* @return void
	* @public
	**/
	function _admin_default_add()
	{	
		$this->setTitle('Add New Role');
		// FINAL TOUCH !!
		$data['mySetting'] = $this->Setting->get_settings();
		$this->set('data' , $data);
		
		// if form submit is taken...
		if (!empty($this->data)) 
		{
			$this->data['Role']['name'] = $this->data['Role'][0]['value'];
			$this->data['Role']['description'] = $this->data['Role'][1]['value'];
			
			// now for validation !!
			$this->Role->set($this->data);
			if($this->Role->validates())
			{
				$this->Role->create();
				$this->Role->save($this->data);
				
				// NOW finally setFlash ^^
				$this->Session->setFlash($this->data['Role']['name'].' has been added.','success');
				$this->redirect (array('controller'=>'master','action' => 'roles'));
			}
			else 
			{
				$this->Session->setFlash('Please complete all required fields.','failed');
				$this->redirect (array('controller'=>'master','action' => 'roles','add'));
			}
		}
	}

	/**
	* update roles
	* @return void
	* @public
	**/
	function _admin_default_edit($myRole = array())
	{	
		$this->setTitle('Edit '.$myRole['Role']['name'].' Role');
		$data['myRole'] = $myRole;
		// FINAL TOUCH !!
		$data['mySetting'] = $this->Setting->get_settings();
		$this->set('data' , $data);
		
		// if form submit is taken...
		if (!empty($this->data))
		{
			$this->data['Role']['name'] = $this->data['Role'][0]['value'];
			$this->data['Role']['description'] = $this->data['Role'][1]['value'];
			
			// now for validation !!
			$this->Role->set($this->data);
			if($this->Role->validates())
			{
				$this->Role->id = $myRole['Role']['id'];
				$this->Role->save($this->data);
				
				// NOW finally setFlash ^^
				$this->Session->setFlash($this->data['Role']['name'].' has been updated.','success');
				$this->redirect (array('controller'=>'master','action' => 'roles'));
			}
			else 
			{
				$this->Session->setFlash('Update failed. Please try again','failed');
				$this->redirect (array('controller'=>'master','action' => 'roles','edit',$myRole['Role']['id']));
			}
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid role', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('role', $this->Role->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Role->create();
			if ($this->Role->save($this->data)) {
				$this->Session->setFlash(__('The role has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The role could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid role', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Role->save($this->data)) {
				$this->Session->setFlash(__('The role has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The role could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Role->read(null, $id);
		}
	}

	/**
	 * delete role
	 * @param integer $id contains id of the role
	 * @return void
	 * @public
	 **/
	function delete($id = null) 
	{
		$this->autoRender = FALSE;
		if (!$id) {
			$this->Session->setFlash('Invalid id for role', 'failed');
			header("Location: ".$_SESSION['now']);
			return;
		}		
		$title = $this->Role->findById($id);
		
		$test = $this->User->find('first' , array(
			'conditions' => array(
				'User.role_id' => $id,
				'User.status' => array(0,1)
			)
		));		
		if(!empty($test))
		{
			$this->Session->setFlash('This role is in used by certain user. Please remove them first!', 'failed');
			header("Location: ".$_SESSION['now']);
			return;
		}
		$this->Role->delete($id);
		$this->Session->setFlash($title['Role']['name'].' has been deleted', 'success');
		header("Location: ".$_SESSION['now']);
	}
}
