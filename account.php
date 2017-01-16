<?php
    session_start();
	$id = $_SESSION['userid'];
    include("Database/config.php");		 
    $conn = getConnection();
    
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
        <div class="container" align = "center">
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" align ="left">
                            <div class="col-lg-8" align = "left">
                                <form action="Account/editinfo.php" method="post">
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
                                            <h3><a onclick="displayChangePassword(this)">Change Password</a></h3>
                                            <div id = "changePassword" style="display:none;">
                                                <h2>Current Password</h2>
                                                <input type="password" placeholder="Current Password" class="form-control" id="oldPassword" name="password" style="width:65%">
                                                <span id="incorrectPassword" style="display:none;">The entered password does not match the current password!</span>
                                                <h2>New Password</h2>
                                                <input type="password" placeholder="New Password" class="form-control" id="password" name="newPassword" style="width:65%">
                                                <h4><div class="figure" id="strength"></div></h4>
                                                <h2>Confirm Password</h2>
                                                <input type="password" placeholder="Confirm Password" class="form-control" id="confirmPassword" name="confirmPassword" style="width:65%">
                                                <div id="passwordsNotEqual" style="display:none;">The Password do not match</div>
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
        var password = $("#oldPassword").val();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                debugger;
                if (this.responseText == false)
                    $("#incorrectPassword").css("display","");
                else
                    $("#incorrectPassword").css("display","none");
            }
        };
        xmlhttp.open("GET", "Account/accountinfo.php?val=comparePasswords&pass=" + password, true);
        xmlhttp.send();
    });
    
    /*
    $("#oldPassword").bind("change",function(){
        debugger;
        var password = $("#oldPassword").val();
        jQuery.ajax({
            url: 'Account/accountinfo.php',
            data: ({val : 'comparePasswords'},{ pass : $("#oldPassword").val() }),
            success: function(match) {
                handleData(match);
                
            }
        });
    });
    */
    /*
    $("#oldPassword").bind("change",function(){
            var password = $(this).val();
            debugger;
            $.post(
                'Account/accountinfo.php',
                'val=comparePasswords',
                'pass=' + password,
                function(match) {
                    
                    if (match == false)
                        $("#incorrectPassword").css("display","")

                }
            ); 
            
    });*/
</script>