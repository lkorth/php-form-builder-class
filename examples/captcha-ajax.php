<?php
session_start();
error_reporting(E_ALL);
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit")
{
	$form = new form("ajax_captcha");

	header("Content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
	echo "<response>";

	if($form->validate())
	{
		echo "<status>Success</status>";
		echo "<message>reCAPTCHA Answered Correctly</message>";
	}	
	else
	{
		echo "<status>Error</status>";
		echo "<message>reCAPTCHA Answered Incorrectly - Error: ", $form->errorMsg, ".\n\nA new reCAPTCHA challenge phrase will be provided.  Please retry.</message>";
	}

	echo "</response>";
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"]))
{
	?>
	<html>
		<head>
			<title>PHP Form Builder Class | Examples | Captcha and Ajax</title>
		</head>
		<body>
			<h2 style="text-align: center; margin: 0; padding: 0;">PHP Form Builder Class</h2>
			<h5 style="text-align: center; margin: 0; padding: 0;"><span style="padding-right: 10px;">Author: Andrew Porterfield</span><span style="padding-right: 10px;">Released: <?php echo(file_get_contents('../release'));?></span><span>Version: <?php echo(file_get_contents('../version'));?></span></h5>
			<div style="text-align: center; padding-bottom: 10px;"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">View Project's Homepage</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Latest Stable Release</a></div>
			<a href="../index.php">Back to Project Home Page</a>
			<p>
			<b>reCAPTCHA and Ajax</b> - When you submit the captcha form element via ajax, the reCAPTCHA challenge will not refresh on its own because the webpage does not reload.
			To force the reCAPTCHA challenge to reset once the form is submitted, the Recaptcha.reload() javascript method will need to be envoked.  In this example, the <i>ajaxCallback</i>
			form attribute has been set to a js function, reCAPTCHAHandler, which alerts a response message, reloads reCAPTCHA, and resets the form if appropriate.
			</p>

			<?php
			$form = new form("ajax_captcha");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes",
				"tableAttributes" => array("width" => "400"),
				"ajax" => 1,
				"ajaxCallback" => "reCAPTCHAHandler",
				"ajaxDataType" => "xml"
			));
			$form->addHidden("cmd", "submit");
			$form->addTextarea("Comments:", "field0");
			$form->addCaptcha();
			$form->addButton();
			$form->render();
			?>
			<a href="../index.php">Back to Project Home Page</a>

			<script type="text/javascript">
				function reCAPTCHAHandler(msg)
				{
					var response = msg.getElementsByTagName("response")[0];
					alert(response.getElementsByTagName("message")[0].firstChild.data);

					/*This line resets the reCAPTCHA challenge.*/
					Recaptcha.reload();

					if(response.getElementsByTagName("status")[0].firstChild.data == "Success")
						document.ajax_captcha.reset();
				}
			</script>	

			<?
echo '<pre>' . htmlentities('<?php
$form = new form("ajax_captcha");
$form->setAttributes(array(
	"includesRelativePath" => "../includes",
	"tableAttributes" => array("width" => "400"),
	"ajax" => 1,
	"ajaxCallback" => "reCAPTCHAHandler",
	"ajaxDataType" => "xml"
));
$form->addHidden("cmd", "submit");
$form->addTextarea("Comments:", "field0");
$form->addCaptcha();
$form->addButton();
$form->render();
?>

<script type="text/javascript">
	function reCAPTCHAHandler(msg)
	{
		var response = msg.getElementsByTagName("response")[0];
		alert(response.getElementsByTagName("message")[0].firstChild.data);

		/*This line resets the reCAPTCHA challenge.*/
		Recaptcha.reload();

		if(response.getElementsByTagName("status")[0].firstChild.data == "Success")
			document.ajax_captcha.reset();
	}
</script>') . '</pre>';	
?>
		</body>
	</html>	
	<?php
}
?>

