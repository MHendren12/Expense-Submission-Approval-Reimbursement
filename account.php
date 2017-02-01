<?php
    session_start();
	$id = $_SESSION['userid'];
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>My Account</title>
        <!-- Styles -->
        <link href="/Styles/css/bootstrap.css" rel="stylesheet">
        
        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="/Scripts/bootstrap.min.js"></script>
        <script src="/Scripts/passwordstrength.js"></script>
        
        
    </head>
    <body>
        <?php
            include("Navbar/header.php");	
        ?>
        <div class="container" align="center" style="padding-top:30px;">
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" align ="left">
                            <div class="col-lg-8" align = "left">
                                <form action="Account/editinfo.php" onsubmit="return validateForm()" method="post">
                                    <?php
                                        $sql = "SELECT * FROM user WHERE user_id= '".$id."'";
                                        $result = mysqli_query($conn, $sql);
                                        
                                        
                                        while($row = mysqli_fetch_assoc($result))
                                        {     
                                            $userid= $row['user_id'];
                                            $fname= $row['user_fname'];
                                            $lname= $row['user_lname'];
                                            $email = $row['user_email'];
                                            $dob = $row['user_dob'];
                                        
                                    ?>
                                    <div class="container" align="left">
                                        <div class="row">
                                            <h2>Name </h2>
                                            <?php echo'<input type="name" placeholder="Name" value="'.$fname ." ". $lname.'" class="form-control" name="name" style="width:65%">';?>
                                            <h2>Email </h2>
                                            <?php echo '<input type="text" placeholder="Email" class="form-control" value="'.$email.'" name="email" style="width:65%">';?>
                                            <h2>Date Of Birth</h2>
                                            <?php echo '<input type="date" placeholder="Date Of Birth" class="form-control" value="'.$dob.'" name="dob" style="width:65%">';?>
                                            <h2>User Role</h2>
                                            <?php $sql = "SELECT * FROM user WHERE user_id= '".$id."'";
                                                    $result = mysqli_query($conn, $sql); 
                                                    $row=$result->fetch_object();
                                                    $user['is_admin'] = $row->is_admin;
                                                    if($user['is_admin'] == 1){
                                                        echo "<h4>Administrator</h4>";
                                                    } else{
                                                        echo "<h4>Normal User</h4>";
                                                    }
                                                    ?>
                                            <h3><a onclick="displayChangePassword(this)">Change Password</a></h3>
                                            <div id = "changePassword" style="display:none;">
                                                <h2>Current Password</h2>
                                                <input type="password" placeholder="Current Password" class="form-control" id="oldPassword" name="password" style="width:65%">
                                                <span id="incorrectPassword" style="display:none; color:red;font-weight:bold;">The entered password does not match the current password!</span>
                                            </div>
                                            <div id = "changePasswordNewPassword" style="display:none;">
                                                <h2>New Password</h2>
                                                <input type="password" placeholder="New Password" class="form-control" id="password" name="newPassword" style="width:65%">
                                                <div class="figure" id="strength" style="font-weight:bold;"></div>
                                                <h2>Confirm Password</h2>
                                                <input type="password" placeholder="Confirm Password" class="form-control" id="confirmPassword" name="confirmPassword" style="width:65%">
                                                <div id="passwordsNotEqual" style="display:none;"><span style="color:red;font-weight:bold;">The Password do not match</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                    <div class="container" style="padding:15px 0px 0px 0px">
                                        <input class="btn btn-default" type="submit" id="submit" value="Submit" name="submit" />
                                        <a class="btn btn-default" href="home.php" role="button">Cancel &raquo;</a>
                                    </div>
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

    function displayChangePassword(element)
    {
        $(element).css("display", "none");
        $("#changePassword").css("display","");
    }
    
    $("#confirmPassword").bind("change", function(){
        var newPass = $("#password").val();
        var confirmPass = $("#confirmPassword").val();
        if (newPass != confirmPass)
        {
            $("#passwordsNotEqual").css("display", "");
        }
        else
        {
            $("#passwordsNotEqual").css("display", "none");
            
            
        }
    });
    
   
    
    $("#oldPassword").bind("change",function(){
        debugger;
        var password = $("#oldPassword").val();
        jQuery.ajax({
            url: 'Account/accountinfo.php?val=comparePasswords&pass=" + password,',
            data: ({val : 'comparePasswords'},{ pass : $("#oldPassword").val() }),
            success: function(match) {
                if (match == 0)
                {
                    $("#incorrectPassword").css("display","");
                }
                else
                {
                    $("#changePasswordNewPassword").css("display", "");
                    $("#incorrectPassword").css("display","none");
                    $("#changePassword").css("display", "none");
                }
            }
        });
    });
    
    function validateForm()
    {
        //no errors
        if ( $("#passwordsNotEqual").css("display") == "none" && $("#incorrectPassword").css("display") == "none" )
        {
            //Current password not entered or entered incorrectly
            if ($("#changePassword").css("display") != "none")
            {
                alert("Please enter your old password.");
                return false;
            }
            //Blank new password 
            else if( $("#changePasswordNewPassword").css("display") != "none" &&  ( $("#password").val() == "" || $("#confirmPassword").val() == "" ) )
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