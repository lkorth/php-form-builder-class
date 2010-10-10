<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0"))) {
	$form = new form("email_" . substr($_POST["cmd"], -1));
	if($form->validate()) {
		$result = $form->email("my_username", "my_password", array(
			"to" => "my_recipient(s)", 
			"subject" => "my_subject", 
			"from" => "my_from", 
			"replyto" => "replyto", 
			"cc" => "my_cc", 
			"bcc" => "my_bcc", 
			"preHTML" => "my_prehtml", 
			"postHTML" => "my_posthtml",
			"css" => '<style type="text/css">...</style>',
			"cssFile" => "my_css.css or http://www.my_domain.com/my_css.css",
			"textonly" => "true/false"
		));

		if($result)
			header("Location: email.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Congratulations! The information you enter has been emailed from your Google Gmail account."));
		else
			header("Location: email.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Oops! The following error has occurred while sending information from your Google Gmail account.  " .  $form->getEmailError()));
	}
	else
		header("Location: email.php");

	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	$title = "Email w/Google's Gmail Service";
	include("../header.php");
	?>

	<p><b>Email w/Google's Gmail Service</b> - This project's email function provides the ability to email a form's submitted data using your Google Gmail account.
	This function has four parameters as seen below.</p>

	<ul style="margin: 0;">
		<li>Google Account Email Address - Email address (including domain) of your Google Gmail account.</li>
		<li>Google Account Password - Password of your Google Gmail account.</li>
		<li>Additional Parameters (optional) - This parameter allows you to set various email settings through an associative array of key/value pairs.  Available settings are provided below.
			<ul style="margin: 0;">
				<li>to - Sets the email's to address.  If blank, this parameter will be set to the Google Gmail account email address used in the first parameter.</li>
				<li>subject - Sets the email's subject.</li>
				<li>from - Sets the email's from address.  If blank, this parameter will be set to the Google Gmail account email address used in the first parameter.</li>
				<li>replyto - Sets the email's reply to address.  If empty, the from address will be used.</li>
				<li>cc - Sets the email's CC address.</li>
				<li>bcc - Sets the email's BCC address.</li>
				<li>preHTML - Allows you to prepend html content above the form's submitted data.</li>
				<li>postHTML - Allows you to append html content below the form's submitted data.</li>
				<li>textonly - Sends text-only version of the form's submitted data.  By default, the email function will send an email containing both an html and text version.</li>
				<li>css - Gives you the ability to style the html email as needed.  This parameter should be passed as a string beginning with &lt;style type="text/css"&gt; and ending with &lt;/style&gt;</li>
				<li>cssFile - Gives you the ability to style the html email as needed by specifying a css include file.</li>
			</ul>
		</li>
	</ul>

	<p>Before getting started, you'll want to review the checklist of information provided below to ensure you have a good understanding on how this functionality works.</p>

	<ol style="margin: 0;">
		<li>You'll need a Google Gmail account.  If you don't have one, you can create one by clicking the "Create an account" link at <a href="http://mail.google.com">http://mail.google.com</a>.</li>
		<li>to, replyto, cc, and bcc can contain multiple email addresses - just separate them with commas.</li>
		<li>to, from, replyto, cc, bcc can contain email addresses formatted as either "my@email.com" or "My Email &lt;my@email.com&gt;"</li>
		<li>Within the email function, a call is made to another public function - getEmail - to get the email's html/text content.  If you already have an existing system in place for sending email, you can use this function instead
		of the project's email function to build a string containing an html/text representation of the form's submitted data.  By default, this function will return html, but you can pass true as the first and only parameter to return
		text.</li>
	</ol>	

	<p>In the php source code of this example file, you'll see that the email function call currently contains demo authentication/email settings ("my_email", "my_password", etc).
	You'll want to replace these with your information.</p>

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
