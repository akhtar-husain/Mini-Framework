<?php
namespace App\System;
use App\System\Image, App\System\Helpers;

class Upload
{	
	public $file;
	public $info;
	public $fileType;
	public $fileTypes;
	public $config;

	public $dir = BASEPATH.'uploads'.DS.'media'.DS; 
	public $thumb1 = BASEPATH."uploads".DS."media".DS."thumb1".DS;
	public $thumb2 = BASEPATH."uploads".DS."media".DS."thumb2".DS;	

	public function __construct($file, $config = array())
	{
		// 1MB = 1048576 KB.
		
		if( !empty($file) ){
			include_once BASEPATH."app".DS."System".DS."Mimes.php";
			$this->file = $file;
			$this->config = $config;

			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			$mime = $fileTypes[$ext];
			$size = isset($file['size']) ? $file['size'] : filesize($file['name']);
			$this->fileTypes = $fileTypes;

			$this->info = array(				
				'bits'   => $size,
				'mime'   => $mime
			);
		
			if( !file_exists( BASEPATH.'uploads' )){
				mkdir( BASEPATH."uploads", 0755);
			}
			$type = explode('/', $this->info['mime']);
			$this->fileType = strtolower($type[0]);
			if( $this->fileType == "image" || $this->fileType == 'video' )
			{
				$info = getimagesize($file['tmp_name']);
				$this->info['width'] = $info[0];
				$this->info['height'] = $info[1];

				if( !file_exists( BASEPATH.'uploads'.DS.'media' )){
					mkdir( BASEPATH.'uploads'.DS.'media'.DS.'thumb1', 0755, true);
					mkdir( BASEPATH.'uploads'.DS.'media'.DS.'thumb2', 0755);				
				}
			}
			else
			{
				if( !file_exists( BASEPATH.'uploads'.DS.'document' )){
					mkdir( BASEPATH.'uploads'.DS.'document', 0755, true);				
				}
				$this->dir = BASEPATH.'uploads'.DS.'document'.DS;
			}
		}
		else{
			exit("Couldn't load the given file ".$file);
		}
	}

	public function doUpload()
	{
		$ext = pathinfo($this->file['name'], PATHINFO_EXTENSION);
		if( $this->info['bits'] > $this->config['max_size'] ){
			return "File size exceeded";
		}

		if( in_array( $this->fileType, ['image', 'audio', 'video'] ) ){
			$fileName = date("Ymd_His")._rand().".".$ext;
			$targetFile = $this->dir.$fileName;

			if( is_array($this->config) )
			{				
				if( $this->fileType == 'image' || $this->fileType == 'video' )
				{
					if( $this->info['width'] > $this->config['max_width'] ){
						return "File width exceeded";
					}
					if( $this->info['height'] > $this->config['max_height'] ){
						return "File height exceeded";
					}
				}
			}

			if( move_uploaded_file($this->file['tmp_name'], $targetFile) ){
				if( $this->fileType == 'image' ){
					$image = new Image( $targetFile );

					$image->load($targetFile);
					$image->resizeToWidth(450);
					$image->save($this->thumb1.$fileName);	

					$image->load($targetFile);
					$image->resizeToWidth(150);
					$image->save($this->thumb2.$fileName);
				}
				return $fileName;
			}
			
		}
		else{
			$fileName = date("Ymd_His")._rand().".".$ext;
			$targetFile = $this->dir.$fileName;
			if( move_uploaded_file($this->file['tmp_name'], $targetFile) ){
				return $fileName;
			}
		}
	}


}