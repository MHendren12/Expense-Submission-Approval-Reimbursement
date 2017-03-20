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
    function getExpenseTableQueryAdmin($status = "null"){
        $expenseTableQuery = "select user.user_id, expense_reports.approver_id, expense_reports.submitter_id,expense_reports.submission_date,
                                expense_reports.expense_reports_id, expense_reports.expensereport_status
                                from expense_reports
                                left join user on user.user_id = expense_reports.submitter_id";
        if ($status != "null")
        {
            if ($status == "Processed")
            {
                $expenseTableQuery .= "and (expense_reports.expensereport_status = 'Approved' or expense_reports.expensereport_status = 'Denied') ";
                
            }
            else
            {
                $expenseTableQuery .= "and expense_reports.expensereport_status='".$status."'";
            }
            
        }
        $expenseTableQuery .= " order by submission_date DESC";
        
        return $expenseTableQuery;
    }
    
    
    function getExpenseTableQuerySandA($status = "null"){
        $expenseTableQuerySubmitter = "select user.user_id, expense_reports.approver_id, expense_reports.submitter_id,expense_reports.submission_date,
                                expense_reports.expense_reports_id, expense_reports.expensereport_status
                                from expense_reports
                                left join user on user.user_id = expense_reports.submitter_id
                                where submitter_id = '".$_SESSION['userid']."'";
         $expenseTableQueryApprover = "select user.user_id, expense_reports.approver_id, expense_reports.submitter_id,expense_reports.submission_date,
                                expense_reports.expense_reports_id, expense_reports.expensereport_status
                                from expense_reports
                                left join user on user.user_id = expense_reports.approver_id
                                where approver_id = '".$_SESSION['userid']."'";
                                
        if ($status != "null")
        {
            if ($status == "Processed")
            {
                $expenseTableQuerySubmitter .= "and (expense_reports.expensereport_status = 'Approved' or expense_reports.expensereport_status = 'Denied') ";
                $expenseTableQueryApprover .= "and (expense_reports.expensereport_status = 'Approved' or expense_reports.expensereport_status = 'Denied') ";
            }
            else
            {
                $expenseTableQuerySubmitter .= "and expense_reports.expensereport_status='".$status."'";
                $expenseTableQueryApprover .= "and expense_reports.expensereport_status='".$status."'";
            }
            
        }
        
        $expenseTableQuery = $expenseTableQuerySubmitter . 'union ' . $expenseTableQueryApprover;
        $expenseTableQuery .= " order by submission_date DESC";
        
        return $expenseTableQuery;
    }
        
        
    function getExpenseTableQuerySubmitter($status = "null"){
        $expenseTableQuery = "select user.user_id, expense_reports.approver_id, expense_reports.submitter_id,expense_reports.submission_date,
                                expense_reports.expense_reports_id, expense_reports.expensereport_status
                                from expense_reports
                                left join user on user.user_id = expense_reports.submitter_id
                                where submitter_id = '".$_SESSION['userid']."'";
        if ($status != "null")
        {
            if ($status == "Processed")
            {
                $expenseTableQuery .= "and (expense_reports.expensereport_status = 'Approved' or expense_reports.expensereport_status = 'Denied') ";
            }
            else
            {
                $expenseTableQuery .= "and expense_reports.expensereport_status='".$status."'";
            }
        }
            
            
        $expenseTableQuery .= "order by expense_reports.submission_date DESC";
                                

        return $expenseTableQuery;
    }
    function getExpenseTableQueryApprover($status = "null"){
        $expenseTableQuery = "select expense_reports.expense_reports_id, expensereport_history.reviewer_id, expense_reports.approver_id, expense_reports.submitter_id,
                                expense_reports.submission_date, expense_reports.expensereport_status
                                from expense_reports
                                left join expensereport_history on expense_reports.expense_reports_id = expensereport_history.expense_reports_id
                                where reviewer_id = '".$_SESSION['userid']."'";
                                
                                
        if ($status != "null")
        {
            if ($status == "Processed")
            {
                $expenseTableQuery .= "and (expense_reports.expensereport_status = 'Approved' or expense_reports.expensereport_status = 'Denied') ";
            }
            else
            {
                $expenseTableQuery .= "and expense_reports.expensereport_status='".$status."'";
            }
        }
        $expenseTableQuery .= "order by expense_reports.submission_date DESC"; 

        return $expenseTableQuery;
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
        $sql = "SELECT userRole_id FROM user left join userAssignment on user.user_id=userAssignment.user_id WHERE user.user_id='" .$user_id. "'";
        $result = mysqli_query($conn, $sql);
        $ids = [];
        while($row = mysqli_fetch_assoc($result))
        {
            array_push($ids, $row['userRole_id']);
        }
        if(in_array (2, $ids)  && in_array (3,$ids) ){
            return true;
        }
        else{
            return false;
        }
    }
    
    function getApprovalDate($user_id, $conn){
    $sql = "select * from expense_reports left join expensereport_history on expense_reports.expense_reports_id=expensereport_history.expense_reports_id 
    where expensereport_history.action = 'Approved' and expensereport_history.reviewer_id = ". $user_id; 
             $result = mysqli_query($conn, $sql);
             $num_rows = mysqli_num_rows($result);           
            while($row = mysqli_fetch_assoc($result))
            {
                $revieweddate=$row['revieweddate'];
                $dataDate = strtotime($revieweddate);
                $dataDate =  date("Y-m-d", $dataDate);
                echo '<script>$("#'.$dataDate.'").addClass("approved").find(".approve-'.$dataDate.'").removeClass("hidden");
                      </script>';
            }
            
    }
    
    function getSubmittedDate($user_id, $conn){
    $sql = "select * from expense_reports left join expensereport_history on expense_reports.expense_reports_id = expensereport_history.expense_reports_id
        where expensereport_history.action = 'Submit' and reviewer_id = '".$user_id."'";
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result); 
            while($row = mysqli_fetch_assoc($result))
            {
                $submission_date=$row['submission_date'];
                $revieweddate=$row['revieweddate'];
                $expense_reports_id=$row['expense_reports_id'];
                $expensereport_status = $row['expensereport_status'];
                $dataDate = strtotime($submission_date);
                $dataDate =  date("Y-m-d", $dataDate);
                
                echo '<script>$("#'.$dataDate.'").addClass("submitted").find(".submit-'.$dataDate.'").removeClass("hidden");
                  </script>';
            }
            
    }
    
    function getFinalApprovalDate($user_id, $conn){
        $sql = "select * from expense_reports left join expensereport_history on expense_reports.expense_reports_id = expensereport_history.expense_reports_id 
        where expense_reports.expensereport_status = 'Approved' and expensereport_history.reviewer_id = ". $user_id;
             $result = mysqli_query($conn, $sql);
             $num_rows = mysqli_num_rows($result);           
            while($row = mysqli_fetch_assoc($result))
            {
                $submission_date=$row['submission_date'];
                $revieweddate = $row['revieweddate'];
                $action = $row['action'];
                $dataDate = strtotime($revieweddate);
                $dataDate =  date("Y-m-d", $dataDate);
                if($action=="Final Approved"){
                    echo '<script>$("#'.$dataDate.'").addClass("finalapproved").find(".finalapprove-'.$dataDate.'").removeClass("hidden");
                        $(".submitted.finalapproved").find(".S-Time").removeClass("hidden");
                     </script>';
                }
            }        
    }
    function getDeniedDate($user_id, $conn){
    $sql = "select * from expense_reports left join expensereport_history on expense_reports.expense_reports_id = expensereport_history.expense_reports_id 
        where (expensereport_history.action = 'Denied' or (expensereport_history.action = 'Submit' and expense_reports.expensereport_status = 'Denied')) and expensereport_history.reviewer_id = ". $user_id;
             $result = mysqli_query($conn, $sql);
             $num_rows = mysqli_num_rows($result);           
            while($row = mysqli_fetch_assoc($result))
            {
                $submission_date=$row['submission_date'];
                $revieweddate = $row['revieweddate'];
                $dataDate = strtotime($revieweddate);
                $dataDate =  date("Y-m-d", $dataDate);
                echo '<script>$("#'.$dataDate.'").addClass("denied").find(".denied-'.$dataDate.'").removeClass("hidden");
                        $(".submitted.denied").find(".D-Time").removeClass("hidden");
                      </script>';
            }        
    }
    
    function getCalendarSubmitterInfo($user_id, $conn){
        getSubmittedDate($user_id, $conn);
        $sql = "select * from expense_reports left join expensereport_history on expense_reports.expense_reports_id = expensereport_history.expense_reports_id 
        where expensereport_history.action = 'Submit' and reviewer_id = '".$user_id."'";
        $result = mysqli_query($conn, $sql);
        $submitInfo = "<table class='table table-striped table-bordered' style='text-align:center'> <tr><th >Expense-ID:</th> <th>Time:</th><th>View</th></tr>";
            while($row = mysqli_fetch_assoc($result))
            {
                $expense_reports_id=$row['expense_reports_id'];
                $submission_date=$row['submission_date'];
                $revieweddate=$row['revieweddate'];
                $dataDate = strtotime($revieweddate);
                $dataDate =  date("H:i:s", $dataDate);
                $submitInfo .= " <tr class='submit-".$revieweddate." hidden'> <td>". $expense_reports_id . "</td> <td>".$dataDate."</td>
                <td><button data-toggle='modal' onclick='$(&quot;.submitter&quot;).popover(&quot;hide&quot;);' data-target='#view-modal' data-id='".$expense_reports_id."' id='getexpenseform' class='btn btn-sm btn-info'><i class='glyphicon glyphicon-eye-open'></i> View</button></td></tr>";
            }
            $submitInfo .= "</table>";
            echo $submitInfo;
    }
    
    function getCalendarApprovedInfo($user_id, $conn){
        getApprovalDate($user_id, $conn);
        $sql = "select * from expense_reports left join expensereport_history on expense_reports.expense_reports_id = expensereport_history.expense_reports_id 
        where expensereport_history.action = 'Approved' and expensereport_history.reviewer_id = ". $user_id;
        $result = mysqli_query($conn, $sql);
        $approveInfo = "<table class='table table-striped table-bordered' style='text-align:center'> <tr><th>Expense-ID:</th><th>Time:</th><th>View</th></tr>";
             while($row = mysqli_fetch_assoc($result))
            {
                $expense_reports_id=$row['expense_reports_id'];
                $revieweddate=$row['revieweddate'];
                $reviewer_id = $row['reviewer_id'];
                $dataDate = strtotime($revieweddate);
                $dataDate =  date("H:i:s", $dataDate);
                $approveInfo .= "<tr class='approve-".$revieweddate." hidden'> <td>". $expense_reports_id . "</td> <td>".$dataDate."</td>
                <td><button data-toggle='modal' data-target='#view-modal' onclick='$(&quot;.approver&quot;).popover(&quot;hide&quot;);' data-id='".$expense_reports_id."' id='getexpenseform' class='btn btn-sm btn-info'><i class='glyphicon glyphicon-eye-open'></i> View</button></td></tr>";
            }
        $approveInfo .= "</table>";
        echo $approveInfo;
    }    

    function getCalendarFinalApprovedInfo($user_id, $conn){
        getFinalApprovalDate($user_id, $conn);
        $sql = "select * from expense_reports left join expensereport_history on expense_reports.expense_reports_id = expensereport_history.expense_reports_id 
        where expense_reports.expensereport_status = 'Approved' and expensereport_history.reviewer_id = ". $user_id;
        $result = mysqli_query($conn, $sql);
        $finalapproveInfo = "<table class='table table-striped table-bordered' style='text-align:center'> <tr><th>Expense-ID:</th> <th class='S-Time hidden'>Submit Time:</th> <th>Status:</th> <th>Time:</th> <th>View</th></tr>";
             while($row = mysqli_fetch_assoc($result))
            {
                $expense_reports_id=$row['expense_reports_id'];
                $revieweddate=$row['revieweddate'];
                $reviewer_id = $row['reviewer_id'];
                $submission_date = $row['submission_date'];
                $action = $row['action'];
                $dataDate = strtotime($revieweddate);
                $dataDate =  date("H:i:s", $dataDate);
                if($action=="Submit"){
                    $dataTime=$dataDate;
                }
                $finalapproveInfo .= "<tr class='finalapprove-".$revieweddate." hidden'> <td>". $expense_reports_id . "</td><td class='S-Time hidden'>".$dataTime."</td><td>Approved</td><td>".$dataDate."</td>
                <td><button data-toggle='modal' onclick='$(&quot;.finalapprover&quot;).popover(&quot;hide&quot;);' data-target='#view-modal' data-id='".$expense_reports_id."' id='getexpenseform' class='btn btn-sm btn-info'><i class='glyphicon glyphicon-eye-open'></i> View</button></td></tr>";
            }
            $finalapproveInfo .= "</table>";
            echo $finalapproveInfo;
    }
    
    function getCalendarDeniedInfo($user_id, $conn){
        getDeniedDate($user_id, $conn);
        $sql = "select * from expense_reports left join expensereport_history on expense_reports.expense_reports_id = expensereport_history.expense_reports_id 
        where (expensereport_history.action = 'Denied' or (expensereport_history.action = 'Submit' and expense_reports.expensereport_status = 'Denied')) and expensereport_history.reviewer_id = ". $user_id;
        $result = mysqli_query($conn, $sql);
        $finalapproveInfo = "<table class='table table-striped table-bordered' style='text-align:center'> <tr><th>Expense-ID:</th> <th class='D-Time hidden'>Submit Time:</th> <th>Status:</th><th>Time:</th><th>View</th></tr>";
             while($row = mysqli_fetch_assoc($result))
            {
                $expense_reports_id=$row['expense_reports_id'];
                $revieweddate=$row['revieweddate'];
                $reviewer_id = $row['reviewer_id'];
                $submission_date = $row['submission_date'];
                $action = $row['action'];                
                $dataDate = strtotime($revieweddate);
                $dataDate =  date("H:i:s", $dataDate);
                if($action=="Submit"){
                    $dataTime=$dataDate;
                }                
                $finalapproveInfo .= "<tr class='denied-".$revieweddate." hidden'> <td>". $expense_reports_id . "</td><td class='D-Time hidden'>".$dataTime."</td><td>Denied</td><td>".$dataDate."</td>
                <td><button data-toggle='modal' data-target='#view-modal' onclick='$(&quot;.denier&quot;).popover(&quot;hide&quot;);' data-id='".$expense_reports_id."' id='getexpenseform' class='btn btn-sm btn-info'><i class='glyphicon glyphicon-eye-open'></i> View</button></td></tr>";
            }
            $finalapproveInfo .= "</table>";
            echo $finalapproveInfo;
    }     
    
    function getApproverTable($user_id, $conn, $status = "null"){
                    
    $sql = getExpenseTableQueryApprover($status);
            
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);            
            while($row = mysqli_fetch_assoc($result))
            {   
                $submitter_id = $row['submitter_id'];
                $expense_reports_id= $row['expense_reports_id'];
                $submission_date = $row ['submission_date'];
                //$revieweddate = $row ['revieweddate'];
                $expensereport_status = $row ['expensereport_status'];
                $approver_id = $row['approver_id'];
?>
                <tr>
                <td><?php echo $expense_reports_id;?></td>
                <td><?php echo userName($submitter_id , $conn); ?></td>  
                <td><?php echo userName($approver_id, $conn); ?></td>
                <td><?php echo $submission_date;?></td>
                <td><?php 
                        $getApprovedDate = "select max(revieweddate) as revieweddate, expensereport_status from expense_reports 
                        left join expensereport_history on expensereport_history.expense_reports_id = expense_reports.expense_reports_id
                        where expense_reports.expense_reports_id ='".$expense_reports_id."' and  (expensereport_status = 'Approved' or  expensereport_status = 'Denied') ";
                        $ApprovedDate = mysqli_query($conn, $getApprovedDate);
                        $row = mysqli_fetch_assoc($ApprovedDate);
                        $status = $row['expensereport_status'];
                        $revieweddate = $row['revieweddate'];
                        if ($status == "Approved" || $status == "Denied")
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
    
    function getSubmitterTable($user_id, $conn, $status = "null"){

    $sql = getExpenseTableQuerySubmitter($status);
            
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);           
            while($row = mysqli_fetch_assoc($result))
            {   
                $submitter_id = $row['submitter_id'];
                $expense_reports_id= $row['expense_reports_id'];
                $submission_date = $row ['submission_date'];
                //$revieweddate = $row ['revieweddate'];
                $expensereport_status = $row ['expensereport_status'];
                $approver_id = $row['approver_id'];
?>
                <tr>
                <td><?php echo $expense_reports_id;?></td>
                <td><?php echo userName($submitter_id , $conn); ?></td>  
                <td><?php echo userName($approver_id, $conn); ?></td>
                <td><?php echo $submission_date;?></td>
                <td><?php 
                        $getApprovedDate = "select max(revieweddate) as revieweddate, expensereport_status from expense_reports 
                        left join expensereport_history on expensereport_history.expense_reports_id = expense_reports.expense_reports_id
                        where expense_reports.expense_reports_id ='".$expense_reports_id."' and  (expensereport_status = 'Approved' or  expensereport_status = 'Denied') ";
                        $ApprovedDate = mysqli_query($conn, $getApprovedDate);
                        $row = mysqli_fetch_assoc($ApprovedDate);
                        $status = $row['expensereport_status'];
                        $revieweddate = $row['revieweddate'];
                        if ($status == "Approved" || $status == "Denied")
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
    function getSandATable($user_id, $conn, $status = "null"){

    $sql = getExpenseTableQuerySandA($status);
            
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);           
            while($row = mysqli_fetch_assoc($result))
            {   
                $submitter_id = $row['submitter_id'];
                $expense_reports_id= $row['expense_reports_id'];
                $submission_date = $row ['submission_date'];
                //$revieweddate = $row ['revieweddate'];
                $expensereport_status = $row ['expensereport_status'];
                $approver_id = $row['approver_id'];
?>
                <tr>
                <td><?php echo $expense_reports_id;?></td>
                <td><?php echo userName($submitter_id , $conn); ?></td>  
                <td><?php echo userName($approver_id, $conn); ?></td>
                <td><?php echo $submission_date;?></td>
                <td><?php 
                        $getApprovedDate = "select max(revieweddate) as revieweddate, expensereport_status from expense_reports 
                        left join expensereport_history on expensereport_history.expense_reports_id = expense_reports.expense_reports_id
                        where expense_reports.expense_reports_id ='".$expense_reports_id."' and  (expensereport_status = 'Approved' or  expensereport_status = 'Denied') ";
                        $ApprovedDate = mysqli_query($conn, $getApprovedDate);
                        $row = mysqli_fetch_assoc($ApprovedDate);
                        $status = $row['expensereport_status'];
                        $revieweddate = $row['revieweddate'];
                        if ($status == "Approved" || $status == "Denied")
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
function getAdminTable($conn, $status = "null"){
                    
    $sql = getExpenseTableQueryAdmin($status = "null");
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);            
            while($row = mysqli_fetch_assoc($result))
            {   
                $submitter_id = $row['submitter_id'];
                $expense_reports_id= $row['expense_reports_id'];
                $submission_date = $row ['submission_date'];
                //$revieweddate = $row ['revieweddate'];
                $expensereport_status = $row ['expensereport_status'];
                $approver_id = $row['approver_id'];
?>
                <tr>
                <td><?php echo $expense_reports_id;?></td>
                <td><?php echo userName($submitter_id , $conn); ?></td>  
                <td><?php echo userName($approver_id, $conn); ?></td>
                <td><?php echo $submission_date;?></td>
                <td><?php 
                        $getApprovedDate = "select max(revieweddate) as revieweddate, expensereport_status from expense_reports 
                        left join expensereport_history on expensereport_history.expense_reports_id = expense_reports.expense_reports_id
                        where expense_reports.expense_reports_id ='".$expense_reports_id."' and  (expensereport_status = 'Approved' or  expensereport_status = 'Denied') ";
                        $ApprovedDate = mysqli_query($conn, $getApprovedDate);
                        $row = mysqli_fetch_assoc($ApprovedDate);
                        $status = $row['expensereport_status'];
                        $revieweddate = $row['revieweddate'];
                        if ($status == "Approved" || $status == "Denied")
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
                    
    $sql = getExpenseTableQuerySubmitter("Pending");
            
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
                    
    $sql = getExpenseTableQuerySubmitter("Saved");
            
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
        $sql = "select * from expense_reports 
        left join expensereport_history on expense_reports.expense_reports_id = expensereport_history.expense_reports_id
        where (expense_reports.expensereport_status='Approved' or expense_reports.expensereport_status='Denied' or expensereport_history.action='Approved' or expense_reports.expensereport_status='Denied') and expensereport_history.reviewer_id = ".$user_id;
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        return $num_rows != 0;
        
        /*
        while($row = mysqli_fetch_assoc($result))
        {
            $expensereport_status=$row['expensereport_status'];
            
            if($expensereport_status=="Submit"){
        
                $sql = getExpenseTableQuerySubmitter("Processed");
                    
                    $result = mysqli_query($conn, $sql);
                                
                    $num_rows = mysqli_num_rows($result);
                      if($num_rows == 0){
                        return false;
                    }
                    else{
                        return true;
                    }
            }
                
            else if($expensereport_status=="Approved"){ 
                $sql = getExpenseTableQueryApprover("Processed");
                    
                    $result = mysqli_query($conn, $sql);
                                
                    $num_rows = mysqli_num_rows($result);
                      if($num_rows == 0){
                        return false;
                    }
                    else{
                        return true;
                    }
            }
            
        }
*/
    }
    
    
?>