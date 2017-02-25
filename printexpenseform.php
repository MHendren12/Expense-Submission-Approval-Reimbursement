<?php

include ('Database/config.php');
if (isset($_REQUEST['id'])) {
  $id = intval($_REQUEST['id']);
  $sql = "SELECT * FROM user WHERE user_id=" . $id;
  $conn = getConnection();
  $result = mysqli_query($conn, $sql);
  while($row = mysqli_fetch_assoc($result)){
    $user_fname = $row['user_fname'];
    $user_lname = $row['user_lname'];         
  }
 
 ?>
<!-- Expense Form Output here -->
  <div class="row">
    <div class="col-lg-1">
  
    </div>
    <div class="col-lg-10">
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <tr>
            <td>
    
            </td>
          </tr>
        </table>
  
       </div>       
    </div>
    <div class="col-lg-1">
  
    </div>
  </div>
<?php    
}
?>