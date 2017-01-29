<?php
session_start();

error_reporting(E_ERROR | E_PARSE);

include("Database/config.php");
include("../Database/config.php");


$conn = getConnection();
$id = $_SESSION['userid'];
$request = true;
$sql = "select * from user where user_id = '".$id."'";
$result = mysqli_query($conn,$sql);
$row=$result->fetch_object();

$user['user_email'] = $row->user_email;
$user['user_pass'] = $row->user_pass;
$user['salt'] = $row->salt;
$user['user_activated'] = $row->user_activated;
$user['user_fname'] = $row->user_fname;
$user['user_lname'] = $row->user_lname;

$name = $user['user_fname'] . " " . $user['user_lname'];
$domain = $_SERVER['HTTP_HOST'];
$current_id = $user['user_pass'] . $user['salt'];
$initial_id = $user['salt'] . $user['user_pass'];
$account_link_id = "/Account/activate.php?id=";
$password_link_id = "/Account/changePassword.php?id=";

if($user['user_activated'] == 0 && $user['user_activated'] != null && $request == true){
  //Used when user creates a new account.
  shell_exec("curl -s \
    -X POST \
    --user \"fd53dceb11de74bfc08124b30aabfbe0:96e43f32048e212b9d94cb45191c62ce\" \
    https://api.mailjet.com/v3/send \
    -H 'Content-Type: application/json' \
    -d '{
      \"FromEmail\": \"mrhendre@oakland.edu\",
      \"FromName\": \"RASE Corp.\",
      \"Subject\": \"RASE - Activate your account!\",
      \"MJ-TemplateID\": \"99083\",
      \"MJ-TemplateLanguage\": true,
      \"Recipients\": [
        { \"Email\": \"" . $user['user_email'] . "\" }
      ],
      \"Vars\": {
      \"user\": \"" . $name . "\",
      \"confirmation_link\": \"" . $domain . $account_link_id . $current_id . "\",
      \"email\": \"" . $user['user_email'] . "\"
      }
    }'");
    echo "<html>
    <head>
        <title>Email Sent</title>
        <!-- Styles -->
        <link href=\"/Styles/css/bootstrap.css\" rel=\"stylesheet\">
        
        <!-- Scripts -->
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js\"></script>
        <script src=\"/Scripts/bootstrap.min.js\"></script>
        
        
    </head>
    <body>
        <div class=\"container\" align = \"left\">
            <div class=\"row\">
              <h1>Verify your RASE account!</h1>
            </div>
            <div class=\"row\">
                <div class=\"well panel panel-default\" >
                    <div class=\"panel-body\">
                        <div class=\"row\" align =\"center\">
                            <div class=\"col-lg-2 \">
                                <img alt=\"\" class=\"img\" height=\"150\" src=\"../images/email.png\" width=\"150\" style=\"border:4px solid #021a40\">
                            </div>
                            <div class=\"col-lg-8\" align = \"left\">
                                <h3>A email has been sent to " . $user['user_email'] . " inbox.</h3>
                                <p>
                                    Please check your email and follow the email instruction to login to your RASE account.
                                    You will not be able to login to your account until your email has been verified.<br><br>
                                    Didn't recieve any email, <a href=" . $domain . "/Account/sendEmail.php\"> send another email and try again</a>.
                                </p>
                            </div>
                            <div class=\"col-lg-2 \">
                                
                            </div>                            
                        </div>
                        <hr>
                        <div class=\"row\" align =\"right\">
                            <div class=\"col-lg-10 \">
                                
                            </div>
                            <div class=\"col-lg-2\" align = \"center\">
                              <form action=\"logout.php\" method=\"post\">
                                   <input id=\"submit\" input type=\"submit\" class=\"btn btn-info\" value=\"OK\" name=\"submit\" style=\"width:100px; height:50px; font-size:20px\"/>
                              </form>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>";
$request = false;
}

if($request == true && $user['user_activated'] == 0 ){
    
    echo "<html>
    <head>
        <title>Email Sent</title>
        <!-- Styles -->
        <link href=\"/Styles/css/bootstrap.css\" rel=\"stylesheet\">
        
        <!-- Scripts -->
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js\"></script>
        <script src=\"/Scripts/bootstrap.min.js\"></script>
        
        
    </head>
    <body>
        <div class=\"container\" style=\"padding:20px px 0px 0px;\" align=\"left\">
               
                <h4>Please provide your email address to reset your password:</h4>
                <input id=\"mytext\" type=\"text\" placeholder=\"Email\" class=\"form-control\" value=\"\" name=\"email\"  style=\"width:65%\">
                <br>
                <div id=\"resetPassword\" style=\"display:none;\">
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
                            <h4>A email notfication has been sent to the following email:</h4><h2 id =\"address\"></h2>
                            <p>
                                Please check your email and follow the email instruction to change you RASE account password.
                                <br><br>
                                Didn't recieve any email, <a href=\"retrievepassword.php?request=1\"> reset and try again</a>.
                            </p>
                        </div>
                        <div class=\"col-lg-2 \">
                            
                        </div>                            
                    </div>
                </div>
            <div class=\"container\" style=\"padding:15px 0px 0px 0px\" align=\"center\">
                <input class=\"btn btn-default\" type=\"submit\" id=\"submit\" value=\"Submit\" name=\"submit\" />
                <a class=\"btn btn-default\" href=\"index.php\" role=\"button\">Cancel &raquo;</a>
            </div>
        </div>
    </body>
    </html>";
    //Used when user selects for your password.
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
        { \"Email\": \"" . $user['user_email'] . "\" }
      ],
      \"Vars\": {
     \"name\": \"" . $name . "\",
      \"confirmation_link\": \"" . $domain . $password_link_id . $initial_id . "\",
      \"reset_password_link\": \"" . $domain . $password_link_id . $initial_id . "\",
      \"email\": \"" . $user['user_email'] . "\"
      }
    }'");
}
?>