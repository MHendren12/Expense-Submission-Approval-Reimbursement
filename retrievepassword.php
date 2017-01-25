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
        							    <form  onsubmit="return sendResetPassEmail();" >
                                    
                                            <div class="container" style="padding:20px px 0px 0px;" align="left">
                                                <div class="row">
                                                   
                                                    <h4>Please provide your email address to reset your password:</h4>
                                                    <input type="text" placeholder="Email" class="form-control" value="" name="email" style="width:65%">
                                                    <br>
                                                    <div id="resetPassword" style="display:none;">
                                                        <span>
                                                            An email has been sent to your email address with a link to reset the password
                                                        </span>
                                                    </div>
                                                        
                                                </div>
                                            
                                                <div class="container" style="padding:15px 0px 0px 0px" align="center">
                                                    <input class="btn btn-default" type="submit" id="submit" value="Submit" name="submit" />
                                                    <a class="btn btn-default" href="home.php" role="button">Cancel &raquo;</a>
                                                </div>
                                            </div>
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
            $("#resetPassword").css("display","");
            return false;
        }
    </script>
</html>

