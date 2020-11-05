<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/property.php');
//BD接続ファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/db.php');

require_once './header.php';

//sql処理
try {
    $sql = "select * from HOUSE_INFO";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }

$smarty->assign('house', $r);
$smarty->display('main/event_entry.html');

