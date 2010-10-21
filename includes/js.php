<?php
if(!empty($_GET["session_name"]))
	session_name($_GET["session_name"]);
session_start();
header("Content-Type: text/javascript");

$id = (string) $_GET["id"];

if(empty($_SESSION["pfbc-instances"][$id]))
{
	echo 'alert("PFBC Configuration Error: A PHP Session is required to generate this form\'s necessary javascript and stylesheet information.  To correct, simply add \"session_start();\" before any output in your script.");';
	exit();
}

$path = "../class.form.php";

if(is_file($path))
{
	include($path);
	$form = new form($id);
	$form->renderJS();
}
else
	echo 'alert("PFBC Configuration Error: The path to the project\'s main file - class.form.php - is not referenced correctly.  Use the $path variable in the js.php/css.php files found in the php-form-builder-class/includes directory to identify the location of class.form.php.");';
?>
