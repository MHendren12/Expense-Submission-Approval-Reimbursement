<?php
    include("../Database/config.php");		 
    $conn = getConnection();
    
    
    
	$roleId = $_GET['roleId'];
    $userRole_Name = $_POST['userRole_Name'];
    $userRole_Desc = $_POST['userRole_Desc'];
    
    $updateRole = 'update userRole set userRole_Name = "'.$userRole_Name.'", userRole_Desc = "'.$userRole_Desc.'" where userRole_id = "'.$roleId.'" ';
    mysqli_query($conn, $updateRole) or die(mysqli_error($conn));
    
    
    $query = 'select * from role_permissions where userRole_id = "'.$roleId.'" ';
    $permissions = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $num_rows = mysqli_num_rows($permissions);
    if ($num_rows != 0)
    {
        $query = 'delete from role_permissions where userRole_id = "'.$roleId.'" ';
        mysqli_query($conn, $query) or die(mysqli_error($conn));
    }
    if(!empty($_POST['permissions'])) {
        foreach($_POST['permissions'] as $permission) {
            echo $permission;
            $query = 'insert into role_permissions (permission_id, userRole_id) values ("'.$permission.'","'.$roleId.'")';
            mysqli_query($conn, $query); 
        }
    }
    header("Location: ../configureroles.php?roleid=".$role_id);
    /*
    $query = 'insert into userRole (userRole_Name, userRole_Desc) values ("'.$roleName.'","'.$roleDesc.'")';
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    $userRole_id = mysqli_insert_id($conn);
    
    $submit = $_POST['Submit Form'];
    

    
    
    
    */
?>