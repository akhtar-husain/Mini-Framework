<?php

/*
 * @author 	: 	Akhtar Husain <akhtar4660@gmail.com>
 * @package : 	Admin Panel
 * @version : 	1.0
 */

final public class AdminUser extends Auth
{
  /////////////////////////////////////////////////
  // PROPERTIES, PUBLIC
  /////////////////////////////////////////////////
  
  public $table = 'admin';
  
  public $id;

  public $username;

  public $password;
  
  public $hash;

  public $email;

  public $display_name;

  public $updated_on;
  
  public $status;

  /**
   * Constructor
   * @return void
   */
	function __construct($var=0)
	{
		if($var>0)
		{
			$db = new DB();
			$obj = $db->getRow( $this->table, '*' );

			if(is_object($obj))
			{
				$this->id = stripslashes($obj->id);
				$this->username = stripslashes($obj->username);
				$this->password = stripslashes($obj->password);
				$this->hash = stripslashes($obj->hash);
				$this->email = stripslashes($obj->email);
				$this->display_name = stripslashes($obj->display_name);
				$this->status = stripslashes($obj->status);
				$this->updated_on = stripslashes($obj->updated_on);
			}
		}

	}
			
	/**
	* Commit DB query.
	* @return pointer
	*/
	function commit()
	{   
		$db = new DB();

		if($this->id>0)
		{ 
			//do update
			$res=self::update();
		}
		else
		{//do insert
			$res=self::add();
		}
		return $res;
	}

	/**
	* Perform Update Query for User.
	* @return pointer
	*/
	function update()
	{
		$db = new DB();
		$pass = new Password( md5($this->password) );

		$fieldSet = ['display_name' => $this->display_name, 'email' => $this->email, 'password' => $pass->password, 'hash' => $pass->hash, 'updated_on' => date('Y-m-d H:i:s')];
		$db->where( ['id'=>$this->id] );
		$res = $db->update( $this->table, $fieldSet );
		return $res;
	}
	
	/**
	* Perform Inser Query for User.
	* @return inserted id
	*/
	function add()
	{
		$db = new DB();
		$pass = new Password( md5($this->password) );

		$fieldSet = ['username' => $this->username, 'email' => $this->email, 'password' => $pass->password, 'hash' => $pass->hash, 'display_name' => $this->display_name, 'updated_on' => date('Y-m-d H:i:s'), 'status'=>'1'];
		$id = $db->insert( $this->table, $fieldSet );
		$this->id = $id;
		return $id;
	}

	/**
	* Delete user's record.
	* @return pointer
	*/
	function remove()
	{
		$db = new DB();

		$db->where( ['id' => $this->id] );
		$res = $db->delete( $this->table );
		return $res;
	}

}