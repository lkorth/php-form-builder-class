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
			<title>PHP Form Builder Class | Examples | Conditional Scenarios</title>
			<link href="../style.css" rel="stylesheet" type="text/css"/>
			<link href="pfbc.css" rel="stylesheet" type="text/css"/>
			<script type="text/javascript"> 
				function toggleShipping(val)
				{
					if(val == "1")
						document.getElementById("shipping_section").style.display = "none";
					else
						document.getElementById("shipping_section").style.display = "block";
				}	

				function toggleLocationOptions(val)
				{
					document.getElementById("MapDiv").style.display = "none";
					document.getElementById("AddressDiv").style.display = "none";
					document.getElementById(val + "Div").style.display = "block";
				}	
			</script>
		</head>
		<body>
			<div id="pfbc_links"><a href="http://code.google.com/p/php-form-builder-class/" target="_blank">Homepage - Google Code Project Hosting</a> | <a href="http://groups.google.com/group/php-form-builder-class/" target="_blank">Development Community - Google Groups</a> | <a href="http://php-form-builder-class.googlecode.com/files/formbuilder.zip" target="_blank">Download Version <?php echo(file_get_contents('../version'));?></a></div>
			<div id="pfbc_banner">
				<h2>PHP Form Builder Class / Examples / Conditional Scenarios</h2>
				<h5><span>Version: <?php echo(file_get_contents('../version'));?></span><span style="padding-left: 10px;">Released: <?php echo(file_get_contents('../release'));?></span></h5>
			</div>

			<div id="pfbc_content">
				<p><b>Conditional Scenarios</b> - The example provided below demonstrates how the combination of multiple form instances, an onclick javascript event, and the elementsToString() function can be used to create sections that can be displayed or hidden based on a yes/no condition.</p>
				<p>An additional example is provided below demonstrating a similar conditional scenario - the difference is that a select box with an onchange event is used to trigger the condition as apposed to radio buttons with onclick events.

				<?php
				$billing_form = new form("billing");
				$billing_form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 500,
					"map" => array(1, 2, 2, 1, 3, 1)
				));
				$billing_form->addHidden("cmd", "submit");
				$billing_form->addHTML('<div style="font-weight: bold; padding-bottom: 5px;">Billing Address</div>');
				$billing_form->addTextbox("First Name:", "BillingFName", "", array("required" => 1));
				$billing_form->addTextbox("Last Name:", "BillingLName", "", array("required" => 1));
				$billing_form->addEmail("Email Address:", "BillingEmail", "", array("required" => 1));
				$billing_form->addTextbox("Phone Number:", "BillingPhone", "", array("required" => 1));
				$billing_form->addTextbox("Address:", "BillingAddress", "", array("required" => 1));
				$billing_form->addTextbox("City:", "BillingCity", "", array("required" => 1));
				$billing_form->addState("State:", "BillingState", "", array("required" => 1));
				$billing_form->addTextbox("Zip Code:", "BillingZip", "", array("required" => 1));

				$shipping_form = new form("shipping");
				$shipping_form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 500,
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

				$billing_form->addYesNo("Use my billing address for shipping?", "UseBilling", 1, array("clear" => 1, "onclick" => "toggleShipping(this.value);", "postHTML" => '<div id="shipping_section" style="display: none;">' . $shipping_form->elementsToString() . '</div>'));
				$billing_form->addButton();
				$billing_form->bind($shipping_form, 'document.forms["billing"].UseBilling[1].checked', '$_POST["UseBilling"] == 0');
				$billing_form->render();
				?>
				<script type="text/javascript">
					if(document.forms["billing"].UseBilling[1].checked)
						toggleShipping(0);
				</script>
				<?

