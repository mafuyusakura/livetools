<?php
$parm = "";
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/property.php');
//ログイン確認
require_once($_SERVER['DOCUMENT_ROOT'] . '/login_check.php');
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');

//sql処理
//ライブハウス情報取得
try {
    $sql1 = "select * from EVENT_LIST where EVENT_FLG = '0' order by EVENT_DATE";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute();
    $r1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $sql2 = "select PART from PART order by ID";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute();
    $r2 = $stmt2->fetchAll(PDO::FETCH_COLUMN);

  } catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }

//初期化
$bandname = "";
$js = json_encode($r2);
$row = json_encode(1);
?>

<h1>バンド登録</h1>
<form class="entry-sheet" name="entry-sheet" method="post" action="band_entry_sql.php" onsubmit="return check();" onreset="return prereset();">
    <input type="button" value="+" onclick="addForm()">
    <input type="button" value="-" onclick="dltForm()">
    <input type="submit" value="登録">
    <input type="reset" value="リセット">
	<table id="memberform">
    <tr>
        <td>出演日</td>
        <td colspan="3">
            <select name="eventdate" required>
                <option value="">--選択してください</option>
                <?php foreach ($r1 as $eventday) { ?>
                    <option value="<?php print $eventday['EVENT_ID'] ?>"><?php print $eventday['EVENT_DATE'] ?></option>
				<?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>バンド名</td><td colspan="4"><input type="text" name="bandname" value="<?php print h($bandname) ?>" placeholder="バンド名"></td>
    </tr>
    <tr>
        <td>希望する出演時間</td>
        <td colspan="3">
        <select name="time" required>
            <option value="">--選択してください</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
            <option value="25">25</option>
            <option value="30">30</option>
            <option value="35">35</option>
            <option value="40">40</option>
            <option value="50">50</option>
            <option value="60">60</option>
        </select>
        </td>
    </tr>
    <tr>
        <td>参加人数</td>
        <td colspan="2">
        <select name="num" required>
            <option value="">--選択してください</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        </td>
    </tr>
    <tr>
        <td>メンバー</td>
        <td style="width: 10px;">
            <select name="part_1" id="option_1" required>
                <?php foreach ($r2 as $value) {
                    if ($value === reset($r2)) {
                        ?><option value="">--</option>
                    <?php }else{ ?>
                    <option value="<?php print $value; ?>"><?php print $value; ?></option>
                <?php }} ?>
            </select>
        </td>
        <td colspan="2">
            <input type="text" name="member_1" placeholder="名前">
        </td>
    </tr>
    </table>
    ※メンバーが未定の場合は必要パートを選択して「未定」と入力してください。
</form>

<?php print "<div class='back-button'><a href=$url[2]><i class='zmdi zmdi-arrow-left'></i>[Back]</a></div>"; ?>

<script type="text/javascript">
    var js=JSON.parse('<?php print $js; ?>')
    var row=JSON.parse('<?php print $row; ?>')
</script>
<script text="script/javascript" src="../js/conf.js"></script>
<script text="script/javascript" src="../js/addbox.js"></script>