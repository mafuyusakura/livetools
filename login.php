<?php

//db接続
try{
    require_once 'config/property.php';
    $pdo = get_pdo();
}catch(PDOException $hoge){
    die('接続エラー:'.$hoge->getMessage());
}

//sql処理
$search_name = $_POST['username'];
$search_pass = $_POST['password'];
try{
    $pdo->beginTransaction();
    $sql = "select * from USER_INFO where USER_NAME = :search_name and HASH_PASSWORD = :search_pass";
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':search_name',$search_name,PDO::PARAM_STR);
    $stmh->bindValue(':search_pass',$search_pass,PDO::PARAM_STR);
    $stmh->execute();
    $count = $stmh->rowcount();
}catch(PDOException $Exception){
    print 'エラー：'.$Exception->getMessage();
}

//ログイン処理
if ($count < 1) {
    print 'ユーザー名/パスワードが違います。<br>';
    ?><a href="javascript:history.back()"><i class="zmdi zmdi-arrow-left"></i>[戻る]</a><?php
}else {
    $uname = $_POST['username'];
    $pword = $_POST['password'];
    //$db_date["username"] = "user";
    $result = $stmh->fetch(PDO::FETCH_ASSOC);
    if ($uname == $result['username'] && $pword == $result['password']) {
        require "../redirect.php";
    }else{
        print "ログイン出来ませんでした<br>";
    }
}


