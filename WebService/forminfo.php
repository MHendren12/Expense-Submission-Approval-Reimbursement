<?php

    session_start();
     if (!$conn)
     {
        if (file_exists('Database/config.php') )
        {
            include("Database/config.php");
        }
        else 
        {
            include("../Database/config.php");
        }
        $conn = getConnection();
     }
    $id = $_SESSION['userid'];
    
    if( $_POST['val'] )  
    {
       
        switch ($_POST['val']) {
            case getExpenseTypes:
                $formid = $_POST['formid'];
                $sql = "select expense_types from expense_reports where expense_reports_id = '".$formid."'";
        		$result = mysqli_query($conn, $sql);
        		$row = mysqli_fetch_assoc($result);
        		$num_rows = mysqli_num_rows($result);
        		if ($num_rows > 0)
        		{
            	    echo $row['expense_types'];
        		}
                
                break;
            case getExpenseFields:
                echo getExpenseFields($_POST['formid'], $conn);
                break;  
            default:
                break;
        }
    }
    
    function getExpenseTypes($formid, $conn)
    {
        

    }
    function getExpenseFields($formid, $conn)
    {
        $sql = "select expense_fields from expense_reports where expense_reports_id = '".$formid."'";
        		$result = mysqli_query($conn, $sql);
        		$row = mysqli_fetch_assoc($result);
        		$num_rows = mysqli_num_rows($result);
        		
        		if ($num_rows > 0)
        		{
            	    echo $row['expense_fields'];
        		}
        		else
        		    echo '[]';
    }
    
        
    function getExpenseTableQuerySubmitter($status = "null"){
        $expenseTableQuerry = "select user.user_id, expense_reports.approver_id, expense_reports.submitter_id,expense_reports.submission_date,
                                expense_reports.expense_reports_id, expense_reports.expensereport_status
                                from expense_reports
                                left join user on user.user_id = expense_reports.submitter_id
                                where submitter_id = '".$_SESSION['userid']."'";
        if ($status != "null")
            $expenseTableQuerry .= "and expense_reports.expensereport_status='".$status."'";
        $expenseTableQuerry .= "order by expense_reports.submission_date DESC";
                                

        return $expenseTableQuerry;
    }
    function getExpenseTableQueryApprover($status = "null"){
        $expenseTableQuerry = "select user.user_id, expense_reports.approver_id, expense_reports.submitter_id,expense_reports.submission_date,
                                expense_reports.expense_reports_id, expense_reports.expensereport_status
                                from expense_reports
                                left join user on user.user_id = expense_reports.submitter_id
                                where approver_id = '".$_SESSION['userid']."'";
                                
                                
        if ($status != "null")
            $expenseTableQuerry .= "and expense_reports.expensereport_status='".$status."'";
        $expenseTableQuerry .= "order by expense_reports.submission_date DESC"; 

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

    
    function isApprovalDate($user_id, $conn){
    $sql = getExpenseTableQuery()." order by expense_reports.submission_date desc";
             $result = mysqli_query($conn, $sql);
             $num_rows = mysqli_num_rows($result);           
            while($row = mysqli_fetch_assoc($result))
            {
                $revieweddate=$row['revieweddate'];
            }
            
    }
    
    function isSubmittedDate($user_id, $conn){
    $sql = getExpenseTableQuery()." order by expense_reports.submission_date desc";
             $result = mysqli_query($conn, $sql);
             $num_rows = mysqli_num_rows($result);           
            while($row = mysqli_fetch_assoc($result))
            {
                $submission_date=$row['submission_date'];
            }
            
    }
    
    function isFinalApprovalDate($user_id, $conn){
    $sql = getExpenseTableQuery()." order by expense_reports.submission_date desc";
             $result = mysqli_query($conn, $sql);
             $num_rows = mysqli_num_rows($result);           
            while($row = mysqli_fetch_assoc($result))
            {
                $expensereport_status=$row['status'];
            }
            
    }
    
    function getApproverTable($user_id, $conn){
                    
    $sql = getExpenseTableQueryApprover();
            
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);            
            while($row = mysqli_fetch_assoc($result))
            {   
                $user_id = $row['user_id'];
                $expense_reports_id= $row['expense_reports_id'];
                $submission_date = $row ['submission_date'];
                //$revieweddate = $row ['revieweddate'];
                $expensereport_status = $row ['expensereport_status'];
                $approver_id = $row['approver_id'];
?>
                <tr>
                <td><?php echo $expense_reports_id;?></td>
                <td><?php echo userName($user_id , $conn); ?></td>  
                <td><?php echo userName($approver_id, $conn); ?></td>
                <td><?php echo $submission_date;?></td>
                <td><?php 
                        if ($expensereport_status == "Approved" || $expensereport_status == "denied")
                        {
                            echo $revieweddate;
                        }
                        else
                        echo "N/A";
                    ?>
                </td>
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
    
    function getSubmitterTable($user_id, $conn){

    $sql = getExpenseTableQuerySubmitter();
            
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);           
            while($row = mysqli_fetch_assoc($result))
            {   
                $user_id = $row['user_id'];
                $expense_reports_id= $row['expense_reports_id'];
                $submission_date = $row ['submission_date'];
                //$revieweddate = $row ['revieweddate'];
                $expensereport_status = $row ['expensereport_status'];
                $approver_id = $row['approver_id'];
?>
                <tr>
                <td><?php echo $expense_reports_id;?></td>
                <td><?php echo userName($user_id , $conn); ?></td>  
                <td><?php echo userName($approver_id, $conn); ?></td>
                <td><?php echo $submission_date;?></td>
                <td><?php 
                        if ($expensereport_status == "Approved" || $expensereport_status == "denied")
                        {
                            echo $revieweddate;
                        }
                        else
                        echo "N/A";
                    ?>
                </td>
                <td><?php echo $expensereport_status;?></td>
                <td align="center">
                <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $expense_reports_id; ?>" id="getexpenseform" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i> View</button>
                </td>                                
                </tr>
<?php
            }
                if($num_rows==0){
                    echo $user_id;
                    echo "<td colspan='7' align='center'>No Results or History.</td>";
                }
    }
function getAdminTable($conn){
                    
    $sql = getExpenseTableQuerySubmitter();
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);            
            while($row = mysqli_fetch_assoc($result))
            {   
                $user_id = $row['user_id'];
                $expense_reports_id= $row['expense_reports_id'];
                $submission_date = $row ['submission_date'];
                //$revieweddate = $row ['revieweddate'];
                $expensereport_status = $row ['expensereport_status'];
                $approver_id = $row['approver_id'];
?>
                <tr>
                <td><?php echo $expense_reports_id;?></td>
                <td><?php echo userName($user_id , $conn); ?></td>  
                <td><?php echo userName($approver_id, $conn); ?></td>
                <td><?php echo $submission_date;?></td>
                <td><?php 
                        if ($expensereport_status == "Approved" || $expensereport_status == "denied")
                        {
                            echo $revieweddate;
                        }
                        else
                        echo "N/A";
                    ?>
                </td>
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
                    
    $sql = getExpenseTableQuerySubmitter("pending");
            
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
                    
    $sql = getExpenseTableQuerySubmitter("saved");
            
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
                    
    $sql = getExpenseTableQuerySubmitter("processed");
            
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