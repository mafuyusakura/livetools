<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/property.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');

//ログインチェック
session_start();
if (!array_key_exists("USER_NAME", $_SESSION)) {
    $to_top = $url[1].'/top/';
    header("Location: $to_top");
    exit;
}

//メインページ読み込み
$smarty->display('main/index.html');
