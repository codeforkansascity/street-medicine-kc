<?php
class Hours {
	public $table = "agencyHours";

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
	public function deleteHoursForAgency($agency_id) {
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
	public function getHoursForAgency($agency_id, $subcategory_id = 0, $orderby = "dayOfWeek_id, openTime") {
                $db = self::$db;
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
	public function insertHoursForAgency($openTime, $closeTime, $dayOfWeek_id, $agency_id, $subcategory_id) {
                $db = self::$db;
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
