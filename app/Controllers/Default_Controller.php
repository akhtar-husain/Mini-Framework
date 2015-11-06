<?php
namespace App\Controllers;

use App\System\Controller;

class Default_Controller extends Controller
{
	function __construct(){
		parent::__construct();
	}

	public function index(){
		if( \App\System\Auth::isLoggedIn() ){
			$this->loadView("index.tpl", ['title'=>'Admin']);
		}
		else{
			$this->loadView("login.tpl", ['title'=>'Login']);
		}
	}
}