<?php

session_start();
include("Database/config.php");
$conn = getConnection();
$id = $_SESSION['userid'];
$sql = "select user_email, user_pass, salt from user where user_id = '".$id."'";
$result = mysqli_query($conn,$sql);
$row=$result->fetch_object();

$user['user_email'] = $row->user_email;
$user['user_pass'] = $row->user_pass;
$user['salt'] = $row->salt;
$name = $_SESSION['name'];

//$current_id = $user['user_pass'] + $user['salt'];

$output = shell_exec("curl -s \
    -X POST \
    --user \"fd53dceb11de74bfc08124b30aabfbe0:96e43f32048e212b9d94cb45191c62ce\" \
    https://api.mailjet.com/v3/send \
    -H \"Content-Type: application/json\" \
    -d '{
        \"FromEmail\":\"mrhendre@oakland.edu\",
        \"FromName\":\"RASE Corp.\",
        \"Recipients\": [ 
            {
            \"Email\":\"" . $user['user_email'] . "\"
            }
        ],
        \"Subject\":\"RASE - Activate your account!\",
        \"Html-part\":\"<h1>You Have Created a New RASE Account!</h1>".
        "<p style='font-size:15px'>Hello " . $name . ",<br><br>" .
        "Thank you for registering an account using RASE. Your account is created and must be activated before you can use it." .
        "To activate the account click on the following link or copy-paste it in you browser.<br><br>".
        "Activation Link: expense-submit-approve-reimburse-mhendren12.c9users.io/activate.php?id="
        . "<br><br>After activation you may login to RASE using the following email and password:<br><br>".
        "Email: " . $user['user_email'] . "<p>\"}'");
echo $output;
echo $id;
?>