<?php
namespace App\System;
use App\System\DB, App\System\Password;

/*
 * @author 	: 	Akhtar Husain <akhtar4660@gmail.com>
 * @package : 	Admin Panel
 * @version : 	1.0
 */

class Auth
{
	//protected function initialize();
	public function login(){
		$pass = new Password( $this->password );
		$db = new DB();
		$db->where( ['email' => $this->email, 'username' => $this->username],'AND', "OR" );
		$db->where( ['password' => $this->password],'AND' );
		$data = $db->getRow($this->table);
		//_print_r($data);
		if( $data->id > 0 && $pass->verifyPassword() ){
			if( $n = $pass->needRehash() ){
				$newHash = $pass->reHashPassword();
				$db->where( ['email' => $this->email, 'username' => $this->username],'AND', "OR" );
				$db->where( ['password' => $this->password],'AND' );
				$db->update($this->table,['hash' => $newHash]);
			}

			/************ SET SESSION VARIABLES HERE **************/
			//session_start();
			$_SESSION['logged'] = TRUE;
			$_SESSION['userid'] = $data->id;
			$_SESSION['username'] = $data->username;
			$_SESSION['name'] = $data->display_name ? $data->display_name : "";
			/****************** END SESSION SETTINGS **************/
			return $data;
		}
	}
	public static function isLoggedIn(){
		if( isset($_SESSION['logged']) ){
			return $_SESSION['logged'];
		}
	}
	public static function logout(){
		unset( $_SESSEION );
		session_destroy();
		header("Location:".BASEURL);
	}
}