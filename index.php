<?php
error_reporting(E_ALL);
include("header.php");
?>

<h2 class="first"><a name="project-overview">Project Overview</a></h2>
<p>The PFBC (PHP Form Builder Class) project is developed with the following goals in mind...</p>
<ul>
	<li>Promote rapid development of forms through an object-oriented PHP structure.</li>
	<li>Eliminate the grunt/repetitive work of writing the html and validation when building forms.</li>
	<li>Reduce human error by using a consistent/tested utility.</li>
</ul>
<p>This project was first release to the open source community on April, 24 2009 at 
<a href="http://www.phpclasses.org/package/5350-PHP-Generate-HTML-and-Javascript-for-displaying-forms.html">PHPClass.org</a>.  
It was moved to its current location at <a href="http://code.google.com/p/php-form-builder-class">Google's Project Hosting service</a>
on November 16, 2009.  Since the initial release, the project has gone through over 20 revisions
and is still under active development.</p>

<p>Version 2.0 represents the first major rewrite in the project's history and attempts to evolve PFBC 
into a code base that is more efficient, easier to manage, and extensible.</p>

<h2><a name="system-requirements">System Requirements</a></h2>
<ul>
	<li>PHP 5.3+</li>
</ul>

<h2><a name="whats-new-different-in-version-2x">What's New/Different in Version 2.x</a></h2>
<p>PFBC version 2.x is a complete rewrite of the last 1.x version released - 1.1.4.  This rewrite was
done for several reasons...</p>

