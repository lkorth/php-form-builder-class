<?php
error_reporting(E_ALL);
header("Content-type: application/json");
if($_GET["Username"] == "formbuilder" && $_GET["Password"] == "password")
	$response = array("status" => "Success", "message" => "You're Logged In");
else
	$response = array("status" => "Error", "message" => "Invalid Username/Password");

echo json_encode($response);
exit();
?>
