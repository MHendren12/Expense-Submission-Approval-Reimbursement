<?php

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
        <div class="container">
        	<div class="row">
        		<div class="well panel panel-default">
        			<div class="panel-body">
        				<div id="content" class="site-content">
        					<article id="post-8" class="single-post post-8 page type-page status-publish hentry">
        						<div class="entry-content">
        							<hr>
        							<div align="center">
        							    <form onsubmit="return sendResetPassEmail();" >
                                            <?php include("Account/sendEmail.php"); ?>
                                        </form>
        							</div>
        					</article>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
    </body>
    <script>
        function sendResetPassEmail()
        {
            var x = document.getElementById("mytext").value;
            document.getElementById("address").innerHTML = x;            
            $("#resetPassword").css("display","");
            return false;
        }
    </script>
</html>

