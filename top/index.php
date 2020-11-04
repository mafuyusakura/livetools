<?php
require_once '../smarty/Smarty.class.php';
require_once './header.php';

$smarty = new Smarty();
$smarty->template_dir = '../templates/';
$smarty->compile_dir  = '../templates_c/';
$smarty->display('top/login.html');
$smarty->display('top/signup.html');
// $smarty->display('top/reset.html');
$smarty->display('footer.html');

