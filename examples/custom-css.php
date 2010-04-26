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
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<title>PHP Form Builder Class | Examples | Custom CSS Styling</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<style type="text/css">
				.pfbc-clear:after {
					clear: both;
					display: block;
					margin: 0;
					padding: 0;
					visibility: hidden;
					height: 0;
					content: ":)";
				}	
				.pfbc-buttons {
					text-align: right;
				}
				.pfbc-required {
					color: #990000; 
				}
				.pfbc-element {
					padding-bottom: 5px;
				}
				/*login Specific CSS*/
				#login .pfbc-main {
					width: 300px;
				}
				#login .pfbc-label {
					display: block;
					float: left;
					width: 100px;
				}
				#login .pfbc-textbox {
					width: 194px;
				}

				/*signup Specific CSS*/
				#signup .pfbc-main {
					width: 800px;
				}
				#signup .pfbc-label {
					display: block;
					float: left;
					width: 90px;
					text-align: right;
					padding-right: 10px;
				}
				<?
				$map = array(2, 2, 1, 3);
				$margin = 4;
				$width = 800;
				$mapVals = array_values(array_unique($map));
				$mapValSize = sizeof($mapVals);
				for($m = 0; $m < $mapValSize; ++$m)
				{
					$elementWidth = number_format((($width - ($margin * 2 * ($mapVals[$m] - 1)))  / $mapVals[$m]), 2, ".", "");
					$textboxWidth = $elementWidth - 100 - 6;
					$textareaWidth = $elementWidth - 100 - 2;
					$selectWidth = $elementWidth - 100;
						
				echo <<<STR
				#signup .pfbc-map-columns-{$mapVals[$m]} {
					float: left; 
					width: {$elementWidth}px;
				}
				#signup .pfbc-map-columns-{$mapVals[$m]} .pfbc-textbox {
					width: {$textboxWidth}px;
				}
				#signup .pfbc-map-columns-{$mapVals[$m]} .pfbc-textarea {
					width: {$textboxWidth}px;
				}
				#signup .pfbc-map-columns-{$mapVals[$m]} .pfbc-select {
					width: {$selectWidth}px;
				}

STR;
				}

				echo <<<STR
				#signup .pfbc-map-element-first {
					margin-left: 0 !important;
				}
				#signup .pfbc-map-element-last {
					float: right !important;
					margin-right: 0 !important;
				}
				#signup .pfbc-map-element-single {
					margin: 0 !important;
				}
				#signup .pfbc-element {
					margin: 0 {$margin}px;
				}

STR;
				?>
			</style>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/" target="_blank">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2>PHP Form Builder Class / Examples / Custom CSS Styling</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Custom CSS Styling</b> - By default, css will be applied to the forms you build providing a easy way to get up-and-running quickly; however, these default styles can be turned off with the <i>preventDefaultCSS</i> form attribute,
				which then allows you to layout your forms however you'd like.  Below are a few examples of how this can be done.  Notice that hardcoded classes are applied throughout the markup for styling purposes.  The second example demonstrates how to style forms that use the mapping functionality.  It is recommended that you review the php source of this example and/or the php source of the elementsToString() function within class.form.php when styling forms that make use of the <i>map</i> form attribute as the process is somewhat complex.
				Please submit any questions/issues you have about this topic to the project's issue tracker found at - <a href="http://code.google.com/p/php-form-builder-class/issues/list" target="_blank">http://code.google.com/p/php-form-builder-class/issues/list</a>.</p>

				<?php
				$form = new form("login");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"preventDefaultCSS" => 1
				));
				$form->addHidden("cmd", "submit");
				$form->addTextbox("Username:", "Username", "", array("required" => 1));
				$form->addPassword("Password:", "Password", "", array("required" => 1));
				$form->addHTML('<a href="#">Forgot your password?</a>');
				$form->addButton("Login");
				$form->render();

echo '<pre>' . htmlentities('<?php
$form = new form("login");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"preventDefaultCSS" => 1
));
$form->addHidden("cmd", "submit");
$form->addTextbox("Username:", "Username");
$form->addPassword("Password:", "Password");
$form->addHTML(\'<a href="#">Forgot your password?</a>\');
$form->addButton("Login");
$form->render();
?>
<style type="text/css">
	.pfbc-clear:after {
		clear: both;
		display: block;
		margin: 0;
		padding: 0;
		visibility: hidden;
		height: 0;
		content: ":)";
	}	
	.pfbc-buttons {
		text-align: right;
	}
	.pfbc-required {
		color: #990000; 
	}
	.pfbc-element {
		padding-bottom: 5px;
	}
	#login .pfbc-main {
		width: 300px;
	}
	#login .pfbc-label {
		display: block;
		float: left;
		width: 100px;
	}
	#login .pfbc-textbox {
		width: 194px;
	}
</style>
?>') . '</pre>';

				$form = new form("signup");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"noAutoFocus" => 1,
					"preventDefaultCSS" => 1,
					"map" => array(2, 2, 1, 3)
				));
				$form->addHidden("cmd", "submit");
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

echo '<pre>' . htmlentities('<?php
$form = new form("signup");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"noAutoFocus" => 1,
	"preventDefaultCSS" => 1,
	"map" => array(2, 2, 1, 3)
));
$form->addHidden("cmd", "submit");
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
?>
<style type="text/css">
#signup .pfbc-main {
	width: 800px;
}
#signup .pfbc-label {
	display: block;
	float: left;
	width: 90px;
	text-align: right;
	padding-right: 10px;
}
#signup .pfbc-map-columns-2 {
	float: left; 
	width: 396.00px;
}
#signup .pfbc-map-columns-2 .pfbc-textbox {
	width: 290px;
}
#signup .pfbc-map-columns-2 .pfbc-textarea {
	width: 290px;
}
#signup .pfbc-map-columns-2 .pfbc-select {
	width: 296px;
}
#signup .pfbc-map-columns-1 {
	float: left; 
	width: 800.00px;
}
#signup .pfbc-map-columns-1 .pfbc-textbox {
	width: 694px;
}
#signup .pfbc-map-columns-1 .pfbc-textarea {
	width: 694px;
}
#signup .pfbc-map-columns-1 .pfbc-select {
	width: 700px;
}
#signup .pfbc-map-columns-3 {
	float: left; 
	width: 261.33px;
}
#signup .pfbc-map-columns-3 .pfbc-textbox {
	width: 155.33px;
}
#signup .pfbc-map-columns-3 .pfbc-textarea {
	width: 155.33px;
}
#signup .pfbc-map-columns-3 .pfbc-select {
	width: 161.33px;
}
#signup .pfbc-map-element-first {
	margin-left: 0 !important;
}
#signup .pfbc-map-element-last {
	float: right !important;
	margin-right: 0 !important;
}
#signup .pfbc-map-element-single {
	margin: 0 !important;
}
#signup .pfbc-element {
	margin: 0 4px;
}
</style>
?>') . '</pre>';

				?>
			</div>
		</body>	
	</html>	
	<?php
}
?>
