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
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<link href="pfbc.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/" target="_blank">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Version <?php echo(file_get_contents('../version'));?></a></div>
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
				$form->addYesNo("Yes/No:", "field10", "", array("clear" => 1));
				$form->addTrueFalse("True/False:", "field11", "", array("clear" => 1));
				$form->addSelect("Select Box:", "field12", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"));
				$form->addRadio("Radio Buttons:", "field13", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"), array("clear" => 1));
				$form->addCheckbox("Checkboxes:", "field14", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"), array("clear" => 1));
				$form->addLatLng("Latitude/Longitude:", "field15");
				$form->addSort("Sort:", "field16", array("Option #1", "Option #2", "Option #3"));
				$form->addCheckSort("Checksort:", "field17", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"), array("clear" => 1));
				$form->addCaptcha("Captcha:");
				$form->addSlider("Slider:", "field18");
				$form->addRating("Rating:", "field19", "", range(1, 10));
				$form->addHTML("HTML:");
				$form->addColorPicker("Color Picker", "field20");
				$form->addEmail("Email:", "field21");
				$form->addButton();
				$form->render();

echo '<pre>' . htmlentities('<?php
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
$form->addYesNo("Yes/No:", "field10", "", array("clear" => 1));
$form->addTrueFalse("True/False:", "field11", "", array("clear" => 1));
$form->addSelect("Select Box:", "field12", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"));
$form->addRadio("Radio Buttons:", "field13", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"), array("clear" => 1));
$form->addCheckbox("Checkboxes:", "field14", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"), array("clear" => 1));
$form->addLatLng("Latitude/Longitude:", "field15");
$form->addSort("Sort:", "field16", array("Option #1", "Option #2", "Option #3"));
$form->addCheckSort("Checksort:", "field17", "", array("option0" => "Option 0", "option1" => "Option 1", "option2" => "Option 2"), array("clear" => 1));
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
			</div>	
		</body>
	</html>
	<?php
}
?>

