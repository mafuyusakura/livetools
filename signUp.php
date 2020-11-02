<?php

//db接続
try{
    require_once './config/property.php';
    $pdo = get_pdo();
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
}catch(\PDOException $e){
    die('接続エラー:'.$e->getMessage());
}

//パスワードの正規表現
if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
    $hash_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
} else {
    echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
    return false;
}

//パスワードの暗号化
//$hash_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

//登録処理
try {
    $pdo->beginTransaction();
    try {
        $sql = "insert into USER_INFO(USER_NAME,HASH_PASSWORD) values (:USER_NAME,:HASH_PASSWORD)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':USER_NAME',$_POST['username'],PDO::PARAM_STR);
        $stmt->bindValue(':HASH_PASSWORD',$hash_pass,PDO::PARAM_STR);
        $stmt->execute();
        $pdo->commit();
       echo '登録完了！';
       ?><a href="javascript:history.back()"><i class="zmdi zmdi-arrow-left"></i>[戻る]</a><?php
    } catch (\PDOException $e) {
       $pdo->rollBack();
       echo '登録済みのメールアドレスです。';
       ?><a href="javascript:history.back()"><i class="zmdi zmdi-arrow-left"></i>[戻る]</a><?php
     }
} catch (\PDOException $th) {
    throw $th;
}
    