<?php
/**
 * Routes Configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */

$server = $_SERVER['SERVER_NAME'];
$server = strtolower($server);

$accessMode = 'web';

// the domain contain www, redirect to the corrent one
if (substr($server, 0, 4) == 'www.') {
	$server = substr($server, 4);
}

$controllers = array(
	'accounts',
	'entries',
	'entry_metas',
	'pages',
	'roles',
	'settings',
	'type_metas',
	'types',
	'user_metas',
	'users',
	'admin',
);

$url_set = explode('/', strtolower($_SERVER['REQUEST_URI']));

// -------------- THIS IS FOR LOCAL HOST ------------------------------------ //
if(is_numeric(str_replace('.', '', $_SERVER['SERVER_NAME'])))
{
	$controller = !empty($url_set[2]) ? $url_set[2] : null;
	$action     = !empty($url_set[3]) ? $url_set[3] : null;
}
else // -------------- THIS IS FOR ONLINE HOSTING -------------------------------- //
{
	$controller = !empty($url_set[1]) ? $url_set[1] : null;
	$action     = !empty($url_set[2]) ? $url_set[2] : null;
}

$domainSet = explode('.', $server);

// START CUSTOM //
Router::connect('/ajax_send_organization', array('controller' => 'entries', 'action' => 'ajax_send_organization'));
// END CUSTOM //

// ---------------------------- admin routing ---------------------------------------------- //
Router::connect('/admin', array('controller' => 'accounts', 'action' => 'redirect_login'));
Router::connect('/admin/login', array('controller' => 'accounts', 'action' => 'login'));
Router::connect('/admin/logout', array('controller' => 'accounts', 'action' => 'logout'));
Router::connect('/admin/forget', array('controller' => 'accounts', 'action' => 'forget'));
Router::connect('/admin/reset_password', array('controller' => 'accounts', 'action' => 'reset_password'));

// special pages, comment some of this part if you'd like to create your own custom pages
Router::connect('/login', array('controller' => 'accounts', 'action' => 'login'));
Router::connect('/forget', array('controller' => 'accounts', 'action' => 'forget'));
Router::connect('/register', array('controller' => 'accounts', 'action' => 'register'));
// end of special pages

Router::connect('/subscribe', array('controller' => 'users', 'action' => 'subscribe'));
Router::connect('/reset_password', array('controller' => 'accounts', 'action' => 'reset_password'));
Router::connect('/logout', array('controller' => 'accounts', 'action' => 'logout'));
Router::connect('/activate', array('controller' => 'accounts', 'action' => 'activate'));

// twitter callback
Router::connect('/twitter/*', array('controller' => 'users', 'action' => 'twitter'));

// go to master ...
Router::connect('/admin/master/types/*', array('controller' => 'types', 'action' => 'master' , 'admin'=>true));
Router::connect('/admin/master/settings/*', array('controller' => 'settings', 'action' => 'master' , 'admin'=>true));
Router::connect('/admin/master/roles/*', array('controller' => 'roles', 'action' => 'master' , 'admin'=>true));

// go to parent entries...
Router::connect('/admin/entries/:type', array('controller' => 'entries', 'action' => 'index' , 'admin'=>true));
Router::connect('/admin/entries/:type/index/:page', array('controller' => 'entries', 'action' => 'index' , 'admin'=>true));
Router::connect('/admin/entries/:type/add', array('controller' => 'entries', 'action' => 'index_add' , 'admin'=>true));
Router::connect('/admin/entries/:type/edit/:entry', array('controller' => 'entries', 'action' => 'index_edit' , 'admin'=>true));

// go to children entries...
Router::connect('/admin/entries/:type/:entry', array('controller' => 'entries', 'action' => 'index' , 'admin'=>true));
Router::connect('/admin/entries/:type/:entry/index/:page', array('controller' => 'entries', 'action' => 'index' , 'admin'=>true));
Router::connect('/admin/entries/:type/:entry/add', array('controller' => 'entries', 'action' => 'index_add' , 'admin'=>true));
Router::connect('/admin/entries/:type/:entry_parent/edit/:entry', array('controller' => 'entries', 'action' => 'index_edit' , 'admin'=>true));

if(!in_array($controller, $controllers))
{
	Router::connect('/*', array('controller' => 'entries', 'action' => 'index'));
}