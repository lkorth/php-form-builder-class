<?php
$example = false;
if(strpos($_SERVER["PHP_SELF"], "/examples") !== false)
	$example = true;

$documentation = false;
if(strpos($_SERVER["PHP_SELF"], "/documentation") !== false)
	$documentation = true;

$pathprefix = "";
if($example || $documentation)
	$pathprefix = "../";

$version = trim(file_get_contents($pathprefix . "version"));
$release = trim(file_get_contents($pathprefix . "release"));

$pagetitle = "PHP Form Builder Class";
$bannertitle = "PHP Form Builder Class";
if($example) {
	$pagetitle .= " | Examples";
	$bannertitle = '<a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a>';
}	
elseif($documentation) {
	$pagetitle .= " | Documentation";
	$bannertitle = '<a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Documentation</a>';
}	
if(!empty($title)) {
	$pagetitle .= " | " . $title;
	$bannertitle .= " / " . $title;
}	

if(!isset($headextra))
	$headextra = "";
if($example)
	$headextra .= '<link href="style.css" rel="stylesheet" type="text/css"/>';

echo <<<STR
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>$pagetitle</title>
		<link href="{$pathprefix}style.css" rel="stylesheet" type="text/css"/>
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/> 
		$headextra
	</head>
	<body>
		<div id="pfbc_links">
			<a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | 
			<a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | 
			<a href="http://php-form-builder-class.googlecode.com/files/formbuilder-$version.zip">Download Version $version</a>
		</div>

		<div id="pfbc_banner">
			<h2>$bannertitle</h2>
			<h5><span>Version: $version</span><span style="padding-left: 10px;">Released: $release</span></h5>
		</div>

		<div id="pfbc_content">

STR;
