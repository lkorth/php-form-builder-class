<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>PHP Form Builder Class | Documentation</title>
		<link href="../style.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip">Download Version <?php echo(file_get_contents('../version'));?></a></div>
		<div id="pfbc_banner">
			<h2>PHP Form Builder Class / Documentation</h2>
			<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
		</div>

		<div id="pfbc_content">
			<b>Table of Contents:</b>
			<div>
				<ul style="margin-top: 0; padding-top: 0;">
					<li><a href="#Introduction">Introduction</a></li>
					<li><a href="#The-Hello-World-of-PHP-Form-Builder-Class">The "Hello World" of PHP Form Builder Class</a></li>
					<li><a href="#Form-Attributes">Form Attributes</a>
						<ul>
							<li><a href="#Form-Attribute-action">action</a></li>
							<li><a href="#Form-Attribute-ajax">ajax</a></li>
							<li><a href="#Form-Attribute-ajaxCallback">ajaxCallback</a></li>
							<li><a href="#Form-Attribute-ajaxDataType">ajaxDataType</a></li>
							<li><a href="#Form-Attribute-ajaxPreCallback">ajaxPreCallback</a></li>
							<li><a href="#Form-Attribute-ajaxType">ajaxType</a></li>
							<li><a href="#Form-Attribute-ajaxUrl">ajaxUrl</a></li>
							<li><a href="#Form-Attribute-captchaLang">captchaLang</a></li>
							<li><a href="#Form-Attribute-captchaPublicKey">captchaPublicKey</a></li>
							<li><a href="#Form-Attribute-captchaPrivateKey">captchaPrivateKey</a></li>
							<li><a href="#Form-Attribute-captchaTheme">captchaTheme</a></li>
							<li><a href="#Form-Attribute-ckeditorCustomConfig">ckeditorCustomConfig</a></li>
							<li><a href="#Form-Attribute-ckeditorLang">ckeditorLang</a></li>
							<li><a href="#Form-Attribute-class">class</a></li>
							<li><a href="#Form-Attribute-emailErrorMsgFormat">emailErrorMsgFormat</a></li>
							<li><a href="#Form-Attribute-enctype">enctype</a></li>
							<li><a href="#Form-Attribute-errorMsgFormat">errorMsgFormat</a></li>
							<li><a href="#Form-Attribute-id">id</a></li>
							<li><a href="#Form-Attribute-includesPath">includesPath</a></li>
							<li><a href="#Form-Attribute-jqueryDateFormat">jqueryDateFormat</a></li>
							<li><a href="#Form-Attribute-jqueryTimeFormat">jqueryTimeFormat</a></li>
							<li><a href="#Form-Attribute-jsErrorFunction">jsErrorFunction</a></li>
							<li><a href="#Form-Attribute-latlngDefaultLocation">latlngDefaultLocation</a></li>
							<li><a href="#Form-Attribute-map">map</a></li>
							<li><a href="#Form-Attribute-mapMargin">mapMargin</a></li>
							<li><a href="#Form-Attribute-method">method</a></li>
							<li><a href="#Form-Attribute-noAutoFocus">noAutoFocus</a></li>
							<li><a href="#Form-Attribute-onsubmitFunction">onsubmitFunction</a></li>
							<li><a href="#Form-Attribute-preventJQueryLoad">preventJQueryLoad</a></li>
							<li><a href="#Form-Attribute-preventJQueryUILoad">preventJQueryUILoad</a></li>
							<li><a href="#Form-Attribute-preventQTipLoad">preventQTipLoad</a></li>
							<li><a href="#Form-Attribute-preventGoogleMapsLoad">preventGoogleMapsLoad</a></li>
							<li><a href="#Form-Attribute-preventTinyMCELoad">preventTinyMCELoad</a></li>
							<li><a href="#Form-Attribute-preventTinyMCEInitLoad">preventTinyMCEInitLoad</a></li>
							<li><a href="#Form-Attribute-preventCaptchaLoad">preventCaptchaLoad</a></li>
							<li><a href="#Form-Attribute-preventCKEditorLoad">preventCKEditorLoad</a></li>
							<li><a href="#Form-Attribute-preventDefaultCSS">preventDefaultCSS</a></li>
							<li><a href="#Form-Attribute-preventXHTMLStrict">preventXHTMLStrict</a></li>
							<li><a href="#Form-Attribute-style">style</a></li>
							<li><a href="#Form-Attribute-tooltipIcon">tooltipIcon</a></li>
							<li><a href="#Form-Attribute-tooltipBorderColor">tooltipBorderColor</a></li>
						</ul>
					</li>
				</ul>
			</div>

			<div class="pfbc_doc_section">
				<a name="Introduction"></a>
				<h3>Introduction</h3>
				<p>The purpose of this document is to provide a reference guide for developers to access while using this project.</p>
			</div>

			<div class="pfbc_doc_section">
				<a name="The-Hello-World-of-PHP-Form-Builder-Class"></a>
				<h3>The "Hello World" of PHP Form Builder Class</h3>
				<p>Before getting started, you will need to <a href="http://code.google.com/apis/maps/documentation/introduction.html">downloaded the latest version 
				of this project</a>, unzip formbuilder.zip, and install the php-form-builder-class directory on your web server.  After you've done this, you're 
				ready to get started creating your first form using this project.</p>
					
				<p>Consider the code snippet below...</p>	

				<?php
