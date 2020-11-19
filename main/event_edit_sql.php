<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/property.php');
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');

try {
	$pdo->beginTransaction();
	try {
		// EVENT_LIST UPDATE文
		// 開催日
		if (empty($_POST['calendar']) === false) {
			$sql1 = "UPDATE EVENT_LIST SET EVENT_DATE = :EVENT_DATE, UPD_DATE = NOW() WHERE EVENT_ID = :ID ";
			$stmt1 = $pdo->prepare($sql1);
			$stmt1->bindParam(':EVENT_DATE',$_POST['calendar'],PDO::PARAM_STR);
			$stmt1->bindValue(':ID',$_POST['ID'],PDO::PARAM_INT);
			$stmt1->execute();
		}
		// イベント名
		if (empty($_POST['eventname']) === false) {
			$sql1 = "UPDATE EVENT_LIST SET EVENT_NAME = :EVENT_NAME, UPD_DATE = NOW() WHERE EVENT_ID = :ID ";
			$stmt1 = $pdo->prepare($sql1);
			$stmt1->bindValue(':EVENT_NAME',$_POST['eventname'],PDO::PARAM_STR);
			$stmt1->bindValue(':ID',$_POST['ID'],PDO::PARAM_INT);
			$stmt1->execute();
		}
		// レンタル時間
		if (empty($_POST['time']) === false) {
			$sql1 = "UPDATE EVENT_LIST SET RENTAL_TIME = :RENTAL_TIME, UPD_DATE = NOW() WHERE EVENT_ID = :ID ";
			$stmt1 = $pdo->prepare($sql1);
			$stmt1->bindValue(':RENTAL_TIME',$_POST['time'],PDO::PARAM_STR);
			$stmt1->bindValue(':ID',$_POST['ID'],PDO::PARAM_INT);
			$stmt1->execute();
		}
		// 参加バンド上限数
		if (empty($_POST['num']) === false) {
			$sql1 = "UPDATE EVENT_LIST SET BAND_NUM = :BAND_NUM, UPD_DATE = NOW() WHERE EVENT_ID = :ID ";
			$stmt1 = $pdo->prepare($sql1);
			$stmt1->bindValue(':BAND_NUM',$_POST['num'],PDO::PARAM_STR);
			$stmt1->bindValue(':ID',$_POST['ID'],PDO::PARAM_INT);
			$stmt1->execute();
		}
		// band_info UPDATE文
		if (empty($_POST['housename']) === false) {
			$sql1 = "UPDATE EVENT_LIST SET HOUSE_NAME = :HOUSE_NAME, UPD_DATE = NOW() WHERE EVENT_ID = :ID ";
			$stmt1 = $pdo->prepare($sql1);
			$stmt1->bindValue(':HOUSE_NAME',$_POST['housename'],PDO::PARAM_STR);
			$stmt1->bindValue(':ID',$_POST['ID'],PDO::PARAM_INT);
			$stmt1->execute();
		}
        
		$pdo->commit();
		print '登録完了！<br>';
		print "<a href=".$url[2]."><i class='zmdi zmdi-arrow-left'></i>[Back]</a>";
		} catch (\PDOException $e) {
			$pdo->rollBack();
			print '登録出来ませんでした。<br>再度登録し直してください。<br>';
			print "<a href='javascript:history.back()'><i class='zmdi zmdi-arrow-left'></i>[Back]</a>";
		}
	} catch (\PDOException $th) {
	throw $th;
}
