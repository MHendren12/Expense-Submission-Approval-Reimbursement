<?php
    session_start();
    include("../Database/config.php");
    $conn = getConnection();
    
    $email = $_POST['email'];
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
    header("Location: ../retrievepassword.php?emailsent=1&email='".urlencode(base64_encode($email))."'");
    
?>