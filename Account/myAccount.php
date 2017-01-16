<?php

?>
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
        <div class="container" align = "center">
            <h1>Change Password</h1>
            <hr>
            <div class="row">
                <form action="../Account/changePassword.php" method="post" >
                    <div class="row">
                        <h4>New Password: </h4>
                        <input type="text" placeholder="Enter New Password..." class="form-control" name="user_pass" style="width:70%" required>
                        <h4 > <div class="figure" id="strength"></div> </h4> 
                    </div>
                    <hr width = "100%">
                    <div class="row" align="center" >
                        <input id="submit" input type="submit" class="btn btn-success" value="Submit" name="submit" />
                        <a class="btn btn-default" href="../home.php" role="button">Cancel &raquo;</a>
                        
                        <script language="JavaScript">
                            window.onbeforeunload = confirmExit;
                            function confirmExit()
                            {
                                // this shouldn't show if the user has filled out the page and wants to register
                                return "Do you wish to cancel your registration for the Not-So-Social-Network and leave this page?";
                            }
                        </script>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>

