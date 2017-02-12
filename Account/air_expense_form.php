
<!DOCTYPE html>
<html>
<head>
  <link href="/css/style.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="/css/bootstrap.min.js"></script>
  <title>Pulldown</title>
</head>
<style type="text/css">
  
</style>

<body>
  
<!--<form action="insert.php" method="post" enctype="multipart/form-data">-->
<pre>Air Travel</pre>

<p>
  <label for="air_explain_expense">Airline: </label>
  <input type="text" name="air_explain_expense" id="air_explain_expense">
</p>
<p>
  <label for="air_date">Date of Flight: </label>
  <input type="date" name="air_date" id="air_date">
</p>
<p>
  <label for="air_amount">Amount ($):</label>
  <input type="number" step="0.01" name="air_amount" id="air_amount">
</p>
<p>
  <label for="air_receipt_upload">Upload a Receipt: </label>
  <input type="file" name="air_receipt_upload" id="air_receipt_upload">
</p>
<!--<input class="btn btn-default" type= "submit" id="submit" value="submit" name="submit" value="">
</form>-->
</body>
</html>
