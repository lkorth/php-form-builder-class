<?php
error_reporting(E_ALL);
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit")
{
	echo "<pre>" . htmlentities(print_r($_POST,true)) . "</pre>";
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"]))
{
	?>
	<html>
		<head>
			<title>PHP Form Builder Class | Examples | Web Editors</title>
		</head>
		<body>
			<h2 style="text-align: center; margin: 0; padding: 0;">PHP Form Builder Class</h2>
			<h5 style="text-align: center; margin: 0; padding: 0;"><span style="padding-right: 10px;">Author: Andrew Porterfield</span><span style="padding-right: 10px;">Released: <?php echo(file_get_contents('../release'));?></span><span>Version: <?php echo(file_get_contents('../version'));?></span></h5>
			<div style="text-align: center; padding-bottom: 10px;"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">View Project's Homepage</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Latest Stable Release</a></div>
			<a href="../index.php">Back to Project Home Page</a>
			<p><b>Web Editors</b> - There are two web editors included with this project - TinyMCE and CKEditor.  Both editors have full and minimal versions that can be used.  By default, the full version will be rendered.
			To use TinyMCE's minimal version, set the <i>webeditorSimple</i> element attribute.  To use CKEditor's minimal version, set the <i>ckeditorBasic</i> element attribute.</p>
			<?php
			$form = new form("web_editors");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes",
				"tableAttributes" => array("width" => "400")
			));
			$form->addHidden("cmd", "submit");
			$form->addWebEditor("Default Web Editor:", "field0");
			$form->addWebEditor("Simple Web Editor:", "field1", "", array("webeditorSimple" => 1));
			$form->addWebEditor("Required/Prefilled Web Editor:", "field2", '<b>Rich</b> <span style="color: #009900;">Text</span>', array("required" => 1));
			$form->addCKEditor("Default CKEditor Editor:", "field3");
			$form->addCKEditor("Basic CKEditor Editor:", "field4", "", array("ckeditorBasic" => 1));
			$form->addCKEditor("Prefilled CKEditor Editor w/Basic Toolbar:", "field5", '<b>Rich</b> <span style="color: #009900;">Text</span>', array("required" => "1"));
			$form->addButton();
			$form->render();

echo '<pre>' . htmlentities('<?php
$form = new form("web_editors");
$form->setAttributes(array(
	"includesRelativePath" => "../includes",
	"tableAttributes" => array("width" => "400")
));
$form->addHidden("cmd", "submit");
$form->addWebEditor("Default Web Editor:", "field0");
$form->addWebEditor("Simple Web Editor:", "field1", "", array("webeditorSimple" => 1));
$form->addWebEditor("Required/Prefilled Web Editor:", "field2", \'<b>Rich</b> <span style="color: #009900;">Text</span>\', array("required" => 1));
$form->addCKEditor("Default CKEditor Editor:", "field3");
$form->addCKEditor("Basic CKEditor Editor:", "field4", "", array("ckeditorBasic" => 1));
$form->addCKEditor("Prefilled CKEditor Editor w/Basic Toolbar:", "field5", \'<b>Rich</b> <span style="color: #009900;">Text</span>\', array("required" => "1"));
$form->addButton();
$form->render();
?>') . '</pre>';

			?>
			<a href="../index.php">Back to Project Home Page</a>
		</body>
	</html>
	<?php
}
?>

