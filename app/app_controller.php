<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
	public $layout='cms_default';
	//customize
	public $active='index';
	public $uses = array('Account','User','UserMeta','Type','TypeMeta','EntryMeta','Entry','Role','Setting');
	public $components = array('Auth','Session','Cookie');

	function _setErrorLayout()
	{
		if ($this->name == 'CakeError')
		{
			$this->layout = 'error';
		}
	}

	/**
	* set variable needThumbBrowser
	* @return void
	**/

	public function __construct( )
	{
		parent::__construct();

		$this->set('needThumbBrowser',false);
	}

	/**
	* set layout title
	* @param string $title get title
	* @return boolean
	**/

	public function setTitle($title=null)
	{
		if($title!=null)
			$this->set('title_for_layout', $title);

		return false;
	}

	/**
	* still unknown
	* @param array $anArray still unknown
	* @return void
	**/

	public function pr($anArray=array())
	{
		echo '<pre>';
		print_r($anArray);
		echo '</pre>';
	}

	/**
	* set title for layout
	* @param string $one title name
	* @param string $two get title
	* @return void
	**/

	public function set( $one, $two = NULL )
	{
		if($one=='title_for_layout')
		{
			$findTitle = $this->Setting->findById(1);
			$two .= ' | '.$findTitle['Setting']['value'];
		}

		parent::set($one,$two);
	}

	/**
	* set all variable before render page
	* @param string $activePage get active page
	* @return void
	**/

	public function beforeRender($activePage='Index')
	{
		$this->_setErrorLayout();

		$this->set('activePage',$activePage);
		$this->set('site',$this->get_host_name());
		$this->set('imagePath',$this->get_linkpath());

		$myAccount = $this->Auth->user();
		$myUser = $this->User->findById($myAccount['Account']['user_id']);
		$this->set('user',$myUser);

		// $user = $this->User->find('first' , array(
			// "order" => array('User.id ASC')
		// ));
		// $this->set('user' , $user);

		// -------------------------------------------------------------------- >>>
		// parent_id = -1 => don't have relationship at all...
		// parent_id = 0 => relationship with itself...
		// parent_id > 0 => is being child from other Type...
		// view all the Type, but not Child !!
		$myTypes = $this->Type->find('all',array(
			'conditions' => array(
				'Type.parent_id' => array(-1,0)
			),
			'order' => array('Type.id')
		));
		$this->set('types',$myTypes);

		// get all the pages...
		// $myPages = $this->Entry->find('all' , array(
			// 'conditions' => array(
				// 'Entry.entry_type' => 'pages'
			// ),
			// 'order' => array('Entry.id')
		// ));
		// $this->set('pages' , $myPages);

		$setting = $this->Setting->find('all' , array(
			'order' => array('Setting.id')
		));
		$this->set('setting' , $setting);

		// get GOOGLE ANALYTICS CODES...
		// $this->Setting->id = 15;
		// $this->set('gac' , $this->Setting->field('value'));
		parent::beforeRender();
	}

	/**
	* set all variable before load page
	* @return void
	**/

	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->userModel = 'Account';
		$this->Auth->fields = array(
			'username' => 'email',
			'password' => 'password'
		);
		$this->Auth->userScope = array('User.status >' => 0);

		$this->Auth->authError= 'Authorized access is required.';

		$this->Auth->loginError='Incorrect username/password combination';
		$this->Auth->autoRedirect = false;
//		$this->Auth->loginRedirect=array('controller'=>'settings','action'=>'index','admin'=>true);
//		$this->Auth->logoutRedirect=array('controller'=>'accounts','action'=>'login','admin'=>false);
		$this->Auth->loginAction=array('controller'=>'accounts','action'=>'login','admin'=>false, "plugin" => false);

		$cookie = $this->Cookie->read('Auth.User');
		$auth_user = $this->Auth->user();

		if (!empty($cookie) && empty($auth_user))
		{
			if (!$this->Auth->login($cookie)) // if relogin failed, and then delete cookie !!
				$this->Cookie->delete("Auth.User");
		}

		// check role if admin or not...
		if(isset($this->params['admin']) and $this->params['admin'] == 1)
		{
			$nowAccount = $this->Auth->user();
			if(!empty($nowAccount))
			{
				$nowUser = $this->User->findById($nowAccount['Account']['user_id']);
				if($nowUser['User']['role_id'] > 3)
				{
					$this->Cookie->delete("Auth.User");
					$this->Session->setFlash('Authorized access is required.','failed');
					$this->redirect($this->Auth->logout());
				}
			}
		}

		// pass to view for checking if user logged in
		$is_logged_in = false;
		$user = $this->Auth->user();
		if (!empty($user)) {
			$is_logged_in = true;
			$this->User->recursive = 0;
			$user = $this->User->findById($user["Account"]["user_id"]);
			$this->set("logged_in_user", $user);
		}
		$this->set("is_logged_in", $is_logged_in);
	}

	/**
	* set variable needThumbBrowser
	* @return void
	**/

	public function showThumbBrowser()
	{
		$this->set('needThumbBrowser',true);
	}

	public function getNowDate()
	{
		$nowDate = getdate();
		return $nowDate['year'].'-'.$nowDate['mon'].'-'.$nowDate['mday'].' '.$nowDate['hours'].':'.$nowDate['minutes'].':'.$nowDate['seconds'];
	}

	public function get_slug($value)
	{
		$str = Inflector::slug($value);
		return str_replace('_','-', strtolower($str));
	}

	public function get_view_dir()
	{
		$str = substr(WWW_ROOT, 0 , strlen(WWW_ROOT)-1); // buang DS trakhir...
		$str = substr($str, 0 , strripos($str, DS)+1); // buang webroot...
		$src = $str.'views';
		return $src;
	}

// ------------------------------------------------------------------------------------------------------------ //
// ----------------------------------- HOST SETTING FUNCTION -------------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------ //
	public function get_http()
	{
		if(!empty($_SERVER['HTTPS']))
		{
			return 'https://';
		}
		else
		{
			return 'http://';
		}
    }

	public function get_host_name()
	{
		return $this->get_http().$_SERVER['SERVER_NAME'].$this->get_linkpath();
	}

	public function get_linkpath()
	{
		// -------------- THIS IS FOR LOCAL HOST ------------------------------------ //
		if(is_numeric(str_replace('.', '', $_SERVER['SERVER_NAME'])))
		{
			$cwd = getcwd();
			$cwd = str_replace(DS, '/', $cwd);
			$pos = strpos($cwd, '/app/webroot');
			$cwd = substr($cwd, 0 , $pos);
			$imagePath = substr($cwd, strrpos($cwd, '/')).'/';
		}
		else // -------------- THIS IS FOR ONLINE HOSTING -------------------------------- //
		{
			$imagePath = '/';
		}
		return $imagePath;

		// $imagePath = $this->Setting->find('first' , array(
			// 'conditions' => array(
				// 'Setting.name' => 'sites',
				// 'Setting.key' => 'path_url'
			// )
		// ));
	}
// ------------------------------------------------------------------------------------------------------------ //
// ----------------------------------- END OF HOST SETTING FUNCTION ------------------------------------------- //
// ------------------------------------------------------------------------------------------------------------ //
}
