<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

header("Content-type: application/json");

$form = new form("login");
if($form->validate()) {
	if($_GET["Username"] == "formbuilder" && $_GET["Password"] == "password")
		$response = array("status" => "Success", "message" => "You're Logged In");
	else
		$response = array("status" => "Error", "message" => "Invalid Username/Password");

	echo json_encode($response);
}		
else
	echo $form->getErrorMessage("json");

exit();
?>
