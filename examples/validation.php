<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0", "submit_1", "submit_2"))) {
	$form = new form("validation_" . substr($_POST["cmd"], -1));
	if($form->validate())
		header("Location: validation.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Congratulations! The information you enter passed the form's validation."));
	else
		header("Location: validation.php");
	exit();
}
elseif(isset($_POST["cmd"]) && $_POST["cmd"] == "submit_3") {
	$form = new form("validation_3");
	if($form->validate())
		echo "Congratulations! The information you enter passed the form's validation.";
	else
		$form->renderAjaxErrorResponse();
	exit();
}

if(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>PHP Form Builder Class | Examples | Validation</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<link href="style.css" rel="stylesheet" type="text/css"/>
			<script type="text/javascript">
				function toggleAlternateEmailAddresses(val) {
					if(val == "1")
						document.getElementById("alternateEmailAddressesDiv").style.display = "block";
					else	
						document.getElementById("alternateEmailAddressesDiv").style.display = "none";
				}
			</script>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / Validation</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">

				<p><b>Validation</b> - Javascript/PHP validation within this project occurs when a form element meets one of four scenarios listed below.</p>
				<ol style="margin: 0;">
					<li>When the "required" element attribute is applied.  The "required" attribute places a red asterisks to the left of the element's label to provide
					a visual notification to the user that this field must be populated.</li>
					<li>The element is of type "email".  Elements added to the form by the addEmail function are checked before (javascript) and after (php) submission to ensure
					they contain an email address that is formatted correctly.</li>
					<li>When the "integer" element attribute is applied.  The "integer" attribute allows only numbers to be typed into textboxes.  Copy-and-paste is allowed, so the
					element's value is checked before (javascript) and after (php) submission to ensure no illegal characters exist.</li>
					<li>When the "alphanumeric" element attribute is applied.  The "alphanumeric" attribute allows only numbers and/or letters to be typed into textboxes.  Copy-and-paste is allowed, so the
					element's value is checked before (javascript) and after (php) submission to ensure no illegal characters exist.</li>
				</ol>
				<p>The first example form provided below demonstrates each of these four scenarios.</p>

				<?php
				$form = new form("validation_0");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 400
				));

				if(!empty($_GET["errormsg_0"]))
					$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

				$form->addHidden("cmd", "submit_0");
				$form->addTextbox("Required Textbox:", "MyRequiredTextbox", "", array("required" => 1));
				$form->addEmail("Email Address:", "MyEmail");
				$form->addTextbox("Textbox w/Integer Validation:", "MyIntegerTextbox", "", array("integer" => 1));
				$form->addTextbox("Textbox w/Alphanumeric Validation:", "MyAlphanumericTextbox", "", array("alphanumeric" => 1));
				$form->addButton();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("validation_0");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 400
));

if(!empty($_GET["errormsg_0"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_0");
$form->addTextbox("Required Textbox:", "MyRequiredTextbox", "", array("required" => 1));
$form->addEmail("Email Address:", "MyEmail");
$form->addTextbox("Textbox w/Integer Validation:", "MyIntegerTextbox", "", array("integer" => 1));
$form->addTextbox("Textbox w/Alphanumeric Validation:", "MyAlphanumericTextbox", "", array("alphanumeric" => 1));
$form->addButton();
$form->render();
?>', true), '</pre>';
				?>

				<p><b>Validation w/Map Attribute</b> - If you're using the "map" form attribute to alter your form's layout, error messages will be displayed at the top of your form, instead of above each appropriate element.
				This prevents the form's structure from being misaligned by the error messages.</p>

				<?php
				$form = new form("validation_1");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 500,
					"noAutoFocus" => 1,
					"map" => array(2, 2, 1, 3)
				));

				if(!empty($_GET["errormsg_1"]))
					$form->errorMsg = filter_var(stripslashes($_GET["errormsg_1"]), FILTER_SANITIZE_SPECIAL_CHARS);

				$form->addHidden("cmd", "submit_1");
				$form->addTextbox("First Name:", "FName", "", array("required" => 1));
				$form->addTextbox("Last Name:", "LName", "", array("required" => 1));
				$form->addEmail("Email Address:", "Email", "", array("required" => 1));
				$form->addTextbox("Phone Number:", "Phone");
				$form->addTextbox("Address:", "Address");
				$form->addTextbox("City:", "City");
				$form->addState("State:", "State");
				$form->addTextbox("Zip Code:", "Zip");
				$form->addButton();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("validation_1");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 500,
	"map" => array(2, 2, 1, 3)
));

