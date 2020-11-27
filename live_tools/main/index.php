<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/property.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/login_check.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');

//メインページ読み込み
$smarty->display('main/index.html');

