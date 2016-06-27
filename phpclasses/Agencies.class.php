<?php
class Agencies {

	public $table = "agency";
	public $subCatLinkTable = "agency_has_subcategories";
	public $subCatTable = "subCategory";
	public $catTable = "category";

	public function __construct() {
	}

	/*
		        * Returns a single Agency in the Agency table
		        *
		        * @param  $agencyid
		        *
		        * @return associative array
	*/
	function fetchAgency($agencyid) {
		if (!$agencyid) {
			return FALSE;
		}

		$db = new Db();
		$dbconn = $db->connect();
		$sql = "SELECT * FROM " . $this->table . " WHERE id='$agencyid'";
		$agencies = $db->select($sql);

		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		if (!$agencies) {
			return FALSE;
		}

		foreach ($agencies as $agency) {
			$agency['cdata'] = $this->getAgencyDescription($agencyid);
			return $agency;
		}
	}

	/*
		        * Returns the CDATA description a single Agency in the Agency table
		        *
		        * @param  $agencyid
		        *
		        * @return string
	*/
	function getAgencyDescription($agencyid) {
		$db = new Db();
		$dbconn = $db->connect();
		$sql = "SELECT * FROM " . $this->table . " WHERE id='$agencyid'";
		$agencies = $db->select($sql);

		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}

