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
					<li><a href="#Form-Elements">Supported Form Elements</a>
						<ul>
							<li><a href="#Form-Elements-Textbox">Textbox</a></li>
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
				the form's width is set to 400 pixels.</p>

				<p>Now, we're ready to add our form elements.  In our "Hello World" example, there's only one element - a textbox.</p>

				<?php
echo '<pre>', htmlentities('
$form->addTextbox("My Textbox:", "MyTextbox", "Hello World");
'), '</pre>';
				?>
				
				<p>More information on how to work with textboxes and all the other form elements can be found 
				in the <a href="#Form-Elements">Form Elements</a> section.  This textbox has a label assigned as "My Textbox:", a name set to "MyTextbox", and a
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
				<a name="Form-Elements"></a>
				<h3>Form Elements</h3>
				<p>The latest release of this project, version <?php echo(file_get_contents('../version'));?>, contains support for 26 form element types.  These 
				include button, captcha, checkbox, checksort, ckeditor, colorpicker, country, date, daterange, email, file, hidden, html, htmlexternal, latlng, 
				password, radio, rating, select, sort, state, textarea, textbox, truefalse, webeditor, and yesno.  Let's take a closer look at how each of these form element
				types can be used in your development.</p>

				<a name="Form-Elements-Textbox"></a>
				<h4>Textbox:</h4><p>I chose to begin with textboxes because they're arguably the most frequently used form element on the web.  Chances are, the first form you build with this
				project will contain a textbox - so, let's get started.  Textboxes are added to your forms through the addTextbox() function.  See the code snippet provided below.</p>

				<?php
echo '<pre>', highlight_string('<?php
/* addTextbox() Function Declaration
public function addTextbox($label, $name, $value="", $additionalParams="") {}
*/

$form->addTextbox("My Textbox", "MyTextbox");
$form->addTextbox("My Prefilled Textbox", "MyPrefilledTextbox", "This is my default value.");
$form->addTextbox("My Required Textbox", "MyRequiredTextbox", "", array("required" => 1));
?>', true), '</pre>';
				?>
				
				<p>This function has four available parameters: label, name, value, and additionalParams.  Many of the functions responsible for adding form elements follow this same pattern.
				The table provided below describes each of these parameters.</p>

				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="150">label</td>
						<td>Controls the content rendered inside &lt;label&gt; tags before the textbox.</td>
					</tr>
					<tr>
						<td>name</td>
						<td>Corresponds to the name attribute of the &lt;input&gt; tag.</td>
					</tr>
					<tr>
						<td>value</td>
						<td>Optional - Corresponds to the value attribute of the &lt;input&gt; tag.  This can be used to set the textbox's default value.</td>
					</tr>
					<tr>
						<td>additionalParams</td>
						<td>Optional - Associative array of key/value pairs allowing a variety of settings to be applied to the textbox.  The third example seen above 
						demonstrates how this parameter can be used to apply the required setting.  See the <a href="#Additional-Parameters">additionalParams</a> section for all available options
						that can be passed in this array.</td>
					</tr>
				</table>
			</div>	

			<div class="pfbc_doc_section">
				<a name="Additional-Parameters"></a>
				<h3>additionalParams</h3>
				<p>Nearly all the functions for adding form elements have an optional, last parameter called additionalParams that can be used to apply various settings
				to form elements through an associative array of key/value pairs.  An example is provided below to demonstrate how this can be done.</p>
				<?php
echo '<pre>', highlight_string('<?php
$form->addTextbox("My Textbox w/additionalParams", "MyTextbox", "", array("required" => 1, "class" => "myclass"));
?>', true), '</pre>';
				?>
				<p>Many of the available options that can be passed to the additionalParams parameter directly correspond with html attributes, like "class" seen 
				in the code snippet above.  Others are custom settings with functionality built into this project, like "required".  All the available options that can
				passed to the additionalParams paramter are provided below for your reference.</p>

				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="150">basic</td>
						<td width="200">addCKEditor, addWebEditor</td>
						<td>Triggers web editor's simplified control panel.  Both of the web editors integrated into this project - TinyMCE and CKEditor - have two
						control panels that can be used.  By default, the web editor will be displayed with a full-featured set of controls; however, you can use the basic option
						to display a reduced set of controls including only bold, italics, ordered/unordered lists, and a few others.  Both control panels can be seen in the <a href="../examples/web-editors.php">Web Editors example</a>.</td>
					</tr>
					<tr>
						<td>height</td>
						<td>addLatLng, addSlider</td>
						<td>Controls the height of the Google Map and jQuery slider (when orientation has been set to vertical).  When using the addLatLng function, the container housing the 
						Google Map will be set to 200px by default; however, you can override this setting by making use of the height option.  When using the addSlider function, the height option
						can be used in combination with the orientation jqueryOption to control the slider's height.  In both functions, numbers passed with no suffix - "px", "%", etc - will be 
						interpreted in pixels.  This means that "80" will be rewritten as "80px".</td>
					</tr>
					<tr>
						<td>hint</td>
						<td>addTextbox, addTextarea, addDate, addDateRange, addColorPicker, addLatLng, addEmail</td>
						<td>Prefills elements with a temporary value that is cleared with an onclick javascript function when engaged.  Several functions including addDate, addDateRange, addColorPicker, and addLatLng
						have this option set by default.  For instance, the addDate function has a hint set to "Click to Select Date...".  Hints are ignored for required fields during javascript validation.  Also, the form's
						built in onsubmit javascript function will remove hints before the data is submitted.</td>
					</tr>
				</table>
			</div>	
		</div>
	</body>
</html>	
