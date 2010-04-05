<?php
error_reporting(E_ALL);
header("Content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
echo "<response>";
if($_GET["Username"] == "formbuilder" && $_GET["Password"] == "password")
{
	echo "<status>Success</status>";
	echo "<message>You're Logged In</message>";
}	
else
{
	echo "<status>Error</status>";
	echo "<message>Invalid Username/Password</message>";
}
echo "</response>";
exit();
?>
