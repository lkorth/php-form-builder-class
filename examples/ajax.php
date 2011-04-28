<?php
session_start();
error_reporting(E_ALL);
include("../PFBC/Form.php");

if(isset($_POST["form"])) {
	if(PFBC\Form::isValid($_POST["form"])) {
		header("Content-type: application/json");
		echo file_get_contents("http://maps.google.com/maps/api/geocode/json?address=" . urlencode($_POST["Address"]) . "&sensor=false");
	}
	else
		PFBC\Form::renderAjaxErrorResponse("example2");
	exit();
}	

include("../header.php");
?>

<h2 class="first">Ajax</h2>
<p>This project provides several properties/methods for facilitating ajax submissions.  To get started, you'll first need to set the ajax property in
the form's configure method.  The ajaxCallback property can also be included in the configure method if you'd like a javascript function to called
after the form's data has been submitted.  In the example belew a callback function has been set to extract the latitude/longitude information from a
json response.  The validation process for an ajax submission also differs slightly from that of a standard submission.  If the form's isValid method 
returns false, you will need to invoke the renderAjaxErrorResponse method, which returns a json response containing the appropriateerror messages.  
These errors will then be displayed in the form so the end user can correct and re-submit.</p>

<?php
$form = new PFBC\Form("ajax", 400);
$form->configure(array(
	"ajax" => 1,
	"ajaxCallback" => "parseJSONResponse",
));
$form->addElement(new PFBC\Element\Hidden("form", "ajax"));
$form->addElement(new PFBC\Element\Textbox("Address:", "Address", array("required" => 1)));
$form->addElement(new PFBC\Element\HTMLExternal('<div id="GoogleGeocodeAPIReaponse" style="display: none;">'));
$form->addElement(new PFBC\Element\Textbox("Latitude/Longitude:", "LatitudeLongitude", array("readonly" => "readonly")));
$form->addElement(new PFBC\Element\HTMLExternal('</div>'));
$form->addElement(new PFBC\Element\Button("Geocode"));
$form->render();
?>

<script type="text/javascript">
	function parseJSONResponse(latlng) {
		var form = document.getElementById("ajax");
		if(latlng.status == "OK") {
			var result = latlng.results[0];
			form.LatitudeLongitude.value = result.geometry.location.lat + ', ' + result.geometry.location.lng;
		}
		else
			form.LatitudeLongitude.value = "N/A";

		document.getElementById("GoogleGeocodeAPIReaponse").style.display = "block";
	}
</script>

<?php
echo '<pre>', highlight_string('<?php
$form = new PFBC\Form("ajax", 400);
$form->configure(array(
	"ajax" => 1,
	"ajaxCallback" => "parseJSONResponse",
));
$form->addElement(new PFBC\Element\Hidden("form", "ajax"));
$form->addElement(new PFBC\Element\Textbox("Address:", "Address", array("required" => 1)));
$form->addElement(new PFBC\Element\HTMLExternal(\'<div id="GoogleGeocodeAPIReaponse" style="display: none;">\'));
$form->addElement(new PFBC\Element\Textbox("Latitude/Longitude:", "LatitudeLongitude", array("readonly" => "readonly")));
$form->addElement(new PFBC\Element\HTMLExternal(\'</div>\'));
$form->addElement(new PFBC\Element\Button("Geocode"));
$form->render();
?>

<script type="text/javascript">
	function parseJSONResponse(latlng) {
		var form = document.getElementById("ajax");
		if(latlng.status == "OK") {
			var result = latlng.results[0];
			form.LatitudeLongitude.value = result.geometry.location.lat + \', \' + result.geometry.location.lng;
		}
		else
			form.LatitudeLongitude.value = "N/A";

		document.getElementById("GoogleGeocodeAPIReaponse").style.display = "block";
	}
</script>
?>', true), '</pre>';

include("../footer.php");
?>
