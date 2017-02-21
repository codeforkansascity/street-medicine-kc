<?php
/**
 * Copyright (C) 2013 peredur.net
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
require '../controller.php';
include_once 'includes/functions.php';

sec_session_start();

$L = new Login();
if ($L->loginCheck() == true) {
	$logged = 'in';
} else {
	$logged = 'out';
}
echo $header;

if (isset($_GET['error'])) {
	echo '<p class="error">Error Logging In!</p>';
}
?>
        <form action="includes/process_login.php" method="post" name="login_form">
	<h1>Homeless KC Login:</h1>
            <p>Email: <input type="text" name="email" />
            Password: <input type="password"
                             name="password"
                             id="password"/>
            <input type="button"
                   value="Login"
                   onclick="formhash(this.form, this.form.password);" /></p>
        </form>
        <p>You are currently logged <?php echo $logged ?>.</p>
        <?php
if ($logged == 'in') {
	echo "
        <p>You are authorized to <a href=\"register.php\">add an agent</a>.</p>
    <p>If you are done, please <a href=\"includes/logout.php\">log out</a>.</p>
        ";
}
echo $footer;
?>
