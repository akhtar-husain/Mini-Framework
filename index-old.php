<?php
require_once "app/Config.php";
$exceptPages = ['login','error', 'forget'];

$page = isset($_REQUEST['page']) ? basename($_REQUEST['page'], ".php") : "index";
$title = ($page != "index") ? ucwords($page) : "Admin";

if( ! in_array($page, $exceptPages) ){
    include_once BASEPATH."pages".DS."header.php";
    include_once BASEPATH."pages".DS."sidebar.php";
}
?>
    <!-- Content -->
<?php
if( is_file(BASEPATH."pages".DS.$page.".php") ){
    include_once BASEPATH."pages".DS.$page.".php";
}
else{
    include_once BASEPATH."pages".DS."index.php";
}
?>
    <!-- /Content -->
    <!-- Footer -->
<?php
if( ! in_array($page, $exceptPages) ){
    include_once BASEPATH."pages".DS."footer.php";
}