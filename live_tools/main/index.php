<?php
$parm = "";
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/property.php');
//ログイン確認
require_once($_SERVER['DOCUMENT_ROOT'] . '/login_check.php');
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');


//ライブ情報取得
//タイムテーブル遷移用URL生成
try {
    $sql1 = "
            select 
                EVENT_ID, EVENT_NAME, EVENT_DATE, EVENT_NAME
            from 
                EVENT_LIST
            where 
                EVENT_FLG = '0' 
            and TT_FLG = '1'
            order by 
                EVENT_DATE
            ";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute();
    $r1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
$cnt = count($r1);
if ($cnt > 0) {
    $img = "<img src='$url[1]/image/led.png' alt='none' width='25px'>";
    print "<div class='title-bar'>".$img."ライブinfo".$img."</div>";
    
    foreach ($r1 as $key => $value) {
        print "<div class='main-list'><a href='".$url[2]."/timetable_view?id=".$value['EVENT_ID']."&parm=".$value['EVENT_DATE']."'>"
        .$value['EVENT_DATE']." ---> ".$value['EVENT_NAME']
        ."</a></div>";
    }
}

print "<hr>";
print "<div class='title-bar'>".$img."メインメニュー".$img."</div>";

//メインページ読み込み
$smarty->display('main/index.html');
