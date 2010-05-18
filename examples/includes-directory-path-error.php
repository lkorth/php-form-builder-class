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
			<title>PHP Form Builder Class | Examples | Invalid includes Directory Path Error</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<link href="pfbc.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2>PHP Form Builder Class / Examples / Invalid includes Directory Path Error</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Invalid includes Directory Path Error</b> - When you download and unzip the latest release of this project, you will find an includes directory within the php-form-builder-class folder.
				This directory contains essential functionality used throughout this project includeing jQuery, TinyMCE, CKEditor, and reCAPTCHA.  If the relative path of this directory is not correctly identified,
				a javascript alert message will be displayed notifying you of this configuration problem.</p>

				<p>To correct this, you will need to specify the <i>includesPath</i> form attribute in the form's setAttributes() function.  By default, this attribute
				is set to php-form-builder-class/includes.  The default setting will correctly identify the includes directory if the php-form-builder-class folder and the script where your form is built/rendered are in the
				same directory.  Please take note that this path needs to be relative to the script where your form is built/rendered - not absolute.  This is because the attribute is used to include both javascript and php
				files.</p>

				<p>In this example script, as well as all the included examples, you will notice the <i>includesPath</i> form attribute is set to ../includes.  This is because all the example files are grouped in the examples
				directory and not in the same folder as the includes directory.  To remove the javascript alert message on this example script and fix the configuration error, edit the php source and remove the comment from the line 
				setting the <i>includesPath</i> attribute in the form's setAttributes() function.</p>

				<p>An alternate solution would be to manually edit the default value of the <i>includesPath</i> form attribute in class.form.php; however, this method isn't ideal if you plan to keep your copy of this project
				up-to-date with the latest versions that are released frequently.</p>

				<?php
				$form = new form("includes_configuration_error");
				$form->setAttributes(array(
					//"includesPath" => "../includes",
					"width" => 400
				));
				$form->addHidden("cmd", "submit");
				$form->addTextbox("Textbox:", "field0");
				$form->addSelectbox("Selectbox:", "field1", "", array("" => "--Select an Option--", "1" => "Option #1", "2" => "Option #2", "3" => "Option #3"));
				$form->addCheckbox("Checkboxes:", "field2", "", array("Option #1", "Option #2", "Option #3"), array("clear" => 1));
				$form->addRadio("Radio Buttons:", "field3", "", array("Option #1", "Option #2", "Option #3"), array("clear" => 1));
				$form->addButton();
				$form->render();

echo '<pre>', highlight_string('<?php
$form = new form("includes_configuration_error");
$form->setAttributes(array(
	//"includesPath" => "../includes",
	"width" => 400
));
$form->addHidden("cmd", "submit");
$form->addTextbox("Textbox:", "field0");
$form->addSelectbox("Selectbox:", "field1", "", array("" => "--Select an Option--", "1" => "Option #1", "2" => "Option #2", "3" => "Option #3"));
$form->addCheckbox("Checkboxes:", "field2", "", array("Option #1", "Option #2", "Option #3"));
$form->addRadio("Radio Buttons:", "field3", "", array("Option #1", "Option #2", "Option #3"));
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