if(!empty($_GET["errormsg_1"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_1"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_1");
$form->addTextbox("First Name:", "FName", "", array("required" => 1));
$form->addTextbox("Last Name:", "LName", "", array("required" => 1));
$form->addEmail("Email Address:", "Email", "", array("required" => 1));
$form->addTextbox("Phone Number:", "Phone");
$form->addTextbox("Address:", "Address");
$form->addTextbox("City:", "City");
$form->addState("State:", "State");
$form->addTextbox("Zip Code:", "Zip");
$form->addButton();
$form->render();
?>', true), '</pre>';
				?>

				<p><b>PHP Validation</b> - Unlike javascript, php validation needs to be manually triggered by using the validate
				function after the form's been submitted.  Below, you will see a code snippet of how to properly implement php validation.</p>

				<?php
echo '<pre>', highlight_string('<?php
include("class.form.php");
$form = new form("myform");
if($form->validate()) {
	/*The form\'s submitted data passed validation.  Your script can continue processing 
	the data as necessary.*/
}	
else {
	/*The form failed validation.  Errors have been stored a session array and will be 
	automatically applied when the user is redirected back to the form.*/
	header("Location: myscript.php");
	exit();
}	
?>', true), '</pre>';
				?>

				<p>After class.form.php is included, you'll notice that a new form object instance is created.  The identifier passed to the constructor
				is used to associate the get/post data submitted by the user with the specific form you - the developer - created, so it is essential that
				you pass the same unique identifier used when you initially created the form.  Next, we're ready to invoke the validate function.  This function
				will return true or false depending on if the submitted data passed or failed validation respectively.  If true is returned, your script should
				continue to process the data accordingly.  If false is returned, you will need to redirect the user back to the form so they can correct the 
				validation errors that were found and re-submit.  The validate function stores the errors in a session array that will be automatically applied
				when the user views the form again.</p>

				<p>In the example below, the "preventJSValidation" form attribute is used to disable/bypass javascript validation.  This is applied only to help demonstrate
				php validation.  It is not recommended that you use this form attribute in your development.  I repeat, don't use it on your production forms!</p>

				<?php
				$form = new form("validation_2");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 500,
					"noAutoFocus" => 1,
					"preventJSValidation" => 1,
					"map" => array(2, 2, 1, 3)
				));

				if(!empty($_GET["errormsg_2"]))
					$form->errorMsg = filter_var(stripslashes($_GET["errormsg_2"]), FILTER_SANITIZE_SPECIAL_CHARS);

				$form->addHidden("cmd", "submit_2");
				$form->addTextbox("First Name:", "FName", "", array("required" => 1));
				$form->addTextbox("Last Name:", "LName", "", array("required" => 1));
				$form->addEmail("Email Address:", "Email", "", array("required" => 1));
				$form->addTextbox("Phone Number:", "Phone");
				$form->addTextbox("Address:", "Address");
				$form->addTextbox("City:", "City");
				$form->addState("State:", "State");
				$form->addTextbox("Zip Code:", "Zip");
				$form->addButton();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("validation_2");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 500,
	"preventJSValidation" => 1,
	"map" => array(2, 2, 1, 3)
));

