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
        <link rel='stylesheet' href='../css/main.css'>
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
		<link rel='stylesheet' href='../css/main.css'>
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
		<link rel='stylesheet' href='../css/main.css'>
		<title></title>
		</head>
		<body>";

 }
?>