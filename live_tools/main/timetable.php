<?php
$parm = "";
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/property.php');
//ログイン確認
require_once($_SERVER['DOCUMENT_ROOT'] . '/login_check.php');
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');
?>
<link rel="stylesheet" href="../css/timetable.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js" type="text/javascript"></script>
<?php
// 権限ありユーザ判定 [1:有,0:無]
$AUTHORITY = 1;
if ($_SESSION['AUTHORITY'] !== $AUTHORITY) {
	print "編集権限がありません。<br>管理者に問い合わせてください。<br>";
	print "<a href=".$url[2]."><i class='zmdi zmdi-arrow-left'></i>[Back]</a>";
	exit;
}

//sql処理
//ライブ情報取得
try {
    $sql1 = "
            select 
                t1.EVENT_ID, t1.EVENT_NAME, t1.EVENT_DATE, t1.BAND_NUM, t1.RENTAL_TIME, t2.HOUSE_NAME, t1.EVENT_FLG
            from 
                EVENT_LIST t1
            join
                HOUSE_INFO t2
                on t1.HOUSE_NAME = t2.ID
            where 
                EVENT_FLG = '0' 
                and t1.EVENT_ID = :EVENT_ID
                and t1.EVENT_DATE = :EVENT_DATE
            ";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindvalue(':EVENT_ID',$_GET['id'],PDO::PARAM_INT);
    $stmt1->bindvalue(':EVENT_DATE',$_GET['parm'],PDO::PARAM_STR);
    $stmt1->execute();
    $r1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $sql2 = "
            select 
                t2.ID, t1.EVENT_DATE, t2.BAND_NAME, t2.APPEARANCE_DATE, t2.APPEARANCE_ORDER, t2.TIME_CONTROL, t2.NUM
            from 
                EVENT_LIST t1 
            join 
                BAND_INFO t2 
                on t1.EVENT_ID = t2.EVENT_ID 
                and t1.EVENT_DATE = t2.APPEARANCE_DATE
            where 
                t1.EVENT_FLG = '0' 
                and t1.EVENT_ID = :EVENT_ID
                and t1.EVENT_DATE = :EVENT_DATE
            ";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindvalue(':EVENT_ID',$_GET['id'],PDO::PARAM_INT);
    $stmt2->bindvalue(':EVENT_DATE',$_GET['parm'],PDO::PARAM_STR);
    $stmt2->execute();
    $r2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}



// ********変数、配列整形********
$e_arr = $r1[0]; //$r1を追加やすいように多元→連想配列に変換
$count = count($r2); // 初期化
$obj = array( '転換', '休憩', '完全撤収',);// インターバル用
$sec = array( "", 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60); //セレクター用時間(5分刻み)
// バンド+希望出演時間 表示用+JSに渡す前処理
$control = array(['TIME_CONTROL' => '--', 'BAND_NAME' => '選択してください']);
foreach ($r2 as $key => $value) {
    $control[] = (['TIME_CONTROL' => $value['TIME_CONTROL'], 'BAND_NAME' => $value['BAND_NAME']]);
}
$js_control = json_encode($control);



