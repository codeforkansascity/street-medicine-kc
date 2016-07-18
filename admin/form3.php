<?php
require '../variables.php';
require '../controller.php';
require 'functions.php';

/* Process the Form Input */
if ($_POST) {
	$agency_id = $_POST['agency_id'];

	//Prep the input as much as we can
	$zip = prepInput($_POST["zip"]);
	$city = prepInput($_POST["city"]);
	$email = prepInput($_POST["email"]);
	$state = prepInput($_POST["state"]);
	$agency = prepInput($_POST["agency"]);
	$fax = prepInput($_POST["fax"], "phone");
	$contactLast = prepInput($_POST["last"]);
	$address1 = prepInput($_POST["address1"]);
	$address2 = prepInput($_POST["address2"]);
	$contactFirst = prepInput($_POST["first"]);
	$free = prepInput($_POST["free"], "boolean");
	$phone = prepInput($_POST["phone"], "phone");
	$website = prepInput($_POST["website"], "url");
	$description = prepInput($_POST["description"]);
	$emergencyPhone = prepInput($_POST["emergencyPhone"], "phone");

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

	$A = new Agencies();
	$C = new Categories();
	$H = new Hours();

	$f = "H:i";
	if ($agency_id > 0) {
		//Update an EXISTING Agency
		$H->deleteHoursForAgency($agency_id);
		$C->deleteSubcategoryRows($agency_id);
		$A->update_agency($agency_id, $agency, $description, $address1, $address2, $city, $state, $zip, $phone, $emergencyPhone, $fax, $website, $first, $last, $email, $free);
	} else {
		//Insert a NEW Agency, and get the new agency's ID
		$agency_id = $A->insert_agency($agency, $description, $address1, $address2, $city, $state, $zip, $phone, $emergencyPhone, $fax, $website, $first, $last, $email, $free);
	}

	foreach ($_POST as $key => $value) {
		if (preg_match("/open/", $key) && $value != "") {
			$i = substr($key, 5, 1);
			$j = substr($key, 7, 1);
			$D = new DateTime($value);
			$oTime = $D->format($f);
			$k2 = "close-$i+$j";
			$D = new DateTime($_POST["$k2"]);
			$cTime = $D->format($f);
			$H->insertHoursForAgency($oTime, $cTime, $j + 1, $agency_id);
		} else if (preg_match("/subcat/", $key) && $value != "") {
			$subcategory_id = substr($key, 7);
			$subcategory_id = preg_replace("/[^0-9]/", "", $subcategory_id);
			$A->refreshSubCatLinkTable($agency_id, $subcategory_id);
		} //if
	} //foreach
} //if

//What about missing required fields of information?
//using the required constraint on html input statements.

header("Location: form2.php?agency_id=$agency_id");

?>
