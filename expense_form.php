

<?php
  session_start();
  //include("Database/config.php");
  //$conn = getConnection();
?>

<script>
function DoCheckUncheckDisplay(d,dchecked,dunchecked)
{
   if( d.checked == true )
   {
      document.getElementById(dchecked).style.display = "block";
      document.getElementById(dunchecked).style.display = "none";
   }
   else
   {
      document.getElementById(dchecked).style.display = "none";
      document.getElementById(dunchecked).style.display = "block";
   }
}
</script>

<!DOCTYPE html>
<html>
<head>
  <!--<link href="/css/style.css" rel="stylesheet">-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script src="Scripts/bootstrap.min.js"></script>
  <title>Pulldown</title>
</head>
<style type="text/css">
  
</style>

<body>
<form action="form_insert.php" method="POST" enctype="multipart/form-data" > 
What type of expense?<br>

  <input type="checkbox" onclick="DoCheckUncheckDisplay(this, 'air_expense', '')"  value="Air">Air Travel<br>
  <input type="checkbox" onclick="DoCheckUncheckDisplay(this, 'land_expense', '')"  value="Land">Land Travel<br>
  <input type="checkbox" onclick="DoCheckUncheckDisplay(this, 'hotel_expense', '')"  value="Hotel">Hotel<br>
  <input type="checkbox" onclick="DoCheckUncheckDisplay(this, 'food_expense', '')" value="Food">Food<br>
  <input type="checkbox" onclick="DoCheckUncheckDisplay(this, 'other_expense', '')" value="Other">Other
<div>
<div id="air_expense", style="display:none">
 <?php include("air_expense_form.php")?>
</div>

<div id="land_expense", style="display:none">
  <?php include("land_expense_form.php")?>
</div>

<div id="hotel_expense", style="display:none">
  <?php include("hotel_expense_form.php")?>
</div>

<div id="food_expense", style="display:none">
  <?php include("food_expense_form.php")?>
</div>

<div id="other_expense", style="display:none">
  <?php include("other_expense_form.php")?>
</div>

<input class="btn btn-default" type= "submit" id="submit" value="submit" name="submit" value="">
</div>
</form>
</body>
</html>