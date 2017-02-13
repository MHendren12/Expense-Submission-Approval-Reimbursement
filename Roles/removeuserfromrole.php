<?php
    include("../Database/config.php");		 
    $conn = getConnection();
	 
    $userid = $_GET['user'];
    $role_id = $_GET['role'];

    
    
    $query = 'select * from user where user_id = "'.$userid.'"';
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $num_rows = mysqli_num_rows($res);
    
    if ($num_rows == 1) 
    {
        $query = 'delete from  userAssignment where userRole_id  =  "'.$role_id.'" and user_id = "'.$userid.'"';
        $insert = mysqli_query($conn, $query);
        if(!$insert)
        {
            die("Error: " . mysqli_error($conn) );
        }
        else
        {
            header("Location: ../configureroles.php?roleid=".$role_id);
        }
    }
?>