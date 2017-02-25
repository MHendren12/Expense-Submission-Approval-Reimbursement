<?php

    session_start();
    if (file_exists('Database/config.php') )
    {
        include("Database/config.php");
    }
    else 
    {
        include("../Database/config.php");
    }
    $conn = getConnection();
    $id = $_SESSION['userid'];
    
    
    if( $_GET['val'] )  
    {
        switch ($_GET['val']) {
            case comparePasswords:
                return comparePasswords($_GET['pass'], $id, $conn);
                break;
            case compareEmails:
                return compareEmails($_GET['email'], $conn);
                break;
            case isadmin:
                return isadmin($_GET['user_id'], $conn);
            default:
                break;
        }
    }
    
    function comparePasswords($pass, $uid, $conn)
    {
        $sql = "select salt from user where user_id = '".$uid."'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$num_rows = mysqli_num_rows($result);
		if ($num_rows > 0)
		{
		    
    		$salt= $row['salt'];
            $saltedPW =  $pass . $salt;
            
            $hashedPW = hash('sha256', $saltedPW);
    		$sql = "select * from user where user_pass='".$hashedPW."' and user_id='".$uid."'";
    		$result = mysqli_query($conn, $sql);
    		$num_rows = mysqli_num_rows($result);
    		if ($num_rows >= 1)
    		    echo true;
    		else
    		    echo false;
		}

    }
    function compareEmails($email, $conn)
    {
        $sql = "select * from user where user_email = '".$email."'";
		$result = mysqli_query($conn, $sql);
		$num_rows = mysqli_num_rows($result);
		if ($num_rows == 1)
		{
		    echo true;
    		
		}
        else {
            echo false;
        }
    }
    function isadmin($user_id, $conn)
    {
        $sql = "SELECT is_admin FROM user WHERE user_id= '".$user_id."'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result))
        {     
            $admin = $row['is_admin'];
        }
        $sql = "SELECT * FROM userAssignment WHERE userRole_id = (select userRole_id from userRole where userRole_Name ='Administrator' ) and user_id = '".$user_id."'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        
        $isAdmin = ( $num_rows == 1 || $admin ) == true ? true : false;
        return $isAdmin;
        
    }
    function getUserNameById($user_id, $conn)
    {
        $sql = "SELECT user_fname, user_lname FROM user WHERE user_id= '".$user_id."'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $users_name = $row['user_fname']." ".$row['user_lname'];
        return $users_name;
    }
    
    function getExpenseTableQuerry(){
        $expenseTableQuerry = "select user.user_id, user.user_fname, user_lname, routingColumn_id, routingCondition.routingConditionType_id, expense_reports.approver_id, expense_reports.submitter_id,
            expense_reports.submission_date, expensereport_history.revieweddate, expense_reports.expense_reports_id, expense_activity.expense_activity_id, expense_reports.expensereport_status
            from routing
            left join user on routing.routingUser_id = user.user_id 
            left join routingCondition on routingCondition.routingCondition_id=routing.routingRow_id
            left join userAssignment on userAssignment.user_id=user.user_id
            left join expense_reports on expense_reports.submitter_id=routingCondition.routingConditionType_id 
            left join expense_activity on expense_activity.expense_reports_id=expense_reports.expense_reports_id
            left join expensereport_history on expensereport_history.expense_reports_id = expense_reports.expense_reports_id";
        return $expenseTableQuerry;
    }
    
    function isSubmitter($user_id, $conn)
    {
        $sql = "SELECT * FROM user left join userAssignment on user.user_id=userAssignment.user_id WHERE user.user_id=" .$user_id. " and userAssignment.userRole_id=3";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        if($num_rows == 1){
            return true;
        }
        else{
            return false;
        }
        
    }

    function isApprover($user_id, $conn)
    {
        $sql = "SELECT * FROM user left join userAssignment on user.user_id=userAssignment.user_id WHERE user.user_id=" .$user_id. " and userAssignment.userRole_id=2";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        if($num_rows == 1){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    function isSubmitterAndApprover($user_id, $conn){
        $sql = "SELECT * FROM user left join userAssignment on user.user_id=userAssignment.user_id WHERE user.user_id=" .$user_id. " and userAssignment.userRole_id=1";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        if($num_rows == 1){
            return true;
        }
        else{
            return false;
        }
    }
    
    function userName($user_id, $conn){
        $sql = "SELECT user_id, user_fname, user_lname FROM user WHERE user_id= '".$user_id."'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $user_fname = $row['user_fname'];
            $user_lname = $row['user_lname'];
        }
        $fullname= $user_fname . " " . $user_lname;
        return $fullname;
    }
    
    
    function isApprovalDate($user_id, $conn){
    $sql = getExpenseTableQuerry()." where expense_reports.expense_reports_id is not null and user.user_id=" . $user_id .
            " order by expense_reports.submission_date desc";
             $result = mysqli_query($conn, $sql);
             $num_rows = mysqli_num_rows($result);           
            while($row = mysqli_fetch_assoc($result))
            {
                $revieweddate=$row['revieweddate'];
            }
            
    }
    
    function isSubmittedDate($user_id, $conn){
    $sql = getExpenseTableQuerry()." where expense_reports.expense_reports_id is not null and user.user_id=" . $user_id .
            " order by expense_reports.submission_date desc";
             $result = mysqli_query($conn, $sql);
             $num_rows = mysqli_num_rows($result);           
            while($row = mysqli_fetch_assoc($result))
            {
                $submission_date=$row['submission_date'];
            }
            
    }
    
    function isFinalApprovalDate($user_id, $conn){
    $sql = getExpenseTableQuerry()." where expense_reports.expense_reports_id is not null and user.user_id=" . $user_id .
            " order by expense_reports.submission_date desc";
             $result = mysqli_query($conn, $sql);
             $num_rows = mysqli_num_rows($result);           
            while($row = mysqli_fetch_assoc($result))
            {
                $expensereport_status=$row['status'];
            }
            
    }
    
    function isApproverTable($user_id, $conn){
                    
    $sql = getExpenseTableQuerry()." where expense_reports.expense_reports_id is not null and user.user_id=" . $user_id .
            " order by expense_reports.submission_date desc";
            
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);            
            while($row = mysqli_fetch_assoc($result))
            {   
                $user_id = $row['user_id'];
                $expense_activity_id= $row['expense_activity_id'];
                $expense_reports_id= $row['expense_reports_id'];
                $routingColumn_id = $row['routingColumn_id'];
                $routingConditionType_id = $row['routingConditionType_id'];
                $fname= $row['user_fname'];
                $lname= $row['user_lname'];
                $submission_date = $row ['submission_date'];
                $revieweddate = $row ['revieweddate'];
                $expensereport_status = $row ['status'];
?>
                <tr>
                <td><?php echo $expense_activity_id;?></td>
                <td><?php echo userName($routingConditionType_id, $conn); ?></td>  
                <td><?php echo userName($user_id, $conn); ?></td>
                <td><?php echo $submission_date;?></td>
                <td><?php echo $revieweddate;?></td>
                <td><?php echo $expensereport_status;?></td>
                <td align="center">
                <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $expense_reports_id; ?>" id="getexpenseform" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i> View</button>
                </td>                                
                </tr>
<?php
            }
                if($num_rows==0){
                    echo "<td colspan='7' align='center'>No Results or History.</td>";
                }
        }
    
    function isSubmitterTable($user_id, $conn){

    $sql = getExpenseTableQuerry()." where expense_reports.expense_reports_id is not null and user.user_id=expense_reports.approver_id and routingCondition.routingConditionType_id=" . $user_id.
            " order by expense_reports.submission_date desc";
            
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);           
            while($row = mysqli_fetch_assoc($result))
            {   
                $user_id = $row['user_id'];
                $expense_activity_id= $row['expense_activity_id'];
                $expense_reports_id= $row['expense_reports_id'];
                $routingColumn_id = $row['routingColumn_id'];
                $routingConditionType_id = $row['routingConditionType_id'];
                $fname= $row['user_fname'];
                $lname= $row['user_lname'];
                $submission_date = $row ['submission_date'];
                $revieweddate = $row ['revieweddate'];
                $expensereport_status = $row ['status'];

?>
                <tr>
                <td><?php echo $expense_activity_id;?></td>
                <td><?php echo userName($routingConditionType_id, $conn); ?></td>  
                <td><?php echo userName($user_id, $conn); ?></td>
                <td><?php echo $submission_date;?></td>
                <td><?php echo $revieweddate;?></td>
                <td><?php echo $expensereport_status;?></td>
                <td align="center">
                <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $expense_reports_id; ?>" id="getexpenseform" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i> View</button>
                </td>                                
                </tr>
<?php
            }
                if($num_rows==0){
                    echo "<td colspan='7' align='center'>No Results or History.</td>";
                }
    }
