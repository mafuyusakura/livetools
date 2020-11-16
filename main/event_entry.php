<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/property.php');
//ログイン確認
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/login_check.php');
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');

// 権限ありユーザ判定 [1:有,0:無]
$AUTHORITY = 1;
if ($_SESSION['AUTHORITY'] !== $AUTHORITY) {
    print "編集権限がありません。<br>管理者に問い合わせてください。<br>";
    print "<a href=".$url[2]."><i class='zmdi zmdi-arrow-left'></i>[Back]</a>";
    exit;
}

//sql処理
//ライブハウス情報取得
try {
    $sql = "select * from HOUSE_INFO";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }

//初期化
$eventname = "";

?>

<h1>イベント登録</h1>
<form class="entry-sheet" name="entry-sheet" method="post" action="event_entry_sql.php">
	<table>
    <tr>
        <td>開催日</td><td><input type="date" name="calendar" max="9999-12-31"></td>
    </tr>
    <tr>
        <td>ライブハウス</td>
        <td>
            <select name="livehouse" required>
                <option value="">--選択してください</option>
                <?php foreach ($r as $house) { ?>
                    <option value="<?php print $house['id'] ?>"><?php print $house['HOUSE_NAME'] ?></option>
				<?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>イベント名</td><td><input type="text" name="eventname" value="<?php print h($eventname) ?>" placeholder="イベント名"></td>
    </tr>
    <tr>
        <td>レンタル時間</td>
        <td>
        <select name="rentaltime" required>
            <option value="">--選択してください</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
        </select>
        </td>
    </tr>
    </table>
    <input type="submit" value="登録" onClick="return check();">
    <input type="reset" value="リセット">
</form>

<?php 

//ライブ情報取得
try {
    $sql1 = "
            select 
                EVENT_ID, EVENT_DATE, EVENT_NAME
            from 
                EVENT_LIST 
            where 
                EVENT_FLG = '0' 
            group by 
                EVENT_DATE
            order by 
                EVENT_DATE
            ";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute();
    $r1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
//レコード数取得
$count = count($r1);
//開催日 配列化
$unique = array_column($r1,'EVENT_DATE');
// $unique = array_unique($unique);



//イベント判定
if ($count < 0) {
    print "開催予定がありません。<br>";
    print "<a href=".$url[2]."><i class='zmdi zmdi-arrow-left'></i>[Back]</a>";
    exit;
}
?>

<h1>イベント編集</h1>
開催日<br>
    <?php
    //編集ページ遷移用URL生成
    foreach ($r1 as $key => $value) {
        print "<a href='".$url[2]."/event_edit?id=".$value['EVENT_ID']."&parm=".$value['EVENT_DATE']."'>"
            .$value['EVENT_DATE']." ---> ".$value['EVENT_NAME']
            ."</a><br>";
    }

?>

<h1>タイムテーブル</h1>
開催日<br>
    <?php

    //編集ページ遷移用URL生成
    foreach ($r1 as $key => $value) {
        print "<a href='".$url[2]."/timetable?id=".$value['EVENT_ID']."&parm=".$value['EVENT_DATE']."'>"
            .$value['EVENT_DATE']." ---> ".$value['EVENT_NAME']
            ."</a><br>";
    }

print "<a href=".$url[2]."><i class='zmdi zmdi-arrow-left'></i>[Back]</a>";
