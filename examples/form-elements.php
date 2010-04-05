<?php
error_reporting(E_ALL);
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit")
{
	echo "<pre>" . htmlentities(print_r($_POST,true)) . "</pre>";
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"]))
{
	?>
	<html>
		<head>
			<title>PHP Form Builder Class | Examples | All Supported Form Elements</title>
		</head>
		<body>
			<h2 style="text-align: center; margin: 0; padding: 0;">PHP Form Builder Class</h2>
			<h5 style="text-align: center; margin: 0; padding: 0;"><span style="padding-right: 10px;">Author: Andrew Porterfield</span><span style="padding-right: 10px;">Released: <?php echo(file_get_contents('../release'));?></span><span>Version: <?php echo(file_get_contents('../version'));?></span></h5>
			<div style="text-align: center; padding-bottom: 10px;"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">View Project's Homepage</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Latest Stable Release</a></div>
			<a href="../index.php">Back to Project Home Page</a>
			<p><b>All Supported Form Elements</b> - This example demonstrates all supported form element types.</p>

			<?php
			$form = new form("form_elements");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes"
			));	

			/*
			Below you will find functions for adding each of the supported form field types.
			function addHidden($name, $value="", $additionalParams="")
			function addTextbox($label, $name, $value="", $additionalParams="")
			function addTextarea($label, $name, $value="", $additionalParams="")
			function addWebEditor($label, $name, $value="", $additionalParams="")
			function addCKEditor($label, $name, $value="", $additionalParams="")
			function addPassword($label, $name, $value="", $additionalParams="")
			function addFile($label, $name, $additionalParams="")
			function addDate($label, $name, $value="", $additionalParams="")
			function addDateRange($label, $name, $value="", $additionalParams="")
			function addState($label, $name, $value="", $additionalParams="")
			function addCountry($label, $name, $value="", $additionalParams="")
			function addYesNo($label, $name, $value="", $additionalParams="")
			function addTrueFalse($label, $name, $value="", $additionalParams="")
			function addSelect($label, $name, $value="", $options="", $additionalParams="")
			function addRadio($label, $name, $value="", $options="", $additionalParams="")
			function addCheckbox($label, $name, $value="", $options="", $additionalParams="")
			function addSort($label, $name, $options="", $additionalParams="")
			function addLatLng($label, $name, $value="", $additionalParams="")
			function addCheckSort($label, $name, $value="", $options="", $additionalParams="")
			function addCaptcha($label="", $additionalParams="")
			function addSlider($label, $name, $value="", $additionalParams="")
			function addRating($label, $name, $value="", $options="", $additionalParams="")
			function addHTML($value)
			function addColorPicker($label, $name, $value="", $additionalParams="")
			function addEmail($label, $name, $value="", $additionalParams="")
			*/

			$form->addHidden("cmd", "submit");
			$form->addTextbox("Textbox:", "field0");
			$form->addTextarea("Textarea:", "field1");
			$form->addWebEditor("Web Editor - TinyMCE:", "field2");
			$form->addCKEditor("Web Editor - CKEditor:", "field3");
			$form->addPassword("Password:", "field4");
			$form->addFile("File:", "field5");
			$form->addDate("Date:", "field6");
			$form->addDateRange("Date Range:", "field7");
			$form->addState("State:", "field8");
			$form->addCountry("Country:", "field9");
			$form->addYesNo("Yes/No:", "field10");
			$form->addTrueFalse("True/False:", "field11");
			$form->addSelect("Select Box:", "field12", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"));
			$form->addRadio("Radio Buttons:", "field13", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"));
			$form->addCheckbox("Checkboxes:", "field14", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"));
			$form->addLatLng("Latitude/Longitude:", "field15");
			$form->addSort("Sort:", "field16", array("Option #1", "Option #2", "Option #3"));
			$form->addCheckSort("Checksort:", "field17", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"));
			$form->addCaptcha("Captcha:");
			$form->addSlider("Slider:", "field18");
			$form->addRating("Rating:", "field19", "", range(1, 10));
			$form->addHTML("HTML:");
			$form->addColorPicker("Color Picker", "field20");
			$form->addEmail("Email:", "field21");
			$form->addButton();
			$form->render();

echo '<pre>' . htmlentities('<?php
$form = new form("form_elements");
$form->setAttributes(array(
	"includesRelativePath" => "../includes"
));	

$form->addHidden("cmd", "submit");
$form->addTextbox("Textbox:", "field0");
$form->addTextarea("Textarea:", "field1");
$form->addWebEditor("Web Editor - TinyMCE:", "field2");
$form->addCKEditor("Web Editor - CKEditor:", "field3");
$form->addPassword("Password:", "field4");
$form->addFile("File:", "field5");
$form->addDate("Date:", "field6");
$form->addDateRange("Date Range:", "field7");
$form->addState("State:", "field8");
$form->addCountry("Country:", "field9");
$form->addYesNo("Yes/No:", "field10");
$form->addTrueFalse("True/False:", "field11");
$form->addSelect("Select Box:", "field12", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"));
$form->addRadio("Radio Buttons:", "field13", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"));
$form->addCheckbox("Checkboxes:", "field14", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"));
$form->addLatLng("Latitude/Longitude:", "field15");
$form->addSort("Sort:", "field16", array("Option #1", "Option #2", "Option #3"));
$form->addCheckSort("Checksort:", "field17", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"));
$form->addCaptcha("Captcha:");
$form->addSlider("Slider:", "field18");
$form->addRating("Rating:", "field19", "", range(1, 10));
$form->addHTML("HTML:");
$form->addColorPicker("Color Picker", "field20");
$form->addEmail("Email:", "field21");
$form->addButton();
$form->render();
?>') . '</pre>';
			?>
			<a href="../index.php">Back to Project Home Page</a>
		</body>
	</html>
	<?php
}
?>

