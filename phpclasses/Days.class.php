<?php
class Days {
	public $table = "dayOfWeek";

	public function __construct() {
	}

	/*
		            * Returns an array of days
		            *
		            * @param  $orderby - Field by which to order (default: id)
		            *
		            * @return MySQL query result array
	*/
	function getAllDays($orderby = "id") {
		$db = new Db();
		$dbconn = $db->connect();
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
