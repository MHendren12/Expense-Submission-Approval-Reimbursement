<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <style type="text/css">
            .table-style .today {background: #2A3F54; color: #ffffff;}
            .table-style tr:first-child th{background-color:#F6F6F6; text-align:center; font-size: 15px;}        
        </style>
    </head>
<body>
    <div class="row">
        <div class="col-lg-6">
             <div class="col-sm-12 well pull-right-lg" style="border:0px solid">
                <p class="well" style="padding:10px; margin-bottom:2px;">
                  <span class="glyphicon glyphicon-calendar"></span> My Calendar
                </p>
                <div class="col-md-12" style="padding:0px;">
                  <br>
                    <?php
                    include 'Account/calendar.php';
                     
                    $calendar = new Calendar();
                     
                    echo $calendar->show();
                    ?>
                </div>
              </div>           
        </div>
        <div class="col-lg-6">
            <table class="table table-striped table-bordered">
            	<thead>
            		<tr>
            			<th>ID #</th>
            			<th>Submission Date</th>
            			<th>Approval Date</th>
            			<th>Approver</th>
            			<th>View Form</th>
            			<th>Status</th>
            		</tr>
            	</thead>
                <tbody>
                       
                    <?php
                        $sql = "select user.user_id, user.user_fname, user.user_lname, userRole.userRole_Name, expense_activity.date_of_submission, 
                        expense_activity.date_of_approval, expense_activity.expense_activity_id, expense_activity.status, routing.routingUser_id, routingCondition.routingConditionType_id
                        from user
                        left outer join userAssignment on user.user_id=userAssignment.user_id
                        left outer join routing on routing.routingUser_id=user.user_id
                        left outer join routingCondition on routingCondition.routingConditionType_id= user.user_id
                        left outer join userRole on userRole.userRole_id=userAssignment.userRole_id
                        left outer join expense_reports on expense_reports.userAssign_id=userAssignment.userAssign_id 
                        left outer join expense_activity on expense_activity.expense_reports_id=expense_reports.expense_reports_id 
                        where routing.routingUser_id=user.user_id and routingCondition.routingConditionType_id= user.user_id";

                        $result = mysqli_query($conn, $sql);
                        
                        
                        while($row = mysqli_fetch_assoc($result))
                        {   
                            $user_id = $row['user_id'];
                            $expense_activity_id= $row['expense_activity_id'];
                            $userRole_Name = $row['userRole_Name'];
                            $fname= $row['user_fname'];
                            $lname= $row['user_lname'];
                            $date_of_submission = $row ['date_of_submission'];
                            $date_of_approval = $row ['date_of_approval'];
                            $status = $row ['status'];
                            
                            if($row == 0 && $expense_activity_id == null){
                                echo "<td colspan='6' align='center'>No Results or History.</td>";
                            }
                            else if ($expense_activity_id != null){
                    ?>
                                <tr>
                                <td><?php echo $expense_activity_id;?></td>
                                <td><?php echo $date_of_submission;?></td>
                                <td><?php echo $date_of_approval;?></td>
                                <td><?php echo $fname . " ". $lname ?></td>                            
                                <td>
                                <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $user_id; ?>" id="getexpenseform" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i> View</button>
                                </td>
                                <td><?php echo $status;?></td>
                                </tr>
                            <?php
                            }
                        }
               ?>
            
               </tbody>
            </table>            
        	<div class="container">
                <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                     <div class="modal-dialog"> 
                          <div class="modal-content"> 
                          
                               <div class="modal-header"> 
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> 
                                    <h4 class="modal-title">
                                    	<i class="glyphicon glyphicon-user"></i> Expense Form
                                    </h4> 
                               </div> 
                               <div class="modal-body"> 
                               
                               	   <div id="modal-loader" style="display: none; text-align: center;">
                               	   	<img src="images/ajax-loader.gif">
                               	   </div>
                                    
                                   <!-- content will be load here -->                          
                                   <div id="dynamic-content"></div>
                                     
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

<script>
$(document).ready(function(){
	
	$(document).on('click', '#getexpenseform', function(e){
		
		e.preventDefault();
		
		var user_id = $(this).data('id');   // it will get id of clicked row
		
		$('#dynamic-content').html(''); // leave it blank before ajax call
		$('#modal-loader').show();      // load ajax loader
		
		$.ajax({
			url: 'getexpenseform.php',
			type: 'POST',
			data: 'id='+user_id,
			dataType: 'html'
		})
		.done(function(data){
			console.log(data);	
			$('#dynamic-content').html('');    
			$('#dynamic-content').html(data); // load response 
			$('#modal-loader').hide();		  // hide ajax loader	
		})
		.fail(function(){
			$('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
			$('#modal-loader').hide();
		});
		
	});
	
});

</script>

</body>
</html>