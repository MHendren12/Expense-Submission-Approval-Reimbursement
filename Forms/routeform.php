<?php
    session_start();
    include("../Database/config.php");		 
    $conn = getConnection();
    $sid = $_SESSION['userid'];
    
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