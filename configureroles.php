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
		<link href="/Styles/css/customStyles.css" rel="stylesheet">
    </header>
    <body>
        <?php
		    include("Navbar/header.php");
	    ?>
        <div class="container loggedInContainer" align = "center" >
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" align ="left">
                            <div>
                                <div class="container" align="left">
                                    <?php
                                        $sql = "SELECT userRole_Name, userRole_Desc
                                        FROM userRole 
                                        WHERE userRole.userRole_id = '".$roleId."'  ";
                                        
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        $userRole_Name = $row['userRole_Name'];
                                        $userRole_Desc = $row['userRole_Desc'];
                                        
                                    ?>
                                    <table>
                                        <tr>
                                            <b>Role</b>
                                        </tr>
                                        <tr style="width:100%">
                                            <td>
                                                Role Name
                                            </td>
                                            <td>
                                                <?php echo'<input class="form-control" style="min-width:275px;" value = '.$userRole_Name.' >';?>
                                            </td>
                                        <tr>
                                            <td > 
                                                Role Description
                                            </td>
                                            <td>
                                                <?php echo'<br><textarea class="form-control" style="height40px; width:100%;min-width:275px;max-width:500px;max-height:80px"  >'.$userRole_Desc.'</textarea>';?>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <?php
                                        $sql = "SELECT user_fname, user_lname, userAssignment.userRole_id, userAssignment.user_id 
                                        FROM userRole 
                                        join userAssignment on userAssignment.userRole_id = userRole.userRole_id
                                        join user on userAssignment.user_id = user.user_id 
                                        where userRole.userRole_id = '".$roleId."'  ";
                                        
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0)
                                        {
                                            echo '
                                            <hr>
                                            <table style="width:100%">
                                                <tr>
                                                    <td style="width:80%; " >
                                                        <b>Users</b>
                                                    </td>
                                                    
                                                    <td style="width:20%">
                                                        <b>Action</b>
                                                    </td>
                                                </tr>
                                                ';
                                            while($row = mysqli_fetch_assoc($result))
                                            {    
                                                $userFullName = $row['user_fname']. '&nbsp;'.$row['user_lname'];
                                                $role_id = $row['userRole_id'];
                                                $user_id = $row['user_id'];
                                                    
                                    ?>
                                            <tr>
                                                <td>
                                                    <?php echo'<span>'.$userFullName.'</span>';?>
                                                </td>
                                                <td>
                                                    <?php echo '<a href="Roles/removeuserfromrole.php?user='.$user_id.'&role='.$role_id.'" ><span class="glyphicon glyphicon-remove"></span></a>'; ?>
                                                </td>
                                            </tr>
                                    <?php
                                            }
                                        }
                                        
                                    ?>
                                    </table>
                                    <br><br>
                                    <?php
                                        
                                        
                                        //"select userRole_Name from userRole where userRole_id = '".$roleId."'
                                        //join role_permissions on role_permissions.userRole_id = userRole.userRole_id";
                                        
                                        
                                        
                                    ?>
                                    <b>Permissions</b>
                                    <br>
                                    <table style="width:100%">
                                        <thead>
                                            <td style="width:80%;">
                                                
                                            </td>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <?php
                                                $sql = "select permission_name from permissions";
                                                
                                                //where role_permissions.userRole_id = '".$roleId."'";
                                                $res = mysqli_query($conn, $sql);
                                                echo '<div id="permissions">';
                                                while($row = mysqli_fetch_assoc($res))
                                                {    
                                                    echo '<input type="checkbox" id="'.$row['permission_name'].'" name="permissions" value="'.$row['permission_name'].'" margin-left="5px">'.$row['permission_name']. '&nbsp' ;
                                                }
                                                echo '</div>';
                                            ?>
                                        </tr>
                                        </tbody>
                                        
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
        <br>
        <div class="container normalContainer" id="addUser" align = "center" style="display:none;padding-top:20px;">
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" align ="left">

                            <form action="Roles/adduserrole.php" onsubmit="return validateUser()" method="post" >
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
                                    </select>
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
        $(document).ready(function()
        {
            var role_id = "<?php echo $roleId ?>";
            $.ajax({
    			url: 'WebService/roleinfo.php',
    			type: 'POST',
    			data: { "val": "getPermissionsForRole","roleid":role_id },
    
    		})
    		.done(function(data){
    		   debugger;
    		    var data = JSON.parse(data);
    		    //var chboxes = $("#permissions").find("input[type=checkbox]");
                for (var i = 0; i<= data.length-1; i++)
                {
                    document.getElementById(data[i].permission).checked = true;
                }
               
    		})
    		.fail(function(){
    			
    		});
        });
    		
    
    
    
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