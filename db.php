<?php
//db接続
try{
    require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/config/property.php');
    $pdo = get_pdo();
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
}catch(PDOException $hoge){
    die('接続エラー:'.$hoge->getMessage());
}
