<?php
include("Navbar/header.php");

$id = $_SESSION['userid'];
$email = base64_decode($_GET['user_email']);

?>
<html>
    <head>
        <title>Email Sent</title>
        <!-- Styles -->
       
        
        
    </head>
    <body>
        <div class="container" align = "left">
            <div class="row">
              <h1>Verify your RASE account!</h1>
            </div>
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" align ="center">
                            <div class="col-lg-2 ">
                                <img alt="" class="img" height="150" src="../images/email.png" width="150" style="border:4px solid #021a40">
                            </div>
                            <div class="col-lg-8" align = "left">
                                <h3>An email has been sent to the inbox of <?php echo $email ?></h3>
                                <p>
                                    Please check your email and follow the email instruction to login to your RASE account.
                                    You will not be able to login to your account until your email has been verified.<br><br>
                                    Didn't recieve any email, <a href="Account/sendEmail.php"> send another email and try again</a>.
                                </p>
                            </div>
                            <div class="col-lg-2 ">
                                
                            </div>                            
                        </div>
                        <hr>
                        <div class="row" align ="right">
                            <div class="col-lg-10 ">
                                
                            </div>
                            <div class="col-lg-2" align = "center">
                              <form action="../index.php" method="post">
                                   <input id="submit" input type="submit" class="btn btn-info" value="OK" name="submit" style="width:100px; height:50px; font-size:20px"/>
                              </form>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>