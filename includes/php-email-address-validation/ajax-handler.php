<?php
include("EmailAddressValidator.php");
$emailObj = new EmailAddressValidator;
if($emailObj->check_email_address($_POST["email"]))
	echo "valid";
else
	echo "invalid";
?>
