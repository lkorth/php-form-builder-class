<?php
session_start();
error_reporting(E_ALL);
include("../PFBC/Form.php");

if(isset($_POST["form"])) {
	if(PFBC\Form::isValid($_POST["form"])) {
		/*The form's submitted data has been validated.  Your script can now proceed with any 
		further processing required.*/
		header("Location: " . $_SERVER["PHP_SELF"]);
	}
	else {
		/*Validation errors have been found.  We now need to redirect back to the 
		script where your form exists so the errors can be corrected and the form
		re-submitted.*/
		header("Location: " . $_SERVER["PHP_SELF"]);
	}
	exit();
}	

include("../header.php");
?>

<h2 class="first">Validation</h2>
<p>In PFBC, php validation is achieved in a two step process.  The first step is to apply 
validation rules to your form elements via the element's validation property.  And secondly,
you need to call the Form class' isValid static method once the form's data has been submitted.
This function will return true/false.  If false is returned, it indicates that one or more errors
occurred.  You will then need to redirect users back to the form to correct and re-submit.  Check
out the php source of this example file to get a better idea of this workflow.</p>

<?php
$form = new PFBC\Form("validation", 400);
$form->addElement(new PFBC\Element\Hidden("form", "validation"));
$form->addElement(new PFBC\Element\Textbox("Require (required property):", "Required", array(
	"required" => 1,
	"description" => "The required property provides a shortcut for applying the Required class to the element's validation property."
)));
$form->addElement(new PFBC\Element\Textbox("Required (validation property):", "Required2", array(
	"validation" => new PFBC\Validation\Required,
	"description" => "An alternate method for making an element required is to set the validation property to an instance of the Required validation class."
)));
$form->addElement(new PFBC\Element\Email("Email (Email element):", "Email", array(
	"description" => "The Email element class provides a shortcut for adding a Textbox element with the Email validation attached."
)));
$form->addElement(new PFBC\Element\Textbox("Email (Textbox element w/validation property):", "Email2", array(
	"validation" => new PFBC\Validation\Email,
	"description" => "Email validation can also be attach to a Textbox element with the validation property."
)));
$form->addElement(new PFBC\Element\Date("Date (Date element):", "Date", array(
	"description" => "The Date element class provides a shortcut for adding a jQueryUI datepicker with the Date validation attached."
)));
$form->addElement(new PFBC\Element\Textbox("Date (Textbox element w/validation property):", "Date2", array(
	"validation" => new PFBC\Validation\Date,
	"description" => "Date validation can also be attach to a Textbox element with the validation property."
)));
$form->addElement(new PFBC\Element\Textbox("Multiple Validation Rules (Textbox element w/Required and Email validation):", "RequiredEmail", array(
	"validation" => array(
		new PFBC\Validation\Required,
		new PFBC\Validation\Email
	),
	"description" => "Multiple validation rules can be attached to an element by passing the validation property an array of validation class instances."
)));
$form->addElement(new PFBC\Element\Textbox("Regular Expression:", "RegularExpression", array(
	"validation" => new PFBC\Validation\RegExp("/pfbc/", "Error: The %element% field must contain following keyword - \"pfbc\"."),
	"description" => "The RegExp validation class provides the means to apply custom validation to an element.  Its constructor includes two parameters: the regular expression pattern to test and the error message to display if the pattern is not matched."
)));
$form->addElement(new PFBC\Element\Textbox("Numeric:", "Numeric", array(
	"validation" => new PFBC\Validation\Numeric,
	"description" => "The Numberic validation class will verify that the element's submitted value is numeric.  See php's is_numeric function for details."
)));
$form->addElement(new PFBC\Element\Textbox("Url:", "Url", array(
	"validation" => new PFBC\Validation\Url,
	"description" => "The Url validation class will verify that the element's submitted value is a url.  See php's filter_var function (w/FILTER_VALIDATE_URL flag) for details."
)));
$form->addElement(new PFBC\Element\Textbox("AlphaNumeric:", "AlphaNumberic", array(
	"validation" => new PFBC\Validation\AlphaNumeric,
	"description" => "The AlphaNumeric validation class will verify that the element's submitted value contains only letters, numbers, underscores, and/or hyphens."
)));
$form->addElement(new PFBC\Element\Button);
$form->render();

echo '<pre>', highlight_string('<?php
$form = new PFBC\Form("validation", 400);
$form->addElement(new PFBC\Element\Hidden("form", "validation"));
$form->addElement(new PFBC\Element\Textbox("Require (required property):", "Required", array(
	"required" => 1
)));
$form->addElement(new PFBC\Element\Textbox("Required (validation property):", "Required2", array(
	"validation" => new PFBC\Validation\Required
)));
$form->addElement(new PFBC\Element\Email("Email (Email element):", "Email"));
$form->addElement(new PFBC\Element\Textbox("Email (Textbox element w/validation property):", "Email2", array(
	"validation" => new PFBC\Validation\Email
)));
$form->addElement(new PFBC\Element\Date("Date (Date element):", "Date"));
$form->addElement(new PFBC\Element\Textbox("Date (Textbox element w/validation property):", "Date2", array(
	"validation" => new PFBC\Validation\Date
)));
$form->addElement(new PFBC\Element\Textbox("Multiple Validation Rules (Textbox element w/Required and Email validation):", "RequiredEmail", array(
	"validation" => array(
		new PFBC\Validation\Required,
		new PFBC\Validation\Email
	)
)));
$form->addElement(new PFBC\Element\Textbox("Regular Expression:", "RegularExpression", array(
	"validation" => new PFBC\Validation\RegExp("/pfbc/", "Error: The %element% field must contain following keyword - \"pfbc\".")
)));
$form->addElement(new PFBC\Element\Textbox("Numeric:", "Numeric", array(
	"validation" => new PFBC\Validation\Numeric
)));
$form->addElement(new PFBC\Element\Textbox("Url:", "Url", array(
	"validation" => new PFBC\Validation\Url
)));
$form->addElement(new PFBC\Element\Textbox("AlphaNumeric:", "AlphaNumberic", array(
	"validation" => new PFBC\Validation\AlphaNumeric
)));
$form->addElement(new PFBC\Element\Textbox("Date:", "Date", array(
	"validation" => new PFBC\Validation\Date
)));
$form->addElement(new PFBC\Element\Button);
$form->render();
?>', true), '</pre>';

include("../footer.php");
?>
