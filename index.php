<?php
// propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/property.php');

$url = URL2;
$redirect[$id] = "$url/top";
header("Location: $redirect[$id]");
exit();
