

<?php
  session_start();
  $id = intval($_REQUEST['id']);
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
  <link href="/Styles/css/customStyles.css" rel="stylesheet">
  <link href="/Styles/css/bootstrap.css" rel="stylesheet">
</head>
<style type="text/css">
  
</style>

<body>
<form action="Forms/submitform.php" method="POST" enctype="multipart/form-data" > 
What type of expense?<br>

  <input type="checkbox" name="Air" id="Air" onclick="DoCheckUncheckDisplay(this, 'air_expense', '')"  value="Air">Air Travel<br>
  <input type="checkbox" name="Land" id="Land"onclick="DoCheckUncheckDisplay(this, 'land_expense', '')"  value="Land">Land Travel<br>
  <input type="checkbox" name="Hotel" id="Hotel" onclick="DoCheckUncheckDisplay(this, 'hotel_expense', '')"  value="Hotel">Hotel<br>
  <input type="checkbox" name="Food" id="Food" onclick="DoCheckUncheckDisplay(this, 'food_expense', '')" value="Food">Food<br>
  <input type="checkbox" name="Other" id="Other" onclick="DoCheckUncheckDisplay(this, 'other_expense', '')" value="Other">Other
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
<br>
<input class="btn btn-default" type= "submit" id="submit" value="submit" name="submit" value="">
</div>
</form>
</body>
<script>
    $(document).ready(function()
    {
        debugger;
        var form_id = " <?php echo $id ?> ";
    
    
    
        $.ajax({
			url: 'WebService/forminfo.php',
			type: 'POST',
			data: { "val": "getExpenseTypes","formid":form_id },

		})
		.done(function(data){
		    var expenseTypes = JSON.parse(data);
            for (var i = 0; i<= expenseTypes.length-1; i++)
            {
                var fieldId = expenseTypes[i].fieldId;
                var fieldValue = expenseTypes[i].fieldValue;
                var checked = fieldValue == "checked" ? true : false;
                var expenseTypeField = document.getElementById(fieldId);
                $(expenseTypeField).attr("checked",checked);
                $(expenseTypeField).trigger("onclick");
            }
           
		})
		.fail(function(){
			
		});
		
		$.ajax({
			url: 'WebService/forminfo.php',
			type: 'POST',
			data: { "val": "getExpenseFields","formid":form_id },

		})
		.done(function(data){
		    var expenseFields = JSON.parse(data);
            for (var i = 0; i<= expenseFields.length-1; i++)
            {
                debugger;
                var fieldId = expenseFields[i].fieldId;
                var fieldValue = expenseFields[i].fieldValue;
                var expenseTypeField = document.getElementById(fieldId);
                if (fieldId.indexOf("date")> -1)
                {

                }
                $(expenseTypeField).val(fieldValue);

                
            }
           
		})
		.fail(function(){
			
		});
    });

     
</script>
</html>
