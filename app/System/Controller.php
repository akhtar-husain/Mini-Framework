<?php
namespace App\System;
use Twig_Autoloader;
abstract class Controller
{
	public $twig;
	function __construct(){
		/*-------------- Initialize Twig Template Engine -----------------*/
		$mail = new \PHPMailer();
		Twig_Autoloader::register();
		$loader = new \Twig_Loader_Filesystem(DIR_VIEW);
		$this->twig = new \Twig_Environment($loader, (ENVIRONMENT == 'production') ? array('cache' => 'cache') : array() );

	}

	/*-------------- FUNCTION TO LOAD VIEW -----------------*/
	public function loadView($template, $data=array()){
		if( ! is_array($data) ){
			return;
		}
		$data['BASEPATH'] = BASEPATH;
		$data['BASEURL'] = BASEURL;

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