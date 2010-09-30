<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

$form = new form("synchronous");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit") {
	if($form->validate())
		$form->errorMsg = "Congratulations! The information you enter passed the form's validation.";
} 

$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 400
));
$form->addHidden("cmd", "submit");
$form->addTextbox("Textbox:", "MyTextbox");
$form->addTextarea("Textarea:", "MyTextarea");
$form->addPassword("Password:", "MyPassword");
$form->addFile("File:", "MyFile");
$form->addDate("Date:", "MyDate");
$form->addDateRange("Date Range:", "MyDateRange");
$form->addState("State:", "MyState");
$form->addCountry("Country:", "MyCountry");
$form->addYesNo("Yes/No:", "MyYesNo");
$form->addTrueFalse("True/False:", "MyTrueFalse");
$form->addSelect("Select Box:", "MySelect", "", array("Option #0", "Option #1", "Option #2"));
$form->addRadio("Radio Buttons:", "MyRadio", "", array("Option #0", "Option #1", "Option #2"));
$form->addCheckbox("Checkboxes:", "MyCheckbox", "", array("Option #0", "Option #1", "Option #2"));
$form->addLatLng("Latitude/Longitude:", "MyLatitudeLongitude");
$form->addSort("Sort:", "MySort", array("Option #0", "Option #1", "Option #2"));
$form->addCheckSort("Checksort:", "MyChecksort", "", array("Option #0", "Option #1", "Option #2"));
$form->addCaptcha("Captcha:");
$form->addSlider("Slider:", "MySlider");
$form->addRating("Rating:", "MyRating", "", range(1, 10));
$form->addColor("Color:", "MyColor");
$form->addEmail("Email:", "MyEmail");
$form->addButton();

$title = "Synchronous Resource Loading";
$headextra = $form->renderHead(true);
include("../header.php");
?>

<p><b>Synchronous Resource Loading</b> - This project's render function loads the form's required css/js resources asynchronously.  For XHTML strict compliance, the css include files and style tag sections are
appended to the head tag.  This example file demonstrates how two functions - renderHead and renderBody - can be used to load these css/js resources synchronously.  One of the benefits of this approach
is that the form's stylesheet is loaded before any markup is generated, which eliminates the visual delay that can occur when the render function is invoked.</p>

<?php
$form->renderBody();
include("../footer.php");
?>

