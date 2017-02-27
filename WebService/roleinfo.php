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
            case getPermissionsForRole:
                $sql = "select permissions.permission_Name from role_permissions join permissions on permissions.permission_id = role_permissions.permission_id  where userRole_id ='".$_POST['roleid']."'";
                $res = mysqli_query($conn,$sql);
                $rolePermissions = '[';
                $num_rows = mysqli_num_rows($res);
                $i = 0;
                while($row = mysqli_fetch_assoc($res))
                {
                    $rolePermissions .= '{"permission": "'.$row['permission_Name'].'"}';
                    $i++;
                    if ($i != $num_rows)
                        $rolePermissions .=',';
                }
                $rolePermissions .= ']';
                echo $rolePermissions;
                
                break;
            default:
                break;
        }
    }
    