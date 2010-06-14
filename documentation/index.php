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
			<h2><a href="../index.php">PHP Form Builder Class</a> / Documentation</h2>
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
							<li><a href="#Form-Attribute-jqueryUITheme">jqueryUITheme</a></li>
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
							<li><a href="#Form-Function-setValues">setValues</a></li>
							<li><a href="#Form-Function-validate">validate</a></li>
						</ul>	
					</li>	
				</ul>
			</div>

			<div class="pfbc_doc_section">
				<a name="Introduction"></a>
				<h3>Introduction</h3>
				<p>The purpose of this document is to provide a reference guide for users to access while incorporating this project into their development.</p>
			</div>

			<div class="pfbc_doc_section">
				<a name="The-Hello-World-of-PHP-Form-Builder-Class"></a>
				<h3>The "Hello World" of PHP Form Builder Class</h3>
				<p>Before getting started, you will need to <a href="http://code.google.com/p/php-form-builder-class/downloads/list">download the latest version
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

				<p>This file can be found within the php-form-builder-class directory, and must be included in each script that makes use of this project.</p>
				
				<p>Next, a new form object is created with...</p>	

				<?php
echo '<pre>', htmlentities('
$form = new form("HelloWorld");
'), '</pre>';
				?>

				<p>An identifier, "HelloWorld" in this case, is included.  If this identifier is not provided, "myform" will be used; however,
				it is recommended that you include an identifier with each form you create.  This becomes increasingly important when multiple
				forms are rendered on the same webpage.</p>	

				<p>Once the form object is created, the <a href="#Form-Function-setAttributes">setAttributes()</a> function is invoked...</p>

				<?php
echo '<pre>', htmlentities('
$form->setAttributes(array(
	"width" => 400
));
'), '</pre>';
				?>

				<p>The <a href="#Form-Function-setAttributes">setAttributes()</a> function accepts an associative array of key/value pairs, and is used to assign various attributes to 
				the form.  Chances are, you will be calling this function in most all of the forms you create.  In this "Hello World" example, 
				the form's width is set to 400 pixels.  See the <a href="">Form Attributes</a> section for a detailed list of form attributes that 
				can be included in the associative array passed to the <a href="#Form-Function-setAttributes">setAttributes()</a> function.</p>

				<p>Now, we're ready to add our form elements.  In our "Hello World" example, there's only one element - a textbox.</p>

				<?php
echo '<pre>', htmlentities('
$form->addTextbox("My Textbox:", "MyTextbox", "Hello World");
'), '</pre>';
				?>
				
				<p>More information on the <a href="#Form-Function-addTextbox">addTextbox()</a> function, and all the other functions for rendering form elements,  can be found 
				in the <a href="#Form-Functions">Form Functions</a> section.  This textbox has a label assigned as "My Textbox:", a name set to "MyTextbox", and a
				default value of "Hello World".</p>

				<p>A button is attached to the form with...</p>

				<?php
echo '<pre>', htmlentities('
$form->addButton();
'), '</pre>';
				?>

				<p>The <a href="#Form-Function-addButton">addButton()</a> function has optional parameters for customizing the appearance and behavior of your buttons.  With no paramaters 
				provided, it will render a submit button titled "Submit".</p>

				<p>The final function called is <a href="#Form-Function-render">render()</a>...</p>

				<?php
echo '<pre>', htmlentities('
$form->render();
'), '</pre>';
				?>

				<p>The <a href="#Form-Function-render">render()</a> function is responsible for a variety of tasks including building the form's html markup, including the appropriate
				javascript/css include files, and applying javascript validation if applicable.</p>

				<p>Congratulations!  You have just created your first form using the PHP Form Builder Class.  If you're like me, and like learning 
				about a new piece of software by jumping right in and using it, you should <a href="../examples">check out the other included examples</a>, 
				which provide a more in depth look at the various functionality included in this project.  If you're not like me, and like learning about a
				new piece of software by reading the manual first, then you should continue reading this document.</p>
			</div>

			<div class="pfbc_doc_section">
				<a name="Form-Attributes"></a>
				<h3>Form Attributes</h3>
				<p>Form Attributes are set through the <a href="#Form-Function-setAttributes">setAttributes()</a> function and provide a way to customize how a particular form appears and/or behaves.
				These customizations may include specifying a form's width, indicating that you want to turn on ajax submission, or changing the default
				date format returned by the jQuery date/daterange/datetime elements.  Below you will find a detailed list of all the available form attributes
				you can pass to the <a href="#Form-Function-setAttributes">setAttributes()</a> function.</p>

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
				<p><b>ajaxUrl</b>: If AJAX form submission is activated, this attribute controls where the data is submitted to - similar to the
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

				<p>Or in the <a href="#Form-Function-setAttributes">setAttributes()</a> function...</p>

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

				<a name="Form-Attribute-jqueryUITheme"></a>
				<p><b>jqueryUITheme</b>:<br/>jQuery UI themes are leveraged throughout this project to apply css definitions to various entities including the date/daterange/slider/sort/checksort elements, the js/php error reporting 
				section, and buttons.  If the jqueryUITheme attribute is not specified, it will be set to "smoothness", which uses a generic grey color pallet.  Checkout jQuery UI's site at
				<a href="http://jqueryui.com/themeroller/">http://jqueryui.com/themeroller/</a> for a closer look at the various themes that can be used within this project.  You can even create your own, custom theme
				on the jQuery UI site.  The value of this attribute must correspond with one of the folders within the php-form-builder-class/includes/jquery/ui/themes directory.  These options include...</p>

				<p>"black-tie", "blitzer", "cupertino", "dark-hive", "dot-luv", "eggplant", "excite-bike", "flick", "hot-sneaks", "humanity", "le-frog", "mint-choc", "overcast", "pepper-grinder", "redmond", "smoothness", "south-street", "start", "sunny", "swanky-purse", "trontastic", "ui-darkness", "ui-lightness", "vader"</p>

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
public function addButton($value="Submit", $type="submit", $additionalParams="")
'), '</pre>';
				?>

				<p>This function is responsible for adding buttons to the forms that you create.  The form's declaration includes three parameters.  The first - value - controls the value attribute of the &lt;input&gt;
				tag, which the browser uses for the button's displayed text.  The second parameter - type - controls the type attribute of the &lt;input&gt; tag.  Possible values for this parameter include button, image,
				reset, and submit.  The final parameter - additionalParams - accepts an associative array of key/value pairs allowing a variety of settings to be applied.  A list of these settings are provided below.</p>
				
				<p>additionalParams: alt, disabled, name, size, src, type, value, accesskey, class, dir, id, lang, style, tabindex, title, xml:lang, onblur, onchange, onclick, ondblclick, onfocus, onmousedown, 
				onmousemove, onmouseout, onmouseover, onmouseup, onkeydown, onkeypress, onkeyup, onselect, phpFunction, phpParams, wrapLink, linkAttributes</p>

				<p>By default, buttons are rendered in the lower-right corner of a form's container; however, this can be modified through css if you wish with the help of the <a href="#Form-Attribute-preventDefaultCSS">preventDefaultCSS</a> 
				form attribute.</p>

				<p>If your system has a utility in place for dynamically generating button images, you will want to utilize the phpFunction, phpParams, wrapLink, and hrefAttributes button attributes.  
				A sample is provided below of what this function - addButton - might look like with these attributes applied.</p>

				<?php
echo '<pre>', htmlentities('
$form->addButton("", "", array("phpFunction" => "renderDynamicButton", "phpParams" => array("#ffffff", "#cccccc", "My Button"), "wrapLink" => 1, "linkAttributes" => array("href" => "http://www.php.net/")));
'), '</pre>';
				?>

				<a name="Form-Functions-addCaptcha"></a>
				<p><b>addCaptcha</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addCaptcha($label="", $additionalParams="")
'), '</pre>';
				?>

				<p>Adds reCAPTCHA's anti-bot service to your form.  More information on reCAPTCHA can be found at <a href="http://recaptcha.net">http://recaptcha.net</a>.  Unlike other form elements,
				there can only be one captcha element attached to a form, which means any additional addCatpcha() function calls will be ignored.  If you look at this function's declaration provided above, you will notice
				that there are no parameters available for specifying the name and value attributes.  The name attribute is hardcoded to "recaptcha_response_field" for reCAPTCHA validation purposes.  As for the value attribute, it
				is not applicable because reCATCHA generates a new challenge phrase with each page load.  There are several form attributes - <a href="#Form-Attribute-captchaLang">captchaLang</a>, 
				<a href="#Form-Attribute-captchaPublicKey">captchaPublicKey</a>, <a href="#Form-Attribute-captchaPrivateKey">captchaPrivateKey</a>, <a href="#Form-Attribute-captchaTheme">captchaTheme</a> - that you will want to review when using
				reCAPTCHA within your forms.</p>

				<a name="Form-Functions-addCheckbox"></a>
				<p><b>addCheckbox</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addCheckbox($label, $name, $value="", $options="", $additionalParams="")
'), '</pre>';
				?>

				<p>Adds a group of one or more checkboxes to your form.  The value parameter controls which checkboxes in the group are checked by default, and it can contain a string or an array or strings.  An array should be used if 
				if you want multiple checkboxes to be checked by default.  Similar to other elements, the options parameter can contain either a one dimensional or associative array.  If you want the value and displayed text of the checkboxes to be the
				same, you can use a one dimensional array.  If you need the value and displayed text to be different, use an associative array for the keys to be used as the values and the values to be used for the displayed text.</p>

				<a name="Form-Functions-addCheckSort"></a>
				<p><b>addCheckSort</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addCheckSort($label, $name, $value="", $options="", $additionalParams="")
'), '</pre>';
				?>

				<p>Adds the checksort element to your form, which makes use of jQuery UI to allow checkbox options to be selected and sorted in one area.  It combines the functionality of the checkbox and sort elements.
				This element could be used to help your users create a playlist of songs - since this activity requires selecting which songs to include and then sorting them in the desired order.  See the <a href="">addCheckbox()</a>
				function for instructions on how to use the value and options parameters.  More information on jQuery UI can be found at <a href="http://jqueryui.com">http://jqueryui.com</a>.</p>

				<a name="Form-Functions-addCKEditor"></a>
				<p><b>addCKEditor</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addCKEditor($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<p>Adds CKEditor's WYSIWYG text and html web editor to your form.  This is one of two web editors that is available within this project - the other being <a href="#Form-Functions-addWebEditor">TinyMCE</a>.
				More information on CKEditor can be found at <a href="http://ckeditor.com">http://ckeditor.com</a>.  The basic element attribute can be utilized to display the editor with a minimal toolbar, which includes options for 
				bold, italic, creating ordered/unordered lists, and hyperlinking.  Form attributes unique to this element include <a href="#Form-Attributes-ckeditorCustomConfig">ckeditorCustomConfig</a> and <a href="#Form-Attributes-ckeditorLang">ckeditorLang</a>.</p>

				<a name="Form-Functions-addColorPicker"></a>
				<p><b>addColorPicker</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addColorPicker($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<p>Adds the colorpicker element to your form, which utilizes a jQuery plugin found at <a href="http://plugins.jquery.com/project/color_picker">http://plugins.jquery.com/project/color_picker</a>.  When setting the
				default value, you can pass the 6 character hex color string with or without the leading "#".</p>

				<a name="Form-Functions-addCountry"></a>
				<p><b>addCountry</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addCountry($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<p>Adds a select box pre-populated with an alphabetized list of countries.  The &lt;option&gt; values contain the corresponding 2 character country codes.</p>

				<a name="Form-Functions-addDate"></a>
				<p><b>addDate</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addDate($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<p>Adds the date element to your form, which makes use of jQuery UI's datepicker widget.  More information can be found on jQuery UI's website at <a href="http://jqueryui.com/demos/datepicker/">http://jqueryui.com/demos/datepicker</a>.
				By default, this element will return date's formatted like <?=date("F j, Y")?>; however, you can customize this formatting by using the <a href="#Form-Attribute-jqueryDateFormat">jqueryDateFormat</a> form attribute.  There are several element
				attributes specific to this element that are worth mentioned here as well.  The range of selectable dates can be restricted by using the <a href="Element-Attribute-min">min</a> and <a href="">max</a> attributes.  Also, you can control the number of months
				displayed on the calendar with the <a href="Element-Attribute-months">months</a> attribute.</p>

				<a name="Form-Functions-addDateRange"></a>
				<p><b>addDateRange</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addDateRange($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addEmail"></a>
				<p><b>addEmail</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addEmail($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addFile"></a>
				<p><b>addFile</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addFile($label, $name, $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addHidden"></a>
				<p><b>addHidden</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addHidden($name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addHTML"></a>
				<p><b>addHTML</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addHTML($value)
'), '</pre>';
				?>

				<a name="Form-Functions-addLatLng"></a>
				<p><b>addLatLng</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addLatLng($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addPassword"></a>
				<p><b>addPassword</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addPassword($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addRadio"></a>
				<p><b>addRadio</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addRadio($label, $name, $value="", $options="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addRating"></a>
				<p><b>addRating</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addRating($label, $name, $value="", $options="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addSelect"></a>
				<p><b>addSelect</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addSelect($label, $name, $value="", $options="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addSlider"></a>
				<p><b>addSlider</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addSlider($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addSort"></a>
				<p><b>addSort</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addSort($label, $name, $options="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addState"></a>
				<p><b>addState</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addState($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addTextarea"></a>
				<p><b>addTextarea</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addTextarea($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addTextbox"></a>
				<p><b>addTextbox</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addTextbox($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addTrueFalse"></a>
				<p><b>addTrueFalse</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addTrueFalse($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addWebEditor"></a>
				<p><b>addWebEditor</b>:</p>

				<?php
echo '<pre>', htmlentities('
public function addWebEditor($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-addYesNo"></a>
				<p><b>addYesNo</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
public function addYesNo($label, $name, $value="", $additionalParams="")
'), '</pre>';
				?>

				<a name="Form-Functions-bind"></a>
				<p><b>bind</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
public function bind($ref, $jsIfCondition = "", $phpIfCondition = "")
'), '</pre>';
				?>

				<a name="Form-Functions-clearButtons"></a>
				<p><b>clearButtons</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
public function clearButtons()
'), '</pre>';
				?>

				<a name="Form-Functions-clearElements"></a>
				<p><b>clearElements</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
public function clearElements()
'), '</pre>';
				?>

				<a name="Form-Functions-elementsToString"></a>
				<p><b>elementsToString</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
public function elementsToString()
'), '</pre>';
				?>

				<a name="Form-Functions-render"></a>
				<p><b>render</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
public function render($returnString=false)
'), '</pre>';
				?>

				<a name="Form-Functions-setAttributes"></a>
				<p><b>setAttributes</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
public function setAttributes($params)
'), '</pre>';
				?>

				<a name="Form-Functions-setReferenceValues"></a>
				<p><b>setReferenceValues</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
public function setReferenceValues($params)
'), '</pre>';
				?>

				<a name="Form-Functions-setValues"></a>
				<p><b>setValues</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
public function setValues($params)
'), '</pre>';
				?>

				<a name="Form-Functions-validate"></a>
				<p><b>validate</b>:<br/></p>

				<?php
echo '<pre>', htmlentities('
public function validate()
'), '</pre>';
				?>
			</div>
		</div>	
	</body>
</html>
