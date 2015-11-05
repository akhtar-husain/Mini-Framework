<?php
namespace App\Models;
use App\System\DB;

/*
 * @author 	: 	Akhtar Husain <akhtar4660@gmail.com>
 * @package : 	Admin Panel
 * @version : 	1.0
 */

final class Options
{
	public $table = "options";
	/**
	* Perform Update Query for User.
	* @return pointer
	*/
	function update($arrField = array())
	{
		if(count($arrField) > 1){
			return FALSE;
		}
		$key = array_keys($arrField);
		$val = $arrField[$key[0]];
		$db = new DB();
		$fieldSet = ['option_value' => $val];
		$db->where( ['option_key' => $key[0]] );
		return $db->update( $this->table, $fieldSet );
	}
	
	/**
	* Perform Inser Query for Option.
	* @return inserted id
	*/

	/*----------- USED FOR FIRST TIME TO CONFIGE OPTION TABLE -----------*/
	function add($arrField = array())
	{
		if(count($arrField) > 1){
			return FALSE;
		}
		$key = array_keys($arrField);
		$val = $arrField[$key[0]];
		$db = new DB();
		$fieldSet = ['option_key' => $key[0], 'option_value' => $val];
		$id = $db->insert( $this->table, $fieldSet );
		$this->id = $id;
		return $id;
	}

	function getOption($key = "")
	{
		if($key != "")
		{
			$db = new DB();
			$db->where(['option_key' => $key]);
			$obj = $db->getRow($this->table, ['option_value']);

			if(is_object($obj))
			{
				return $obj->option_value;
			}
		}
		else
			return FALSE;

	}

	/**
	* Delete user's record.
	* @return pointer
	*/
	function remove($key)
	{
		$db = new DB();

		$db->where( ['option_key' => $key] );
		return $db->delete( $this->table );
	}

}