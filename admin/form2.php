<?php
require '../variables.php';
require '../controller.php';
$db = new Db();
echo $header;

if ($_GET["agency_id"]) //This agency was saved - show them a confirmation message at the top
{
	$saved = 1;
	$agency_id = $_GET["agency_id"];
} else {
	$saved = 0;
	$agency_id = $_POST["id"];
}
?>

<!--BEGIN CUSTOM CONTENT-->
<div class="page-header">
	<h1><?php if ($agency_id == 0): ?>Add New<?php else: ?>Edit<?php endif;?> Agency Record</h1>
	<h4>Fields marked with a * are required.</h4>
</div>
<?php
if ($saved) {
	echo "<p class=\"bg-success\">This agency's information has been saved! Continue editing this agency below or <a href=\"index.php\"><b>click here</b></a> to return to the main menu.</p>";
}

if ($agency_id > 0) {
	$A = new Agencies();
	$agency = $A->fetchAgency($agency_id);

	//For the description, since it will go into textarea, let's convert "<br>" to line break:
	$agency['description'] = str_replace("<br>", "\r\n", $agency['description']);
}
//Otherwise, $agency will be empty by default and we can reference it anyway without harm

echo "<form method='POST' action='form3.php'>
	<input type='hidden' name='agency_id' value='$agency_id'> <!-- I MOVED THE HIDDEN VALUE OF THE agency_id HERE -->
	<div class='form-group'>
	<br><br>
	<label for='agency'>*Agency Name:</label>
	<input type='text' class='form-control' id='agency' name='agency' placeholder=\"Agency Name\" value=\"$agency[name]\" required>
	</div>
	<div class='form-group'>
	<label for='description'>Description:</label>
	<textarea rows='8' class='form-control' id='description' name='description' wrap='soft' placeholder='Description'>" . $agency['description'] . "</textarea>
	</div><div class='form-group'><p><input type='checkbox' name='free'";
if ($agency['free'] == 1) {
	echo " checked";
}

echo ">&nbsp;<b>All <u>FREE</u> services</b></p></div>
	<div class='form-group'><label for='email'>*Email:</label><input type='email' class='form-control' id='email' name='email' value=\"$agency[email]\" placeholder=\"agency@example.com\" required>
	</div>
	<div class='form-group'>
	<p><b>*Address Line 1</b>&nbsp;<input type='text' class='form-control' id='address1' name='address1' required value=\"$agency[address1]\" placeholder=\"Address Line 1\"></p>
	<p><b>Address Line 2</b>&nbsp;<input type='text' class='form-control' id='address2' name='address2' value=\"$agency[address2]\" placeholder=\"Address Line 2\"></p>
	<p><b>*City</b>&nbsp;<input type='text' size='20' id='city' name='city' required value=\"$agency[city]\" placeholder=\"City\">,&nbsp;
	<span class='radio-inline'><label><input type='radio' name='state' id='mo' value='MO'";
if ($agency['state'] == "MO") {
	echo " checked";
}

echo '>Missouri</label></span><span class="radio-inline"><label><input type="radio" name="state" id="ks" value="KS"';
if ($agency['state'] == "KS") {
	echo " checked";
}

echo ">Kansas</label></span>&nbsp;&nbsp;&nbsp;<b>*Zip</b>&nbsp;<input type='text' minlength='5' maxlength='10' size='11' id='zip' name='zip' required value=\"$agency[zip]\" placeholder=\"Zip\"></p>
	</div>
	<div class='form-group'>
	<label for='phone'>Telephone Numbers:</label>
	<p><b>*Primary:</b> <input id='phone' type='text' size=11 minlength=10 maxlength=10 name='phone' required value=\"$agency[phone]\" placeholder=\"8165551212\">&nbsp;&nbsp;&nbsp;
	<b>Emergency:</b> <input type='text' size=11 minlength=10 maxlength=10 name='emergencyPhone' value=\"$agency[emergencyPhone]\" placeholder=\"8165551212\">&nbsp;&nbsp;&nbsp;
	<b>Fax:</b> <input type='text' size=11 minlength=10 maxlength=10 name='fax' value=\"$agency[fax]\" placeholder=\"8165551212\">
	</p>
	</div>
	<div class='form-group'>
	<label for='first'>Name of Contact:</label>
	<p><b>First:</b> <input type='text' id='first' name='first' size='20' value=\"$agency[contactFirst]\" placeholder=\"First Name\">&nbsp;&nbsp;&nbsp;
	<b>Last:</b><input type='text' id='last' name='last' size='30' value=\"$agency[contactLast]\" placeholder=\"Last Name\"></p>
	</div>
	<div class='form-group'>
	<p><b>Website:</b> <input type='url' name='website' class='form-control' value=\"$agency[website]\" placeholder=\"http://\" size='60'></p>
	</div>
	<div class='form-group'>
	<p><b>*Hours:</b></p>
	</div>";

hoursTable($agency_id);

/* THE CATEGORIES & SUBCATEGORIES */

