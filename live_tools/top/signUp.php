<?php

//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');

//パスワードの正規表現
if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
    $hash_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
} else {
    echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
    return false;
}


//※※※※※※※※※登録処理※※※※※※※※※

try {
    $pdo->beginTransaction();
    try {
        $sql = "insert into USER_INFO(USER_NAME,HASH_PASSWORD,INS_DATE,UPD_DATE) 
                values (:USER_NAME,:HASH_PASSWORD,NOW(),NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':USER_NAME',$_POST['username'],PDO::PARAM_STR);
        $stmt->bindValue(':HASH_PASSWORD',$hash_pass,PDO::PARAM_STR);
        $stmt->execute();
        $pdo->commit();
       echo '登録完了！';
       ?><a href="javascript:history.back()"><i class="zmdi zmdi-arrow-left"></i>[戻る]</a><?php
    } catch (\PDOException $e) {
       $pdo->rollBack();
       echo '登録出来ませんでした。<br>再度登録し直してください。';
       ?><a href="javascript:history.back()"><i class="zmdi zmdi-arrow-left"></i>[戻る]</a><?php
     }
} catch (\PDOException $th) {
    throw $th;
}
