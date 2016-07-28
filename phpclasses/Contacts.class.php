<?php
class Contacts {
	public $table = "contact";
	public $contactTypeTable = "contactType";
	public $phoneTypeTable = "phoneType";

        // The database object
        protected static $db;

        public function __construct() {
                self::$db = new Db() or die("Unable to initiate database object");
                $dbconn = self::$db->connect() or die("Unable to connect to the database");
        }

	/*
		$sql = "DELETE FROM homeless_kc.agency_has_subcategories WHERE agency_id=$agency_id;";

		            * Returns bool
		            *
		            * @param  $openTime, $closeTime, $dayOfWeek_id, $agency_id
		            *
		            * @return FALSE on error, otherwise TRUE
	*/
	public function deleteContactsForAgency($agency_id) {
		$db = self::$db;
		$sql = "DELETE FROM " . $this->table . " WHERE agency_id=$agency_id;";
		$result = $db->query($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return TRUE;
	}

	/*
		            * Returns an array of hours for an agency
		            *
		            * @param  $orderby - Field by which to order (default: id)
		            *
		            * @return MySQL query result array
	*/
	public function getContactsForAgency($agency_id, $orderby = "contactType_id") {
                $db = self::$db;
		$sql = "SELECT * FROM " . $this->table . " WHERE agency_id = $agency_id ORDER BY $orderby";
		$contacts = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return $contacts;
	}

	/*
		            * Returns a contact type given its id
		            *
		            * @return MySQL query result string
	*/
	public function getContactType($id) {
                $db = self::$db;
		$sql = "SELECT type FROM " . $this->contactTypeTable . " WHERE id = $id";
                $type = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return $type[0][type];	//Returning a single result
	}

	/*
		            * Returns a phone type given its id
		            *
		            * @return MySQL query result string
	*/
	public function getPhoneType($id) {
                $db = self::$db;
		$sql = "SELECT type FROM " . $this->phoneTypeTable . " WHERE id = $id";
		$type = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
                return $type[0][type];  //Returning a single result
	}

	/*
		            * Returns a contact type given its id
		            *
		            * @return MySQL query result string
	*/
	public function getAllContactTypes() {
                $db = self::$db;
		$sql = "SELECT * FROM " . $this->contactTypeTable;
		$result = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return $result;
	}

	/*
		            * Returns a phone type given its id
		            *
		            * @return MySQL query result string
	*/
	public function getAllPhoneTypes() {
                $db = self::$db;
		$sql = "SELECT * FROM " . $this->phoneTypeTable;
		$result = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return $result;
	}

	/*
		            * Returns a phone type given its id
		            *
		            * @return MySQL query result string
	*/
	public function insertContact($title, $givenName, $familyName, $suffix, $credentials, $phone, $email, $contactType_id, $agency_id, $phoneType_id) {
                $db = self::$db;
		$sql = "INSERT INTO " . $this->table . " (title, givenName, familyName, suffix, credentials, phone, email, contactType_id, agency_id, phoneType_id)
		VALUES ('$title', '$givenName' , '$familyName', '$suffix', '$credentials', '$phone', '$email', '$contactType_id', '$agency_id', '$phoneType_id')";
		$result = $db->query($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return $result;
	}
}
?>
