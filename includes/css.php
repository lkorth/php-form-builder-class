<?
session_start();
$path = "../class.form.php";

if(is_file($path))
{
	include($path);
	header("Content-Type: text/css");
	$form = new form($_GET["id"]);
	$form->renderCSS();
}
?>
