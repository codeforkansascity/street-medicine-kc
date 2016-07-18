<?php
class Categories {
	public $table = "category";
	public $subtable = "subcategory";
	public $junctionTable = "agency_has_subcategories";

	public function __construct() {
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
	function getAllCategories($orderby = "id", $pinfile = FALSE) {
		$db = new Db();
		$dbconn = $db->connect();
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
	function getSubCategories($catid, $orderby = "sequence, id") {
		$db = new Db();
		$dbconn = $db->connect();
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
	function deleteSubcategoryRows($agency_id) {
		$db = new Db();
		$dbconn = $db->connect();
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
