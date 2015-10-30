<?php
require "lib/Config.php";
//use App;
use App\DB;
use App\Tables\AdminUser;

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

