<?php
    session_start();
	$id = $_SESSION['userid'];
    include("Database/config.php");		 
    $conn = getConnection();
    
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
                                                Edit Role
                                            </td>
                                        </tr>
                                        <?php
                                            $sql = "SELECT * FROM userRole";
                                            $result = mysqli_query($conn, $sql);
                                            while($row = mysqli_fetch_assoc($result))
                                            {    
                                                $userRole_id = $row['userRole_id'];
                                                $userRole_Name = $row['userRole_Name'];
                                                $userRole_Desc = $row['userRole_Desc'];
                                                $editRoleLink = 'configureroles.php?roleid='.$userRole_id;
                                                
                                        ?>
                                
                                        <tr>
                                            <td>
                                                <?php echo'<span style="width:65%">'.$userRole_Name.'</span>';?>
                                            </td>
                                            <td>
                                                <?php echo'<span>'.$userRole_Desc.'</span>';?>
                                            </td>
                                            <td>
                                                <?php echo'<a href="'.$editRoleLink.'">Edit Role</a>'; ?>
                                            </td>
                                        </tr>
                                    
                                    <?php
                                        }
                                    ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>