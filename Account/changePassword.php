<?php

session_start();
include("../Database/config.php");
$conn = getConnection();
$sql = "select * from user where user_pass = '".$_GET['id']."'";
$result = mysqli_query($conn,$sql);
$row=$result->fetch_object();

$user['user_id'] = $row->user_id;
$user['user_email'] = $row->user_email;
$user['user_pass'] = $row->user_pass;
$user['salt'] = $row->salt;
$user['user_activated'] = $row->user_activated;



$link_id = strval($_GET['id']);
$current_id = strval($user['user_pass']);

//current_id is the curent user session pass combined with salt from the user database table
if($current_id == $link_id) {
    $id = $user['user_id'];
}
?>
<html>
    <head>
        <title>Email Sent</title>
        <!-- Styles -->
        <link href="/Styles/css/bootstrap.css" rel="stylesheet">
        
        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="/Scripts/bootstrap.min.js"></script>
        
        
    </head>
    <body>
        <div class="container" align = "left">
            <div class="row">
              <h1>RASE Password Request Successful!</h1>
            </div>
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" align ="center">
                            <div class="col-lg-2 ">
                                <img alt="" class="img" height="150" src="../images/check.png" width="150" style="border:4px solid #021a40">
                            </div>
                            <div class="col-lg-8" align = "left">
                                <h3>Change Password</h3>
                                <p>
                                    We have recieved a password change request from <?php echo $user['user_email'] ?>.
                                     To proceed type a new password in both fields then click the Submit button.
                                </p>
                                <form action="editinfo.php?id=<?php echo $user['user_id'] ?> " onsubmit="return validateForm()" method="post">
                                    <div id = "changePasswordNewPassword">
                                        <h2>New Password</h2>
                                        <input type="password" placeholder="New Password" class="form-control" id="password" name="newPassword" style="width:65%">
                                        <div class="figure" id="strength" style="font-weight:bold;"></div>
                                        <h2>Confirm Password</h2>
                                        <input type="password" placeholder="Confirm Password" class="form-control" id="confirmPassword" name="confirmPassword" style="width:65%">
                                        <div id="passwordsNotEqual" style="display:none;"><span style="color:red;font-weight:bold;">The Password do not match</span></div>
                                    </div>
                            </div>
                            <div class="col-lg-4 ">
                                
                            </div>                            
                        </div>
                        <hr>
                        <div class="row" align ="right">
                            <div class="col-lg-7 ">
                                
                            </div>
                            <div class="col-lg-3" align = "center">
                                   <input id="submit" input type="submit" class="btn btn-info" value="Submit" name="submit" style="width:100px; height:50px; font-size:20px"/>
                                   <a class="btn btn-default" href="../index.php"  style="width:100px; height:50px; font-size:20px" role="button">Cancel</a>
                              </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    
    function validateForm()
    {
        //no errors
        if ( $("#passwordsNotEqual").css("display") == "none")
        {
            //Blank new password 
            if( $("#changePasswordNewPassword").css("display") != "none" &&  ( $("#password").val() == "" || $("#confirmPassword").val() == "" ) )
            {
                alert("Please enter your new password.");
                return false;
            }
            //no issues
            else
            {
                return true;
            }
            
            
        }
        else
        {
            alert("Your password and confirmation do not match");
            return false;
        }
        
    }
    
   
</script>