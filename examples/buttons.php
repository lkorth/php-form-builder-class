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
			<title>PHP Form Builder Class | Examples | Buttons</title>
		</head>	
		<body>
			<h2 style="text-align: center; margin: 0; padding: 0;">PHP Form Builder Class</h2>
			<h5 style="text-align: center; margin: 0; padding: 0;"><span style="padding-right: 10px;">Author: Andrew Porterfield</span><span style="padding-right: 10px;">Released: <?php echo(file_get_contents('../release'));?></span><span>Version: <?php echo(file_get_contents('../version'));?></span></h5>
			<div style="text-align: center; padding-bottom: 10px;"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">View Project's Homepage</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Latest Stable Release</a></div>
			<a href="../index.php">Back to Project Home Page</a>
			<p><b>Buttons</b> - This example demonstrates how buttons are handled within the class.  By default, all buttons attached to forms via the addButton() function will be rendered in the lower right corner of the form.
			You can make use of the html form element - addHTML() - and/or the postHTML/preHTML element attributes if you need to render button in another location.</p>

			<?php
			$form = new form("buttons");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes",
				"tableAttributes" => array("width" => "400")
			));
			$form->addHidden("cmd", "submit");
			$form->addTextbox("Textbox:", "field0");
			$form->addSelectbox("Selectbox:", "field1", "", array("" => "--Select an Option--", "1" => "Option #1", "2" => "Option #2", "3" => "Option #3"));
			$form->addCheckbox("Checkboxes:", "field2", "", array("Option #1", "Option #2", "Option #3"));
			$form->addRadio("Radio Buttons:", "field3", "", array("Option #1", "Option #2", "Option #3"));
			$form->addButton();
			$form->addButton("Apply");
			$form->addButton("php.net", "button", array("onclick" => "window.location = 'http://www.php.net';"));

			/*
			If your system has a utility in place for dynamically generating button images, you will want to utilize the phpFunction, phpParams, wrapLink, and hrefAttributes button attributes.  
			A sample is provided below of what this function call might look like.  View the source of class.form.php to learn more about these attributes.

			$form->addButton("", "", array("phpFunction" => "RenderDynamicButton", "phpParams" => array("param1","param2"), "wrapLink" => 1, "linkAttributes" => array("href" => "http://www.php.net/")));
			*/

			$form->render();

echo '<pre>' . htmlentities('<?php
$form = new form("buttons");
$form->setAttributes(array(
	"includesRelativePath" => "../includes",
	"tableAttributes" => array("width" => "400")
));
$form->addHidden("cmd", "submit");
$form->addTextbox("Textbox:", "field0");
$form->addSelectbox("Selectbox:", "field1", "", array("" => "--Select an Option--", "1" => "Option #1", "2" => "Option #2", "3" => "Option #3"));
$form->addCheckbox("Checkboxes:", "field2", "", array("Option #1", "Option #2", "Option #3"));
$form->addRadio("Radio Buttons:", "field3", "", array("Option #1", "Option #2", "Option #3"));
$form->addButton();
$form->addButton("Apply");
$form->addButton("php.net", "button", array("onclick" => "window.location = \'http://www.php.net\';"));

/*
If your system has a utility in place for dynamically generating button images, you will want to utilize the phpFunction, phpParams, wrapLink, and hrefAttributes button attributes.  
A sample is provided below of what this function call might look like.  View the source of class.form.php to learn more about these attributes.

$form->addButton("", "", array("phpFunction" => "RenderDynamicButton", "phpParams" => array("param1","param2"), "wrapLink" => 1, "linkAttributes" => array("href" => "http://www.php.net/")));
*/

$form->render();
?>') . '</pre>';
			?>

			<a href="../index.php">Back to Project Home Page</a>
		</body>
	</html>
	<?php
}
?>

