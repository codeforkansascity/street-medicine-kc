<?php
class Contacts {
	public $table = "contact";
	public $contactTypeTable = "contactType";
	public $phoneTypeTable = "phoneType";

	public function __construct() {
	}

	/*
		$sql = "DELETE FROM homeless_kc.agency_has_subcategories WHERE agency_id=$agency_id;";

		            * Returns bool
		            *
		            * @param  $openTime, $closeTime, $dayOfWeek_id, $agency_id
		            *
		            * @return FALSE on error, otherwise TRUE
	*/
	function deleteContactsForAgency($agency_id) {
		$db = new Db();
		$dbconn = $db->connect();
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
	function getContactsForAgency($agency_id, $orderby = "contactType_id") {
		$db = new Db();
		$dbconn = $db->connect();
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
	function getContactType($id) {
		$db = new Db();
		$dbconn = $db->connect();
		$sql = "SELECT type FROM " . $this->contactTypeTable . " WHERE id = $id";
		$result = $db->query($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		$type = $result->fetch_assoc();
		return $type[type];
	}

	/*
		            * Returns a phone type given its id
		            *
		            * @return MySQL query result string
	*/
	function getPhoneType($id) {
		$db = new Db();
		$dbconn = $db->connect();
		$sql = "SELECT type FROM " . $this->phoneTypeTable . " WHERE id = $id";
		$result = $db->query($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		$type = $result->fetch_assoc();
		return $type[type];
	}

	/*
		            * Returns a contact type given its id
		            *
		            * @return MySQL query result string
	*/
	function getAllContactTypes() {
		$db = new Db();
		$dbconn = $db->connect();
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
	function getAllPhoneTypes() {
		$db = new Db();
		$dbconn = $db->connect();
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
	function insertContact($title, $givenName, $familyName, $suffix, $credentials, $phone, $email, $contactType_id, $agency_id, $phoneType_id) {
		$db = new Db();
		$dbconn = $db->connect();
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
