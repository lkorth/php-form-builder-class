<?php
session_start();
error_reporting(E_ALL);
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit")
{
	$form = new form("captcha");
	if($form->validate())
		$msg = "Congratulations! The information you enter passed the form's validation.";
	else
		$msg = "Oops! The information you entered did not pass the form's validation.  Please review the following error message and re-try - " . $form->errorMsg;

	header("Location: captcha.php?error_message=" . urlencode($msg));
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"]))
{
	?>
	<html>
		<head>
			<title>PHP Form Builder Class | Examples | Captcha</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/" target="_blank">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2>PHP Form Builder Class / Examples / Captcha</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Captcha</b> - The captcha form element, which integrates reCAPTCHA, is different than many of the other form elements within the form builder class in several ways.
				The first difference is that the captcha element can only be used once per webpage, which is a reCAPTCHA restriction.  If two or more captcha elements are attached to a form,
				the additional captchas will be ignored.  A second difference exists in how the captcha element is attached to a form.  The addCaptcha method has the following format -
				addCaptcha($label="", $additionalParams="").  The $name and $value parameters that exist for many of the other form elements are excluded because reCAPTCHA hardcodes the $name to
				"recaptcha_response_field" and there is no need to assign the $value parameter as reCAPTCHA cycles a new pair of challenge words with each page load.</p>

				<p>This functionality requires that a session be started on the page where the form is being built and validated.  Simply call session_start() at the top of your page and 
				you will be all set.</p>

				<p>Also, if you look in the php souce code of this example, you will notice that I'm passing a unique identifier when creating a new instance of the form class.  That line 
				looks like this - $form = new form("captcha");.  After the form is submitted, you will see the exact same line before the validate() function is used.  These 
				identifiers must match exactly for the validation to function properly.</p>

				<p>reCAPTCHA and Ajax - If you are placing the captcha form element in a form submitting via ajax, check out the <a href="captcha-ajax.php" target="_blank">reCAPTCHA ajax example</a> for further instructions.</p>

				<p>The <i>captchaTheme</i> form attribute allows the look and feel of reCAPTCHA to be cumstomized.  By default, the white theme will be applied.  Click the links below to view different reCAPTCHA themes.<br>
				<a href="captcha.php?theme=white">white</a>, <a href="captcha.php?theme=red">red</a>, <a href="captcha.php?theme=blackglass">blackglass</a>, or <a href="captcha.php?theme=clean">clean</a></p>

				<p>The <i>captchaLang</i> attribute allows the language of reCAPTCHA to be cumstomized.  By default, English will be used - <a href="http://recaptcha.net/apidocs/captcha/client.html" target="_blank">View reCAPTCHA's Supported Languages</a>.</p>

				<?php
				if(!empty($_GET["error_message"]))
					echo("<div style='text-align: center; font-weight: bold; color: #990000;'>" . htmlentities(stripslashes($_GET["error_message"])) . "</div>");
				
				$captchaTheme = "white";
				if(!empty($_GET["theme"]))
					$captchaTheme = $_GET["theme"];

				$form = new form("captcha");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"tableAttributes" => array("width" => "400"),
					"captchaTheme" => $captchaTheme
				));
				$form->addHidden("cmd", "submit");
				$form->addTextarea("Comments:", "field0");
				$form->addCaptcha();
				$form->addButton();
				$form->render();

echo '<pre>' . htmlentities('<?php
$captchaTheme = "white";
if(!empty($_GET["theme"]))
	$captchaTheme = $_GET["theme"];

$form = new form("captcha");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"tableAttributes" => array("width" => "400"),
	"captchaTheme" => $captchaTheme
));
$form->addHidden("cmd", "submit");
$form->addTextarea("Comments:", "field0");
$form->addCaptcha();
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

