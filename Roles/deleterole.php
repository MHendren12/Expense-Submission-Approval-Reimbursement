<?php
    include("../Database/config.php");		 
    $conn = getConnection();
	 
    $roleId = $_GET['roleid'];

    $query = 'select * from userRole where userRole_id = "'.$roleId.'"';
    $res = mysqli_query($conn, $query);
    $num_rows = mysqli_num_rows($res);
    
    if ($num_rows > 0) 
    {
        $query = 'delete from userRole where userRole_id = "'.$roleId.'"';
        mysqli_query($conn, $query);
        
        $query = 'delete from userAssignment where userRole_id = "'.$roleId.'"';
        mysqli_query($conn, $query);
    }
    
    header("Location: ../userroles.php")
    
?>