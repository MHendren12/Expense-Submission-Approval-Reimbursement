<?php
    include("../Database/config.php");		 
    $conn = getConnection();
    
    $conditionId = $_POST['userSearchBox'];
    $query = 'insert into routingCondition (routingConditionType, routingConditionType_id) values ("user","'.$conditionId.'")';
    mysqli_query($conn, $query);
    $routingConditionId = mysqli_insert_id($conn);
    
    for ($i=1; $i<6; $i++)
    {
        $query = 'insert into routing (routingRow_id, routingColumn_id) values ("'.$routingConditionId.'","'.$i.'")';
        mysqli_query($conn, $query);
    }
    header("Location: ../home.php");
?>