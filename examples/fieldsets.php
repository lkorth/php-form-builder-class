<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0"))) {
	$form = new form("fieldsets_" . substr($_POST["cmd"], -1));
	if($form->validate())
		header("Location: fieldsets.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Congratulations! The information you enter passed the form's validation."));
	else
		header("Location: fieldsets.php");
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>PHP Form Builder Class | Examples | Fieldsets</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<link href="style.css" rel="stylesheet" type="text/css"/>
			<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>  
			<style type="text/css">
				.pfbc-fieldset {
					margin: 0;
					padding: 10px;
					border: 1px solid #ccc;
					-moz-border-radius: 8px; 
					-webkit-border-radius: 8px;
					width: 500px;
				}
				#fieldsets_0 {
					width: 522px;
				}
			</style>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / Fieldsets</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Fieldsets</b> - Fieldsets are applied to your forms by using the project's openFieldset/closeFieldset functions.  Below, you will find one way that you can use fieldsets in your
				development.</p>

				<?php
				$form = new form("fieldsets_0");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 500,
					"map" => array(2, 1, 3, 2, 3)
				));

				if(!empty($_GET["errormsg_0"]))
					$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

				$form->addHidden("cmd", "submit_0");
				$form->openFieldset("Name");
				$form->addTextbox("First Name:", "FName");
				$form->addTextbox("Last Name:", "LName");
				$form->closeFieldset();
				$form->openFieldset("Address");
				$form->addTextbox("Address:", "Address");
				$form->addTextbox("City:", "City");
				$form->addState("State:", "State");
				$form->addTextbox("Zip Code:", "Zip");
				$form->closeFieldset();
				$form->openFieldset("Email Addresses");
				$form->addEmail("Email Address:", "Email");
				$form->addEmail("Alternate Email Address:", "AlternateEmail");
				$form->closeFieldset();
				$form->openFieldset("Phone Numbers");
				$form->addTextbox("Mobile/Cell:", "Mobile");
				$form->addTextbox("Home:", "Home");
				$form->addTextbox("Work:", "Work");
				$form->addButton();
				$form->closeFieldset();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("fieldsets_0");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 500,
	"map" => array(2, 1, 3, 2, 3)
));

if(!empty($_GET["errormsg_0"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_0");
$form->openFieldset("Name");
$form->addTextbox("First Name:", "FName");
$form->addTextbox("Last Name:", "LName");
$form->closeFieldset();
$form->openFieldset("Address");
$form->addTextbox("Address:", "Address");
$form->addTextbox("City:", "City");
$form->addState("State:", "State");
$form->addTextbox("Zip Code:", "Zip");
$form->closeFieldset();
$form->openFieldset("Email Addresses");
$form->addEmail("Email Address:", "Email");
$form->addEmail("Alternate Email Address:", "AlternateEmail");
$form->closeFieldset();
$form->openFieldset("Phone Numbers");
$form->addTextbox("Mobile/Cell:", "Mobile");
$form->addTextbox("Home:", "Home");
$form->addTextbox("Work:", "Work");
$form->addButton();
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
