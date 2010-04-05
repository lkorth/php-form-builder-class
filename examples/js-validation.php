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
			<title>PHP Form Builder Class | Examples | Javascript Validation</title>
		</head>	
		<body>
			<h2 style="text-align: center; margin: 0; padding: 0;">PHP Form Builder Class</h2>
			<h5 style="text-align: center; margin: 0; padding: 0;"><span style="padding-right: 10px;">Author: Andrew Porterfield</span><span style="padding-right: 10px;">Released: <?php echo(file_get_contents('../release'));?></span><span>Version: <?php echo(file_get_contents('../version'));?></span></h5>
			<div style="text-align: center; padding-bottom: 10px;"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">View Project's Homepage</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Latest Stable Release</a></div>
			<a href="../index.php">Back to Project Home Page</a>
			<p><b>Javascript Validation</b> - For javascript validation, simply set the <i>required</i> attribute to 1 and an onsubmit function for validation will automatically be generated and applied to the form.</p>
			<p>By default, the alert message will say "Label is a required field."; however, you can use the <i>errorMsgFormat</i> form attribute to customize this message.  [LABEL] will be replaced with the appropriate form field's
			label.  View the php source at the bottom of this page to see an example of how the <i>errorMsgFormat</i> attribute can be used.</p>
			<?php
			$form = new form("js_validation");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes",
				"tableAttributes" => array("width" => "400"),
				"errorMsgFormat" => "[LABEL] is a require.  Please provide this information and re-submit."
			));

			$form->addHidden("cmd", "submit");
			$form->addDateRange("Required Date Range:", "field0", "", array("required" => 1));
			$form->addColorPicker("Required Color Picker:", "field1", "", array("required" => 1));
			$form->addCheckSort("Required Check Sort:", "field2", "", array("Option #1", "Option #2", "Option #3", "Option #4", "Option #5"), array("required" => 1));
			$form->addRating("Required Rating:", "field3", "", range(1, 10), array("ratingHideCaption" => 1, "required" => 1));
			$form->addButton();
			$form->render();

echo '<pre>' . htmlentities('<?php
$form = new form("js_validation");
$form->setAttributes(array(
	"includesRelativePath" => "../includes",
	"tableAttributes" => array("width" => "400"),
	"errorMsgFormat" => "[LABEL] is a require.  Please provide this information and re-submit."
));

$form->addHidden("cmd", "submit");
$form->addDateRange("Required Date Range:", "field0", "", array("required" => 1));
$form->addColorPicker("Required Color Picker:", "field1", "", array("required" => 1));
$form->addCheckSort("Required Check Sort:", "field2", "", array("Option #1", "Option #2", "Option #5", "Option #4", "Option #5"), array("required" => 1));
$form->addRating("Required Rating:", "field3", "", range(1, 10), array("ratingHideCaption" => 1, "required" => 1));
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
