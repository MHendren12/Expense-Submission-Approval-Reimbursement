<?php

session_start();
	
    include("../Database/config.php");		 
    $conn = getConnection();
        
    $row  = $_POST['rowId2'];
    
    $sql = 'select * from routingCondition where routingCondition_id = "'.$row.'"';
    $result = mysqli_query($conn,$sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows == 1)
    {
        $deleteRC = 'delete from routingCondition where routingCondition_id ='.$row;
        mysqli_query($conn, $deleteRC);
        $deleteR = 'delete from routing where routingRow_id ='.$row;
        mysqli_query($conn, $deleteR);
    }
    
    header("Location: ../home.php#routing");
    
?>