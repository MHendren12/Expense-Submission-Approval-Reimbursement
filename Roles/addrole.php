<?php
    include("../Database/config.php");		 
    $conn = getConnection();
    
    
    
	 
    $roleName = $_POST['roleName'];
    $roleDesc = $_POST['roleDesc'];
    
    
    $query = 'insert into userRole (userRole_Name, userRole_Desc) values ("'.$roleName.'","'.$roleDesc.'")';
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    header("Location: ../configureroles.php?roleid=".$role_id);
?>