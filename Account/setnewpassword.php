<?php

	session_start();
	
    include("../Database/config.php");		 
    $conn = getConnection();
	$id = $_GET['editUser'] != "" ? $_GET['editUser'] :  $_SESSION['userid'];
	$redirectUrl =  "../index.php";
    
    $pass  = $_POST['newPassword'];
    $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
    $saltedPW =  $pass . $salt;
    $hashedPW = hash('sha256', $saltedPW);
    $query = 'update user set user_pass = "'.$hashedPW.'", salt =  "'.$salt.'" where user_id = "'.$id.'" ';
    $update = mysqli_query($conn, $query);
    
    
    if($_GET['id'] != null){
        header("Location: ../index.php");
    } else{
        header("Location: ".$redirectUrl);
        
    }
        
?>