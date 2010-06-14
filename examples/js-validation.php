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
			<title>PHP Form Builder Class | Examples | Javascript Validation</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / Javascript Validation</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Javascript Validation</b> - For javascript validation, simply set the <i>required</i> attribute to 1 and an onsubmit function for validation will automatically be generated and applied to the form.</p>
				<p>By default, the alert message will say "Label is a required field."; however, you can use the <i>errorMsgFormat</i> form attribute to customize this message.  [LABEL] will be replaced with the appropriate form field's
				label.  View the php source at the bottom of this page to see an example of how the <i>errorMsgFormat</i> attribute can be used.</p>

				<?php
				$form = new form("js_validation");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 400,
					"errorMsgFormat" => "[LABEL] is require.  Please provide this information and re-submit."
				));

				$form->addHidden("cmd", "submit");
				$form->addDateRange("Required Date Range:", "field0", "", array("required" => 1));
				$form->addColorPicker("Required Color Picker:", "field1", "", array("required" => 1));
				$form->addCheckSort("Required Check Sort:", "field2", "", array("Option #1", "Option #2", "Option #3", "Option #4", "Option #5"), array("required" => 1));
				$form->addRating("Required Rating:", "field3", "", range(1, 10), array("ratingHideCaption" => 1, "required" => 1));
				$form->addButton();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("js_validation");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 400,
	"errorMsgFormat" => "[LABEL] is a require.  Please provide this information and re-submit."
));

$form->addHidden("cmd", "submit");
$form->addDateRange("Required Date Range:", "field0", "", array("required" => 1));
$form->addColorPicker("Required Color Picker:", "field1", "", array("required" => 1));
$form->addCheckSort("Required Check Sort:", "field2", "", array("Option #1", "Option #2", "Option #3", "Option #4", "Option #5"), array("required" => 1));
$form->addRating("Required Rating:", "field3", "", range(1, 10), array("ratingHideCaption" => 1, "required" => 1));
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
