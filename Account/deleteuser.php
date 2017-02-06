<?php

session_start();
	
    include("../Database/config.php");		 
    $conn = getConnection();
        
    $user  = $_GET['userid'];
    
    $sql = 'select * from user where user_id = "'.$user.'"';
    $result = mysqli_query($conn,$sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows == 1)
    {
        $deleteQuery = 'delete from user where user_id ='.$user;
        mysqli_query($conn, $deleteQuery);
        
    }
    
    header("Location: ../userlist.php");
    
?>