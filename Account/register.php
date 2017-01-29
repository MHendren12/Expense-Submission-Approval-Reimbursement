<?php
    include("../Database/config.php");		 
    $conn = getConnection();
	 
	 $fname = $_POST['FName'];
	 $lname = $_POST['LName'];
	 $email  = $_POST['Email'];
	 $pass  = $_POST['Password'];
	 $pass2 = $_POST['ConfirmPassword'];
     $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
     $saltedPW =  $pass . $salt;
     $hashedPW = hash('sha256', $saltedPW);

  
  
	 $dobm = $_POST['DOBMonth'];
	 $dobd = $_POST['DOBDay'];
	 $doby = $_POST['DOBYear'];
	 
	 $dob=$doby.'-'.$dobm.'-'.$dobd;
	 
	 $sql = "select * from user where user_email = '$email'";
	 $check = mysqli_query($conn, $sql);
	 $num_rows = mysqli_num_rows($check);
	 
	 /*if ($pass != $pass2){
	     header("../index.php");
	     die();
	 }
	 else{
	     header("../home.php");
	 }*/

	 if ($num_rows == 0) 
     {
         $query = 'insert into user (user_fname, user_lname, user_email, user_pass, salt, user_dob) values ("'.$fname.'", "'.$lname.'", "'.$email.'", "'.$hashedPW.'","'.$salt.'","'.$dob.'" )';
         $insert = mysqli_query($conn, $query);
         if(!$insert)
         {
             die("Error: " . mysqli_error($conn) );
         }
         else
         {
             header("Location: ../sendEmail.php");
             die();
         }
     }
?>