<?php
require "lib/Config.php";
//use App;
use App\DB;
use App\Tables\AdminUser;
use App\Upload;

echo BASEURL."<br/>".BASEPATH;

$db = new DB();

echo "<br>Password: ".$func->generateKey();
?>
<fieldset><legend>Admin</legend>
<?php
$admin = new AdminUser(1);
_print_r($admin);
?>
</fieldset>

<fieldset><legend>Upload</legend>
<?php
//$upload = new Upload('D:\office work\New folder\Mirchi-Murga.webm');
$config['max_size'] = 1048576;
$config['max_width'] = 1024;
$config['max_height'] = 768;

$upload = new Upload('robot.png',);
//_print_r($upload);
$upload->doUpload();
?>
</fieldset>

