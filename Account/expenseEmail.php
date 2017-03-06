<?php
function getUserInformation($user_id, $conn){
    $domain = $_SERVER['HTTP_HOST'];
    $expenseTableQuerry = "select user.user_id, user.user_fname, user_lname, user.email, routingColumn_id, routingCondition.routingConditionType_id, expense_reports.approver_id, expense_reports.submitter_id,
    expense_reports.submission_date, expensereport_history.revieweddate, expense_reports.expense_reports_id, expense_activity.expense_activity_id, expense_reports.expensereport_status
    from routing
    left join user on routing.routingUser_id = user.user_id 
    left join routingCondition on routingCondition.routingCondition_id=routing.routingRow_id
    left join userAssignment on userAssignment.user_id=user.user_id
    left join expense_reports on expense_reports.submitter_id=routingCondition.routingConditionType_id 
    left join expense_activity on expense_activity.expense_reports_id=expense_reports.expense_reports_id
    left join expensereport_history on expensereport_history.expense_reports_id = expense_reports.expense_reports_id
    where expense_reports.expense_reports_id is not null and user.user_id is not null and expense_reports.expense_reports_id is not null and expense_reports.approver_id=user.user_id and routingCondition.routingConditionType_id=" . $user_id .
    " or expense_reports.expense_reports_id is not null and user.user_id is not null and expense_reports.expense_reports_id is not null and expense_reports.approver_id=user.user_id and user.user_id=" . $user_id .
    " order by expense_reports.submission_date desc";
    
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result))
    {   
        $userid = $row['user_id'];
        $sent_to_email = $row['email'];
        $name = userName($userid, $conn);
        $expense_id= $row['expense_reports_id'];
        $routingConditionType_id = $row['routingConditionType_id'];
        $submitter = userName($routingConditionType_id, $conn);
        $submission_date = $row ['submission_date'];
        
    }
}

// Submitter gets an email stating that the expense form was submitted
function getSubmissionEmail(){
    getUserInformation($user_id, $conn);
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
          { \"Email\": \"".$sent_to_email."\" }
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
function getApprovedEmail(){
    getUserInformation($user_id, $conn);
    shell_exec("
    curl -s \
      -X POST \
      --user \"fd53dceb11de74bfc08124b30aabfbe0:96e43f32048e212b9d94cb45191c62ce\" \
      https://api.mailjet.com/v3/send \
      -H 'Content-Type: application/json' \
      -d '{
        \"FromEmail\": \"mrhendre@oakland.edu\",
        \"FromName\": \"RASE Corp.\",
        \"Subject\": \"RASE - Expense Form Approved\",
        \"MJ-TemplateID\": \"114891\",
        \"MJ-TemplateLanguage\": true,
        \"Recipients\": [
          { \"Email\": \"".$sent_to_email."\" }
        ],
        \"Vars\": {
        \"user\": \"" . $name . "\",
        \"RASE_link\": \"".$domain."\",
        \"expense_id\": \"".$expense_id."\",
        \"submission_date\": \"".$submission_date."\",
        \"last_approver\": \"".$last_approver."\"
        }
      }'
    ");    
}

// Email is sent to the Submitter when the expense form gets declined.
function getDeclinedEmail(){
    getUserInformation($user_id, $conn);
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
        \"declined_approver\": \"".$declined_approver."\"
        }
      }'
    ");    
}

// Email is sent to the initial approver of the expense form
function getApprovalRequest(){
    getUserInformation($user_id, $conn);
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
        \"current_approver\": \"".$current_approver."\"
        }
      }'
    ");    
}

?>