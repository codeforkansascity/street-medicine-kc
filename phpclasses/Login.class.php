<?php
class Login {
	public $table = "admin";
	public $attempts = "loginAttempts";

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
	function deleteUsersForAgency($agency_id) {
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
		            * Returns an array of agents for an agency
		            *
		            * @param  $orderby - Field by which to order (default: id)
		            *
		            * @return MySQL query result array
	*/
	function getAdminRowsForAgency($agency_id, $orderby = "id") {
		$db = new Db();
		$dbconn = $db->connect();
		$sql = "SELECT * FROM " . $this->table . " WHERE agency_id = $agency_id ORDER BY $orderby";
		$rows = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return $rows;
	}

	/*
		            * Returns bool
		            *
		            * @param $agency_id
		            *
		            * @return FALSE on error, otherwise TRUE
	*/
	function insertUser($username, $email, $password, $random_salt) {
		$db = new Db();
		$dbconn = $db->connect();
		$sql = "INSERT INTO " . $this->table . " (username, email, password, salt)
			VALUES('$username', '$email', '$password', '$random_salt')";
		$db->query($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return TRUE;
	}

	/*
		            * Returns bool
		            *
		            * @param $admin_id
		            *
		            * @return FALSE on error, otherwise TRUE
	*/
	function insertLoginAttempt($admin_id) {
		$db = new Db();
		$dbconn = $db->connect();
		$time = time();
		$sql = "INSERT INTO " . $this->attempts . " ($admin_id, $time')";
		$db->query($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return TRUE;
	}

	/*
		            * Returns bool
		            *
		            * @param $admin_id, $maxAttemps
		            *
		            * @return FALSE on error or too many attempte, else TRUE
	*/
	function checkBruteForceAttack($admin_id, $maxAttempts) {
		$db = new Db();
		$dbconn = $db->connect();
		$time = time() - 7200; //two hours before
		$sql = "SELECT time FROM $this->attempts WHERE admin_id = $admin_id AND time > $time";
		$result = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		// If there have been too many failed logins
		return count($result) <= $maxAttempts;
	}

	/*
		            * Returns bool
		            *
		            * @param $email, $password
		            *
		            * @return FALSE on error or no login, else TRUE
	*/
	function login($email, $password) {
		$db = new Db();
		$dbconn = $db->connect();
		$sql = "SELECT id, userName, password, salt FROM admin WHERE email = '$email'";
		$result = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		$admin_id = $result[0]['id'];
		$db_password = $result[0]['password'];
		// $password = hash('sha512', $password . $salt);
		if (count($result) == 1) {
			// If the user exists we check if the account is locked
			// from too many login attempts
			// echo "admin_id: $admin_id<br>";
			if ($this->checkBruteForceAttack($admin_id, 5) == FALSE) {
				// Account is locked
				// Send an email to user saying their account is locked
				return false;
			} else {
				// Check if the password in the database matches
				// the password the user submitted.
				// echo "db_password: $db_password<br>password: $password<br>";
				if ($db_password == $password) {
					// echo "username: $username<br>";
					// echo "<br>admin_id: $admin_id<br>";
					// Password is correct!
					// Get the user-agent string of the user.
					$user_browser = $_SERVER['HTTP_USER_AGENT'];

					// XSS protection as we might print this value
					$admin_id = preg_replace("/[^0-9]+/", "", $admin_id);
					$_SESSION['admin_id'] = $admin_id;

					// XSS protection as we might print this value
					$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

					$_SESSION['username'] = $username;
					// $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
					$_SESSION['login_string'] = $password;

					// Login successful.
					return true;
				} else {
					// Password is not correct
					// We record this attempt in the database
					$now = time();
					$sql = "INSERT INTO loginAttempts(admin_id, time) VALUES ($admin_id, $now)";
					$db->query($sql);
					if ($db->error()) {
						echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
						return FALSE;
					}
					return false;
				}
			}
		} else {
			// No user exists.
			return false;
		}
	}

/*
 * Returns bool
 *
 * @param none
 *
 * @return true if logged in
 */
	function loginCheck() {
		$db = new Db();
		$dbconn = $db->connect();
		if (isset($_SESSION['admin_id'], $_SESSION['username'], $_SESSION['login_string'])) {
			$admin_id = $_SESSION['admin_id'];
			$login_string = $_SESSION['login_string'];
			$username = $_SESSION['username'];

			// Get the user-agent string of the user.
			$user_browser = $_SERVER['HTTP_USER_AGENT'];

			$sql = "SELECT password FROM admin  WHERE id = $admin_id LIMIT 1";
			$result = $db->select($sql);
			if ($db->error()) {
				echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
				return FALSE;
			}
			return (count($result) == 1 && $result[0]["password"] == $login_string);
		} else {
			// Not logged in
			return false;
		}
	}

/*
 * Returns bool
 *
 * @param none
 *
 * @return true if logged in
 */
	function userExists($email) {
		$db = new Db();
		$dbconn = $db->connect();
		$sql = "SELECT id FROM admin  WHERE email = '$email'";
		$result = $db->select($sql);
		if ($db->error()) {
			echo "<br>MySQL Error: " . $sql . "<br>" . $db->error() . "<br>";
			return FALSE;
		}
		return count($result) > 0;
	}
}
?>
