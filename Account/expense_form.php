

<?php
  session_start();
  include("../Database/config.php");
  $conn = getConnection();
?>

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
  
<form action="form_insert.php" method="post" enctype="multipart/form-data">
<p>
  <label for="expense_id">Type of Expense: </label>
  <input type="text" name="expense_id" id="expense_id">
</p>
<p>
  <label for="explain_expense">Describe: </label>
  <input type="text" name="explain_expense" id="explain_expense">
</p>
<p>
  <label for="date">Date of Expense: </label>
  <input type="date" name="date" id="date">
</p>
<p>
  <label for="file_upload">Upload a Receipt: </label>
  <input type="file" name="file_upload" id="file_upload">
</p>
<p>
  <label for="number">Amount ($):</label>
  <input type="number" step="0.01" name="number" id="number">
</p>
<input class="btn btn-default" type= "submit" id="submit" value="submit" name="submit" value="">
</form>
</body>
</html>
