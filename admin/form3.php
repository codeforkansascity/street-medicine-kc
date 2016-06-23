<?php
require 'variables.php';
echo $header;

/* Process the Form Input */
if($_POST) {
	//Prep the input as much as we can
	$agency_id = $_POST["agency_id"];
	$agency = prepInput($_POST["agency"]);
	$description = prepInput($_POST["description"]);
	$email = prepInput($_POST["email"]);
	$address1 = prepInput($_POST["address1"]);
	$address2 = prepInput($_POST["address2"]);
	$city = prepInput($_POST["city"]);
	$state = prepInput($_POST["state"]);
	$zip = prepInput($_POST["zip"]);
	$phone = prepInput($_POST["phone"],"phone");
	$emergencyPhone = prepInput($_POST["emergencyPhone"],"phone");
	$fax = prepInput($_POST["fax"],"phone");
	$free = prepInput($_POST["free"],"boolean");
	$website = prepInput($_POST["website"],"url");
	$hours = prepInput($_POST["hours"]);
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

	//What about missing required fields of information?

	if($agency_id>0) {
		//Update an EXISTING Agency
                updateAgency($agency_id, $agency, $description, $address1, $address2, $city, $state, $zip, $phone, $emergencyPhone, $fax, $website, $hours, $first, $last, $email, $free);     //CALL TO AGENCY CLASS
	}
	else {
		//Insert a NEW Agency, and get the new agency's ID
		$agency_id = insertAgency($agency, $description, $address1, $address2, $city, $state, $zip, $phone, $emergencyPhone, $fax, $website, $hours, $first, $last, $email, $free);	//CALL TO AGENCY CLASS
	} 
	echo ("<script>
<!--
location.replace(\"index.php\");
-->
</script>");
} else {
	var_dump($email);
	echo "<br>Email: $email";
}

function delete_subcategories($id) {
	$conn = connect();

	$sql = "DELETE FROM homeless_kc.agency_has_subcategories WHERE agency_id=$id;";

	if ($conn->query($sql) === FALSE) {
		echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
	}

	$conn->close();
}

function doSubcategories($agency_id) {
	$allSubcategoriesResult = fetchAllSubcategories();
	while ($subcategoryRow = $allSubcategoriesResult->fetch_assoc()) {
		$subcategory_id = $subcategoryRow["id"];
		if ($_POST[$subcategory_id]) {
			update_agency_has_subcategories($agency_id, $subcategory_id);
		}
	}
}

function fetchActivatedAgencySubcategories($id) {
	$conn = connect();
	$sql = "SELECT subcategories_id FROM homeless_kc.agency_has_subCategories where agency_id=$id;";
	$result = $conn->query($sql);

	if ($conn->query($sql) === FALSE) {
		echo "<br>Error: " . $sql . "<br>" . $conn->error . "<br>";
	}

	$conn->close();

	return $result;
}

function fetchAllSubcategories() {
	$conn = connect();
	$sql = "SELECT * FROM homeless_kc.subcategory;";
	$result = $conn->query($sql);

	if ($conn->query($sql) === FALSE) {
		echo "<br>Error: " . $sql . "<br>" . $conn->error . "<br>";
	}

	$conn->close();

	return $result;
}

function fetchAgency($id) {
	$conn = connect();
	$sql = "SELECT * FROM homeless_kc.agency where id=$id;";
	$result = $conn->query($sql);

	if ($conn->query($sql) === FALSE) {
		echo "<br>Error: " . $sql . "<br>" . $conn->error . "<br>";
	}

	$conn->close();

	return $result;
}

function fetchCategories() {
	$conn = connect();

	$sql = "SELECT * FROM homeless_kc.category ORDER BY category";

	$result = $conn->query($sql);

	if ($conn->query($sql) === FALSE) {
		echo "<br>Error: " . $sql . "<br>" . $conn->error . "<br>";
	}
	$conn->close();

	return $result;
}

function fetchSubcategories($category_id) {
	$conn = connect();
	$sql = "SELECT * FROM homeless_kc.subcategory where category_id=$category_id ORDER BY subcategory";
	$result = $conn->query($sql);

	if ($conn->query($sql) === FALSE) {
		echo "<br>Error: " . $sql . "<br>" . $conn->error . "<br>";
	}

	$conn->close();

	return $result;
}

function insert_agency($agency, $description, $address1, $address2, $city, $state, $zip,
	$phone, $emergencyPhone, $fax, $website, $hours, $contactFirst, $contactLast, $email, $free) {

	$sql = "INSERT INTO homeless_kc.agency (`name`, `description`, `address1`, `address2`, `city`, `state`, `zip`, `phone`, `emergencyPhone`, `fax`, `website`, `hours`, `contactFirst`, `contactLast`, `email`, `free`) VALUES ('$agency', '$description' , '$address1', '$address2', '
	$city', '$state', '$zip', '$phone',	'$emergencyPhone', '$fax', '$website', '$hours', '$contactFirst', '$contactLast', '$email', $free)";

}

function test_input($data) {
	$data = trim($data);
	$data = addslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function update_agency($id, $agency, $description, $address1, $address2, $city, $state, $zip,
	$phone, $emergencyPhone, $fax, $website, $hours, $contactFirst, $contactLast, $email, $free) {
	$conn = connect();

	$sql = "UPDATE homeless_kc.agency SET name='$agency', description='$description', address1='$address1', address2='$address2', city='$city', state='$state',
	zip='$zip', phone='$phone', emergencyPhone='$emergencyPhone', fax='$fax', website='$website', hours='$hours', contactFirst='$first',
	contactLast='$last', email='$email', free=$free WHERE id=$id;";

	if ($conn->query($sql) === FALSE) {
		echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
	}

	$conn->close();
}

function update_agency_has_subcategories($agency_id, $subcategory_id) {
	$conn = connect();
	$sql = "INSERT INTO homeless_kc.agency_has_subcategories VALUES ($agency_id,$subcategory_id);";

	if ($conn->query($sql) === FALSE) {
		echo "<br>Error: " . $sql . "<br>" . $conn->error . "<br>";
	}

	$conn->close();
}
?>
