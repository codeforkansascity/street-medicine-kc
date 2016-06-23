<?php
class Categories
{
   	public $table = "categories";
   	public $subtable = "subCategories";

   	public function __construct()
   	{
          	$config = parse_ini_file('../../dbconfig.ini');
          	require ($config['homedir'].'controller.php');
   	}

        /*
        * Returns an array of all Categories 
        *
        * @param  $orderby - Field by which to order (default: id)
        *
        * @return MySQL query result array
        */
   	function getAllCategories($orderby="id")
   	{
      		$db = new Db();
      		$dbconn = $db->connect();
      		$sql = "SELECT * FROM ".$this->table." ORDER BY $orderby";
      		$cats = $db->select($sql);
      		if($db->error()) {
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
   	function getSubCategories($catid)
        {
                $db = new Db();
                $dbconn = $db->connect();
                $sql = "SELECT * FROM ".$this->subtable." WHERE categories_id='$catid' ORDER BY $orderby";
                $subcats = $db->select($sql);
                if($db->error()) {
                        echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
                        return FALSE;
                }
                return $subcats;
	}
}
?>
