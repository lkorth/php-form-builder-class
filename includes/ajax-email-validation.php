<?php
if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
	echo "invalid";
else
	echo "valid";
?>