//Below, I'm going to incorporate the Categories class I've already written to pull out the available categories/subcategories

//First, get the subCategories the Agency has activated
$activatedSubcategories = [];
if ($agency_id > 0) {
	$subCats = $A->fetchActivatedAgencySubCategories($agency_id);
}
if ($subCats) {
	foreach ($subCats as $subCat) {
		array_push($activatedSubcategories, $subCat['id']);
	}
}

//Next, display an accordion of the categories & subcategories, with activated subcategories checked
$C = new Categories();
$cats = $C->getAllCategories();
if ($cats) {
	echo
		"<div class=\"panel-group\" id=\"accordion\">";
	foreach ($cats as $category) {
		echo
			"<div class=\"panel panel-default\">
			<div class=\"panel-heading\">
				<h4 class=\"panel-title\">
					<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse" . $category["id"] . "\">" . $category["category"] . "</a>
				</h4>
			</div>
			<div id=\"collapse" . $category["id"] . "\" class=\"panel-collapse collapse \">
				<div class=\"panel-body\">
					<div class=\"panel-group\" id=\"accordion" . $category["id"] . "\">";
//Show Subcategories of this Category:
		$subcats = $C->getSubCategories($category['id']);
		foreach ($subcats as $subcat) {
			echo "
						<div class=\"panel panel-default\">
							<div class=\"panel-heading\">
								<h5 class=\"panel-title\">
									<div class=\"checkbox\">
										<input type=\"checkbox\" name=\"subcat" . $subcat["id"] . "\"";
			if (in_array($subcat['id'], $activatedSubcategories)) {echo " checked";}
			echo ">" . $subcat["subcategory"];
			echo "</div>
								</h5>
							</div>
						</div>
<div class=\"container\">
<button type=\"button\" class=\"btn btn-info\" data-toggle=\"collapse\" data-target=\"#collapse" . $category["id"] . $subcategory["id"] . "\">Edit Hours</button>
<div id=\"collapse" . $category["id"] . $subcategory["id"] . "\" class=\"collapse\"> " .
			hoursTable($agency_id, $subcat["id"]) . "
</div>
</div>
						";
		}
		echo "
					</div>
				</div>
			</div>
		</div>";
	}
	echo "
	</div>";
}

echo "<button type='submit' class='btn btn-primary'>Save and Continue</button></form>";

echo $footer;

function hoursTable($agency_id, $subCat = 0) {
	if ($agency_id) {
		$H = new Hours();
		$hours = $H->getHoursForAgency($agency_id, $subCat);
		$counts = [];
		for ($i = 0; $i < 7; $i++) {
			$counts[$i] = 0;
		}

		//find number of rows for each column
		if ($hours) {
			foreach ($hours as $hour) {
				$counts[$hour['dayOfWeek_id'] - 1] += 1;
			}}

		$rowCount = 0;
		if ($counts) {
			foreach ($counts as $c) {
				$rowCount = max($rowCount, $c);
			}}
		if ($agency_id == 0) {
			$rowCount = 2;
		} else {
			$rowCount++;
			$rowCount = min($rowCount, 9);
		}

		for ($i = 0; $i < $rowCount; $i++) {
			for ($j = 0; $j < 7; $j++) {
				$times[$i][$j] = "";
			}
		}

		if ($hours) {
			foreach ($hours as $hour) {
				for ($i = 0; $i < $rowCount; $i++) {
					if ($times[$i][$hour['dayOfWeek_id'] - 1] == "") {
						$times[$i][$hour['dayOfWeek_id'] - 1] = $hour;
						break;
					}
				}
			}
		}

		$D = new Days();
		$days = $D->getAllDays();
		echo "<table class=\"table\">
  <thead>
    <tr>";
		if ($days) {
			foreach ($days as $day) {
				echo "<th>" . $day['longName'] . "</th>";
			}}
		echo "   </tr>
  </thead>
  <tbody>";

		for ($i = 0; $i < $rowCount; $i++) {
			echo "<tr>";
			for ($j = 0; $j < 7; $j++) {
				$td = "<td><input size='6' name='open+$i+$j+subCat' zxcvb ></input>&nbsp;<input size='6' name='close+$i+$j+subCat' qwert ></input></td>";
				$timeItem = $times[$i][$j];
				if ($i == 0 && $subCat == 0 && $j < 5) {
					$td = str_replace("put size", "put required size", $td);
				}
				if ($timeItem == "") {
					$td = str_replace("zxcvb", "placeholder=\"09:30\"", $td);
					$td = str_replace("qwert", "placeholder=\"16:30\"", $td);
				} else {
					$ot = substr($timeItem['openTime'], 0, 5);
					$ct = substr($timeItem['closeTime'], 0, 5);
					$td = str_replace("zxcvb", "value=\"" . $ot . "\"", $td);
					$td = str_replace("qwert", "value=\"" . $ct . "\"", $td);
				}
				echo $td;
			}
			echo "</tr>";
		}

		echo "</tbody></table>";
	}
}

echo $footer;
?>
