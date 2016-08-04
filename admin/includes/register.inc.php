<?php

/*
 * Copyright (C) 2013 peter
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

include_once 'psl-config.php';
include_once '../controller.php';

$error_msg = "";

if (isset($_POST['username'], $_POST['email'], $_POST['p'], $_POST['agency_id'])) {
	// Sanitize and validate the data passed in
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// Not a valid email
		$error_msg .= '<p class="error">The email address you entered is not valid</p>';
	}

	$password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);

	$agency_id = filter_input(INPUT_POST, 'agency_id', FILTER_SANITIZE_STRING);
	// var_dump($password);
	if (strlen($password) != 128) {
		// The hashed pwd should be 128 characters long.
		// If it's not, something really odd has happened
		// $error_msg .= '<p class="error">Invalid password configuration.</p>';
	}

	// Username validity and password validity have been checked client side.
	// This should should be adequate as nobody gains any advantage from
	// breaking these rules.
	//
	$L = new Login();
	if ($L->userExists($email)) {
		// A user with this email address already exists
		$error_msg .= '<p class="error">A user with this email address already exists.</p>';
	} else {

		// TODO:
		// We'll also have to account for the situation where the user doesn't have
		// rights to do registration, by checking what type of user is attempting to
		// perform the operation.

		// Create a random salt
		$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

		// Create salted password
		// $password = hash('sha512', $password . $random_salt);

		// Insert the new user into the database
		if ($L->insertUser($username, $email, $password, $random_salt, $agency_id)) {
			header('Location: ./register_success.php');
		} else {
			header('Location: ../admin/error.php?err=Registration failure: INSERT');
		}
		exit();
	}
}
