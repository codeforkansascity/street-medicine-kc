<?php
require 'variables.php';

//IMPORT POST/GET VARIABLES
if ($_REQUEST) {
	foreach ($_REQUEST as $key => $value) {
		$$key = $value;
	}
}

if ($_FILES) {
	foreach ($_FILES as $key => $value) {
		$$key = $_FILES[$key]['tmp_name'];
	}
}

if (version_compare(phpversion(), '5.6.10', '<')) {
	$db = mysql_connect($dbhost, $dbuser, $dbpass);
	if (!$db) {
		echo "Failed to connect to MySQL: " . mysql_error();
	} elseif (!mysql_select_db($dbname, $db)) {
		echo "Failed to select " . $dbname;
	} else {
		//do nothing
	}
} else {
	$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
}

function GetHeader($kmlfile = "") {
	require 'variables.php';

	$header = '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Homeless KC</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="map.css">
    <script src="https://use.fontawesome.com/8080d19550.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Optional theme -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">-->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossori
gin="anonymous"></script>';
	if ($kmlfile != '') {
		$header .= '<!-- MAP SCRIPTS -->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=' . $GoogleMapsAPIKey . '"></script>
        <script>
        function initialize() {
                var mapOptions = {
                        zoom: 10,
                        center: {lat: 39.0844507, lng: -94.5752503},
                        zoomControl: true,
                        zoomControlOptions: {
                                position: google.maps.ControlPosition.RIGHT_CENTER
                        },
                        mapTypeControl:false,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        scrollwheel:false
                }
                window.map = new google.maps.Map(document.getElementById("map"), mapOptions);
                var kmlLayer = new google.maps.KmlLayer({
                        url: "http://homelesskc.gazelleincorporated.com/' . $kmlfile . '",
                        suppressInfoWindows: true,
                        preserveViewport: false
                });
                kmlLayer.setMap(map);
                google.maps.event.addListener(kmlLayer, "click", function(kmlEvent) {
                        showInContentWindow(kmlEvent.latLng, kmlEvent.featureData.description);
                });
                window.infowindow = new google.maps.InfoWindow({ maxwidth:200 });
                function showInContentWindow(latlng,text) {
                        var content = "<div class=\"google-map-listings\" style=\"max-width:200px !important;\">" + text +"</div>";
                        infowindow.setPosition(latlng);
                        infowindow.setContent(content);
                        infowindow.open(map);
                }
		function geoFindMe() {
  			function success(position) {
    				var latitude  = position.coords.latitude;
    				var longitude = position.coords.longitude;
				var myLatLng = {lat: latitude, lng: longitude};
 				var marker = new google.maps.Marker({
    					position: myLatLng,
    					map: map,
    					icon: {
      						path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
						scale:3,
						strokeColor: "blue",
						fillColor: "blue",
						fillOpacity: 0.5
    					},
					animation: google.maps.Animation.DROP,
    					title: "YOU ARE HERE"
  				});
  			};
  			function error() {
    				//output.innerHTML = "Unable to retrieve your location";
  			};
			if (navigator.geolocation) {
  				navigator.geolocation.getCurrentPosition(success, error);
			}
		}
		geoFindMe();
        }
        google.maps.event.addDomListener(window, "load", initialize);
        </script>
<!-- END MAP SCRIPTS -->';
	}
	$header .= '</head>
  <body role="document">
    <nav></nav>
    <div class="container-fluid" role="main">';
	return $header;
}
function GetSearchResults($catids = array()) {
	require 'controller.php';
	$sql = "SELECT DISTINCT t1.* FROM agency AS t1, agency_has_subcategories AS t2, subCategory AS t3 WHERE t1.id=t2.agency_id AND t2.subcategories_id=t3.id AND (t1.latitude!=0 OR t1.longitude!=0) AND (";
	$catssearched = 0;
	for ($i = 0; $i < count($catids); $i++) {
		if ($catids[$i] > 0) {
			$sql .= "t3.category_id='$catids[$i]' OR ";
			$catssearched = 1;
		}
	}
	if ($catssearched == 0) {
		$sql = substr($sql, 0, strlen($sql) - 6);
	} else {
		$sql = substr($sql, 0, strlen($sql) - 4) . ")";
	}

	$kml = '<?xml version="1.0" encoding="UTF-8"?>
        <kml xmlns="http://www.opengis.net/kml/2.2">
        <Document>';
	$sql2 = "SELECT * FROM category";

	$rows2 = setRows($sql2);
	foreach ($rows2 as $row2) {
		$kml .= '<Style id="category' . $row2[id] . '">
                <IconStyle>
                        <Icon>
                        <href>' . GetCategoryPin($row2[id]) . '</href>
                        </Icon>
                </IconStyle>
        </Style>';
	}
	$list = "";

	$a = new Agencies();

	$rows = setRows($sql);
	foreach ($rows as $row) {
		$row = $a->fetchAgency($row[id]);
		$info = $row['cdata']; //GetCDATADescription($row[id]);
		$kml .= "<Placemark>
                <name></name>
                <description><![CDATA[<div class=\"map-listings-text\">" . $info . "</div>]]></description>
		<styleUrl>#category" . GetMainCategory($row[id], $catids) . "</styleUrl>
                <Point>
                        <coordinates>$row[longitude],$row[latitude],0.000000</coordinates>
                </Point>
        </Placemark>";
		$list .= "<div class=\"list-element\">" . $info . "</div>";
	}
	$kml .= "</Document></kml>";
	$filename = time() . "-" . preg_replace("/[^0-9]/", "", $_SERVER['SERVER_ADDR']) . ".kml";
	$filename = "kml/" . $filename;
	if (!$open = fopen($filename, "w")) {echo "Could not open $filename";return FALSE;}
	if (!fwrite($open, $kml)) {return FALSE;}
	fclose($open);
	return $filename . "<data>" . $list;
}
function GetCategoryPin($categid) {
	$sql = "SELECT pinfile FROM category WHERE id='$categid'";
	if (version_compare(phpversion(), '5.6.10', '<')) {
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
	} else {
		$result = mysqli_query($dq, $sql);
		$row = mysqli_fetch_array($result);
	}
	if ($row) {
		return "http://homelesskc.gazelleincorporated.com/images/" . $row[0];
	} else {
		return FALSE;
	}

}
function GetMainCategory($agencyid, $usecatids = array()) {
	$sql = "SELECT t1.id,t1.category FROM category AS t1, subCategory AS t2, agency_has_subcategories AS t3 WHERE t1.id=t2.category_id AND t2.id=t3.subcategories_id AND t3.agency_id='$agencyid'";
	if (count($usecatids) > 0) {
		$sqlpiece = "";
		for ($i = 0; $i < count($usecatids); $i++) {
			$sqlpiece .= "t1.id='$usecatids[$i]' OR ";
		}
		if ($sqlpiece != '') {
			$sql .= " AND (" . substr($sqlpiece, 0, strlen($sqlpiece) - 4) . ")";
		}
	}
	$sql .= " LIMIT 1";
	if (version_compare(phpversion(), '5.6.10', '<')) {
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
	} else {
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($result);
	}
	if ($row) {
		return $row[id];
	} else {
		return 0;
	}

}

function setRows($sql) {
	$rows = array();
	if (version_compare(phpversion(), '5.6.10', '<')) {
		$result = mysql_query($sql);
		if(mysql_error())
		{
			echo "<p>ERROR WITH QUERYL $sql<br>ERROR READS:".mysql_error()."</p>"; return FALSE;
		}
		while ($row = mysql_fetch_array($result)) {
			$rows[]=$row;
		}
	} else {
		$result = mysqli_query($db, $sql);
		while ($row = mysqli_fetch_array($result)) {
			$rows = array_push($rows, $row);
		}
	}
	return $rows;
}
