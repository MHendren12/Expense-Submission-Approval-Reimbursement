<?php
    $emailSent = $_GET['emailsent'];
    $email = base64_decode($_GET['email']);
?>
<!DOCTYPE html>
<html>
    <body>
        <?php 
            include("Navbar/header.php");
            if ($emailSent != 1)
            {
        ?>
        <div class="container contentContainer" >
        	<div class="row">
        		<div class="well panel panel-default">
        			<div class="panel-body">
        				<div id="content" class="site-content">
        					<article id="post-8" class="single-post post-8 page type-page status-publish hentry">
        						<div class="entry-content">
        							<hr>
        							<div align="center">
        							    
        							    <form method="post" action="Account/sendpasswordreset.php" onsubmit="return checkValidEmail();"> 
        							    <!--<form method="post" action="WebService/accountinfo.php?val=compareEmails&email=jccalver@oakland.edu"> -->
                                            <div class="container" style="padding:20px px 0px 0px;" align="left">
                                                    <h4>Please provide your email address to reset your password:</h4>
                                                    <input type="text" placeholder="Email" id="userEmail" class="form-control" value="<?php echo $email;?>" name="email" style="width:65%"><br>
                                                    <div id="emailError" style="display:none;"><span style="color:red;font-weight:bold;">The email you entered does not exist!</span></div>
                                                    <div class="container" style="padding:15px 0px 0px 0px" align="center">
                                                    <input class="btn btn-default" type="submit" id="submit" value="Submit" name="submit" />
                                                    <a class="btn btn-default" href="index.php" role="button">Cancel</a>
                                                </div>
                                            </div>
                                        </form>
        							</div>
    							</div>
        					</article>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
        <?php
            }
            else
            {
        ?>
        <div class="container contentContainer" align="left">
            <div id="resetPassword" >
                <div class="row">
                    <div class="well panel panel-default" >
                        <div class="panel-body">
                            <div class="row">
                              <h1>Password Reset Sent!</h1>
                            </div>                            
                            <div class="row" align ="center">
                                <div class="col-lg-2 ">
                                    <img alt="" class="img" height="125" src="images/key.png" width="125" style="border:4px solid #021a40">
                                </div>
                                <div class="col-lg-8" align = "left">
                                    <h4>An email notfication has been sent to the following email:"<?php echo $email; ?>"
                                    <p>
                                        Please check your email and follow the email instruction to change you RASE account password.
                                        <br><br>
                                        Didn't recieve any email, <a href="retrievepassword.php?"> reset and try again</a>.
                                    </p>
                                </div>
                                <div class="col-lg-2">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <?php
            }
        ?>
    </body>
    
                                                        
                                                
    <script>
        function checkValidEmail()
        {
            var isValid = $("#emailError").css("display") == "none";
            if (isValid)
                return isValid;
            else
                alert("Enter a valid email address");
            return isValid;
        }
        
        
        $("#userEmail").bind("change",function(){
        var userEmail = $("#userEmail").val();
        jQuery.ajax({
            url: 'WebService/accountinfo.php?val=compareEmails&email='+userEmail,
            data: ({val : 'compareEmails'},{ pass : $("#userEmail").val() }),
            success: function(match) {
                debugger;
                if (match == 1)
                {
                    $("#emailError").css("display","none");
                }
                else
                {
                    $("#emailError").css("display","");
                }
            }
        });
    });
    </script>
</html>