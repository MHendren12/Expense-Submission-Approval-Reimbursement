<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Expense Reimbursement</title>
        <!-- Styles -->
        <link href="/Styles/css/bootstrap.css" rel="stylesheet">
        <link href="/Styles/css/customStyles.css" rel="stylesheet">
        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="/Scripts/bootstrap.min.js"></script>
        
        
    </head>
    <body>
        <?php
            include("Navbar/header.php");
            if($_SESSION['userid'] == null){
                header("Location: index.php");
            }
        ?>
        <div class="container loggedInContainer" align = "center">
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" ><br><br>
                            <ul class="nav nav-tabs nav-justified">
                              <li class="active"><a data-toggle="tab" href="#home"><h4>Home</h4></a></li>
                              <li><a data-toggle="tab" href="#myform"><h4>My forms</h4></a></li>
                              <li><a data-toggle="tab" href="#myactivity"><h4>My activity</h4></a></li>
                              <li><a data-toggle="tab" href="#aboutus"><h4>About us</h4></a></li>
                              <li><a data-toggle="tab" href="#contactus"><h4>Contact us</h4></a></li>                              
                            </ul>
                            <br><br>
                            <div class="row">
                                <div class="col-lg-1">
                                    
                                </div>
                                <div class="col-lg-10">
                                    <div class="tab-content" align="left">
                                        <div id="home" class="tab-pane fade in active">
                                            <h2>Your RASE Home</h2>
                                            <?php include('info.php'); ?>
                                        </div>
                                        <div id="myform" class="tab-pane fade">
                                            <h2>Create a New Expense Form</h2>
                                            <?php include('expense_form.php'); ?>
                                        </div>
                                        <div id="myactivity" class="tab-pane fade">
                                            <h2>Activity Stream</h2>
                                            <?php include('activity.php'); ?>
                                        </div>
                                        <div id="aboutus" class="tab-pane fade">
                                            <h2>About Us</h2>
                                            <?php include('aboutus.php'); ?>
                                        </div>  
                                        <div id="contactus" class="tab-pane fade">
                                            <h2>Contact Us</h2>
                                            <?php include('contactus.php'); ?>
                                        </div>                                        
                                    </div>     
                                </div>
                                <div class="col-lg-1">
                                    
                                </div>                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div align="center">
            <label>&#169; Copyright 2017, RASE Corp. English(US). All Right Reserved.</label>
        </div>
    </body>
</html>