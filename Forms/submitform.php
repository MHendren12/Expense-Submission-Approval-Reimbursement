<?php
    session_start();
    include("../Database/config.php");		 
    $conn = getConnection();
    $sid = $_SESSION['userid'];
    echo $sid;
    $getApprover = "select routing.routingUser_id from routing
    left join routingCondition on routingCondition.routingCondition_id = routing.routingRow_id
    where routingCondition.routingConditionType_id = '".$sid."'";
    $approvers =  mysqli_query($conn, $getApprover);
    $firstApprover = -1;
    while($row = mysqli_fetch_assoc($approvers))
    {
        if ( $row['routingUser_id']  )
        {
            $firstApprover = $row['routingUser_id'];
            break;
        }
    }
    //$file_upload = $_FILES["file_upload"]["name"];
    //$image = addslashes(file_get_contents($_FILES["file_upload"]["name"]));
    
    //$num_mile = $_GET['distance_traveled'];
    //$mile_to_money = .52 + 'distance_traveled';
    
    $AirChecked =  isset( $_POST['Air'] ) ? "checked" : "unchecked";
    $LandChecked = isset( $_POST['Land'] ) ? "checked" : "unchecked";
    $HotelChecked = isset( $_POST['Hotel'] ) ? "checked" : "unchecked";
    $FoodChecked = isset( $_POST['Food'] ) ? "checked" : "unchecked";
    $OtherChecked = isset( $_POST['Other'] ) ? "checked" : "unchecked";
    
    $expenseTypes .= '[{"fieldId":"Air", "fieldValue":"' . $AirChecked. '"},';
    $expenseTypes .= '{"fieldId":"Land", "fieldValue":"' . $LandChecked. '"},';
    $expenseTypes .= '{"fieldId":"Hotel","fieldValue":"' . $HotelChecked. '"},';
    $expenseTypes .= '{"fieldId":"Food", "fieldValue" :"' . $FoodChecked. '"},';
    $expenseTypes .= '{"fieldId":"Other","fieldValue":"' . $OtherChecked. '"}]';

    $air_explain_expense = mysqli_real_escape_string($conn, $_POST['air_explain_expense']);
    $air_amount = mysqli_real_escape_string($conn, $_POST['air_amount']);
    
    $air_depart_date = date('d-M-Y', strtotime($_POST['air_depart_date']));
    $air_return_date = date('d-M-Y', strtotime($_POST['air_return_date']));
    
    $land_explain_expense = mysqli_real_escape_string($conn, $_POST['land_explain_expense']);
    //$distance_traveled = mysqli_real_escape_string($db, $mile_to_money);
    $date = mysqli_real_escape_string($db, $_POST['land_date']);
    $land_date = date('d-M-Y', strtotime($date));
    $distance_traveled = mysqli_real_escape_string($conn, $_POST['distance_traveled']);
    
    $hotel_explain_expense = mysqli_real_escape_string($conn, $_POST['hotel_explain_expense']);
    $hotel_amount = mysqli_real_escape_string($conn, $_POST['hotel_amount']);
    $date = mysqli_real_escape_string($db, $_POST['hotel_date']);
    $hotel_date = date('d-M-Y', strtotime($date));

    $food_explain_expense = mysqli_real_escape_string($conn, $_POST['food_explain_expense']);
    $food_amount = mysqli_real_escape_string($conn, $_POST['food_amount']);
    $date = mysqli_real_escape_string($db, $_POST['food_date']);
    $food_date = date('d-M-Y', strtotime($date));
    
    $other_explain_expense = mysqli_real_escape_string($conn, $_POST['other_explain_expense']);
    $other_amount = mysqli_real_escape_string($conn, $_POST['other_amount']);
    $date = mysqli_real_escape_string($db, $_POST['other_date']);
    $other_date = date('d-M-Y', strtotime($date));


    $fieldValues = "";
    $fieldValues .= '[{"fieldId":"air_explain_expense", "fieldValue":"' . $air_explain_expense. '"},';
    $fieldValues .= '{"fieldId":"air_amount","fieldValue":"' . $air_amount. '"},';
    $fieldValues .= '{"fieldId":"air_depart_date","fieldValue":"' . $air_depart_date. '"},';
    $fieldValues .= '{"fieldId":"air_return_date","fieldValue":"' . $air_return_date. '"},';
    $fieldValues .= '{"fieldId":"land_explain_expense","fieldValue":"' . $land_explain_expense. '"},';
    $fieldValues .= '{"fieldId":"land_date", "fieldValue":"' . $land_date. '"},';
    $fieldValues .= '{"fieldId":"distance_traveled", "fieldValue":"' . $distance_traveled. '"},';
    $fieldValues .= '{"fieldId":"hotel_explain_expense", "fieldValue":"' . $hotel_explain_expense. '"},';
    $fieldValues .= '{"fieldId":"hotel_amount", "fieldValue":"' . $hotel_amount. '"},';
    $fieldValues .= '{"fieldId":"food_explain_expense", "fieldValue":"' . $food_explain_expense. '"},';
    $fieldValues .= '{"fieldId":"food_amount", "fieldValue":"' . $food_amount. '"},';
    $fieldValues .= '{"fieldId":"food_date", "fieldValue":"' . $food_date. '"},';
    $fieldValues .= '{"fieldId":"other_explain_expense", "fieldValue":"' . $other_explain_expense. '"},';
    $fieldValues .= '{"fieldId":"other_amount", "fieldValue":"' . $other_amount. '"},';
    $fieldValues .= '{"fieldId":"other_date", "fieldValue":"' . $other_date. '"}]';
    
    
    $sql = "INSERT INTO expense_reports( submitter_id, approver_id, expense_types, expense_fields, submission_date, expensereport_status) 
            VALUES ('".$sid."', '" . $firstApprover. "','" .$expenseTypes. "','".$fieldValues."', CURRENT_TIMESTAMP(), 'Pending' )";
    $insert = mysqli_query($conn, $sql) 
        or die(mysqli_error($insert));
    
    $expenseReportId = mysqli_insert_id($conn);
    echo $expenseReportId;
    
    $sql = "INSERT INTO expensereport_history( expense_reports_id, revieweddate, reviewer_id) 
            VALUES ('".$expenseReportId."', CURRENT_TIMESTAMP() ,'" .$sid. "' )";
    $insert = mysqli_query($conn, $sql) 
        or die(mysqli_error($insert));
        
    $sql = "INSERT INTO expensereport_history( expense_reports_id, reviewer_id) 
            VALUES ('".$expenseReportId."','" .$firstApprover. "' )";
    $insert = mysqli_query($conn, $sql) 
        or die(mysqli_error($insert));
    
        
        
    header("Location: ../home.php");
    
?>