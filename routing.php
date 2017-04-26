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
                    <td style="width:16%">
                        <b>
                            Condition:
                        </b>
                    </td>
                    <?php
                        $sql = "select * from routingLevels order by routinglevel_id asc";
                        $res = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($res))
                        {    
                            $routingLevels_name = $row['routinglevel_name'];
                            echo '<td class="approverLevelHeader" onmouseover="mouseover(this,2)" onmouseout="mouseover(this,3)" data-placement="auto rigth" data-toggle="popover" data-trigger="click"  style="width:16%">'.$routingLevels_name.'</td>';
                        }
                    
                    ?>
                    
                    
                    
                    
                    <!--
                    
                    <td style="width:16%">
                        Approver Level 1
                    </td>
                    <td style="width:16%">
                        Approver Level 2
                    </td>
                    <td style="width:16%">
                        Approver Level 3
                    </td>
                    <td style="width:16%">
                        Approver Level 4
                    </td>
                    <td style="width:16%">
                        Approver Level 5
                    </td>
                    -->
                    
                    
                    <td align="right" style="width:3%">
                        <div class="dropdown">
                            <a data-toggle="dropdown">
                                <span class="glyphicon glyphicon-menu-hamburger">
                                    
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="menuCell"  id="'routingCondition_id'" data-placement="auto left" data-toggle="popover" data-trigger="click">Add Routing Condition</a>
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
                        left join user on routing.routingUser_id = user.user_id
                        where routingRow_id = '".$routingCondition_id."' 
                        order by routingRow_id asc, routingColumn_id asc";
                        $result = mysqli_query($conn, $query);
                        $num_rows = mysqli_num_rows($result);
                        $rowId = 0;
                        while($row2 = mysqli_fetch_assoc($result))
                        {    
                             $rowId= $row2['routingRow_id'];
                             $colId = $row2['routingColumn_id'];
                             $user_name = $row2['user_fname'] . '&nbsp;' . $row2['user_lname'];
                             $class = $row2['user_fname'] == "" ? "dataCellEmpty" : "dataCell";
                             echo '<td class="'.$class.'" id="row'.$rowId.'_col'.$colId.'"  onmouseover="mouseover(this,0)" onmouseout="mouseover(this,1)" data-placement="auto bottom" data-toggle="popover" data-trigger="click" >'.$user_name.'</td>';

                        }
                            
                        if ($num_rows > 0)
                        {
                            $fillTable = 5 - $num_rows;
                            $i = 1;
                        }
                        else {
                            $fillTable = 5;
                            $i = $num_rows+1;
                        }
                        while ($i <= $fillTable)
                        {
                            echo '<td class="dataCellEmpty" id="row'.$routingCondition_id.'_col'.$i.'" onmouseover="mouseover(this,0)" onmouseout="mouseover(this,1)" data-placement="auto bottom" data-toggle="popover" data-trigger="click" ></td>';
                            $i++;
                        }
                    echo '<td align="right">
                            <div class="dropdown">
                                <a data-toggle="dropdown"><span class="glyphicon glyphicon-menu-hamburger"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a class="menuCellDelete" id="'.$routingCondition_id.'" data-placement="auto left" data-toggle="popover" data-trigger="click" >Delete routing condition</a></li>
                                </ul>
                            </div>
                        </td>';
                    }
                ?>
                
                </tr>

            </table>
            <?php
                }
            ?>
        </div>
        <div id="addconditionForm" style="display:none;" >
            <form action="Routing/addroutingcondition.php" method="post" id="addcondition">
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
                    <a class="btn btn-default" onclick="closeDialog(this) ">cancel &raquo;</a>
                </div>
            </form>
        </div>
        <div id="removeroutingconditionForm" style="display:none;">
            <form action="Routing/removeroutingcondition.php" method="post"  onsubmit="return checkinput();" id="removeroutingcondition" >
                <div align="left" style="padding:0px 15px 15px 15px">
                    <h3 style="display:inline-block; padding-right:15px;">
                        Are you sure you want to remove this routing condition?
                    </h3>
                    <br>
                    <input type="radio" id="delete" name="delete" value="yes">
                    <label for="delete">Yes</label>
                    <input type="radio" id="keep" name="delete" value="no">
                    <label for="keep">No</label>
                    <hr>
                    <input id="submit" input type="submit" class="btn btn-success" value="Submit" name="submit" />
                    <a class="btn btn-default" onclick="closeDialog() ">cancel &raquo;</a>
                </div>
                <input id="rowId2" name="rowId2" style="display:none;" value=""/>
            </form>
        </div>
        <div id="addapproverlevelForm" style="display:none;">
            <form action="Routing/reassignapprover.php" method="post" id="addapproverlevel"  >
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
                <input id="rowId3" name="rowId3" style="display:none;" value=""/>
                <input id="colId" name="colId" style="display:none;" value=""/>
            </form>
        </div>
        <div id="reassignroutingconditionForm" style="display:none;">
            <form action="Routing/reassignapprover.php" method="post" id="reassignroutingcondition">
                <div align="left" style="padding:0px 15px 15px 15px">
                    <h2 style="display:inline-block; padding-right:15px;">
                        New Approver:
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
                    
                    <input id="submit" input type="submit" class="btn btn-success" value="Assign Approver" name="submit" />
                    <a class="btn btn-default" onclick="closeDialog() ">cancel &raquo;</a>
                </div>
                <input id="rowId3" name="rowId3" style="display:none;" value=""/>
                <input id="colId" name="colId" style="display:none;" value=""/>
            </form> 
        </div>
        <div id="renameApproverLevelForm" style="display:none;">
            <form action="Routing/renameApproverLevel.php" method="post" id="renameApproverLevel"  >
                <div align="left" style="padding:0px 15px 15px 15px">
                    <h2 style="display:inline-block; padding-right:15px;">
                        New Name:
                    </h2>
                    <input class="form-control" id="levelname" name="levelname">
                    <hr>
                    <input id="submit" input type="submit" class="btn btn-success" value="Update" name="submit" />
                    <a class="btn btn-default" onclick="closeDialog() ">cancel &raquo;</a>
                </div>
                <input id="headerId" name="headerId" style="display:none;" value=""/>
            </form>
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
            $('[data-toggle="popover"]').popover('hide');
            $("#reassignroutingcondition").css("display", "none");
            $("#removeroutingcondition").css("display", "none");
            $("#addapproverlevel").css("display", "none");
            $("#addcondition").css("display", "none");
        }

        

        
        function checkinput()
        {
            debugger;
            var input= $("input[name=delete]:checked").val();
            var deleteRC = input == "yes";
            if (!deleteRC)
            {
                $('[data-toggle="popover"]').popover('hide');
            }
            return deleteRC;
        }
        
        function changeApprover(cell)
        {
            var row = cell.split("_")[0];
            var rowId = row.slice("row".length);
            var col = cell.split("_")[1];
            var colId = col.slice("col".length);
            debugger;
            //$("#popup").css("display", "block");
            //positionDialog();
            $(".popover-content").find("#rowId3").val(rowId);
            $(".popover-content").find("#colId").val(colId);
        }
        function showDialog(elementId)
        {
            $(elementId).css("display", "block");
            
        }
        
        function mouseover(element, type)
        { 
            element.style.cursor = "pointer"; 
            if (type == 0)
                $(element).css('background-color', '#337ab7');
            else if (type == 1)
                $(element).css('background-color', '#f5f5f5');
            else if( type == 2)
                $(element).css('background-color', '#B2D5F4');
            else
                $(element).css('background-color', '#f5f5f5');

                
            
        }
        
        $('.dataCellEmpty').popover({
            content: $('#addapproverlevelForm').html(),
            html: true,
            container: 'body'
        }).click(function(e)
        {
          showDialog("addapproverlevelForm");
          if ( !$(".popover-content").parent()[0] || $(".popover-content").parent()[0].style.display != "block" )
            $(this).click();
            
            
          changeApprover(this.id);
        });
        
        
        
        $('.dataCell').popover({
            content: $('#reassignroutingconditionForm').html(),
            html: true,
            container: 'body'
        }).click(function(e)
        {
          changeApprover(this.id);
          showDialog("reassignroutingconditionForm");
          if ( !$(".popover-content").parent()[0] || $(".popover-content").parent()[0].style.display != "block" )
            $(this).click();
        });
        
        
        
        $('.menuCell').popover({
            content: $('#addconditionForm').html(),
            html: true,
            container: 'body'
            
        }).click(function(e)
        {
          showDialog("addconditionForm");
          if ( !$(".popover-content").parent()[0] || $(".popover-content").parent()[0].style.display != "block" )
            $(".menuCell").click();
        });
        
        
        
        $('.menuCellDelete').popover({
            content: $('#removeroutingconditionForm').html(),
            html: true,
            container: 'body'
            
        }).click(function(e)
        {
          showDialog("removeroutingconditionForm");
          if ( !$(".popover-content").parent()[0] || $(".popover-content").parent()[0].style.display != "block" )
            $(this).click();
          
          
          $(".popover-content").find("#rowId2").val(this.id);
        });
        
        
        
        
        $('.approverLevelHeader').popover({
            content: $('#renameApproverLevelForm').html(),
            html: true,
            container: 'body'
            
        }).click(function(e)
        {
            
          showDialog("renameApproverLevelForm");
          if ( !$(".popover-content").parent()[0] || $(".popover-content").parent()[0].style.display != "block" )
            $(this).click();
          
          
          $(".popover-content").find("#headerId").val(this.cellIndex);
         
        });
        
        
        
        
        
        
    </script>
</html