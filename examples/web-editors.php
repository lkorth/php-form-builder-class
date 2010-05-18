<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit")
{
	echo "<pre>" . htmlentities(print_r($_POST,true)) . "</pre>";
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"]))
{
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>PHP Form Builder Class | Examples | Web Editors</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
		</head>	
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2>PHP Form Builder Class / Examples / Web Editors</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Web Editors</b> - There are two web editors included with this project - TinyMCE and CKEditor.  Both editors have full and minimal versions that can be used.  By default, the full version will be rendered.
				To use TinyMCE's minimal version, set the <i>webeditorSimple</i> element attribute.  To use CKEditor's minimal version, set the <i>ckeditorBasic</i> element attribute.</p>

				<?php
				$form = new form("web_editors");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 400
				));
				$form->addHidden("cmd", "submit");
				$form->addWebEditor("Default Web Editor:", "field0");
				$form->addWebEditor("Simple Web Editor:", "field1", "", array("webeditorSimple" => 1));
				$form->addCKEditor("Default CKEditor Editor:", "field3");
				$form->addCKEditor("Basic CKEditor Editor:", "field4", "", array("ckeditorBasic" => 1));
				$form->addButton();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("web_editors");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 400
));
$form->addHidden("cmd", "submit");
$form->addWebEditor("Default Web Editor:", "field0");
$form->addWebEditor("Simple Web Editor:", "field1", "", array("webeditorSimple" => 1));
$form->addCKEditor("Default CKEditor Editor:", "field3");
$form->addCKEditor("Basic CKEditor Editor:", "field4", "", array("ckeditorBasic" => 1));
$form->addButton();
$form->render();
?>', true), '</pre>';

				?>
			</div>	
		</body>
	</html>
	<?php
}
?>

