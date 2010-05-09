<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit")
{
	$form = new form("email_validation");
	if($form->validate())
		$msg = "Congratulations! The information you enter passed the form's validation.";
	else
		$msg = "Oops! The information you entered did not pass the form's validation.  Please review the following error message and re-try - " . $form->errorMsg;

	header("Location: email-validation.php?error_message=" . urlencode($msg));
	exit();
}

if(!isset($_GET["cmd"]) && !isset($_POST["cmd"]))
{
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>PHP Form Builder Class | Examples | Email Validation</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2>PHP Form Builder Class / Examples / Email Validation</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">

			<?php
			if(!empty($_GET["error_message"]))
				echo("<div style='text-align: center; font-weight: bold; color: #990000;'>" . htmlentities(stripslashes($_GET["error_message"])) . "</div>");
			?>

				<p><b>Email Validation</b> - When an email form element type is added, javascript will automatically validate the email address via an ajax call within the form's onsubmit function.  You can also validate the email address through the validate() function after the form has been submitted.
				If you do not apply the <i>required</i> element attribute, a blank value will not be checked.</p>

				<?php
				$form = new form("email_validation");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"enableSessionAutoFill" => 1,
					"width" => 400
				));
				$form->addHidden("cmd", "submit");
				$form->addEmail("Email Address:", "Email", "", array("required" => 1));
				$form->addButton();
				$form->render();

echo '<pre>' . htmlentities('<?php
$form = new form("email_validation");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"enableSessionAutoFill" => 1,
	"width" => 400
));
$form->addHidden("cmd", "submit");
$form->addEmail("Email Address:", "Email", "", array("required" => 1));
$form->addButton();
$form->render();
?>') . '</pre>';

				?>
			</div>	
		</body>
	</html>
	<?php
}
?>

