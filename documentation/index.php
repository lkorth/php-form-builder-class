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
				</ul>
			</div>

			<div class="pfbc_doc_section">
				<a name="Introduction"></a>
				<h3>Introduction</h3>
				<p>The purpose of this document is to provide a reference guide for developers to access while using this project.  If you are not comfortable working
				with php, it is recommended that you first familiarize yourself with this web scripting language before working with this project.  There are many 
				great references available online - specifically <a href="http://www.php.net">http://www.php.net</a>.</p>
			</div>

			<div class="pfbc_doc_section">
				<a name="The-Hello-World-of-PHP-Form-Builder-Class"></a>
				<h3>The "Hello World" of PHP Form Builder Class</h3>
				<p>Before getting started, you will need to <a href="http://code.google.com/apis/maps/documentation/introduction.html">downloaded the latest version 
				of this project</a>, unzip formbuilder.zip, and install the php-form-builder-class directory it on your web server.  After you've done this, you're 
				ready to get started building your first form.  It is recommended that the scripts building/rendering your forms be located in the same folder as 
				the php-form-builder-class directory. Doing so will eliminate the need for specifying the includesPath attribute while building your forms.</p>
					
				<p>Consider the code snippet below...</p>	

				<?php
echo '<pre>' . htmlentities('<?php
include("php-form-builder-class/class.form.php");

$form = new form("HelloWorld");
$form->setAttributes(array(
	"width" => 400
));

$form->addTextbox("My Textbox:", "MyTextbox", "Hello World");
$form->addButton();
$form->render();
?>') . '</pre>';
				?>

				<p>The first thing you'll notice is that class.form.php is included with...</p>

				<?php
echo '<pre>' . htmlentities('
include("php-form-builder-class/class.form.php");
') . '</pre>';
				?>

				<p>This file is where most of the magic happens within the project. It can be found within the php-form-builder-class 
				directory, and must be included in each script that makes use of this project.</p>
				
				<p>Next, a new form object is created with...</p>	

				<?php
echo '<pre>' . htmlentities('
$form = new form("HelloWorld");
') . '</pre>';
				?>

				<p>An identifier, "HelloWorld" in this case, is included.  If this identifier is not provided, "myform" will be used; however,
				it is recommended that you include an identifier with each form you create.  This becomes increasingly important when multiple
				forms are rendered on the same webpage.</p>	

				<p>Once the form object is created, the setAttributes() function is invoked...</p>

				<?php
echo '<pre>' . htmlentities('
$form->setAttributes(array(
	"width" => 400
));
') . '</pre>';
				?>

				<p>The setAttributes() function accepts an associative array of key/value pairs, and is used to assign various attributes to 
				the form.  Chances are you will be calling this function in most all of the forms you create.  In this "Hello World" example, 
				the form's width is set to 400.  See the <a href="">Form Attributes</a> section for a detailed list of form attributes that 
				can be included in the associative array passed to the setAttributes() function.</p>

				<p>Now, we're ready to add our form elements.  In our "Hello World" example, there's only one element - a textbox.</p>

				<?php
echo '<pre>' . htmlentities('
$form->addTextbox("My Textbox:", "MyTextbox", "Hello World");
') . '</pre>';
				?>
				
				<p>More information on the addTextbox() function, and all the other functions for rendering form elements,  can be found 
				in the <a href="">Form Elements</a> section.  This textbox has a label assigned as "My Textbox:", a name set to "MyTextbox", and a
				default value of "Hello World".</p>

				<p>A button is attached to the form with...</p>

				<?php
echo '<pre>' . htmlentities('
$form->addButton();
') . '</pre>';
				?>

				<p>The addButton() function has optional parameters for customizing the appearance and behavior of your buttons.  With no paramaters 
				provided, it will render a submit button titled "Submit" as is the case with this "Hello World" example.</p>

				<p>The final function called is render()...</p>

				<?php
echo '<pre>' . htmlentities('
$form->render();
') . '</pre>';
				?>

				<p>The render() function is responsible for a variety of task including building the form's html markup, including the appropriate
				javascript/css include files, and applying javascript validation if applicable.</p>

				<p>Congratulations!  You have just created your first form using the PHP Form Builder Class.  If you're like me, and like learning 
				about a new piece of software by jumping right in and using it, you should <a href="../examples">check out the other included examples</a>, 
				which provide a more in depth look at the various functionality included in this project.  If you're not like me, and like learning about a
				new piece of software by reading the manual first, then you should continue reading this document.</p>
			</div>

		</div>	
	</body>
</html>
