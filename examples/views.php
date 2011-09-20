<?php
session_start();
error_reporting(E_ALL);
include("../PFBC/Form.php");

if(isset($_POST["form"])) {
	if(PFBC\Form::isValid($_POST["form"])) {
		/*The form's submitted data has been validated.  Your script can now proceed with any 
		further processing required.*/
		header("Location: " . $_SERVER["PHP_SELF"]);
	}
	else {
		/*Validation errors have been found.  We now need to redirect back to the 
		script where your form exists so the errors can be corrected and the form
		re-submitted.*/
		header("Location: " . $_SERVER["PHP_SELF"]);
	}
	exit();
}	

include("../header.php");
?>

<h2 class="first">Views</h2>
<p>In PFBC, views are responsible for converting a form's properties and elements into HTML, CSS, and Javascript for 
the browser to display.  There are four views provided in the project's download: Standard, SideBySide, Horizontal, 
and Grid.</p>

<h3>Standard</h3>
<p>PFBC's default view is Standard.  This view displays labels above their corresponding elements, and 
allows only one element per row.</p>

<?php
$form = new PFBC\Form("layout_standard", 300);
$form->addElement(new PFBC\Element\Hidden("form", "layout_standard"));
$form->addElement(new PFBC\Element\Textbox("Username:", "Username"));
$form->addElement(new PFBC\Element\Password("Password:", "Password"));
$form->addElement(new PFBC\Element\Button("Login", "submit", array("icon" => "key")));
$form->render();

