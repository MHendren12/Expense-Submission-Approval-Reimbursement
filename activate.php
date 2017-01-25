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

$link_id = strval($_GET['id']);
$current_id = $user['user_pass'] . $user['salt'];

//current_id is the curent user session pass combined with salt from the user database table
if($current_id == $link_id) {
    $conn = getConnection();
    $query = "update user set user_activated = 1 where id=" . $id;
    $result = mysqli_query($conn,$sql);
}
echo $link_id . "\n" . $current_id . "\n";
echo $id;
?>