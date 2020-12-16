<?php
// cronがファイル読み込みだと上手くいかないのでべた書き。
//db接続情報
function get_pdo(){
	$dsn = 'mysql:host=mysql146.phy.lolipop.lan;dbname=LAA1212173-mfys;charset=utf8';
	$username = 'LAA1212173';
	$password = 'f3EGNgGwTFNjG9r';
	return new PDO($dsn,$username,$password);
	}
// pdo生成
try{
    $pdo = get_pdo();
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
}catch(PDOException $hoge){
    die('接続エラー:'.$hoge->getMessage());
}


// EVENT_DATEが今日より過去のデータを取得
try {
	$sql1 = "
		select
			EVENT_ID
		from 
			EVENT_LIST
		where
			EVENT_FLG = 0
		and EVENT_DATE < date_format(NOW(), '%Y-%m-%d')
		";
	$stmt1 = $pdo->prepare($sql1);
	$stmt1->execute();
	$rowcount = $stmt1->rowcount();
	if ($rowcount == 0 ) {
		exit; // 対象が無ければ終了
	}else{
		$r = $stmt1->fetchAll(PDO::FETCH_COLUMN);
	}
	} catch (\PDOException $e) {
		$pdo->rollBack();
}

// UPDATE文整形
$upd1 = "update EVENT_LIST set EVENT_FLG = 1 where EVENT_ID IN (";
$upd2 = "";
$upd3 = ")";
foreach ($r as $key => $value) {
	if ($value == reset($r)) {
		$upd2 .= $value;
	}else{
		$upd2 .= ",".$value;
	}
}

// メイン処理
try {
	$pdo->beginTransaction();
	try {
		// EVENT_FLG更新
		$sql1 = $upd1.$upd2.$upd3;
		$stmt1 = $pdo->prepare($sql1);
		$stmt1->execute();
		$pdo->commit();
	} catch (\PDOException $e) {
			$pdo->rollBack();
		}
	} catch (\PDOException $e) {
		throw $e;
}
