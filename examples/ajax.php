<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && $_POST["cmd"] == "submit_0") {
	$form = new form("ajax_0");
	if($form->validate()) {
		if($_POST["Password"] != $_POST["Password2"])
			echo "The Password and Re-Enter Password fields do not match.";
		else
			echo "Congratulations! The information you enter passed the form's validation.";
	}		
	else
		$form->renderAjaxErrorResponse();
	exit();
}
elseif(isset($_POST["cmd"]) && $_POST["cmd"] == "submit_1") {
	$form = new form("ajax_1");
	if($form->validate()) {
		header("Content-type: application/json");
		echo file_get_contents("http://maps.google.com/maps/api/geocode/json?address=" . urlencode($_POST["Address"]) . "&sensor=false");
	}
	else
		$form->renderAjaxErrorResponse();
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	$title = "Ajax";
	include("../header.php");
	?>

	<p><b>Ajax</b> - To submit your form's data via AJAX, simply apply the "ajax" form attribute in the setAttributes function.  That's it - you're all set.  Most all of the complexity
	is handled for you by the project in the background, which saves you development time.  Below, you'll find several more form attributes that are specific to ajax functionality
	within the project.</p>
	<ul style="margin: 0;">
		<li>ajaxCallback -  The "ajaxCallback" attribute is used to house a javascript function name (without parenthesis) which is invoked when the ajax call is complete.  Any response returned
		from the AJAX call will be passed to this function as it's one and only parameter.</li>
		<li>ajaxPreCallback - Similar to the previous attribute, "ajaxPreCallback" is used to house a javascript function (without parenthesis).  The difference is that this javascript function is
		invoked just before the AJAX call is made.  Another difference is that no parameters are passed.</li>
	</ul>
	<p>Review the final section titled "Validation w/Ajax" in the <a href="validation.php">validation example file</a> provided for instructions on how to handle php validation when using the "ajax" 
	form attribute.</p>

	<?php
	$form = new form("ajax_0", 500);
	$form->setAttributes(array(
		"map" => array(1, 2, 2, 2, 1, 3),
		"ajax" => 1
	));
	$form->addHidden("cmd", "submit_0");
	$form->addTextbox("Username:", "Username", "", array("required" => 1));
	$form->addPassword("Password:", "Password", "", array("required" => 1));
	$form->addPassword("Re-Enter Password:", "Password2", "", array("required" => 1));
	$form->addTextbox("First Name:", "FName", "", array("required" => 1));
	$form->addTextbox("Last Name:", "LName", "", array("required" => 1));
	$form->addEmail("Email Address:", "Email", "", array("required" => 1));
	$form->addTextbox("Phone Number:", "Phone");
	$form->addTextbox("Address:", "Address");
	$form->addTextbox("City:", "City");
	$form->addState("State:", "State");
	$form->addTextbox("Zip Code:", "Zip");
	$form->addButton("Sign Up");
	$form->render();

	echo '<pre>', highlight_string('<?php
$form = new form("ajax_0", 500);
$form->setAttributes(array(
	"map" => array(1, 2, 2, 2, 1, 3),
	"ajax" => 1
));
$form->addHidden("cmd", "submit_0");
$form->addTextbox("Username:", "Username", "", array("required" => 1));
$form->addPassword("Password:", "Password", "", array("required" => 1));
$form->addPassword("Re-Enter Password:", "Password2", "", array("required" => 1));
$form->addTextbox("First Name:", "FName", "", array("required" => 1));
$form->addTextbox("Last Name:", "LName", "", array("required" => 1));
$form->addEmail("Email Address:", "Email", "", array("required" => 1));
$form->addTextbox("Phone Number:", "Phone");
$form->addTextbox("Address:", "Address");
$form->addTextbox("City:", "City");
$form->addState("State:", "State");
$form->addTextbox("Zip Code:", "Zip");
$form->addButton("Sign Up");
$form->render();
?>', true), '</pre>';
	?>

	<p>This example, displayed below, uses Google's Geocoding API combined with this project's AJAX functionality to provide users with a quick way
	to convert an address into a latitude/longitude pair.  Also demonstrated here is the use of the "ajaxCallback" form attribute.</p>

	<?php
	$form = new form("ajax_1", 400);
	$form->setAttributes(array(
		"noAutoFocus" => 1,
		"preventJQueryLoad" => 1,
		"preventJQueryUILoad" => 1,
		"ajaxCallback" => "parseJSONResponse",
		"ajax" => 1
	));

	$form->addHidden("cmd", "submit_1");
	$form->addTextbox("Enter your address below to view the geocoded latitude/longitude.", "Address", "", array("required" => 1));
	$form->addHTMLExternal('<div id="geocodingInfoDiv" style="display: none;">');
	$form->addTextbox("Recognized Address:", "RecognizedAddress", "", array("readonly" => "readonly"));
	$form->addTextbox("Latitude/Longitude:", "LatitudeLongitude", "", array("readonly" => "readonly"));
	$form->addHTMLExternal('</div>');
	$form->addButton("Submit");
	$form->render();

	?>
	<script type="text/javascript">
		function parseJSONResponse(latlng) {
			var formObj = document.getElementById("ajax_1");
			if(latlng.status == "OK") {
				var result = latlng.results[0];
				formObj.RecognizedAddress.value = result.formatted_address;
				formObj.LatitudeLongitude.value = result.geometry.location.lat + ', ' + result.geometry.location.lng;
			}
			else {
				formObj.RecognizedAddress.value = "Address Unrecognized by Google's Geocoding API";
				formObj.LatitudeLongitude.value = "N/A";
			}	
			document.getElementById("geocodingInfoDiv").style.display = "block";
		}
	</script>

	<?php
	echo '<pre>', highlight_string('<?php
$form = new form("ajax_1", 400);
$form->setAttributes(array(
	"ajaxCallback" => "parseJSONResponse",
	"ajax" => 1
));

$form->addHidden("cmd", "submit_1");
$form->addTextbox("Enter your address below to view the geocoded latitude/longitude.", "Address", "", array("required" => 1));
$form->addHTMLExternal(\'<div id="geocodingInfoDiv" style="display: none;">\');
$form->addTextbox("Recognized Address:", "RecognizedAddress", "", array("readonly" => "readonly"));
$form->addTextbox("Latitude/Longitude:", "LatitudeLongitude", "", array("readonly" => "readonly"));
$form->addHTMLExternal("</div>");
$form->addButton("Submit");
$form->render();

?>
<script type="text/javascript">
	function parseJSONResponse(latlng) {
		var formObj = document.getElementById("ajax_1");
		if(latlng.status == "OK") {
			var result = latlng.results[0];
			formObj.RecognizedAddress.value = result.formatted_address;
			formObj.LatitudeLongitude.value = result.geometry.location.lat + \', \' + result.geometry.location.lng;
		}
		else {
			formObj.RecognizedAddress.value = "Address Unrecognized by Google\'s Geocoding API";
			formObj.LatitudeLongitude.value = "N/A";
		}	
		document.getElementById("geocodingInfoDiv").style.display = "block";
	}
</script>
?>', true), '</pre>';
	include("../footer.php");
}
?>
