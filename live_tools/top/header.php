<?php
$ua = $_SERVER['HTTP_USER_AGENT'];
if ((strpos($ua, 'Android') !== false) && (strpos($ua, 'Mobile') !== false) || (strpos($ua, 'iPhone') !== false) || (strpos($ua, 'Windows Phone') !== false)) {

	// print "スマホ用";
	print 
		"<!DOCTYPE html>
        <html lang='ja'>
        <head>
        <meta name='viewport' content='width=device-width,initial-scale=1.0' />
        <meta charset='utf-8'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css'>
        <link rel='stylesheet' href='../css/top/sp.css'>
		<script type='text/javascript' src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
		<script type='text/javascript' src='../js/script.js'></script>
		<title></title>
        </head>
        <body>";

 } elseif ((strpos($ua, 'Android') !== false) || (strpos($ua, 'iPad') !== false)) { 
	// print "タブレット用";
	print 
		"<!DOCTYPE html>
		<html lang='ja'>
		<head>
		<meta name='viewport' content='width=device-width,initial-scale=1.0' />
		<meta charset='utf-8'>
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css'>
		<link rel='stylesheet' href='../css/top/tab.css'>
		<script type='text/javascript' src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
		<script type='text/javascript' src='../js/script.js'></script>
		<title></title>
		</head>
		<body>";

 } else { 
	// print "PC用";
	print 
		"<!DOCTYPE html>
		<html lang='ja'>
		<head>
		<meta name='viewport' content='width=device-width,initial-scale=1.0' />
		<meta charset='utf-8'>
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css'>
		<link rel='stylesheet' href='../css/top/pc.css'>
		<script type='text/javascript' src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
		<script type='text/javascript' src='../js/script.js'></script>
		<title></title>
		</head>
		<body>";

 }
?>