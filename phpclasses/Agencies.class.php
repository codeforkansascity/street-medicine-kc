<?php
class Agencies {

        // The database object
        protected static $db;

	public $table = "agency";
	public $subCatLinkTable = "agency_has_subcategories";
	public $subCatTable = "subCategory";
	public $catTable = "category";

	public function __construct() {
                self::$db = new Db() or die("Unable to initiate database object");
                $dbconn = self::$db->connect() or die("Unable to connect to the database");
	}

	/*
		        * Returns a single Agency in the Agency table
		        *
		        * @param  $agencyid
		        *
		        * @return associative array
	*/

	public function fetchAgency($agencyid) {
		if (!$agencyid) {
			return FALSE;
		}

		$db = self::$db;
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

	public function getAgencyDescription($agencyid) {
		$db = self::$db;
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

			$description .= "<span style=\"float:left;\"><a target=\"_blank\" href=\"https://maps.google.com/maps?dirflg=r&saddr=My+Location&daddr=" . urlencode("$agency[address1], $agency[city] $agency[state], $agency[zipcode]") . "\"><b>GET DIRECTIONS</b></a></span><span style=\"float:right;\"><a target=\"_blank\" href=\"#\"><b>MORE INFO</b></a></span><div style=\"clear:both;\"></div>";
			return $description;
		}
	}

	/*
		        * Returns an array of all sub categories under a given category
		        *
		        * @param  $orderby - Field by which to order (default: subCategory)
		        *
		        * @return bool
	*/

	public function refreshSubCatLinkTable($agency_id, $subcategories_id) {
		$db = self::$db;
		$sql = "INSERT INTO " . $this->subCatLinkTable . " VALUES ($agency_id, $subcategories_id);";
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
		     	* @return MySQL false on error, else query result
	*/

	public function fetchAgencies($orderby = "name ASC") {
		$db = self::$db;
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

	public function formatPhone($phone) {
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

	public function fetchActivatedAgencySubCategories($agencyid = 0, $categoryid = 0, $orderby = "subCategory") {

		if ($agencyid == 0) {
			return FALSE;
		}

		$sql = "SELECT t1.* FROM " . $this->subCatTable . " AS t1, " . $this->subCatLinkTable . " AS t2 WHERE t1.id=t2.subCategories_id AND t2.Agency_id='$agencyid'";
		if ($categoryid > 0) {
			$sql .= " AND t1.categories_id='$categoryid'";
		}

		$sql .= " ORDER BY $orderby";

		$db = self::$db;
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

	public function agencyHasSubCategory($agencyid, $subcatid) {
		if (!$agencyid || !$subcatid) {
			return FALSE;
		}

		$db = self::$db;

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
			        * @return       MySQL query result, false on error
	*/
	public function fetchActivatedAgencyCategories($agencyid = 0, $orderby = "category") {

		if ($agencyid == 0) {
			return FALSE;
		}

		$db = self::$db;

		$sql = "SELECT DISTINCT t1.* FROM " . $this->catTable . " AS t1, " . $this->subCatTable . " AS t2, " . $this->subCatLinkTable . " AS t3 WHERE t1.id=t2.category_id AND t2.id=t3.subCategories_id AND t3.Agency_id='$agencyid' ORDER BY $orderby";

		$activatedCats = $db->select($sql);

		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}

		return $activatedCats;
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
	public function insert_agency($name, $description, $address1, $address2, $city, $state, $zip, $website, $email, $free) {

		$db = self::$db;

		$sql = "INSERT INTO " . $this->table . " (name, description, address1, address2, city, state, zip, website, email, free)
		VALUES ('$name', '$description' , '$address1', '$address2', '$city', '$state', '$zip', '$website', '$email', $free)";

		$result = $db->query($sql);

		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		if (version_compare(phpversion(), '5.6.10', '<')) {
			$insert_id = mysql_insert_id(); //This is the Agency.id value for the newly inserted Agency
		} else {
			$insert_id = $dbconn->insert_id;
		}
		return $insert_id;
	}

	/*
		 * Update existing agency's info in the database
		 * Assumption: All data has been sanitized/prepped
		 *
		 * @return	boolean
	*/
	public function update_agency($id, $agency, $description, $address1, $address2, $city, $state, $zip, $website, $email, $free) {

		$db = self::$db;

		$sql = "UPDATE " . $this->table . " SET name='$agency', description='$description', address1='$address1', address2='$address2', city='$city', state='$state',
	zip='$zip', website='$website', email='$email', free=$free WHERE id=$id;";

		$db->query($sql);

		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return TRUE;
	}

	/*
		 * Use Google Maps API to grab the coordinates for an Agency's location
		 *
		 * @param	agencyid
		 * @return       "$lat,$lng" or FALSE
	*/
	public function getCoordinates($agencyid) {
		$db = self::$db;
		$sql = "SELECT * FROM " . $this->table . " WHERE id='$agencyid'";
		$result = $db->query($sql);

		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}

		if (version_compare(phpversion(), '5.6.10', '<')) {
			$row = mysql_fetch_array($result);
		} else {
			$row = mysqli_fetch_array($result);
		}

		$url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyD4msj-ty44VVh0dNDPPocz0wAv_XIRjiE&address=" . urlencode($row[address1] . " " . $row[address2] . ", $row[city], $row[state]");

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
	public function isInCategory($agencyid, $categid) {
		$sql = "SELECT * FROM subCategories AS t2, Agency_has_subCategories AS t3 WHERE t2.id=t3.subCategories_id AND t3.Agency_id='$agencyid' AND t2.categories_id='$categid'";

		$db = self::$db;

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
                 * Delete agency and related info from the database
                 *
                 * @return      boolean
        */
        public function deleteAgency($id)	{

                $db = self::$db;

		$sql="DELETE FROM contact WHERE agency_id='$id'";
                $db->query($sql);
                if ($db->error()) {
                        echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
                        return FALSE;
                }

                $sql="DELETE FROM agency_has_subcategories WHERE agency_id='$id'";
                $db->query($sql);
                if ($db->error()) {
                        echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
                        return FALSE;
                }

                $sql="DELETE FROM agencyHours WHERE agency_id='$id'";
                $db->query($sql);
                if ($db->error()) {
                        echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
                        return FALSE;
                }

                $sql="DELETE FROM agency WHERE id='$id'";
                $db->query($sql);
                if ($db->error()) {
                        echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
                        return FALSE;
                }
                return TRUE;
        }

	/*
		* Add/Update coordinates for an agency
		*
		* @param $agencyid: if 0 = check for missing coordinates; if >0, update that agency only
		* @return boolean
	*/
	public function geoCode($agencyid=0) {
		$db=self::$db;
		if($agencyid==0)
		   	$sql = "SELECT * FROM agency WHERE latitude=0 AND address1!=''";
		else
			$sql = "SELECT * FROM agency WHERE id='$agencyid'";
                $agencies = $db->select($sql);
                if ($db->error()) {
                        echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
                        return FALSE;
                }
                foreach ($agencies as $agency) {
        		$temp = explode(",", $this->getCoordinates($agency['id']));
        		$sql2 = "UPDATE agency SET latitude='$temp[0]',longitude='$temp[1]' WHERE id='".$agency['id']."'";
        		$result2 = $db->query($sql2);
                	if ($db->error()) {
                        	echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
                        	return FALSE;
                	}
		}
	}

} //End Class Definition
?>
