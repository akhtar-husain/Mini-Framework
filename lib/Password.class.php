<?php

/*
 * @author 	: 	Akhtar Husain <akhtar4660@gmail.com>
 * @package : 	Admin Panel
 * @version : 	1.0
 */

final class Password
{
	public $hash;
	public $password;

	public function __construct( $password = '' ){
		if($password != ''){
			$this->hash = self::hashPassword($password);
		}
		$this->password = $password;
	}

	public final function unique_salt() {
		return substr(sha1(uniqid(mt_rand(), true)), 0, 22);
	}

	public function hashPassword($password){
		$options = ['salt' => self::unique_salt(), 'cost' => 10];
		$hash = password_hash($password, PASSWORD_DEFAULT, $options);
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