echo '<pre>', highlight_string('<?php
$form = new PFBC\Form("layout_standard", 300);
$form->addElement(new PFBC\Element\Hidden("form", "layout_standard"));
$form->addElement(new PFBC\Element\Textbox("Username:", "Username"));
$form->addElement(new PFBC\Element\Password("Password:", "Password"));
$form->addElement(new PFBC\Element\Button("Login", "submit", array("icon" => "key")));
$form->render();
?>', true), '</pre>';
?>

<h3>Side By Side</h3>
<p>The SideBySide view displays labels beside their corresponding element.  This view has a few properties 
for further customizing the form's appearance. These include labelPaddingTop, labelPaddingRight, and 
labelRightAlign.  Like the Standard view, only one element is allowed per row.</p>

<?php
$form = new PFBC\Form("layout_sidebyside", 300);
$form->configure(array(
	"view" => new PFBC\View\SideBySide(100),
	"prevent" => array("focus", "jQuery", "jQueryUI")
));
$form->addElement(new PFBC\Element\Hidden("form", "layout_sidebyside"));
$form->addElement(new PFBC\Element\Textbox("Username:", "Username"));
$form->addElement(new PFBC\Element\Password("Password:", "Password"));
$form->addElement(new PFBC\Element\Button("Login"));
$form->render();
echo '<br/>';
$form = new PFBC\Form("layout_sidebyside2", 300);
$form->configure(array(
	"view" => new PFBC\View\SideBySide(100, array("labelRightAlign" => 1)),
	"prevent" => array("focus", "jQuery", "jQueryUI")
));
$form->addElement(new PFBC\Element\Hidden("form", "layout_sidebyside2"));
$form->addElement(new PFBC\Element\Textbox("Name:", "Name"));
$form->addElement(new PFBC\Element\Email("Email Address:", "Email"));
$form->addElement(new PFBC\Element\Button("Sign Up"));
$form->render();

echo '<pre>', highlight_string('<?php
$form = new PFBC\Form("layout_sidebyside", 300);
$form->configure(array(
	"view" => new PFBC\View\SideBySide(100)
));
$form->addElement(new PFBC\Element\Hidden("form", "layout_sidebyside"));
$form->addElement(new PFBC\Element\Textbox("Username:", "Username"));
$form->addElement(new PFBC\Element\Password("Password:", "Password"));
$form->addElement(new PFBC\Element\Button("Login"));
$form->render();

$form = new PFBC\Form("layout_sidebyside2", 300);
$form->configure(array(
	"view" => new PFBC\View\SideBySide(100, array("labelRightAlign" => 1)),
));
$form->addElement(new PFBC\Element\Hidden("form", "layout_sidebyside2"));
$form->addElement(new PFBC\Element\Textbox("Name:", "Name"));
$form->addElement(new PFBC\Element\Email("Email Address:", "Email"));
$form->addElement(new PFBC\Element\Button("Sign Up"));
$form->render();
?>', true), '</pre>';

?>

<h3>Horizontal</h3>
<p>The Horizontal view displays a form's attached element in one horizontal line. Just like SideBySide, this 
view has a labelPaddingTop property that can be used to pad labels down to align vertically with their 
corresponding elements.</p>

<?php
$form = new PFBC\Form("layout_horizontal");
$form->configure(array(
	"view" => new PFBC\View\Horizontal,
	"prevent" => array("focus", "jQuery", "jQueryUI")
));
$form->addElement(new PFBC\Element\Hidden("form", "layout_horizontal"));
$form->addElement(new PFBC\Element\Textbox("Username:", "Username"));
$form->addElement(new PFBC\Element\Password("Password:", "Password"));
$form->addElement(new PFBC\Element\Button("Login"));
$form->render();

echo '<pre>', highlight_string('<?php
$form = new PFBC\Form("layout_horizontal");
$form->configure(array(
	"view" => new PFBC\View\Horizontal
));
$form->addElement(new PFBC\Element\Hidden("form", "layout_horizontal"));
$form->addElement(new PFBC\Element\Textbox("Username:", "Username"));
$form->addElement(new PFBC\Element\Password("Password:", "Password"));
$form->addElement(new PFBC\Element\Button("Login"));
$form->render();
?>', true), '</pre>';
?>

<h3>Grid</h3>
<p>The forth and final view provided in the project's download is Grid.  Grid is similar to Standard, but provides
the ability to display multiple elements on the same line.  Form's structure is controlled by an array that is passed
to the Grid class' constructor.  The values of this array correspond with the number of elements to display in each
row.  As seen in the second example below, you can also customize each grid element's width.</p>

<?php
$form = new PFBC\Form("layout_grid", 500);
$form->configure(array(
	"view" => new PFBC\View\Grid(array(2, 1, 3)),
	"prevent" => array("focus", "jQuery", "jQueryUI")
));
$form->addElement(new PFBC\Element\Hidden("form", "layout_grid"));
$form->addElement(new PFBC\Element\Textbox("First Name:", "FirstName"));
$form->addElement(new PFBC\Element\Textbox("Last Name:", "LastName"));
$form->addElement(new PFBC\Element\Textbox("Address:", "Address"));
$form->addElement(new PFBC\Element\Textbox("City:", "City"));
$form->addElement(new PFBC\Element\State("State:", "State"));
$form->addElement(new PFBC\Element\Textbox("Zip Code:", "ZipCode"));
$form->addElement(new PFBC\Element\Button);
$form->render();
echo '<br/>';
$form = new PFBC\Form("layout_grid2", 350);
$form->configure(array(
	"view" => new PFBC\View\Grid(array(2, 2)),
	"prevent" => array("focus", "jQuery", "jQueryUI")
));
$form->addElement(new PFBC\Element\Hidden("form", "layout_grid2"));
$form->addElement(new PFBC\Element\Textbox("Name:", "Name"));
$form->addElement(new PFBC\Element\Textbox("Age:", "Age", array("width" => 75)));
$form->addElement(new PFBC\Element\Radio("Gender:", "Gender", array("Male", "Female"), array("inline" => 1)));
$form->addElement(new PFBC\Element\Email("Email Address:", "Email", array("width" => 225)));
$form->addElement(new PFBC\Element\Button);
$form->render();

echo '<pre>', highlight_string('<?php
$form = new PFBC\Form("layout_grid", 500);
$form->configure(array(
	"view" => new PFBC\View\Grid(array(2, 1, 3))
));
$form->addElement(new PFBC\Element\Hidden("form", "layout_grid"));
$form->addElement(new PFBC\Element\Textbox("First Name:", "FirstName"));
$form->addElement(new PFBC\Element\Textbox("Last Name:", "LastName"));
$form->addElement(new PFBC\Element\Textbox("Address:", "Address"));
$form->addElement(new PFBC\Element\Textbox("City:", "City"));
$form->addElement(new PFBC\Element\State("State:", "State"));
$form->addElement(new PFBC\Element\Textbox("Zip Code:", "ZipCode"));
$form->addElement(new PFBC\Element\Button);
$form->render();

$form = new PFBC\Form("layout_grid2", 350);
$form->configure(array(
	"view" => new PFBC\View\Grid(array(2, 2))
));
$form->addElement(new PFBC\Element\Hidden("form", "layout_grid2"));
$form->addElement(new PFBC\Element\Textbox("Name:", "Name"));
$form->addElement(new PFBC\Element\Textbox("Age:", "Age", array("width" => 75)));
$form->addElement(new PFBC\Element\Radio("Gender:", "Gender", array("Male", "Female"), array("inline" => 1)));
$form->addElement(new PFBC\Element\Email("Email Address:", "Email", array("width" => 225)));
$form->addElement(new PFBC\Element\Button);
$form->render();
?>', true), '</pre>';

include("../footer.php");
?>
