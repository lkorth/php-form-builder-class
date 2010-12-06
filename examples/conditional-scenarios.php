<?php
error_reporting(E_ALL);
session_start();
include("../class.form.php");

if(isset($_POST["cmd"]) && in_array($_POST["cmd"], array("submit_0", "submit_1"))) {
	$form = new form("conditionalscenarios_" . substr($_POST["cmd"], -1));
	if($form->validate())
		header("Location: conditional-scenarios.php?errormsg_" . substr($_POST["cmd"], -1) . "=" . urlencode("Congratulations! The information you enter passed the form's validation."));
	else
		header("Location: conditional-scenarios.php");
	exit();
}
elseif(!isset($_GET["cmd"]) && !isset($_POST["cmd"])) {
	$title = "Conditional Scenarios";
	include("../header.php");
	?>

	<p><b>Conditional Scenarios</b> - By "conditional scenarios", I'm referring to situations where one or more questions/fields in a form are applicable only when a certain
	condition is met.  There are multiple ways this type of scenario can be handled by this project; however, the preferred method is to use the bind function as seen below,
	which properly handles validation and ajax submission.</p>

	<?php
	$billing_form = new form("conditionalscenarios_0", 500);
	$billing_form->setAttributes(array(
		"map" => array(1, 2, 2, 1, 3, 1)
	));

	if(!empty($_GET["errormsg_0"]))
		$billing_form->errorMsg = filter_var($_GET["errormsg_0"], FILTER_SANITIZE_SPECIAL_CHARS);

	$billing_form->addHidden("cmd", "submit_0");
	$billing_form->addHTML('<div style="font-weight: bold; padding-bottom: 5px;">Billing Address</div>');
	$billing_form->addTextbox("First Name:", "BillingFName", "", array("required" => 1));
	$billing_form->addTextbox("Last Name:", "BillingLName", "", array("required" => 1));
	$billing_form->addEmail("Email Address:", "BillingEmail", "", array("required" => 1));
	$billing_form->addTextbox("Phone Number:", "BillingPhone", "", array("required" => 1));
	$billing_form->addTextbox("Address:", "BillingAddress", "", array("required" => 1));
	$billing_form->addTextbox("City:", "BillingCity", "", array("required" => 1));
	$billing_form->addState("State:", "BillingState", "", array("required" => 1));
	$billing_form->addTextbox("Zip Code:", "BillingZip", "", array("required" => 1));

	$shipping_form = new form("shipping", 500);
	$shipping_form->setAttributes(array(
		"map" => array(1, 2, 2, 1, 3)
	));
	$shipping_form->addHTML('<div style="font-weight: bold; padding-top: 15px; padding-bottom: 5px;">Shipping Address</div>');
	$shipping_form->addTextbox("First Name:", "ShippingFName", "", array("required" => 1));
	$shipping_form->addTextbox("Last Name:", "ShippingLName", "", array("required" => 1));
	$shipping_form->addEmail("Email Address:", "ShippingEmail", "", array("required" => 1));
	$shipping_form->addTextbox("Phone Number:", "ShippingPhone", "", array("required" => 1));
	$shipping_form->addTextbox("Address:", "ShippingAddress", "", array("required" => 1));
	$shipping_form->addTextbox("City:", "ShippingCity", "", array("required" => 1));
	$shipping_form->addState("State:", "ShippingState", "", array("required" => 1));
	$shipping_form->addTextbox("Zip Code:", "ShippingZip", "", array("required" => 1));

	$billing_form->addYesNo("Use my billing address for shipping?", "UseBilling", 1, array("onclick" => "toggleShipping(this.value);", "postHTML" => '<div id="shipping_section" style="display: none;">' . $shipping_form->elementsToString() . '</div>'));
	$billing_form->addButton();
	$billing_form->bind($shipping_form, 'document.getElementById("conditionalscenarios_0").UseBilling[1].checked', '$_POST["UseBilling"] == 0');
	$billing_form->render();
	?>

	<script type="text/javascript">
		function toggleShipping(val) {
			if(val == "1")
				document.getElementById("shipping_section").style.display = "none";
			else
				document.getElementById("shipping_section").style.display = "block";
		}	

		if(document.getElementById("conditionalscenarios_0").UseBilling[1].checked)
			toggleShipping(0);
	</script>

	<?php
	echo '<pre>', highlight_string('<?php
$billing_form = new form("conditionalscenarios_0", 500);
$billing_form->setAttributes(array(
	"map" => array(1, 2, 2, 1, 3, 1)
));

if(!empty($_GET["errormsg_0"]))
	$form->errorMsg = filter_var($_GET["errormsg_0"], FILTER_SANITIZE_SPECIAL_CHARS);

$billing_form->addHidden("cmd", "submit_0");
$billing_form->addHTML(\'<div style="font-weight: bold; padding-bottom: 5px;">Billing Address</div>\');
$billing_form->addTextbox("First Name:", "BillingFName", "", array("required" => 1));
$billing_form->addTextbox("Last Name:", "BillingLName", "", array("required" => 1));
$billing_form->addEmail("Email Address:", "BillingEmail", "", array("required" => 1));
$billing_form->addTextbox("Phone Number:", "BillingPhone", "", array("required" => 1));
$billing_form->addTextbox("Address:", "BillingAddress", "", array("required" => 1));
$billing_form->addTextbox("City:", "BillingCity", "", array("required" => 1));
$billing_form->addState("State:", "BillingState", "", array("required" => 1));
$billing_form->addTextbox("Zip Code:", "BillingZip", "", array("required" => 1));

$shipping_form = new form("shipping", 500);
$shipping_form->setAttributes(array(
	"map" => array(1, 2, 2, 1, 3)
));
$shipping_form->addHTML(\'<div style="font-weight: bold; padding-top: 15px; padding-bottom: 5px;">Shipping Address</div>\');
$shipping_form->addTextbox("First Name:", "ShippingFName", "", array("required" => 1));
$shipping_form->addTextbox("Last Name:", "ShippingLName", "", array("required" => 1));
$shipping_form->addEmail("Email Address:", "ShippingEmail", "", array("required" => 1));
$shipping_form->addTextbox("Phone Number:", "ShippingPhone", "", array("required" => 1));
$shipping_form->addTextbox("Address:", "ShippingAddress", "", array("required" => 1));
$shipping_form->addTextbox("City:", "ShippingCity", "", array("required" => 1));
$shipping_form->addState("State:", "ShippingState", "", array("required" => 1));
$shipping_form->addTextbox("Zip Code:", "ShippingZip", "", array("required" => 1));

$billing_form->addYesNo("Use my billing address for shipping?", "UseBilling", 1, array("onclick" => "toggleShipping(this.value);", "postHTML" => \'<div id="shipping_section" style="display: none;">\' . $shipping_form->elementsToString() . \'</div>\'));
$billing_form->addButton();
$billing_form->bind($shipping_form, \'document.getElementById("conditionalscenarios_0").UseBilling[1].checked\', \'$_POST["UseBilling"] == 0\');
$billing_form->render();
?>

<script type="text/javascript">
	function toggleShipping(val) {
		if(val == "1")
			document.getElementById("shipping_section").style.display = "none";
		else
			document.getElementById("shipping_section").style.display = "block";
	}	

	if(document.getElementById("conditionalscenarios_0").UseBilling[1].checked)
		toggleShipping(0);
</script>
', true), '</pre>';

	$location_form = new form("conditionalscenarios_1", 500);
	$location_form->setAttributes(array(
		"noAutoFocus" => 1
	));	

	if(!empty($_GET["errormsg_1"]))
		$location_form->errorMsg = filter_var($_GET["errormsg_1"], FILTER_SANITIZE_SPECIAL_CHARS);

	$map_form = new form("map", 500);
	$map_form->addLatLng("", "LatitudeLongitude", "", array("required" => 1));

	$address_form = new form("address", 500);
	$address_form->setAttributes(array(
		"map" => array(1, 3)
	));	
	$address_form->addTextbox("Address:", "BillingAddress", "", array("required" => 1));
	$address_form->addTextbox("City:", "BillingCity", "", array("required" => 1));
	$address_form->addState("State:", "BillingState", "", array("required" => 1));
	$address_form->addTextbox("Zip Code:", "BillingZip", "", array("required" => 1));

	$location_form->addHidden("cmd", "submit_1");
	$location_form->addSelect("How would you like to specify your location?", "LocationOption", "Map", array("Map" => "Select My Location Using Google Maps", "Address" => "Enter My Address Manually"), array("onchange" => "toggleLocationOptions(this.value);", "postHTML" => '<div id="MapDiv" style="padding-top: 10px;">' . $map_form->elementsToString() . '</div><div id="AddressDiv" style="display: none; padding-top: 10px;">' . $address_form->elementsToString() . '</div>', "required" => 1));
	$location_form->addButton();
	$location_form->bind($map_form, 'document.getElementById("conditionalscenarios_1").LocationOption.value == "Map"', '$_POST["LocationOption"] == "Map"');
	$location_form->bind($address_form, 'document.getElementById("conditionalscenarios_1").LocationOption.value == "Address"', '$_POST["LocationOption"] == "Address"');
	$location_form->render();
	?>

	<script type="text/javascript">
		function toggleLocationOptions(val) {
			document.getElementById("MapDiv").style.display = "none";
			document.getElementById("AddressDiv").style.display = "none";
			document.getElementById(val + "Div").style.display = "block";
		}	

		toggleLocationOptions(document.getElementById("conditionalscenarios_1").LocationOption.value);
	</script>

	<?php
	echo '<pre>', highlight_string('<?php
$location_form = new form("conditionalscenarios_1", 500);
$location_form->setAttributes(array(
	"ajax" => 1,
	"noAutoFocus" => 1
));	

if(!empty($_GET["errormsg_1"]))
	$form->errorMsg = filter_var($_GET["errormsg_1"], FILTER_SANITIZE_SPECIAL_CHARS);

$map_form = new form("map", 500);
$map_form->addLatLng("", "LatitudeLongitude", "", array("required" => 1));

$address_form = new form("address", 500);
$address_form->setAttributes(array(
	"map" => array(1, 3)
));	
$address_form->addTextbox("Address:", "BillingAddress", "", array("required" => 1));
$address_form->addTextbox("City:", "BillingCity", "", array("required" => 1));
$address_form->addState("State:", "BillingState", "", array("required" => 1));
$address_form->addTextbox("Zip Code:", "BillingZip", "", array("required" => 1));

$location_form->addHidden("cmd", "submit_1");
$location_form->addSelect("How would you like to specify your location?", "LocationOption", "Map", array("Map" => "Select My Location Using Google Maps", "Address" => "Enter My Address Manually"), array("onchange" => "toggleLocationOptions(this.value);", "postHTML" => \'<div id="MapDiv" style="padding-top: 10px;">\' . $map_form->elementsToString() . \'</div><div id="AddressDiv" style="display: none; padding-top: 10px;">\' . $address_form->elementsToString() . \'</div>\', "required" => 1));
$location_form->addButton();
$location_form->bind($map_form, \'document.getElementById("conditionalscenarios_1").LocationOption.value == "Map"\', \'$_POST["LocationOption"] == "Map"\');
$location_form->bind($address_form, \'document.getElementById("conditionalscenarios_1").LocationOption.value == "Address"\', \'$_POST["LocationOption"] == "Address"\');
$location_form->render();
?>

<script type="text/javascript">
	function toggleLocationOptions(val) {
		document.getElementById("MapDiv").style.display = "none";
		document.getElementById("AddressDiv").style.display = "none";
		document.getElementById(val + "Div").style.display = "block";
	}	

	toggleLocationOptions(document.getElementById("conditionalscenarios_1").LocationOption.value);
</script>
', true), '</pre>';

	include("../footer.php");
}
?>
