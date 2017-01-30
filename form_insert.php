<?php
    $db = mysqli_connect("localhost", "root", "", "expense_reimbursement");
    
    
   // $user = mysqli_real_escape_string($db, $_POST['user']);
    //$target_dir = "upload/";
    $file_upload = $_FILES["file_upload"]["name"];
    $image = addslashes(file_get_contents($_FILES["file_upload"]["name"]));
    
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