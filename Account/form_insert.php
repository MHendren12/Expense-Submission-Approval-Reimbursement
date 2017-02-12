<?php
    $db = mysqli_connect("localhost", "root", "", "expense_reimbursement");
    
    
    $file_upload = $_FILES["file_upload"]["name"];
    //$image = addslashes(file_get_contents($_FILES["file_upload"]["name"]));
    
    //$num_mile = $_GET['distance_traveled'];
    //$mile_to_money = .52 + 'distance_traveled';
    
    $air_explain_expense = mysqli_real_escape_string($db, $_POST['air_explain_expense']);
    $air_amount = mysqli_real_escape_string($db, $_POST['air_amount']);
    $rawdata = mysqli_real_escape_string($db, $_POST['air_date']);
    $air_date = date('m-d-Y', strtotime($rawdata));
    
    $land_explain_expense = mysqli_real_escape_string($db, $_POST['land_explain_expense']);
    //$distance_traveled = mysqli_real_escape_string($db, $mile_to_money);
    $rawdata = mysqli_real_escape_string($db, $_POST['land_date']);
    $land_date = date('m-d-Y', strtotime($rawdata));
        
    $hotel_explain_expense = mysqli_real_escape_string($db, $_POST['hotel_explain_expense']);
    $hotel_amount = mysqli_real_escape_string($db, $_POST['hotel_amount']);
    $rawdata = mysqli_real_escape_string($db, $_POST['hotel_date']);
    $hotel_date = date('m-d-Y', strtotime($rawdata));
    
    $food_explain_expense = mysqli_real_escape_string($db, $_POST['food_explain_expense']);
    $food_amount = mysqli_real_escape_string($db, $_POST['food_amount']);
    $rawdata = mysqli_real_escape_string($db, $_POST['food_date']);
    $food_date = date('m-d-Y', strtotime($rawdata));
    
    $other_explain_expense = mysqli_real_escape_string($db, $_POST['other_explain_expense']);
    $other_amount = mysqli_real_escape_string($db, $_POST['other_amount']);
    $rawdata = mysqli_real_escape_string($db, $_POST['other_date']);
    $other_date = date('m-d-Y', strtotime($rawdata));
    
    $sql = "INSERT INTO reports(expense_id, number, date, explain_expense, file_upload, distance_traveled) 
            VALUES ('$expense_id', '$number', '$date', '$explain_expense', '$file_upload', '$distance_traveled')";
    
    if(mysqli_query($db, $sql)){
        echo "Records reported";
    } else{
        echo "Error";
    }
?>