if(!empty($_GET["errormsg_2"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_2"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_2");
$form->addTextbox("First Name:", "FName", "", array("required" => 1));
$form->addTextbox("Last Name:", "LName", "", array("required" => 1));
$form->addEmail("Email Address:", "Email", "", array("required" => 1));
$form->addTextbox("Phone Number:", "Phone");
$form->addTextbox("Address:", "Address");
$form->addTextbox("City:", "City");
$form->addState("State:", "State");
$form->addTextbox("Zip Code:", "Zip");
$form->addButton();
$form->render();
?>', true), '</pre>';
				?>

				<p><b>Validation w/Ajax</b> - When using the "ajax" form attribute to submit the form's data via AJAX, javascript validation is handled no differently
				than without the "ajax" attribute; however, php validation differs slightly.  Review the code snippet below.  Just to clarify, this code is to be applied
				after the form's data has been submitted.</p>

				<?php
echo '<pre>', highlight_string('<?php
include("class.form.php");
$form = new form("myform");
if($form->validate()) {
	/*The form\'s submitted data passed validation.  Your script can continue processing 
	the data as necessary.*/
}	
else {
	/*The form failed validation.  The renderAjaxErrorResponse function is used to generate
	and send back a JSON response which is used to display the appropriate error messages within
	the form\'s elements.*/
	$form->renderAjaxErrorResponse();
}
exit();
?>', true), '</pre>';
				?>

				<p>The only difference between this section and the code snippet provided in the previous example is that the renderAjaxErrorResponse function is used instead of
				simply redirecting the user back to the form with the header function.</p>

				<p>As stated previously, the example below uses the "preventJSValidation" form attribute to disable/bypass javascript validation.  This is applied only to help demonstrate
				php validation.  It is not recommended that you use this form attribute in your development.  I repeat (again), don't use it on your production forms!</p>

				<?php
				$form = new form("validation_3");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 400,
					"noAutoFocus" => 1,
					"ajax" => 1,
					"preventJSValidation" => 1
				));
				$form->addHidden("cmd", "submit_3");
				$form->addEmail("Primary Email Address:", "MyPrimaryEmail", "", array("required" => 1));
				$form->addYesNo("Do you have any alternate email addresses?", "MyYesNo", "", array("onclick" => "toggleAlternateEmailAddresses(this.value);"));

				$subform = new form("validation_3sub");
				$subform->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 400,
				));
				$subform->addEmail("Alternate Email Address #1:", "MyAlternateEmail1");
				$subform->addEmail("Alternate Email Address #2:", "MyAlternateEmail2");
				$subform->addEmail("Alternate Email Address #3:", "MyAlternateEmail3");

				$form->addHTMLExternal('<div id="alternateEmailAddressesDiv" style="display: none; padding-bottom: 1em;">' . $subform->elementsToString() . '</div>');
				$form->bind($subform, 'document.getElementById("validation_3").MyYesNo[0].checked' , '!empty($_POST["MyYesNo"])');
				$form->addButton();
				$form->render();
				?>

				<script type="text/javascript">
					if(document.getElementById("validation_3").MyYesNo[0].checked)
						document.getElementById("alternateEmailAddressesDiv").style.display = "block";
				</script>

				<?php
echo '<pre>', highlight_string('<?php
$form = new form("validation_3");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 400,
	"noAutoFocus" => 1,
	"ajax" => 1,
	"preventJSValidation" => 1
));
$form->addHidden("cmd", "submit_3");
$form->addEmail("Primary Email Address:", "MyPrimaryEmail", "", array("required" => 1));
$form->addYesNo("Do you have any alternate email addresses?", "MyYesNo", "", array("onclick" => "toggleAlternateEmailAddresses(this.value);"));

$subform = new form("validation_3sub");
$subform->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 400,
));
$subform->addEmail("Alternate Email Address #1:", "MyAlternateEmail1");
$subform->addEmail("Alternate Email Address #2:", "MyAlternateEmail2");
$subform->addEmail("Alternate Email Address #3:", "MyAlternateEmail3");

$form->addHTMLExternal(\'<div id="alternateEmailAddressesDiv" style="display: none; padding-bottom: 1em;">\' . $subform->elementsToString() . \'</div>\');
$form->bind($subform, \'document.getElementById("validation_3").MyYesNo[0].checked\' , \'!empty($_POST["MyYesNo"])\');
$form->addButton();
$form->render();
?>

<script type="text/javascript">
	if(document.getElementById("validation_3").MyYesNo[0].checked)
		document.getElementById("alternateEmailAddressesDiv").style.display = "block";
</script>
', true), '</pre>';
				?>
    
			</div>
		</body>	
	</html>	
	<?php
}
?>
