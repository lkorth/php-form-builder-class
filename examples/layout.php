<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0", "submit_1", "submit_2"))) {
	$form = new form("layout_" . substr($_POST["cmd"], -1));
	if($form->validate())
		header("Location: layout.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Congratulations! The information you enter passed the form's validation."));
	else
		header("Location: layout.php");
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	$title = "Layout";
	include("../header.php");
	?>

	<p><b>Layout</b> - The project's default layout will render each element on it's own line, place the labels above the elements, and set the elements' widths
	to span the entire length of the form.  Below, you'll find several form/element attributes that can be used to alter your forms' layouts.</p>

	<ul style="margin: 0;">
		<li>map - The "map" form attribute is used to render multiple elements on each line by specifying a single dimention array where the array values
		corresponds with the number of elements that should be displayed on each respective line.</li>
		<li>mapMargin - When using the "map" attribute, "mapMargin" is used to adjust the amount of left/right padding applied to form elements rendered
		on the same line.  By default, this attribute will be set to 2px or 2% depending on if the form's width is set as a pixel or percentage value.
		The total padding between form elements will be twice the value of the "mapMargin" attribute as it is applied to padding on both the left and right
		side of each element.</li>
		<li>labelWidth - The "labelWidth" attribute gives you - the developer - the ability display labels floated left beside the elements (instead of dispalyed
		block above the elements).  The "labelWidth" attribute exists as both a form and element attribute, which means it can be applied in the form's setAttributes function
		and/or in the additionalParams associative array when adding form elements.  Setting "labelWidth" in the form's setAttribute function will apply the attribute
		to each form element.  If "labelWidth" is applied both as a form and element attribute, the element attribute's value will take precedence.</li>
		<li>labelRightAlign - When using the "labelWidth" attribtue, "labelRightAlign" can be used to right align the label's text (instead of left).
		Like "labelWidth", the "labelRightAlign" attribute exists as both a form and element attribute, which means it can be applied in the form's setAttributes function
		and/or in the additionalParams associative array when adding form elements.  Setting "labelRightAlign" in the form's setAttribute function will apply the attribute
		to each form element.  If "labelRightAlign" is applied both as a form and element attribute, the element attribute's value will take precedence.</li>
		<li>labelPaddingRight - When using both the "labelWidth" attribute, "labelPaddingRight" can be used to adjust the amount of padding between the
		label and the element.  This attribute will default to 4px or 4% depending on if the form's width is set as a pixel or percentage value.
		Like "labelWidth", the "labelPaddingRight" attribute exists as both a form and element attribute, which means it can be applied in the form's setAttributes function
		and/or in the additionalParams associative array when adding form elements.  Setting "labelPaddingRight" in the form's setAttribute function will apply the attribute
		to each form element.  If "labelPaddingRight" is applied both as a form and element attribute, the element attribute's value will take precedence.</li>
		<li>labelDisplayRight - This form/element attribute can be used to render the label to the right of the form element.  It differs from "labelRightAlign" as this attribute
		only right aligns the text within the label.</li>
		<li>labelPaddingLeft - The "labelPaddingLeft" form/element attribute comes into play when setting "labelDisplayRight" and is used to adjust the amount of padding between
		the label and the form element.  It functions identically to "labelPaddingRight" except padding is applied to the left side of the label as apposed to the right.</li>
	</ul>

	<p>Below are several example forms that demo many of the attributes listed above.</p>

	<?php
	$form = new form("layout_0");
	$form->setAttributes(array(
		"width" => 500,
		"map" => array(2, 2, 1, 3)
	));

	if(!empty($_GET["errormsg_0"]))
		$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

	$form->addHidden("cmd", "submit_0");
	$form->addTextbox("First Name:", "FName");
	$form->addTextbox("Last Name:", "LName");
	$form->addEmail("Email Address:", "Email");
	$form->addTextbox("Phone Number:", "Phone");
	$form->addTextbox("Address:", "Address");
	$form->addTextbox("City:", "City");
	$form->addState("State:", "State");
	$form->addTextbox("Zip Code:", "Zip");
	$form->addButton();
	$form->render();

	echo '<pre>', highlight_string('<?php
$form = new form("layout_0");
$form->setAttributes(array(
	"width" => 500,
	"map" => array(2, 2, 1, 3)
));

if(!empty($_GET["errormsg_0"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_0");
$form->addTextbox("First Name:", "FName");
$form->addTextbox("Last Name:", "LName");
$form->addEmail("Email Address:", "Email");
$form->addTextbox("Phone Number:", "Phone");
$form->addTextbox("Address:", "Address");
$form->addTextbox("City:", "City");
$form->addState("State:", "State");
$form->addTextbox("Zip Code:", "Zip");
$form->addButton();
$form->render();
?>', true), '</pre>';

	$form = new form("layout_1");
	$form->setAttributes(array(
		"width" => 400,
		"noAutoFocus" => 1,
		"preventJQueryLoad" => 1,
		"preventJQueryUILoad" => 1,
		"labelWidth" => 100
	));

	if(!empty($_GET["errormsg_1"]))
		$form->errorMsg = filter_var(stripslashes($_GET["errormsg_1"]), FILTER_SANITIZE_SPECIAL_CHARS);

	$form->addHidden("cmd", "submit_1");
	$form->addTextbox("Username:", "Username", "", array("required" => 1));
	$form->addPassword("Password:", "Password", "", array("required" => 1));
	$form->addHTML('<a href="#">Forgot your password?</a>');
	$form->addButton("Login");
	$form->render();

	echo '<pre>', highlight_string('<?php
$form = new form("layout_1");
$form->setAttributes(array(
	"width" => 400,
	"labelWidth" => 100
));

if(!empty($_GET["errormsg_1"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_1"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_1");
$form->addTextbox("Username:", "Username", "", array("required" => 1));
$form->addPassword("Password:", "Password", "", array("required" => 1));
$form->addHTML(\'<a href="#">Forgot your password?</a>\');
$form->addButton("Login");
$form->render();
?>', true), '</pre>';

	$form = new form("layout_2");
	$form->setAttributes(array(
		"width" => 800,
		"noAutoFocus" => 1,
		"preventJQueryLoad" => 1,
		"preventJQueryUILoad" => 1,
		"labelWidth" => 125,
		"labelRightAlign" => 1,
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
$form = new form("layout_2");
$form->setAttributes(array(
	"width" => 800,
	"labelWidth" => 125,
	"labelRightAlign" => 1,
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
	
	$form = new form("layout_3");
	$form->setAttributes(array(
		"width" => 400,
		"noAutoFocus" => 1,
		"preventJQueryLoad" => 1,
		"preventJQueryUILoad" => 1,
		"labelWidth" => 100,
		"labelDisplayRight" => 1
	));

	if(!empty($_GET["errormsg_3"]))
		$form->errorMsg = filter_var(stripslashes($_GET["errormsg_3"]), FILTER_SANITIZE_SPECIAL_CHARS);

	$form->addHidden("cmd", "submit_3");
	$form->addTextbox("Username:", "Username", "", array("required" => 1));
	$form->addPassword("Password:", "Password", "", array("required" => 1));
	$form->addHTML('<a href="#">Forgot your password?</a>');
	$form->addButton("Login");
	$form->render();

	echo '<pre>', highlight_string('<?php
$form = new form("layout_3");
$form->setAttributes(array(
	"width" => 400,
	"noAutoFocus" => 1,
	"preventJQueryLoad" => 1,
	"preventJQueryUILoad" => 1,
	"labelWidth" => 100,
	"labelDisplayRight" => 1
));

if(!empty($_GET["errormsg_3"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_3"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_3");
$form->addTextbox("Username:", "Username", "", array("required" => 1));
$form->addPassword("Password:", "Password", "", array("required" => 1));
$form->addHTML(\'<a href="#">Forgot your password?</a>\');
$form->addButton("Login");
$form->render();
?>', true), '</pre>';

	include("../footer.php");
}
?>
