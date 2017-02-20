

<!DOCTYPE html>
<html>

<style type="text/css">
  
</style>

<body>
  
<!--<form action="insert.php" method="post" enctype="multipart/form-data">-->
<pre>Hotel Expense</pre>

<p>
  <label for="hotel_explain_expense">Location of Stay: </label><br>
  <input type="text" name="hotel_explain_expense" id="hotel_explain_expense" style="width:30%">
</p>
<p>
  <label for="hotel_date">Date of Expense: </label><br>
  <input type="date" name="hotel_date" id="hotel_date" style="width:30%">
</p>

<p>
  <label for="hotel_amount">Amount ($):</label><br>
  <input type="number" step="0.01" name="hotel_amount" id="hotel_amount" style="width:30%"> 
</p>
<p>
  <label for="hotel_receipt_upload">Upload a Receipt: </label><br>
  <input type="file" name="hotel_receipt_upload" id="hotel_receipt_upload">
</p>
<!--<input class="btn btn-default" type= "submit" id="submit" value="submit" name="submit" value="">-->
</form>
</body>
</html>
