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
							<li><a href="#Form-Attribute-width">width</a></li>
						</ul>
					</li>
					<li><a href="#Form-Functions">Form Functions</a>
						<ul>
							<li><a href="#Form-Function-addButton">addButton</a></li>
							<li><a href="#Form-Function-addCaptcha">addCaptcha</a></li>
							<li><a href="#Form-Function-addCheckbox">addCheckbox</a></li>
							<li><a href="#Form-Function-addCheckSort">addCheckSort</a></li>
							<li><a href="#Form-Function-addCKEditor">addCKEditor</a></li>
							<li><a href="#Form-Function-addColorPicker">addColorPicker</a></li>
							<li><a href="#Form-Function-addCountry">addCountry</a></li>
							<li><a href="#Form-Function-addDate">addDate</a></li>
							<li><a href="#Form-Function-addDateRange">addDateRange</a></li>
							<li><a href="#Form-Function-addDateTime">addDateTime</a></li>
							<li><a href="#Form-Function-addEmail">addEmail</a></li>
							<li><a href="#Form-Function-addFile">addFile</a></li>
							<li><a href="#Form-Function-addHidden">addHidden</a></li>
							<li><a href="#Form-Function-addHTML">addHTML</a></li>
							<li><a href="#Form-Function-addLatLng">addLatLng</a></li>
							<li><a href="#Form-Function-addPassword">addPassword</a></li>
							<li><a href="#Form-Function-addRadio">addRadio</a></li>
							<li><a href="#Form-Function-addRating">addRating</a></li>
							<li><a href="#Form-Function-addSelect">addSelect</a></li>
							<li><a href="#Form-Function-addSlider">addSlider</a></li>
							<li><a href="#Form-Function-addSort">addSort</a></li>
							<li><a href="#Form-Function-addState">addState</a></li>
							<li><a href="#Form-Function-addTextarea">addTextarea</a></li>
							<li><a href="#Form-Function-addTextbox">addTextbox</a></li>
							<li><a href="#Form-Function-addTime">addTime</a></li>
							<li><a href="#Form-Function-addTrueFalse">addTrueFalse</a></li>
							<li><a href="#Form-Functimn-addWebEditor">addWebEditor</a></li>
							<li><a href="#Form-Function-addYesNo">addYesNo</a></li>
							<li><a href="#Form-Function-bind">bind</a></li>
							<li><a href="#Form-Function-clearButtons">clearButtons</a></li>
							<li><a href="#Form-Function-clearElements">clearElements</a></li>
							<li><a href="#Form-Function-elementsToString">elementsToString</a></li>
							<li><a href="#Form-Function-render">render</a></li>
							<li><a href="#Form-Function-setAttributes">setAttributes</a></li>
							<li><a href="#Form-Function-setReferenceValues">setReferenceValues</a></li>
							<li><a href="#Form-Function-validate">validate</a></li>
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
					
				<p>Let's begin by looking at the code snippet of our "Hello World" form seen below...</p>	

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
				<p><b>action</b>:<br/>Controls the action attribute on the &lt;form&gt; tag.  This will be defaulted to the script where the form is created.</p>

				<a name="Form-Attribute-ajax"></a>
				<p><b>ajax</b>:<br/>Activates AJAX form submission.</p>

				<a name="Form-Attribute-ajaxCallback"></a>
				<p><b>ajaxCallback</b>:<br/>If AJAX form submission is activated, this attribute allows you to specify the name of a javascript function to be
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
				<p><b>ajaxDataType</b>:<br/>If AJAX form submission is activated, this attribute allows you to specify the type of data that you're expecting back 
				from the server.  By default, jQuery will intelligently try to get the results, based on the MIME type of the response. Possible values for this
				attribute include xml, html, script, json, jsonp, and text.
				</p>

				<a name="Form-Attribute-ajaxPreCallback"></a>
				<p><b>ajaxPreCallback</b>:<br/>This attribute is very similar to <a href="#Form-Attribute-ajaxCallback">ajaxCallback</a>.  The only differences
				are the javascript function is invoked before the AJAX call is initiated and there is no response parameter passed.</p>  

				<a name="Form-Attribute-ajaxType"></a>
				<p><b>ajaxType</b>: If AJAX form submission is activated, this attribute allows you to specify if the submit method is get or post.  The
				default value is set to "post".</p>

				<a name="Form-Attribute-ajaxUrl"></a>
				<p><b>ajaxType</b>: If AJAX form submission is activated, this attribute controls where the data is submitted to - similar to the 
				<a name="Form-Attribute-method">action</a> form attribute.  This will be defaulted to the script where the form is created.</p>

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
				<p><b>class</b>:<br/>Controls the class attribute on the &lt;form&gt; tag.  This will be empty by default.</p>

				<a name="Form-Attribute-emailErrorMsgFormat"></a>
				<p><b>emailErrorMsgFormat</b>:<br/>Responsible for the error messages displayed when an invalid email address is discovered during both javascript and 
				php validation.  By default, this attribute will be set to "Error: [LABEL] contains an invalid email address."  [LABEL] is replaced with the appropriate 
				field's label.</p>

				<a name="Form-Attribute-enctype"></a>
				<p><b>enctype</b>:<br/>Controls the enctype attribute on the &lt;form&gt; tag.  For ease-of-use, this attribute will automatically be set to 
				"multipart/form-data" if one or more file elements are added to a form.  This will be empty by default.</p>

				<a name="Form-Attribute-errorMsgFormat"></a>
				<p><b>errorMsgFormat</b>:<br/>Similar to <a href="#Form-Attribute-emailErrorMsgFormat">emailErrorMsgFormat</a>, this attribute is responsible for the error 
				messages displayed when a required element is left blank in both javascript and php validation.  By default, this attribute will be set to "Error: [LABEL]
				is a required field."  [LABEL] is replaced with the appropriate field's label.</p>

				<a name="Form-Attribute-id"></a>
				<p><b>id</b>:<br/>Controls the id attribute on the &lt;form&gt; tag.  If left empty, this attribute will be set to "myform"; however, it is recommended 
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

				<a name="Form-Attribute-includesPath"></a>
				<p><b>includesPath</b>:<br/>The php-form-builder-class/inclues directory contains libraries that are essential to the project such as jQuery, CKEditor, 
				and reCAPTCHA.  Because of this, it's location must be identified by either an absolute or relative path.  The attribute defaults to "php-form-builder-class/includes",
				which will correctly identify this directory if the script where your form is created is in the same location as the php-form-builder-class directory.  For
				ease-of-use, a configuration error message will be displayed if the includes directory is not identified correctly.  If you see this error message, you will need
				to provide a relative or absolute path to where the includes directory is located in relation to the script where your form is being created (not where class.form.php 
				is located).  Absolute paths can either be identified from the document or server root.</p>

				<a name="Form-Attribute-jqueryDateFormat"></a>
				<p><b>jqueryDateFormat</b>:<br/>Controls the date format returned by the date, datetime, and daterange form elements.  By default, this attribute will be set to "MM d, yy",
				which will return dates formatted like <?=date("F j, Y")?>.  To have these elements return a MySQL friendly date format, set this attribute to "yy-mm-dd".  See 
				<a href="http://docs.jquery.com/UI/Datepicker/$.datepicker.formatDate">http://docs.jquery.com/UI/Datepicker/$.datepicker.formatDate</a> for a complete list of available options.</p>

				<a name="Form-Attribute-jqueryTimeFormat"></a>
				<p><b>jqueryTimeFormat</b>:<br/>Controls the time format returned by the time form element.  By default, this attribute will be set to "h:ii a", which will return times formatted
				like <?=date("g:i a")?>.</p>

				<a name="Form-Attribute-jsErrorFunction"></a>
				<p><b>jsErrorFunction</b>:<br/>Allows a javascript function to be specified for handling error messages.  When a required field is left blank or an invalid email
				address is provided, an error is triggered within the form's built in onsubmit event.  By default, this error message is handled by a pre-built javascript function that
				displays the error message in red above the form.  If you don't like this feature, you are free to specify your own, custom javascript function for processing the error
				message however you desire.  Your custom function will automatically be passed the error message as its one and only parameter.  This attribute should be defined without
				parenthesis as seen below...</p>

				<?php
