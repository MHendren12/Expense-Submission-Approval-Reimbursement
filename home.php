<?php
    session_start();
    $user_id = $_SESSION['userid'];
    include("WebService/accountinfo.php");
?>
<!DOCTYPE html>
<html>
    <head>

        <link href="/Styles/css/customStyles.css" rel="stylesheet">
        
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
                        <!-- Menu tabs are generated from bootstrap, the bootstap is included from the header.php file. -->
                            <ul class="nav nav-tabs nav-justified" id="homeTabs">
                              <li class="active"><a data-toggle="tab" href="#home"><h4>Home</h4></a></li>
                              <!-- Subpannel for My Form -->
                              <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><h4>My Form</h4>
                                <ul class="dropdown-menu" style="min-width: 100%;";>
                                  <li><a data-toggle="tab" href="#expenseform">Expense Form</a></li>
                                  <li><a data-toggle="tab" href="#submissionform">Submission Form</a></li>
                                  <li><a data-toggle="tab" href="#approverform">Approver Form</a></li>
                                </ul>
                              </li>
                              <!--
                              <li><a data-toggle="tab" href="#myactivity"><h4>My activity</h4></a></li>
                                
                                <li><a data-toggle="tab" href="#aboutus"><h4>About us</h4></a></li>
                                <li><a data-toggle="tab" href="#contactus"><h4>Contact us</h4></a></li>     
                                -->
                                <?php
                                    
                                    $isadmin = isadmin($user_id, $conn);
                                    if ($isadmin)
                                    {
                                ?>
                                <li><a data-toggle="tab" class="active" href="#routing"><h4>Routing</h4></a></li>
                                <?php
                                    }
                                ?>                              
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
                                        <div id="expenseform" class="tab-pane fade">
                                            <h2>Create a New Expense Form</h2>
                                            <?php include('expense_form.php'); ?>
                                        </div>
                                        <!--
                                        <div id="myactivity" class="tab-pane fade">
                                            <h2>Activity Stream</h2>
                                            <?php //include('activity.php'); ?>
                                        </div>
                                        <div id="aboutus" class="tab-pane fade">
                                            <h2>About Us</h2>
                                            <?php //include('aboutus.php'); ?>
                                        </div>  
                                        <div id="contactus" class="tab-pane fade">
                                            <h2>Contact Us</h2>
                                            <?php //include('contactus.php'); ?>
                                        </div>  
                                        -->
                                        <div id="routing" class="tab-pane fade">
                                            <h2>Routing</h2>
                                            <?php include('routing.php'); ?>
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
    <script>
    
        $('#homeTabs a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
        
        // store the currently selected tab in the hash value
        $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
        });
        
        // on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('#homeTabs a[href="' + hash + '"]').tab('show');
        
    </script>
</html>