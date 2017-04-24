<?php
    session_start();
    include("../Database/config.php");

    $conn = getConnection();
    $sid = $_SESSION['userid'];
    $action = $_GET['action'];
    $form = $_POST['formId'];
    $tableRows = $_POST['numRows'];
    $currentTableRow = 1;
    
    
    $tableRowsArray = array();
    while ( $currentTableRow <= $tableRows ) 
    {
        $formJSON .= '{"row": "'.$currentTableRow.'", "Value": "';
        $sDate = $_POST['ExpenseStartDate'][$currentTableRow];
        $eDate = $_POST['ExpenseEndDate'][$currentTableRow];
        $type = $_POST['ExpenseType'][$currentTableRow];
        $total = $_POST['ExpenseAmount'][$currentTableRow];
        $totalApp = $_POST['ExpenseApproved'][$currentTableRow];
        $hField = $_POST['fieldData'][$currentTableRow];
        $hField = json_decode($hField);
        
        $JSON = array(
            "Row" => $currentTableRow,
            "Value" => array(
                array(
                    "Column" => "ExpenseStartDate",
                    "Value" => $sDate
                ),
                array(
                    "Column" => "ExpenseEndDate",
                    "Value" => $eDate
                ),
                array(
                    "Column" => "ExpenseType",
                    "Value" => $type
                ),
                array(
                    "Column" => "ExpenseAmount",
                    "Value" => $total
                ),
                array(
                    "Column" => "ExpenseApproved",
                    "Value" => $totalApp
                ),
                array(
                    "Column" => "fieldData",
                    "Value" => $hField
                )
            )
        );

        /*
        $formJSON .= '{"row":"'.$currentTableRow.'", "ColValues":"[{ "Column" : "ExpenseStartDate", "Value": "'.$sDate.'" },"';
        $formJSON .= '{ "Column" : "ExpenseEndDate", "Value": "'.$eDate.'" },"';
        $formJSON .= '{ "Column" : "ExpenseType", "Value": "'.$type.'" },"';
        $formJSON .= '{ "Column" : "ExpenseAmount", "Value": "'.$total.'" },"';
        $formJSON .= '{ "Column" : "ExpenseApproved", "Value": "'.$totalApp.'" },"';
        if ( $currentTableRow == $tableRows )
            $formJSON .= '{ "Column" : "fieldData", "Value": "'.$hField.'" }]"}],';
        else
            $formJSON .= '{ "Column" : "fieldData", "Value": "'.$hField.'" }]"},';
        
        */
        array_push( $tableRowsArray, $JSON );
        $currentTableRow = $currentTableRow + 1;
    }
    //$formJSON = '[{"fieldId":"ExpenseTable", "fieldValue":"[';
    $formArray = array(
        array(
            "fieldId" => "ExpenseTable",
            "fieldValue" => $tableRowsArray
        )
        
    );
    
    
    
    $getApprover = "select routing.routingUser_id, routingColumn_id from routing
    left join routingCondition on routingCondition.routingCondition_id = routing.routingRow_id
    where routingCondition.routingConditionType_id = '".$sid."'";
    $approvers =  mysqli_query($conn, $getApprover);
    
    $firstApprover = -1;
    $approverLevel = -1;
    while($row = mysqli_fetch_assoc($approvers))
    {
        if ( $row['routingUser_id']  )
        {
            $firstApprover = $row['routingUser_id'];
            $approverLevel = $row['routingColumn_id'];
            break;
        }
    }
    //$file_upload = $_FILES["file_upload"]["name"];
    //$image = addslashes(file_get_contents($_FILES["file_upload"]["name"]));
    
    //$num_mile = $_GET['distance_traveled'];
    //$mile_to_money = .52 + 'distance_traveled';
    
    //$GeneralChecked = isset($_POST['General'] );
    $AirChecked =  isset( $_POST['Air'] ) ? "checked" : "unchecked";
    $LandChecked = isset( $_POST['Land'] ) ? "checked" : "unchecked";
    $HotelChecked = isset( $_POST['Hotel'] ) ? "checked" : "unchecked";
    $FoodChecked = isset( $_POST['Food'] ) ? "checked" : "unchecked";
    $OtherChecked = isset( $_POST['Other'] ) ? "checked" : "unchecked";
    
   // $expenseTypes .= '{"fieldId":"General", "fieldValue":"' . $GeneralChecked. '"},';
    $expenseTypes .= '[{"fieldId":"Air", "fieldValue":"' . $AirChecked. '"},';
    $expenseTypes .= '{"fieldId":"Land", "fieldValue":"' . $LandChecked. '"},';
    $expenseTypes .= '{"fieldId":"Hotel","fieldValue":"' . $HotelChecked. '"},';
    $expenseTypes .= '{"fieldId":"Food", "fieldValue" :"' . $FoodChecked. '"},';
    $expenseTypes .= '{"fieldId":"Other","fieldValue":"' . $OtherChecked. '"}]';

    $general_name = mysqli_real_escape_string($conn, $_POST['name']);
    $general_address = mysqli_real_escape_string($conn, $_POST['address']);
    $general_city = mysqli_real_escape_string($conn, $_POST['city']);
    $general_postal_code = mysqli_real_escape_string($conn, $_POST['postal']);
    $general_department = mysqli_real_escape_string($conn, $_POST['department']);
    
    
    
    $formFieldsArray = array(
        array(
            "fieldId" => "general_name",
            "fieldValue" => $general_name
        ),
        array(
            "fieldId" => "general_address",
            "fieldValue" => $general_address
        ),
        array(
            "fieldId" => "general_city",
            "fieldValue" => $general_city
        ),
        array(
            "fieldId" => "general_postal_code",
            "fieldValue" => $general_postal_code
        ),
        array(
            "fieldId" => "general_department",
            "fieldValue" => $general_department
        )
    );
    array_push( $formArray, $formFieldsArray );
    
    $formJSON = json_encode($formArray);
    echo $formJSON;


    
    $expenseReportId = $form;
    $status = "Pending";
    
    if ($action == "save")
    {
        $status = "Saved";
        $firstApprover = -1;
        $approverLevel = -1;
    }
    if ($form != -1)
    {
        
        $sql = "update expense_reports set submitter_id = '".$sid."',
        approver_id = '".$firstApprover."',
        approver_level = '".$approverLevel."',
        expense_fields = '".$formJSON."',
        submission_date = CURRENT_TIMESTAMP(),
        expensereport_status = '".$status."'
        where expense_reports_id = '".$form."'";
        $update = mysqli_query($conn, $sql) or die(mysqli_error($update));
    }
    else
    {
        $sql = "INSERT INTO expense_reports( submitter_id, approver_id, approver_level, expense_fields, submission_date, expensereport_status) 
            VALUES ('".$sid."', '" . $firstApprover. "','".$approverLevel."', '".$formJSON."', CURRENT_TIMESTAMP(), '".$status."' )";
        $insert = mysqli_query($conn, $sql) or die(mysqli_error($insert));
    
        $expenseReportId = mysqli_insert_id($conn);
    }
    if ($action != "save")
    {
        $sql = "INSERT INTO expensereport_history( expense_reports_id, revieweddate, reviewer_id, action) 
                VALUES ('".$expenseReportId."', CURRENT_TIMESTAMP() ,'" .$sid. "', 'Submit' )";
        $insert = mysqli_query($conn, $sql) or die(mysqli_error($insert));
            
        $sql = "INSERT INTO expensereport_history( expense_reports_id, reviewer_id) 
                VALUES ('".$expenseReportId."','" .$firstApprover. "' )";
        $insert = mysqli_query($conn, $sql) or die(mysqli_error($insert));
    }
    
    if (empty($_FILES['attachments']['name']))
    foreach ($_FILES['attachments']['name'] as $f => $filename) 
    {  
        $tmpName  = $_FILES['attachments']['tmp_name'][$f];
        $tmpPath = "/home/ubuntu/workspace/FormAttachments/".$tmpName;
        $webPath = "../FormAttachments".$tmpName;
        move_uploaded_file($tmpName, $tmpPath);
        $insertAttachment = "insert into attachments (expenseform_id, uploadpath) values ('".$expenseReportId."', '".$webPath."' ) ";
        $insert = mysqli_query($conn, $insertAttachment);
    }
    
    // trigger email on submission
    include("../Account/expenseEmail.php");
    $sql = "select expense_reports_id from expense_reports order by expense_reports_id DESC limit 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $expense_reports_id = $row['expense_reports_id'];
    getSubmissionEmail($expense_reports_id, $conn);
    
    // trigger email for first approver
    $sql = "select expense_reports_id from expense_reports order by expense_reports_id DESC limit 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $expense_reports_id = $row['expense_reports_id'];
    getApprovalRequest($expense_reports_id, $conn);
    
    header("Location: ../home.php");

?>