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
    
    
    
    /*
    
    select user.user_id, expense_reports.approver_id, expense_reports.submitter_id,expense_reports.submission_date, 
                                expense_reports.expense_reports_id, expense_reports.expensereport_status
                                from expense_reports
                                join user on user.user_id = expense_reports.submitter_id
                                where submitter_id = 8
                                union
select user.user_id, expense_reports.approver_id, expense_reports.submitter_id,expense_reports.submission_date, 
                                expense_reports.expense_reports_id, expense_reports.expensereport_status
                                from expense_reports
                                join user on user.user_id = expense_reports.submitter_id
                                where approver_id = 8
                                
    
    */
    
    
    

?>