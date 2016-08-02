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
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
include_once '../functions.php';
echo $header;
?>
        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <h1>Register with us</h1>
        <?php
if (!empty($error_msg)) {
	echo $error_msg;
}

$L = new Login();
if ($L->loginCheck() == FALSE) {
	echo "You are not authorized to add an agent.";
	exit();
}

?>
        <ul>
            <li>Usernames may contain only digits, upper and lower case letters and underscores</li>
            <li>Emails must have a valid email format</li>
            <li>Passwords must be at least 6 characters long</li>
            <li>Passwords must contain
                <ul>
                    <li>At least one upper case letter (A..Z)</li>
                    <li>At least one lower case letter (a..z)</li>
                    <li>At least one number (0..9)</li>
                </ul>
            </li>
            <li>Your password and confirmation must match exactly</li>
        </ul>
        <form method="post" name="registration_form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">
            <p>Username: <input type='text' name='username' id='username' /></p>
            <p>Email: <input type="text" name="email" id="email" /></p>
            <p>Password: <input type="password"
                             name="password"
                             id="password"/></p>
            <p>Confirm password: <input type="password"
                                     name="confirmpwd"
                                     id="confirmpwd" /></p>
            <p><input type="button"
                   value="Register"
                   onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);" /></p>
        </form>
        <p>Return to the <a href="index.php">login page</a>.</p>
<?php echo $footer; ?>
