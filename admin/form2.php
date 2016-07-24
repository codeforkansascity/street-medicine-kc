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
	<input type='hidden' name='agency_id' value='$agency_id'>
	<div class='form-group'>
	<br><br>
	<label for='agency'><h4>*Agency Name:</h4></label>
	<input type='text' class='form-control' id='agency' name='agency' placeholder=\"Agency Name\" value=\"$agency[name]\" required>
	</div>
	<div class='form-group'>
	<label for='description'><h4>Description:</h4></label>
	<textarea rows='8' class='form-control' id='description' name='description' wrap='soft' placeholder='Description'>" . $agency['description'] . "</textarea>
	</div><div class='form-group'><p><input type='checkbox' name='free'";
if ($agency['free'] == 1) {
	echo " checked";
}
echo "
	>&nbsp;<b>All <u>FREE</u> services</b></p></div>
 	<div class='form-group'>
		<p><h4>Website:</h4> <input type='url' name='website' class='form-control' value=\"$agency[website]\" placeholder=\"http://\" size='60'></p>
	</div>
     <h4>*Email:</h4><input type='email' class='form-control' id='email' name='email' value=\"$agency[email]\" placeholder=\"agency@example.com\" required>
	<div class='form-group'>
		<p><h4>*Address Line 1</h4><input type='text' class='form-control' id='address1' name='address1' required value=\"$agency[address1]\" placeholder=\"Address Line 1\"></p>
		<p><h4>Address Line 2</h4><input type='text' class='form-control' id='address2' name='address2' value=\"$agency[address2]\" placeholder=\"Address Line 2\"></p>
		<p><h4>*City *State *Zip</h4>&nbsp;<input type='text' size='20' id='city' name='city' required value=\"$agency[city]\" placeholder=\"City\">,&nbsp;
		<span class='radio-inline'><label><input type='radio' name='state' id='mo' value='MO'";
if ($agency['state'] == "MO") {
	echo " checked";
}

echo ">Missouri</label></span><span class=\"radio-inline\"><label><input type=\"radio\" name=\"state\" id=\"ks\" value=\"KS\"";
if ($agency['state'] == "KS") {
	echo " checked";
}

echo "
			>Kansas</label></span>&nbsp;&nbsp;&nbsp;<input type='text' minlength='5' maxlength='10' size='11' id='zip' name='zip' required value=\"$agency[zip]\" placeholder=\"Zip\"></p>
	</div>
	<h4>Contacts:</h4>
	";
doContacts($agency);

echo "<h4>*Hours:</h4>";
doHoursTable($agency_id);

/* THE CATEGORIES & SUBCATEGORIES */
doSubcategories($A, $agency_id);
echo "<button type='submit' class='btn btn-primary'>Save and Continue</button></form>";

