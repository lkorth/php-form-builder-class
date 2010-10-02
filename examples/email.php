<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0"))) {
	$form = new form("email_" . substr($_POST["cmd"], -1));
	if($form->validate())
		$form->sendFromGmail("my_email", "my_password", "my_recipient(s)", "my_subject");

	header("Location: google-gmail.php");
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	$title = "Email w/Google's Gmail Service";
	include("../header.php");
	?>

	<p><b>Email w/Google's Gmail Service</b> - </p>

	<?php
	$form = new form("email_0");
	$form->setAttributes(array(
		"includesPath" => "../includes",
		"map" => array(2, 2, 1, 3),
		"width" => 500
	));

	if(!empty($_GET["errormsg_0"]))
		$form->errorMsg = filter_var(stripslashes($_GET["errormsg_0"]), FILTER_SANITIZE_SPECIAL_CHARS);

	$form->addHidden("cmd", "submit_0");
	$form->addTextbox("First Name:", "FName");
	$form->addTextbox("Last Name:", "LName");
	$form->addEmail("Email Address:", "Email");
	$form->addTextbox("Phone Number:", "Phone");
	$form->addTextbox("Address:", "Address");
	$form->addTextbox("City:", "City");
	$form->addState("State:", "State");
	$form->addTextbox("Zip Code:", "Zip");
	$form->addButton();
	$form->render();

	include("../footer.php");
}
?>
