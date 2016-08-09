<?php
//DATABASE PARAMS
$dbname = "homeless_kc";
$dbuser = "homeless_kc";
$dbpass = "kiran-0605";
$dbhost = "localhost";

$GoogleMapsAPIKey = "AIzaSyD4msj-ty44VVh0dNDPPocz0wAv_XIRjiE";

//STATES
// $state_abbrevs=array("KS","MO");
// $state_fulls=array("Kansas","Missouri");

// $pattern10digits = "/[0-9]{10}/";

//Admin header:
$header = '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Homeless KC</title>
        <script type="text/JavaScript" src="/admin/js/sha512.js"></script>
        <script type="text/JavaScript" src="/admin/js/forms.js"></script>
  <!-- minified jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
 </head>
  <body role="document">
	<nav class="navbar navbar-default">
  		<div class="container-fluid">
    		<div class="navbar-header">
     			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        		<span class="sr-only">Toggle navigation</span>
        		<span class="icon-bar"></span>
        		<span class="icon-bar"></span>
        		<span class="icon-bar"></span>
      		</button>
      		<a class="navbar-brand" href="#">
        	<img alt="Homeless KC" src="/images/SMKC.jpg" style="height:25px;">
      		</a>
    		</div>
    		<!-- Collect the nav links, forms, and other content for toggling -->
    		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      		<ul class="nav navbar-nav">
            <li><a href="/admin/front.php">Main Menu</a></li>
	    <li><a href="/admin/register.php">Add Users</a></li>
            <li><a href="/admin/includes/logout.php">Logout</a></li>
          </ul>
		</div>
	</nav>

    <div class="container theme-showcase" role="main">';

$footer = '    </div><!--/main container-->
  </body>
</html>';
?>
