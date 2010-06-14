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
				<p><b>Fieldsets</b> - To insert fieldsets into your form, simply use the addFieldset() and closeFields() functions as seen below.  When using fieldsets and the mapping functionality to structure your form, 
				keep in mind that the openFieldset/closeFieldset function calls do not count as form elements in the array passed to the <i>map</i> form attribute.</p>

				<?php
				$form = new form("fieldsets");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 300,
				));
				$form->addHidden("cmd", "submit");
				$form->openFieldset("Fieldset #1");
				$form->addTextbox("Field #1:", "Field1");
				$form->addTextbox("Field #2:", "Field2");
				$form->closeFieldset();
				$form->openFieldset("Fieldset #2");
				$form->addTextbox("Field #3:", "Field3");
				$form->addTextbox("Field #4:", "Field4");
				$form->closeFieldset();
				$form->openFieldset("Fieldset #3");
				$form->addTextbox("Field #5:", "Field5");
				$form->addTextbox("Field #6:", "Field6");
				$form->addHTML('<div style="text-align: right;"><input type="submit" value="Submit"/></div>');
				$form->closeFieldset();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("fieldsets");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 300,
));
$form->addHidden("cmd", "submit");
$form->openFieldset("Fieldset #1");
$form->addTextbox("Field #1:", "Field1");
$form->addTextbox("Field #2:", "Field2");
$form->closeFieldset();
$form->openFieldset("Fieldset #2");
$form->addTextbox("Field #3:", "Field3");
$form->addTextbox("Field #4:", "Field4");
$form->closeFieldset();
$form->openFieldset("Fieldset #3");
$form->addTextbox("Field #5:", "Field5");
$form->addTextbox("Field #6:", "Field6");
$form->closeFieldset();
$form->addButton();
$form->render();
?>', true), '</pre>';

				$form = new form("fieldsets_mapping");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 500,
					"noAutoFocus" => 1,
					"map" => array(2, 2, 1, 3, 1)
				));
				$form->addHidden("cmd", "submit");
				$form->openFieldset("Shipping Information");
				$form->addTextbox("First Name:", "FName");
				$form->addTextbox("Last Name:", "LName");
				$form->addEmail("Email Address:", "Email");
				$form->addTextbox("Phone Number:", "Phone");
				$form->addTextbox("Address:", "Address");
				$form->addTextbox("City:", "City");
				$form->addState("State:", "State");
				$form->addTextbox("Zip Code:", "Zip");
				$form->addHTML('<div style="text-align: right;"><input type="submit" value="Submit"/></div>');
				$form->closeFieldset();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("fieldsets_mapping");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 500,
	"noAutoFocus" => 1,
	"map" => array(2, 2, 1, 3, 1)
));
$form->addHidden("cmd", "submit");
$form->openFieldset("Shipping Information");
$form->addTextbox("First Name:", "FName");
$form->addTextbox("Last Name:", "LName");
$form->addEmail("Email Address:", "Email");
$form->addTextbox("Phone Number:", "Phone");
$form->addTextbox("Address:", "Address");
$form->addTextbox("City:", "City");
$form->addState("State:", "State");
$form->addTextbox("Zip Code:", "Zip");
$form->addHTML(\'<div style="text-align: right;"><input type="submit" value="Submit"/></div>\');
$form->closeFieldset();
$form->render();
?>', true), '</pre>';

				?>
			</div>
		</body>	
	</html>	
	<?php
}
?>
