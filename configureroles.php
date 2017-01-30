<?php
    session_start();
	include("Database/config.php");		 
    $conn = getConnection();
        
	$id = $_SESSION['userid'];
    
    $roleId = $_GET['roleid'];
    if ($roleId == "")
    {
        header("Location: ../userroles.php");
    }
    
    $sql = "SELECT userRole_Name
            FROM userRole 
            WHERE userRole_id = '".$roleId."'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $roleName = $row['userRole_Name'];
    
    
?>
<!DOCTYPE html>
<html>
    <header>
        <title>Expense Reimbursement</title>
        
		<!-- Styles -->
		<link href="/Styles/css/bootstrap.css" rel="stylesheet">
		
		<!-- Scripts -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="/Scripts/bootstrap.min.js"></script>
    </header>
    <body>
        <?php
		    include("Navbar/header.php");
	    ?>
        <div class="container" align = "center" style="padding: 100px 0px 0px 0px">
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" align ="left">
                            <div >
                                <div class="container" align="left">
                                    <table>
                                        <tr>
                                            <td style="width:20%">
                                                Role Name
                                            </td style="width:70%">
                                            <td>
                                                Role Description
                                            </td>
                                            <td style="width:10%">
                                                Users
                                            </td>
                                        </tr>
                                        <?php
                                            $sql = "SELECT userRole_Name, userRole_Desc, user_fname, user_lname
                                            FROM userRole 
                                            join userAssignment on userAssignment.userRole_id = userRole.userRole_id
                                            join user on userAssignment.user_id = user.user_id 
                                            where userRole.userRole_id = '".$roleId."'  ";
                                            
                                            $result = mysqli_query($conn, $sql);
                                            while($row = mysqli_fetch_assoc($result))
                                            {    
                                                $userFullName = $row['user_fname']. '&nbsp;'.$row['user_lname'];
                                                $userRole_Name = $row['userRole_Name'];
                                                $userRole_Desc = $row['userRole_Desc'];
                                                
                                        ?>
                                
                                        <tr>
                                            <td>
                                                <?php echo'<span style="width:65%">'.$userRole_Name.'</span>';?>
                                            </td>
                                            <td>
                                                <?php echo'<span>'.$userRole_Desc.'</span>';?>
                                            </td>
                                            <td>
                                                <?php echo'<span>'.$userFullName.'</span>';?>
                                            </td>
                                        </tr>
                                    
                                    <?php
                                        }
                                    ?>
                                    </table>
                                    <hr>
                                    <a  onclick="addUserToRole()" id="addUserToRole">Add a user to this role</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" id="addUser" align = "center" style="padding: 10px 0px 0px 0px; display:none;">
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" align ="left">

                            <form action="Account/addroles.php" onsubmit="return validateUser()" method="post" >
                                <input value="<?php echo $roleId; ?>" id="roleId" name="roleId" style="display:none;"/>
                                <div class="container" align="left">
                                    <h2>
                                        Add user to the <?php echo $roleName; ?> role
                                    </h2>
                                    <select type="text" placeholder="User" class="form-control" id="userRole" name="userSearchBox" list = "list1" style="display:inline-block; width:80%">
                                        <?php
                                            $sql = "select user_id, user_fname, user_lname from user";
                                            $res = mysqli_query($conn, $sql);
                                            echo '<option>- Select User -</option>';
                                            while($row = mysqli_fetch_assoc($res))
                                            {    
                                                $fullName = $row['user_fname'] . '&nbsp;' . $row['user_lname'];
                                                $id = $row['user_id'];
                                                echo "<option value=".$id.">".$fullName."</option>";  
                                            }
                                        ?>    
                                    <input id="submit" input type="submit" class="btn btn-success" value="Add User" name="submit" />
                                </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        function addUserToRole()
        {
            $("#addUserToRole").css("display", "none");
            $("#addUser").css("display", "");
        }
        function validateUser()
        {
            debugger;
            var user = $("#userRole")[0].value;
            var isSet = $("#userRole")[0].value != "" ;
            return isSet;
        }
        
        
    </script>
</html>