<?php
require_once 'smarty/Smarty.class.php';
require_once 'ua.php';

$smarty = new Smarty();
$smarty->template_dir = 'templates/';
$smarty->compile_dir  = 'templates_c/';
$smarty->display('header.html');
$smarty->display('top/login.html');

$smarty->display('footer.html');


