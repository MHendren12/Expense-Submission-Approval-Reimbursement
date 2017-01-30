<?php
    include("../Database/config.php");		 
    $conn = getConnection();
	 
    $userid = $_POST['userSearchBox'];
    $role_id = $_POST['roleId'];
    echo $role_id;
    $query = 'select * from user where user_id = "'.$userid.'"';
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $num_rows = mysqli_num_rows($res);
    
    if ($num_rows == 1) 
    {
        $query = 'insert into userAssignment (userRole_id, user_id) values ("'.$role_id.'","'.$userid.'")';
        $insert = mysqli_query($conn, $query);
        if(!$insert)
        {
            die("Error: " . mysqli_error($conn) );
        }
        else
        {
            //header("Location: ../configureroles.php?roleid=".$role_id);
        }
    }
?>