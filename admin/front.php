<?php
include_once 'includes/functions.php';
require '../variables.php';
require '../controller.php';
// Include database connection and functions here.  See 3.1.
sec_session_start();
$L = new Login();
if ($L->loginCheck() == false) {
	echo "You are not authorized to access this page, please <a href=\"../admin/\">login</a>.";
	exit();
}
$db = new Db();
echo $header;

$A = new Agencies();
$message = "";
if ($_REQUEST['delete_agency_id']) {
	//DELETE AGENCY
	if ($A->deleteAgency($_REQUEST['delete_agency_id'])) {
		$message = "The agency has been deleted from the database.";
	} else {
		$message = "There was an error removing the agency from the database.";
	}
}
?>

<!--BEGIN CUSTOM CONTENT-->

    <div class="container theme-showcase" role="main">


<div class="page-header">
<h1 style="text-align:center;">Homeless KC <small>Main Menu</small></h1>
<?php if ($message != '') {
	echo "<div class=\"alert alert-warning\">" . $message . "</div>";
}
?>

<form method="post" name="id" action="form2.php">
	<hr />
        <div class="form-group">
	<h3>Add/Edit Agency Record:</h3>
	<h4>Select an agency to edit.</h4>
</div>
<?php
$agencies = $A->fetchAgencies();
?>
		<select class="c-select" name="id">
			<option value="0">New Agency Record</option>
<?php
$agencyinfo = array();
$a = 0;
foreach ($agencies as $agency) {
	$agencyinfo[$a] = $agency;
	$a++;
	$agencyName = $agency["name"];
	$agency_id = $agency["id"];
	echo "<option value='$agency_id'";
	if ($_REQUEST['id'] == $agency_id) {
		echo " selected";
	}
	//SELECTED AGENCY, IF APPLICABLE
	echo ">$agencyName</option>";
}
echo "</select><br /><br /><button type='submit' class='btn btn-primary'>Continue</button><br /><br /></form></div>"; //'CONTINUE' WORKS FOR ADDING OR EDITING

/* TABLE SHOWING ALL AGENCIES IN THE SYSTEM, PAGINATED, WITH SEARCH OPTION */
$agencyct = count($agencies);
if ($agencyct == 1) {
	$isare = "is";
} else {
	$isare = "are";
}

echo "<h3>There $isare currently <u>" . $agencyct . "</u>";
if ($agencyct == 1) {
	echo " agency";
} else {
	echo " agencies";
}

echo " in the system.</h3>";

$perpage = 10;
if (!$offset) {
	$offset = 0;
}

$curpage = ($offset / $perpage) + 1;
$pagect = ceil($agencyct / $perpage);
$pagenav = "<ul class=\"pagination\">";
for ($p = 1; $p <= $pagect; $p++) {
	$curoffset = ($perpage * $p) - 10;
	$pagenav .= "<li";
	if ($curpage == $p) {
		$pagenav .= " class=\"active\"";
	}

	$pagenav .= "><a href=\"front.php?offset=$curoffset\">$p</a></li>";
}
$pagenav .= "</ul><div style=\"clear:both;\"></div>";
echo $pagenav;

$limit = $offset + $perpage - 1;
if ($limit >= $agencyct) {
	$limit = $agencyct - 1;
}

$start = $offset + 1;
$end = $limit + 1;
echo '<table class="table table-striped"><caption><i>Showing ' . $start . ' to ' . $end . ' of ' . $agencyct . ' records.</caption>
  <thead>
    <tr>
      <th>Agency Name (click to edit)</th>
	<th>Address</th>
      	<th>City</th><th>State</th>
      	<th>Categories</th>
      	<th>Contact</th>
	<th>Delete</th>
    </tr>
  </thead>
  <tbody>';
$K = new Contacts();
$cTypes = $K->getAllContactTypes();
$pTypes = $K->getAllPhoneTypes();
for ($a = $offset; $a <= $limit; $a++) {
	echo "<tr><td><a href=\"form2.php?id=" . $agencyinfo[$a]['id'] . "\">" . $agencyinfo[$a]['name'] . "</a></td>
	<td>" . $agencyinfo[$a]['address1'] . "<br />" . $agencyinfo[$a]['address2'] . "</td>
	<td>" . $agencyinfo[$a]['city'] . "</td><td>" . $agencyinfo[$a]['state'] . "</td><td>";
	$cats = $A->fetchActivatedAgencyCategories($agencyinfo[$a]['id']);
	if ($cats) {
		foreach ($cats as $cat) {
			if ($cat['pinfile'] != '') {
				echo $cat['category'] . "<br />";
			}

		}
	}
	echo "</td><td>";
	$contacts = $K->getContactsForAgency($agencyinfo[$a]['id']);
	if ($contacts) {
		foreach ($contacts as $contact) {
			echo trim($contact['title'] . " " . $contact['givenName'] . " " . $contact['familyName'] . " " . $contact['suffix'] . " " . $contact['credentials']) . " (" . $K->getContactType($contact['contactType_id']) . ")<ul>";
			if (trim($contact['phone']) != '') {
				echo "<li>" . $A->formatPhone($contact['phone']) . " (" . $K->getPhoneType($contact['phoneType_id']) . ")</li>";
			}

			if (trim($contact['email']) != '') {
				echo "<li><a href=\"mailto:" . $contact['email'] . "\">" . $contact['email'] . "</a></li>";
			}

			echo "</ul>";
		}
	} else {
		echo "<i>(no contact listed)</i>";
	}

	echo "</td><td><a href=\"front.php?delete_agency_id=" . $agencyinfo[$a]['id'] . "\" onClick=\"return confirm('Are you sure you want to remove this agency from the database?');\">Delete</a></td></tr>";
}
echo "</tbody></table>";
echo $pagenav;

echo $footer;
?>

