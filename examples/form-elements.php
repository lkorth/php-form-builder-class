<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit")
{
	echo "<pre>" . htmlentities(print_r($_POST,true)) . "</pre>";
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"]))
{
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>PHP Form Builder Class | Examples | All Supported Form Elements</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2>PHP Form Builder Class / Examples / All Supported Form Elements</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>All Supported Form Elements</b> - This example demonstrates all supported form element types.</p>

				<?php
				$form = new form("form_elements");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => "400"
				));	

				$form->addHidden("cmd", "submit");
				$form->addTextbox("Textbox:", "field0");
				$form->addTextarea("Textarea:", "field1");
				$form->addWebEditor("Web Editor - TinyMCE:", "field2");
				$form->addCKEditor("Web Editor - CKEditor:", "field3");
				$form->addPassword("Password:", "field4");
				$form->addFile("File:", "field5");
				$form->addDate("Date:", "field6");
				$form->addDateTime("Date/Time:", "field7");
				$form->addTime("Time:", "field8");
				$form->addDateRange("Date Range:", "field9");
				$form->addState("State:", "field10");
				$form->addCountry("Country:", "field11");
				$form->addYesNo("Yes/No:", "field12");
				$form->addTrueFalse("True/False:", "field13");
				$form->addSelect("Select Box:", "field14", "", array("Option #0", "Option #1", "Option #2"));
				$form->addRadio("Radio Buttons:", "field15", "", array("Option #0", "Option #1", "Option #2"));
				$form->addCheckbox("Checkboxes:", "field16", "", array("Option #0", "Option #1", "Option #2"));
				$form->addLatLng("Latitude/Longitude:", "field17");
				$form->addSort("Sort:", "field18", array("Option #0", "Option #1", "Option #2"));
				$form->addCheckSort("Checksort:", "field19", "", array("Option #0", "Option #1", "Option #2"));
				$form->addCaptcha("Captcha:");
				$form->addSlider("Slider:", "field20");
				$form->addRating("Rating:", "field21", "", range(1, 10));
				$form->addHTML("HTML:");
				$form->addColorPicker("Color Picker", "field22");
				$form->addEmail("Email:", "field23");
				$form->addButton();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("form_elements");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => "400"
));	

$form->addHidden("cmd", "submit");
$form->addTextbox("Textbox:", "field0");
$form->addTextarea("Textarea:", "field1");
$form->addWebEditor("Web Editor - TinyMCE:", "field2");
$form->addCKEditor("Web Editor - CKEditor:", "field3");
$form->addPassword("Password:", "field4");
$form->addFile("File:", "field5");
$form->addDate("Date:", "field6");
$form->addDateTime("Date/Time:", "field7");
$form->addTime("Time:", "field8");
$form->addDateRange("Date Range:", "field9");
$form->addState("State:", "field10");
$form->addCountry("Country:", "field11");
$form->addYesNo("Yes/No:", "field12");
$form->addTrueFalse("True/False:", "field13");
$form->addSelect("Select Box:", "field14", "", array("Option #0", "Option #1", "Option #2"));
$form->addRadio("Radio Buttons:", "field15", "", array("Option #0", "Option #1", "Option #2"));
$form->addCheckbox("Checkboxes:", "field16", "", array("Option #0", "Option #1", "Option #2"));
$form->addLatLng("Latitude/Longitude:", "field17");
$form->addSort("Sort:", "field18", array("Option #0", "Option #1", "Option #2"));
$form->addCheckSort("Checksort:", "field19", "", array("Option #0", "Option #1", "Option #2"));
$form->addCaptcha("Captcha:");
$form->addSlider("Slider:", "field20");
$form->addRating("Rating:", "field21", "", range(1, 10));
$form->addHTML("HTML:");
$form->addColorPicker("Color Picker", "field22");
$form->addEmail("Email:", "field23");
$form->addButton();
$form->render();
?>', true), '</pre>';

				?>
			</div>	
		</body>
	</html>
	<?php
}
?>

