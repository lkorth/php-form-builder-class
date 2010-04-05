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
			<title>PHP Form Builder Class | Examples | Layout</title>
		</head>	
		<body>
			<h2 style="text-align: center; margin: 0; padding: 0;">PHP Form Builder Class</h2>
			<h5 style="text-align: center; margin: 0; padding: 0;"><span style="padding-right: 10px;">Author: Andrew Porterfield</span><span style="padding-right: 10px;">Released: <?php echo(file_get_contents('../release'));?></span><span>Version: <?php echo(file_get_contents('../version'));?></span></h5>
			<div style="text-align: center; padding-bottom: 10px;"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">View Project's Homepage</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Latest Stable Release</a></div>
			<a href="../index.php">Back to Project Home Page</a>
			<p><b>Layout</b> - By default, one form element will be rendered on each line; however, the <i>map</i> form attribute can be used to customize the form's layout.
			Simply set this attribute to a one dimensional array of numbers corresponding with how many elements you would like rendered on each line.  In the example provided below, the
			<i>map</i> attribute is set to array(2, 2, 1, 3).</p>

			<?php
			$form = new form("layout");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes",
				"tableAttributes" => array("width" => "500"),
				"map" => array(2, 2, 1, 3)
			));
			$form->addHidden("cmd", "submit");
			$form->addTextbox("First Name:", "FName");
			$form->addTextbox("Last Name:", "LName");
			$form->addTextbox("Email Address:", "Email");
			$form->addTextbox("Phone Number:", "Phone");
			$form->addTextbox("Address:", "Address");
			$form->addTextbox("City:", "City");
			$form->addState("State:", "State");
			$form->addTextbox("Zip Code:", "Zip");
			$form->addButton();
			$form->render();

echo '<pre>' . htmlentities('<?php
$form = new form("layout");
$form->setAttributes(array(
	"includesRelativePath" => "../includes",
	"tableAttributes" => array("width" => "500"),
	"map" => array(2, 2, 1, 3)
));
$form->addHidden("cmd", "submit");
$form->addTextbox("First Name:", "FName");
$form->addTextbox("Last Name:", "LName");
$form->addTextbox("Email Address:", "Email");
$form->addTextbox("Phone Number:", "Phone");
$form->addTextbox("Address:", "Address");
$form->addTextbox("City:", "City");
$form->addState("State:", "State");
$form->addTextbox("Zip Code:", "Zip");
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
