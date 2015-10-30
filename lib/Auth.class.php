<?php
defined("BASEPATH") OR die("File access not allowed");
/*
 * @author 	: 	Akhtar Husain <akhtar4660@gmail.com>
 * @package : 	Admin Panel
 * @version : 	1.0
 */

abstract class Auth
{
	//protected function initialize();	
	public function login(){
		$pass = new Password( $this->password );
		$db = new DB();
		$db->where( ['email' => $this->email, 'username' => $this->username],'AND', "OR" );
		$db->where( ['password' => $this->password],'AND' );
		$data = $db->getRow($this->table);
		//_print_r($data);
		if( count($data) > 0 && $pass->verifyPassword() ){
			if( $n = $pass->needRehash() ){
				$newHash = $pass->reHashPassword();
				$db->where( ['email' => $this->email, 'username' => $this->username],'AND', "OR" );
				$db->where( ['password' => $this->password],'AND' );
				$res = $db->update($this->table,['hash' => $newHash]);
			}

			/************ SET SESSION VARIABLES HERE **************/
			//session_start();
			$_SESSION['logged'] = TRUE;
			$_SESSION['userid'] = $data->id;
			$_SESSION['username'] = $data->username ? $data->username : "";

			/****************** END SESSION SETTINGS **************/
			return $data;
		}
		else{
			return FALSE;
		}
	}
	public function logout(){
		unset( $_SESSEION );
		session_destroy();
		header("Location:".BASEURL."?action=logout");
	}

}