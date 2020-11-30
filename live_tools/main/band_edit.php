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
//ライブ情報取得
?><h1>バンド照会</h1><?php

if (!isset($_POST['date']) === true) {
    try {
        $sql1 = "
                select 
                    t1.EVENT_ID, t1.EVENT_DATE
                from 
                    EVENT_LIST t1 
                join 
                    BAND_INFO t2 
                    on t1.EVENT_ID = t2.EVENT_ID 
                where 
                    t1.EVENT_FLG = '0' 
                    and t2.R_PERSON_ID = :R_PERSON_ID
                    and t2.R_PERSON_NAME = :R_PERSON_NAME
                group by t1.EVENT_DATE
                order by t1.EVENT_DATE
                ";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindValue(':R_PERSON_ID',$_SESSION['ID'],PDO::PARAM_INT);
        $stmt1->bindValue(':R_PERSON_NAME',$_SESSION['USER_NAME'],PDO::PARAM_STR);
        $stmt1->execute();
        $r1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
      } catch (\Exception $e) {
        echo $e->getMessage() . PHP_EOL;
      }
    //開催日 配列化
    $unique = array_column($r1,'EVENT_DATE');
    // $unique = array_unique($unique);
    
    ?>
    <p>出演日</p>
    <form name="aa" method="post" action="">
      <select name="date" id="date" action="">
      <option selected disabled>--選択してください</option>
      <?php $count = '0';
          foreach ($unique as $value) { 
          ?>
          <option value="<?php print $value ?>"><?php print h(date('Y/m/d',strtotime($value))); ?></option>
          <?php 
          $count++;
      } ?>
      </select>
      <input type="submit" value="照会">
    </form>
    <?php

}else {
    try {
        $sql1 = "
                select 
                    t2.ID, t1.EVENT_ID, t2.BAND_NAME
                from 
                    EVENT_LIST t1 
                join 
                    BAND_INFO t2 
                    on t1.EVENT_ID = t2.EVENT_ID 
                where 
                    t1.EVENT_FLG = '0' 
                    and t1.EVENT_DATE = :EVENT_DATE
                    and t2.R_PERSON_ID = :R_PERSON_ID
                    and t2.R_PERSON_NAME = :R_PERSON_NAME
                order by t1.EVENT_DATE
                ";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindValue(':EVENT_DATE',$_POST['date'],PDO::PARAM_STR);
        $stmt1->bindValue(':R_PERSON_ID',$_SESSION['ID'],PDO::PARAM_INT);
        $stmt1->bindValue(':R_PERSON_NAME',$_SESSION['USER_NAME'],PDO::PARAM_STR);
        $stmt1->execute();
        $r1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }

    $b_name = array_column($r1,'BAND_NAME');

    ?>
    <p>バンド名</p>
    <form name="b_name" method="post" action="">
        <select name="b_name" >
        <option  selected disabled>--選択してください</option>
        <?php foreach ($b_name as $value) { ?>
        <option value="<?php print h($value) ?>"><?php print h($value) ?></option>
        <?php } ?>
        </select>
        <input type="submit" value="照会">
    </form>
    <?php
}

