<?php
namespace App\System;

class Router
{	
	protected $controller;
	protected $action;
	protected $params;
	protected $route;

	public function __construct(){

		$this->route = isset($_GET['_route']) ? $_GET['_route'] : '';

		self::parseRoute();
		self::_redirect();
	}

	public function parseRoute(){
		$urlArray = array();
	    $urlArray = explode("/", $this->route);
	 
	    $this->controller = $urlArray[0] ? '\\App\Controllers\\' . ucfirst($urlArray[0]) : '\\App\Controllers\\'.DEFAULT_CONTROLLER;
	    array_shift($urlArray);
	    $this->action = $urlArray[0] ? $urlArray[0] : 'index';
	    array_shift($urlArray);
	    $this->params = $urlArray;
	}

	public function _redirect(){
		if( class_exists($this->controller) ){
			$controller = new $this->controller();
			$action = $this->action;
			$controller->$action($this->params);
		}
		else{
			header("Location:" . BASEURL . ERROR_DOCUMENT);
		}				
	}

}