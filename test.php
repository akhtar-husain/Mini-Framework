<?php
require "lib/config.php";
use App\Upload;
if( isset($_POST['upload']) )
{	
	_print_r($_FILES);
	$config['max_size'] = 1048576;
	$config['max_width'] = 1024;
	$config['max_height'] = 768;

	$upload = new Upload($_FILES['file1'],$config);
	//_print_r($upload);
	echo "File Name: ".$upload->doUpload();
}
?>
<fieldset><legend>Upload file</legend>
	<form method="post" enctype="multipart/form-data">
		<input type="file" name="file1" />
		<input type="submit" name="upload" value="Upload" />
	</form>
</fieldset>