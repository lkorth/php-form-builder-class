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
			<title>PHP Form Builder Class | Examples | Layout</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / Layout</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Layout</b> - By default, one form element will be rendered on each line; however, the <i>map</i> form attribute can be used to customize the form's layout.
				Simply set this attribute to a one dimensional array of numbers corresponding with how many elements you would like rendered on each line.  In the example provided below, the
				<i>map</i> attribute is set to array(2, 2, 1, 3).</p>

				<?php
				$form = new form("layout");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 500,
					"map" => array(2, 2, 1, 3)
				));
				$form->addHidden("cmd", "submit");
				$form->addTextbox("First Name:", "FName");
				$form->addTextbox("Last Name:", "LName");
				$form->addEmail("Email Address:", "Email");
				$form->addTextbox("Phone Number:", "Phone");
				$form->addTextbox("Address:", "Address");
				$form->addTextbox("City:", "City");
				$form->addState("State:", "State");
				$form->addTextbox("Zip Code:", "Zip");
				$form->addButton();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("layout");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 500,
	"map" => array(2, 2, 1, 3)
));
$form->addHidden("cmd", "submit");
$form->addTextbox("First Name:", "FName");
$form->addTextbox("Last Name:", "LName");
$form->addTextbox("Email Address:", "Email");
$form->addTextbox("Phone Number:", "Phone");
$form->addTextbox("Address:", "Address");
$form->addTextbox("City:", "City");
$form->addState("State:", "State");
$form->addTextbox("Zip Code:", "Zip");
$form->addButton();
$form->render();
?>', true), '</pre>';

				?>
				<p>In the sample login form provided below, the <i>labelWidth</i> attribute is used to render the label on the same line as the form elements.  <i>labelWidth</i> can be set as both a form and element level attribute.</p>
				<?
				$form = new form("login");
				$form->setAttributes(array(
					"width" => 300,
					"includesPath" => "../includes",
					"labelWidth" => 100
				));
				$form->addHidden("cmd", "submit");
				$form->addTextbox("Username:", "Username", "", array("required" => 1));
				$form->addPassword("Password:", "Password", "", array("required" => 1));
				$form->addHTML('<a href="#">Forgot your password?</a>');
				$form->addButton("Login");
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("login");
$form->setAttributes(array(
	"width" => 300,
	"includesPath" => "../includes",
	"labelWidth" => 100
));
$form->addHidden("cmd", "submit");
$form->addTextbox("Username:", "Username", "", array("required" => 1));
$form->addPassword("Password:", "Password", "", array("required" => 1));
$form->addHTML(\'<a href="#">Forgot your password?</a>\');
$form->addButton("Login");
$form->render();
', true), '</pre>';

				?>
				<p>This form demonstrates how the <i>labelWidth, labelRightAlign, and map</i> attributes can all be used in combination to produce yet another possible layout.  <i>labelPaddingRight</i> can be used to control the padding applied to the right of the each label.</p>
				<?
				$form = new form("signup");
				$form->setAttributes(array(
					"width" => 700,
					"includesPath" => "../includes",
					"noAutoFocus" => 1,
					"labelWidth" => 100,
					"labelRightAlign" => 1,
					"map" => array(2, 2, 1, 3)
				));
				$form->addHidden("cmd", "submit");
				$form->addTextbox("First Name:", "FName", "", array("required" => 1));
				$form->addTextbox("Last Name:", "LName", "", array("required" => 1));
				$form->addEmail("Email Address:", "Email", "", array("required" => 1));
				$form->addTextbox("Phone Number:", "Phone");
				$form->addTextbox("Address:", "Address");
				$form->addTextbox("City:", "City");
				$form->addState("State:", "State");
				$form->addTextbox("Zip Code:", "Zip");
				$form->addButton();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("signup");
$form->setAttributes(array(
	"width" => 700,
	"includesPath" => "../includes",
	"noAutoFocus" => 1,
	"labelWidth" => 100,
	"labelRightAlign" => 1,
	"map" => array(2, 2, 1, 3)
));
$form->addHidden("cmd", "submit");
$form->addTextbox("First Name:", "FName", "", array("required" => 1));
$form->addTextbox("Last Name:", "LName", "", array("required" => 1));
$form->addEmail("Email Address:", "Email", "", array("required" => 1));
$form->addTextbox("Phone Number:", "Phone");
$form->addTextbox("Address:", "Address");
$form->addTextbox("City:", "City");
$form->addState("State:", "State");
$form->addTextbox("Zip Code:", "Zip");
$form->addButton();
$form->render();
', true), '</pre>';

				?>
				<p>Using pixels when building your forms will give you more accurate alignment; however, you can defines widths in percentages if desired.
				Please note that percentages and pixels should not be mixed together in the same form.</p>
				<?
				$form = new form("percentages");
				$form->setAttributes(array(
					"width" => "80%",
					"includesPath" => "../includes",
					"noAutoFocus" => 1,
					"labelWidth" => "30%",
					"labelRightAlign" => 1,
					"labelPaddingRight" => "1%"
				));
				$form->addHidden("cmd", "submit");
				$form->addTextbox("First Name:", "FName", "", array("required" => 1));
				$form->addTextbox("Last Name:", "LName", "", array("required" => 1));
				$form->addEmail("Email Address:", "Email", "", array("required" => 1));
				$form->addTextbox("Phone Number:", "Phone");
				$form->addTextbox("Address:", "Address");
				$form->addTextbox("City:", "City");
				$form->addState("State:", "State");
				$form->addTextbox("Zip Code:", "Zip");
				$form->addButton();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("percentages");
$form->setAttributes(array(
	"width" => "80%",
	"includesPath" => "../includes",
	"noAutoFocus" => 1,
	"labelWidth" => "30%",
	"labelRightAlign" => 1,
	"labelPaddingRight" => "1%"
));
$form->addHidden("cmd", "submit");
$form->addTextbox("First Name:", "FName", "", array("required" => 1));
$form->addTextbox("Last Name:", "LName", "", array("required" => 1));
$form->addEmail("Email Address:", "Email", "", array("required" => 1));
$form->addTextbox("Phone Number:", "Phone");
$form->addTextbox("Address:", "Address");
$form->addTextbox("City:", "City");
$form->addState("State:", "State");
$form->addTextbox("Zip Code:", "Zip");
$form->addButton();
$form->render();
', true), '</pre>';
				?>
			</div>
		</body>	
	</html>	
	<?php
}
?>
