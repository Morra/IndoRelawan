<?php
class UsersController extends AppController {
	public $name='Users';
    public $uses = array('Account','UserMeta','Type','TypeMeta','EntryMeta','Entry','Role','Setting');
    public $components = array('Email','RequestHandler');
	public $helpers = array('Form', 'Html', 'Js', 'Time', 'Ajax');
	private $countListPerPage = 15;

	/**
	 * BeforeFilter callback. Called before the controller action.
	 * @return void
	 * @public
	 **/
    public function beforeFilter(){
        parent::beforeFilter();

        $this->Auth->allow("fb_connect", "subscribe", "twitter");
    }

	/**
	 * Before render callback. beforeRender is called before the view file is rendered.
	 * Overridden in subclasses.
	 * @param string $activePage contains the name of active page
	 * @return void
	 * @public
	 **/
    public function beforeRender($activePage='User')
    {
        $this->set('setting',$this->Setting->find('all'));
        parent::beforeRender($activePage);
    }

	function index() {
		$this->set('title_for_layout', 'User');
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	/**
	* querying to get list of users.
	* @param integer $paging[optional] contains selected page of lists you want to retrieve
	* @return void
	* @public
	**/
	
	function admin_index($paging = 1)
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
		$this->setTitle('Users');
		// set paging session...
		$countPage = $this->countListPerPage;

		// our list conditions...
		$options['conditions'] = array(
			'User.status' => array(0,1),
			'User.role_id >' => 1
		);
		// find last modified...
		$options['order'] = array('User.modified DESC');
		$lastModified = $this->User->find('first' , $options);
		$this->set('lastModified' , $lastModified);
		// end of last modified...

		$resultTotalList = $this->User->find('count' , $options);
		$this->set('totalList' , $resultTotalList);

		$options['order'] = array('User.role_id' , 'User.created DESC');
		$options['offset'] = ($paging-1) * $countPage;
		$options['limit'] = $countPage;
		// $options['recursive'] = 1;
		$mysql = $this->User->find('all' ,$options);
		$this->set('myList' , $mysql);
		
		// dpr($mysql); exit;

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
	
	function admin_index_bak($paging = 1)
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
		$this->setTitle('Users');
		// set paging session...
		$countPage = $this->countListPerPage;

		// our list conditions...
		$options['conditions'] = array(
			'User.status' => array(0,1),
			'User.role_id >' => 1
		);
		// find last modified...
		$options['order'] = array('User.modified DESC');
		$lastModified = $this->User->find('first' , $options);
		$this->set('lastModified' , $lastModified);
		// end of last modified...

		$resultTotalList = $this->User->find('count' , $options);
		$this->set('totalList' , $resultTotalList);

		$options['order'] = array('User.role_id' , 'User.created DESC');
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
	 * change user status (active or disabled)
	 * @param integer $id contains id of the user
	 * @return void
	 * @public
	 **/
	function change_status($id=null)
	{
		if ($id != null)
		{
			$this->autoRender = false;

			$data = $this->User->findById($id);

			$data_change = $data['User']['status']==0?1:0;

			$this->User->id = $id;
			$this->User->saveField('status', $data_change);
			header("Location: ".$_SESSION['now']);
			return;
		}
	}

	/**
	* add users(just for participants role or equally to that)
	* @return void
	* @public
	**/
	function admin_add()
	{
		$this->setTitle('Add New User');
		if (!empty($this->data))
		{
			$myCreator = $this->Auth->user();
			$this->data['User']['created_by'] = $myCreator['Account']['user_id'];
			$this->data['User']['modified_by'] = $myCreator['Account']['user_id'];

			$this->User->set($this->data);
			if($this->User->validates())
			{
				$myDetails = $this->data['UserMeta'];
				foreach ($myDetails as $key => $value)
				{
					if($value['key'] == 'email')
					{
						$findUserMeta = $this->UserMeta->find('first' , array(
							'conditions' => array(
								'UserMeta.key' => $value['key'],
								'UserMeta.value' => $value['value']
							)
						));

						if(!empty($findUserMeta))
						{
							$this->Session->setFlash('This user has already existed.','failed');
            				$this->redirect (array('action' => 'add'));
						}
					}
				}

				$this->User->create();
				$this->data['User']['role_id'] = 5; // as participants...
				$this->User->save($this->data);

				$this->data['UserMeta']['user_id'] = $this->User->id;
				foreach ($myDetails as $key => $value)
				{
					// if(empty($value['key']) || empty($value['value']))
					// {
						// continue;
					// }

					$this->data['UserMeta']['key'] = $value['key'];
					$this->data['UserMeta']['value'] = $value['value'];
					$this->UserMeta->create();
					$this->UserMeta->save($this->data);
				}

				$this->Session->setFlash($this->data['User']['firstname'].' '.$this->data['User']['lastname'].' has been created.','success');
				$this->redirect (array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('Please complete all required fields.','failed');
			}
		}
	}

	/**
	 * update user
 	 * @param integer $id contains id of the user
	 * @return void
	 * @public
	 **/
	function admin_edit($id = null)
	{
		$this->setTitle('Edit User');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid user', 'failed');
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data))
		{
			$myCreator = $this->Auth->user();
			$this->data['User']['modified_by'] = $myCreator['Account']['user_id'];

			$this->User->set($this->data);
			if($this->User->validates())
			{
				$myDetails = $this->data['UserMeta'];
				foreach ($myDetails as $key => $value)
				{
					if($value['key'] == 'email')
					{
						$findUserMeta = $this->UserMeta->find('first' , array(
							'conditions' => array(
								'UserMeta.key' => $value['key'],
								'UserMeta.value' => $value['value'],
								'UserMeta.user_id <>' => $id
							)
						));

						if(!empty($findUserMeta))
						{
							$this->Session->setFlash('This user has already existed.','failed');
            				$this->redirect (array('action' => 'edit',$id));
						}
					}
				}

				$this->User->id = $id;
				$this->User->save($this->data);

				// delete first, and then add again...
				$this->UserMeta->deleteAll(array('UserMeta.user_id' => $id));

				$this->data['UserMeta']['user_id'] = $this->User->id;
				foreach ($myDetails as $key => $value)
				{
					// if(empty($value['key']) || empty($value['value']))
					// {
						// continue;
					// }

					$this->data['UserMeta']['key'] = $value['key'];
					$this->data['UserMeta']['value'] = $value['value'];
					$this->UserMeta->create();
					$this->UserMeta->save($this->data);
				}

				$this->Session->setFlash($this->data['User']['firstname'].' '.$this->data['User']['lastname'].' has been updated.','success');
				$this->redirect (array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash('The User could not be saved. Please try again','failed');
				$this->redirect (array('action' => 'edit',$id));
			}
		}
		else
		{
			$this->set('id',$id);
			$result = $this->User->findById($id);
			$this->set('myData' , $result);
		}
	}

	/**
	 * delete user
	 * @param integer $id contains id of the user
	 * @return void
	 * @public
	 **/
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for user', 'failed');
			$this->redirect(array('action'=>'index','admin'=>true));
		}

