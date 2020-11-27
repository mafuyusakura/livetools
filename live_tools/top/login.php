<?php
session_start();
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/db.php');
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/property.php');
// require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/top/header.php');

//sql処理
$search_name = $_POST['username'];
$search_pass = $_POST['password'];

try {
	$sql = "
            select 
                ID, USER_NAME, HASH_PASSWORD, AUTHORITY 
            from 
                USER_INFO 
            where 
                USER_NAME = :search_name
            ";
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':search_name',$search_name,PDO::PARAM_STR);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (\Exception $e) {
	print $e->getMessage() . PHP_EOL;
		}

	//usernameがDB内に存在しているか確認
	if (!isset($row['USER_NAME'])) {
	print 'ユーザー名又はパスワードが間違っています。<br>';
	print "<a href=".$url[2]."><i class='zmdi zmdi-arrow-left'></i>[Back]</a>";

	return false;
	}
	
	$id = $row['ID'];
	$parm = $row['AUTHORITY'];

	//パスワード確認後sessionにユーザー名を渡す
	if (password_verify($search_pass, $row['HASH_PASSWORD'])) {
	//session_idを新しく生成し、置き換える
	session_regenerate_id(true); 
	$_SESSION['USER_NAME'] = $row['USER_NAME'];
	$_SESSION['ID'] = $row['ID'];
	$_SESSION['AUTHORITY'] = $row['AUTHORITY'];
	header("location: ./r.php?id=$id&parm=$parm");
	exit();
} else {
	print 'ユーザー名又はパスワードが間違っています。<br>';
	print "<a href=".$url[2]."><i class='zmdi zmdi-arrow-left'></i>[Back]</a>";
	return false;
}