<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/property.php');
//ログイン確認
require_once($_SERVER['DOCUMENT_ROOT'] . '/login_check.php');
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');

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
                and EVENT_ID = :EVENT_ID
                and EVENT_DATE = :EVENT_DATE
            ";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindvalue(':EVENT_ID',$_GET['id'],PDO::PARAM_INT);
    $stmt1->bindvalue(':EVENT_DATE',$_GET['parm'],PDO::PARAM_STR);
    $stmt1->execute();
    $r1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    $e_arr = $r1[0];

    $sql2 = "select ID, HOUSE_NAME from HOUSE_INFO ";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute();
    $r2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    // foreach($r2 as $key => $value){
    //     $h_info[] = 
    // }

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

?>
<h1>イベント編集</h1>
<?php
    print "<div style='font-size: 22px; background-color:#80808066;'>".h($e_arr['EVENT_NAME']).'</div>'; ?>
    <form class="edit-sheet-1" name="edit-sheet-1" method="post" action="event_edit_sql.php" onsubmit="return check();" onreset="return prereset();">
        <input type="submit" value="登録">
        <input type="reset" value="リセット">
        <input type="hidden" name="ID" value="<?php print h($e_arr['EVENT_ID']); ?>">
        <table id="memberform" width="100%" border="5">
        <tr>
            <td>開催日</td>
            <td colspan="3">
                <?php print h(date('Y/m/d',strtotime($e_arr['EVENT_DATE']))); ?><br>
                →
                <input type="date" name="calendar" max="9999-12-31">
            </td>
        </tr>
        <tr>
            <td>イベント名</td>
            <td colspan="4">
                <input type="text" name="eventname" placeholder=<?php print h($e_arr['EVENT_NAME']) ?>>
            </td>
        </tr>
        <tr>
            <td>レンタル時間</td>
            <td colspan="3">
                <?php print h($e_arr['RENTAL_TIME']).'時間' ?><br>
                →
                <select name="time">
                    <option value="">--選択してください</option>
                    <option value="4">4</option>
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
        <tr>
            <td>参加バンド上限数</td>
            <td colspan="2">
                <?php 
                // 未設定は0を表示
                $num = $e_arr['BAND_NUM'] == '' ? '0' : $e_arr['BAND_NUM'];
                print h($num).'組' 
                ?><br>
                →
                <select name="num">
                    <option value="">--変更する場合は選択</option>
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
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>ライブハウス</td>
            <td>
                <?php print h($e_arr['HOUSE_NAME']) ?><br>
                →
                <select name=housename>
                    <?php foreach ($r2 as $key => $value) {
                        if ($value === reset($r2)) { ?>
                            <option value="">--変更する場合は選択</option>
                            <option value="<?php print h($value['ID']); ?>"><?php print h($value['HOUSE_NAME']); ?></option>
                        <?php }else{ ?>
                        <option value="<?php print h($value['ID']); ?>"><?php print h($value['HOUSE_NAME']); ?></option>
                    <?php }} ?>
                </select>
            </td>
        </tr>
        </table>
        <div class="attention"> ※変更がある項目のみ修正してください。<br></div><br><br>
    </form>
<?php 
print "<div class='back-button'><a href=$url[2]><i class='zmdi zmdi-arrow-left'></i>[Back]</a></div>";
?>
