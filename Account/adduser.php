<?php
    include("../Database/config.php");		 
    $conn = getConnection();
	 
	 $fname = $_POST['FName'];
	 $lname = $_POST['LName'];
	 $email  = $_POST['Email'];
	 $pass  = "password";
	 $user_activated = 0;
	 $is_admin = 0;
     $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
     $saltedPW =  $pass . $salt;
     $hashedPW = hash('sha256', $saltedPW);

  
  
	 $dobm = $_POST['DOBMonth'];
	 $dobd = $_POST['DOBDay'];
	 $doby = $_POST['DOBYear'];
	 
	 $dob='2000-01-01';
	 
	 $sql = "select * from user where user_email = '$email'";
	 $check = mysqli_query($conn, $sql);
	 $num_rows = mysqli_num_rows($check);
	 

	 if ($num_rows == 0) 
     {
         $query = 'insert into user (user_fname, user_lname, user_email, user_pass, salt, user_dob, is_admin, user_activated) values ("'.$fname.'", "'.$lname.'", "'.$email.'", "'.$hashedPW.'","'.$salt.'","'.$dob.'", "'.$is_admin.'", "'.$user_activated.'")';
         $insert = mysqli_query($conn, $query);
         if(!$insert)
         {
             die("Error: " . mysqli_error($conn) );
         }
         else
         {
             header("Location: ../userlist.php");
         }
     }
?>