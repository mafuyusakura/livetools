<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/property.php');

// ログイン中？（セッションにユーザーIDがある？）
session_start();
if (array_key_exists("USER_NAME", $_SESSION)) {
    // ログアウト（セッションデータを削除）する
    unset($_SESSION["USER_NAME"]);
}

$to_top = $url[1].'/top/';

print "<a href=$to_top>[ログイン画面へ]</a>";
