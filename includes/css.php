<?php
session_start();
$path = "../class.form.php";

$id = (string) $_GET["id"];

if(is_file($path))
{
	include($path);
	header("Content-Type: text/css");
	$form = new form($id);
	$form->renderCSS();
}
?>
