<?php
class ValidationComponent extends Object{
	/**
	 * to validate input field from an entry
	 * @param mixed $variable contains input value want to be checked
	 * @param string $flag contains validation option
	 * @return boolean true, false
	 * @public
	 **/
	function blazeValidate ($variable, $flag)
	{
		if (empty($flag)) return true;
		$flag = strtoupper($flag);
		if($flag == 'NOT_EMPTY')
		{
			if (!empty($variable)) return true;
		}
		else if($flag == 'IS_EMAIL')
		{
			if (preg_match('|^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$|i', $variable)) return true;
		}
		else if(substr($flag, 0 , 10) == 'MIN_LENGTH')
		{
			$temp = explode('_', $flag);
			if (strlen($variable) >= $temp[count($temp)-1]) return true;
		}
		else if(substr($flag, 0 , 10) == 'MAX_LENGTH')
		{
			$temp = explode('_', $flag);
			if (strlen($variable) <= $temp[count($temp)-1]) return true;
		}
		else if($flag == 'IS_NUMERIC')
		{
			if (is_numeric($variable)) return true;
		}
		else
		{
			return false;
		}
	}
}

?>