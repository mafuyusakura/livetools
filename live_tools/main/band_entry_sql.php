<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/property.php');
//ログイン確認
require_once($_SERVER['DOCUMENT_ROOT'] . '/login_check.php');
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');

//※※※※※※※※※登録前処理※※※※※※※※※

//sql処理
//ライブハウス情報取得
try {
    $sql1 = "SELECT * from EVENT_LIST where EVENT_ID = :EVENT_ID";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindValue(':EVENT_ID',$_POST['eventdate'],PDO::PARAM_INT);
    $stmt1->execute();
	$res1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
	
	$sql2 = "SELECT COALESCE(MAX(`ID`)+1,1) AS `ID` FROM `BAND_INFO`";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute();
	$res2 = $stmt2->fetch(PDO::FETCH_ASSOC);

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }

//※※※※※※※※※変数整形※※※※※※※※※

$var = 0; // 入力チェック初期化
$count = (count($_POST)-4)/2; // 主要素[4]個 メンバー要素[2]個ずつ
$num = $_POST['num'];
$EVENT_ID = $res1[0]['EVENT_ID'];
$EVENT_NAME = $res1[0]['EVENT_NAME'];
$EVENT_DATE = $res1[0]['EVENT_DATE'];
$NEW_ID = $res2['ID']; //最新ID+1取得

$num_1 = $_POST['num']+1;
$list = array('part_', 'member_');


//入力チェック
if ($count != $num ) {
    $var = ++$var;
	print 'メンバー数と参加人数が一致しません。<br>';
}
if (empty($_POST['eventdate'])) {
    $var = ++$var;
    print '出演日が未入力です。<br>';
}
if (empty($_POST['bandname'])) {
    $var = ++$var;
    print 'バンド名が未入力です。<br>';
}
if (empty($_POST['time'])) {
    $var = ++$var;
    print '出演時間が未入力です。<br>';
}
if (empty($_POST['time'])) {
    $var = ++$var;
    print '参加人数が未入力です。<br>';
}
for ($i=1; $i < $num_1; $i++) { 
	if (empty($list[0].$i) || empty($list[1].$i)) {
    	$var = ++$var;
    	print 'メンバーが未入力です。<br>';
	}
}
if ($var >= 1) {
    print "<a href='javascript:history.back()'><i class='zmdi zmdi-arrow-left'></i>[戻る]</a>";
    exit;
}


//insert文整形
$ins1 = 'INSERT INTO MEMBER_LIST (ID, EVENT_ID, BAND_NAME, ';
$ins2 = '';
$ins3 = 'INS_DATE, UPD_DATE) VALUES ('.$NEW_ID.', '.$EVENT_ID.', :BAND_NAME, ';
$ins4 = '';
$ins5 = 'NOW(), NOW())';
for ($i=1; $i < $num_1; $i++) { 
	$ins2 .= $list[0].$i.', '.$list[1].$i.', ';
}
for ($i=1; $i < $num_1; $i++) { 
	$ins4 .= ':'.$list[0].$i.', :'.$list[1].$i.', ';
}


//登録処理
try {
    $pdo->beginTransaction();
    try {
        $sql1 = "insert into BAND_INFO (ID, EVENT_ID, BAND_NAME, APPEARANCE_DATE, TIME_CONTROL, NUM, R_PERSON_ID, R_PERSON_NAME, INS_DATE, UPD_DATE)
                values ('$NEW_ID', '$EVENT_ID', :BAND_NAME, '$EVENT_DATE', :TIME_CONTROL, :NUM, :R_PERSON_ID, :R_PERSON_NAME, NOW(), NOW())";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindValue(':BAND_NAME',$_POST['bandname'],PDO::PARAM_STR);
        $stmt1->bindValue(':TIME_CONTROL',$_POST['time'],PDO::PARAM_STR);
        $stmt1->bindValue(':R_PERSON_ID',$_SESSION['ID'],PDO::PARAM_INT);
        $stmt1->bindValue(':NUM',$_POST['num'],PDO::PARAM_INT);
		$stmt1->bindValue(':R_PERSON_NAME',$_SESSION['USER_NAME'],PDO::PARAM_STR);
        $stmt1->execute();

		$sql2 = $ins1.$ins2.$ins3.$ins4.$ins5;
        $stmt2 = $pdo->prepare($sql2);
		$stmt2->bindValue(':BAND_NAME',$_POST['bandname'],PDO::PARAM_STR);
		for ($i=1; $i < $num_1; $i++) {
			$t = $_POST[$list[0].$i];
			$y = $_POST[$list[1].$i];
			$g = $list[0].$i;
			$h = $list[1].$i;
			$stmt2->bindValue(':'.$g,$t,PDO::PARAM_STR);
			$stmt2->bindValue(':'.$h,$y,PDO::PARAM_STR);
		}
		$stmt2->execute();

		$pdo->commit();
        print '登録完了！';
        print "<a href=".$url[2]."><i class='zmdi zmdi-arrow-left'></i>[戻る]</a>";
    } catch (\PDOException $e) {
        $pdo->rollBack();
		print '登録出来ませんでした。<br>再度登録し直してください。';
		print $e;
        print "<a href='javascript:history.back()'><i class='zmdi zmdi-arrow-left'></i>[戻る]</a>";
    }
} catch (\PDOException $th) {
    throw $th;
}

