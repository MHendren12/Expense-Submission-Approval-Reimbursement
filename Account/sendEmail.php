<?php
session_start();

error_reporting(E_ERROR | E_PARSE);

include("Database/config.php");
include("../Database/config.php");
include("../Navbar/header.php");

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
    header("Location: ../sendmail.php?user_email=".  urlencode(base64_encode($user['user_email']))  );
}

?>