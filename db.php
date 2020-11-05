<?php

session_start();

//db接続
try{
    require_once '../config/property.php';
    $pdo = get_pdo();
}catch(PDOException $hoge){
    die('接続エラー:'.$hoge->getMessage());
}
