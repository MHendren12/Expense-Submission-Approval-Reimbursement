
<!DOCTYPE html>
<html>

<style type="text/css">
  
</style>

<body>
  
<!--<form action="insert.php" method="post" enctype="multipart/form-data">-->
<pre>Food Expense</pre>
<p>
  <label for="food_explain_expense">Describe: </label>
  <input type="text" name="food_explain_expense" id="food_explain_expense">
</p>
<p>
  <label for="food_date">Date of Expense: </label>
  <input type="date" name="food_date" id="food_date">
</p>

<p>
  <label for="food_amount">Amount ($):</label>
  <input type="number" step="0.01" name="food_amount" id="food_amount">
</p>
<p>
  <label for="food_receipt_upload">Upload a Receipt: </label>
  <input type="file" name="food_receipt_upload" id="food_receipt_upload">
</p>
<!--<input class="btn btn-default" type= "submit" id="submit" value="submit" name="submit" value="">-->
</form>
</body>
</html>
