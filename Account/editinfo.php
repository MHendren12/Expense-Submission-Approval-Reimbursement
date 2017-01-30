<?php

session_start();
	
    include("../Database/config.php");		 
    $conn = getConnection();
	$id = $_SESSION['userid'];
    
    if(isset($_POST['submit'])) 
    {
    
        $fname  = explode(" ",$_POST['name'])[0];
        $lname = explode(" ",$_POST['name'])[1];
        $email  = $_POST['email'];
        $dob  = $_POST['dob'];
        $pass  = $_POST['newPassword'];
        if($_GET['id'] != null){
    	    $id = $_GET['id'];
    	    $sql = "select * from user where user_pass = '".$id."'";
            $result = mysqli_query($conn,$sql);
            $row=$result->fetch_object();

            $user['user_fname'] = $row->user_fname;
            $user['user_lname'] = $row->user_lname;
            
            $fname = $user['user_fname'];
            $lname = $user['user_lname'];
	    }
        if ($pass)
        {
             $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
             $saltedPW =  $pass . $salt;
             $hashedPW = hash('sha256', $saltedPW);
             
            $sql = "update user set user_fname='".$fname."',  user_lname='".$lname."', user_pass='".$hashedPW."', salt='".$salt."', user_dob='".$dob."' where user_id='".$id."'";
            $res = mysqli_query($conn, $sql)
                or die(err);
        }
        else
        {
            $sql = "update user set user_fname='".$fname."',  user_lname='".$lname."', user_dob='".$dob."' where user_id='".$id."'";
            $res = mysqli_query($conn, $sql)
                or die(mysqli_error($conn));
        }
        if($_GET['id'] != null){
            header("Location: ../index.php");
        } else{
            header("Location: ../account.php");
        }   
        
    }
        
?>