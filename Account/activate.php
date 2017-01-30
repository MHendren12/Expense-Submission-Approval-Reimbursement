<?php

session_start();
include("../Database/config.php");

$conn = getConnection();
$link_id = strval($_GET['id']);
$id = $_SESSION['userid'];
    
    if($link_id != null && $id == null){
        $sql = "select * from user where salt = '".$link_id."'";
        $result = mysqli_query($conn,$sql);
    }else{
        $sql = "select * from user where user_id = '".$id."'";
        $result = mysqli_query($conn,$sql);
    }
$row=$result->fetch_object();

$user['user_id'] = $row->user_id;
$user['user_email'] = $row->user_email;
$user['user_pass'] = $row->user_pass;
$user['salt'] = $row->salt;
$user['user_activated'] = $row->user_activated;

$current_id = strval($user['salt']);

//current_id is the curent user session pass combined with salt from the user database table
if($current_id == $link_id) {
    $sql = 'update user set user_activated = 1 where user_id=' .$user['user_id'];
    mysqli_query($conn,$sql) or die(mysql_error());
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
              <h1>RASE Account Activation Complete!</h1>
            </div>
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" align ="center">
                            <div class="col-lg-2 ">
                                <img alt="" class="img" height="150" src="../images/check.png" width="150" style="border:4px solid #021a40">
                            </div>
                            <div class="col-lg-8" align = "left">
                                <h3>Activation Successfull</h3>
                                <p>
                                    You have successfully activated your rase account for <?php echo $user['user_email'] ?>.
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