<?php
namespace App\System;
/*
 * @author 	: 	Akhtar Husain <akhtar4660@gmail.com>
 * @package : 	Admin Panel
 * @version : 	1.0
 */

final class Password
{
	public $hash;
	public $password;
	public $options;

	public function __construct( $password = '' ){		
		if($password == ''){
			return;
		}
		$this->password = $password;
		$this->options = ['salt' => self::uniqueSalt(), 'cost' => 10];
		if($password != ''){
			$this->hash = self::hashPassword();
		}
	}

	public final function uniqueSalt() {
		return substr(sha1(uniqid(mt_rand(), true)), 0, 22);
	}

	public function hashPassword(){		
		$hash = password_hash($this->password, PASSWORD_DEFAULT, $this->options);
		return $hash;
	}
	public function needRehash(){
		if( password_needs_rehash($this->hash, PASSWORD_DEFAULT, $this->options) ){
			return TRUE;
		}
	}
	public function reHashPassword(){		
		$hash = password_hash($this->password, PASSWORD_DEFAULT, $this->options);
		return $hash;
	}

	public function getInfo(){
		$info = password_get_info($this->hash);
		return $info;
	}

	public function verifyPassword(){
		return password_verify($this->password, $this->hash) ? TRUE : FALSE;
	}
}