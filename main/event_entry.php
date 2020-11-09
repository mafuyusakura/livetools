<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/property.php');
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');

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

<?php print "<a href=".$url[2]."><i class='zmdi zmdi-arrow-left'></i>[キャンセル]</a>"; ?>
