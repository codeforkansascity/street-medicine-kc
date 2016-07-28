<?php
require '../variables.php';
require '../controller.php';
require 'functions.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
/* Process the Form Input */
sec_session_start();
if (login_check($mysqli) == false) {
	echo "You are not authorized to access this page, please <a href=\"../admin/\">login</a>.";
}
if ($_POST) {
	$A = new Agencies();
	$C = new Categories();
	$H = new Hours();
	$K = new Contacts();

	$agency_id = $_POST['agency_id'];

//Prep the input as much as we can
	$zip = prepInput($_POST["zip"]);
	$city = prepInput($_POST["city"]);
	$email = prepInput($_POST["email"]);
	$state = prepInput($_POST["state"]);
	$agency = prepInput($_POST["agency"]);
	$address1 = prepInput($_POST["address1"]);
	$address2 = prepInput($_POST["address2"]);
	$free = prepInput($_POST["free"], "boolean");
	$website = prepInput($_POST["website"], "url");
	$description = prepInput($_POST["description"]);

	$tFormat = "H:i";
	if ($agency_id > 0) {
		// 	//Update an EXISTING Agency
		$H->deleteHoursForAgency($agency_id);
		$C->deleteSubcategoryRows($agency_id);
		$K->deleteContactsForAgency($agency_id);
		$A->update_agency($agency_id, $agency, $description, $address1, $address2, $city, $state, $zip, $website, $email, $free);
	} else {
		// Insert a NEW Agency, and get the new agency's ID
		$agency_id = $A->insert_agency($agency, $description, $address1, $address2, $city, $state, $zip, $website, $email, $free);
	}

	foreach ($_POST as $key => $value) {
		if (preg_match("/open/", $key) && $value != "") {
			doTime($H, $key, $value, $agency_id, $tFormat);
		} else if (preg_match("/subcat/", $key) && $value != "") {
			doSubcategory($A, $key, $agency_id);
		} else if (preg_match("/family/", $key) && $value != "") {
			doContact($K, $key, $agency_id);
		} //if match
	} //foreach
} //if $_POST

header("Location: form2.php?agency_id=$agency_id");

function doTime($H, $key, $value, $agency_id, $tFormat) {
	$j = prepInput(substr($key, 7, 1), "phone") + 1;
	$subcategory_id = prepInput(substr($key, 9), "phone");
	$D = new DateTime($value);
	$oTime = $D->format($tFormat);
	$k2 = str_replace("open+", "close+", $key);
	$D = new DateTime($_POST["$k2"]);
	$cTime = $D->format($tFormat);
	$H->insertHoursForAgency($oTime, $cTime, $j, $agency_id, $subcategory_id);
}

function doSubcategory($A, $key, $agency_id) {
	$subcategory_id = prepInput(substr($key, 6), "phone");
	$A->refreshSubCatLinkTable($agency_id, $subcategory_id);
}

function doContact($K, $key, $agency_id) {
	$contact_id = prepInput(substr($key, 6), "phone");
	$title = prepInput($_POST["title" . $contact_id]);
	$givenName = prepInput($_POST["given" . $contact_id]);
	$familyName = prepInput($_POST["family" . $contact_id]);
	$suffix = prepInput($_POST["suffix" . $contact_id]);
	$credentials = prepInput($_POST["credentials" . $contact_id]);
	$phone = prepInput($_POST["phone" . $contact_id], "phone");
	$email = prepInput($_POST["email" . $contact_id], "email");
	$contactType_id = prepInput($_POST["contactType" . $contact_id], "phone");
	$phoneType_id = prepInput($_POST["phoneType" . $contact_id], "phone");
	$K->insertContact($title, $givenName, $familyName, $suffix, $credentials, $phone, $email, $contactType_id, $agency_id, $phoneType_id);
}
?>
