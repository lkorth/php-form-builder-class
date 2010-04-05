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
			<title>PHP Form Builder Class | Examples | Google Maps</title>
		</head>	
		<body>
			<h2 style="text-align: center; margin: 0; padding: 0;">PHP Form Builder Class</h2>
			<h5 style="text-align: center; margin: 0; padding: 0;"><span style="padding-right: 10px;">Author: Andrew Porterfield</span><span style="padding-right: 10px;">Released: <?php echo(file_get_contents('../release'));?></span><span>Version: <?php echo(file_get_contents('../version'));?></span></h5>
			<div style="text-align: center; padding-bottom: 10px;"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">View Project's Homepage</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Latest Stable Release</a></div>
			<a href="../index.php">Back to Project Home Page</a>
			<p><b>Google Maps</b> - Included in this class is a field for capturing a latitude/longitude by utilizing the Google Maps API v3.
			To specifiy a location, simply click, drag, and drop the marker on the map to a given point.  Once dropped, the lattitude and 
			longitude will be inserted into the textbox above the map. You can also make use of the Location Jump textbox to move to a specific 
			location. The maps latitude/longitude will automatically update as you type.  The location will need to be parsed once submitted - I recommend using 
			explode() on the "," and substring() on each piece.<p>
			<p>You can customize the map's zoom, width, and height with the <i>latlngZoom</i>, </i>latlngWidth</i>, and <i>latlngHeight</i> element attributes.  Also, you can disable
			the location jump functionality with the <i>latlngHideJump</i> element attribute.</p>
			<p>Also, you can use the <i>latlngDefaultLocation</i> form attribute to control where the marker is placed on the map initially - with no value assigned.
			<?php
			$form = new form("google_maps");
			$form->setAttributes(array(
				"includesRelativePath" => "../includes",
				"tableAttributes" => array("width" => "500"),
				"latlngDefaultLocation" => array(38.897, -77.040)
			));
			$form->addHidden("cmd", "submit");
			$form->addLatLng("Detault LatLng Functionality:", "field0");
			$form->addLatLng("Pre-Filled LatLng Functionality:", "field1", array(40.737, -73.994), array("latlngZoom" => 12, "latlngHeight" => 400));
			$form->addButton();
			$form->render();

echo '<pre>' . htmlentities('<?php
$form = new form("google_maps");
$form->setAttributes(array(
	"includesRelativePath" => "../includes",
	"tableAttributes" => array("width" => "500"),
	"latlngDefaultLocation" => array(38.897, -77.040)
));
$form->addHidden("cmd", "submit");
$form->addLatLng("Detault LatLng Functionality:", "field0");
$form->addLatLng("Pre-Filled LatLng Functionality:", "field1", array(40.737, -73.994), array("latlngZoom" => 12, "latlngHeight" => 400));
$form->addButton();
$form->render();
?>') . '</pre>';

			?>
			<a href="../index.php">Back to Project Home Page</a>
		</body>
	</html>	
	<?php
}
?>