function isAdminTable($conn){
                    
    $sql = getExpenseTableQuerry()." where expense_reports.expense_reports_id is not null and user.user_id is not null and user.user_id=expense_reports.approver_id" .
            " order by expense_reports.submission_date desc";
            
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);            
            while($row = mysqli_fetch_assoc($result))
            {   
                $user_id = $row['user_id'];
                $expense_activity_id= $row['expense_activity_id'];
                $expense_reports_id= $row['expense_reports_id'];
                $routingColumn_id = $row['routingColumn_id'];
                $routingConditionType_id = $row['routingConditionType_id'];
                $fname= $row['user_fname'];
                $lname= $row['user_lname'];
                $submission_date = $row ['submission_date'];
                $revieweddate = $row ['revieweddate'];
                $expensereport_status = $row ['expensereport_status'];

?>
                <tr>
                <td><?php echo $expense_reports_id;?></td>
                <td><?php echo userName($routingConditionType_id, $conn); ?></td>  
                <td><?php echo userName($user_id, $conn); ?></td>
                <td><?php echo $submission_date;?></td>
                <td><?php echo $revieweddate;?></td>
                <td><?php echo $expensereport_status;?></td>
                <td align="center">
                <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $expense_reports_id; ?>" id="getexpenseform" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i> View</button>
                </td>                                
                </tr>
<?php
            }
                if($num_rows==0){
                    echo "<td colspan='7' align='center'>No Results or History.</td>";
                }
    }
    
    function isMyPending($user_id, $conn){
                    
    $sql = getExpenseTableQuerry()." where expense_reports.expense_reports_id is not null and user.user_id is not null and expense_reports.expensereport_status='Pending' and expense_reports.approver_id=user.user_id and routingCondition.routingConditionType_id=" . $user_id .
            " or expense_reports.expense_reports_id is not null and user.user_id is not null and expense_reports.expensereport_status='Pending' and expense_reports.approver_id=user.user_id and user.user_id=" . $user_id .
            " order by expense_reports.submission_date desc";
            
            $result = mysqli_query($conn, $sql);
                        
            $num_rows = mysqli_num_rows($result);
            if($num_rows == 0){
                return false;
            }
            else{
                return true;
            }
        }
    function isMySaved($user_id, $conn){
                    
    $sql = getExpenseTableQuerry()." where expense_reports.expense_reports_id is not null and user.user_id is not null and expense_reports.expensereport_status='saved' and expense_reports.approver_id=user.user_id and routingCondition.routingConditionType_id=" . $user_id .
            " or expense_reports.expense_reports_id is not null and user.user_id is not null and expense_reports.expensereport_status='saved' and expense_reports.approver_id=user.user_id and user.user_id=" . $user_id .
            " order by expense_reports.submission_date desc";
            
            $result = mysqli_query($conn, $sql);
                        
            $num_rows = mysqli_num_rows($result);
            if($num_rows == 0){
                return false;
            }
            else{
                return true;
            }
        }
    function isMyProcessed($user_id, $conn){
                    
    $sql = getExpenseTableQuerry()." where expense_reports.expense_reports_id is not null and user.user_id is not null and expense_reports.expensereport_status='approved' and expense_reports.approver_id=user.user_id and routingCondition.routingConditionType_id=" . $user_id .
            " or expense_reports.expense_reports_id is not null and user.user_id is not null and expense_reports.expensereport_status='approved' and expense_reports.approver_id=user.user_id and user.user_id=" . $user_id .
            " order by expense_reports.submission_date desc";
            
            $result = mysqli_query($conn, $sql);
                        
            $num_rows = mysqli_num_rows($result);
              if($num_rows == 0){
                return false;
            }
            else{
                return true;
            }
        }
?>