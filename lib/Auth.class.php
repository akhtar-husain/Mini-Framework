<?php
namespace App\Auth;
use App\DB as DB, App\Password as Password;

/*
 * @author 	: 	Akhtar Husain <akhtar4660@gmail.com>
 * @package : 	Admin Panel
 * @version : 	1.0
 */

public abstract class Auth
{
	//protected function initialize();
	public function login(){
		$pass = new Password( $this->password );
		$db = new DB();
		$db->where( ['email' => $this->email, 'password' => $this->password] );
		$data = $db->getRow($this->table);
		if( count($res) > 0 && $pass->verifyPassword() ){
			if( $pass->needRehash() ){
				$newHash = $pass->reHashPassword();
				return $newHash;
				$db->where( ['email' => $this->email, 'password' => $this->password] );
				$res = $db->update($this->table,['hash' => $newHash]);
			}

			/************ SET SESSION VARIABLES HERE **************/

			$_SESSEION['logged'] = TRUE;
			$_SESSEION['userid'] = $data->id;
			$_SESSEION['username'] = $data->username ? $data->username : "";

			/****************** END SESSION SETTINGS **************/
		}
	}
	public function logout(){
		unset( $_SESSEION );
		header("Location:".BASEURL."?action=logout");
	}

}