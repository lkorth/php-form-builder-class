<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0"))) {
	$form = new form("googlespreadsheets_" . substr($_POST["cmd"], -1));
	if($form->validate()) {
		if($form->sendToGoogleSpreadsheet("my_email", "my_password", "my_spreadsheet_title", "(optional) my_worksheet_title"))
			header("Location: google-spreadsheets.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Congratulations! The information you enter has been sent your Google Docs spreadsheet."));
		else
			header("Location: google-spreadsheets.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Oops! The following error has occurred while sending information to your Google Docs spreadsheet.  " .  $form->getGoogleSpreadsheetError()));
	}	
	else
		header("Location: google-spreadsheets.php");
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	$title = "Google Spreadsheets";
	include("../header.php");
	?>

	<p><b>Google Spreadsheets</b> - This project's sendToGoogleSpreadsheet function provides the ability to send a form's submitted data direclty to a Google Docs spreadsheet using the Google Spreadsheet API.
	This function has four parameters as seen below.</p>

	<ul style="margin: 0;">
		<li>Google Account Email Address - Email address (including domain) of your Google account.</li>
		<li>Google Account Password - Password of your Google account.</li>
		<li>Google Docs Spreadsheet - The title of the spreadsheet where you'd like the form's submitted data to be sent.</li>
		<li>Worksheet (optional) - The title of the worksheet to be used within the specified spreadsheet.
		This parameter will default to the the spreadsheet's first worksheet.</li> 
	</ul>

	<p>Before getting started, you'll want to review the checklist of information provided below to ensure you have a good understanding on how this functionality works.</p>

	<ol style="margin: 0;">
		<li>You'll need a Google account.  If you don't have one, you can create one by clicking the "Create an account now" link at <a href="http://docs.google.com">http://docs.google.com</a>.</li>
		<li>If the spreadsheet title you specify in the sendToGoogleSpreadsheet function does not exist, a new spreadsheet will be created for you with the appropriate title and column headers.</li>
		<li>If you're creating your spreadsheet manually through the Google Docs GUI, an important thing to keep in mind is that Google will treat the initial row of cells as column identifiers.
		These column identifiers must match an element's label used in your form ("First Name:", "Last Name:", etc), which enables the form's submitted 
		data to be correctly placed within the appropriate column.  If the spreadsheet you specify in the sendToGoogleSpreadsheet function exists but has no inital row of column headers, your form's data will not
		populated upon submission.  Your spreadsheet does not need to contain a column for every element used in the form - data for those elements that are
		not included will just not be collected.  Likewise, your spreadsheet can contain column identifiers that don't match an element's label used in the form - data for those columns will
		be left blank.</li>
		<li>Elements of type hidden, captcha, button, html, and htmlexternal will not be included in the information that is sent to your Google spreadsheet.</li>
		<li>The "ignoreGSSend" element attribute can be applied to form elements that you do not want to be send to your Google Docs spreadsheet.  The hidden field "cmd" has this attribute set in the form below.</li>
		<li>If you're populating an existing spreadsheet in your Google Docs account, you can store the web server's date/time at the moment the form's data is submitted
		by adding "Timestamp" as a column header.</li>
	</ol>

	<p>In the php source code of this example file, you'll see that the sendToGoogleSpreadsheet function call currently contains demo authentication/spreadshet settings ("my_email", "my_password", etc).
	You'll want to replace these with your information.</p>

	<?php
	$form = new form("googlespreadsheets_0", 500);
	$form->setAttributes(array(
		"map" => array(2, 2, 1, 3)
	));

	if(!empty($_GET["errormsg_0"]))
		$form->errorMsg = filter_var($_GET["errormsg_0"], FILTER_SANITIZE_SPECIAL_CHARS);

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
