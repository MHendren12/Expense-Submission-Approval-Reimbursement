<?php

    session_start();
    include("../Database/config.php");
    $conn = getConnection();
    $id = $_SESSION['userid'];
    
    
    if( $_GET['val'] )  
    {
        switch ($_GET['val']) {
            case comparePasswords:
                return comparePasswords($_GET['pass'], $id, $conn);
                break;
            default:
                break;
        }
    }
    
    function comparePasswords($pass, $uid, $conn)
    {
        $sql = "select salt from user where user_id = '".$uid."'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$num_rows = mysqli_num_rows($result);
		if ($num_rows > 0)
		{
		    
    		$salt= $row['salt'];
            $saltedPW =  $pass . $salt;
            
            $hashedPW = hash('sha256', $saltedPW);
    		$sql = "select * from user where user_pass='".$hashedPW."' and user_id='".$uid."'";
    		$result = mysqli_query($conn, $sql);
    		$num_rows = mysqli_num_rows($result);
    		echo $num_rows;
    		if ($num_rows >= 1)
    		    echo true;
    		else
    		    echo false;
		}

    }
    
?>