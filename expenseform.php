

<?php
  session_start();
  $id = intval($_REQUEST['id']);
  //include("Database/config.php");
  //$conn = getConnection();
?>

<script>
function DoCheckUncheckDisplay(element, sectionId)
{
    var section = document.getElementById(sectionId);
    if( element.checked == true )
    {
      
        $(section).css("display", "block");
        //document.getElementById(dunchecked).style.display = "none";
    }
    else
    {
        $(section).css("display", "none");
    }
}
</script>

<!DOCTYPE html>
<html>

<body>
<form action="Forms/submitform.php" method="POST" enctype="multipart/form-data" > 

  <div id="General">
   <?php include("general_information_form.php")?>
  </div>

What type of expense?<br>

  <input type="checkbox" name="Air" id="Air" onchange="DoCheckUncheckDisplay(this,'air_expense')"  value="Air">Air Travel<br>
  <input type="checkbox" name="Land" id="Land"onchange="DoCheckUncheckDisplay(this,'land_expense')"  value="Land">Land Travel<br>
  <input type="checkbox" name="Hotel" id="Hotel" onchange="DoCheckUncheckDisplay(this,'hotel_expense')"  value="Hotel">Hotel<br>
  <input type="checkbox" name="Food" id="Food" onchange="DoCheckUncheckDisplay(this,'food_expense')" value="Food">Food<br>
  <input type="checkbox" name="Other" id="Other" onchange="DoCheckUncheckDisplay(this,'other_expense')" value="Other">Other
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
<div>
  <label for="air_receipt_upload">Upload a Receipt: </label><br>
  <input type="file" name="air_receipt_upload" id="air_receipt_upload">
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
        var form_id = "<?php echo $id ?>";
    
    
    
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
                $(expenseTypeField).trigger("change");
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
