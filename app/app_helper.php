<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @subpackage    cake.cake
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::import('Helper', 'Helper', false);

/**
 * This is a placeholder class.
 * Create the same file in app/app_helper.php
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake
 */
class AppHelper extends Helper
{
	function get_http()
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

	function get_host_name()
	{
		return $this->get_http().$_SERVER['SERVER_NAME'].$this->get_linkpath();
	}

	function get_slug($value)
	{
		$str = Inflector::slug($value);
		return str_replace('_','-', strtolower($str));
	}

	function get_linkpath()
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
	}
}
