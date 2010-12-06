<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0"))) {
	$form = new form("fieldsets_" . substr($_POST["cmd"], -1));
	if($form->validate())
		header("Location: fieldsets.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Congratulations! The information you enter passed the form's validation."));
	else
		header("Location: fieldsets.php");
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	$title = "Fieldsets";
	$headextra = <<<STR
<style type="text/css">
	.pfbc-fieldset {
		margin: 0 0 10px;
		padding: 10px;
		border: 1px solid #ccc;
		-moz-border-radius: 8px; 
		-webkit-border-radius: 8px;
		width: 500px;
	}
	#fieldsets_0 {
		width: 522px;
	}
</style>

STR;
	include("../header.php");
	?>

	<p><b>Fieldsets</b> - Fieldsets are applied to your forms by using the project's openFieldset/closeFieldset functions.  Below, you will find one way that you can use fieldsets in your
	development.</p>

	<?php
	$form = new form("fieldsets_0", 500);
	$form->setAttributes(array(
		"map" => array(2, 1, 3, 2, 3)
	));

	if(!empty($_GET["errormsg_0"]))
		$form->errorMsg = filter_var($_GET["errormsg_0"], FILTER_SANITIZE_SPECIAL_CHARS);

	$form->addHidden("cmd", "submit_0");
	$form->openFieldset("Name");
	$form->addTextbox("First Name:", "FName");
	$form->addTextbox("Last Name:", "LName");
	$form->closeFieldset();
	$form->openFieldset("Address");
	$form->addTextbox("Address:", "Address");
	$form->addTextbox("City:", "City");
	$form->addState("State:", "State");
	$form->addTextbox("Zip Code:", "Zip");
	$form->closeFieldset();
	$form->openFieldset("Email Addresses");
	$form->addEmail("Email Address:", "Email");
	$form->addEmail("Alternate Email Address:", "AlternateEmail");
	$form->closeFieldset();
	$form->openFieldset("Phone Numbers");
	$form->addTextbox("Mobile/Cell:", "Mobile");
	$form->addTextbox("Home:", "Home");
	$form->addTextbox("Work:", "Work");
	$form->addButton();
	$form->closeFieldset();
	$form->render();

	echo '<pre>', highlight_string('<?php
$form = new form("fieldsets_0", 500);
$form->setAttributes(array(
	"map" => array(2, 1, 3, 2, 3)
));

if(!empty($_GET["errormsg_0"]))
	$form->errorMsg = filter_var($_GET["errormsg_0"], FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_0");
$form->openFieldset("Name");
$form->addTextbox("First Name:", "FName");
$form->addTextbox("Last Name:", "LName");
$form->closeFieldset();
$form->openFieldset("Address");
$form->addTextbox("Address:", "Address");
$form->addTextbox("City:", "City");
$form->addState("State:", "State");
$form->addTextbox("Zip Code:", "Zip");
$form->closeFieldset();
$form->openFieldset("Email Addresses");
$form->addEmail("Email Address:", "Email");
$form->addEmail("Alternate Email Address:", "AlternateEmail");
$form->closeFieldset();
$form->openFieldset("Phone Numbers");
$form->addTextbox("Mobile/Cell:", "Mobile");
$form->addTextbox("Home:", "Home");
$form->addTextbox("Work:", "Work");
$form->addButton();
$form->closeFieldset();
$form->render();
?>', true), '</pre>';

	include("../footer.php");
}
?>
