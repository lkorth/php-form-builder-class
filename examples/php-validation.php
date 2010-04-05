<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit")
{
	$form = new form("php_validation");
	if($form->validate())
		$msg = "Congratulations! The information you enter passed the form's validation.";
	else
		$msg = "Oops! The information you entered did not pass the form's validation.  Please review the following error message and re-try - " . $form->errorMsg;

	header("Location: php-validation.php?error_message=" . urlencode($msg));
	exit();
}

if(!empty($_GET["error_message"]))
	echo("<div style='text-align: center; font-weight: bold; color: #990000;'>" . htmlentities(stripslashes($_GET["error_message"])) . "</div>");

if(!isset($_GET["cmd"]) && !isset($_POST["cmd"]))
{
	?>
	<html>
		<head>
			<title>PHP Form Builder Class | Examples | PHP Validation</title>
		</head>	
		<body>
			<h2 style="text-align: center; margin: 0; padding: 0;">PHP Form Builder Class</h2>
			<h5 style="text-align: center; margin: 0; padding: 0;"><span style="padding-right: 10px;">Author: Andrew Porterfield</span><span style="padding-right: 10px;">Released: <?php echo(file_get_contents('../release'));?></span><span>Version: <?php echo(file_get_contents('../version'));?></span></h5>
			<div style="text-align: center; padding-bottom: 10px;"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">View Project's Homepage</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Latest Stable Release</a></div>
			<a href="../index.php">Back to Project Home Page</a>
			<p><b>PHP Validation</b> - After the form has been submitted, the validate() function can be used to verify that all required fields have been properly filled in and that
			the captcha solution is correct, if applicable.</p>

			<p>This functionality requires that a session be started on the page where the form is being built and validated.  Simply call session_start() at the top of your page and 
			you will be all set.</p>

			<p>Also, if you look in the php souce code of this example, you will notice that I'm passing a unique identifier when creating a new instance of the form class.  That line 
			looks like this - $form = new form("php_validation");.  After the form is submitted, you will see the exact same line before the validate() function is used.  These 
			identifiers must match exactly for the validation to function properly.</p>

			<p>An optional form attribute, <i>enableSessionAutoFill</i>, can be specified in the setAttributes() function after creating a new instance of the form class.  If this parameter 
			is set, the form's submitted values will be stored in the session and recalled if the form is rendered again after an error.  When the form is successfully validated, these session values will be removed.  By default, this parameter is not enabled.</p>

			<?php
			$form = new form("php_validation");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes",
				"tableAttributes" => array("width" => "400"),
				"enableSessionAutoFill" => 1
			));
			$form->addHidden("cmd", "submit");
			$form->addTextbox("Required Textbox:", "field0", "", array("required" => 1));
			$form->addDate("Required Date:", "field1", "", array("required" => 1));
			$form->addWebEditor("Required Web Editor:", "field2", "", array("required" => 1));
			$form->addCaptcha("Captcha:");
			$form->addButton();
			$form->render();

echo '<pre>' . htmlentities('<?php
$form = new form("php_validation");
$form->setAttributes(array(
	"includesRelativePath" => "../includes",
	"tableAttributes" => array("width" => "400"),
	"enableSessionAutoFill" => 1
));
$form->addHidden("cmd", "submit");
$form->addTextbox("Required Textbox:", "field0", "", array("required" => 1));
$form->addDate("Required Date:", "field1", "", array("required" => 1));
$form->addWebEditor("Required Web Editor:", "field2", "", array("required" => 1));
$form->addCaptcha("Captcha:");
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
