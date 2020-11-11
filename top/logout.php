<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/property.php');

session_start();
// ログイン中？（セッションにユーザーIDがある？）
if (array_key_exists("USER_NAME", $_SESSION)) {
    // ログアウト（セッションデータを削除）する
    unset($_SESSION["USER_NAME"]);
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');

$url = [URL1, URL2, URL3, URL4];
$smarty->assign('url', $url);


$top = $url[2];

print "<a href=$top>[ログイン画面へ]</a>";

