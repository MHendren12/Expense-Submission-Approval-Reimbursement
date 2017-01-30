<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Expense Reimbursement</title>
        <!-- Styles -->
        <link href="/Styles/css/bootstrap.css" rel="stylesheet">
        
        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="/Scripts/bootstrap.min.js"></script>
        
        
    </head>
    <body>
        <?php
            include("Navbar/header.php");
        ?>
        <div class="container" align = "center">
            <hr>
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" align ="left">
                            <div class="col-lg-4 ">
                                <h1>Welcome to Expense Reimbursement</h1>
                            </div>
                            <div class="col-lg-8" align = "left">
                                <h1>This is our CSE/CIT480 Project</h1>
                                <p>
                                    <?php
                                        
                                        echo "hello ";
                                        echo $_SESSION['name'];
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>