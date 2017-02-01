<?php

session_start();
include("../Database/config.php");

$conn = getConnection();
$link_id = strval($_GET['id']);
$id = $_SESSION['userid'];
    
    if($link_id != null && $id == null){
        $sql = "select * from user where salt = '".$link_id."'";
        $result = mysqli_query($conn,$sql);
    }else{
        $sql = "select * from user where user_id = '".$id."'";
        $result = mysqli_query($conn,$sql);
    }
$row=$result->fetch_object();

$user['user_id'] = $row->user_id;
$user['user_email'] = $row->user_email;
$user['user_pass'] = $row->user_pass;
$user['salt'] = $row->salt;
$user['user_activated'] = $row->user_activated;

$current_id = strval($user['salt']);

//current_id is the curent user session pass combined with salt from the user database table
if($current_id == $link_id) {
    $sql = 'update user set user_activated = 1 where user_id=' .$user['user_id'];
    mysqli_query($conn,$sql) or die(mysql_error());
    header("Location: ../activateaccount.php?email=" . $user['user_email']);
}
?>