<?php
/*
 * @author 	: 	Akhtar Husain <akhtar4660@gmail.com>
 * @package : 	Admin Panel
 * @version : 	1.0
 */
ob_start();
session_start();

const DS = DIRECTORY_SEPARATOR;

if( ENVIRONMENT == 'development' ){
	error_reporting(-1);
	//error_reporting(E_ALL & E_WARNING & E_NOTICE);
}
else{
	error_reporting(0);
}

$basepath = realpath( dirname( dirname(__FILE__) ) );
$httpProt = isset($_SERVER['https']) ? 'https://' : 'http://';
$baseurl = $httpProt.$_SERVER['HTTP_HOST'].substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')). '/';

$basepath = $basepath.DS;
$curPage = basename($_SERVER['SCRIPT_NAME'], '.php');

define( 'BASEPATH', $basepath );
define( 'APP_PATH', BASEPATH . 'app' .DS );
define( 'BASEURL', $baseurl );
define( 'CURRENT_PAGE', $curPage );

const DIR_CONTROLLER = APP_PATH . 'Controllers' . DS;
const DIR_MODEL = APP_PATH . 'Models' . DS;
const DIR_VIEW = APP_PATH . 'Views' . DS;
/** ========== C O N S T A N T   E N D S   H E R E ============ **/

/**
 *
 * ========== I N C L U D E   N E C E S S A R Y   F I L E S ===========
 *
 */
if( file_exists(BASEPATH . 'vendor'.DS.'autoload.php') ){
	//require BASEPATH ."vendor/autoload.php";
	require BASEPATH . 'vendor'.DS.'autoload.php';
}
else{
	exit("Autoload file does not exists. Please try to regenerate autoload file using command `composer dump-autoload`");
}
/** =========== F I L E   L O A D I N G   E N D S   H E R E  =========== **/