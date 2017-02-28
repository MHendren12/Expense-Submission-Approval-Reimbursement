<?php
    session_start();
    include("../Database/config.php");		 
    $conn = getConnection();
    
    $action = $_GET['action'];
    $formId = $_GET['fid'];
    
    if ($action == "approve")
    {
        $getSubmitterId = "select submitter_id, approver_id, approver_level from expense_reports where expense_reports_id = '".$formId."'";
        $res = mysqli_query($conn,$getSubmitterId);
        $row = mysqli_fetch_assoc($res);
        $submitterId = $row['submitter_id'];
        $currentApproverId = $row['approver_id'];
        $currentLevel = $row['approver_level'];
        
        $getNextApprovers = "select routing.routingUser_id, routingColumn_id  from routing
            left join routingCondition on routingCondition.routingCondition_id = routing.routingRow_id
            where routingCondition.routingConditionType_id =  '".$submitterId."'";
        $res =  mysqli_query($conn, $getNextApprovers);
        $nextApprover = -1;
        $nextApproverLevel = -1;
        while($row = mysqli_fetch_assoc($res))
        {
            if ( $row['routingColumn_id'] > $currentLevel && $row['routingUser_id'] )
            {
                $nextApprover = $row['routingUser_id'];
                $nextApproverLevel = $row['routingColumn_id'];
                break;
            }
        }
        
        if ($nextApprover == -1)
        {
            $updateFormApprover = "Update expense_reports set approver_id = -1, approver_level = -1, expensereport_status='Approved' where expense_reports_id = '".$formId."'";
            $res = mysqli_query($conn, $updateFormApprover)
                or die(mysql_error());
        }
        else
        {
            $updateFormApprover = "Update expense_reports set approver_id = '".$nextApprover."', approver_level = '".$nextApproverLevel."' where expense_reports_id = '".$formId."'";
            $res = mysqli_query($conn, $updateFormApprover)
                or die(mysql_error());
            
             $insert = "INSERT INTO expensereport_history( expense_reports_id, reviewer_id) 
                VALUES ('".$formId."', '" .$nextApprover. "' )";
            $res = mysqli_query($conn, $insert)
                or die(mysql_error());
        }

        $updateHistory = "Update expensereport_history set revieweddate = CURRENT_TIMESTAMP() where expense_reports_id = '".$formId."' and revieweddate is NULL";
        $res = mysqli_query($conn, $updateHistory)
            or die(mysql_error());;
            

       
        header("Location: ../home.php");
    }
    else if ($action == "deny")
    {
        
    }
    else
    {
       
    }
    /*
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
    */
    
?>