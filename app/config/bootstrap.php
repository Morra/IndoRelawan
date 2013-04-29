<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
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
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array(/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Debug print_r with <pre></pre>
 * ex: dpr(var1[,var1,...]);
 */
function dpr() {
	$n = func_num_args();
	echo "<pre>";
	for ($i = 0; $i < $n; $i ++) {
		echo "dpr".($i + 1).":\n";
		print_r(func_get_arg($i));
		echo "\n";
	}
	echo "</pre>";
}

/**
 * Debug var_dump with <pre></pre>
 * ex: mpr(var1[,var1,...]);
 */
function mpr() {
	$n = func_num_args();
	echo "<pre>";
	for($i = 0; $i < $n; $i ++) {
		echo "mpr".($i + 1).":\n";
		var_dump(func_get_arg($i));
		echo "\n";
	}
	echo "</pre>";
}

/**
	* convert formated string to display string
	* @param string $str contains string want to be converted
	* @return string $result contains string that can be published
	* @public
	**/
function string_unslug($str)
{
	$temp = explode('_', $str);
	foreach ($temp as $key => $value)
	{
		$temp[$key] = strtoupper(substr($temp[$key], 0 , 1)).substr($temp[$key], 1);
	}
	$result = implode(' ' , $temp);
	return $result;
}

/**
	* convert date text to selected date format from template settings
	* @param date $value contains source date
	* @param string $date contains date format selected
 	* @param string $time contains time format selected
	* @return string new date format
	* @public
	**/
function date_converter($value , $date , $time)
{
	$value = strtotime($value);
	$newDate = date($date , $value);
	$newTime = date($time , $value);
	return $newDate.' @ '.$newTime;
}

/**
	* retrieve certain value attribute of selected input validation
	* @param string $str contains source of validation value, separated by "|"
	* @param string $value contains selected validation
	* @return string $result contain attribute of selected validation
	* @public
	**/
function get_input_attrib($src , $value)
{
	$temp = stripos($src, $value);
	if($temp === FALSE)
	{
		$result = "";
	}
	else
	{
		$src = substr($src, $temp); //  ???|??|MIN_LENGTH_5|???|??  => MIN_LENGTH_5|???|???
		$pos = strpos($src, '|');
		$src = ($pos === FALSE?$src:substr($src, 0 , $pos));
		$result = substr($src, strrpos($src, '_')+1);
	}
	return $result;
}

/**
	* convert formated language to display language
	* @param string $str contains source language want to be converted
	* @return string $result contains language that can be published
	* @public
	**/
function lang_unslug($str)
{
	$temp = explode('_', $str);
	$result = strtoupper($temp[0]).' - '. strtoupper(substr($temp[1], 0 , 1)).substr($temp[1], 1);
	return $result;
}

/**
	* retrieve list of language option used in settings form
	* @param array $src contains group of used language in settings
	* @return array $langlist contains array of language that will be displayed as language option
	* @public
	**/
function get_list_lang($src = array())
{
	$langlist[] = 'en_english';
	$langlist[] = 'id_indonesia';
	$langlist[] = 'fr_france';

	$existlang = explode(chr(13).chr(10), $src);
	foreach ($existlang as $key => $value)
	{
		$state = 0;
		foreach ($langlist as $key10 => $value10)
		{
			if($value == $value10)
			{
				$state = 1;
				break;
			}
		}
		if($state == 0)
		{
			$langlist[] = $value;
		}
	}
	return $langlist;
}

function parse_lang($src = array())
{
	$temp = explode(chr(13).chr(10), $src);
	foreach ($temp as $key => $value)
	{
		$result[] = strtoupper(substr($value, 0,2))." - ".strtoupper(substr($value, 3,1)).substr($value, 4);
	}
	return $result;
}

function convert_input($input)
{
	switch ($input)
	{
		case 'text':
			$input = 'textfield';
			break;
		case 'dropdown':
			$input = 'pulldown';
			break;
		case 'ckeditor':
			$input = 'WYSIWYG Editor';
			break;
		case 'radio':
			$input = 'Radio Button';
			break;
		default:
			break;
	}
	$result = strtoupper(substr($input, 0,1)).substr($input, 1);
	return $result;
}