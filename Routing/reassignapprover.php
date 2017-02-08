<?php

session_start();
	
    include("../Database/config.php");		 
    $conn = getConnection();
        
    $row  = $_POST['rowId3'];
    $col  = $_POST['colId'];
    $user  = $_POST['userSearchBox'];
    
    $sql = 'select * from routing where routingRow_id = "'.$row.'" and routingColumn_id="'.$col.'"';
    $result = mysqli_query($conn,$sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0)
    {
        $updateApprover = 'update routing set routingUser_id ="'.$user.'" where routingRow_id = "'.$row.'" and routingColumn_id="'.$col.'"';
        mysqli_query($conn, $updateApprover);
    }
    else
    {
        $insertApprover = 'insert into routing (routingRow_id, routingColumn_id, routingUser_id) values ("'.$row.'","'.$col.'","'.$user.'")';
        mysqli_query($conn, $insertApprover);
    }
    
    header("Location: ../home.php");
    
?>