<?php

session_start();
include("../Database/config.php");
$conn = getConnection();
$sql = "select * from user where user_pass = '".$_GET['id']."'";
$result = mysqli_query($conn,$sql);
$row=$result->fetch_object();

$user['user_id'] = $row->user_id;
$user['user_email'] = $row->user_email;
$user['user_pass'] = $row->user_pass;
$user['salt'] = $row->salt;
$user['user_activated'] = $row->user_activated;



$link_id = strval($_GET['id']);
$current_id = strval($user['user_pass']);

//current_id is the curent user session pass combined with salt from the user database table
if($current_id == $link_id) {
    $id = $user['user_id'];
    header("Location: ../changepassword.php?id='".urlencode(base64_encode($id))."'");
}
?>
