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

<h2 class="first">Selecting Element Values</h2>
<p>This project provides two ways for setting an element's value.  The first is 
use the final parameter in the appropriate element's constructor, which allows 
a variety of element properties to be set through an associative array.  The keys 
of this array correspond with element property names.  In this case, "value" is the 
property we're setting.</p>

<?php
$options = array("Option #1", "Option #2", "Option #3");
$form = new PFBC\Form("setting-element-values", 400);
$form->addElement(new PFBC\Element\Hidden("form", "elements"));
$form->addElement(new PFBC\Element\Textbox("Textbox:", "Textbox", array(
	"value" => "My Textbox's Value"
)));
$form->addElement(new PFBC\Element\Textarea("Textarea:", "Textarea", array(
	"value" => "My Textarea's Value"
	)));
$form->addElement(new PFBC\Element\Select("Select:", "Select", $options, array(
	"value" => "Option #2"
)));
$form->addElement(new PFBC\Element\Radio("Radio:", "Radio", $options, array(
	"value" => "Option #2"
)));
$form->addElement(new PFBC\Element\Checkbox("Checkbox:", "Checkbox", $options, array(
	"value" => array("Option #1", "Option #3")
)));
$form->addElement(new PFBC\Element\Button);
$form->render();

echo '<pre>', highlight_string('<?php
$options = array("Option #1", "Option #2", "Option #3");
$form = new PFBC\Form("setting-element-values", 400);
$form->addElement(new PFBC\Element\Hidden("form", "elements"));
$form->addElement(new PFBC\Element\Textbox("Textbox:", "Textbox", array(
	"value" => "My Textbox\'s Value"
)));
$form->addElement(new PFBC\Element\Textarea("Textarea:", "Textarea", array(
	"value" => "My Textarea\'s Value"
	)));
$form->addElement(new PFBC\Element\Select("Select:", "Select", $options, array(
	"value" => "Option #2"
)));
$form->addElement(new PFBC\Element\Radio("Radio:", "Radio", $options, array(
	"value" => "Option #1"
)));
$form->addElement(new PFBC\Element\Checkbox("Checkbox:", "Checkbox", $options, array(
	"value" => array("Option #1", "Option #3")
)));
$form->addElement(new PFBC\Element\Button);
$form->render();
$form->render();
?>', true), '</pre>';
?>

<p>The second way is to use the form's setValues method, which allows the values 
of multiple elements to be set at the same time through an associative array.  
The keys of this array correspond with your form's element names.</p>

<?php
$form = new PFBC\Form("setting-element-values2", 400);
$form->configure(array(
	"prevent" => array("focus", "jQuery", "jQueryUI")
));
$form->setValues(array(
	"Textbox" => "My Textbox's Value",
	"Textarea" => "My Textarea's Value",
	"Select" => "Option #2",
	"Radio" => "Option #2",
	"Checkbox" => array("Option #1", "Option #3")
));
$form->addElement(new PFBC\Element\Hidden("form", "elements"));
$form->addElement(new PFBC\Element\Textbox("Textbox:", "Textbox"));
$form->addElement(new PFBC\Element\Textarea("Textarea:", "Textarea"));
$form->addElement(new PFBC\Element\Select("Select:", "Select", $options));
$form->addElement(new PFBC\Element\Radio("Radio:", "Radio", $options));
$form->addElement(new PFBC\Element\Checkbox("Checkbox:", "Checkbox", $options));
$form->addElement(new PFBC\Element\Button);
$form->render();

echo '<pre>', highlight_string('<?php
$form = new PFBC\Form("setting-element-values2", 400);
$form->setValues(array(
	"Textbox" => "My Textbox\'s Value",
	"Textarea" => "My Textarea\'s Value",
	"Select" => "Option #2",
	"Radio" => "Option #2",
	"Checkbox" => array("Option #1", "Option #3")
));
$form->addElement(new PFBC\Element\Hidden("form", "elements"));
$form->addElement(new PFBC\Element\Textbox("Textbox:", "Textbox"));
$form->addElement(new PFBC\Element\Textarea("Textarea:", "Textarea"));
$form->addElement(new PFBC\Element\Select("Select:", "Select", $options));
$form->addElement(new PFBC\Element\Radio("Radio:", "Radio", $options));
$form->addElement(new PFBC\Element\Checkbox("Checkbox:", "Checkbox", $options));
$form->addElement(new PFBC\Element\Button);
$form->render();
?>', true), '</pre>';

include("../footer.php");
?>
