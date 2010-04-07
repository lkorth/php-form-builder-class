<?php
error_reporting(E_ALL);
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit")
{
	echo "<pre>" . htmlentities(print_r($_POST,true)) . "</pre>";
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"]))
{
	?>
	<html>
		<head>
			<title>PHP Form Builder Class | Examples | jQuery</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/" target="_blank">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2>PHP Form Builder Class / Examples / jQuery</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>jQuery</b> - Below you will find samples of the form elements that utilize jQuery.  jQuery also handles tooltips and ajax form submissions.</p>

				<?php
				$form = new form("jquery");
				$form->setAttributes(array(
					"includesRelativePath" => "../includes",
					"tableAttributes" => array("width" => "300")
				));
				$form->addHidden("cmd", "submit");
				$form->addCheckSort("Select And Rank Your Favorite Sports:", "field0", "", array("Baseball", "Basketball", "Golf", "Soccer"));
				$form->addSort("Sort These MLB Baseball Teams Alphabetically:", "field1", array("Dodgers", "Cubs", "Cardinals"));
				$form->addDate("Your Birthday:", "field2");
				$form->addDate("Today's Date Pre-filled:", "field3", date("F j, Y"));
				$form->addDateRange("Select a Date Range:", "field4");
				$form->addDateRange("Select a Date Range:<br><small>(prefilled)</small>", "field5", date("F j, Y", strtotime("-1 month")) . " - " . date("F j, Y"));
				$form->addSlider("Select Rating:<br><small>(1 = lowest; 5 = highest)</small>", "field6", 3, array("sliderMin" => 1, "sliderMax" => 5));
				$form->addSlider("Select Percentage:", "field7", "", array("sliderSuffix" => "%"));
				$form->addSlider("Select Dollar Amount Range:<br><small>($5 increments)</small>", "field8", array(25, 75), array("sliderPrefix" => "$", "sliderSnapIncrement" => 5));
				$form->addSlider("Select Rating Vertical:<br><small>(1 = lowest; 5 = highest)</small>", "field9", 3, array("sliderMin" => 1, "sliderMax" => 5, "sliderOrientation" => "vertical", "sliderHeight" => 200));
				$form->addSlider("Select Rating w/Custom Scale:", "field10", 3, array("sliderMin" => 1, "sliderMax" => 5, "sliderHideDisplay" => 1, "postHTML" => '<table cellpadding="0" cellspacing="0" width="100%" border="0"><tr><td align="left" width="70">1</td><td align="left" width="73">2</td><td align="left" width="73">3</td><td align="left" width="">4</td><td align="right" width="">5</td></tr></table>'));
				$form->addRating("Default Rating:", "field11", "", array("1" => "Bad", "2" => "Below Average", "3" => "Average", "4" => "Above Average", "5" => "Good"));
				$form->addRating("Customized Rating:", "field12", "1", range(1, 10), array("ratingHideCaption" => 1, "ratingHideCancel" => 1));
				$form->addColorPicker("Select Color:", "field13");
				$form->addColorPicker("Select Color Pre-filled:", "field14", "009900");
				$form->addButton();
				$form->render();

echo '<pre>' . htmlentities('<?php
$form = new form("jquery");
$form->setAttributes(array(
	"includesRelativePath" => "../includes",
	"tableAttributes" => array("width" => "300")
));
$form->addHidden("cmd", "submit");
$form->addCheckSort("Select And Rank Your Favorite Sports:", "field0", "", array("Baseball", "Basketball", "Golf", "Soccer"));
$form->addSort("Sort These MLB Baseball Teams Alphabetically:", "field1", array("Dodgers", "Cubs", "Cardinals"));
$form->addDate("Your Birthday:", "field2");
$form->addDate("Today\'s Date Pre-filled:", "field3", date("F j, Y"));
$form->addDateRange("Select a Date Range:", "field4");
$form->addDateRange("Select a Date Range:<br><small>(prefilled)</small>", "field5", date("F j, Y", strtotime("-1 month")) . " - " . date("F j, Y"));
$form->addSlider("Select Rating:<br><small>(1 = lowest; 5 = highest)</small>", "field6", 3, array("sliderMin" => 1, "sliderMax" => 5));
$form->addSlider("Select Percentage:", "field7", "", array("sliderSuffix" => "%"));
$form->addSlider("Select Dollar Amount Range:<br><small>($5 increments)</small>", "field8", array(25, 75), array("sliderPrefix" => "$", "sliderSnapIncrement" => 5));
$form->addSlider("Select Rating Vertical:<br><small>(1 = lowest; 5 = highest)</small>", "field9", 3, array("sliderMin" => 1, "sliderMax" => 5, "sliderOrientation" => "vertical", "sliderHeight" => 200));
$form->addSlider("Select Rating w/Custom Scale:", "field10", 3, array("sliderMin" => 1, "sliderMax" => 5, "sliderHideDisplay" => 1, "postHTML" => \'<table cellpadding="0" cellspacing="0" width="100%" border="0"><tr><td align="left" width="70">1</td><td align="left" width="73">2</td><td align="left" width="73">3</td><td align="left" width="">4</td><td align="right" width="">5</td></tr></table>\'));
$form->addRating("Default Rating:", "field11", "", array("1" => "Bad", "2" => "Below Average", "3" => "Average", "4" => "Above Average", "5" => "Good"));
$form->addRating("Customized Rating:", "field12", "1", range(1, 10), array("ratingHideCaption" => 1, "ratingHideCancel" => 1));
$form->addColorPicker("Select Color:", "field13");
$form->addColorPicker("Select Color Pre-filled:", "field14", "009900");
$form->addButton();
$form->render();
?>') . '</pre>';

				?>
			</div>
		</body>
	</html>	
	<?php
}
?>

