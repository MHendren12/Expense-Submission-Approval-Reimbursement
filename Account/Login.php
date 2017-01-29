<?php 
    session_start();
	
    include("../Database/config.php");		 
    $conn = getConnection();
	 
    
    if(isset($_POST['submit'])) 
    {
    
        $email  = $_POST['Email'];
        $pass  = $_POST['Password'];
        $saltQuery = "select salt, user_activated from user where user_email = '".$email."' ";
        $result = mysqli_query($conn, $saltQuery);
        $row = mysqli_fetch_assoc($result);
        $salt = $row['salt'];
        $user_activated = $row['user_activated'];
        $saltedPW =  $pass . $salt;
        $hashedPW = hash('sha256', $saltedPW);
        
        $checklogin = "select * from user where user_email = '".$email."' and user_pass = '".$hashedPW."'";
        $res = mysqli_query($conn, $checklogin);
    
        if(!$res)
        {
            die(mysqli_error($res));
        }
        $num_rows = mysqli_num_rows($res);

        if($num_rows == 1 && $user_activated == 1) 
        {
            $id = "select user_id from user where user_email = '".$email."'";
            $res = mysqli_query($conn, $checklogin);
        
            if ($num_rows == 1) 
            {
                while($row = $res->fetch_assoc()) 
                {
                    $_SESSION['userid'] = $row["user_id"];
                }
            }
        
            $first = "select user_fname,user_lname from user where user_email = '".$email."'";
            $res = mysqli_query($conn, $first);
            if ($num_rows == 1) 
            {
                while($row = $res->fetch_assoc()) 
                {
                    $fname = $row["user_fname"];
                    $lname = $row["user_lname"];
                }
            }
            $name = $fname. ' ' .$lname;
            $_SESSION['name'] = $name;
        
        
            $_SESSION['is_logged_in'] = true;
            header("Location: ../home.php");
        }
        else if ($user_activated == 0 && $user_activated != null && $num_rows == 1 ){
            $id = "select user_id from user where user_email = '".$email."'";
            $res = mysqli_query($conn, $checklogin);
            
            if ($num_rows == 1) 
            {
                while($row = $res->fetch_assoc()) 
                {
                    $_SESSION['userid'] = $row["user_id"];
                }
            }
            
            $_SESSION['is_logged_in'] = true;
            header("Location: sendEmail.php");
            
        }
        else 
        {
            header("Location: ../index.php");
        } 
	}
?>	