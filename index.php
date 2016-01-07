<?php

/*---------- SET YOUR DEFAULT CONTROLLER WHEN NONE IS FOUND.
 *			 PLEASE MAKE IT AVAILABE, OTHERWISE WILL REDIRECTED TO 404 PAGE.
 *---------------*/

const DEFAULT_CONTROLLER = "Default_Controller";



/*---------- SET ERROR DOCUMENT THAT IS USED AS 404 ERROR ---------------*/

const ERROR_DOCUMENT = "404.html";



/*---------- SET ERROR DOCUMENT THAT IS USED AS 404 ERROR
 *			 TRUE => USE TWIG TEMPLATE ENGINE FOR VIEW FILES
 *			 FALSE => USE .php EXTENSION FOR VIEW FILES
 *---------------*/

const USE_TEMPLATE = TRUE; 



/*---------- SET ENCRYPTION KEY THAT WILL BE USED TO ENCRYPT CONFIDENTIAL DATA
 *			 ONCE STARTED THE SYSTEM PLEASE DON'T CHANGE IT.
 *---------------*/

const KEY = 'qwertyuiopASDFGHJKLzxcvbnm!@#$%^&*87654321';



/*---------- SETTINGS WILL BE APPPLIED BASED ON THE ENVIRONMENT
 *			 ENVIRONMENT => development
 *			 OR ENVIRONMENT => production
 * ---------------*/

const ENVIRONMENT = 'development'; // OR production => live



/*---------- SET DB DETAILS ---------------*/

const HOSTNAME = 'DBHOST';
const DBNAME = 'DBNAME';
const USERNAME = 'DBUSER';
const PASSWORD = 'DBPASSWORD';


require_once "app/Bootstrap.php";

$RT = new \App\System\Router();
$RT->parseRoute();
$RT->_redirect();
