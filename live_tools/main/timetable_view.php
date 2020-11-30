<?php
$parm = "timetable_view";
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/property.php');
//ログイン確認
require_once($_SERVER['DOCUMENT_ROOT'] . '/login_check.php');
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js" type="text/javascript"></script>
<?php


//ライブ情報取得
try {
    $sql1 = "
            select 
                t1.EVENT_ID, t1.EVENT_DATE, t1.ENTER_TIME, t1.END_TIME, t1.EVENT_NAME, t1.TT_FLG,
                t2.`NO`, t2.`BAND_NAME`, t2.`START_TIME`, t2.`TIME`
            from 
                EVENT_LIST t1
            join 
                timetable t2
             on t1.EVENT_ID = t2.`EVENT_ID`
            where 
                t1.EVENT_FLG = '0' 
            and t1.TT_FLG = '1'
            and t1.EVENT_ID = :EVENT_ID
            and t1.EVENT_DATE = :EVENT_DATE
            ";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindvalue(":EVENT_ID",$_GET["id"],PDO::PARAM_INT);
    $stmt1->bindvalue(":EVENT_DATE",$_GET["parm"],PDO::PARAM_STR);
    $stmt1->execute();
    $r1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

print "<div class='title-bar'>".$r1[0]['EVENT_NAME']."&nbsp&nbsp".date("Y/m/d",strtotime($r1[0]['EVENT_DATE']))."</div>";
?>
<table>
    <tr>
        <td>&nbsp</td>
        <td>&nbsp</td>
        <td>&nbsp</td>
    </tr>
    <tr>
        <td>TT</td>
        <td>分</td>
        <td>バンド名</td>
    </tr>
    <?php
    foreach ($r1 as $key => $value) { ?>
        <tr>
            <td><?php print $value["START_TIME"]; ?></td>
            <td><?php print $value["TIME"]; ?></td>
            <td><?php print $value["BAND_NAME"]; ?></td>
        </tr>
        <?php } ?>
</table>
<br>
<form action="">
<textarea cols="25" rows="4" style="border-color:ghostwhite; width:100%;">備考：</textarea>
</form>

<script type="text/javascript" src="../js/timetable_view.js" ></script>
