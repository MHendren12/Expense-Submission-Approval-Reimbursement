<?php
session_start();

error_reporting(E_ERROR | E_PARSE);

include("Database/config.php");
include("../Database/config.php");


$conn = getConnection();
$id = $_SESSION['userid'];
$email = $_GET['id'];
if($email != null){
    $sql = "select * from user where user_email = '".$email."'";
    $result = mysqli_query($conn,$sql);
} else{
    $sql = "select * from user where user_id = '".$id."'";
    $result = mysqli_query($conn,$sql);
}
$row=$result->fetch_object();

$user['user_email'] = $row->user_email;
$user['user_pass'] = $row->user_pass;
$user['salt'] = $row->salt;
$user['user_activated'] = $row->user_activated;
$user['user_fname'] = $row->user_fname;
$user['user_lname'] = $row->user_lname;



$name = $user['user_fname'] . " " . $user['user_lname'];
$domain = $_SERVER['HTTP_HOST'];
$current_id = $user['salt'];
$account_link_id = "/Account/activate.php?id=";


if($user['user_activated'] == 0){
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
                              <form action=\"../index.php\" method=\"post\">
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
}

?>