echo '<pre>' . htmlentities('<?php
$billing_form = new form("billing");
$billing_form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 500,
	"map" => array(1, 2, 2, 1, 3, 1)
));
$billing_form->addHidden("cmd", "submit");
$billing_form->addHTML(\'<div style="font-weight: bold; padding-bottom: 5px;">Billing Address</div>\');
$billing_form->addTextbox("First Name:", "BillingFName", "", array("required" => 1));
$billing_form->addTextbox("Last Name:", "BillingLName", "", array("required" => 1));
$billing_form->addEmail("Email Address:", "BillingEmail", "", array("required" => 1));
$billing_form->addTextbox("Phone Number:", "BillingPhone", "", array("required" => 1));
$billing_form->addTextbox("Address:", "BillingAddress", "", array("required" => 1));
$billing_form->addTextbox("City:", "BillingCity", "", array("required" => 1));
$billing_form->addState("State:", "BillingState", "", array("required" => 1));
$billing_form->addTextbox("Zip Code:", "BillingZip", "", array("required" => 1));

$shipping_form = new form("shipping");
$shipping_form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 500,
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

$billing_form->addYesNo("Use my billing address for shipping?", "UseBilling", 1, array("clear" => 1, "onclick" => "toggleShipping(this.value);", "postHTML" => \'<div id="shipping_section" style="display: none;">\' . $shipping_form->elementsToString() . \'</div>\'));
$billing_form->addButton();
$billing_form->bind($shipping_form, \'document.forms["billing"].UseBilling[1].checked\', \'$_POST["UseBilling"] == 0\');
$billing_form->render();
?>

<script type="text/javascript">
	function toggleShipping(val)
	{
		if(val == "1")
			document.getElementById("shipping_section").style.display = "none";
		else
			document.getElementById("shipping_section").style.display = "block";
	}	

	if(document.forms["billing"].UseBilling[1].checked)
		toggleShipping(0);
</script>
') . '</pre>';

				$location_form = new form("location");
				$location_form->setAttributes(array(
					"includesPath" => "../includes",
					"ajax" => 1,
					"width" => 500,
					"noAutoFocus" => 1
				));	

				$map_form = new form("map");
				$map_form->setAttributes(array(
					"includesPath" => "../includes",
					"parentFormOverride" => "location",
					"width" => 500
				));	
				$map_form->addLatLng("", "LatitudeLongitude", "", array("required" => 1));

				$address_form = new form("address");
				$address_form->setAttributes(array(
					"includesPath" => "../includes",
					"width" => 500,
					"map" => array(1, 3)
				));	
				$address_form->addTextbox("Address:", "BillingAddress", "", array("required" => 1));
				$address_form->addTextbox("City:", "BillingCity", "", array("required" => 1));
				$address_form->addState("State:", "BillingState", "", array("required" => 1));
				$address_form->addTextbox("Zip Code:", "BillingZip", "", array("required" => 1));

				$location_form->addHidden("cmd", "submit");
				$location_form->addSelect("How would you like to specify your location?", "LocationOption", "Map", array("Map" => "Select My Location Using Google Maps", "Address" => "Enter My Address Manually"), array("onchange" => "toggleLocationOptions(this.value);", "postHTML" => '<div id="MapDiv" style="display: none; padding-top: 10px;">' . $map_form->elementsToString() . '</div><div id="AddressDiv" style="display: none; padding-top: 10px;">' . $address_form->elementsToString() . '</div>', "required" => 1));
				$location_form->addButton();
				$location_form->bind($map_form, 'document.forms["location"].LocationOption.value == "Map"', '$_POST["LocationOption"] == "Map"');
				$location_form->bind($address_form, 'document.forms["location"].LocationOption.value == "Address"', '$_POST["LocationOption"] == "Address"');
				$location_form->render();
				?>
				<script type="text/javascript">
					toggleLocationOptions(document.forms["location"].LocationOption.value);
				</script>
				<?

echo '<pre>' . htmlentities('<?php
$location_form = new form("location");
$location_form->setAttributes(array(
	"includesPath" => "../includes",
	"ajax" => 1,
	"width" => 500,
	"noAutoFocus" => 1
));	

$map_form = new form("map");
$map_form->setAttributes(array(
	"includesPath" => "../includes",
	"parentFormOverride" => "location",
	"width" => 500
));	
$map_form->addLatLng("", "LatitudeLongitude", "", array("required" => 1));

$address_form = new form("address");
$address_form->setAttributes(array(
	"includesPath" => "../includes",
	"width" => 500,
	"map" => array(1, 3)
));	
$address_form->addTextbox("Address:", "BillingAddress", "", array("required" => 1));
$address_form->addTextbox("City:", "BillingCity", "", array("required" => 1));
$address_form->addState("State:", "BillingState", "", array("required" => 1));
$address_form->addTextbox("Zip Code:", "BillingZip", "", array("required" => 1));

$location_form->addHidden("cmd", "submit");
$location_form->addSelect("How would you like to specify your location?", "LocationOption", "Map", array("Map" => "Select My Location Using Google Maps", "Address" => "Enter My Address Manually"), array("onchange" => "toggleLocationOptions(this.value);", "postHTML" => \'<div id="MapDiv" style="display: none; padding-top: 10px;">\' . $map_form->elementsToString() . \'</div><div id="AddressDiv" style="display: none; padding-top: 10px;">\' . $address_form->elementsToString() . \'</div>\', "required" => 1));
$location_form->addButton();
$location_form->bind($map_form, \'document.forms["location"].LocationOption.value == "Map"\', \'$_POST["LocationOption"] == "Map"\');
$location_form->bind($address_form, \'document.forms["location"].LocationOption.value == "Address"\', \'$_POST["LocationOption"] == "Address"\');
$location_form->render();
?>

<script type="text/javascript">
	function toggleLocationOptions(val)
	{
		document.getElementById("MapDiv").style.display = "none";
		document.getElementById("AddressDiv").style.display = "none";
		document.getElementById(val + "Div").style.display = "block";
	}	
	toggleLocationOptions(document.forms["location"].LocationOption.value);
</script>
') . '</pre>';

				?>
			</div>
		</body>	
	</html>	
	<?php
}
?>