?>
<h1>タイムテーブル</h1>
<p class="title-bar"><?php print h(date('Y/m/d',strtotime($e_arr['EVENT_DATE'])))."&nbsp&nbsp".h($e_arr['EVENT_NAME']); ?></p>
<form name="form1" method="post" action="timetable_sql.php">
    <input type="hidden" name="evet_id" value="<?php print h($e_arr['EVENT_ID']) ?>">
    <strong>開始：</strong>
    <input type="time" name="rehst" id="from" oninput="sted()" required>
    <strong>終了:</strong>
    <input type="time" name="rehen" id="end" required>
    <br>
    <strong>レンタル時間：</strong>
    <input type="number" name="rentt" id="to" value="<?php print h($e_arr['RENTAL_TIME']); ?>" min="1" oninput="sted()">
    <br>
    <strong>トータル:</strong>
    <input type="text" name="total" id="total" value="0">
    <br>
    <table border="2" width="100%">
        <thead>
            <tr>
                <th>TT</th>
                <th>出演時間</th>
                <th colspan="2">バンド名</th>
            </tr>
        </thead>
        <tr><th colspan="4">REHEARSAL ※転換込</th></tr>
    <tbody>
        <?php
            $loop = 0; // id連番用
            for ($i=0; $i < $count; $i++) {
            $loop++; // id連番用 ?>
            <tr>
                <input type="hidden" name="id_<?php print $loop; ?>" value="<?php print $loop; ?>">
                <td><input type="time" name="ctltm<?php print $loop; ?>" id="target<?php print $loop; ?>" required></td>
                <td>
                    <select name="ctlsc<?php print $loop; ?>" id="rt_<?php print $loop; ?>" onChange="timetable(this)">
                    <?php foreach ($sec as $value) { ?>
                    <option value="<?php print $value; ?>"><?php print $value; ?></option>
                    <?php } ?>
                    </select>
                </td>
                <td colspan="2">
                    <select name="ctlnm<?php print $loop; ?>">
                    <?php foreach ($r2 as $key => $value) { ?>
                        <option value="<?php print h($value['BAND_NAME']) ?>"><?php print h($value['BAND_NAME']) ?></option>
                    <?php } ?>
                    </select>
                </td>
            <tr>
        <?php } ?>
    </tbody>
    <tbody>
        <?php $loop = $loop + 2; // id連番用 ?>
        <tr>
            <input type="hidden" name="id_<?php print $loop-1; ?>" value="<?php print $loop-1; ?>">
            <td><input type="time" name="ctltm<?php print $loop-1; ?>" id="target<?php print $loop-1; ?>" required></td>
            <td>
                <select name="ctlsc<?php print $loop-1; ?>" id="op_<?php print $loop-1; ?>" onChange="timetable(this)">
                    <?php foreach ($sec as $value) { ?>
                        <option value="<?php print $value; ?>"><?php print $value; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td colspan="2">
                <input type="hidden" name="ctlnm<?php print $loop-1; ?>" value="顔合わせ">
                顔合わせ
            </td>
        </tr>
        <tr>
            <input type="hidden" name="id_<?php print $loop; ?>" value="<?php print $loop; ?>">
            <td><input type="time" name="ctltm<?php print $loop; ?>" id="target<?php print $loop; ?>" required></td>
            <td>
                <select name="ctlsc<?php print $loop; ?>" id="op_<?php print $loop; ?>" onChange="timetable(this)">
                    <?php foreach ($sec as $value) { ?>
                        <option value="<?php print $value; ?>"><?php print $value; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td colspan="2">
                <input type="hidden" name="ctlnm<?php print $loop; ?>" value="OPEN/START">
                OPEN/START
            </td>
        </tr>
    </tbody>
    <tr><td colspan="4"> </td></tr>
    <thead>
        <tr><th>TT</th><th>出演時間</th><th>バンド名</th><th>希望</th></tr>
    </thead>
    <tr><th colspan="4">本番</th></tr>
    <tbody>
        <?php
        $count = $count*2; // バンド+転換表示のために2倍にする
        $loop1 = $loop; // id連番用
        $t = 0; // バンド表示用
        for ($i=0; $i < $count; $i++) {
        $loop1++; // id連番用
            if ($i % 2 == 0) { ?>
                <tr>
                    <input type="hidden" name="id_<?php print $loop1; ?>" value="<?php print $loop1; ?>">
                    <td><input type="time" name="ctltm<?php print $loop1; ?>" id="target<?php print $loop1; ?>" required></td>
                    <td>
                        <select name="ctlsc<?php print $loop1; ?>" id="bt_<?php print $loop1; ?>" onChange="timetable(this)">
                        <?php foreach ($sec as $value) { ?>
                        <option value="<?php print $value; ?>"><?php print $value; ?></option>
                        <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="ctlnm<?php print $loop1; ?>" id="ctl<?php print $loop1; ?>" onChange="select_ctl(this)">
                        <?php foreach ($control as $key => $value) { ?>
                            <option value="<?php print h($value['BAND_NAME']) ?>"><?php print h($value['BAND_NAME']) ?></option>
                        <?php } ?>
                        </select>
                    </td>
                    <td align="right" id="ctlnu<?php print $loop1; ?>">
                        0分
                    </td>
                <tr>
                <?php
                $t++;
            }else{ 
                //転換用 ?>
                <tr>
                    <input type="hidden" name="id_<?php print $loop1; ?>" value="<?php print $loop1; ?>">
                    <td><input type="time" name="ctltm<?php print $loop1; ?>" id="target<?php print $loop1; ?>" required></td>
                    <td>
                        <select name="ctlsc<?php print $loop1; ?>" id="ht_<?php print $loop1; ?>" onChange="timetable(this)">
                            <?php foreach ($sec as $value) { ?>
                                <option value="<?php print $value; ?>"><?php print $value; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td colspan="2">
                        <select name="ctlnm<?php print $loop1; ?>" id="oj_<?php print $loop1; ?>" onChange="endtime(this)">
                            <?php foreach ($obj as $value) { ?>
                                <option value="<?php print $value; ?>"><?php print $value; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
        <?php }
        } ?>
    </tbody>
    </table>
    <br>
    <div class="conf-bottum">
        <input type="submit" value=" 登録 " onClick="return check()">
        <input type="reset" value="リセット" onClick="return prereset()">
    </div>
</form>
<br>
<div class="attention">
    ※入力方法<br>
    ①　開始時間を入力します。<br>
    ②　REHEARSALの「出演時間」と「バンド名」を入力します。<br>
    ③　本番以降の項目は「バンド名」を先に選択。<br>各バンドの希望時間が右欄に表示されます。<br>
    ④　②と同手順。<br>
    ⑤　インターバルの時間を入力します。<br>最終項目のインターバルは「完全撤収」を選択してください。<br>自動的に最終時間が入力されます。<br>
</div>
<?php 
print "<div class='back-button'><a href=$url[2]><i class='zmdi zmdi-arrow-left'></i>[Back]</a></div>";
?>
<script src="../js/conf.js"></script>
<script src="../js/timetable.js"></script>
<script type="text/javascript">
    var control=JSON.parse('<?php print $js_control; ?>')
</script>

</body>
