<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit") {
	$form = new form("ajax_captcha");

	header("Content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
	echo "<response>";

	if($form->validate()) {
		echo "<status>Success</status>";
		echo "<message>reCAPTCHA Answered Correctly</message>";
	}	
	else {
		echo "<status>Error</status>";
		echo "<message>reCAPTCHA Answered Incorrectly - Error: ", $form->errorMsg, ".\n\nA new reCAPTCHA challenge phrase will be provided.  Please retry.</message>";
	}

	echo "</response>";
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>PHP Form Builder Class | Examples | Captcha and Ajax</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<link href="style.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / Captcha and Ajax</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>reCAPTCHA and Ajax</b> - When you submit the captcha form element via ajax, the reCAPTCHA challenge will not refresh on its own because the webpage does not reload.
				To force the reCAPTCHA challenge to reset once the form is submitted, the Recaptcha.reload() javascript method will need to be invoked.  In this example, the <i>ajaxCallback</i>
				form attribute has been set to a js function, reCAPTCHAHandler, which alerts a response message, reloads reCAPTCHA, and resets the form if appropriate.</p>

				<?php
				$form = new form("ajax_captcha");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => "400",
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
					function reCAPTCHAHandler(msg) {
						var response = msg.getElementsByTagName("response")[0];
						alert(response.getElementsByTagName("message")[0].firstChild.data);

						/*This line resets the reCAPTCHA challenge.*/
						Recaptcha.reload();

						if(response.getElementsByTagName("status")[0].firstChild.data == "Success")
							document.ajax_captcha.reset();
					}
				</script>	
				<?php

echo '<pre>', highlight_string('<?php
$form = new form("ajax_captcha");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => "400",
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
	function reCAPTCHAHandler(msg) {
		var response = msg.getElementsByTagName("response")[0];
		alert(response.getElementsByTagName("message")[0].firstChild.data);

		/*This line resets the reCAPTCHA challenge.*/
		Recaptcha.reload();

		if(response.getElementsByTagName("status")[0].firstChild.data == "Success")
			document.ajax_captcha.reset();
	}
</script>', true), '</pre>';	

				?>
			</div>	
		</body>
	</html>	
	<?php
}
?>

