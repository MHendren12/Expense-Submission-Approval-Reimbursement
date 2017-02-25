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
                    if(isMySaved($_SESSION['userid'], $conn)){
                        if(isadmin($_SESSION['userid'], $conn)){
                            isAdminTable($conn);
                        }
                        else if(isSubmitter($_SESSION['userid'], $conn)){
                            isSubmitterTable($_SESSION['userid'], $conn);
                        }
                        else if(isApprover($_SESSION['userid'], $conn)){
                            isApproverTable($_SESSION['userid'], $conn);
                        }
                        else if(isSubmitterAndApprover($_SESSION['userid'], $conn)){
                            isSubmitterTable($_SESSION['userid'], $conn);
                            isApproverTable($_SESSION['userid'], $conn);
                        }
                        else{
                            echo "<td colspan='7' align='center'>No Results or History.</td>";
                        }
                    }
                    else{
                       echo "<td colspan='7' align='center'>No Results or History.</td>"; 
                    }
                    ?>
               </tbody>
            </table>            
        </div>
    </div>	

</body>
</html>