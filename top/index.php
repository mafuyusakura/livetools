<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/property.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/top/header.php');
$smarty->display('top/login.html');
$smarty->display('top/signup.html');
// $smarty->display('top/reset.html');
$smarty->display('footer.html');

