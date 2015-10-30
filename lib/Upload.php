<?php
namespace App;

class Upload
{	
	public $file;
	public $info;
	public $fileType;

	public $dir = BASEPATH.'uploads'.DS.'media'.DS; 
	public $thumb1 = BASEPATH."uploads".DS."media".DS."thumb1".DS;
	public $thumb2 = BASEPATH."uploads".DS."media".DS."thumb2".DS;
	
	public function __construct($file)
	{
		if( !empty($file) && is_file($file) ){
			//echo is_file($file) ? "YES" : "NO";
			$this->file = $file;
			$info = getimagesize($file);

			$this->info = array(
				'width'  => $info[0],
				'height' => $info[1],
				'bits'   => isset($info['bits']) ? $info['bits'] : '',
				'mime'   => isset($info['mime']) ? $info['mime'] : ''
			);
		
			if( !file_exists( BASEPATH.'uploads' )){
				mkdir( BASEPATH."uploads", 0755);
			}
			$this->fileType = strtolower(explode('/', $this->info['mime']));
			if( $this->fileType == "image" )
			{
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
		if( !in_array($ext, $mimes) ){
			exit("Unsupported file type");
		}

		if( in_array( $this->fileType, ['image', 'audio', 'video'] ) ){
			$fileName = time().rand(0,10).".".$ext;
			$targetFile = $this->dir.$fileName;
			if( move_uploaded_file($this->file['tmp_name'], $targetFile) ){
				$image = new Image( $targetFile );

				$image->load($targetPath);
				$image->resizeToWidth(450);
				$image->save($thumb1.$fileName);	

				$image->load($targetPath);
				$image->resizeToWidth(150);
				$image->save($thumb2.$fileName);
			}
			return $fileName;
		}
		else{
			$fileName = time().rand(0,10).".".$ext;
			$targetFile = $this->dir.$fileName;
			if( move_uploaded_file($this->file['tmp_name'], $targetFile) ){
				return $fileName;
			}
		}
	}

}