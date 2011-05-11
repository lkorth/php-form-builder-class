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

<h2 class="first">Elements</h2>
<p>The pfbc project includes 19 elements that added to your forms through the addElement method.  These elements are as follows:
Button, Captcha, Checkbox, Checksort, CKEditor, Date, Email, File, Hidden, HTML, HTMLExternal, Password, Radio, Select, State, Textarea, 
Textbox, TinyMCE, YesNo.</p>

<?php
$options = array("Option #1", "Option #2", "Option #3");
$form = new PFBC\Form("elements", 400);
$form->addElement(new PFBC\Element\Hidden("form", "elements"));
$form->addElement(new PFBC\Element\Textbox("Textbox:", "Textbox"));
$form->addElement(new PFBC\Element\Textarea("Textarea:", "Textarea"));
$form->addElement(new PFBC\Element\Select("Select:", "Select", $options));
$form->addElement(new PFBC\Element\Radio("Radio:", "Radio", $options));
$form->addElement(new PFBC\Element\File("File:", "File", array("required" => 1)));
$form->addElement(new PFBC\Element\Password("Password:", "Password"));
$form->addElement(new PFBC\Element\Checkbox("Checkbox:", "Checkbox", $options));
$form->addElement(new PFBC\Element\YesNo("Yes / No:", "YesNo", array(
	"description" => "The YesNo element provides a shortcut for adding a Radio element with Yes/No options."
)));
$form->addElement(new PFBC\Element\Checksort("Checksort:", "Checksort", $options, array(
	"description" => "Checksort leverages jQueryUI's Sortable interaction to allow end users to both select and sort items in one location."
)));
$form->addElement(new PFBC\Element\Sort("Sort:", "Sort", $options, array(
	"description" => "Like Checksort, the Sort element leverages jQueryUI's Sortable interaction to allow end users to sort a group of items."
)));
$form->addElement(new PFBC\Element\State("State:", "State", array(
	"description" => "The State element provides a shortcut for adding a Select element with options for each of the 50 US states."
)));
$form->addElement(new PFBC\Element\Email("Email:", "Email", array(
	"description" => "The Email element provides a shortcut for adding a Textbox element with Email validation applied."
)));
$form->addElement(new PFBC\Element\Date("Date:", "Date", array(
	"description" => "The Date element leverages jQueryUI's Datepicker widget to allow end users to select a date from a calendar."
)));
$form->addElement(new PFBC\Element\Color("Color:", "Color", array(
	"description" => "The Color element leverages the ColorPicker jQuery plugin to allow end users to select a color."
)));
$form->addElement(new PFBC\Element\Captcha("Captcha:", array(
	"description" => "The Captcha element leverages Google's reCAPTCHA anti-bot service to prevent spam submissions."
)));
$form->addElement(new PFBC\Element\Button);
$form->render();

echo '<pre>', highlight_string('<?php
$options = array("Option #1", "Option #2", "Option #3");
$form = new PFBC\Form("elements", 400);
$form->addElement(new PFBC\Element\Hidden("form", "elements"));
$form->addElement(new PFBC\Element\Textbox("Textbox:", "Textbox"));
$form->addElement(new PFBC\Element\Textarea("Textarea:", "Textarea"));
$form->addElement(new PFBC\Element\Select("Select:", "Select", $options));
$form->addElement(new PFBC\Element\Radio("Radio:", "Radio", $options));
$form->addElement(new PFBC\Element\File("File:", "File"));
$form->addElement(new PFBC\Element\Password("Password:", "Password"));
$form->addElement(new PFBC\Element\Checkbox("Checkbox:", "Checkbox", $options));
$form->addElement(new PFBC\Element\YesNo("Yes / No:", "YesNo"));
$form->addElement(new PFBC\Element\Checksort("Checksort:", "Checksort", $options));
$form->addElement(new PFBC\Element\Sort("Sort:", "Sort", $options));
$form->addElement(new PFBC\Element\State("State:", "State"));
$form->addElement(new PFBC\Element\Email("Email:", "Email"));
$form->addElement(new PFBC\Element\Color("Color:", "Color"));
$form->addElement(new PFBC\Element\Date("Date:", "Date"));
$form->addElement(new PFBC\Element\Captcha("Captcha:"));
$form->addElement(new PFBC\Element\Button);
$form->render();
?>', true), '</pre>';

$form = new PFBC\Form("webeditors", 650);
$form->configure(array(
	"prevent" => array("focus", "jQuery", "jQueryUI")
));
$form->addElement(new PFBC\Element\Hidden("form", "webeditors"));
$form->addElement(new PFBC\Element\TinyMCE("TinyMCE:", "TinyMCE", array(
	"description" => "The TinyMCE element provides one of the project's two included web editors.  The default toolbar (as seen below) requires a width of 650px.  The basic property can be applied to render a reduced toolbar."
)));
$form->addElement(new PFBC\Element\CKEditor("CKEditor:", "CKEditor", array(
	"description" => "The CKEditor element provides the other web editor included in the project.  Like TinyMCE, the basic property can be used to reduce the options included in the toolbar."
)));
$form->addElement(new PFBC\Element\Button);
$form->render();

echo '<pre>', highlight_string('<?php
$form = new PFBC\Form("webeditors", 650);
$form->addElement(new PFBC\Element\Hidden("form", "webeditors"));
$form->addElement(new PFBC\Element\TinyMCE("TinyMCE:", "TinyMCE"));
$form->addElement(new PFBC\Element\CKEditor("CKEditor:", "CKEditor"));
$form->addElement(new PFBC\Element\Button);
$form->render();
?>', true), '</pre>';

include("../footer.php");
?>
