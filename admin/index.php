<?php
require '../variables.php';
require '../controller.php';
$db = new Db();
echo $header;
?>

<!--BEGIN CUSTOM CONTENT-->
<div class="page-header">
	<h1>Add/Edit Agency Record</h1>
	<h4>Select an agency to edit.</h4>
</div>

<form method="post" name="id" action="form2.php">
	<div class="form-group">
<?php
$A = new Agencies();
$agencies = $A->fetchAgencies();
?>
		<select class="c-select" name="id">
				<option value="0">New Agency Record</option>
<!-- Phil - I LIKE TO USE 0 - WHAT IF WE HAVE 99999 AGENCIES ONE DAY?
	ALSO - THIS WILL BE SELECTED UNLESS AN AGENCY HAS BEEN SELECTED TO EDIT, NO NEED FOR selected-->
<?php
foreach ($agencies as $agency) {
	$agencyName = $agency["name"];
	$agency_id = $agency["id"];
	echo "<option value='$agency_id'";
	if ($_REQUEST['id'] == $agency_id) {
		echo " selected";
	}
	//SELECTED AGENCY, IF APPLICABLE
	echo ">$agencyName</option>";
}
echo "</select></div><br><button type='submit' class='btn btn-primary'>Continue</button></form>"; //'CONTINUE' WORKS FOR ADDING OR EDITING

echo $footer;
?>
