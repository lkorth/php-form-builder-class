<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0", "submit_1", "submit_2", "submit_4"))) {
	$form = new form("validation_" . substr($_POST["cmd"], -1));
	if($form->validate()) {
		//The form has passed validation.  We can now move forward with any necessary processing.
		$form->setError("Congratulations! The information you enter passed the form's validation.");
	}
	else {
		/*One or more validation errors were found.  These errors have been saved in the session 
		and will automatically be displayed after redirecting back to the form.*/ 
	}	

	header("Location: validation.php");
	exit();
}
elseif(isset($_POST["cmd"]) && $_POST["cmd"] == "submit_3") {
	$form = new form("validation_3");
	if($form->validate()) {
		//The form has passed validation.  We can now move forward with any necessary processing.
		echo "Congratulations! The information you enter passed the form's validation.";
	}	
	else {
		/*One or more validation errors were found.  The renderAjaxErrorResponse function formats the
		errors in a json response and sends them back to the browser so the user can corrent and re-submit
		their form data.*/
		$form->renderAjaxErrorResponse();
	}	
	exit();
}
elseif(isset($_POST["cmd"]) && $_POST["cmd"] == "submit_5") {
	$form = new form("validation_5");
	/*Passing false to the validate function prevents the form's values from being cleared from the session.
	This allows any additional validation to be performed.*/
	if($form->validate(false)) {
		if($_POST["Password"] != $_POST["ConfirmPassword"]) {
			/*The setError function allows you to apply an error message to a specific form element.  Simply
			pass the element's name as the second parameter.*/
			$form->setError("Error: This field does not match the password you provided above.", "ConfirmPassword");
		}
		else {
			/*Once all additional validation has been completed, the clearValues function is used to prevent any
			values stored in the session from being auto-populated when the user returns to the form.*/
			$form->clearValues();
			$form->setError("Congratulations! The information you enter passed the form's validation.");
		}
	}	

	header("Location: validation.php");
	exit();
}

