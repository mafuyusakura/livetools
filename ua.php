<?php
$ua = $_SERVER['HTTP_USER_AGENT'];
if ((strpos($ua, 'Android') !== false) && (strpos($ua, 'Mobile') !== false) || (strpos($ua, 'iPhone') !== false) || (strpos($ua, 'Windows Phone') !== false)) {

  // print "スマホ用";
  print "<meta name='viewport' content='width=480,user-scalable=no'>";
  print "<link href='../css/sp.css' rel='stylesheet' media='all' />";

 } elseif ((strpos($ua, 'Android') !== false) || (strpos($ua, 'iPad') !== false)) { 

  // print "タブレット用";
  print "<meta name='viewport' content='width=768,user-scalable=no'>";
  print "<link href='../css/tablet.css' rel='stylesheet' media='all' />";

 } else { 

  // print "PC用";
  print "<meta name='viewport' content='width=device-width'/>";
  print "<link href='../css/pc.css' rel='stylesheet' media='all' />";

 }
?>