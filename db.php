<?php

session_start();

//db接続
try{
    require_once '../config/property.php';
    $pdo = get_pdo();
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
}catch(PDOException $hoge){
    die('接続エラー:'.$hoge->getMessage());
}
