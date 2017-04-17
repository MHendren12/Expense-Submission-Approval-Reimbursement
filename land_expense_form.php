
<!DOCTYPE html>
<html>

<style type="text/css">
  
</style>

<body>
  
<!--<form action="insert.php" method="post" enctype="multipart/form-data">-->
<pre>Land Travel</pre>
<p>
  <label for="land_explain_expense">Describe your Travel: </label><br>
  <textarea rows="5" cols="50" name="land_explain_expense" id="land_explain_expense" style="width:30%"></textarea>
</p>
<p>
  <label for="land_date">Date of Expense: </label><br>
  <input type="date" name="land_date" id="land_date" style="width:30%">
</p>
<p>
  <label for="distance_traveled">Distance (miles): </label><br>
  <input type="number" name="distance_traveled" id="distance_traveled" style="width:30%" onchange="getMileageExpense(this)">
</p>
<p>
  <label for="totalExpense">Total Expense: </label><br>
  <input type="text" name="totalLandExpense" id="totalLandExpense" style="width:30%">
</p>

<!--<input class="btn btn-default" type= "submit" id="submit" value="submit" name="submit" value="">-->
</form>
</body>
<script>
  function getMileageExpense(mileage)
  {
    
    distance = $(mileage).val();
    var expense = parseFloat(distance * 0.54).toFixed(2);
    var mileageExpense = $(mileage).parents(".popover-content").find("#totalLandExpense");
    $(mileageExpense).val(expense);

  }
</script>
</html>
