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
			<title>PHP Form Builder Class | Examples | Buttons</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / Buttons</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Buttons</b> - This example demonstrates how buttons are handled within the class.  The addButton() function can be called anywhere in the flow of your form's elements allowing you to 
				insert buttons in various places in your form's structure.  By default, buttons are right-aligned within their respective row.  The <i>jqueryUI</i> can be applied to leverage jQuery UI's button
				widget functionality.</b>

				<?php
				$form = new form("buttons");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 400
				));
				$form->addHidden("cmd", "submit");
				$form->addTextbox("Textbox:", "field0");
				$form->addSelect("Select:", "field1", "", array("" => "--Select an Option--", "1" => "Option #1", "2" => "Option #2", "3" => "Option #3"));
				$form->addButton();
				$form->addButton("Apply", "submit", array("jqueryUI" => 1));
				$form->addCheckbox("Checkboxes:", "field2", "", array("Option #1", "Option #2", "Option #3"), array("clear" => 1));
				$form->addRadio("Radio Buttons:", "field3", "", array("Option #1", "Option #2", "Option #3"), array("clear" => 1));
				$form->addButton("php.net", "link", array("href" => "http://www.php.net", "jqueryUI" => 1));
				$form->addButton("php.net", "button", array("onclick" => "window.location = 'http://www.php.net';"));
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("buttons");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 400
));
$form->addHidden("cmd", "submit");
$form->addTextbox("Textbox:", "field0");
$form->addSelect("Select:", "field1", "", array("" => "--Select an Option--", "1" => "Option #1", "2" => "Option #2", "3" => "Option #3"));
$form->addButton();
$form->addButton("Apply", "submit", array("jqueryUI" => 1));
$form->addCheckbox("Checkboxes:", "field2", "", array("Option #1", "Option #2", "Option #3"), array("clear" => 1));
$form->addRadio("Radio Buttons:", "field3", "", array("Option #1", "Option #2", "Option #3"), array("clear" => 1));
$form->addButton("php.net", "link", array("href" => "http://www.php.net", "jqueryUI" => 1));
$form->addButton("php.net", "button", array("onclick" => "window.location = \'http://www.php.net\';"));
$form->render();
?>', true), '</pre>';

				?>
			</div>	
		</body>
	</html>
	<?php
}
?>

