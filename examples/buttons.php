<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0", "submit_1"))) {
	$form = new form("buttons_" . substr($_POST["cmd"], -1));
	if($form->validate())
		header("Location: buttons.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Congratulations! The information you enter passed the form's validation."));
	else
		header("Location: buttons.php");
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>PHP Form Builder Class | Examples | Buttons</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<link href="style.css" rel="stylesheet" type="text/css"/>
			<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>  
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / Buttons</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Buttons</b> - The list provided below identifies sevaral areas where the button element differs from other element types within this project.</b>

				<ul style="margin: 0;">
					<li>Using this project's default stylesheet, Buttons will always be rendered right-aligned on their own line separate from other elements.</li>
					<li>Consecutive buttons will be rendered horizontally in the same line.</li>
					<li>When using the "map" form attribute, buttons don't affect the the number of elements that are to be rendered on each line.</li>
				</ul>

				<p>See the <a href="jquery.php">jQuery example file</a> for more information on how the "jqueryUI" and "jqueryUIButtons" attributes can be used to leverage jQueryUI's button
				widget functionality.  Below, you will find several ways of how you can use this project's addButton function in your development.</p>

				<?php
				$form = new form("buttons_0");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 400
				));

				if(!empty($_GET["errormsg_0"]))
					$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

				$form->addHidden("cmd", "submit_0");
				$form->addTextbox("Textbox:", "MyTextbox");
				$form->addSelect("Selectbox:", "MySelectbox", "", array("Option #1", "Option #2", "Option #3"));
				$form->addButton("Button #1");
				$form->addButton("Button #2");
				$form->addButton("Button #3");
				$form->addCheckbox("Checkboxes:", "MyCheckbox[]", "", array("Option #1", "Option #2", "Option #3"), array("nobreak" => 1));
				$form->addRadio("Radio Buttons:", "MyRadio", "", array("Option #1", "Option #2", "Option #3"), array("nobreak" => 1));
				$form->addButton("Button #4");
				$form->render();

				?>
				<br/><br/>
				<?php

				$form = new form("buttons_1");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 500,
					"jqueryUIButtons" => 1,
					"noAutoFocus" => 1,
					"preventJQueryLoad" => 1,
					"preventJQueryUILoad" => 1,
					"map" => array(2, 2, 1, 3)
				));

				if(!empty($_GET["errormsg_1"]))
					$form->errorMsg = filter_var(stripslashes($_GET["errormsg_1"]), FILTER_SANITIZE_SPECIAL_CHARS);

				$form->addHidden("cmd", "submit_1");
				$form->addTextbox("First Name:", "FName");
				$form->addTextbox("Last Name:", "LName");
				$form->addButton("Button w/Map Attribute");
				$form->addEmail("Email Address:", "Email");
				$form->addTextbox("Phone Number:", "Phone");
				$form->addTextbox("Address:", "Address");
				$form->addTextbox("City:", "City");
				$form->addState("State:", "State");
				$form->addTextbox("Zip Code:", "Zip");
				$form->addButton("Cancel", "button", array("onclick" => "window.back();"));
				$form->addButton();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("buttons_0");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 400
));

if(!empty($_GET["errormsg_0"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_0");
$form->addTextbox("Textbox:", "MyTextbox");
$form->addSelect("Selectbox:", "MySelectbox", "", array("Option #1", "Option #2", "Option #3"));
$form->addButton("Button #1");
$form->addButton("Button #2");
$form->addButton("Button #3");
$form->addCheckbox("Checkboxes:", "MyCheckbox[]", "", array("Option #1", "Option #2", "Option #3"), array("nobreak" => 1));
$form->addRadio("Radio Buttons:", "MyRadio", "", array("Option #1", "Option #2", "Option #3"), array("nobreak" => 1));
$form->addButton("Button #4");
$form->render();

?>
<br/><br/>
<?

$form = new form("buttons_1");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 500,
	"jqueryUIButtons" => 1,
	"map" => array(2, 2, 1, 3)
));

if(!empty($_GET["errormsg_1"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_1"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_1");
$form->addTextbox("First Name:", "FName");
$form->addTextbox("Last Name:", "LName");
$form->addButton("Button w/Map Attribute");
$form->addEmail("Email Address:", "Email");
$form->addTextbox("Phone Number:", "Phone");
$form->addTextbox("Address:", "Address");
$form->addTextbox("City:", "City");
$form->addState("State:", "State");
$form->addTextbox("Zip Code:", "Zip");
$form->addButton("Cancel", "button", array("onclick" => "window.back();"));
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

