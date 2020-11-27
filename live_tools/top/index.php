<?php
//propertyファイル
require_once($_SERVER['DOCUMENT_ROOT'] . '/property.php');

session_start();
if (array_key_exists("USER_NAME", $_SESSION)) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/top/header.php');
    // session_regenerate_id(TRUE);
    $url = [URL1, URL2, URL3, URL4];
    $mian = $url[1].'/main/';
    $logout = $url[1].'/top/logout.php';
    print 'ようこそ　'.($_SESSION['USER_NAME']).'さん<br>';
    print "<img src='$url[1]/image/onpu.png' alt='none' width='15px'><a href=$mian>マイページ</a><br>";
    print "<img src='$url[1]/image/logout.png' alt='none' width='15px'><a href=$logout>ログアウト</a>";
    exit;
}else {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/live_tools/top/header.php');
    
    $smarty->display('top/login.html');
    // $smarty->display('top/signup.html');
    // $smarty->display('top/reset.html');
    $smarty->display('footer.html');
    
}
