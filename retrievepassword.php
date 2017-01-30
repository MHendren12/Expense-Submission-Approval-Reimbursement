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
    <style>
    .error {color: #FF0000; font-size: 20px;}
    </style>
    </head>
    
    <body>
    
        <?php
            include("Navbar/header.php");
            $emailErr = "";
            $email = "";
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              
              if (empty($_POST["email"])) {
                $emailErr = "*Email is required";
              } 
              else {
                $email = test_input($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  $emailErr = "*Invalid email format";
                }
                else{
                $success = "<div id=\"resetPassword\" >
                    <div class=\"row\">
                        <div class=\"col-lg-6 \">
                             <h1>Password Reset Request!</h1><br>                                                                
                        </div>
                        <div class=\"col-lg-6 \">
                           
                        </div>                                                             
                    </div>
                    <div class=\"row\" align =\"center\">
                        <div class=\"col-lg-2 \">
                            <img alt=\"\" class=\"img\" height=\"125\" src=\"../images/key.png\" width=\"125\" style=\"border:4px solid #021a40\">
                        </div>
                        <div class=\"col-lg-8\" align = \"left\">
                            <h4>An email notfication has been sent to the following email:" . $email . "
                            <p>
                                Please check your email and follow the email instruction to change you RASE account password.
                                <br><br>
                                Didn't recieve any email, <a href=\"retrievepassword.php?\"> reset and try again</a>.
                            </p>
                        </div>
                        <div class=\"col-lg-2 \">
                            
                        </div>                            
                    </div>
                </div>";
                }

              }
                
            }
            
            function test_input($data) {
              $data = trim($data);
              $data = stripslashes($data);
              $data = htmlspecialchars($data);
              return $data;
            }
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
        							    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> " onsubmit="return sendResetPassEmail();">
                                            <div class="container" style="padding:20px px 0px 0px;" align="left">
  
                                                    <h4>Please provide your email address to reset your password:</h4>
                                                    <input type="text" placeholder="Email" class="form-control" value="<?php echo $email;?>" name="email" style="width:65%"><br>
                                                    <span class="error"><?php echo $emailErr;?></span>
                                                    <span class=""><?php echo $success;?></span>
                                                    <br>
                                                        <?php
                                                        session_start();
                                                        
                                                        $sql = "select * from user where user_email = '".$email."'";
                                                        $result = mysqli_query($conn,$sql);
                                                        $row=$result->fetch_object();
                                                        
                                                        $user['user_email'] = $row->user_email;
                                                        $user['user_pass'] = $row->user_pass;
                                                        $user['salt'] = $row->salt;
                                                        $user['user_fname'] = $row->user_fname;
                                                        $user['user_lname'] = $row->user_lname;
                                                        
                                                        $name = $user['user_fname'] . " " . $user['user_lname'];
                                                        $domain = $_SERVER['HTTP_HOST'];
                                                        $password_link_id = "/Account/changePassword.php?id=";
                                                        $initial_id = $user['user_pass'];
                                                        
                                                          shell_exec("curl -s \
                                                            -X POST \
                                                            --user \"fd53dceb11de74bfc08124b30aabfbe0:96e43f32048e212b9d94cb45191c62ce\" \
                                                            https://api.mailjet.com/v3/send \
                                                            -H 'Content-Type: application/json' \
                                                            -d '{
                                                              \"FromEmail\": \"mrhendre@oakland.edu\",
                                                              \"FromName\": \"RASE Corp.\",
                                                              \"Subject\": \"RASE - Password Reset Request!\",
                                                              \"MJ-TemplateID\": \"99747\",
                                                              \"MJ-TemplateLanguage\": true,
                                                              \"Recipients\": [
                                                                { \"Email\": \"" . $email . "\" }
                                                              ],
                                                              \"Vars\": {
                                                             \"name\": \"" . $name . "\",
                                                              \"confirmation_link\": \"" . $domain . $password_link_id . $initial_id . "\",
                                                              \"reset_password_link\": \"" . $domain . $password_link_id . $initial_id . "\",
                                                              \"email\": \"" . $email . "\"
                                                              }
                                                            }'");
                                                        ?>
                                                <div class="container" style="padding:15px 0px 0px 0px" align="center">
                                                    <input class="btn btn-default" type="submit" id="submit" value="Submit" name="submit" />
                                                    <a class="btn btn-default" href="index.php" role="button">Cancel</a>
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
            var x = document.getElementById("mytext").value;
            document.getElementById("address").innerHTML = x;            
            $("#resetPassword").css("display","");
            return false;
        }
    </script>
</html>

