<?php
namespace App\Controllers;

use App\Models\AdminUser;
use App\System\Auth;

class Login()
{
	public function login()
	{

		use App\System\Auth;
		if(Auth::isLoggedIn()){
		    header("Location:".BASEURL);
		}
		
		$error = FALSE;
		Kint::dump( $_COOKIE ); //OR d($_POST); to debug.
		if(isset($_POST['sign_in']))
		{
		    
		    if(empty($_POST['username'])){
		        $error['username'] = "Username/Email ID is required.";
		    }
		    if(empty($_POST['password'])){
		        $error['password'] = "Password is required.";
		    }
		    else if( strlen($_POST['password']) < 6 ){
		        $error['password'] = "Password length must be at least 6 characters.";
		    }
		    if($error === FALSE)
		    {
		        $user = new AdminUser();
		        $user->username = $_POST['username'];
		        $user->password = md5($_POST['password']);
		        $res = $user->login();
		        if( (int)$res->id > 0){
		            if(isset($_POST['keep_sign']))
		            {
		                setcookie('username', $_POST['username'], time() + (30*86400), '/');
		                setcookie('password', $_POST['password'], time() + (30*86400), '/');
		                setcookie('keep_sign', TRUE, time() + (30*86400), '/');
		            }
		            else{
		                setcookie('username', '', time() - 3600);
		                setcookie('password', '', time() - 3600);
		                setcookie('keep_sign', '', time() - 3600);
		            }
		            header("Location:".BASEURL);
		        }
		        else{
		            $error = TRUE;
		        }
		    }
		}

		if(isset($_COOKIE['username'])){
		    $username = isset($_COOKIE['username']) ? $_COOKIE['username'] : "";
		}else if(isset($_POST['username'])){
		    $username = isset($_POST['username']) ? $_POST['username'] : "";
		}
		if(isset($_COOKIE['password'])){
		    $password = isset($_COOKIE['password']) ? $_COOKIE['password'] : "";
		}else if(isset($_POST['password'])){
		    $password = isset($_POST['password']) ? $_POST['password'] : "";
		}
		if(isset($_COOKIE['keep_sign'])){
		    $keep = isset($_COOKIE['keep_sign']) ? TRUE : FALSE;
		}else if(isset($_POST['keep_sign'])){
		    $keep = isset($_POST['keep_sign']) ? TRUE : FALSE;;
		}
	}

	/*-------------Login Function Ends ------------*/

	
}