<?php
class Hours {
	public $table = "agencyHours";

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
	function deleteHoursForAgency($agency_id) {
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
	function getHoursForAgency($agency_id, $subcategory_id = 0, $orderby = "dayOfWeek_id, openTime") {
		$db = new Db();
		$dbconn = $db->connect();
		$sql = "SELECT * FROM " . $this->table . " WHERE agency_id = $agency_id AND subcategory_id = $subcategory_id ORDER BY $orderby";
		$hours = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return $hours;
	}

	/*
		            * Returns bool
		            *
		            * @param  $openTime, $closeTime, $dayOfWeek_id, $agency_id
		            *
		            * @return FALSE on error, otherwise TRUE
	*/
	function insertHoursForAgency($openTime, $closeTime, $dayOfWeek_id, $agency_id, $subcategory_id) {
		$db = new Db();
		$dbconn = $db->connect();
		$sql = "INSERT INTO " . $this->table . " (openTime, closeTime, dayOfWeek_id, agency_id, subcategory_id)  VALUES('$openTime', '$closeTime', '$dayOfWeek_id', '$agency_id', '$subcategory_id')";
		$db->query($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return TRUE;
	}
}
?>
