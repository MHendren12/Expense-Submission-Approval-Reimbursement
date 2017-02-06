<?php
    session_start();
    $user_id = $_SESSION['userid'];
    include("WebService/accountinfo.php");
    $editUser = $_GET['editUser'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Expense Reimbursement</title>
        <!-- Styles -->
        <link href="/Styles/css/bootstrap.css" rel="stylesheet">
        <link href="/Styles/css/customStyles.css" rel="stylesheet">
        <style>
            input.form-control
            {
                width:35%;
            }
        </style>
        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="/Scripts/bootstrap.min.js"></script>
        
        
    </head>
    <body>
        <?php
            include("Navbar/header.php");
            if($_SESSION['userid'] == null){
                header("Location: index.php");
            }
            if ($editUser == null)
            {
        ?>
        <div class="container loggedInContainer" >
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" >
                            <table style="width:100%">
                                <tr>
                                    <td>
                                        <b>Name</b>
                                    </td>
                                    <td>
                                        <b>Email</b>
                                    </td>
                                    <td>
                                        <b>Actions</b>
                                    </td>
                                </tr>
                                <?php
                                $sql = 'select * from user';
                                $result = mysqli_query($conn,$sql);
                                while($row = mysqli_fetch_assoc($result))
                                {     
                                    $userid = $row['user_id'];
                                    $username = $row['user_fname']." ".$row['user_lname'];
                                    $email = $row['user_email'];
                                    echo 
                                        '<tr>
                                            <td>
                                                '.$username.' 
                                            </td>
                                            <td>
                                                '.$email.'
                                            </td>
                                            <td>
                                                <a href="userlist.php?editUser='.$userid.'" ><span class="glyphicon glyphicon-pencil" title="Edit User" ></span></a>
                                                <a href="Account/deleteuser.php?userid='.$userid.'" title="Delete User" ><span class="glyphicon glyphicon-remove"></span></a>
                                            </td>
                                        </tr>'; 
                                }
                            ?>
                            </table>
                            <hr>
                            <a class="btn btn-default" value="Add User" onclick="addNewUser()" align="left" >Add New User</a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
            else 
            {
        ?>
        <div class="container loggedInContainer" align = "center">
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" >
                            <table style="width:100%">
                                <?php
                                $sql = 'select * from user where user_id = "'.$editUser.'"';
                                $result = mysqli_query($conn,$sql);
                                while($row = mysqli_fetch_assoc($result))
                                {     
                                    $userid = $row['user_id'];
                                    $username = $row['user_fname']." ".$row['user_lname'];
                                    $email = $row['user_email'];
                                    $dob = $row['user_dob'];
                                    $isadmin = $row['is_admin'] == 1 ? "Administrator" : "User";
                                    $status = $row['user_activated'] == 1 ? "Active" : "Inactive";
                                    echo 
                                        '<tr>
                                            <td>
                                                <b>Name</b>
                                                <input class="form-control" value="'.$username.'"> 
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Email</b>
                                                <input class="form-control" value="'.$email.'">
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Date of Birth</b>
                                                <input type="date" class="form-control" value="'.$dob.'"> 
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Account Type</b><br>
                                                '.$isadmin.'
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Status</b><br>
                                                '.$status.'
                                                <br>
                                            </td>
                                            
                                        </tr>'; 
                                }
                            ?>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
        <br><br>
        <div class="container normalContainer" id="addUser" style="display:none;">
            <br>
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <form action="Account/register.php">
                            <div class="row" align="left">
								<input class="form-control" name="FName" placeholder="First Name" required style="display:inline-block;" type="text">													
								<input class="form-control" name="LName" placeholder="Last Name" required style="display:inline-block;" type="text">													
    						</div>											
    						<br>
    						<div class="row" align="left">
    						    <input class="form-control" name="Email" placeholder="Email" required type="text">
    						</div>
    						<div class="row" align="left" style="display:none;">
    						    
    						        <input class="form-control" id="Password" name="Password" placeholder="Password" value="password" required type="text">
    						</div>
    						<div class="row" align="left" style="display:none;">
    						    <select class="btn btn-default" name="DOBMonth" id="DOBMonth" value="01" required>
            						<option>- Month -</option>
            						<?php 
            							$months = array("January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October","November", "December");
            							$count = 0;
            							foreach($months as $month){
            								echo "<option value='" . $count . "'>" . $month . "</option>";
            								$count++;
            							} 
        							?>
    							</select>
    							<select class="btn btn-default" name="DOBDay" id="DOBDay" value="01" required>
    								<option>- Day -</option>
    								<?php
    									for($i=1; $i<=31; $i++){
    										echo "<option value='" . $i . "'>" . $i . "</option>";
    									} 
    								?>
    							</select>
    							<select class="btn btn-default" name="DOBYear" id="DOBYear" value="1947"  required>
    								<option>- Year -</option>
    								<?php 
    									for($i=2017; $i>=1947; $i--)
    									{
    										echo "<option value='" . $i . "'>" . $i . "</option>";
    									} 
    								?>
    							</select>
    						</div>
    						<br>
    						
    						<div class="row" align="left">
    						    <!--<input id="submit" type="submit" class="btn btn-success" value="Add User" name="submit"  />-->
    						    <a onclick="hideAddUser()" class="btn btn-default">Cancel</a>
    						    
						    </div>
						    
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        <div align="center">
            <label>&#169; Copyright 2017, RASE Corp. English(US). All Right Reserved.</label>
        </div>
    </body>
    <script>
        function addNewUser()
        {
            $("#addUser").css("display","");
        }
        function hideAddUser()
        {
             $("#addUser").css("display","none");
        }
        
    </script>
</html>