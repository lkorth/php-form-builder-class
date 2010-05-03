<?php
session_start();
header("Content-Type: text/javascript");

$id = (string) $_GET["id"];

if(empty($_SESSION["pfbc-instances"][$id]))
{
	echo 'alert("php-form-builder-class Configuration Error: Session Not Started\n\nA session is required to generate this form\'s necessary javascript and stylesheet information.  To correct, simply add session_start(); before any output in your script.");';
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
	echo 'alert("php-form-builder-class Configuration Error: Invalid class.form.php Path(s)\n\nUse the $path variable in both the js.php and css.php files found in the php-form-builder-class/includes directory to identify the location of class.form.php.");';
?>
