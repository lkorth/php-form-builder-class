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

if(!empty($_GET["error_message"]))
	echo("<div style='text-align: center; font-weight: bold; color: #990000;'>" . htmlentities(stripslashes($_GET["error_message"])) . "</div>");

if(!isset($_GET["cmd"]) && !isset($_POST["cmd"]))
{
	?>
	<html>
		<head>
			<title>PHP Form Builder Class | Examples | Email Validation</title>
		</head>	
		<body>
			<h2 style="text-align: center; margin: 0; padding: 0;">PHP Form Builder Class</h2>
			<h5 style="text-align: center; margin: 0; padding: 0;"><span style="padding-right: 10px;">Author: Andrew Porterfield</span><span style="padding-right: 10px;">Released: <?php echo(file_get_contents('../release'));?></span><span>Version: <?php echo(file_get_contents('../version'));?></span></h5>
			<div style="text-align: center; padding-bottom: 10px;"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">View Project's Homepage</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Latest Stable Release</a></div>
			<a href="../index.php">Back to Project Home Page</a>
			<p><b>Email Validation</b> - When an email form element type is added, javascript will automatically validate the email address via an ajax call within the form's onsubmit function.  You can also validate the email address through the validate() function after the form has been submitted.
			If you do not apply the <i>required</i> element attribute, a blank value will not be checked.</p>

			<?php
			$form = new form("email_validation");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes",
				"enableSessionAutoFill" => 1,
				"tableAttributes" => array("width" => "400")
			));
			$form->addHidden("cmd", "submit");
			$form->addEmail("Email Address:", "Email", "", array("required" => 1));
			$form->addButton();
			$form->render();

echo '<pre>' . htmlentities('<?php
$form = new form("email_validation");
$form->setAttributes(array(
	"includesRelativePath" => "../includes",
	"enableSessionAutoFill" => 1,
	"tableAttributes" => array("width" => "400")
));
$form->addHidden("cmd", "submit");
$form->addEmail("Email Address:", "Email", "", array("required" => 1));
$form->addButton();
$form->render();
?>') . '</pre>';
			?>

			<a href="../index.php">Back to Project Home Page</a>
		</body>
	</html>
	<?php
}
?>

