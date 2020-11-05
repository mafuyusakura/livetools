<?php
//smarty定義
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = $_SERVER['DOCUMENT_ROOT'] . '/live_tools/templates/';
$smarty->compile_dir  = $_SERVER['DOCUMENT_ROOT'] . '/live_tools/templates_c/';

define ('URL1', (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST']);
define ('URL2', (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'].'/'.basename(__DIR__));
define ('URL3', (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
define ('URL4', (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
