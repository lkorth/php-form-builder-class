<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit_0") {
	$form = new form("captcha_0");
	if($form->validate())
		header("Location: captcha.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Congratulations! The information you enter passed the form's validation."));
	else
		header("Location: captcha.php");
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	$title = "Captcha";
	include("../header.php");
	?>

	<p><b>Captcha</b> - This project leverages reCAPTCHA's anti-bot service to provide captcha functionality.  For more information about this service, visit <a href="http://www.google.com/recaptcha">http://www.google.com/recaptcha</a>.  
	Below you will find a detailed list of the various form attributes that affect the reCAPTCHA integration.</p>

	<ul style="margin: 0;">
		<li>captchaLang - The "captchaLang" form attribute allows you - the developer - to internationalize reCAPTCHA by supplying a two-character language code.  This project uses
		"en" by default which displays text in English.  Supported options include "en" (English), "nl" (Dutch), "fr" (French), "de" (German), "pt" (Portuguese), "ru" (Russian), "es" (Spanish), and "tr" (Turkish).</li>
		<li>captchaPublicKey - reCAPTCHA requires both a public and private key to function properly.  You receive each of these keys during the reCAPTCHA signup process.  By default, these keys are
		only enabled on a specific domain (and all subdomain); however, there is also an option to generate keys that are enabled on all domains.  To provide out-of-the-box functionality,
		this project uses keys that were generated to be enabled accross all domains.  For security, it is recommended that you complete the reCAPTCHA signup process at <a href="https://www.google.com/recaptcha/admin/create">https://www.google.com/recaptcha/admin/create</a>
		and generate keys specific to the domain in which you will be using this project.</li>
		<li>captchaPrivateKey - See previous form attribute, "captchaPublicKey", for more information.</li>
		<li>captchaTheme - This form attribute allows you to modify the look/feel of the reCAPTCHA's container by supplying one of the four pre-defined themes.
		Available options include "red", "white", "blackglass", and "clean".  These themes can be viewed at <a href="http://code.google.com/apis/recaptcha/docs/customization.html">http://code.google.com/apis/recaptcha/docs/customization.html</a>.
		This project sets the "captchaTheme" attribute to "white" by default.</li>
		<li>preventCaptchaLoad - The "preventCaptchaLoad" form attribute is used to prevent reCAPTCHA's javascript file from being included twice.  The only time this attribute is needed would be if you're
		manually including reCAPTCHA's js file separate from this project.  Chances are, you will never have to use this attribute, but it's included just in case.</li>
	</ul>

	<p>When using the addCaptcha function in your forms, there are a few important things to keep in mind.  First, it's essential that you invoke the validate function after the form's data has been submitted.  If you fail to do this, the user's reCAPTCHA solution
	will never be validated.  If you have questions regarding how to use the validate function, you can view this example file's php source code.  The second important thing to keep in mind is that reCAPTCHA only permits one challenge phrase per page.  So, this means
	that you can only use the addCaptcha function once per webpage.  Finally, you can use the javascript function Recaptcha.reload() to force a new reCAPTCHA challenge phrase to be displayed to the user.  This can be helpful if you're using the "ajax" form attribute to
	submit the form's data via AJAX.</p>

	<?php
	$form = new form("captcha_0");
	$form->setAttributes(array(
		"includesPath" => "../includes",
		"width" => 400
	));

	if(!empty($_GET["errormsg_0"]))
		$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

	$form->addHidden("cmd", "submit_0");
	$form->addCaptcha("Captcha:");
	$form->addButton();
	$form->render();

	echo '<pre>', highlight_string('<?php
$form = new form("captcha_0");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 400
));

if(!empty($_GET["errormsg_0"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_0");
$form->addCaptcha("Captcha:");
$form->addButton();
$form->render();
?>', true), '</pre>';

	include("../footer.php");
}
?>

