<?php
require "lib/config.php";
//phpinfo();
echo BASEURL."<br/>".BASEPATH;

$db = new DB();

//$db->where = "WHERE status='1'";
$db->where( ['status'=>'1'], 'OR', 'AND' );
//$db->where( ['id'=>'3'], 'OR', 'AND' );
// $db->limit = '1';
// $db->offset = '0';
//$res = $db->getRow('admin');

$pass = new Password(md5('123456'));
/*$res = $db->update('admin',['password' => $pass->password, 'hash' => $pass->hash, 'updated_on' => date('Y-m-d H:i:s')]);*/

//$db->insert('admin', ['username'=>'akhtar', 'email'=>'abc@xyz.com', 'password'=>$pass->password, 'hash' => $pass->hash, 'updated_on' => date('Y-m-d H:i:s')]);
$res = $db->getCount('admin');
_print_r($res);

$admin = new AdminUser(1); // 1 = ID

/*$admin->password = md5('123456');
$pass = new Password(md5('123456'));
$admin->hash = $pass->hash;
$admin->commit();*/

_print_r($admin);

$pass = new Password($admin->password);
_print_r($pass);

echo $pass->verifyPassword() ? "SUCCESS" : "FAIL";
/*$admin->password = "123456";
$admin->commit();*/