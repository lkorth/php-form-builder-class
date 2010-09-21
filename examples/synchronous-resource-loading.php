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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>PHP Form Builder Class | Examples | Synchronous Resource Loading</title>
		<link href="../style.css" rel="stylesheet" type="text/css"/>
		<link href="style.css" rel="stylesheet" type="text/css"/>
		<?php
		$form->renderHead();
		?>
	</head>
	<body>
		<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
		<div id="pfbc_banner">
			<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / Synchronous Resource Loading</h2>
			<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
		</div>

		<div id="pfbc_content">
			<p><b>Synchronous Resource Loading</b> - This project's render function loads the form's required css/js resources asynchronously.  For XHTML strict compliance, the css include files and style tag sections are
			appended to the head tag.  This example file demonstrates how two functions - renderHead and renderBody - can be used to load these css/js resources synchronously.  One of the benefits of this approach
			is that the form's stylesheet is loaded before any markup is generated, which eliminates the visual delay that can occur when the render function is invoked.</p>
			<?php
			$form->renderBody();
			?>
		</div>
	</body>
</html>
