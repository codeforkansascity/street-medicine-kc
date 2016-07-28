<?php
class Categories {

	public $table = "category";
	public $subtable = "subCategory";
	public $junctionTable = "agency_has_subcategories";

        // The database object
        protected static $db;

        public function __construct() {
                self::$db = new Db() or die("Unable to initiate database object");
                $dbconn = self::$db->connect() or die("Unable to connect to the database");
        }

	/*
		        * Returns an array of all Categories
		        *
		        * @param  $orderby - Field by which to order (default: id)
			* @param $pinfile - If TRUE only return ones that have a pinfile associated
			*	with it (to make sure correct ones selected for I NEED search
		        *
		        * @return MySQL query result array
	*/
	public function getAllCategories($orderby = "id", $pinfile = FALSE) {
		$db = self::$db;
		$sql = "SELECT * FROM " . $this->table;
		if ($pinfile) {
			$sql .= " WHERE pinfile!=''";
		}

		$sql .= " ORDER BY $orderby";
		$cats = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return $cats;
	}

	/*
		        * Returns an array of all sub categories under a given category
		        *
		        * @param  $orderby - Field by which to order (default: subCategory)
		        *
		        * @return MySQL query result array
	*/
	public function getSubCategories($catid, $orderby = "sequence, id") {
                $db = self::$db;
		$sql = "SELECT * FROM " . $this->subtable . " WHERE category_id='$catid'" . " ORDER BY $orderby";
		$subcats = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return $subcats;
	}

	/*
		        * Returns an array of all sub categories under a given category
		        *
		        * @param  $orderby - Field by which to order (default: subCategory)
		        *
		        * @return MySQL query result array
	*/
	public function deleteSubcategoryRows($agency_id) {
                $db = self::$db;
		$sql = "DELETE FROM " . $this->junctionTable . " WHERE agency_id = $agency_id";
		$db->query($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return TRUE;
	}
}
?>
