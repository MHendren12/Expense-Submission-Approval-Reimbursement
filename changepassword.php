<?php
    include("Navbar/header.php");
    $id = base64_decode($_GET['id']);
?>
<html>
    <body>
        <div class="container contentContainer" align = "center">
            <div class="row">
              <h1>RASE Password Request Successful!</h1>
            </div>
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" align ="center">
                            <div class="col-lg-2 ">
                                <img alt="" class="img" height="150" src="images/check.png" width="150" style="border:4px solid #021a40">
                            </div>
                            <div class="col-lg-8" align = "left">
                                <h3>Change Password</h3>
                                <p>
                                    We have recieved a password change request from <?php echo $user['user_email'] ?>.
                                    To proceed type a new password in both fields then click the Submit button.
                                </p>
                                <form action="Account/editinfo.php?id=<?php echo $id ?> " onsubmit="return validateForm()" method="post">
                                    <div id = "changePasswordNewPassword">
										<input id="newPassword" class="form-control" name="newPassword" placeholder="Password" required style="width: 70%" type="password">
										<br>
										<input id="confirmpassword" onchange="verifyPasswords();" class="form-control" name="confirmpassword" placeholder="Confirm Password" required style="width: 70%" type="password">
										<br>
										<div id="passNotEqual" style="display:none;width:70%;" align="left">
											<span style="color:red;font-weight:bold;">The Passwords do not match!</span>
										</div>
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
                                   <a class="btn btn-default" href="index.php"  style="width:100px; height:50px; font-size:20px" role="button">Cancel</a>
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

		function verifyPasswords()
		{
			
			debugger;
			var pass = $("#newPassword").val();
			var pass2 =  $("#confirmpassword").val();
			if (pass == pass2)
			{
				$("#passNotEqual").css("display","none");
				return true;
			}
			else
			{
				$("#passNotEqual").css("display","");
				return false;
			}
		}
		
		function validateForm()
		{
			var passMatch = $("#passNotEqual").css("display") == "none";
			if ($("#passNotEqual").css("display") == "none" )
			{
				return true;
			}
			else
			{
				return false;
			}
		}
    
</script>