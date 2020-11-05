<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/property.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');

$url = [URL1, URL2, URL3, URL4];
$smarty->assign('url', $url);
$smarty->display('main/index.html');
