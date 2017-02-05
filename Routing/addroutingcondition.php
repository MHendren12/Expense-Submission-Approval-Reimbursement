<?php
    include("../Database/config.php");		 
    $conn = getConnection();
    
    
    
	 
    $conditionId = $_POST['userSearchBox'];
    echo $conditionId;
    
    $query = 'insert into routingCondition (routingConditionType, routingConditionType_id) values ("user","'.$conditionId.'")';
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    header("Location: ../home.php");
?>