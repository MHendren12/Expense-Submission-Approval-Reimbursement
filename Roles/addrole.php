<?php
    include("../Database/config.php");		 
    $conn = getConnection();
    
    
    
	 
    $roleName = $_POST['roleName'];
    $roleDesc = $_POST['roleDesc'];
    
    
    $query = 'insert into userRole (userRole_Name, userRole_Desc) values ("'.$roleName.'","'.$roleDesc.'")';
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    $userRole_id = mysqli_insert_id($conn);
    
    $submit = $_POST['Submit Form'];
    

    if(!empty($_POST['permissions'])) {
        foreach($_POST['permissions'] as $permission) {
            $query = 'insert into role_permissions (permission_id, userRole_id) values ("'.$permission.'","'.$userRole_id.'")';
            mysqli_query($conn, $query); 
        }
    }
    
    header("Location: ../configureroles.php?roleid=".$role_id);
?>