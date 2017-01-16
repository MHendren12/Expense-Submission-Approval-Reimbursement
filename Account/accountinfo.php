<?php

session_start();
	
    include("../Database/config.php");		 
    $conn = getConnection();
    $id = $_SESSION['userid'];
    
    if( $_GET['val'] )  
    {
        switch ($_GET['val']) {
            case comparePasswords:
                echo comparePasswords($_GET['pass']);
                break;
            default:
                break;
        }
    }
    
    function comparePasswords($pass)
    {
        $sql = "select salt from user where user_id = '".$id."'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$salt= $row['salt'];
        $saltedPW =  $pass . $salt;
        $hashedPW = hash('sha256', $saltedPW);
        
		$sql = "select * from user where user_pass='".$hashedPW."' and user_id='".$id."'";
		$result = mysqli_query($conn, $sql);
		$num_rows = mysqli_num_rows($check);
		
		if (num_rows >= 1)
		    echo true;
		else
		    echo false;

    }
    
?>