echo $footer;
// ==========
function doHoursTable($agency_id, $category_id = 0, $subcategory_id = 0) {
	if ($agency_id) {
		$H = new Hours();
		$hours = $H->getHoursForAgency($agency_id, $subcategory_id);
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
		echo "
				<table>
  					<thead>
    					<tr>";
		if ($days) {
			foreach ($days as $day) {
				echo "<th>" . $day['longName'] . "</th>";
			}
		}
		echo "
						</tr>
  					</thead>
  					<tbody>";

		for ($i = 0; $i < $rowCount; $i++) {
			echo "
						<tr>";
			for ($j = 0; $j < 7; $j++) {
				$td = "
							<td>
								<input size='5' name='open+$i+$j+$subcategory_id'  zxcvb ></input>
								<input size='5' name='close+$i+$j+$subcategory_id' qwert ></input>
								&nbsp;&nbsp;
							</td>";
				$timeItem = $times[$i][$j];
				if ($i == 0 && $subcategory_id == 0 && $j < 5) {
					$td = str_replace(" size=", " required size=", $td);
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
			echo "
						</tr>";
		}

		echo "
					</tbody>
				</table>";
	}
}

function doContacts($agency) {
	$K = new Contacts();
	$cTypes = $K->getAllContactTypes();
	$pTypes = $K->getAllPhoneTypes();
	$contacts = $K->getContactsForAgency($agency["id"]);
	$contacts[] = null;
	if ($contacts) {
		foreach ($contacts as $contact) {
			$id = $contact['id'];
			if (!$id) {
				$id = 0;
			}
			// var_dump($id);
			echo "
				<div class='form-group'>
					<input type=\"text\" size=\"5\" value=\"$contact[title]\" placeholder='Title' id=\"title\"" . $id . "\" name=\"title" . $id . "\"<\input>
					<input type=\"text\" size=\"11\" value=\"$contact[givenName]\" placeholder='First' id=\"given" . $id . "\" name=\"given" . $id . "\"<\input>
					<input type=\"text\" size=\"15\" value=\"$contact[familyName]\" placeholder='Last' id=\"family" . $id . "\" name=\"family" . $id . "\"<\input>
					<input type=\"text\" size=\"5\" value=\"$contact[suffix]\" placeholder='suffix' id=\"suffix" . $id . "\" name=\"suffix" . $id . "\"<\input>
					<input type=\"text\" size=\"12\" value=\"$contact[credentials]\" placeholder='credentials' id=\"credentials" . $id . "\" name=\"credentials" . $id . "\"<\input>
					<input type=\"text\" size=\"11\" minlength=10 maxlength=10 value=\"$contact[phone]\" placeholder='phone' id=\"phone" . $id . "\" name=\"phone" . $id . "\"<\input>
					<input type=\"text\" size=\"38\" value=\"$contact[email]\" placeholder=\"email\" id=\"email" . $id . "\" name=\"email" . $id . "\" <\input>
			";
			doTypes($cTypes, "contactType", $id, $contact['contactType_id']);
			doTypes($pTypes, "phoneType", $id, $contact['phoneType_id']);
			echo "
				</div>";
		}
	}
}

function doTypes($typeArray, $typeName, $id, $tid = 0) {
	if (!$id) {
		$id = 0;
	}
	$n = $typeName . $id;
	echo "
	<select name=\"" . $n . "\">";
	foreach ($typeArray as $typeItem) {
		$type = $typeItem[type];
		$type_id = $typeItem[id];
		echo "<option value=$type_id";
		if ($tid == $type_id) {
			echo " selected";
		}
		echo ">$type</option>";
	}

	echo "
	</select>";
}

function doSubcategories($A, $agency_id) {
//First, get the subCategories the Agency has activated
	$activatedSubcategories = array();
	if ($agency_id > 0) {
		$subCats = $A->fetchActivatedAgencySubCategories($agency_id);
	}
	if ($subCats) {
		foreach ($subCats as $subCat) {
			$activatedSubcategories[] = $subCat['id'];
		}
	}

//Next, display an accordion of the categories & subcategories, with activated subcategories checked
	$C = new Categories();
	$cats = $C->getAllCategories();
	if ($cats) {
		echo "
	<h4>Services:</h4>
	<div class=\"panel-group\" id=\"accordion\">";
		foreach ($cats as $category) {
			echo "
			<div class=\"panel panel-default\">
			<div class=\"panel-heading\">
				<h5 class=\"panel-title\">
					<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse" . $category["id"] . "\">" . $category["category"] . "</a>
				</h5>
			</div>
			<div id=\"collapse" . $category["id"] . "\" class=\"panel-collapse collapse \">
				<div class=\"panel-body\">
					<div class=\"panel-group\" id=\"accordion" . $category["id"] . "\"  data-parent=\"#accordion" . $category["id"] . "\">";
//Show Subcategories of this Category:
			$subcats = $C->getSubCategories($category['id']);
			foreach ($subcats as $subcat) {
				echo "
						<div class=\"panel panel-default\">
							<div class=\"panel-heading\">
								<div class=\"panel-title\">
									<div class=\"checkbox\">
										<input type=\"checkbox\" name=\"subcat" . $subcat["id"] . "\"";
				if (in_array($subcat['id'], $activatedSubcategories)) {echo " checked";}
				echo ">";
				if (strlen($category["pinfile"]) > 4) {
					echo "
											<a
												data-toggle=\"collapse\"
												data-parent=\"#accordion" . $category["id"] . "\"
												href=\"#collapse" . $category["id"] . $subcat["id"] . "\">" . $subcat["subcategory"] . "
											</a>";
				} else {
					echo $subcat["subcategory"];
				}
				echo "
									</div>
								</div>
							</div>";
				if (strlen($category["pinfile"]) > 4) {

					echo "
							<div class='panel-collapse collapse' id=\"collapse" . $category["id"] . $subcat["id"] . "\" >
  								<div class='panel-body'>";
					doHoursTable($agency_id, $category["id"], $subcat["id"]);
					echo "
								</div>
							</div>";
				}
				echo "
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
	</div>
	";
	}
}
?>

