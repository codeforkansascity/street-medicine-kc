<?php
//Database Class to perform standard DB operations
class Db {
	// The database connection
	protected static $connection;

	/**
	 * Connect to the database
	 *
	 * @return bool false on failure / mysqli MySQLi object instance on success
	 */
	public function connect() {
		// Try and connect to the database
		if (!isset(self::$connection)) {
			// echo "connecting...<br>";
			// Load configuration as an array. Use the actual location of your configuration file
			$config = parse_ini_file(dirname(__FILE__) . '/../dbconfig.ini');
			self::$connection = mysql_connect($config['host'], $config['dbuser'], $config['dbpass']);
			mysql_select_db($config['dbname']);
			// echo "connected<br>!";
		}

		// If connection was not successful, handle the error
		if (self::$connection === false) {
			// Handle error - notify administrator, log to a file, show an error screen, etc.
			echo ("connection failed<br>" . mysql_error());
			return false;
		}
		return self::$connection;
	}

	/**
	 * Query the database
	 *
	 * @param $query The query string
	 * @return mixed The result of the mysqli::query() function
	 */
	public function query($query) {
		// Connect to the database
		$connection = $this->connect();

		// Query the database
		$result = mysql_query($query);

		// echo "<br>Query: $query<br>result: $result<br>" . mysql_error();
		return $result;
	}

	/**
	 * Fetch rows from the database (SELECT query)
	 *
	 * @param $query The query string
	 * @return bool False on failure / array Database rows on success
	 */
	public function select($query) {
		$rows = array();
		$result = mysql_query($query);
		// echo "<br>Query: $query<br>result: $result<br>" . mysql_error();
		if ($result === false) {
			return false;
		}
		while ($row = mysql_fetch_assoc($result)) {
			//7.0:$result -> fetch_assoc()) {
			$rows[] = $row;
		}
		return $rows;
	}

	/**
	 * Fetch the last error from the database
	 *
	 * @return string Database error message
	 */
	public function error() {
		$connection = $this->connect();
		return $connection->error;
	}

	/**
	 * Quote and escape value for use in a database query
	 *
	 * @param string $value The value to be quoted and escaped
	 * @return string The quoted and escaped string
	 */
	public function quote($value) {
		$connection = $this->connect();
		return "'" . $connection->real_escape_string($value) . "'";
	}
}
?>
