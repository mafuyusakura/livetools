<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/property.php');
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/main/header.php');







try {
	$pdo->beginTransaction();
	try {
		// event_list アップデート文  入り,捌け,レンタル時間
		$sql1 = "
				update
					EVENT_LIST
				set
					ENTER_TIME = :rehst,
					END_TIME = :rehen,
					RENTAL_TIME = :rentt,
					TT_FLG = 1
				where 
					EVENT_ID = :evet_id 
				";
        $stmt1 = $pdo->prepare($sql1);
		$stmt1->bindValue(':rehst',$_POST['rehst'],PDO::PARAM_STR);
		$stmt1->bindValue(':rehen',$_POST['rehen'],PDO::PARAM_STR);
		$stmt1->bindValue(':rentt',$_POST['rentt'],PDO::PARAM_INT);
		$stmt1->bindValue(':evet_id',$_POST['evet_id'],PDO::PARAM_INT);
		$stmt1->execute();

		// band_info更新  リハ
		// $sql2 = "
		// 		update 
		// 			band_info 
		// 		set 
		// 			REHEARSAL_TIME = :ctltm7
		// 		where 
		// 			EVENT_ID = :evet_id 
		// 		and BAND_NAME = :rehnm1
		// 		";
		// // band_info更新  本番
		// $sql3 = "
		// 		update 
		// 			band_info 
		// 		set 
		// 			PERFORMANCE_TIME = :ctltm7
		// 		where 
		// 			EVENT_ID = :evet_id 
		// 		and BAND_NAME = :ctlnm7
		// 		";

		// time_table  ID1～最大値までインサート文生成
		$getLast = substr(array_key_last($_POST),5); //最終行のID取得
		for ($i=1; $i <= $getLast; $i++) { 
			// 配列置き換え
			$id = $_POST['id_'.$i];
			$ctlnm = $_POST['ctlnm'.$i];
			$ctltm = $_POST['ctltm'.$i];
			$ctlsc = $_POST['ctlsc'.$i];

			$sql4 = "insert into TIMETABLE (EVENT_ID, NO, BAND_NAME, START_TIME, TIME, INS_DATE, UPD_DATE)
					values (:evet_id, :id, :ctlnm, :ctltm, :ctlsc, NOW(), NOW())";
			$stmt4 = $pdo->prepare($sql4);
			$stmt4->bindValue(':evet_id',$_POST['evet_id'],PDO::PARAM_INT);
			$stmt4->bindValue(':id',$id,PDO::PARAM_INT);
			$stmt4->bindValue(':ctlnm',$ctlnm,PDO::PARAM_STR);
			$stmt4->bindValue(':ctltm',$ctltm,PDO::PARAM_STR);
			$stmt4->bindValue(':ctlsc',$ctlsc,PDO::PARAM_STR);
			$stmt4->execute();
		}
        
		$pdo->commit();
		print '登録完了！';
		print "<a href=".$url[2]."><i class='zmdi zmdi-arrow-left'></i>[戻る]</a>";
		} catch (\PDOException $e) {
			$pdo->rollBack();
			print '登録出来ませんでした。<br>再度登録し直してください。';
			// print $e;
			print "<a href='javascript:history.back()'><i class='zmdi zmdi-arrow-left'></i>[戻る]</a>";
		}
	} catch (\PDOException $th) {
	throw $th;
}
