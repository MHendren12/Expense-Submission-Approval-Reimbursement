<?php
    include("../Database/config.php");		 
    $conn = getConnection();
	 
    $levelName = $_POST['levelname'];
    $levelId = $_POST['headerId'];
    
    $query = 'update routingLevels set routingLevel_name= "'.$levelName.'" where routingLevel_id = "'.$levelId.'"';
    $result = mysqli_query($conn, $query);
    header("Location: ../home.php#routing");
?>