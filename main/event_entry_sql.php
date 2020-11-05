<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/property.php');

//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/db.php');

//※※※※※※※※※登録処理※※※※※※※※※

//EVENT_FLG [0]=終了前 [1]=終了後
$EVENT_FLG = '0';

//入力チェック
if (!isset($_POST['livehouse'])) {
    print 'ライブハウスが未入力です。<br>';
    if (!isset($_POST['rentaltime'])) {
        print 'レンタル時間が未入力です。<br>';
        ?><a href="javascript:history.back()"><i class="zmdi zmdi-arrow-left"></i>[戻る]</a><?php
        return false;
    }
}else {
    if (!isset($_POST['rentaltime'])) {
        print 'レンタル時間が未入力です。<br>';
        ?><a href="javascript:history.back()"><i class="zmdi zmdi-arrow-left"></i>[戻る]</a><?php
        return false;
    }
}

try {
    $pdo->beginTransaction();
    try {
        $sql = "insert into EVENT_LIST (EVENT_NAME, EVENT_DATE, RENTAL_TIME, HOUSE_NAME, EVENT_FLG, INS_DATE, UPD_DATE)
                values (:EVENT_NAME, :EVENT_DATE, :RENTAL_TIME, :HOUSE_NAME, $EVENT_FLG, NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':EVENT_NAME',$_POST['eventname'],PDO::PARAM_STR);
        $stmt->bindValue(':EVENT_DATE',$_POST['calendar'],PDO::PARAM_STR);
        $stmt->bindValue(':RENTAL_TIME',$_POST['rentaltime'],PDO::PARAM_INT);
        $stmt->bindValue(':HOUSE_NAME',$_POST['livehouse'],PDO::PARAM_STR);
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


