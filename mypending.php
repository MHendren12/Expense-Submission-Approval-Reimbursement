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
                    if(isMyPending($_SESSION['userid'], $conn)){
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
        	<div class="container">
                <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                     <div class="modal-dialog" style="width:70%"> 
                          <div class="modal-content"> 
                          
                               <div class="modal-header"> 
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> 
                                    <h4 class="modal-title">
                                    	<i class="glyphicon glyphicon-list-alt"></i> Expense Form
                                    </h4> 
                               </div> 
                               <div class="modal-body"> 
                               
                               	   <div id="modal-loader" style="display: none; text-align: center;">
                               	   	<img src="images/ajax-loader.gif">
                               	   </div>
                                   <div class="row">
                                        <div class="col-lg-1"></div>
                                        <div class="col-lg-10">
                                            <div class="well panel panel-default" >
                                                <div class="panel-body">                                       
                                                    <!-- content will be load here -->                          
                                                    <div id="dynamic-content"></div>   
                                                </div>
                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>
                                   </div> 
                                </div> 
                                <div class="modal-footer"> 
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                                </div> 
                                
                         </div> 
                      </div>
               </div>
            </div>               
        </div>
    </div>	
</body>
</html>