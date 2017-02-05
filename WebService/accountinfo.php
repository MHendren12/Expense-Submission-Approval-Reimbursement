<?php

    session_start();
    include("Database/config.php");
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
    
    
    
?>