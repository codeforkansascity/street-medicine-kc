<?php
class Days {
	public $table = "dayOfWeek";

        // The database object
        protected static $db;

        public function __construct() {
                self::$db = new Db() or die("Unable to initiate database object");
                $dbconn = self::$db->connect() or die("Unable to connect to the database");
        }

	/*
		            * Returns an array of days
		            *
		            * @param  $orderby - Field by which to order (default: id)
		            *
		            * @return MySQL query result array
	*/
	public function getAllDays($orderby = "id") {
		$db = self::$db;
		$sql = "SELECT * FROM " . $this->table . " ORDER BY $orderby";
		$days = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return $days;
	}
}
?>
