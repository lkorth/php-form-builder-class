<?
session_start();
header("Content-Type: text/javascript");

$path = "../class.form.php";

if(is_file($path))
{
	include($path);
	$form = new form($_GET["id"]);
	$form->renderJS();
}
else
	echo 'alert("php-form-builder-class Configuration Error: Invalid class.form.php Path(s)\n\nUse the $path variable in both the js.php and css.php files found in the php-form-builder-class/includes directory to identify the location of class.form.php.");';
?>
