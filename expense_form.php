

<?php
  include_once "Database/config.php";
?>

<?php
    $db = mysqli_connect("localhost", "root", "", "expense_reimbursement");
    
    
   // $user = mysqli_real_escape_string($db, $_POST['user']);
    //$target_dir = "upload/";
    $file_upload = $_FILES["file_upload"]["name"];
    //$image = addslashes(file_get_contents($_FILES["file_upload"]["name"]));
    
    $explain_expense = mysqli_real_escape_string($db, $_POST['explain_expense']);
    $expense_id = mysqli_real_escape_string($db, $_POST['expense_id']);
    $number = mysqli_real_escape_string($db, $_POST['number']);
    $rawdata = mysqli_real_escape_string($db, $_POST['date']);
    $date = date('m-d-Y', strtotime($rawdate));
    
    $sql = "INSERT INTO reports(expense_id, number, date, explain_expense, file_upload) 
            VALUES ('$expense_id', '$number', '$date', '$explain_expense', '$file_upload')";
    if(mysqli_query($db, $sql)){
        echo "Records reported";
    } else{
        echo "Error";
    }
    echo "<br>";
    echo $expense_id;
    echo "<br>";
    echo $number;
    echo "<br>";
    echo $date;
    echo "<br>";
    echo $explain_expense;
    echo "<br>";
    echo $file_upload;
?>

<!DOCTYPE html>
<html>
<head>
  <!--
  <link href="Styles/css/style.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="Scripts/bootstrap.min.js"></script>
  <title>Pulldown</title>
  -->
</head>
<style type="text/css">
  
</style>

<body>
  
<form action="insert.php" method="post" enctype="multipart/form-data">
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
