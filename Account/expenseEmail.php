<?php
if (file_exists('WebService/accountinfo.php') )
  {
    include_once('WebService/accountinfo.php');
  }
else {
    include_once('../WebService/accountinfo.php');
}
        


// Submitter gets an email stating that the expense form was submitted
function getSubmissionEmail($expense_id, $conn){
    $domain = $_SERVER['HTTP_HOST'];
    $sql = "select expense_reports.expense_reports_id, expense_reports.submitter_id, expense_reports.approver_id, expense_reports.approver_level, 
                                expense_reports.submission_date, expense_reports.expensereport_status, user.user_id, user.user_email, 
                                expensereport_history.reviewer_id, expensereport_history.revieweddate, expensereport_history.action from expense_reports
                                left join user on user.user_id = expense_reports.submitter_id
                                left join expensereport_history on expensereport_history.expense_reports_id = expense_reports.expense_reports_id
                                where expensereport_history.action='Submit' and expensereport_history.expense_reports_id = $expense_id";
    
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result))
    {   
        $userid = $row['user_id'];
        $email = $row['user_email'];
        $name = userName($userid, $conn);
        $expense_id= $row['expense_reports_id'];
        $routingConditionType_id = $row['routingConditionType_id'];
        $approver_id = $row['approver_id'];
        $first_approver = userName($approver_id, $conn);
        $submission_date = $row ['submission_date'];
        
    }
    echo $email;
    shell_exec("
    curl -s \
      -X POST \
      --user \"fd53dceb11de74bfc08124b30aabfbe0:96e43f32048e212b9d94cb45191c62ce\" \
      https://api.mailjet.com/v3/send \
      -H 'Content-Type: application/json' \
      -d '{
        \"FromEmail\": \"mrhendre@oakland.edu\",
        \"FromName\": \"RASE Corp.\",
        \"Subject\": \"RASE - Expense Form Submitted\",
        \"MJ-TemplateID\": \"114886\",
        \"MJ-TemplateLanguage\": true,
        \"Recipients\": [
          { \"Email\": \"".$email."\" }
        ],
        \"Vars\": {
        \"user\": \"" . $name . "\",
        \"RASE_link\": \"".$domain."\",
        \"expense_id\": \"".$expense_id."\",
        \"submission_date\": \"".$submission_date."\",
        \"first_approver\": \"".$first_approver."\"
        }
      }'
    ");    
}

// Email is sent to the Submitter when the expense form gets approved
// by all of the approvers on the routing table
function getApprovedEmail($expense_id, $conn){
    $domain = $_SERVER['HTTP_HOST'];
    $sql = "select expense_reports.expense_reports_id, expense_reports.submitter_id, expense_reports.approver_id, expense_reports.approver_level, 
                                expense_reports.submission_date, expense_reports.expensereport_status, user.user_id, user.user_email, 
                                expensereport_history.reviewer_id, expensereport_history.revieweddate, expensereport_history.action from expense_reports
                                left join user on user.user_id = expense_reports.submitter_id
                                left join expensereport_history on expensereport_history.expense_reports_id = expense_reports.expense_reports_id
                                where expensereport_history.action = 'Final Approved' and expensereport_history.expense_reports_id = $expense_id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result))
    {   
        $userid = $row['user_id'];
        $name = userName($userid, $conn);
        $expense_id= $row['expense_reports_id'];
        $routingConditionType_id = $row['routingConditionType_id'];
        $submission_date = $row ['submission_date'];
        $submitter_id = $row['submitter_id'];
        $reviewer_id = $row['reviewer_id'];
        $submitter = userName($submitter_id, $conn);
        $last_approver = userName($reviewer_id, $conn);
        $sent_to_email = userEmail($submitter_id, $conn);
        $submission_date = $row ['submission_date'];
        
    }
    shell_exec('
    curl -s \
      -X POST \
      --user "fd53dceb11de74bfc08124b30aabfbe0:96e43f32048e212b9d94cb45191c62ce" \
      https://api.mailjet.com/v3/send \
      -H \'Content-Type: application/json\' \
      -d \'{
        "FromEmail": "mrhendre@oakland.edu",
        "FromName": "RASE Corp.",
        "Subject": "RASE - Expense Form Approved",
        "MJ-TemplateID": "114891",
        "MJ-TemplateLanguage": true,
        "Recipients": [
          { "Email": "'.$sent_to_email.'" }
        ],
        "Vars": {
        "user": "'.$name.'",
        "RASE_link": "'.$domain.'",
        "expense_id": "'.$expense_id.'",
        "submission_date": "'.$submission_date.'",
        "last_approver": "'.$last_approver.'"
        }
      }\'
    ');    
}

