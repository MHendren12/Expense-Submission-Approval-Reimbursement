<?php
    include("../Database/config.php");		 
    $conn = getConnection();
	 
    $approverId = $_POST['userSearchBox'];
    $routingConditionId = $_POST['rowId'];
    
    $query = 'select max(routingColumn_id) as routingColumn_id from routing where routingRow_id="'.$routingConditionId.'"';
    $result = mysqli_query($conn, $query);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows == 0)
    {
        $col = 1;
    }
    else
    {
        $row = mysqli_fetch_assoc($result);
        $col = $row['routingColumn_id'] + 1;
    }
    $query = 'insert into routing (routingRow_id, routingColumn_id, routingUser_id) values ("'.$routingConditionId.'","'.$col.'","'.$approverId.'")';
    mysqli_query($conn, $query) or die(mysqli_error($conn));
    header("Location: ../home.php");
?>