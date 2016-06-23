<?php
/****************************
Utility Functions
*****************************/

/*
* Trim, addslashes, convert HTML chars, etc., for form input before
* adding input to the database
*
* @param	$data = the form field value
*
* @return 	$data = the prepped form field value
*/
function prepInput($data,$type="") {
        $data = trim($data);
        $data = addslashes($data);
        $data = htmlspecialchars($data);

	//Special field types:
	if($type=="phone") {
		$data=preg_replace("/[^0-9]/","",$data);	//Remove anything but digits
	}
	else if($type=="email") {
		$data=filter_var($data, FILTER_SANITIZE_EMAIL);
	}
	else if($type=="boolean") {
		if($data == "on") $data = 1;
		else $data = 0;
	}
	else if($type=="url") {
		if(substr($data,0,7)!="http://" && substr($data,0,8)!="https://")
		   $data="http://".$data;
	}
        return $data;
}