echo '<pre>', highlight_string('<?php
include("php-form-builder-class/class.form.php");

$form = new form("HelloWorld");
$form->setAttributes(array(
	"width" => 400
));

$form->addTextbox("My Textbox:", "MyTextbox", "Hello World");
$form->addButton();
$form->render();
?>', true), '</pre>';
				?>

				<p>The first thing you'll notice is that class.form.php is included with...</p>

				<?php
echo '<pre>', htmlentities('
include("php-form-builder-class/class.form.php");
'), '</pre>';
				?>

				<p>This file is where most of the magic happens within the project. It can be found within the php-form-builder-class 
				directory, and must be included in each script that makes use of this project.</p>
				
				<p>Next, a new form object is created with...</p>	

				<?php
echo '<pre>', htmlentities('
$form = new form("HelloWorld");
'), '</pre>';
				?>

				<p>An identifier, "HelloWorld" in this case, is included.  If this identifier is not provided, "myform" will be used; however,
				it is recommended that you include an identifier with each form you create.  This becomes increasingly important when multiple
				forms are rendered on the same webpage.</p>	

				<p>Once the form object is created, the setAttributes() function is invoked...</p>

				<?php
echo '<pre>', htmlentities('
$form->setAttributes(array(
	"width" => 400
));
'), '</pre>';
				?>

				<p>The setAttributes() function accepts an associative array of key/value pairs, and is used to assign various attributes to 
				the form.  Chances are, you will be calling this function in most all of the forms you create.  In this "Hello World" example, 
				the form's width is set to 400.  See the <a href="">Form Attributes</a> section for a detailed list of form attributes that 
				can be included in the associative array passed to the setAttributes() function.</p>

				<p>Now, we're ready to add our form elements.  In our "Hello World" example, there's only one element - a textbox.</p>

				<?php
echo '<pre>', htmlentities('
$form->addTextbox("My Textbox:", "MyTextbox", "Hello World");
'), '</pre>';
				?>
				
				<p>More information on the addTextbox() function, and all the other functions for rendering form elements,  can be found 
				in the <a href="">Form Elements</a> section.  This textbox has a label assigned as "My Textbox:", a name set to "MyTextbox", and a
				default value of "Hello World".</p>

				<p>A button is attached to the form with...</p>

				<?php
echo '<pre>', htmlentities('
$form->addButton();
'), '</pre>';
				?>

				<p>The addButton() function has optional parameters for customizing the appearance and behavior of your buttons.  With no paramaters 
				provided, it will render a submit button titled "Submit".</p>

				<p>The final function called is render()...</p>

				<?php
echo '<pre>', htmlentities('
$form->render();
'), '</pre>';
				?>

				<p>The render() function is responsible for a variety of tasks including building the form's html markup, including the appropriate
				javascript/css include files, and applying javascript validation if applicable.</p>

				<p>Congratulations!  You have just created your first form using the PHP Form Builder Class.  If you're like me, and like learning 
				about a new piece of software by jumping right in and using it, you should <a href="../examples">check out the other included examples</a>, 
				which provide a more in depth look at the various functionality included in this project.  If you're not like me, and like learning about a
				new piece of software by reading the manual first, then you should continue reading this document.</p>
			</div>

			<div class="pfbc_doc_section">
				<a name="Form-Attributes"></a>
				<h3>Form Attributes</h3>
				<p>Form Attributes are set through the setAttributes() function and provide a way to customize how a particular form appears and/or behaves.
				These customizations may include specifying a form's width, indicating that you want to turn on ajax submission, or changing the default
				date format returned by the jQuery date/daterange/datetime elements.  Below you will find a detailed list of all the available form attributes
				you can pass to the setAttributes() function.</p>

				<a name="Form-Attribute-action"></a>
				<p><b>action</b>:<br>Controls the action attribute on the &lt;form&gt; tag.  This will be defaulted to the script where the form is created.</p>

				<a name="Form-Attribute-ajax"></a>
				<p><b>ajax</b>:<br>Activates AJAX form submission.</p>

				<a name="Form-Attribute-ajaxCallback"></a>
				<p><b>ajaxCallback</b>:<br>If AJAX form submission is activated, this attribute allows you to specify the name of a javascript function to be
				invoked after a successful submission.  This js function name should be passed as a string without any parenthesis or parameters.  An example
				would be...</p>

				<?php
echo '<pre>', htmlentities('
$form->setAttributes(array(
	"ajaxCallback" => "myFunction"
));
'), '</pre>';
				?>

				<p>Any response (xml, json, text, etc) returned by the web server will be automatically passed to your js function as its one and only parameter.
				By default, this attribute will be set to "alert" meaning that any text response returned by the web server will be display in an alert message.
				If the response is not plain text (xml, json, etc) and you have not modified this attributes default value of "alert", no alert message will be
				triggered.</p>

				<a name="Form-Attribute-ajaxDataType"></a>
				<p><b>ajaxDataType</b>:<br>If AJAX form submission is activated, this attribute allows you to specify the type of data that you're expecting back 
				from the server.  By default, jQuery will intelligently try to get the results, based on the MIME type of the response. Possible values for this
				attribute include xml, html, script, json, jsonp, and text.
				</p>

				<a name="Form-Attribute-ajaxPreCallback"></a>
				<p><b>ajaxPreCallback</b>:<br>This attribute is very similar to <a href="#Form-Attribute-ajaxCallback">ajaxCallback</a>.  The only differences
				are the javascript function is invoked before the AJAX call is initiated and there is no response parameter passed.</p>  

				<a name="Form-Attribute-ajaxType"></a>
				<p><b>ajaxType</b>: If AJAX form submission is activated, this attribute allows you to specify if the submit method is get or post.  The
				default value is set to "post".</p>

				<a name="Form-Attribute-ajaxUrl"></a>
				<p><b>ajaxType</b>: If AJAX form submission is activated, this attribute controls where the data is submitted to - similar to the 
				<a name="Form-Attribute-method">action</a> form attribute.  This will be defaulted to the script where the form is created.  

				<a name="Form-Attribute-captchaLang"></a>
				<p><b>captchaLang</b>: Controls the language used by reCAPTCHA.  Supported languages include English(en), Dutch(nl), French(fr), German(de), 
				Portuguese(pt), Russian(ru), Spanish(es), and Turkish(tr).  This attribute defaults to English(en).  When specifying this attribute, use
				the two-character code seen within the parenthesis in the supported languages list above. See <a href="http://recaptcha.net/apidocs/captcha/client.html">http://recaptcha.net/apidocs/captcha/client.html</a>
				for more information on this reCAPTCHA setting.</p>

				<a name="Form-Attribute-captchaPublicKey"></a>
				<p><b>captchaPublicKey</b>: For security purposes, reCAPTCHA requires a public/private key pair to be referenced when using their web service.
				Typically, these keys are resticted to a specific domain (and all sub-domains); however, you can generate keys that are enabled for all domains
				through a global option during signup.  By default, the captchaPublic/PrivateKey attributes are set as global reCATPCHA keys which will allow you to
				use the captcha form element regardless of domain.  For increased security, it is recommended that you 
				<a href="http://recaptcha.net/api/getkey">generate reCAPTCHA public/private keys</a> for your specific domain to overwrite these default settings.
				See <a href="http://recaptcha.net/apidocs/captcha/client.html">http://recaptcha.net/apidocs/captcha/client.html</a> for more information on this 
				reCAPTCHA setting.</p>

				<a name="Form-Attribute-captchaPrivateKey"></a>
				<p><b>captchaPrivateKey</b>: See <a href="#Form-Attribute-captchaPublicKey">captchaPublicKey</a> attribute above.</p>

				<a name="Form-Attribute-captchaTheme"></a>
				<p><b>captchaTheme</b>: reCAPTCHA provides several pre-built themes that can be used to customize the appearance of their interface.  Options include
				red, white, blackglass, and clean.  By default, the red theme will be used.  See <a href="http://recaptcha.net/apidocs/captcha/client.html">http://recaptcha.net/apidocs/captcha/client.html</a>
				for more information on this reCAPTCHA setting.</p>

				<a name="Form-Attribute-ckeditorCustomConfig"></a>
				<p><b>ckeditorCustomConfig</b>: Allows a URL path to a CKEditor custom configuration file to be loaded. If not provided, includes/ckeditor/config.js 
				will be used.  See <a href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html#.customConfig">http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html#.customConfig</a> 
				for more information on this CKEditor configuration setting.</p>

				<a name="Form-Attribute-ckeditorLang"></a>
				<p><b>ckeditorLang</b>: Allows the language within CKEditor's user interface to be customized.  If empty, the editor automatically localizes to the user's language, if supported, 
				otherwise the CKEDITOR.config.defaultLanguage setting is used.  See <a href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html#.language">http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html#.language</a>
				for more information on this CKEditor configuration setting.</p>

				<a name="Form-Attribute-class"></a>
				<p><b>class</b>:<br>Controls the class attribute on the &lt;form&gt; tag.  This will be empty by default.</p>

				<a name="Form-Attribute-emailErrorMsgFormat"></a>
				<p><b>emailErrorMsgFormat</b>:<br>Responsible for the error messages displayed when an invalid email address is discovered during both javascript and 
				php validation.  By default, this attribute will be set to "Error: [LABEL] contains an invalid email address."  [LABEL] is replaced with the appropriate 
				field's label.</p>

				<a name="Form-Attribute-enctype"></a>
				<p><b>enctype</b>:<br>Controls the enctype attribute on the &lt;form&gt; tag.  For ease-of-use, this attribute will automatically be set to 
				"multipart/form-data" if one or more file elements are added to a form.  This will be empty by default.</p>

				<a name="Form-Attribute-errorMsgFormat"></a>
				<p><b>errorMsgFormat</b>:<br>Similar to <a href="#Form-Attribute-emailErrorMsgFormat">emailErrorMsgFormat</a>, this attribute is responsible for the error 
				messages displayed when a required element is left blank in both javascript and php validation.  By default, this attribute will be set to "Error: [LABEL]
				is a required field."  [LABEL] is replaced with the appropriate field's label.</p>

				<a name="Form-Attribute-id"></a>
				<p><b>id</b>:<br>Controls the id attribute on the &lt;form&gt; tag.  If left empty, this attribute will be set to "myform"; however, it is recommended 
				that you include a unique id with each form you create.  This becomes increasingly important when multiple forms are rendered on the same webpage.
				This attribute can be defined when creating a new form object...</p>

				<?php
echo '<pre>', htmlentities('
$form = new form("myID");
'), '</pre>';
				?>

				<p>Or in the setAttributes() function...</p>

				<?php
echo '<pre>', htmlentities('
$form->setAttributes(array(
	"id" => "myID"
));
'), '</pre>';
				?>
			</div>

		</div>	
	</body>
</html>
