<?php

//ログインチェック
session_start();
if (!array_key_exists("USER_NAME", $_SESSION)) {
    $to_top = $url[1].'/top/';
    header("Location: $to_top");
    exit;
}