<?php
require '../variables.php';
require '../controller.php';
require 'functions.php';
echo $header;

/* Process the Form Input */
if ($_POST) {
	$agency_id = $_POST['agency_id'];

	//Prep the input as much as we can
	$agency = prepInput($_POST["agency"]);
	$description = prepInput($_POST["description"]);
	$email = prepInput($_POST["email"]);
	$address1 = prepInput($_POST["address1"]);
	$address2 = prepInput($_POST["address2"]);
	$city = prepInput($_POST["city"]);
	$state = prepInput($_POST["state"]);
	$zip = prepInput($_POST["zip"]);
	$phone = prepInput($_POST["phone"], "phone");
	$emergencyPhone = prepInput($_POST["emergencyPhone"], "phone");
	$fax = prepInput($_POST["fax"], "phone");
	$free = prepInput($_POST["free"], "boolean");
	$website = prepInput($_POST["website"], "url");
	$contactFirst = prepInput($_POST["first"]);
	$contactLast = prepInput($_POST["last"]);

	//Check for errors
	if (!preg_match("/[0-9]{10}/", $phone)) {
		echo "<br>Primary telephone number is invalid. ";
	}
	if (!empty($emergencyPhone) && !preg_match("/[0-9]{10}/", $emergencyPhone)) {
		echo "<br>Emergency telephone number is invalid. ";
	}
	if (!empty($fax) && !preg_match("/[0-9]{10}/", $fax)) {
		echo "<br>Fax number is invalid. ";
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "<br>E-mail address is invalid.";
	}

	$H = new Hours();
	$C = new Categories();
	$A = new Agencies();

	$H->deleteHoursForAgency($agency_id);
	$C->deleteSubcategoryRows($agency_id);
	$f = "H:i";
	if ($agency_id > 0) {
		//Update an EXISTING Agency
		$A->update_agency($agency_id, $agency, $description, $address1, $address2, $city, $state, $zip, $phone, $emergencyPhone, $fax, $website, $first, $last, $email, $free);
		// echo ("agency ID: $agency_id");
	} else {
		//Insert a NEW Agency, and get the new agency's ID
		$agency_id = $A->insert_agency($agency, $description, $address1, $address2, $city, $state, $zip, $phone, $emergencyPhone, $fax, $website, $first, $last, $email, $free);
		// echo ("agency ID: $agency_id");
	}
	foreach ($_POST as $key => $value) {
		if (preg_match("/open/", $key) && $value != "") {
			$i = substr($key, 5, 1);
			$j = substr($key, 7, 1);
			$D = new DateTime($value);
			$ot = $D->format($f);
			$k2 = "close-$i+$j";
			$D = new DateTime($_POST["$k2"]);
			$ct = $D->format($f);
			$H->insertHoursForAgency($ot, $ct, $j + 1, $agency_id);
		} else if (preg_match("/subcat/", $key) && $value != "") {
			$subcategory_id = substr($key, 7);
			$subcategory_id = preg_replace("/[^0-9]/", "", $subcategory_id);
			$A->refreshSubCatLinkTable($agency_id, $subcategory_id);
		}
	}
}

//What about missing required fields of information?
//using the required constraint on input statements.

echo ("<script>
<!--
location.replace(\"index.php\");
-->
</script>");

?>
