<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit") {
	$form = new form("ajax");
	if($form->validate())
		echo "Congratulations! The information you enter passed the form's validation.";
	else
		$form->renderAjaxErrorResponse();
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>PHP Form Builder Class | Examples | Ajax</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<link href="style.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / Ajax</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Ajax</b> - To submit your form's data via AJAX, simply apply the "ajax" form attribute in the setAttributes function.  That's it - you're all set.  Most all of the complexity
				is handled for you by the project in the background, which saves you development time.  Below, you'll find several more form attributes that are specific to ajax functionality
				within the project.</p>
				<ul style="margin: 0;">
					<li>ajaxCallback -  The "ajaxCallback" attribute is used to house a javascript function name (without parenthesis) which is invoked when the ajax call is complete.  Any response returned
					from the AJAX call will be passed to this function as it's one and only parameter.</li>
					<li>ajaxPreCallback - Similar to the previous attribute, "ajaxPreCallback" is used to house a javascript function (without parenthesis).  The difference is that this javascript function is
					invoked just before the AJAX call is made.  Another difference is that no parameters are passed.</li>
				</ul>
				<p>Review the final section titled "Validation w/Ajax" in the <a href="validation.php">validation example file</a> provided for instructions on how to handle php validation when using the "ajax" 
				form attribute.</p>

				<?php
				$form = new form("ajax");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => "500",
					"map" => array(1, 2, 2, 2, 1, 3),
					"ajax" => 1
				));

				$form->addHidden("cmd", "submit");
				$form->addTextbox("Username:", "Username", "", array("required" => 1));
				$form->addPassword("Password:", "Password", "", array("required" => 1));
				$form->addPassword("Re-Enter Password:", "Password2", "", array("required" => 1));
				$form->addTextbox("First Name:", "FName", "", array("required" => 1));
				$form->addTextbox("Last Name:", "LName", "", array("required" => 1));
				$form->addEmail("Email Address:", "Email", "", array("required" => 1));
				$form->addTextbox("Phone Number:", "Phone");
				$form->addTextbox("Address:", "Address");
				$form->addTextbox("City:", "City");
				$form->addState("State:", "State");
				$form->addTextbox("Zip Code:", "Zip");
				$form->addButton("Sign Up");
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("ajax");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => "500",
	"map" => array(1, 2, 2, 2, 1, 3),
	"ajax" => 1
));

$form->addHidden("cmd", "submit");
$form->addTextbox("Username:", "Username", "", array("required" => 1));
$form->addPassword("Password:", "Password", "", array("required" => 1));
$form->addPassword("Re-Enter Password:", "Password2", "", array("required" => 1));
$form->addTextbox("First Name:", "FName", "", array("required" => 1));
$form->addTextbox("Last Name:", "LName", "", array("required" => 1));
$form->addEmail("Email Address:", "Email", "", array("required" => 1));
$form->addTextbox("Phone Number:", "Phone");
$form->addTextbox("Address:", "Address");
$form->addTextbox("City:", "City");
$form->addState("State:", "State");
$form->addTextbox("Zip Code:", "Zip");
$form->addButton("Sign Up");
$form->render();
?>', true), '</pre>';
}
?>
