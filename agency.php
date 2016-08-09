<?php
require 'functions.php';
require 'controller.php';

$agencyid=$_REQUEST['agencyid'];
if(!$agencyid) header("Location: index.php");

$A = new Agencies();

$agency = $A->fetchAgency($agencyid);

echo GetHeader();
?>
<h1><?php echo $agency['name']; ?></h1>
<p><?php echo $agency['address1']; ?>
<?php if($agency['address2']!=''): ?><br /><?php echo $agency['address2']; endif; ?><br />
<?php echo $agency['city'].", ".$agency['state']." ".$agency['zip']; ?><br />
<a target="_blank" href="https://maps.google.com/maps?dirflg=r&saddr=My+Location&daddr=<?php echo urlencode("$agency[address1], $agency[city] $agency[state], $agency[zipcode]"); ?>"><b>GET DIRECTIONS</b></a></p>
<p><a href="<?php echo $agency[website]; ?>" target="_blank">Website</a></p>
<?php if($agency['free']==1): ?><p><b>All <u>FREE</u> Services.</b></p><?php endif; ?>
<p><?php echo $agency['description']; ?></p>
<p><b>Main E-mail:</b> <a href="mailto:<?php echo $agency['email']; ?>"><?php echo $agency['email']; ?></a></p>
<?php
$K = new Contacts();
$contacts = $K->getContactsForAgency($agencyid);
if ($contacts) {
?>
<p><b>Contacts:</b></p><ul>
<?php
foreach ($contacts as $contact) {
	$contactType = $K->getContactType($contact['contactType_id']);	
	$phoneType = $K->getPhoneType($contact['phoneType_id']);
	echo "<li><b>$contactType:</b> ".trim("$contact[title] $contact[givenName] $contact[familyName] $contact[suffix]");
        if($contact['credentials']!='') echo ", $contact[credentials]";
      	if($contact['phone']!='') echo " - ".$A->formatPhone($contact['phone'])." ($phoneType)";
	if($contact['email']!='') echo " - <a href=\"mailto:$contact[email]\">$contact[email]</a>";
	echo "</li>";
}
?>
</ul>
<?php
} //end if contacts

$H = new Hours();
$D = new Days();
$C = new Categories();
$hours = $H->getHoursForAgency($agencyid,0);
if($hours) {
	$description="<p><b>Hours:</b></p><ul>";
        $curday="";
        foreach($hours as $hour) {
        	$day = $D->getDay($hour['dayOfWeek_id']);
                if($day['longName']!=$curday) { //Start new line for each day
                	if($curday!='')
                	{
                		$description=substr($description,0,strlen($description)-2);
                        	if(date("l")==$curday)
                        	{
                        		if($H->isAgencyOpen($agencyid))     //OPEN NOW
                                		$description.=" (Open NOW)";
                                	else
                                        	$description.=" (CLOSED)";
                                	$description.="</span>";
                        	}
                        	$description.="</li>"; //End the line for this day
                        	$specialhours = $H->getSpecialHoursForAgency($agencyid,$hour['dayOfWeek_id']);
                        	if($specialhours) {
                        		$description.="(";
                                	foreach($specialhours as $shour) {
                                		$subcat = $C->getSubCategory($shour['subcategory_id']);
                                        	$description.=$subcat['subcategory'].": ".$H->formatHours($shour['openTime'])."-".$H->formatHours($shour['closeTime']).", ";
                                	}
                                	$description=substr($description,0,strlen($description)-2).")<br />";
                        	}
            		}
                	$curday=$day['longName'];
			$description.="<li>";
                	if(date("l")==$curday) $description.="<span style=\"background-color:yellow;\">";
                	$description.=$day['shortName'].": ";
       		}
        	//List Today's Hours:
        	$description .= $H->formatHours($hour['openTime'])."-".$H->formatHours($hour['closeTime']).", ";
        }
        $description=substr($description,0,strlen($description)-2);
        if(date("l")==$curday)
        {
        	if($H->isAgencyOpen($agency['id']))     //OPEN NOW
                	$description.=" (Open NOW)";
                else
                        $description.=" (CLOSED)";
                $description.="</span>";
        }
      	$description.="</ul>";
	echo $description;
} //end if Hours

//CATEGORIES
$cats = $A->fetchActivatedAgencyCategories($agencyid,"category","Exclusive");
if($cats) {
	$description="<p><b>Services:</b></p><p>";
        foreach($cats as $cat) {
        	$subcats = $A->fetchActivatedAgencySubCategories($agency['id'], $cat['id']);
        	if($subcats) {
        		$description.="<span class=\"".$cat['buttonclass']."\">".$cat['category']."</span> - ";              
                	foreach($subcats as $subcat) {
                		$description.=$subcat['subcategory'].", ";
                	}
                	$description=substr($description,0,strlen($description)-2)."<br />";
        	}
	}
	$description.="</p>";
	echo $description;
} //end if Categories

//Target Demo, Languages == categories without pinfile; pull them similarly to categories (above)
$cats = $A->fetchActivatedAgencyCategories($agencyid,"category",FALSE);
if($cats) {
        foreach($cats as $cat) {
                $subcats = $A->fetchActivatedAgencySubCategories($agencyid, $cat['id']);
                if($subcats) {
                        $description="<p><b>".$cat['category']."</b> - ";
                        foreach($subcats as $subcat) {
                                $description.=$subcat['subcategory'].", ";
                        }
                        $description=substr($description,0,strlen($description)-2)."</p>";
			echo $description;
                }
        }
} //end if cats

echo $footer;
?>