if (isset($_POST['b_name']) === true) {
    ?><h1>バンド編集</h1><?php
    try {
        $sql = "
                select 
                    EVENT_ID, EVENT_DATE
                from 
                    EVENT_LIST 
                where 
                    EVENT_FLG = '0' 
                group by EVENT_DATE
                order by EVENT_DATE
                ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $r = array_column($r,'EVENT_DATE');

        $sql1 = "select PART from PART order by ID";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute();
        $r1 = $stmt1->fetchAll(PDO::FETCH_COLUMN);

        $sql2 = "
                select 
                    t2.ID, t1.EVENT_ID, t1.EVENT_DATE, t2.BAND_NAME, t2.APPEARANCE_DATE, t2.APPEARANCE_ORDER, t2.TIME_CONTROL, t2.NUM
                from 
                    EVENT_LIST t1 
                join 
                    BAND_INFO t2 
                    on t1.EVENT_ID = t2.EVENT_ID 
                where 
                    t1.EVENT_FLG = '0' 
                    and t2.BAND_NAME = :BAND_NAME
                    and t2.R_PERSON_ID = :R_PERSON_ID
                    and t2.R_PERSON_NAME = :R_PERSON_NAME
                ";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindValue(':BAND_NAME',$_POST['b_name'],PDO::PARAM_INT);
        $stmt2->bindValue(':R_PERSON_ID',$_SESSION['ID'],PDO::PARAM_INT);
        $stmt2->bindValue(':R_PERSON_NAME',$_SESSION['USER_NAME'],PDO::PARAM_STR);
        $stmt2->execute();
        $r2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $sql3 = "
                select 
                    t2.ID, t1.EVENT_ID, t2.BAND_NAME, t2.APPEARANCE_DATE, t2.APPEARANCE_ORDER, t2.TIME_CONTROL, t2.NUM
                    ,t1.PART_1, t1.MEMBER_1
                    ,t1.PART_2, t1.MEMBER_2
                    ,t1.PART_3, t1.MEMBER_3
                    ,t1.PART_4, t1.MEMBER_4
                    ,t1.PART_5, t1.MEMBER_5
                    ,t1.PART_6, t1.MEMBER_6
                    ,t1.PART_7, t1.MEMBER_7
                    ,t1.PART_8, t1.MEMBER_8
                    ,t1.PART_9, t1.MEMBER_9
                    ,t1.PART_10, t1.MEMBER_10
                    ,t1.PART_11, t1.MEMBER_11
                    ,t1.PART_12, t1.MEMBER_12
                    ,t1.PART_13, t1.MEMBER_13
                    ,t1.PART_14, t1.MEMBER_14
                    ,t1.PART_15, t1.MEMBER_15
                from 
                    MEMBER_LIST t1 
                join 
                    BAND_INFO t2 
                    on t1.ID = t2.ID 
                    and t1.EVENT_ID = t2.EVENT_ID 
                where 
                    t2.BAND_NAME = :BAND_NAME
                    and t2.R_PERSON_ID = :R_PERSON_ID
                    and t2.R_PERSON_NAME = :R_PERSON_NAME
                ";
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->bindValue(':BAND_NAME',$_POST['b_name'],PDO::PARAM_STR);
        $stmt3->bindValue(':R_PERSON_ID',$_SESSION['ID'],PDO::PARAM_INT);
        $stmt3->bindValue(':R_PERSON_NAME',$_SESSION['USER_NAME'],PDO::PARAM_STR);
        $stmt3->execute();
        $r3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }
    $res = count($r3);
    $bandname = "";
    //JSに渡す用
    $js = json_encode($r1);
    for ($p=0; $p < $res; $p++) {
        print "<div style='font-size: 22px; background-color:#80808066;'>".$r2[$p]['BAND_NAME'].'</div>'; ?>
        <form class="edit-sheet-<?php print $p+1; ?>" name="edit-sheet-<?php print $p+1; ?>" method="post" action="band_edit_sql.php" onsubmit="return check();" onreset="return prereset();">
            <input type="button" value="+" onclick="addForm()">
            <input type="button" value="-" onclick="dltForm()">
            <input type="submit" value="登録">
            <input type="reset" value="リセット">
            <input type="hidden" name="ID" value="<?php print $r3[$p]['ID']; ?>">
            <table id="memberform" width="100%" border="5">
            <tr>
                <td>出演日</td>
                <td colspan="3">
                    <?php print date('Y/m/d',strtotime($r3[$p]['APPEARANCE_DATE'])); ?><br>
                    →
                    <select name="eventdate">
                        <option value="">--変更する場合は選択</option>
                        <?php foreach ($r as $unique) { ?>
                            <option value="<?php print $unique; ?>"><?php print h(date('Y/m/d',strtotime($unique))); ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>バンド名</td>
                <td colspan="4">
                    <input type="text" name="bandname" value="<?php print h($bandname) ?>" placeholder=<?php print $r2[0]['BAND_NAME'] ?>>
                </td>
            </tr>
            <tr>
                <td>希望出演時間</td>
                <td colspan="3">
                    <?php print $r2[$p]['TIME_CONTROL'].'分' ?><br>
                    →
                    <select name="time">
                        <option value="">--変更する場合は選択</option>
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
                    <?php print $r2[$p]['NUM'].'人' ?><br>
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
                    </select>
                </td>
            </tr>
            <?php  
                $num = $r2[$p]['NUM']+1;
                for ($i=1; $i < $num; $i++) { ?>
                    <tr>
                        <td>メンバー</td>
                        <td>
                            <?php print $r3[$p]['PART_'.$i] ?><br>
                                →
                            <select name=<?php print "part_".$i." id=option_".$i ?>>
                                <?php foreach ($r1 as $value) {
                                    if ($value === reset($r1)) { ?>
                                        <option value="">--</option>
                                    <?php }else{ ?>
                                    <option value="<?php print $value; ?>"><?php print $value; ?></option>
                                <?php }} ?>
                            </select>
                        </td>
                        <td colspan="2">
                            <input type="text" name="member_<?php print $i ?>" placeholder=<?php print $r3[$p]['MEMBER_'.$i] ?>>
                        </td>
                    </tr>
            <?php } ?>
            </table>
            <div class="attention"> ※変更がある項目のみ修正してください。<br>現状、登録時の人数より減らせません。</div><br><br>
        </form>
    <?php 
    $row = json_encode($num-1);
    }
} 

print "<div class='back-button'><a href=$url[2]><i class='zmdi zmdi-arrow-left'></i>[Back]</a></div>";
?>
<script type="text/javascript">
    var js=JSON.parse('<?php print $js; ?>')
    var row=JSON.parse('<?php print $row; ?>')
</script>
<script text="script/javascript" src="../js/conf.js"></script>
<script text="script/javascript" src="../js/addbox.js"></script>
<script text="script/javascript" src="../js/select.js"></script>
