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
			<title>PHP Form Builder Class | Examples | Fieldsets</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / Fieldsets</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<?php
				$form = new form("test");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 300,
				));
				$form->addHidden("cmd", "submit");
				$form->addTextbox("Field #1:", "Field1");
				$form->addTextbox("Field #2:", "Field2", "", array("labelWidth" => 100));
				$form->addTextbox("Field #3:", "Field3");
				$form->addSelect("Field #4:", "Field4", "", array("Option #1", "Option #2", "Option #3"), array("labelWidth" => 150));
				$form->addTextbox("Field #5:", "Field5");
				$form->addTextarea("Field #6:", "Field6", "", array("labelWidth" => 75));
				$form->addTextbox("Field #7:", "Field7");
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("test");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 300,
));
$form->addHidden("cmd", "submit");
$form->addTextbox("Field #1:", "Field1");
$form->addTextbox("Field #2:", "Field2", "", array("labelWidth" => 100));
$form->addTextbox("Field #3:", "Field3");
$form->addSelect("Field #4:", "Field4", "", array("Option #1", "Option #2", "Option #3"), array("labelWidth" => 150));
$form->addTextbox("Field #5:", "Field5");
$form->addTextarea("Field #6:", "Field6", "", array("labelWidth" => 75));
$form->addTextbox("Field #7:", "Field7");
$form->render();
?>', true), '</pre>';

				$form = new form("test2");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 600,
                                        "map" => array(2, 2, 1, 3, 1)
				));
				$form->addHidden("cmd", "submit");
				$form->addTextbox("Field #1:", "Field1", "", array("labelWidth" => 100));
				$form->addTextbox("Field #2:", "Field2", "", array("labelWidth" => 100));
				$form->addTextbox("Field #3:", "Field3", "", array("labelWidth" => 100));
				$form->addSelect("Field #4:", "Field4", "", array("Option #1", "Option #2", "Option #3"), array("labelWidth" => 150));
				$form->addTextbox("Field #5:", "Field5");
				$form->addTextarea("Field #6:", "Field6", "", array("labelWidth" => 75));
				$form->addTextbox("Field #7:", "Field7");
                                $form->addTextbox("Field #8:", "Field7");
                                $form->addTextbox("Field #9:", "Field7");
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("test");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 300,
));
$form->addHidden("cmd", "submit");
$form->addTextbox("Field #1:", "Field1");
$form->addTextbox("Field #2:", "Field2", "", array("labelWidth" => 100));
$form->addTextbox("Field #3:", "Field3");
$form->addSelect("Field #4:", "Field4", "", array("Option #1", "Option #2", "Option #3"), array("labelWidth" => 150));
$form->addTextbox("Field #5:", "Field5");
$form->addTextarea("Field #6:", "Field6", "", array("labelWidth" => 75));
$form->addTextbox("Field #7:", "Field7");
$form->addTextbox("Field #8:", "Field7");
$form->addTextbox("Field #9:", "Field7");
$form->render();
?>', true), '</pre>';

				?>
			</div>
		</body>	
	</html>	
	<?php
}
?>