// Email is sent to the Submitter when the expense form gets declined.
function getDeclinedEmail($expense_id, $conn){
    $domain = $_SERVER['HTTP_HOST'];
    $sql = "select expense_reports.expense_reports_id, expense_reports.submitter_id, expense_reports.approver_id, expense_reports.approver_level, 
                                expense_reports.submission_date, expense_reports.expensereport_status, user.user_id, user.user_email, 
                                expensereport_history.reviewer_id, expensereport_history.revieweddate, expensereport_history.action from expense_reports
                                left join user on user.user_id = expense_reports.submitter_id
                                left join expensereport_history on expensereport_history.expense_reports_id = expense_reports.expense_reports_id
                                where expensereport_history.action = 'Denied' and expensereport_history.expense_reports_id = $expense_id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result))
    {   
        $userid = $row['user_id'];
        $sent_to_email = $row['user_email'];
        $name = userName($userid, $conn);
        $expense_id= $row['expense_reports_id'];
        $routingConditionType_id = $row['routingConditionType_id'];
        $submission_date = $row ['submission_date'];
        $reviewer_id = $row['reviewer_id'];
        $denied_approver = userName($reviewer_id, $conn);
        $submission_date = $row ['submission_date'];
        
    }
    shell_exec("  
      curl -s \
      -X POST \
      --user \"fd53dceb11de74bfc08124b30aabfbe0:96e43f32048e212b9d94cb45191c62ce\" \
      https://api.mailjet.com/v3/send \
      -H 'Content-Type: application/json' \
      -d '{
        \"FromEmail\": \"mrhendre@oakland.edu\",
        \"FromName\": \"RASE Corp.\",
        \"Subject\": \"RASE - Expense Form Declined\",
        \"MJ-TemplateID\": \"114892\",
        \"MJ-TemplateLanguage\": true,
        \"Recipients\": [
          { \"Email\": \"".$sent_to_email."\" }
        ],
        \"Vars\": {
        \"user\": \"" . $name . "\",
        \"RASE_link\": \"".$domain."\",
        \"expense_id\": \"".$expense_id."\",
        \"submission_date\": \"".$submission_date."\",
        \"declined_approver\": \"".$denied_approver."\"
        }
      }'
    ");    
}

// Email is sent to the initial approver of the expense form
function getApprovalRequest($expense_id, $conn){
    $domain = $_SERVER['HTTP_HOST'];
    $sql = "select expense_reports.expense_reports_id, expense_reports.submitter_id, expense_reports.approver_id, expense_reports.approver_level, 
                                expense_reports.submission_date, expense_reports.expensereport_status, user.user_id, user.user_email, 
                                expensereport_history.reviewer_id, expensereport_history.revieweddate, expensereport_history.action from expense_reports
                                left join user on user.user_id = expense_reports.submitter_id
                                left join expensereport_history on expensereport_history.expense_reports_id = expense_reports.expense_reports_id
                                where expensereport_history.action = 'Submit' and expensereport_history.expense_reports_id = $expense_id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result))
    {   
        $userid = $row['user_id'];
        $email = $row['user_email'];
        $submitter_id = $row['submitter_id'];
        $submitter = userName($submitter_id, $conn);
        $expense_id= $row['expense_reports_id'];
        $routingConditionType_id = $row['routingConditionType_id'];
        $approver_id = $row['approver_id'];
        $name = userName($approver_id, $conn);
        $sent_to_email = userEmail($approver_id, $conn);
        $submission_date = $row ['submission_date'];
        
    }
    shell_exec("  
      curl -s \
      -X POST \
      --user \"fd53dceb11de74bfc08124b30aabfbe0:96e43f32048e212b9d94cb45191c62ce\" \
      https://api.mailjet.com/v3/send \
      -H 'Content-Type: application/json' \
      -d '{
        \"FromEmail\": \"mrhendre@oakland.edu\",
        \"FromName\": \"RASE Corp.\",
        \"Subject\": \"RASE - Expense Form Request\",
        \"MJ-TemplateID\": \"114893\",
        \"MJ-TemplateLanguage\": true,
        \"Recipients\": [
          { \"Email\": \"".$sent_to_email."\" }
        ],
        \"Vars\": {
        \"user\": \"" . $name . "\",
        \"RASE_link\": \"".$domain."\",
        \"expense_id\": \"".$expense_id."\",
        \"submitter\": \"".$submitter."\",
        \"submission_date\": \"".$submission_date."\",
        \"current_approver\": \"".$name."\"
        }
      }'
    ");    
}

?>