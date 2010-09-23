<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0", "submit_1"))) {
	$form = new form("formelements_" . substr($_POST["cmd"], -1));
	if($form->validate())
		header("Location: form-elements.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Congratulations! The information you enter passed the form's validation."));
	else
		header("Location: form-elements.php");
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>PHP Form Builder Class | Examples | All Supported Form Elements</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<link href="style.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / All Supported Form Elements</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>All Supported Form Elements</b> - This example demonstrates all 27 supported form element types: hidden, textbox, textarea, webeditor, password, file, date, daterange, state, country, yesno, truefalse, select, radio, checkbox, latlng,
				sort, checksort, captcha, slider, rating, html, color, email, htmlexternal, button.  More information on each of these form elements can be found in the <a href="../documentation/index.php#Form-Elements">Supported Form Elements section of the documentation</a>.</p>

				<?php
				$form = new form("formelements_0");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => "400"
				));	

				if(!empty($_GET["errormsg_0"]))
					$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

				$form->addHidden("cmd", "submit_0");
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
				$form->addHTML("HTML:");
				$form->addColor("Color:", "MyColor");
				$form->addEmail("Email:", "MyEmail");
				$form->addHTMLExternal("External HTML:");
				$form->addButton();
				$form->render();
				?>

				<br/><br/>

				<?php
				$form = new form("formelements_1");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => "850"
					"noAutoFocus" => 1,
					"preventJQueryLoad" => 1,
					"preventJQueryUILoad" => 1,
				));	

				if(!empty($_GET["errormsg_1"]))
					$form->errorMsg = filter_var(stripslashes($_GET["errormsg_1"]), FILTER_SANITIZE_SPECIAL_CHARS);

				$form->addHidden("cmd", "submit_1");
				$form->addWebEditor("Web Editor - TinyMCE:", "MyWebEditor");
				$form->addCKEditor("Web Editor - CKEditor:", "MyCKEditor");
				$form->addButton();
				$form->render();


echo '<pre>', highlight_string('<?php
$form = new form("formelements_0");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => "400"
));	

if(!empty($_GET["errormsg_0"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_0");
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
$form->addHTML("HTML:");
$form->addColor("Color:", "MyColor");
$form->addEmail("Email:", "MyEmail");
$form->addHTMLExternal("External HTML:");
$form->addButton();
$form->render();
?>

<br/><br/>

<?php
$form = new form("formelements_1");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => "850"
));	

if(!empty($_GET["errormsg_1"]))
	$form->errorMsg = filter_var(stripslashes($_GET["errormsg_1"]), FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_1");
$form->addWebEditor("Web Editor - TinyMCE:", "MyWebEditor");
$form->addCKEditor("Web Editor - CKEditor:", "MyCKEditor");
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

