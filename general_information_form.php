<?php
  session_start();
  $uid = $inSubmission ? $_SESSION['userid'] : $submitterId;
  
  
?>
<!DOCTYPE html>
<html>

<body>
<?php
  $sql = "SELECT * FROM user WHERE user_id = '".$uid."'";
  $result = mysqli_query($conn, $sql);
  
  while($row = mysqli_fetch_assoc($result))
  {
    $userid = $row['user_id'];
    $fname = $row['user_fname'];
    $lname = $row['user_lname'];
    $address = $row['user_address'];
    $city = $row['user_city'];
    $postal = $row['user_postal'];
    $department = $row['user_department'];
?>
<!--<form action="insert.php" method="post" enctype="multipart/form-data">-->
<b>General Information:</b>
<br><br>
<div id="container">
  <div class="row">
    <div class="col-lg-3">
      <p>
        <label for="general_name">Full Name</label><br>
        <?php echo'<input type="name" placeholder="Name" value="'.$fname ." ". $lname.'" name="name" id=name style="width:80%">';?>
      </p>
    </div>
    <div class="col-lg-3">
        <p>
        <label for="general_address">Address</label><br>
        <?php echo'<input type="text" placeholder="Address" value="'.$address.'" name="address" id=address style="width:80%">';?>
      </p>
    </div>
    <div class="col-lg-3">
        <p>
        <label for="general_city">City</label><br>
        <?php echo'<input type="text" placeholder="City" value="'.$city.'" name="city" id=city style="width:80%">';?>
        </p>
    </div>    
    <div class="col-lg-3">
      
    </div>
  </div>
  <div class="row">
    <div class="col-lg-3">
        <p>
        <label for="general_postal">Postal Code</label><br>
        <?php echo'<input type="text" placeholder="Postal Code" value="'.$postal.'" name="postal" id=postal style="width:80%">';?>
        </p>
    </div>
    <div class="col-lg-3">
      <p>
        <label for="general_department">Department</label><br>
        <?php echo'<input type="text" placeholder="Department" value="'.$department.'" name="department" id=department style="width:80%">';?>
      </p>
    </div>
    <div class="col-lg-6">
      
    </div>
  </div>
  <div class="row">
    <div class="col-lg-0">
      
    </div>    

    <div class="col-lg-5">
      
    </div>
    <div class="col-lg-3">
      
    </div>
  </div>
</div>
<?php
}
?>
<hr>
<!--<input class="btn btn-default" type= "submit" id="submit" value="submit" name="submit" value="">
</form>-->
</body>
</html>
