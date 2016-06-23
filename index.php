<?php
require 'functions.php';
require 'controller.php';

//GET SEARCH PARAMS
   $catids=array(); $c=0;
   foreach($_POST as $key => $value)	//Get Categories Checked
   {
      if(preg_match("/catid/",$key) && $value=="x")	//Category Checked
      {
	 $catids[$c]=preg_replace("/[^0-9]/","",$key); 	//Get Category ID
	 $c++; 
      }
   }
   //Now $catids is an array of the selected categories
   $results=explode("<data>",GetSearchResults($catids));
   $kmlfile=$results[0]; 
   $listhtml=$results[1];

echo GetHeader($kmlfile);

//GEO CODE AGENCIES
$sql="SELECT * FROM Agency WHERE latitude=0 AND address1!=''";
$result=mysql_query($sql);
$A = new Agencies();
while($row=mysql_fetch_array($result))
{
   $temp=explode(",",$A->getCoordinates($row[id]));
   $sql2="UPDATE Agency SET latitude='$temp[0]',longitude='$temp[1]' WHERE id='$row[id]'";
   $result2=mysql_query($sql2);
}

?>
<div class="row filter-wrap">
<form method="post" action="">
<div id="main-filter">
<span id="ineed"><b>I NEED:</b> </span>
<!-- MAIN CATEGORIES -->
<div class="btn-group" data-toggle="buttons" id="category-options">
<?php
$C = new Categories();
$cats = $C->getAllCategories();
foreach($cats as $cat)
{
   $checkboxVar = "catid".$cat[id]; 
   $labelVar = "label".$cat[id];
   //if(!$_POST) $$checkboxVar="x";	//BY DEFAULT, CHECK ALL
   echo "<label class=\"btn btn-default ".$cat[buttonclass];
   if($$checkboxVar=='x') echo " active";
   echo "\" id=\"$labelVar\"><input class=\"category-btn\" type=\"checkbox\" value=\"x\" data-catid=\"".$cat[id]."\" id=\"$checkboxVar\" name=\"$checkboxVar\" autocomplete=\"off\"";
   if($$checkboxVar=='x') echo " checked";
   echo "> ".$cat[category]."</label>";
}
?>
</div><!--/category-options-->
<script>
  $('.category-btn').on('click', function () {
      var catid = $(this).getAttribute('data-catid');
      var labelid = "label"+ catid;
      $('#'+ labelid).toggleClass("active");
      if($(this).checked) $(this).checked=false;
      else $(this).checked=true;
  })
</script>
<input class="btn btn-primary" type="submit" value="FIND" id="find">
</div>
</form>
</div><!--/row-->
<div class="map-wrap">
<div id="map">
<p>Loading...</p>
</div><!--/map-->
</div><!--/map-wrap-->

<div class="list-wrap" id="list">
<input class="btn btn-link" type="button" value="LIST" id="list-toggle">
<?php echo $listhtml; ?>
</div><!--/list-toggle-wrap-->
<script>
$("#list-toggle").click(function () {
  $("#list").toggleClass("active");
});
</script>

<!----END CUSTOM CONTENT--->
<?php
echo $footer;
?>
