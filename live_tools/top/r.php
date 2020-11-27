<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/property.php');

$id = $_GET['id'];
$parm = $_GET['parm'];
$url = URL2;
$redirect[$id] = "$url/main/index?id=$id&parm=$parm";
if(isset($_GET['id'])){
	$id = intval($_GET['id']);
	header("Location: $redirect[$id]");
	exit();
}