		$this->User->id = $id;
		$this->User->saveField('status' , -1);
		$this->Account->deleteAll(array('Account.user_id' => $id));

		$this->Session->setFlash('User deleted', 'success');
		$this->redirect(array('action'=>'index','admin'=>true));
	}

	/**
	 * facebook connect
	 * @return void
	 * @public
	 **/
	function fb_connect() {
		$this->autoRender = false;

		if (!empty($this->data)) {
			// check if FB id exist
			$user = $this->UserMeta->find("first", array(
				"conditions" => array(
					"UserMeta.key" => "fb_id",
					"UserMeta.value" => $this->data["fbdata"]["id"]
				)
			));

			// if not exist
			if (empty($user)) {
				// check if user exist by email
				$user = $this->UserMeta->find("first", array(
					"conditions" => array(
						"UserMeta.key" => "email",
						"UserMeta.value" => $this->data["fbdata"]["email"]
					)
				));

				// if not found
				if (empty($user)) {
					// create new user
					$save_user = array();
					$save_user["User"] = array(
						"firstname" => $this->data["fbdata"]["first_name"].(empty($this->data["fbdata"]["middle_name"]) ? "" : " ".$this->data["fbdata"]["middle_name"]),
						"lastname" => $this->data["fbdata"]["last_name"],
						"role_id" => 4,
						"created_by" => 1,
						"modified_by" => 1,
						"status" => 1
					);
					$save_user["UserMeta"] = array(
						array(
							"key" => "email",
							"value" => $this->data["fbdata"]["email"]
						),
						array(
							"key" => "fb_id",
							"value" => $this->data["fbdata"]["id"]
						)
					);
					$this->User->create();
					$this->User->saveAll($save_user);
					$user_id = $this->User->id;
				}
				// if found
				else {
					$user_id = $user["User"]["id"];
					$save_user = array();
					$save_user["UserMeta"] = array(
						"user_id" => $user_id,
						"key" => "fb_id",
						"value" => $this->data["fbdata"]["id"]
					);
					$this->UserMeta->create();
					$this->UserMeta->save($save_user);
				}
			}
			// if already exist
			else
				$user_id = $user["User"]["id"];

			// check if user have account
			$account = $this->Account->findByUserId($user_id);

			// if don't have account
			if (empty($account)) {
				$this->User->create();
				$this->User->id = $user_id;

				// if current role not sufficient
				if ($this->User->field("role_id") > 4)
					$this->User->saveField("role_id", 4);

				srand();
				$random_pass = md5(time().rand(0, 100));
				$save_account = array();
				$save_account["Account"] = array(
					"user_id" => $user_id,
					"email" => $this->data["fbdata"]["email"],
					"password" => Security::hash($random_pass)
				);
				$this->Account->create();
				$this->Account->save($save_account);

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
				$body[] = "Your password is: $random_pass<br />";
				$body[] = "<a href=\"".$this->get_host_name()."login\">Click here to login</a><br />";
				$status = $this->Email->send($body);

				$account_id = $this->Account->id;
			}
			// if have account
			else
				$account_id = $account["Account"]["id"];

			// log in the user
			if (!empty($account_id)) {
				$this->Auth->login($account_id);
				return true;
			}
		}

		return false;
	}

	function subscribe() {
		$this->layout = "front_login_default";
		$this->setTitle("Subscribe");

		if (!empty($this->data)) {
			$this->data["UserMeta"][0] = array(
				"key" => "email",
				"value" => $this->data["Account"]["email"]
			);
			unset($this->data["Account"]);
			$this->data['User']['created_by'] = 1;
			$this->data['User']['modified_by'] = 1;

			$this->User->set($this->data);
			if($this->User->validates())
			{
				$myDetails = $this->data['UserMeta'];
				foreach ($myDetails as $key => $value)
				{
					if($value['key'] == 'email')
					{
						$findUserMeta = $this->UserMeta->find('first' , array(
							'conditions' => array(
								'UserMeta.key' => $value['key'],
								'UserMeta.value' => $value['value']
							)
						));

						if(!empty($findUserMeta))
						{
							$this->Session->setFlash('This user has already existed.','failed');
            				$this->redirect("/subscribe");
						}
					}
				}

				$this->User->create();
				$this->data['User']['role_id'] = 5; // as participants...
				$this->User->save($this->data);

				$this->data['UserMeta']['user_id'] = $this->User->id;
				foreach ($myDetails as $key => $value)
				{
					// if(empty($value['key']) || empty($value['value']))
					// {
						// continue;
					// }

					$this->data['UserMeta']['key'] = $value['key'];
					$this->data['UserMeta']['value'] = $value['value'];
					$this->UserMeta->create();
					$this->UserMeta->save($this->data);
				}

				$this->Session->setFlash($this->data['User']['firstname'].' '.$this->data['User']['lastname'].' has been created.','success');
			}
			else
			{
				$this->Session->setFlash('Please complete all required fields.','failed');
			}
		}
	}

	function twitter($check_status = 0) {
		$this->autoRender = false;

		$settings = $this->Setting->get_settings();
		if (isset($settings["sites"]["twitter_consumer_key"], $settings["sites"]["twitter_consumer_secret"])) {
			App::import("Vendor", "Twitter", array("file" => "twitteroauth" . DS . "twitteroauth.php"));
			$consumer_key = $settings["sites"]["twitter_consumer_key"];
			$consumer_secret = $settings["sites"]["twitter_consumer_secret"];
			if(isset($_SESSION["access_token"])) {
				//berhasil
				$access_token = $_SESSION["access_token"];
				$connection=NULL;
				try {
					$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token["oauth_token"], $access_token["oauth_token_secret"]);
					$users = $connection->get("account/verify_credentials");
				} catch(Exception $e) {
					unset($_SESSION["access_token"]);
				}
				if (!empty($users)) {
					if ($check_status)
						return true;

					// check if TW id exist
					$user = $this->UserMeta->find("first", array(
						"conditions" => array(
							"UserMeta.key" => "tw_id",
							"UserMeta.value" => $users->id
						)
					));
					if (empty($user)) {
						return "<script>window.opener.status_twitter = \"register\"; self.close();</script>";
					}
					else {
						// check if user have account
						$account = $this->Account->findByUserId($user["UserMeta"]["user_id"]);

						if (empty($account)) {
							return "<script>window.opener.status_twitter = \"register\"; self.close();</script>";
						}
						else {
							// log in the user
							$this->Auth->login($account["Account"]["id"]);
							return "<script>window.opener.status_twitter = \"reload\"; self.close();</script>";
						}
					}

				}
				if ($check_status)
					return false;
				return "<script>window.opener.status_twitter = \"error\"; self.close();</script>";
			}
			elseif(isset($_SESSION["oauth_token"])) {
				if ($check_status)
					return false;

				//callback
				if ($_SESSION["oauth_token"] !== $_REQUEST["oauth_token"]) {
					unset($_SESSION["oauth_token"],$_SESSION["oauth_token_secret"]);
					$this->redirect("");
				} else {
					$connection = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION["oauth_token"], $_SESSION["oauth_token_secret"]);
					$access_token = $connection->getAccessToken($_REQUEST["oauth_verifier"]);
					unset($_SESSION["oauth_token"],$_SESSION["oauth_token_secret"]);
					if($connection->http_code==200) {
						$_SESSION["access_token"] = $access_token;
					}
					$this->redirect("");
				}
			}
			else {
				if ($check_status)
					return false;

				//redirect
				$connection = new TwitterOAuth($consumer_key, $consumer_secret);
				$request_token = $connection->getRequestToken();
				if($connection->http_code==200) {
					$_SESSION["oauth_token"] = $token = $request_token["oauth_token"];
					$_SESSION["oauth_token_secret"] = $request_token["oauth_token_secret"];
					$url_go = $connection->getAuthorizeURL($token);
					$this->redirect($url_go);
				} else {
					return "<script>alert(\"Can't connect Twitter\");self.close();</script>";
				}
			}
		}
	}
}
