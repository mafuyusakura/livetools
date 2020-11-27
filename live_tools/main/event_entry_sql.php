<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/property.php');
//ログイン確認
require_once($_SERVER['DOCUMENT_ROOT'] . '/login_check.php');
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');

//※※※※※※※※※登録前処理※※※※※※※※※

$today = date('Y-m-d');
$var = 0;
//入力チェック
if ($_POST['calendar'] <= $today ) {
    $var = ++$var;
    print '明日以降の日付にしてください。<br>';
}
if (empty($_POST['livehouse'])) {
    $var = ++$var;
    print 'ライブハウスが選択されていません。<br>';
}
if (strlen($_POST['eventname']) > 255) {
    $var = ++$var;
    print '文字数が多すぎます。<br>';
}
if (empty($_POST['rentaltime'])) {
    $var = ++$var;
    print 'レンタル時間が選択されていません。<br>';
}
if ($var >= 1) {
    print "<a href='javascript:history.back()'><i class='zmdi zmdi-arrow-left'></i>[戻る]</a>";
    exit;
}

//登録処理
//EVENT_FLG [0]=終了前 [1]=終了後
$EVENT_FLG = '0';

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
        print '登録完了！';
        print "<a href=".$url[2]."><i class='zmdi zmdi-arrow-left'></i>[戻る]</a>";
    } catch (\PDOException $e) {
        $pdo->rollBack();
        print '登録出来ませんでした。<br>再度登録し直してください。';
        print "<a href='javascript:history.back()'><i class='zmdi zmdi-arrow-left'></i>[戻る]</a>";
    }
} catch (\PDOException $th) {
    throw $th;
}
