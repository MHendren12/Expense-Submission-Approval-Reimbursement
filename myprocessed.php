<html> 
    <body>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-bordered">
            	<thead>
            		<tr>
            			<th>ID #</th>
            			<th>Submitter</th>
            			<th>Approver</th>
            			<th>Submission Date</th>
            			<th>Approval Date</th>
            			<th>Status</th>            			
            			<th style="text-align:center">View Form</th>
            		</tr>
            	</thead>
                <tbody>
                    <?php
                    // First checks if expense form is set to Approved, then
                    // checks whether the user role is admin, submitter, approver, or submitter and approver (lower admin version)
                    // then assigns that current user a table based on thier session user id.                    
                    if(isMyProcessed($_SESSION['userid'], $conn)){
                        if(isadmin($_SESSION['userid'], $conn)){
                            getSandATable($_SESSION['userid'], $conn, "Processed");
                        }
                        else if(isSubmitterAndApprover($_SESSION['userid'], $conn, "Processed"))
                        {
                            getSandATable($_SESSION['userid'], $conn, "Processed");
                        }
                        else if(isSubmitter($_SESSION['userid'], $conn)){
                            getSubmitterTable($_SESSION['userid'], $conn, "Processed");
                        }
                        else if(isApprover($_SESSION['userid'], $conn)){
                            getApproverTable($_SESSION['userid'], $conn,"Processed");
                        }
                        
                        else{
                            echo "<td colspan='7' align='center'>No Results or History.</td>";
                        }
                    }
                    else{
                       echo "<td colspan='7' align='center'>No Results or History.</td>"; 
                    }
                    if($_GET['page'] == ""){
                        $prev = 1;
                        $next = 1;
                    }
                    else{
                        $prev = $_GET['page'];
                        $next = $_GET['page'];
                    }
                    ?>
               </tbody>
            </table>            
        </div>
    </div>	
    <div align="center">
    <ul class='pagination text-center' id="pagination">
        <?php 
                    if(isadmin($_SESSION['userid'], $conn)){
        ?>
                        <li id="prev"><a href='home.php?page=<?php if($_GET['page']==1 || $_GET['page']=="") { echo $prev;} else{echo --$prev;} ?>#myprocessed'>Prev</a></li>
                        <li class='active' id="next"><a href='home.php?page=<?php if(getNumRows($conn, "Processed")==0){ echo $next; } else if(getNumRows($conn, "Processed")<5){echo $next;} else{echo ++$next;} ?>#myprocessed'>Next</a></li>        
        <?php
                    }
                    else if(isSubmitterAndApprover($_SESSION['userid'], $conn)){
        ?>
                        <li id="prev"><a href='home.php?page=<?php if($_GET['page']==1 || $_GET['page']=="") { echo $prev;} else{echo --$prev;} ?>#myprocessed'>Prev</a></li>
                        <li class='active' id="next"><a href='home.php?page=<?php if(getNumRowsSandA($conn, "Processed")==0){ echo $next; } else if(getNumRowsSandA($conn, "Processed")<5){echo $next;} else{echo ++$next;} ?>#myprocessed'>Next</a></li>           
        <?php 
                    }
                    else if(isApprover($_SESSION['userid'], $conn)){
        ?>
                        <li id="prev"><a href='home.php?page=<?php if($_GET['page']==1 || $_GET['page']=="") { echo $prev;} else{echo --$prev;} ?>#myprocessed'>Prev</a></li>
                        <li class='active' id="next"><a href='home.php?page=<?php if(getNumRowsA($conn, "Processed")==0){ echo $next; } else if(getNumRowsA($conn, "Processed")<5){echo $next;} else{echo ++$next;} ?>#myprocessed'>Next</a></li>           
        <?php
                    }
                    else if(isSubmitter($_SESSION['userid'], $conn)){
        ?>
                         <li id="prev"><a href='home.php?page=<?php if($_GET['page']==1 || $_GET['page']=="") { echo $prev;} else{echo --$prev;} ?>#myprocessed'>Prev</a></li>
                        <li class='active' id="next"><a href='home.php?page=<?php if(getNumRowsS($conn, "Processed")==0){ echo $next; } else if(getNumRowsS($conn, "Processed")<5){echo $next;} else{echo ++$next;} ?>#myprocessed'>Next</a></li>          
        <?php
                    }
        ?>
    </ul>
    </div>
</body>
</html>