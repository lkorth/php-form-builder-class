<?php
include("EmailAddressValidator.php");
$emailObj = new EmailAddressValidator;
if(!$emailObj->check_email_address($_POST["email"]))
	echo str_replace("[LABEL]", $_POST["label"], $_POST["format"]);

?>
