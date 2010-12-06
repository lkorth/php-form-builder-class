<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0", "submit_1"))) {
	$form = new form("googlemaps_" . substr($_POST["cmd"], -1));
	if($form->validate())
		header("Location: google-maps.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Congratulations! The information you enter passed the form's validation."));
	else
		header("Location: google-maps.php");
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	$title = "Google Maps";
	include("../header.php");
	?>

	<p><b>Google Maps</b> - This project leverages v3 of the Google Maps API to provide functionality for capturing latitude/longitude information.  Below you will find a
	detailed list of the various form/element attributes that affect the Google Maps API v3 integration.</p>

	<ul style="margin: 0;">
		<li>preventGoogleMapsLoad - This form attribute is used to prevent the required Google Maps javascript file from being loaded when the form is rendered.  If you have multiple forms
		on a signle page that invoke the addLatLng function, you will need to make use of this attribute to prevent a duplicate include of the Google Maps js file.</li>
		<li>latlngDefaultLocation - The "latlngDefaultLocation" form attribute can be used to specify the map's default location when no value is provided.  By default, this attribute
		will be set to array(41.847, -87.661), which places the marker on Chigago, IL.</li>
		<li>height - This element attribute controls the height of the Google Map canvas.  Its default value will be set to 200.</li>
		<li>width - This attribtue controls the width of the Google Map convas.  Its default value will be set to 100% of the form's width.</li>
		<li>hideJump - Below the Google Map canvas, there's an area provided that allows you to find a latitude/longitude by typing a location into a free-form textbox.  This functionality is
		included because it can be difficult to drag the marker accross large distances.  The "hideJump" element attribtue allows you to disable this functionality.</li>
		<li>zoom - The "zoom" element attribute controls the default zoom level of the Google Map canvas.  If not specified, this attribute will be set to 9.</li>
	</ul>

	<p>Below you'll find several ways you can use the addLatLng function in your development.</p>

	<?php
	$form = new form("googlemaps_0", 500);

	if(!empty($_GET["errormsg_0"]))
		$form->errorMsg = filter_var($_GET["errormsg_0"], FILTER_SANITIZE_SPECIAL_CHARS);

	$form->addHidden("cmd", "submit_0");
	$form->addLatLng("Latitude/Longitude:", "MyLatLng");
	$form->addLatLng("Latitude/Longitude w/Default Value:", "MyLatLngPrefilled", array(40.689, -74.045));
	$form->addLatLng("Latitude/Longitude w/Custom Dimensions:", "MyLatLngDimensions", "", array("style" => "width: 300px;", "height" => 150, "width" => 300));
	$form->addLatLng("Latitude/Longitude w/zoom Attribute:", "MyLatLngZoom", "", array("zoom" => 13));
	$form->addButton();
	$form->render();
	?>

	<br/><br/>

	<?php
	$form = new form("googlemaps_1", 500);
	$form->setAttributes(array(
		"noAutoFocus" => 1,
		"preventJQueryLoad" => 1,
		"preventJQueryUILoad" => 1,
		"preventGoogleMapsLoad" => 1,
		"latlngDefaultLocation" => array(52.523, 13.411)
	));

	if(!empty($_GET["errormsg_1"]))
		$form->errorMsg = filter_var($_GET["errormsg_1"], FILTER_SANITIZE_SPECIAL_CHARS);

	$form->addHidden("cmd", "submit_1");
	$form->addLatLng("Latitude/Longitude w/latlngDefaultLocation Attribute:", "MyLatLng");
	$form->addButton();
	$form->render();

	echo '<pre>', highlight_string('<?php
$form = new form("googlemaps_0", 500);

if(!empty($_GET["errormsg_0"]))
	$form->errorMsg = filter_var($_GET["errormsg_0"], FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_0");
$form->addLatLng("Latitude/Longitude:", "MyLatLng");
$form->addLatLng("Latitude/Longitude w/Default Value:", "MyLatLngPrefilled", array(40.689, -74.045));
$form->addLatLng("Latitude/Longitude w/Custom Dimensions:", "MyLatLngDimensions", "", array("style" => "width: 300px;", "height" => 150, "width" => 300));
$form->addLatLng("Latitude/Longitude w/zoom Attribute:", "MyLatLngZoom", "", array("zoom" => 13));
$form->addButton();
$form->render();
?>

<br/><br/>

<?php
$form = new form("googlemaps_1", 500);
$form->setAttributes(array(
	"latlngDefaultLocation" => array(52.523, 13.411)
));

if(!empty($_GET["errormsg_1"]))
	$form->errorMsg = filter_var($_GET["errormsg_1"], FILTER_SANITIZE_SPECIAL_CHARS);

$form->addHidden("cmd", "submit_1");
$form->addLatLng("Latitude/Longitude w/latlngDefaultLocation Attribute:", "MyLatLng");
$form->addButton();
$form->render();
?>', true), '</pre>';

	include("../footer.php");
}
?>
