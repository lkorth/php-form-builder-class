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
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<style type="text/css">
				/*div_layout styles*/
				#div_layout .pfbc-main {
					width: 300px;
				}
				#div_layout .pfbc-label {
					width: 100px;
					float: left;
					display: block;
				}
				#div_layout .pfbc-element {
					padding-bottom: 5px;
				}
				#div_layout .pfbc-element input {
					width: 200px;
				}

				/*div_layout_map styles*/
				#div_layout_map .pfbc-main {
					width: 600px;
				}
				#div_layout_map .pfbc-map {
					padding-bottom: 5px;
				}
				#div_layout_map .pfbc-label {
					display: block;
				}
				#div_layout_map .pfbc-element input {
					width: 100%;
				}
				#div_layout_map .pfbc-element select {
					width: 100%;
				}

				/*styles used in both div_layout and div_layout_map*/
				.pfbc-buttons {
					text-align: right;
				}
			</style>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/" target="_blank">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2>PHP Form Builder Class / Examples / Layout</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Div Layout</b> - By default, form elements are rendered in a table structure; however, the <i>enableDivLayout</i> form attribute gives you the control to replace this default markup
				with a more flexible/customizable div layout with hard-coded classes for easy css styling. The <i>map</i> form attribute can be used in combination with <i>enableDivLayout</i> just as you would with the default table structure.  A second example is included below demoing this functionality.</p>

				<?php
				$form = new form("div_layout");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"enableDivLayout" => 1
				));
				$form->addHidden("cmd", "submit");
				$form->addTextbox("Username:", "Username");
				$form->addTextbox("Password:", "Password");
				$form->addButton("Login");
				$form->render();

echo '<pre>' . htmlentities('<?php
$form = new form("div_layout");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"enableDivLayout" => 1
));
$form->addHidden("cmd", "submit");
$form->addTextbox("Username:", "Username");
$form->addTextbox("Password:", "Password");
$form->addButton("Login");
$form->render();
?>
<style type="text/css">
	#div_layout .pfbc-main {
		width: 300px;
	}
	#div_layout .pfbc-label {
		width: 100px;
		float: left;
		display: block;
	}
	#div_layout .pfbc-element {
		padding-bottom: 5px;
	}
	#div_layout .pfbc-element input {
		width: 200px;
	}
	.pfbc-buttons {
		text-align: right;
	}
</style>
?>') . '</pre>';

				$form = new form("div_layout_map");
				$form->setAttributes(array(
					"includesPath" => "../includes",
					"enableDivLayout" => 1,
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
$form = new form("div_layout_map");
$form->setAttributes(array(
	"includesPath" => "../includes",
	"enableDivLayout" => 1,
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
<style type="text/css">
	#div_layout_map .pfbc-main {
		width: 600px;
	}
	#div_layout_map .pfbc-map {
		padding-bottom: 5px;
	}
	#div_layout_map .pfbc-label {
		display: block;
	}
	#div_layout_map .pfbc-element input {
		width: 100%;
	}
	#div_layout_map .pfbc-element select {
		width: 100%;
	}
	.pfbc-buttons {
		text-align: right;
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
