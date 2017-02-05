<?php
    $sql = "select * from routingCondition";
    $result = mysqli_query($conn, $sql);
	$num_rows = mysqli_num_rows($result);
	if ($num_rows == 0)
	{
	    $noRoutes = true;
	}
	else {
	    $noRoutes = false;
	}
?>
<!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
        <div>
            <?php
                if($noRoutes)
                {
            ?>
            <p>
                No routes yet!
                <br>
                <a onclick="createNewroutingCondtion()">Create a new routing condition! </a>
            </p>
            
            <?php
                }
                else
                {
            ?>
            <table style="width:100%" border="2">
                <tr>
                    <td style="width:15%">
                        <b>
                            Condition:
                        </b>
                    </td>
                    <td style="width:15%">
                        Approver Level 1
                    </td>
                    <td style="width:15%">
                        Approver Level 2
                    </td>
                    <td style="width:15%">
                        Approver Level 3
                    </td>
                    <td style="width:15%">
                        Approver Level 4
                    </td>
                    <td style="width:15%">
                        Approver Level 5
                    </td>
                    <td aign="right">
                        <div class="dropdown">
                            <a data-toggle="dropdown">
                                <span class="glyphicon glyphicon-menu-hamburger">
                                    
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a id="'.$routingCondition_id.'" onclick="createNewroutingCondtion()">Add Routing Condition</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php
                    $sql = "select routingCondition.routingCondition_id, user.user_fname, user_lname from routingCondition
                    join user on routingCondition.routingConditionType_id = user.user_id"
                    ;
                    $res = mysqli_query($conn, $sql);
                    
                    while($row = mysqli_fetch_assoc($res))
                    {    
                        $routingCondition_id = $row['routingCondition_id'];
                        $username = $row['user_fname'] . '&nbsp;' . $row['user_lname'];
                ?>
                <tr>
                    <td>
                        <?php
                        
                            echo $username;
                        ?>
                    </td>
                    <?php
                        $query = "select user.user_fname, user_lname, routingRow_id, routingColumn_id from routing
                        join user on routing.routingUser_id = user.user_id
                        where routingRow_id = '".$routingCondition_id."' 
                        order by routingRow_id asc, routingColumn_id asc";
                        $result = mysqli_query($conn, $query);
                        $num_rows = mysqli_num_rows($result);
                        while($row2 = mysqli_fetch_assoc($result))
                        {    
                             $user_name = $row2['user_fname'] . '&nbsp;' . $row2['user_lname'];
                    ?>
                    <td>
                        <?php echo $user_name; ?>
                    </td>
                    
                <?php
                        }
                        $fillTable = 5 - $num_rows;
                        while ($fillTable != 0)
                        {
                            echo '<td></td>';
                            $fillTable--;
                        }
                    echo '<td aign="right"><div class="dropdown"><a data-toggle="dropdown"><span class="glyphicon glyphicon-menu-hamburger"></span></a><ul class="dropdown-menu"><li><a id="'.$routingCondition_id.'" onclick="addApproverLevel(this.id)">Add approver level</a></li></ul></div></td>';
               
                    }
                ?>
                
                </tr>

            </table>
            <?php
                }
            ?>
        </div>
        <div id="popup" style="display:none;" align="center" >
            <div class="overlay"></div>
            <div class="popupForm">
                <div class="well panel panel-default" style="width:800px;height:500px;">
                    <div class="panel-body">
                        <div class="row" style="position:relative">
                            <a id="close" onclick="closeDialog()" style="position:absolute; right:-6%"></a>
                            
                            <form action="Routing/addroutingcondition.php" method="post" id="addcondition" style="display:none;" >
                                <div align="left" style="padding:0px 15px 15px 15px">
                                    <h2 style="display:inline-block; padding-right:15px;">
                                        Condition:
                                    </h2>
                                    <select type="text" placeholder="User" class="form-control" id="Condition" name="userSearchBox" list = "list1" style="display:inline-block; width:80%">
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
                                    <hr>
                                    <input id="submit" input type="submit" class="btn btn-success" value="Add Condition" name="submit" />
                                    <a class="btn btn-default" onclick="closeDialog() ">cancel &raquo;</a>
                                </div>
                            </form>
                            <form action="Routing/addapproverlevel.php" method="post" id="addapproverlevel" style="display:none;" >
                                <div align="left" style="padding:0px 15px 15px 15px">
                                    <h2 style="display:inline-block; padding-right:15px;">
                                        Approver:
                                    </h2>
                                    <select type="text" placeholder="User" class="form-control" id="Condition" name="userSearchBox" list = "list1" style="display:inline-block; width:80%">
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
                                    <hr>
                                    <input id="submit" input type="submit" class="btn btn-success" value="Add Approver" name="submit" />
                                    <a class="btn btn-default" onclick="closeDialog() ">cancel &raquo;</a>
                                </div>
                                <input id="rowId" name="rowId" style="display:none;" value=""/>
                            </form>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        function createNewroutingCondtion()
        {
            $("#popup").css("display", "block");
            $("#addcondition").css("display", "block");
            positionDialog();
        }
        function closeDialog()
        {
            $("#popup").css("display", "none");
        }
        
        function positionDialog()
        {
            var width = ($(document).width() - $(window).width()) / 2;
            var height = ($(document).height() - $(window).height()) / 2;
            $("#popup").css("left", width);
            $("#popup").css("top", height);
        }
        
        function addApproverLevel(row)
        {
            
            $("#popup").css("display", "block");
            $("#addapproverlevel").css("display", "block");
            $("#addcondition").css("display", "none");
            positionDialog();
            $("#rowId").val(row);
            debugger;
        }
        
    </script>
</html