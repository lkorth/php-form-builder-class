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

<h2 class="first">Conditions</h2>
<p>The following example demonstrates how to show/hide one or more form elements based a set of conditions.  
This is achieved by using a javascript event along with the HTMLExternal element.</p>

<?php
$options = array("Option #1", "Option #2", "Option #3");
$form = new PFBC\Form("conditions", 400);
$form->addElement(new PFBC\Element\Hidden("form", "conditions"));
$form->addElement(new PFBC\Element\YesNo("Show / Hide Condition:", "Condition", array(
	"description" => "Click \"Yes\" below to show additional form elements.  Click \"No\" to hide them. ", 
	"onclick" => "toggleAdditionalElements(this.value);"
)));
$form->addElement(new PFBC\Element\HTMLExternal('<div id="AdditionalElements" style="display: none;">'));
$form->addElement(new PFBC\Element\Textarea("Textarea:", "Textarea"));
$form->addElement(new PFBC\Element\Select("Select:", "Select", $options));
$form->addElement(new PFBC\Element\Radio("Radio:", "Radio", $options));
$form->addElement(new PFBC\Element\HTMLExternal('</div>'));
$form->addElement(new PFBC\Element\Button);
$form->render();
?>
<script type="text/javascript">
	function toggleAdditionalElements(val) {
		if(val == "1")
			jQuery("#AdditionalElements").show(200);
		else
			jQuery("#AdditionalElements").hide(200);
	}
</script>
<?php

echo '<pre>', highlight_string('<?php
$options = array("Option #1", "Option #2", "Option #3");
$form = new PFBC\Form("elements", 400);
$form->addElement(new PFBC\Element\Hidden("form", "elements"));
$form->addElement(new PFBC\Element\YesNo("Show / Hide Condition:", "Condition", array(
	"description" => "Click \"Yes\" below to show additional form elements.  Click \"No\" to hide them. ", 
	"onclick" => "toggleAdditionalElements(this.value);"
)));
$form->addElement(new PFBC\Element\HTMLExternal(\'<div id="AdditionalElements" style="display: none;">\'));
$form->addElement(new PFBC\Element\Textarea("Textarea:", "Textarea"));
$form->addElement(new PFBC\Element\Select("Select:", "Select", $options));
$form->addElement(new PFBC\Element\Radio("Radio:", "Radio", $options));
$form->addElement(new PFBC\Element\HTMLExternal(\'</div>\'));
$form->addElement(new PFBC\Element\Button);
$form->render();
?>
<script type="text/javascript">
	function toggleAdditionalElements(val) {
		if(val == "1")
			jQuery("#AdditionalElements").show(200);
		else
			jQuery("#AdditionalElements").hide(200);
	}
</script>
', true), '</pre>';

include("../footer.php");

echo '<pre>', print_r($_SESSION, true), '</pre>';
?>
