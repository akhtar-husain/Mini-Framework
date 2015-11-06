<?php

/*---------- SET YOUR DEFAULT CONTROLLER WHEN NONE IS FOUND.
 *			 PLEASE MAKE IT AVAILABE, OTHERWISE WILL REDIRECTED TO 404 PAGE.
 *---------------*/

const DEFAULT_CONTROLLER = "Default_Controller";

/*---------- SET ERROR DOCUMENT THAT IS USED AS 404 ERROR ---------------*/

const ERROR_DOCUMENT = "404.html";


/*---------- SET ENCRYPTION KEY THAT WILL BE USED TO ENCRYPT CONFIDENTIAL DATA
 *			 ONCE STARTED THE SYSTEM PLEASE DON'T CHANGE IT.
 *---------------*/

const KEY = 'qwertyuiopASDFGHJKLzxcvbnm!@#$%^&*87654321';


/*---------- SETTINGS WILL BE APPPLIED BASED ON THE ENVIRONMENT ---------------*/

const ENVIRONMENT = 'development'; // OR production => live

/*---------- SET DB DETAILS ---------------*/

const HOSTNAME = 'localhost';
const DBNAME = 'admin_panel';
const USERNAME = 'root';
const PASSWORD = '';


require_once "app/Bootstrap.php";

$RT = new \App\System\Router();
$RT->parseRoute();
$RT->_redirect();