if(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	$title = "Validation";
	include("../header.php");
	?>

	<p><b>Validation</b> - Javascript/PHP validation within this project occurs when a form element meets one of six scenarios listed below.</p>
	<ol style="margin: 0;">
		<li>When the "required" element attribute is applied.  The "required" attribute places a red asterisks to the left of the element's label to provide
		a visual notification to the user that this field must be populated.</li>
		<li>The element is of type "captcha".  Elements added to the form by the addCaptcha function are checked after (php) submission to ensure
		the reCAPTCHA challenge phrase was answered correctly.</li>
		<li>The element is of type "email".  Elements added to the form by the addEmail function are checked before (javascript) and after (php) submission to ensure
		they contain an email address that is formatted correctly.</li>
		<li>When the "integer" element attribute is applied.  The "integer" attribute allows only plus/minus signs and numbers to be typed into textboxes.  Copy-and-paste is allowed, so the
		element's value is checked before (javascript) and after (php) submission to ensure no illegal characters exist.</li>
		<li>When the "float" element attribute is applied.  The "float" attribute allows only plus/minus signs, numbers, and decimal points to be typed into textboxes.  Copy-and-paste is allowed, so the
		element's value is checked before (javascript) and after (php) submission to ensure no illegal characters exist.</li>
		<li>When the "alphanumeric" element attribute is applied.  The "alphanumeric" attribute allows only numbers and/or letters to be typed into textboxes.  Copy-and-paste is allowed, so the
		element's value is checked before (javascript) and after (php) submission to ensure no illegal characters exist.</li>
	</ol>
	<p>The first example form provided below demonstrates each of these five scenarios.</p>

	<?php
	$form = new form("validation_0", 400);
	$form->addHidden("cmd", "submit_0");
	$form->addTextbox("Required Textbox:", "MyRequiredTextbox", "", array("required" => 1));
	$form->addCaptcha("Captcha:");
	$form->addEmail("Email Address:", "MyEmail");
	$form->addTextbox("Textbox w/Integer Validation:", "MyIntegerTextbox", "", array("integer" => 1, "postHTML" => '<div class="pfbc-small">Use copy-and-paste to insert invalid characters and trigger validation errors.</div>'));
	$form->addTextbox("Textbox w/Float Validation:", "MyFloatTextbox", "", array("float" => 1, "postHTML" => '<div class="pfbc-small">Use copy-and-paste to insert invalid characters and trigger validation errors.</div>'));
	$form->addTextbox("Textbox w/Alphanumeric Validation:", "MyAlphanumericTextbox", "", array("alphanumeric" => 1, "postHTML" => '<div class="pfbc-small">Use copy-and-paste to insert invalid characters and trigger validation errors.</div>'));
	$form->addButton();
	$form->render();

	echo '<pre>', highlight_string('<?php
$form = new form("validation_0", 400);
$form->addHidden("cmd", "submit_0");
$form->addTextbox("Required Textbox:", "MyRequiredTextbox", "", array("required" => 1));
$form->addEmail("Email Address:", "MyEmail");
$form->addTextbox("Textbox w/Integer Validation:", "MyIntegerTextbox", "", array("integer" => 1, "postHTML" => \'<div class="pfbc-small">Use copy-and-paste to insert invalid characters and trigger validation errors.</div>\'));
$form->addTextbox("Textbox w/Float Validation:", "MyFloatTextbox", "", array("float" => 1, "postHTML" => \'<div class="pfbc-small">Use copy-and-paste to insert invalid characters and trigger validation errors.</div>\'));
$form->addTextbox("Textbox w/Alphanumeric Validation:", "MyAlphanumericTextbox", "", array("alphanumeric" => 1, "postHTML" => \'<div class="pfbc-small">Use copy-and-paste to insert invalid characters and trigger validation errors.</div>\'));
$form->addButton();
$form->render();
?>', true), '</pre>';
	?>

	<p><b>Validation w/Map Attribute</b> - If you're using the "map" form attribute to alter your form's layout, error messages will be displayed at the top of your form, instead of above each appropriate element.
	This prevents the form's structure from being misaligned by the error messages.</p>

	<?php
	$form = new form("validation_1", 500);
	$form->setAttributes(array(
		"noAutoFocus" => 1,
		"preventJQueryLoad" => 1,
		"preventJQueryUILoad" => 1,
		"map" => array(2, 2, 1, 3)
	));
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
$form = new form("validation_1", 500);
$form->setAttributes(array(
	"map" => array(2, 2, 1, 3)
));
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
	$form = new form("validation_2", 500);
	$form->setAttributes(array(
		"noAutoFocus" => 1,
		"preventJQueryLoad" => 1,
		"preventJQueryUILoad" => 1,
		"preventJSValidation" => 1,
		"map" => array(2, 2, 1, 3)
	));
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
$form = new form("validation_2", 500);
$form->setAttributes(array(
	"preventJSValidation" => 1,
	"map" => array(2, 2, 1, 3)
));
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
	$form = new form("validation_3", 400);
	$form->setAttributes(array(
		"noAutoFocus" => 1,
		"preventJQueryLoad" => 1,
		"preventJQueryUILoad" => 1,
		"ajax" => 1,
		"preventJSValidation" => 1
	));
	$form->addHidden("cmd", "submit_3");
	$form->addEmail("Primary Email Address:", "MyPrimaryEmail", "", array("required" => 1));
	$form->addYesNo("Do you have any alternate email addresses?", "MyYesNo", "", array("onclick" => "toggleAlternateEmailAddresses(this.value);"));
	$form->addHTMLExternal('<div id="alternateEmailAddressesDiv" style="display: none; padding-bottom: 1em;">');
	$form->addEmail("Alternate Email Address #1:", "MyAlternateEmail1");
	$form->addEmail("Alternate Email Address #2:", "MyAlternateEmail2");
	$form->addEmail("Alternate Email Address #3:", "MyAlternateEmail3");
	$form->addHTMLExternal('</div>');
	$form->addButton();
	$form->render();
	?>

	<script type="text/javascript">
		function toggleAlternateEmailAddresses(val) {
			if(val == "1")
				document.getElementById("alternateEmailAddressesDiv").style.display = "block";
			else	
				document.getElementById("alternateEmailAddressesDiv").style.display = "none";
		}

		if(document.getElementById("validation_3").MyYesNo[0].checked)
			document.getElementById("alternateEmailAddressesDiv").style.display = "block";
	</script>

	<?php
	echo '<pre>', highlight_string('<?php
$form = new form("validation_3", 400);
$form->setAttributes(array(
	"ajax" => 1,
	"preventJSValidation" => 1
));
$form->addHidden("cmd", "submit_3");
$form->addEmail("Primary Email Address:", "MyPrimaryEmail", "", array("required" => 1));
$form->addYesNo("Do you have any alternate email addresses?", "MyYesNo", "", array("onclick" => "toggleAlternateEmailAddresses(this.value);"));
$form->addHTMLExternal(\'<div id="alternateEmailAddressesDiv" style="display: none; padding-bottom: 1em;">\');
$form->addEmail("Alternate Email Address #1:", "MyAlternateEmail1");
$form->addEmail("Alternate Email Address #2:", "MyAlternateEmail2");
$form->addEmail("Alternate Email Address #3:", "MyAlternateEmail3");
$form->addHTMLExternal(\'</div>\');
$form->addButton();
$form->render();
?>

<script type="text/javascript">
	function toggleAlternateEmailAddresses(val) {
		if(val == "1")
			document.getElementById("alternateEmailAddressesDiv").style.display = "block";
		else	
			document.getElementById("alternateEmailAddressesDiv").style.display = "none";
	}

	if(document.getElementById("validation_3").MyYesNo[0].checked)
		document.getElementById("alternateEmailAddressesDiv").style.display = "block";
</script>
', true), '</pre>';
	?>

	<p><b>Modifying Error Messages</b> - Each of the five validation error types (see top section of this page for detailed list) generates its own error message explaining
	what happened to the user so he/she can correct and re-submit.  There are five form attributes - "errorMsgFormat", "emailErrorMsgFormat", "integerErrorMsgFormat", 
	"floatErrorMsgFormat", and "alphanumericErrorMsgFormat" - that can be used to customize each of these error messages.  If "[LABEL]" is found within the error message, it will be replaced
	by the appropriate element's label.</p>

	<?php
	$form = new form("validation_4", 400);
	$form->setAttributes(array(
		"noAutoFocus" => 1,
		"preventJQueryLoad" => 1,
		"preventJQueryUILoad" => 1,
		"errorMsgFormat" => "Oops! You didn't fill in the [LABEL] field.",
		"emailErrorMsgFormat" => "You didn't supply a valid email address in the [LABEL] field.",
		"integerErrorMsgFormat" => "[LABEL] can only contain numbers. No letters or special character allowed!",
		"floatErrorMsgFormat" => "[LABEL] can only contain float/decimal numbers. No letters or special character allowed!",
		"alphanumericErrorMsgFormat" => "There were invalid character found in this field.  [LABEL] can only contain letters and/or numbers."
	));
	$form->addHidden("cmd", "submit_4");
	$form->addTextbox("Required Textbox:", "MyRequiredTextbox", "", array("required" => 1));
	$form->addEmail("Email Address:", "MyEmail");
	$form->addTextbox("Textbox w/Integer Validation:", "MyIntegerTextbox", "", array("integer" => 1, "postHTML" => '<div class="pfbc-small">Use copy-and-paste to insert invalid characters and trigger validation errors.</div>'));
	$form->addTextbox("Textbox w/Float Validation:", "MyFloatTextbox", "", array("float" => 1, "postHTML" => '<div class="pfbc-small">Use copy-and-paste to insert invalid characters and trigger validation errors.</div>'));
	$form->addTextbox("Textbox w/Alphanumeric Validation:", "MyAlphanumericTextbox", "", array("alphanumeric" => 1, "postHTML" => '<div class="pfbc-small">Use copy-and-paste to insert invalid characters and trigger validation errors.</div>'));
	$form->addButton();
	$form->render();

	echo '<pre>', highlight_string('<?php
$form = new form("validation_4", 400);
$form->setAttributes(array(
	"errorMsgFormat" => "Oops! You didn\'t fill in the [LABEL] field.",
	"emailErrorMsgFormat" => "You didn\'t supply a valid email address in the [LABEL] field.",
	"integerErrorMsgFormat" => "[LABEL] can only contain numbers. No letters or special character allowed!",
	"floatErrorMsgFormat" => "[LABEL] can only contain float/decimal numbers. No letters or special character allowed!",
	"alphanumericErrorMsgFormat" => "There were invalid character found in this field.  [LABEL] can only contain letters and/or numbers."
));
$form->addHidden("cmd", "submit_4");
$form->addTextbox("Required Textbox:", "MyRequiredTextbox", "", array("required" => 1));
$form->addEmail("Email Address:", "MyEmail");
$form->addTextbox("Textbox w/Integer Validation:", "MyIntegerTextbox", "", array("integer" => 1, "postHTML" => \'<div class="pfbc-small">Use copy-and-paste to insert invalid characters and trigger validation errors.</div>\'));
$form->addTextbox("Textbox w/Float Validation:", "MyFloatTextbox", "", array("float" => 1, "postHTML" => \'<div class="pfbc-small">Use copy-and-paste to insert invalid characters and trigger validation errors.</div>\'));
$form->addTextbox("Textbox w/Alphanumeric Validation:", "MyAlphanumericTextbox", "", array("alphanumeric" => 1, "postHTML" => \'<div class="pfbc-small">Use copy-and-paste to insert invalid characters and trigger validation errors.</div>\'));
$form->addButton();
$form->render();
?>', true), '</pre>';
?>

	<p><b>Custom Validation</b> - Below you will find an example of how custom validation can be applied after your form's data has been submitted.
	Passing boolean false to the validate function will prevent the submitted data from clearing within the php session and will allow the form's
	elements to be auto-populated if a custom validation error is discovered.  If no validation errors are found, use the clearValues to
	prevent the form's data from being auto-populated when the user returns to the form.  The setError function has two parameters - the first for 
	providing an error message, and the second option parameter for specifying an element name to attach the error above.  If the second parameter
	isn't provided, the error message will be displayed at the top of the form.</p>

	<?php
	$form = new form("validation_5", 400);
	$form->setAttributes(array(
		"map" => array(1, 2),
		"noAutoFocus" => 1,
		"preventJQueryLoad" => 1,
		"preventJQueryUILoad" => 1
	));
	$form->addHidden("cmd", "submit_5");
	$form->addTextbox("Username:", "Username", "", array("required" => 1));
	$form->addPassword("Password:", "Password", "", array("required" => 1));
	$form->addPassword("Confirm Password:", "Password", "", array("required" => 1));
	$form->addButton("Signup");
	$form->render();

	echo '<pre>', highlight_string('<?php
if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit_5") {
	$form = new form("validation_5");
	/*Passing false to the validate function prevents the form\'s values from being cleared from the session.
	This allows any additional validation to be performed.*/
	if($form->validate(false)) {
		if($_POST["Password"] != $_POST["ConfirmPassword"]) {
			/*The setError function allows you to apply an error message to a specific form element.  Simply
			pass the element\'s name as the second parameter.*/
			$form->setError("Error: This field does not match the password you provided above.", "ConfirmPassword");
		}
		else {
			/*Once all additional validation has been completed, the clearValues function is used to prevent any
			values stored in the session from being auto-populated when the user returns to the form.*/
			$form->clearValues();
			$form->setError("Congratulations! The information you enter passed the form\'s validation.");
		}
	}	

	header("Location: validation.php");
	exit();
}

$form = new form("validation_5", 400);
$form->setAttributes(array(
	"map" => array(1, 2)
));
$form->addHidden("cmd", "submit_5");
$form->addTextbox("Username:", "Username", "", array("required" => 1));
$form->addPassword("Password:", "Password", "", array("required" => 1));
$form->addPassword("Confirm Password:", "Password", "", array("required" => 1));
$form->addButton();
$form->render();
?>', true), '</pre>';

	include("../footer.php");
}
?>
