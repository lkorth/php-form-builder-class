<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "signup") {
	$form = new form("signup");
	if($form->validate())
		if($_POST["Password"] == $_POST["Password2"])
			echo "Success: You're Signed Up";
		else
			echo "Error: Password fields do not match.";
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
				<p><b>Ajax</b> - Included in this class is the ability to submit a form using ajax.  Simply set the <i>ajax</i> form attribute to 1 and you are ready to get started.  Optional parameters include 
				<i>ajaxType</i> which allows you to specify if you want to submit the form using POST or GET (defaults to POST), <i>ajaxUrl</i> which controls where the form submits data (defaults to current script), 
				<i>ajaxDataType</i> which specifies the server response format (defaults to an intelligent guess based on MIME type), and <i>ajaxCallback</i> which gives you control over what events happen once the form have successfully submitted.</p>

				<?php
				$form = new form("signup");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => "500",
					"ajax" => 1,
					"jqueryUIButtons" => 1,
					"preventJSValidation" => 1,
					"map" => array(1, 2, 2, 2, 1, 3)
				));

				$form->addHidden("cmd", "signup");
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
?>', true), '</pre>';
}
?>
