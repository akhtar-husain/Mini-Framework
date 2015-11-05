<?php
namespace App\System;

abstract class Controller
{
	public $twig;
	function __construct(){
		/*-------------- Initialize Twig Template Engine -----------------*/
		Twig_Autoloader::register();
		$loader = new Twig_Loader_Filesystem('Views');
		$twig = new Twig_Environment($loader);
		$twig = new Twig_Environment($loader, (ENVIRONMENT == 'production') ? array('cache' => 'cache') : array() );
	}

	/*-------------- FUNCTION TO LOAD VIEW -----------------*/
	public function loadView($template, $data=array()){
		if( ! is_array($data) ){
			return;
		}

		$template = $this->twig->loadTemplate($template);
		$template->display($data);
	}

	/*-------------- FUNCTION TO LOAD MODEL -----------------*/
	public function loadModel($model){
		if( ! is_array($data) ){
			return;
		}

		$template = $this->twig->loadTemplate($template);
		$template->display($data);
	}
}