<?php
namespace App\System;
/*
 * @author 	: 	Akhtar Husain <akhtar4660@gmail.com>
 * @package : 	Admin Panel
 * @version : 	1.0
 */
class Functions
{	
	static function getUriSegment( $segment = 0 )
	{
		$uri = $_SERVER['REQUEST_URI'];
		$uri = explode('/', $uri);
		return $uri[$segment];
	}

	static function encryptURL($string)
	{
	  $data = base64_encode($string);
	  $data = str_replace(array('+','/','='),array('-','_',':'),$data);
	  return $data;
	}

	static function decryptURL($string)
	{
	  $data = str_replace(array('-','_',':'),array('+','/','='),$string);
	  $mod4 = strlen($data) % 4;
	  if ($mod4) {
	    $data .= substr('====', $mod4);
	  } 
	  return base64_decode($data);
	}

	static function isValidURL($url)
	{
		$regex = "^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$^"; 
		if(preg_match($regex, $url))
		{
			if(strstr($url,'www'))
			{
				$url_str = substr($url,strpos($url, 'www'));
				if( in_array(substr_count($url_str, '.'), array(2,3)) )
				return TRUE;
				else
				return FALSE;
			}
			else
				return TRUE;
		}
		else
			return FALSE;
	}
	/**
	 * Function to escape value.
	 **/

	static function escape($var)
	{
		if( empty($var) )
			return FALSE;

		$var = trim($var);
		$var = strip_tags($var);
		$var = addslashes($var);
		$var = htmlentities($var, ENT_QUOTES);
		return $var;
	}

	/**
	 * Function to get file extension
	 */
	static function getExtension($filename) {
		if($filename){
			$info = pathinfo($filename);
			return strtolower($info['extension']);
		}
		return FALSE;
	}

	/**
	* Function to get file type by given extension.
	**/
	 static function getFileType( $ext ) {
			$ext2type = array(
				'audio'       => array( 'aac', 'ac3',  'aif',  'aiff', 'm3a',  'm4a',   'm4b', 'mka', 'mp1', 'mp2',  'mp3', 'ogg', 'oga', 'ram', 'wav', 'wma' ),
				'video'       => array( 'asf', 'avi',  'divx', 'dv',   'flv',  'm4v',   'mkv', 'mov', 'mp4', 'mpeg', 'mpg', 'mpv', 'ogm', 'ogv', 'qt',  'rm', 'vob', 'wmv' ),
				'document'    => array( 'doc', 'docx', 'docm', 'dotm', 'odt',  'pages', 'pdf', 'rtf', 'wp',  'wpd' ),
				'spreadsheet' => array( 'numbers',     'ods',  'xls',  'xlsx', 'xlsb',  'xlsm' ),
				'interactive' => array( 'key', 'ppt',  'pptx', 'pptm', 'odp',  'swf' ),
				'text'        => array( 'asc', 'csv',  'tsv',  'txt' ),
				'archive'     => array( 'bz2', 'cab',  'dmg',  'gz',   'rar',  'sea',   'sit', 'sqx', 'tar', 'tgz',  'zip' ),
				'code'        => array( 'css', 'htm',  'html', 'php',  'js' ),
			);
			foreach ( $ext2type as $type => $exts )
				if ( in_array( $ext, $exts ) )
					return $type;
		}

	/**
	 * Function to generates a random password drawn from the defined set of characters.
	 **/
	static function generateKey( $length = 12, $special_chars = true, $extra_special_chars = false ) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		if ( $special_chars )
			$chars .= '!@#$%^&*()';
		if ( $extra_special_chars )
			$chars .= '-_ []{}<>~`+=,.;:/?|';

		$password = '';
		for ( $i = 0; $i < $length; $i++ ) {
			$password .= substr($chars, self::_rand(0, strlen($chars) - 1), 1);
		}
		return $password;
	}

	/*
	 * Function to generate a random number.
	 */
	static function _rand( $min = 111111, $max = 999999 ) {
		$rnd_value='';

		if ( strlen($rnd_value) < 8 ) {
			$rnd_value = md5( uniqid(microtime() . mt_rand(), true ) );
			$rnd_value .= sha1($rnd_value);
			$seed = md5($rnd_value);
		}
		// Take the first 8 digits for our value
		$value = substr($rnd_value, 0, 8);
		$rnd_value = substr($rnd_value, 8);
		$value = abs(hexdec($value));

		if ( $max != 0 )
			$value = $min + (($max - $min + 1) * ($value / (4294967295 + 1)));

		return abs(intval($value));
	}

	/**
	 * Function to get values from ($_POST or $_GET methods) otherwise set to empty.
	 */
	static function getVars($vars=array()){
		for($i = 0; $i < count($vars); $i++){
			$var = $vars[$i];
			global $$var;
			if( !isset($$var) ){
				if(empty($_REQUEST[$var]))
					$$var = "";
				else
					$$var = self::escape($_REQUEST[$var]);
			}
		}
	}

	static function showQuery($query, $params)
	{
		$keys = array();
		$values = array();
	  
		# build a regular expression for each parameter

		foreach ($params as $key=>$value)
		{
			if (is_string($key)){
				$keys[] = '/:'.$key.'/';
			}
			else{
				$keys[] = '/[?]/';
			}           
			if(is_numeric($value)){
				$values[] = intval($value);
			}
			else{
				$values[] = '"'.$value .'"';
			}
		}
		$query = preg_replace($keys, $values, $query, 1, $count);
		//echo "DSGFDGFHGJFDGSDDFG";
		print $query;        
	}
}