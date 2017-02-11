<?php include("Navbar/header.php"); ?>
<html>
    <body>
        <div class="container contentContainer" align = "left">
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row">
                          <h1>RASE Account Activation Complete!</h1>
                        </div>                        
                        <div class="row" align ="center">
                            <div class="col-lg-2 ">
                                <img alt="" class="img" height="150" src="../images/check.png" width="150" style="border:4px solid #021a40">
                            </div>
                            <div class="col-lg-8" align = "left">
                                <h3>Activation Successfull</h3>
                                <p>
                                    You have successfully activated your rase account for <?php echo $GET['email']; ?>.
                                    To proceed click on the OK button and login to your account.<br><br>
                                    Thank you again for establishing an account using RASE.
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
                              <form action="../index.php?redirect=1" method="post">
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