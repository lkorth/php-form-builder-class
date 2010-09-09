<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit") {
	$form = new form("php_validation");
	if($form->validate())
		echo "Congratulations! The information you enter passed the form's validation.";
	else {
		/*Any validation errors that were uncovered in the project's validate function have been stored in 
		a session array - $_SESSION["pfbc-errors"].  When the user is redirected back to the form to fix his/her
		errors, this session array will be used to display the error messages above the appropriate fields.*/
		header("Location: php-validation.php");
	}	
	exit();
}

if(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>PHP Form Builder Class | Examples | PHP Validation</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<link href="style.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / PHP Validation</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">

				<p><b>PHP Validation</b> - After the form has been submitted, the validate() function can be used to verify that all required fields have been properly filled in,
				the captcha solution is correct (if applicable), and any applied textbox validation attributes such as integer and alphanumeric are followed.</p>

				<p>Also, if you look in the php souce code of this example, you will notice that I'm passing a unique identifier when creating a new instance of the form class.  That line 
				looks like this - $form = new form("php_validation");.  After the form is submitted, you will see the exact same line before the validate() function is used.  These 
				identifiers must match exactly for the validation to function properly.</p>

				<?php
				$form = new form("php_validation");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"preventJSValidation" => 1,
					"width" => 400
				));

				$form->addHidden("cmd", "submit");
				$form->addTextbox("Required Textbox:", "field0", "", array("required" => 1));
				$form->addDate("Required Date:", "field1", "", array("required" => 1));
				$form->addWebEditor("Required Web Editor:", "field2", "", array("required" => 1));
				$form->addCaptcha("Captcha:");
				$form->addButton();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("php_validation");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"preventJSValidation" => 1,
	"width" => 400
));

$form->addHidden("cmd", "submit");
$form->addTextbox("Required Textbox:", "field0", "", array("required" => 1));
$form->addDate("Required Date:", "field1", "", array("required" => 1));
$form->addWebEditor("Required Web Editor:", "field2", "", array("required" => 1));
$form->addCaptcha("Captcha:");
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