		foreach ($agencies as $agency) {
			$description = "<h4>$agency[name]</h4>";
			$description .= "<p>$agency[address1]";
			if ($agency[address2] != '') {
				$description .= ", $agency[address2]";
			}

			$description .= "<br>$agency[city], $agency[state] $agency[zip]</p>";
			$description .= "<p><a href=\"tel:+1" . preg_replace("/[^0-9]/", "", $agency[phone]) . "\">" . $agency[phone] . "</a>";
			if ($agency[emergencyPhone] != '') {
				$description .= "<br><a href=\"tel:+1" . preg_replace("/[^0-9]/", "", $agency[emergencyPhone]) . "\">" . $agency[emergencyPhone] . "</a> (Emergency)";
			}

			$description .= "</p>";
			if ($agency[Website] != '') {
				$description .= "<p><a href=\"$agency[Website]\" target=\"_blank\">Website <i class=\"fa fa-external-link\" aria-hidden=\"true\"></i></a></p>";
			}

			if ($agency[hours] != '') {
				$description .= "<p>Hours: $agency[hours]</p>";
			}

			if ($agency[description] != '') {
				$description .= "<p>$agency[description]</p>";
			}

			$description .= "<span style=\"float:left;\"><a target=\"_blank\" href=\"https://www.google.com/maps?saddr=My+Location&daddr=$agency[latitude],$agency[longitude]\"><b>GET DIRECTIONS</b></a></span><span style=\"float:right;\"><a target=\"_blank\" href=\"#\"><b>MORE INFO</b></a></span><div style=\"clear:both;\"></div>";
			return $description;
		}
	}

	/*
		        * Returns an array of all sub categories under a given category
		        *
		        * @param  $orderby - Field by which to order (default: subCategory)
		        *
		        * @return MySQL query result array
	*/
	function refreshSubCatLinkTable($agency_id, $subcategories_id) {
		$db = new Db();
		$dbconn = $db->connect();
		$sql = "INSERT INTO " . $this->subCatLinkTable . " VALUES($agency_id, $subcategories_id);";
		$db->query($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return TRUE;
	}

	/*
		     	* Returns an array of all Agencies in the Agency table
		     	*
			* @param  $orderby - Field by which to order (default: name)
			*
		     	* @return MySQL query result
	*/
	function fetchAgencies($orderby = "name ASC") {
		$db = new Db();
		$dbconn = $db->connect();
		$sql = "SELECT * FROM " . $this->table . " ORDER BY $orderby";
		$agencies = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		foreach ($agencies as $agency) {
			$agency['cdata'] = $this->getAgencyDescription($agencyid);
			$agency['phone'] = $this->formatPhone($agency['phone']);
			$agency['emergencyPhone'] = $this->formatPhone($agency['emergencyPhone']);
			$agency['fax'] = $this->formatPhone($agency['fax']);
		}
		return $agencies;
	}

	/*
		* Format regular 10 digit number into (xxx) xxx-xxxx format
		*
		* @param phone
		*
		* @return formatted string
	*/
	function formatPhone($phone) {
		$phone = preg_replace("/[^0-9]/", "", $phone);
		$phone = "(" . substr($phone, 0, 3) . ") " . substr($phone, 3, 3) . "-" . substr($phone, 6, 4);
		return $phone;
	}

	/*
		* Return an array of the subCategories an Agency belongs to
		*
		* @param	$agencyid (Agency.id)
		* @param	$categoryid (if > 0, we only want subCategories of this category, ex: Languages)
		* @param 	$orderby (default order by is subcategory name)
		*
		* @return 	MySQL query result
	*/
	function fetchActivatedAgencySubCategories($agencyid = 0, $categoryid = 0, $orderby = "subCategory") {

		if ($agencyid == 0) {
			return FALSE;
		}

		$sql = "SELECT t1.* FROM " . $this->subCatTable . " AS t1, " . $this->subCatLinkTable . " AS t2 WHERE t1.id=t2.subCategories_id AND t2.Agency_id='$agencyid'";
		if ($categoryid > 0) {
			$sql .= " AND t1.categories_id='$categoryid'";
		}

		$sql .= " ORDER BY $orderby";

		$db = new Db();
		$dbconn = $db->connect();
		$activatedSubCats = $db->select($sql);

		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}

		return $activatedSubCats;
	}

	/*
		* Determine if an Agency is marked as offering services in a specific subCategory
		*
		* @param	$agencyid (Agency.id)
		* @param	$subcatid (subCategories.id)
		*
		* @return	boolean
	*/
	function agencyHasSubCategory($agencyid, $subcatid) {
		if (!$agencyid || !$subcatid) {
			return FALSE;
		}

		$db = new Db();
		$dbconn = $db->connect();

		$sql = "SELECT t1.* FROM " . $this->subCatTable . " AS t1, " . $this->subCatLinkTable . " AS t2 WHERE t1.id=t2.subCategories_id AND t2.Agency_id='$agencyid' AND t1.id='$subcatid'";

		$result = $db->query($sql);

		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}

		if (mysql_num_rows($result) > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/*
		        * Return an array of the (main) categories an Agency belongs to
		        *
		        * @param        $agencyid (Agency.id)
		        * @param        $orderby (default order by is category name)
		        *
		        * @return       MySQL query result
	*/
	function fetchActivatedAgencyCategories($agencyid = 0, $orderby = "category") {

		if ($agencyid == 0) {
			return FALSE;
		}

		$db = new Db();
		$dbconn = $db->connect();

		$sql = "SELECT DISTINCT t1.* FROM $catTable AS t1, " . $this->subCatTable . " AS t2, " . $this->subCatLinkTable . " AS t3 WHERE t1.id=t2.categories_id AND t2.id=t3.subCategories_id AND t3.Agency_id='$agencyid' ORDER BY $orderby";

		$result = $db->query($sql);

		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}

		return $result;
	}

	/*
		* Insert new agency into database
		* Assumption: All data has been sanitized/prepped
		*
		* @param
		* @param
		*
		* @return	mysql_insert_id() or FALSE if error
	*/
	function insert_agency($name, $description, $address1, $address2, $city, $state, $zip,
		$phone, $emergencyPhone, $fax, $website, $contactFirst, $contactLast, $email, $free) {

		$db = new Db();
		$dbconn = $db->connect();

		$sql = "INSERT INTO " . $this->table . " (name, description, address1, address2, city, state, zip, phone, emergencyPhone, fax, website, contactFirst, contactLast, email, free) VALUES ('$name', '$description' , '$address1', '$address2', '$city', '$state', '$zip', '$phone',     '$emergencyPhone', '$fax', '$website', '$contactFirst', '$contactLast', '$email', $free)";

		$result = $db->query($sql);

		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}

		return mysql_insert_id(); //This is the Agency.id value for the newly inserted Agency
	}

	/*
		* Update existing agency's info in the database
		* Assumption: All data has been sanitized/prepped
		*
		* @return	boolean
	*/
	function update_agency($id, $agency, $description, $address1, $address2, $city, $state, $zip,
		$phone, $emergencyPhone, $fax, $website, $contactFirst, $contactLast, $email, $free) {

		$db = new Db();
		$dbconn = $db->connect();

		$sql = "UPDATE " . $this->table . " SET name='$agency', description='$description', address1='$address1', address2='$address2', city='$city', state='$state',
        	zip='$zip', phone='$phone', emergencyPhone='$emergencyPhone', fax='$fax', website='$website', contactFirst='$first',
        	contactLast='$last', email='$email', free=$free WHERE id=$id;";

		$db->query($sql);

		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}

		// echo "<br>SQL: " . $sql . "<br>";
	}

	/*
		        * Use Google Maps API to grab the coordinates for an Agency's location
		        *
			* @param	agencyid
		        * @return       "$lat,$lng" or FALSE
	*/
	function getCoordinates($agencyid) {
		$db = new Db();
		$sql = "SELECT * FROM " . $this->table . " WHERE id='$agencyid'";
		$result = $db->query($sql);

		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}

		$row = mysql_fetch_array($result);
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($row[address1] . " " . $row[address2] . ", $row[city], $row[state]") . "&key=$GoogleMapsAPI";

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);

		if ($response) {
			$response = json_decode($response);
			if ($response->error) {
				return FALSE;
			}

			$lat = $response->results[0]->geometry->location->lat;
			$lng = $response->results[0]->geometry->location->lng;
			return ("$lat,$lng");
		}
		return FALSE;
	}

	/*
		* Check to see if an Agency is in a certain Category.
		*
		* @param	agency id
		* @param	category id
		*
		* @return	boolean
	*/
	function isInCategory($agencyid, $categid) {
		$sql = "SELECT * FROM subCategories AS t2, Agency_has_subCategories AS t3 WHERE t2.id=t3.subCategories_id AND t3.Agency_id='$agencyid' AND t2.categories_id='$categid'";

		$db = new Db();
		$dbconn = $db->connect();

		$result = $db->query($sql);

		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}

		if (mysql_num_rows($result) > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
} //End Class Definition
?>
