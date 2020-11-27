<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/property.php');
//ログイン確認
require_once($_SERVER['DOCUMENT_ROOT'] . '/login_check.php');
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');

// 初期化
$count = '1';
$upd_arr = [];
$upd_set = '';
$t = false;
// MEMBER_LIST UPDATE文整形
foreach ($_POST as $key => $value) {
	if (strpos($key,'part') !== false) {
		$count++;
	}
}
for ($i=1; $i < $count; $i++) { 
	if(empty($_POST['part_'.$i]) === false){
		$p1 = "part_".$i;
		$p2 = $_POST['part_'.$i];
        $upd_arr[$p1] = $p2;
        $t = true;
	}
	if(empty($_POST['member_'.$i]) === false){
		$m1 = "member_".$i;
		$m2 = $_POST['member_'.$i];
		$upd_arr[$m1] = $m2;
        $t = true;
	}
}
foreach ($upd_arr as $key => $value) {
	$upd_set .= $key." = '".$value."' ";
	if ($value !== end($upd_arr)) {
		$upd_set .= ", ";
	}
}
// MEMBER_LIST UPDATE文結合
$upd1 = "UPDATE MEMBER_LIST SET ";
$upd1 .= $upd_set;
$upd1 .= ", UPD_DATE = NOW() WHERE ID = :ID";
try {
	$pdo->beginTransaction();
	try {
		// band_info UPDATE文
		if (empty($_POST['eventdate']) === false) {
            // EVENT_ID取得
            $sql = "SELECT EVENT_ID FROM EVENT_LIST WHERE EVENT_DATE = :EVENT_DATE";
            $stmt = $pdo->prepare($sql);
			$stmt->bindParam(':EVENT_DATE',$_POST['eventdate'],PDO::PARAM_STR);
            $stmt->execute();
            $r = $stmt->fetch(PDO::FETCH_NUM);
            // 本処理
			$sql1 = "UPDATE BAND_INFO SET EVENT_DATE = :EVENT_DATE, APPEARANCE_DATE = :EVENT_DATE, EVENT_ID = '$r[0]', UPD_DATE = NOW() WHERE ID = :ID ";
			$stmt1 = $pdo->prepare($sql1);
			$stmt1->bindParam(':EVENT_DATE',$_POST['eventdate'],PDO::PARAM_STR);
			$stmt1->bindValue(':ID',$_POST['ID'],PDO::PARAM_INT);
			$stmt1->execute();
		}
		if (empty($_POST['bandname']) === false) {
			$sql1 = "UPDATE BAND_INFO SET BAND_NAME = :BAND_NAME, UPD_DATE = NOW() WHERE ID = :ID ";
			$stmt1 = $pdo->prepare($sql1);
			$stmt1->bindValue(':BAND_NAME',$_POST['bandname'],PDO::PARAM_STR);
			$stmt1->bindValue(':ID',$_POST['ID'],PDO::PARAM_INT);
			$stmt1->execute();
		}
		if (empty($_POST['time']) === false) {
			$sql1 = "UPDATE BAND_INFO SET TIME_CONTROL = :TIME_CONTROL, UPD_DATE = NOW() WHERE ID = :ID ";
			$stmt1 = $pdo->prepare($sql1);
			$stmt1->bindValue(':TIME_CONTROL',$_POST['time'],PDO::PARAM_STR);
			$stmt1->bindValue(':ID',$_POST['ID'],PDO::PARAM_INT);
			$stmt1->execute();
		}
		if (empty($_POST['num']) === false) {
			$sql1 = "UPDATE BAND_INFO SET NUM = :NUM, UPD_DATE = NOW() WHERE ID = :ID ";
			$stmt1 = $pdo->prepare($sql1);
			$stmt1->bindValue(':NUM',$_POST['num'],PDO::PARAM_STR);
			$stmt1->bindValue(':ID',$_POST['ID'],PDO::PARAM_INT);
			$stmt1->execute();
		}
	
		// band_info UPDATE文
        if($t !== false){
            $stmt1 = $pdo->prepare($upd1);
			$stmt1->bindValue(':ID',$_POST['ID'],PDO::PARAM_INT);
			$stmt1->execute();
        }
        
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
