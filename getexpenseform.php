<?php
 
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
     <div class="table-responsive">
      
      <table class="table table-striped table-bordered">
          <tr>
          <th>First Name</th>
          <td><?php echo $user_fname; ?></td>
          </tr>
          <tr>
          <th>Last Name</th>
          <td><?php echo $user_lname; ?></td>
          </tr>
      </table>
       
     </div>
   
 <?php    
}
?>