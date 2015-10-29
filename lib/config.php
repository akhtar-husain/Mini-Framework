<?php

/*
 * @author 	: 	Akhtar Husain <akhtar4660@gmail.com>
 * @package : 	Admin Panel
 * @version : 	1.0
 */

ob_start();
session_start();

if (version_compare(phpversion(), '5.4.0', '<') == true) {
	exit('PHP 5.4+ Required');
}

const HOSTNAME = 'localhost';
const DBNAME = 'YourDBName';
const USERNAME = 'YourUserName';
const PASSWORD = 'YourPassword';

const DS = DIRECTORY_SEPARATOR;
const ENVIRONMENT = 'development'; // OR production => live

if( ENVIRONMENT == 'development' ){
	error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
}
else{
	error_reporting(0);
}

$basepath = realpath( dirname( dirname(__FILE__) ) );
$httpProt = isset($_SERVER['https']) ? 'https://' : 'http://';
$baseurl = $httpProt.$_SERVER['HTTP_HOST'].str_replace(DS, '/', strrchr($basepath, DS)).'/';

$basepath = $basepath.DS;
$curPage = basename($_SERVER['SCRIPT_NAME'], '.php');

define( 'BASEPATH', $basepath );
define( 'BASEURL', $baseurl );
define( 'CURRENT_PAGE', $curPage );

/** ========== C O N S T A N T   E N D S   H E R E ============ **/

/**
 *
 * ========== I N C L U D E   N E C E S S A R Y   F I L E S ===========
 *
 */
if( file_exists(BASEPATH . 'vendor') ){
	require_once BASEPATH ."vendor/autoload.php";
}
else{
	spl_autoload_register( function ($class) {
	    if( file_exists(BASEPATH . 'lib' . DS . $class . '.class.php') ){    	
	    	require_once BASEPATH . 'lib' . DS . $class . '.class.php';
	    }
	} );
	/*
	 * L O A D I N G   T A B L E   F I L E S 
	 */
	spl_autoload_register( function ($class) {
	    if( file_exists(BASEPATH . 'lib' . DS . 'tables' . DS . $class . '.class.php') ){    	
	    	require_once BASEPATH . 'lib' . DS . 'tables' . DS . $class . '.class.php';
	    }
	} );
	require_once BASEPATH . "lib" . DS . "functions.php";
}

/** =========== F I L E   L O A D I N G   E N D S   H E R E  =========== **/