<ul>
	<li>Organization - In version 1.x, most of the project's functionality was stuffed inside a single file - class.form.php,
	which made code's readability and management a real challenge.  Version 2.x organizes the various pieces of the project into
	a logical directory structure.</li>
	<li>Extensibility - The new object-oriented model in version 2.x allows you extend the project's functionality more easily.
	Examples of extensibility include creating your own form elements, customizing the form's html/css structure, and/or creating new validation
	rules.</li>
	<li>Performance - In order to comply with xhtml strict rules, version 1.x used ajax to insert the form's required 
	css/javascript into the document's head tag, negatively impacted performance.  Version 2.x implements a new, simplified 
	strategy where the form's required css is included before the form's html structure is sent to the browser (javascript 
	is inserted after the form's html structure).  This improves performance and reduces the occurance of unexpected shifts 
	caused when the form's css is loaded and applied after the form's mark up is visible on the webpage.</li>
</ul>

<p>PFBC version 2.0 is not a direct replacement for the last 1.x version released - 1.1.4.  In other words, migrating from 
1.x to 2.x requires more than simply overwriting the project's directory on your web server.  Below is a list of changes 
that you should be aware of when transitioning to using PFBC version 2.x.</p>

<h3>Syntax Changes</h3>
<ul>
	<li>Including Project's Required PHP Script - In version 1.x, php-form-builder-class/class.form.php needed to be 
	included in any script using this project.  In version 2.x, the required file is named PFBC/Form.php.

		<?php
		echo '<pre>', highlight_string('<?php
//Version 1.x
include($_SERVER["DOCUMENT_ROOT"] . "/php-form-builder-class/class.form.php");
//Version 2.x
include($_SERVER["DOCUMENT_ROOT"] . "/PFBC/Form.php");
?>', true), '</pre>';
		?>

	</li>

	<li>Namespaces - Version 2.x uses namespaces to prevent naming collisions and organize the project's pieces into a logical 
	structure.  They are also used for autoloading required class files at runtime.  Namespaces were introduced in PHP 5.3, 
	so PFBC 2.x won't work if you're using a previous version of PHP.  See <a href="http://php.net/manual/en/language.namespaces.php">
	http://php.net/manual/en/language.namespaces.php</a> for more information on using namespaces in PHP.</li>

	<li>Form Constructor - The form's contructor now includes an optional second parameter for specifying the form's width.

		<?php
		echo '<pre>', highlight_string('<?php
//Version 1.x
$form = new form("Version1x");
//Version 2.x
$form = new PFBC\Form("Version2x", 300);
?>', true), '</pre>';
		?>

	</li>

	<li>Form's setAttributes Method Renamed To configure - The setAttributes method included in version 1.x is now configure in 2.x.

		<?php
		echo '<pre>', highlight_string('<?php
//Version 1.x
$form->setAttributes(array(
	"method" => "get"
)); 
//Version 2.x
$form->configure(array(
	"method" => "get"
)); 
?>', true), '</pre>';
		?>

	</li>

	<li>Adding Elements - In version 1.x, each element had its own method for adding itself to a form.  The work flow for 
	adding elements in version 2.x is different - the form's addElement method is passed an instance of the appropriate 
	concrete element class.  This strategy allows for decoupling and easier extensibility.

		<?php
		echo '<pre>', highlight_string('<?php
//Version 1.x
$form->addTextbox("My Textbox:", "MyTextbox");
//Version 2.x
$form->addElement(new PFBC\Element\Textbox("My Textbox:", "MyTextbox"));
?>', true), '</pre>';
		?>

	</li>

	<li>Element Value Parameter - In PFBC 1.x, many of the functions for adding elements included a third parameter for 
	specifying the element's value.  This parameter has been removed from version 2.x.  Values can be added to elements 
	using the form's setValues method.  You can also specify the value in the element's final parameter within an associative
	array.

		<?php
		echo '<pre>', highlight_string('<?php
//Version 1.x
$form->addTextbox("My Textbox:", "MyTextbox", "My Textbox\'s Value");
//Version 2.x
$form->addElement(new PFBC\Element\Textbox("My Textbox:", "MyRequiredTextbox", array("required" => 1)));
$form->setValues(array( 
	"MyTextbox" => "My Textbox\'s Value"
));
$form->addElement(new PFBC\Element\Textbox("My Textbox:", "MyTextbox"));
$form->addElement(new PFBC\Element\Textbox("My Textbox:", "MyTextbox", array(
	"value" => "My Textbox\'s Value"
)));
?>', true), '</pre>';
		?>

	</li>

	<li>PHP Validation - PFBC version 2.x implements server-side validation through the isValid static method.  Previous 
	1.x versions required the new form instance to be created before calling the validate method.

		<?php
		echo '<pre>', highlight_string('<?php
//Version 1.x
$form = new form("PHPValidation");
if($form->validate()) {}
//Version 2.x
if(PFBC\Form::isValid("PHPValidation")) {}
?>', true), '</pre>';
		?>

	</li>

	<li>Returning Ajax Validation Errors - The renderAjaxErrorResponse method has also been converted to a static 
	method in version 2.x.

		<?php
		echo '<pre>', highlight_string('<?php
//Version 1.x
$form = new form("Ajax");
if(!$form->validate())
	$form->renderAjaxErrorResponse();
//Version 2.x
if(!PFBC\Form::isValid("Ajax"))
	PFBC\Form::renderAjaxErrorResponse("Ajax");
?>', true), '</pre>';
		?>

	</li>

	<li>Form Layout Properties - One of the significant updates made in version 2.x was decoupling the form's html/css 
	structure into multiple views.  Version 2.x contains four available views: Standard, Grid, SideBySide, and Horizontal.  
	Version 1.x's map property was replaced by the Grid view.  Version 1.x's labelWidth, labelRightAlign, labelPaddingRight, 
	and labelPaddingTop properties now belong to the SideBySide view.

		<?php
		echo '<pre>', highlight_string('<?php
//Version 1.x
$form->setAttributes(array(
	"map" => array(1, 2, 3)
));
//Version 2.x
$form->configure(array(
	"view" => new PFBC\View\Grid(array(1, 2, 3))
));

//Version 1.x
$form->setAttributes(array(
	"labelWidth" => 100,
	"labelRightAlign" => 1
));
//Version 2.x
$form->configure(array(
	"view" => new PFBC\View\SideBySide(100, array(
		"labelRightAlign" => 1
	))	
));

?>', true), '</pre>';
		?>
	
	</li>
		
	<li>Fieldsets - Version 1.x provided two methods, openFieldset and closeFieldset, for incorporating fieldsets into forms.
	PFBC 2.x has no such functions; however, you can make use of the HTMLExternal method to manually insert fieldsets.
	
		<?php
		echo '<pre>', highlight_string('<?php
//Version 1.x
$form->openFieldset("My Fieldset");
$form->closeFieldset();
//Version 2.x
$form->addElement(PFBC\Element\HTMLExternal(\'<fieldset><legend>My Fieldset</legend>\'));
$form->addElement(PFBC\Element\HTMLExternal(\'</fieldset>\'));
?>', true), '</pre>';
		?>

	</li>

</ul>

<h3>What's New in Version 2.x?</h3>
<ul>
	<li>Element Descriptions - The tooltip property that was included in PFBC 1.x have been replaced with the description property,
	which allows you to include a brief explanation for your form fields.  These descriptions will be displayed below the element's
	label.

		<?php
		echo '<pre>', highlight_string('<?php
$form->addElement(PFBC\Element\Textbox("My Textbox:", "MyTextbox", array(
	"description" => "This is my textbox\'s description."
)));
?>', true), '</pre>';
		?>
	
	</li>

	<li>Regular Expression Validation - You can now apply custom validation rules to your form elements through the RegExp validation
	class.

		<?php
		echo '<pre>', highlight_string('<?php
$form->addElement(PFBC\Element\Textbox("My Textbox:", "MyTextbox", array(
	"validation" => new PFBC\Validation\RegExp("/php|form|builder|class/", "This textbox must contain one of the following words - php, form, builder, and/or class.")
)));
?>', true), '</pre>';
		?>
	</li>	
</ul>

<h3>What's Not Included in Version 2.x?</h3>

<ul>
	<li>Form Elements
		<ul>
			<li>Latitude/Longitude w/Google Maps</li>
			<li>jQueryUI Slider Widget</li>
			<li>jQuery Date Range Picker Plugin</li>
			<li>True/False Radio Buttons</li>
		</ul>
	</li>
	<li>Features/Functionality
		<ul>
			<li>Javascript Validation</li>
			<li>Tooltips</li>
			<li>Google Docs Spreadsheet Integration</li>
			<li>Email Support w/PHPMailer + Google's Gmail Service</li>
			<li>XHTML 1.0 Strict Compliance</li>
		</ul>
	</li>
</ul>	

<h2><a name="getting-started">Getting Started</a></h2>
<p>Before writing any code, you'll first need to <a href="http://php-form-builder-class.googlecode.com/files/pfbc<?php echo($version);?>-php5.3.zip">
download the latest version of PFBC</a>, extract the contents zip file, and upload the PFBC directory within 
the document root of your web server.  NOTE: The phrase "within the document root" means that there must be a
public path to the PFBC directory (e.g. http://www.mydomain.com/PFBC).  The other files/directories outside 
of the PFBC folder that are included in the download are provided only for instruction and can be ommitted 
from your production environment.  Once the PFBC directory is up on your web server, you're ready to get started 
creating your first form.  Take a look at the PHP code snippet provided below.</p>

	<?php
	echo '<pre>', highlight_string('<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/PFBC/Form.php");
$form = new PFBC\Form("GettingStarted", 300);
$form->addElement(new PFBC\Element\Textbox("My Textbox:", "MyTextbox"));
$form->addElement(new PFBC\Element\Button);
$form->render();
?>', true), '</pre>';
	?>

<p>Now, let's go through this example to get a clear understanding of how each line is used within the project.</p>

	<?php
	echo '<pre>', highlight_string('<?php
session_start();
?>', true), '</pre>';
	?>

<p>PFBC uses sessions in the validation process to store errors as well as submission information for auto-populating.  
Because of this, you must ensure that a session has been started on each webpage you're using the project.  NOTE: 
session_start() must be called before outputing anything to the browser.  Typically, this function is found at the 
top of your script - and not where it is in the example displayed above.</p>

	<?php
	echo '<pre>', highlight_string('<?php
include($_SERVER["DOCUMENT_ROOT"] . "/PFBC/Form.php");
?>', true), '</pre>';
	?>

<p>In order to create new instance of the Form class, you'll need to first include /PFBC/Form.php.  The specific 
line above assumes that the PFBC directory is sitting in your server's document root.  Within this file, you'll 
find the neccessary properties and methods for building forms.  Also, there's a section near the top of the file 
that leverages SPL (Standard PHP Library) to autoload the various classes required at run time.  This strategy 
eliminates any unused php source code from being included.</p>

	<?php
	echo '<pre>', highlight_string('<?php
$form = new PFBC\Form("GettingStarted", 300);
?>', true), '</pre>';
	?>

<p>The Form class' constructor has two optional parameters.  The first is a unique identifier, "GettingStarted" 
in this case.  This identifier is used during the validation process.  If this parameter is not provided, "myform" 
will be used; however, it is recommended that you include a unique identifier with each form you create. This 
becomes increasingly important when multiple forms are rendered on the same webpage.  The second parameter is 
used to set the form's width.</p>

	<?php
	echo '<pre>', highlight_string('<?php
$form->addElement(new PFBC\Element\Textbox("My Textbox:", "MyTextbox"));
?>', true), '</pre>';
	?>

<p>Next, we've added a textbox to our form via the addElement method.  This method accepts an instance of one 
of the concrete classes that extend the abstract Element class - Textbox in this case.</p>

	<?php
	echo '<pre>', highlight_string('<?php
$form->addElement(new PFBC\Element\Button);
?>', true), '</pre>';
	?>

<p>Another element, Button, is attached to our form.  Using the form's default view, Standard, buttons will 
be right aligned within the form's container.  Also, consecutive buttons will be displayed on the same line.</p>

	<?php
	echo '<pre>', highlight_string('<?php
$form->render();
?>', true), '</pre>';
	?>

<p>The render method is responsible for sending our form's required css, javascript, and html to the browser 
for displaying to the user.</p>

<?php
include("footer.php");
?>
