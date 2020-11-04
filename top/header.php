<?php
$ua = $_SERVER['HTTP_USER_AGENT'];
if ((strpos($ua, 'Android') !== false) && (strpos($ua, 'Mobile') !== false) || (strpos($ua, 'iPhone') !== false) || (strpos($ua, 'Windows Phone') !== false)) {

  // print "スマホ用";
  print "<!DOCTYPE html>";
  print "<html lang='ja'>";
  print "<head>";
  print "<meta name='viewport' content='width=device-width,initial-scale=1.0' />";
  print "<meta charset='utf-8'>";
  print "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css'>";
  print "<link rel='stylesheet' href='../css/sp.css'>";
  print "<title></title>";
  print "</head>";
  print "<body>";

 } elseif ((strpos($ua, 'Android') !== false) || (strpos($ua, 'iPad') !== false)) { 

  // print "タブレット用";
  print "<!DOCTYPE html>";
  print "<html lang='ja'>";
  print "<head>";
  print "<meta name='viewport' content='width=device-width,initial-scale=1.0' />";
  print "<meta charset='utf-8'>";
  print "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css'>";
  print "<link rel='stylesheet' href='../css/tab.css'>";
  print "<title></title>";
  print "</head>";
  print "<body>";

 } else { 

  // print "PC用";
  print "<!DOCTYPE html>";
  print "<html lang='ja'>";
  print "<head>";
  print "<meta name='viewport' content='width=device-width,initial-scale=1.0' />";
  print "<meta charset='utf-8'>";
  print "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css'>";
  print "<link rel='stylesheet' href='../css/pc.css'>";
  print "<title></title>";
  print "</head>";
  print "<body>";

 }
?>