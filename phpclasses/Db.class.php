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
			// Load configuration as an array. Use the actual location of your configuration file
			$config = parse_ini_file(dirname(__FILE__) . '/../dbconfig.ini');
			// Create connection

			if (version_compare(phpversion(), '5.6.10', '<')) {
				self::$connection = mysql_connect($config['host'], $config['dbuser'], $config['dbpass']);
				if (!self::$connection) {
					echo "Connection failed.";
				}
				self::$db_selected = mysql_select_db($config['dbname'], self::$connection);
			} else {
				self::$connection = new mysqli($config['host'], $config['dbuser'], $config['dbpass'], $config['dbname']);
				if (self::$connection->connect_error) {
					echo ("Connection failed: " . self::$connection->connect_error);
				}
			}

// Check connection
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
		if (version_compare(phpversion(), '5.6.10', '<')) {
			$result = mysql_query('SELECT * WHERE 1=1');
			if (!$result) {
				die('Invalid query: ' . mysql_error());
			} else {
				// do nothing
			}
		} else {
			$result = mysqli_query($connection, $query);
		}

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
		$result = $this->query($query);
		if ($result === false) {
			return false;
		}
		if (version_compare(phpversion(), '5.6.10', '<')) {
			while ($row = mysql_fetch_assoc($result)) {
			}
		} else {
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row;
			}
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
