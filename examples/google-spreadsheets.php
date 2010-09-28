<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0"))) {
	$form = new form("googlespreadsheets_" . substr($_POST["cmd"], -1));
	if($form->validate()) {
		$form->sendToGoogleSpreadsheet("my_email", "my_password", "my_spreadsheet", "my_worksheet");
		header("Location: google-spreadsheets.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Congratulations! The information you enter passed the form's validation."));
	}	
	else
		header("Location: google-spreadsheets.php");
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>PHP Form Builder Class | Examples | Google Spreadsheets</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<link href="style.css" rel="stylesheet" type="text/css"/>
			<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>  
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2><a href="../index.php">PHP Form Builder Class</a> / <a href="index.php">Examples</a> / Google Spreadsheets</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Google Spreadsheets</b> - This project's sendToGoogleSpreadsheet function provides the ability to send a form's submitted data direclty to a Google Docs spreadsheet using the Google Spreadsheet API.
				This function has four parameters as seen below.</p>

				<ul style="margin: 0;">
					<li>Google Account Email Address - Email address (including domain) of your Google account.</li>
					<li>Google Account Password - Password of your Google account.</li>
					<li>Google Docs Spreadsheet - The title of the spreadsheet where you'd like the form's submitted data to be sent.</li>
					<li>Worksheet (optional) - The title of the worksheet to be used within the specified spreadsheet.
					This parameter will default to the the spreadsheet's first worksheet.</li> 
				</ul>

				<p>Before getting started, you'll want to review the checklist of necessary prerequisites provided below to ensure you have everything configured
				correctly.</p>

				<ol style="margin: 0;">
					<li>You'll need a Google account.  If you don't have one, you can create one by clicking the "Create an account now" link 
					at <a href="http://docs.google.com">http://docs.google.com</a>.</li>
					<li>You have to have a Google Docs spreadsheet to collect your form's submitted data.  Getting this setup is easy.  Simply login to <a href="http://docs.google.com">http://docs.google.com</a>,
					click the "Creat new" button, and select "Spreadsheet" from the list of available options.  Finally, save and name your spreadsheet by clicking the "Save now" button.</li>
					<li>Once you've created, named, and saved your spreadsheet, the next task you will need to complete is to populate the initial row of your spreadsheet with column identifiers.
					An important thing to note is that these column identifiers must match an element's label used in your form ("First Name:", "Last Name:", etc).  This enables the form's submitted 
					data to be correctly placed within the appropriate column.  Your spreadsheet does not need to contain a column for every element used in the form - data for those elements that are
					not included will just not be collected.  Likewise, your spreadsheet can contain column identifiers that don't match an element's label used in the form - data for those columns will
					be left blank.</li>
				</ol>

				<p>In the php source code of this example file, you'll see that the sendToGoogleSpreadsheet function call currently contains demo authentication/spreadshet settings ("my_username", "my_password", etc).
				You'll want to replace these with your information. </p>

				<?php
				$form = new form("googlespreadsheets_0");
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
				?>

			</div>	
		</body>
	</html>	
	<?php
}
?>
