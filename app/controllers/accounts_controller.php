<?php
class AccountsController extends AppController {
	public $name = 'Accounts';
    public $uses = array('User','UserMeta','Type','TypeMeta','EntryMeta','Entry','Role','Setting');
    public $components = array('Email','RequestHandler');
	public $helpers = array('Form', 'Html', 'Js', 'Time', 'Ajax');
	private $countListPerPage = 15;

	/**
	 * Before render callback. beforeRender is called before the view file is rendered.
	 * Overridden in subclasses.
	 * @param string $activePage contains the name of active page
	 * @return void
	 * @public
	 **/
    public function beforeRender($activePage='Account')
    {
        $this->set('setting',$this->Setting->find('all'));
        parent::beforeRender($activePage);
    }

	/**
	 * BeforeFilter callback. Called before the controller action.
	 * @return void
	 * @public
	 **/
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('index','forget','send_email','redirect_login','login', "reset_password", "register", "activate");
    }

	/**
	* querying to get list of user accounts.
	* @param integer $paging[optional] contains selected page of lists you want to retrieve
	* @return void
	* @public
	**/
	public function admin_index($paging = 1)
	{
		if ($this->RequestHandler->isAjax())
		{
			$this->layout = 'ajax';
			$this->set('isAjax' , 1);
		}
		else
		{
			$this->set('isAjax' , 0);
		}
		$this->set('paging' , $paging);

		// set page title
		$this->setTitle('Accounts');
		// set paging session...
		$countPage = $this->countListPerPage;

		// our list conditions...
		$options['conditions'] = array(
			'User.status' => array(0,1),
			'User.role_id' => array(2,3,4)
		);
		// find last modified...
		$options['order'] = array('Account.modified DESC');
		$this->Account->recursive = 2;
		$lastModified = $this->Account->find('first' , $options);
		$this->set('lastModified' , $lastModified);
		$this->Account->recursive = 1; // refresh recursive...
		// end of last modified...

		$resultTotalList = $this->User->find('count' , $options);
		$this->set('totalList' , $resultTotalList);

		$options['order'] = array('User.role_id' , 'Account.created DESC');
		$options['offset'] = ($paging-1) * $countPage;
		$options['limit'] = $countPage;
		$mysql = $this->User->find('all' ,$options);
		$this->set('myList' , $mysql);

		// set New countPage
		$newCountPage = ceil($resultTotalList * 1.0 / $countPage);
		$this->set('countPage' , $newCountPage);

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

		$this->set('left_limit' , $left_limit);
		$this->set('right_limit' , $right_limit);
	}

	/**
	* add user account to database account
	* @return void
	* @public
	**/
	function admin_add() // for role : morra support, admin, regular user...
	{
		$this->setTitle('Accounts - Add New');
		$listRoles = $this->Role->find('all' , array(
			'conditions' => array(
				'Role.id' => array(3,4,5)
			)
		));
		$this->set('listRoles' , $listRoles);

		if (!empty($this->data))
		{
			$myCreator = $this->Auth->user();
			$this->data['User']['created_by'] = $myCreator['Account']['user_id'];
			$this->data['User']['modified_by'] = $myCreator['Account']['user_id'];

			if($this->data['User']['role_id'] == '5')
			{
				$this->User->set($this->data);
				if($this->User->validates())
				{
					if($this->data['Account']['email'] != '')
					{
						$checkEmail = preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $this->data['Account']['email']);

						if($checkEmail == 1)
						{
							$findUserMeta = $this->UserMeta->find('first' , array(
								'conditions' => array(
									'UserMeta.key' => 'email',
									'UserMeta.value' => $this->data['Account']['email']
								)
							));

							if(!empty($findUserMeta))
							{
								$this->Session->setFlash('This user has already existed.','failed');
								$this->redirect (array('action' => 'add'));
							}
						}
						else
						{
							$this->Session->setFlash('Email is not valid.','failed');
							$this->redirect (array('action' => 'add'));
						}
					}

					$this->data['User']['role_id'] = 5; // as participants...
					$this->User->create();
					$this->User->save($this->data);

					if($this->data['Account']['email'] != '' and $checkEmail == 1)
					{
						$this->data['UserMeta']['user_id'] = $this->User->id;
						$this->data['UserMeta']['key'] = 'email';
						$this->data['UserMeta']['value'] = $this->data['Account']['email'];
						$this->UserMeta->create();
						$this->UserMeta->save($this->data);
					}

					$this->Session->setFlash($this->data['User']['firstname'].' '.$this->data['User']['lastname'].' has been created.','success');
					$this->redirect ('/admin/users');
				}
				else
				{
					$this->Session->setFlash('Please complete all required fields.','failed');
				}
			}
			else
			{
				$this->User->set($this->data);
				$this->Account->set($this->data);
				if($this->User->validates() && $this->Account->validates())
				{
					if(Security::hash($this->data['Account']['confirm'],null,true)==$this->data['Account']['password'])
					{
						if(strlen($this->data['Account']['confirm']) >= 5)
						{
							$findEmail = $this->Account->findByEmail($this->data['Account']['email']);
							if(!empty($this->data['Account']['username']))
							{
								$findUsername = $this->Account->findByUsername($this->data['Account']['username']);
							}
							else
							{
								$this->data['Account']['username'] = NULL;
							}

							if(!empty($findEmail) || !empty($findUsername))
							{
								$this->Session->setFlash('This account has been used. Please add with different account.','failed');
							}
							else
							{
								$findUserMeta = $this->UserMeta->find('first' , array(
									'conditions' => array(
										'UserMeta.key' => 'email',
										'UserMeta.value' => $this->data['Account']['email']
									)
								));

								if(empty($findUserMeta))
								{
									$this->User->create();
									$this->User->save($this->data);

									$this->data['UserMeta']['user_id'] = $this->User->id;
									$this->data['UserMeta']['key'] = 'email';
									$this->data['UserMeta']['value'] = $this->data['Account']['email'];
									$this->UserMeta->create();
									$this->UserMeta->save($this->data);

									$findUserMeta['UserMeta']['user_id'] = $this->User->id;
									$this->Session->setFlash($this->data['User']['firstname'].' '.$this->data['User']['lastname'].' account has been created.','success');
								}
								else
								{
									// from participants to regular user...
									$this->User->id = $findUserMeta['UserMeta']['user_id'];
									$this->User->saveField('role_id', 4);
									$this->User->saveField('status', 1);
									$myName = $this->User->findById($findUserMeta['UserMeta']['user_id']);
									$this->Session->setFlash($myName['User']['firstname'].' '.$myName['User']['lastname'].' has been promoted to regular user.','success');
								}

								$this->data['Account']['user_id'] = $findUserMeta['UserMeta']['user_id'];
								$this->Account->create();
								$this->Account->save($this->data);

								$user = $this->Account->findById($this->Account->id);

								// email section
								$setting = $this->Setting->find("first", array(
									"conditions" => array(
										"name" => "sites",
										"key" => "domain_name"
									)
								));
								$domain = "morrastudio.com";
								if (!empty($setting)) {
									$tmp = strtolower($setting["Setting"]["value"]);
									if (substr($tmp, 0, 7) == "http://")
										$tmp = substr($tmp, 7);
									else if (substr($tmp, 0, 8) == "https://")
										$tmp = substr($tmp, 8);
									if (substr($tmp, 0, 4) == "www.")
										$tmp = substr($tmp, 4);
									if (preg_match("/[^a-z.]+/", $tmp) === 0 and preg_match("/[a-z]+\.[a-z]+/", $tmp) === 1)
										$domain = $tmp;
								}
								$this->Email->from = "noreply@$domain";
								$this->Email->to = $user['Account']['email'];
								$this->Email->sendAs = "html";
								$this->Email->subject = 'Your Account Has Been Created';
								$body = array();
								$body[] = "Hello ".$user["User"]["firstname"]."<br />";
								$body[] = "Your account has been successfully created.<br />";
								$body[] = "Your password is: ".$this->data['Account']['confirm']."<br />";
								$body[] = "<a href=\"".$this->get_host_name()."login\">Click here to login</a><br />";
								$status = $this->Email->send($body);
								
								if($_SESSION['orderVisit'] == "admin/commerce/orders/add")
									$this->redirect ($_SERVER['SERVER_NAME'].'/admin/commerce/orders/add');
								else
									$this->redirect ('/admin/users');
							}
						}
						else
						{
							$this->Session->setFlash('Add user account failed. Minimum password length is invalid. Please try again','failed');
						}
					}
					else
					{
						$this->Session->setFlash('Add user account failed. Confirmation password must match with password. Please try again','failed');
					}
				}
				else
				{
					$this->Session->setFlash('Please complete all required fields.','failed');
				}
			}
		}
	}

	/**
	 * update user account
 	 * @param integer $id contains id of the user account
	 * @return void
	 * @public
	 **/

	function admin_edit($id = null)
	{
		$this->setTitle('Accounts - Edit');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid account', 'failed');
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data))
		{
			$this->User->set($this->data);
			$this->Account->set($this->data);
			if($this->User->validates() && $this->Account->validates())
			{
				if(empty($this->data['Account']['confirm']) && empty($this->data['Account']['password']) || (Security::hash($this->data['Account']['confirm'],null,true)==$this->data['Account']['password']))
				{
					if(empty($this->data['Account']['confirm']) || strlen($this->data['Account']['confirm']) >= 5)
					{
						$findEmail = $this->Account->find('first' , array(
							'conditions' => array(
								'Account.email' => $this->data['Account']['email'],
								'Account.id <>' => $id
							)
						));
						if(!empty($this->data['Account']['username']))
						{
							$findUsername = $this->Account->find('first' , array(
								'conditions' => array(
									'Account.username' => $this->data['Account']['username'],
									'Account.id <>' => $id
								)
							));
						}
						else
						{
							$this->data['Account']['username'] = NULL;
						}

						if(!empty($findEmail) || !empty($findUsername))
						{
							$this->Session->setFlash('This account has been used.','failed');
							$this->redirect (array('action' => 'edit',$id));
						}
						else
						{
							$findUser = $this->Account->findById($id);
							$findUserMeta = $this->UserMeta->find('first' , array(
								'conditions' => array(
									'UserMeta.key' => 'email',
									'UserMeta.user_id' => $findUser['Account']['user_id'],
									'UserMeta.value' => $this->data['Account']['email']
								)
							));

							if(empty($findUserMeta))
							{
								// $this->UserMeta->deleteAll(array(
									// 'UserMeta.key' => $findAttrib['Attribute']['id'],
									// 'UserMeta.user_id' => $findUser['Account']['user_id'],
									// 'UserMeta.value' => $findUser['Account']['email']
								// ));

								$this->data['UserMeta']['user_id'] = $findUser['Account']['user_id'];
								$this->data['UserMeta']['key'] = 'email';
								$this->data['UserMeta']['value'] = $this->data['Account']['email'];
								$this->UserMeta->create();
								$this->UserMeta->save($this->data);
							}

							// CUSTOM //

							$findUserId = $this->User->findById($findUser['Account']['user_id']);
							$this->User->id = $findUserId['User']['id'];
							$this->User->saveField('firstname' , $this->data['User']['firstname']);
							$this->User->saveField('lastname' , $this->data['User']['lastname']);

							// CUSTOM //

							$this->Account->id = $id;
							$this->data['Account']['user_id'] = $findUser['Account']['user_id'];
							if(empty($this->data['Account']['confirm']) && empty($this->data['Account']['password']))
							{
								$this->data['Account']['password'] = $findUser['Account']['password'];
							}
							$this->Account->save($this->data);

							if(!empty($this->data['Account']['confirm']) && !empty($this->data['Account']['password'])) {
								$user = $this->Account->findById($this->Account->id);

								// email section
								$setting = $this->Setting->find("first", array(
									"conditions" => array(
										"name" => "sites",
										"key" => "domain_name"
									)
								));
								$domain = "morrastudio.com";
								if (!empty($setting)) {
									$tmp = strtolower($setting["Setting"]["value"]);
									if (substr($tmp, 0, 7) == "http://")
										$tmp = substr($tmp, 7);
									else if (substr($tmp, 0, 8) == "https://")
										$tmp = substr($tmp, 8);
									if (substr($tmp, 0, 4) == "www.")
										$tmp = substr($tmp, 4);
									if (preg_match("/[^a-z.]+/", $tmp) === 0 and preg_match("/[a-z]+\.[a-z]+/", $tmp) === 1)
										$domain = $tmp;
								}
								$this->Email->from = "noreply@$domain";
								$this->Email->to = $user['Account']['email'];
								$this->Email->sendAs = "html";
								$this->Email->subject = 'Your Password Has Been Changed';
								$body = array();
								$body[] = "Hello ".$user["User"]["firstname"]."<br />";
								$body[] = "Your password has been successfully changed.<br />";
								$body[] = "Your new password is: ".$this->data['Account']['confirm']."<br />";
								$body[] = "<a href=\"".$this->get_host_name()."login\">Click here to login</a><br />";
								$status = $this->Email->send($body);
							}

							$myName = $this->User->findById($this->data['Account']['user_id']);
							$this->Session->setFlash('Update '.$myName['User']['firstname'].' '.$myName['User']['lastname'].' account success.','success');
							// $this->redirect (array('action' => 'index'));
							$this->redirect ('/admin/users');
						}
					}
					else
					{
						$this->Session->setFlash('Update user account failed. Minimum password length is invalid. Please try again','failed');
						$this->redirect (array('action' => 'edit',$id));
					}
				}
				else
				{
					$this->Session->setFlash('Update user account failed. Confirmation password must match with password. Please try again','failed');
					$this->redirect (array('action' => 'edit',$id));
				}
			}
			else
			{
				$this->Session->setFlash('The Account could not be saved. Please try again','failed');
				$this->redirect (array('action' => 'edit',$id));
			}
		}
		else
		{
			$this->set('id',$id);
			$findUser = $this->Account->findById($id);

			$this->User->recursive = 1;
			$result = $this->User->findById($findUser['Account']['user_id']);
			$this->set('myData' , $result);
		}
	}

	function admin_edit_bak($id = null)
	{
		$this->setTitle('Accounts - Edit');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid account', 'failed');
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data))
		{
			$this->User->set($this->data);
			$this->Account->set($this->data);
			if($this->User->validates() && $this->Account->validates())
			{
				if(empty($this->data['Account']['confirm']) && empty($this->data['Account']['password']) || (Security::hash($this->data['Account']['confirm'],null,true)==$this->data['Account']['password']))
				{
					if(empty($this->data['Account']['confirm']) || strlen($this->data['Account']['confirm']) >= 5)
					{
						$findEmail = $this->Account->find('first' , array(
							'conditions' => array(
								'Account.email' => $this->data['Account']['email'],
								'Account.id <>' => $id
							)
						));
						if(!empty($this->data['Account']['username']))
						{
							$findUsername = $this->Account->find('first' , array(
								'conditions' => array(
									'Account.username' => $this->data['Account']['username'],
									'Account.id <>' => $id
								)
							));
						}
						else
						{
							$this->data['Account']['username'] = NULL;
						}

						if(!empty($findEmail) || !empty($findUsername))
						{
							$this->Session->setFlash('This account has been used.','failed');
							$this->redirect (array('action' => 'edit',$id));
						}
						else
						{
							$findUser = $this->Account->findById($id);
							$findUserMeta = $this->UserMeta->find('first' , array(
								'conditions' => array(
									'UserMeta.key' => 'email',
									'UserMeta.user_id' => $findUser['Account']['user_id'],
									'UserMeta.value' => $this->data['Account']['email']
								)
							));

							if(empty($findUserMeta))
							{
								// $this->UserMeta->deleteAll(array(
									// 'UserMeta.key' => $findAttrib['Attribute']['id'],
									// 'UserMeta.user_id' => $findUser['Account']['user_id'],
									// 'UserMeta.value' => $findUser['Account']['email']
								// ));

								$this->data['UserMeta']['user_id'] = $findUser['Account']['user_id'];
								$this->data['UserMeta']['key'] = 'email';
								$this->data['UserMeta']['value'] = $this->data['Account']['email'];
								$this->UserMeta->create();
								$this->UserMeta->save($this->data);
							}

							$this->Account->id = $id;
							$this->data['Account']['user_id'] = $findUser['Account']['user_id'];
							if(empty($this->data['Account']['confirm']) && empty($this->data['Account']['password']))
							{
								$this->data['Account']['password'] = $findUser['Account']['password'];
							}
							$this->Account->save($this->data);

							if(!empty($this->data['Account']['confirm']) && !empty($this->data['Account']['password'])) {
								$user = $this->Account->findById($this->Account->id);

								// email section
								$setting = $this->Setting->find("first", array(
									"conditions" => array(
										"name" => "sites",
										"key" => "domain_name"
									)
								));
								$domain = "morrastudio.com";
								if (!empty($setting)) {
									$tmp = strtolower($setting["Setting"]["value"]);
									if (substr($tmp, 0, 7) == "http://")
										$tmp = substr($tmp, 7);
									else if (substr($tmp, 0, 8) == "https://")
										$tmp = substr($tmp, 8);
									if (substr($tmp, 0, 4) == "www.")
										$tmp = substr($tmp, 4);
									if (preg_match("/[^a-z.]+/", $tmp) === 0 and preg_match("/[a-z]+\.[a-z]+/", $tmp) === 1)
										$domain = $tmp;
								}
								$this->Email->from = "noreply@$domain";
								$this->Email->to = $user['Account']['email'];
								$this->Email->sendAs = "html";
								$this->Email->subject = 'Your Password Has Been Changed';
								$body = array();
								$body[] = "Hello ".$user["User"]["firstname"]."<br />";
								$body[] = "Your password has been successfully changed.<br />";
								$body[] = "Your new password is: ".$this->data['Account']['confirm']."<br />";
								$body[] = "<a href=\"".$this->get_host_name()."login\">Click here to login</a><br />";
								$status = $this->Email->send($body);
							}

							$myName = $this->User->findById($this->data['Account']['user_id']);
							$this->Session->setFlash('Update '.$myName['User']['firstname'].' '.$myName['User']['lastname'].' account success.','success');
							$this->redirect (array('action' => 'index'));
						}
					}
					else
					{
						$this->Session->setFlash('Update user account failed. Minimum password length is invalid. Please try again','failed');
						$this->redirect (array('action' => 'edit',$id));
					}
				}
				else
				{
					$this->Session->setFlash('Update user account failed. Confirmation password must match with password. Please try again','failed');
					$this->redirect (array('action' => 'edit',$id));
				}
			}
			else
			{
				$this->Session->setFlash('The Account could not be saved. Please try again','failed');
				$this->redirect (array('action' => 'edit',$id));
			}
		}
		else
		{
			$this->set('id',$id);
			$findUser = $this->Account->findById($id);

			$this->User->recursive = 1;
			$result = $this->User->findById($findUser['Account']['user_id']);
			$this->set('myData' , $result);
		}
	}

	/**
	 * delete user account
	 * @param integer $id contains id of the user account
	 * @return void
	 * @public
	 **/
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for user account', 'failed');
			$this->redirect(array('action'=>'index','admin'=>true));
		}

		$this->User->id = $id;
		$this->User->saveField('status' , -1);
		$this->Account->deleteAll(array('Account.user_id' => $id));

		$this->Session->setFlash('User account deleted', 'success');
		$this->redirect(array('action'=>'index','admin'=>true));
	}

	function redirect_login()
	{
		$this->redirect('/admin/login');
	}

	function login() {
		// admin login
		if($this->params['url']['url'] == 'admin/login') {
			$this->layout = 'login_default';
			$this->setTitle('Admin Login');

			$this->set('is_admin' , 1);
		}
		// front end login
		else {
			$this->layout = 'front_login_default';
			$this->setTitle('Login');

			$this->set('is_admin' , 0);
		}

		if($this->Auth->isAuthorized()) {
			// set session cookie !!
			if (!empty($this->data)) {
				$cookie = array();
				$cookie['email'] = $this->data['Account']['email'];
				$cookie['password'] = $this->data['Account']['password'];
				$this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');
			}

			// take the last modified first, so it not be affected...
			$myAccount = $this->Auth->user();
			$temp = $myAccount['Account']['modified'];

			// set last login...
			$this->Account->id = $myAccount['Account']['id'];
			$this->Account->saveField('last_login' , $this->getNowDate());
			$this->Account->saveField('modified' , $temp);

			if($this->params['url']['url'] == 'admin/login' || $this->params['form']['is_admin'] == 1)
			{
				$this->redirect(array('controller'=>'settings','action'=>'index','admin'=>true));
			} else
			{
				$this->redirect('/');
			}
		}
		else {
			if ($this->params['url']['url'] == 'admin/login') {
				if (!empty($this->data))
					if ($this->params['form']['is_admin'] != 1)
						$this->redirect('/login');
			}
			else
				// if using controller other than this action
				if (!empty($this->data)) {
					$status = $this->Auth->login($this->data);
					if ($status) {
						$cookie = array();
						$cookie['email'] = $this->data['Account']['email'];
						$cookie['password'] = $this->data['Account']['password'];
						$this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');

						// take the last modified first, so it not be affected...
						$myAccount = $this->Auth->user();
						$temp = $myAccount['Account']['modified'];

						// set last login...
						$this->Account->id = $myAccount['Account']['id'];
						$this->Account->saveField('last_login' , $this->getNowDate());
						$this->Account->saveField('modified' , $temp);
					}
					else
						$this->Session->setFlash("Login failed", 'failed');

					$this->redirect('/login');
				}
		}
		// use different view for front end
		if($this->params['url']['url'] != 'admin/login')
			$this->render("front_login");
    }

	/**
	 * Authorization for logging out from the admin panel
	 * @return void
	 * @public
	 **/
    function logout($is_admin)
    {
    	$this->Cookie->delete('Auth.User');
		$this->Auth->logout();
		$this->redirect(($is_admin==1?'/admin':'').'/login');
    }

	function __validateLoginStatus()
    {
        if($this->action != 'login' && $this->action != 'logout')
        {
            if($this->Session->check('Account') == false)
            {
                $this->redirect('login');
                $this->Session->setFlash('The URL you\'ve followed requires you login.');
            }
        }
    }

	function forget() {
		$this->layout = 'login_default';
		$is_admin = ($this->params['url']['url']=='forget'?0:1);
		$this->set('is_admin' , $is_admin);
		$this->setTitle("Forget Password");

		if(!empty($this->data)) {
			//Find account email
			$row = $this->Account->findByEmail($this->data['Account']['email']);

			if (empty($row))
				$this->Session->setFlash('Input email is incorrect', 'forget_failure');
			else {
				srand();
				$random_key = md5(time().rand(0, 100));
				$reset_link = $this->get_host_name().(empty($this->params["form"]["is_admin"]) ? "" : "admin/")."reset_password?key=".$random_key;

				// save key to user meta
				$user_meta = $this->UserMeta->findAllByUserId($row["User"]["id"]);
				$old_meta_id = array();
				foreach ($user_meta as $um)
					$old_meta_id[$um["UserMeta"]["key"]] = $um["UserMeta"]["id"];

				$save_meta = array();
				$tmp = array(
					"user_id" => $row["User"]["id"],
					"key" => "reset_pass_key",
					"value" => $random_key
				);
				if (isset($old_meta_id["reset_pass_key"]))
					$tmp["id"] = $old_meta_id["reset_pass_key"];
				$save_meta[] = $tmp;
				$tmp = array(
					"user_id" => $row["User"]["id"],
					"key" => "reset_pass_expired",
					"value" => date("Y-m-d H:i:s", time() + 3600)
				);
				if (isset($old_meta_id["reset_pass_expired"]))
					$tmp["id"] = $old_meta_id["reset_pass_expired"];
				$save_meta[] = $tmp;
				$this->UserMeta->saveAll($save_meta);

				// email section
				$setting = $this->Setting->find("first", array(
					"conditions" => array(
						"name" => "sites",
						"key" => "domain_name"
					)
				));
				$domain = "morrastudio.com";
				if (!empty($setting)) {
					$tmp = strtolower($setting["Setting"]["value"]);
					if (substr($tmp, 0, 7) == "http://")
						$tmp = substr($tmp, 7);
					else if (substr($tmp, 0, 8) == "https://")
						$tmp = substr($tmp, 8);
					if (substr($tmp, 0, 4) == "www.")
						$tmp = substr($tmp, 4);
					if (preg_match("/[^a-z.]+/", $tmp) === 0 and preg_match("/[a-z]+\.[a-z]+/", $tmp) === 1)
						$domain = $tmp;
				}
				$this->Email->from = "noreply@$domain";
				$this->Email->to = $this->data['Account']['email'];
				$this->Email->sendAs = "html";
				$this->Email->subject = 'Password Reset Information';
				$body = array();
				$body[] = "Hello ".$row["User"]["firstname"]."<br />";
				$body[] = "You recently tried to reset your password.<br />";
				$body[] = "Click link below to reset your password.<br />";
				$body[] = "<a href=\"$reset_link\">$reset_link</a><br />";
				$body[] = "If this link doesn't working, try copy it to address bar on your browser.";
				$status = $this->Email->send($body);
				if ($status) {
					$this->Session->setFlash('Your reset email has been sent, please check your email. If not found, please try check on your spam folder.','forget_success');
					$this->redirect((empty($this->params['form']['is_admin'])?'':'/admin')."/login");
				}
				else
					$this->Session->setFlash('Email failed to sent. Please try again.','forget_failure');
			}
		}
    }

	function reset_password() {
		$is_admin = ($this->params['url']['url']=='reset_password'?0:1);

		$key = null;
		if (isset($this->params["url"]["key"]))
			$key = $this->params["url"]["key"];

		if (empty($key))
			$this->redirect("/".($is_admin ? "admin" : ""));

		$this->layout = "login_default";
		$this->set("is_admin" , $is_admin);
		$this->setTitle("Reset Password");

		// check key
		$success = false;
		$user = $this->UserMeta->find("all", array(
			"conditions" => array(
				"key" => "reset_pass_key",
				"value" => $key
			),
			"recursive" => -1
		));
		if (!empty($user)) {
			$user_id = $user[0]["UserMeta"]["user_id"];
			if (count($user) == 1) {
				$user = $this->User->findById($user_id);

				$is_expired = true;
				foreach ($user["UserMeta"] as $um)
					if ($um["key"] == "reset_pass_expired") {
						$is_expired = (strtotime($um["value"]) < time());
						break;
					}

				if (!$is_expired)
					$success = true;
			}
		}

		if ($success) {
			if (!empty($this->data)) {
				if ($this->data["password"] == $this->data["confirm"]) {
					// delete all reset meta
					if (!empty($user_id))
						$this->UserMeta->deleteAll(array(
							"user_id" => $user_id,
							"key like" => "reset_pass_%"
						));

					// change password
					$this->Account->id = $user['Account']['id'];
					$this->Account->saveField('password' , Security::hash($this->data["password"],null,true));

					// email section
					$setting = $this->Setting->find("first", array(
						"conditions" => array(
							"name" => "sites",
							"key" => "domain_name"
						)
					));
					$domain = "morrastudio.com";
					if (!empty($setting)) {
						$tmp = strtolower($setting["Setting"]["value"]);
						if (substr($tmp, 0, 7) == "http://")
							$tmp = substr($tmp, 7);
						else if (substr($tmp, 0, 8) == "https://")
							$tmp = substr($tmp, 8);
						if (substr($tmp, 0, 4) == "www.")
							$tmp = substr($tmp, 4);
						if (preg_match("/[^a-z.]+/", $tmp) === 0 and preg_match("/[a-z]+\.[a-z]+/", $tmp) === 1)
							$domain = $tmp;
					}
					$this->Email->from = "noreply@$domain";
					$this->Email->to = $user['Account']['email'];
					$this->Email->sendAs = "html";
					$this->Email->subject = 'Your Password Has Been Changed';
					$body = array();
					$body[] = "Hello ".$user["User"]["firstname"]."<br />";
					$body[] = "Your password has been successfully changed.<br />";
					$body[] = "Your new password is: ".$this->data["password"]."<br />";
					$body[] = "<a href=\"".$this->get_host_name().(empty($this->params["form"]["is_admin"]) ? "" : "admin/")."login\">Click here to login</a><br />";
					$status = $this->Email->send($body);

					$this->Session->setFlash('Your password has been changed','forget_success');
					$this->redirect((empty($this->params['form']['is_admin'])?'':'/admin')."/login");
				}
				else
					$this->Session->setFlash('Confirm password must be same with password','forget_failure');
			}
		}
		else {
			// delete all reset meta
			if (!empty($user_id))
				$this->UserMeta->deleteAll(array(
					"user_id" => $user_id,
					"key like" => "reset_pass_%"
				));
			$this->Session->setFlash('Invalid key or your key has expired, please try to reset your password again','forget_failure');
			$this->redirect(($is_admin ? "/admin" : "")."/forget");
		}
	}

	function send_email()
	{
		$this->autoRender = FALSE;
        if(!empty($this->data)){
            $success = $this->Email->from = $this->data['contact']['email'];
            $success = $this->Email->to = $this->data['contact']['target'];
            $success = $this->Email->subject = "Our Profile";

			$mybody = "First Name : ".$this->data['contact']['fname']."\n";
			$mybody .= "Last Name : ".$this->data['contact']['lname']."\n";
			$mybody .= "Company : ".$this->data['contact']['company']."\n";
			$mybody .= "Website : ".$this->data['contact']['website']."\n";
			$mybody .= "Telephone : ".$this->data['contact']['telephone']."\n";
			$mybody .= "Message :\n".$this->data['contact']['message']."\n";

            $success = $this->Email->send($mybody);
			if($success)
			{
				echo "0";
			}
			else
			{
				echo "1";
			}
        }

		die();
    }

	function register() {
		$this->layout = "front_login_default";
		$this->setTitle("Register");

		if (isset($this->params["url"]["twitter"])) {
			$settings = $this->Setting->get_settings();
			App::import("Vendor", "Twitter", array("file" => "twitteroauth" . DS . "twitteroauth.php"));
			$consumer_key = $settings["sites"]["twitter_consumer_key"];
			$consumer_secret = $settings["sites"]["twitter_consumer_secret"];
			if(isset($_SESSION["access_token"])) {
				$access_token = $_SESSION["access_token"];
				$connection=NULL;
				try {
					$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token["oauth_token"], $access_token["oauth_token_secret"]);
					$users = $connection->get("account/verify_credentials");
				} catch(Exception $e) {
					unset($_SESSION["access_token"]);
				}
				if (!empty($users)) {
					$name = trim($users->name);
					$firstname = "";
					$lastname = "";
					$pos = strpos($name, " ");
					if ($pos === false)
						$firstname = name;
					else {
						$firstname = trim(substr($name, 0, $pos));
						$lastname = trim(substr($name, $pos + 1));
					}
					$this->set("twitter_user_name", array("firstname" => $firstname, "lastname" => $lastname));
				}
			}
		}

		if (!empty($this->data)) {
			$this->data['User']['created_by'] = 1;
			$this->data['User']['modified_by'] = 1;
			$this->data['User']['role_id'] = 4;
			$this->data['User']['status'] = 0;

			$this->User->set($this->data);
			$this->Account->set($this->data);
			if($this->User->validates() && $this->Account->validates())
			{
				if(Security::hash($this->data['Account']['confirm'],null,true)==$this->data['Account']['password'])
				{
					if(strlen($this->data['Account']['confirm']) >= 5)
					{
						$findEmail = $this->Account->findByEmail($this->data['Account']['email']);
						if(!empty($this->data['Account']['username']))
						{
							$findUsername = $this->Account->findByUsername($this->data['Account']['username']);
						}
						else
						{
							$this->data['Account']['username'] = NULL;
						}

						if(!empty($findEmail) || !empty($findUsername))
						{
							$this->Session->setFlash('This account has been used. Please add with different account.','failed');
						}
						else
						{
							$findUserMeta = $this->UserMeta->find('first' , array(
								'conditions' => array(
									'UserMeta.key' => 'email',
									'UserMeta.value' => $this->data['Account']['email']
								)
							));

							if(empty($findUserMeta))
							{
								$this->User->create();
								$this->User->save($this->data);

								$this->data['UserMeta']['user_id'] = $this->User->id;
								$this->data['UserMeta']['key'] = 'email';
								$this->data['UserMeta']['value'] = $this->data['Account']['email'];
								$this->UserMeta->create();
								$this->UserMeta->save($this->data);

								$findUserMeta['UserMeta']['user_id'] = $this->User->id;
								$this->Session->setFlash($this->data['User']['firstname'].' '.$this->data['User']['lastname'].' account has been created. Please check your email to confirm your account.','success');
							}
							else
							{
								// from participants to regular user...
								$this->User->id = $findUserMeta['UserMeta']['user_id'];
								$this->User->saveField('role_id', 4);
								$this->User->saveField('status', 0);
								$myName = $this->User->findById($findUserMeta['UserMeta']['user_id']);
								$this->Session->setFlash($myName['User']['firstname'].' '.$myName['User']['lastname'].' has been promoted to regular user.','success');
							}

							$this->data['Account']['user_id'] = $findUserMeta['UserMeta']['user_id'];
							$this->Account->create();
							$this->Account->save($this->data);

							$user = $this->Account->findById($this->Account->id);

							srand();
							$random_key = md5(time().rand(0, 100));
							$activate_link = $this->get_host_name()."activate?key=".$random_key;

							// save key to user meta
							$user_meta = $this->UserMeta->findAllByUserId($user["User"]["id"]);
							$old_meta_id = array();
							foreach ($user_meta as $um)
								$old_meta_id[$um["UserMeta"]["key"]] = $um["UserMeta"]["id"];

							$save_meta = array();
							$tmp = array(
								"user_id" => $user["User"]["id"],
								"key" => "activate_key",
								"value" => $random_key
							);
							if (isset($old_meta_id["activate_key"]))
								$tmp["id"] = $old_meta_id["activate_key"];
							$save_meta[] = $tmp;
							$tmp = array(
								"user_id" => $user["User"]["id"],
								"key" => "activate_expired",
								"value" => date("Y-m-d H:i:s", time() + 3600)
							);
							if (isset($old_meta_id["activate_expired"]))
								$tmp["id"] = $old_meta_id["activate_expired"];
							$save_meta[] = $tmp;
							if (!empty($users)) {
								$tmp = array(
									"user_id" => $user["User"]["id"],
									"key" => "tw_id",
									"value" => $users->id
								);
								if (isset($old_meta_id["tw_id"]))
									$tmp["id"] = $old_meta_id["tw_id"];
								$save_meta[] = $tmp;
							}
							$this->UserMeta->saveAll($save_meta);

							// email section
							$setting = $this->Setting->find("first", array(
								"conditions" => array(
									"name" => "sites",
									"key" => "domain_name"
								)
							));
							$domain = "morrastudio.com";
							if (!empty($setting)) {
								$tmp = strtolower($setting["Setting"]["value"]);
								if (substr($tmp, 0, 7) == "http://")
									$tmp = substr($tmp, 7);
								else if (substr($tmp, 0, 8) == "https://")
									$tmp = substr($tmp, 8);
								if (substr($tmp, 0, 4) == "www.")
									$tmp = substr($tmp, 4);
								if (preg_match("/[^a-z.]+/", $tmp) === 0 and preg_match("/[a-z]+\.[a-z]+/", $tmp) === 1)
									$domain = $tmp;
							}
							$this->Email->from = "noreply@$domain";
							$this->Email->to = $user['Account']['email'];
							$this->Email->sendAs = "html";
							$this->Email->subject = 'Your Account Has Been Created';
							$body = array();
							$body[] = "Hello ".$user["User"]["firstname"]."<br />";
							$body[] = "Your account has been successfully created.<br />";
							$body[] = "Your password is: ".$this->data['Account']['confirm']."<br />";
							$body[] = "Click link below to reset your password.<br />";
							$body[] = "<a href=\"$activate_link\">$activate_link</a><br />";
							$body[] = "If this link doesn't working, try copy it to address bar on your browser.<br /><br />";
							$body[] = "<a href=\"".$this->get_host_name()."login\">Click here to login</a><br />";
							$status = $this->Email->send($body);

							$this->redirect("/login");
						}
					}
					else
					{
						$this->Session->setFlash('Add user account failed. Minimum password length is invalid. Please try again','failed');
					}
				}
				else
				{
					$this->Session->setFlash('Add user account failed. Confirmation password must match with password. Please try again','failed');
				}
			}
			else
			{
				$this->Session->setFlash('Please complete all required fields.','failed');
			}

			if (empty($users))
				$this->redirect("/register");
			else
				$this->redirect("/register?twitter");
		}
	}

	function activate() {
		$this->autoRender = false;
		$key = null;
		if (isset($this->params["url"]["key"]))
			$key = $this->params["url"]["key"];

		if (empty($key))
			$this->redirect("/");

		// check key
		$success = false;
		$user = $this->UserMeta->find("all", array(
			"conditions" => array(
				"key" => "activate_key",
				"value" => $key
			),
			"recursive" => -1
		));
		if (!empty($user)) {
			$user_id = $user[0]["UserMeta"]["user_id"];
			if (count($user) == 1) {
				$user = $this->User->findById($user_id);

				$is_expired = true;
				foreach ($user["UserMeta"] as $um)
					if ($um["key"] == "activate_expired") {
						$is_expired = (strtotime($um["value"]) < time());
						break;
					}

				if (!$is_expired)
					$success = true;
			}
		}

		if ($success) {
			$this->User->id = $user["User"]["id"];
			$this->User->saveField('status', 1);

			$this->Session->setFlash('Your account has been activated, please login using your account','success');
		}

		// delete all reset meta
		if (!empty($user_id))
			$this->UserMeta->deleteAll(array(
				"user_id" => $user_id,
				"key like" => "activate_%"
			));
		$this->redirect("/login");
	}
}