echo '<pre>', htmlentities('
$form->setAttributes(array(
	"jsErrorFunction" => "myCustomErrorFunction"
));
'), '</pre>';
				?>

				<a name="Form-Attribute-latlngDefaultLocation"></a>
				<p><b>latlngDefaultLocation</b>:<br/>When using the latlng form element, Google Maps needs a location to center the map during initialization.  This attribute will be 
				used if the element's value is not provided.  By default, it is set to array(41.847, -87.661), which is the approximate latitude/longitude for Chicago, IL.  This attribute can be set
				as seen below...</p> 

				<?php
echo '<pre>', htmlentities('
$form->setAttributes(array(
	"latlngDefaultLocation" => array(41.847, -87.661)
));
'), '</pre>';
				?>

				<a name="Form-Attribute-map"></a>
				<p><b>map</b>:<br/>This attribute has no relation to the Google Maps functionality.  When using this project, you'll notice that form elements span the entire width of their row.  This attribute allows you to override this default behavior and render 
				multiple elements in a single row.  Simply set this attribute to a one dimensional array of numbers corresponding with how many elements you would like rendered on each line.
				In the example provided below, two elements will be displayed in the first row, one on the second row, and three on the third row.</p>

				<?php
echo '<pre>', htmlentities('
$form->setAttributes(array(
	"map" => array(2, 1, 3)
));
'), '</pre>';
				?>

				<p>It is highly recommended that you specify a <a href="#Form-Attribute-width">width</a> when using this attribute.</p>

				<a name="Form-Attribute-mapMargin"></a>
				<p><b>mapMargin</b>:<br/>When using the map attribute, this setting controls the spacing between form elements in the same row.  If the <a href="#Form-Attribute-width">width</a>
				of your form is specified in pixels, this attribute will be pixel based.  Likewise, if your form's <a href="#Form-Attribute-width">width</a> is defined as a percentage, this 
				attribute will be percentage based.  The actual margin between form elements will be twice the value of this attribute, as margin will be applied for each element on the
				appropriate left/right side.  This attribute will be set to "1" by default.</p>

				<a name="Form-Attribute-method"></a>
				<p><b>method</b>:<br/>Controls the method attribute on the &lt;form&gt; tag.  This will be set to "post" by default.</p>

				<a name="Form-Attribute-noAutoFocus"></a>
				<p><b>noAutoFocus</b>:<br/>For ease-of-use, the first non-hidden element within a form will be focussed.  This attribute can be used to prevent this default behavior
				from occurring.</p>

				<a name="Form-Attribute-preventJQueryLoad"></a>
				<p><b>preventJQueryLoad</b>:<br/>Prevents jQuery's javascript file from being included.</p>

				<a name="Form-Attribute-preventJQueryUILoad"></a>
				<p><b>preventJQueryUILoad</b>:<br/>Prevents jQuery UI's javascript file from being included.</p>

				<a name="Form-Attribute-preventQTipLoad"></a>
				<p><b>preventQTipLoad</b>:<br/>Prevents qTip's javascript file from being included.</p>

				<a name="Form-Attribute-preventGoogleMapsLoad"></a>
				<p><b>preventGoogleMapsLoad</b>:<br/>Prevents Google Map's javascript file from being included.</p>

				<a name="Form-Attribute-preventTinyMCELoad"></a>
				<p><b>preventTinyMCELoad</b>:<br/>Prevents TinyMCE's javascript file from being included.</p>

				<a name="Form-Attribute-preventTinyMCEInitLoad"></a>
				<p><b>preventTinyMCEInitLoad</b>:<br/>Prevents TinyMCE's init sections from being rendered.</p>

				<a name="Form-Attribute-preventCaptchaLoad"></a>
				<p><b>preventCaptchaLoad</b>:<br/>Prevents reCAPTCHA's javascript file from being included.</p>

				<a name="Form-Attribute-preventCKEditorLoad"></a>
				<p><b>preventCKEditorLoad</b>:<br/>Prevents CKEditor's javascript file from being included.</p>

				<a name="Form-Attribute-preventDefaultCSS"></a>
				<p><b>preventDefaultCSS</b>:<br/>This project generates flexible, css-driven markup.  For ease-of-use, a default stylesheet is applied; however, you can set this attribute to turn
				off these css definitions.</p>

				<a name="Form-Attribute-preventXHTMLStrict"></a>
				<p><b>preventXHTMLStrict</b>:<br/>The php-form-builder-class/includes directory contains two files - js.php and css.php - that are used to generate the form's required javascript/css 
				information and externally include them in the document's &lt;head&gt; tag for xhtml 1.0 strict compliance.  If you're using this project in an environment with its own session 
				handler, such as Joomla!, you may need to use this attribute to render the form's javascript/css inside the &lt;body&gt; tag.
				</p>

				<a name="Form-Attribute-style"></a>
				<p><b>style</b>:<br/>Controls the style attribute on the &lt;form&gt; tag.  This attribute will be empty by default.</p>

				<a name="Form-Attribute-tooltipIcon"></a>
				<p><b>tooltipIcon</b>:<br/>Controls the image displayed for an element's tooltip.  By default, this attribute is set to "php-form-builder-class/includes/jquery/plugins/qtip/tooltip-icon.gif"
				<img src="../includes/jquery/plugins/qtip/tooltip-icon.gif" alt=""/></p>

				<a name="Form-Attribute-tooltipBorderColor"></a>
				<p><b>tooltipBorderColor</b>:<br/>Allows the tooltip's border color to be customized.  By default, this attribute will be set to a light grey.</p>

				<a name="Form-Attribute-width"></a>
				<p><b>width</b>:<br/>Controls the form's width.  By default, this attribute will be blank causing the form to span the entire width of its container.  This parameter can be set
				to a pixel or percentage value.</p>  

				<a name="Form-Functions"></a>
				<h3>Form Functions</h3>
				<p>Below, you will find a list of all available form functions you can invoke within this project.  Before you can use any of these functions, you will need a create a new
				form object instance.  If you have questions about this, review the <a href="#The-Hello-World-of-PHP-Form-Builder-Class">"Hello World"</a> tutorial provided above.</p>

				<a name="Form-Functions-addButton"></a>
				<p><b>addButton</b>:</p>

				<?php
echo '<pre>', htmlentities('
addButton($value="Submit", $type="submit", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addCaptcha"></a>
				<p><b>addCaptcha</b>:</p>

				<?php
echo '<pre>', htmlentities('
addCaptcha($label="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addCheckbox"></a>
				<p><b>addCheckbox</b>:</p>

				<?php
echo '<pre>', htmlentities('
addCheckbox($label, $name, $value="", $options="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addCheckSort"></a>
				<p><b>addCheckSort</b>:</p>

				<?php
echo '<pre>', htmlentities('
addCheckSort($label, $name, $value="", $options="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addCKEditor"></a>
				<p><b>addCKEditor</b>:</p>

				<?php
echo '<pre>', htmlentities('
addCKEditor($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addColorPicker"></a>
				<p><b>addColorPicker</b>:</p>

				<?php
echo '<pre>', htmlentities('
addColorPicker($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addCountry"></a>
				<p><b>addCountry</b>:</p>

				<?php
echo '<pre>', htmlentities('
addCountry($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addDate"></a>
				<p><b>addDate</b>:</p>

				<?php
echo '<pre>', htmlentities('
addDate($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addDateRange"></a>
				<p><b>addDateRange</b>:</p>

				<?php
echo '<pre>', htmlentities('
addDateRange($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addDateTime"></a>
				<p><b>addDateTime</b>:</p>

				<?php
echo '<pre>', htmlentities('
addDateTime($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addEmail"></a>
				<p><b>addEmail</b>:</p>

				<?php
echo '<pre>', htmlentities('
addEmail($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addFile"></a>
				<p><b>addFile</b>:</p>

				<?php
echo '<pre>', htmlentities('
addFile($label, $name, $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addHidden"></a>
				<p><b>addHidden</b>:</p>

				<?php
echo '<pre>', htmlentities('
addHidden($name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addHTML"></a>
				<p><b>addHTML</b>:</p>

				<?php
echo '<pre>', htmlentities('
addHTML($value)
'), '</pre>';
				?>

				<a name="Form-Functions-addLatLng"></a>
				<p><b>addLatLng</b>:</p>

				<?php
echo '<pre>', htmlentities('
addLatLng($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addPassword"></a>
				<p><b>addPassword</b>:</p>

				<?php
echo '<pre>', htmlentities('
addPassword($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addRadio"></a>
				<p><b>addRadio</b>:</p>

				<?php
echo '<pre>', htmlentities('
addRadio($label, $name, $value="", $options="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addRating"></a>
				<p><b>addRating</b>:</p>

				<?php
echo '<pre>', htmlentities('
addRating($label, $name, $value="", $options="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addSelect"></a>
				<p><b>addSelect</b>:</p>

				<?php
echo '<pre>', htmlentities('
addSelect($label, $name, $value="", $options="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addSlider"></a>
				<p><b>addSlider</b>:</p>

				<?php
echo '<pre>', htmlentities('
addSlider($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addSort"></a>
				<p><b>addSort</b>:</p>

				<?php
echo '<pre>', htmlentities('
addSort($label, $name, $options="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addState"></a>
				<p><b>addState</b>:</p>

				<?php
echo '<pre>', htmlentities('
addState($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addTextarea"></a>
				<p><b>addTextarea</b>:</p>

				<?php
echo '<pre>', htmlentities('
addTextarea($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addTextbox"></a>
				<p><b>addTextbox</b>:</p>

				<?php
echo '<pre>', htmlentities('
addTextbox($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addTime"></a>
				<p><b>addTime</b>:</p>

				<?php
echo '<pre>', htmlentities('
addTime($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addTrueFalse"></a>
				<p><b>addTrueFalse</b>:</p>

				<?php
echo '<pre>', htmlentities('
addTrueFalse($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addWebEditor"></a>
				<p><b>addWebEditor</b>:</p>

				<?php
echo '<pre>', htmlentities('
addWebEditor($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addYesNo"></a>
				<p><b>addYesNo</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
addYesNo($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-bind"></a>
				<p><b>bind</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
bind($ref, $jsIfCondition = "", $phpIfCondition = "")
'), '</pre>';
				?>

				<a name="Form-Functions-clearButtons"></a>
				<p><b>clearButtons</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
clearButtons()
'), '</pre>';
				?>

				<a name="Form-Functions-clearElements"></a>
				<p><b>clearElements</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
clearElements()
'), '</pre>';
				?>

				<a name="Form-Functions-elementsToString"></a>
				<p><b>elementsToString</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
elementsToString()
'), '</pre>';
				?>

				<a name="Form-Functions-render"></a>
				<p><b>render</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
render($returnString=false)
'), '</pre>';
				?>

				<a name="Form-Functions-setAttributes"></a>
				<p><b>setAttributes</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
setAttributes($params)
'), '</pre>';
				?>

				<a name="Form-Functions-setReferenceValues"></a>
				<p><b>setReferenceValues</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
setReferenceValues($params)
'), '</pre>';
				?>

				<a name="Form-Functions-validate"></a>
				<p><b>validate</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
validate()
'), '</pre>';
				?>
			</div>
		</div>	
	</body>
</html>
