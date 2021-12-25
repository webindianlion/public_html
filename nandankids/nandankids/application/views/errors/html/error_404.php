<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<!-- Favicon -->
        <link rel="apple-touch-icon" sizes="57x57" href="http://localhost/SAD_UAT/img/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="http://localhost/SAD_UAT/img/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="http://localhost/SAD_UAT/img/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="http://localhost/SAD_UAT/img/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="http://localhost/SAD_UAT/img/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="http://localhost/SAD_UAT/img/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="http://localhost/SAD_UAT/img/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="http://localhost/SAD_UAT/img/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="http://localhost/SAD_UAT/img/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192" href="http://localhost/SAD_UAT/img/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="http://localhost/SAD_UAT/img/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="http://localhost/SAD_UAT/img/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="http://localhost/SAD_UAT/img/favicon-16x16.png">

<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
</html>