
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
                    //include("WebService/accountinfo.php");
                     
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
            			<th>Submitter</th>
            			<th>Current Approver</th>
            			<th>View Form</th>
            			<th>Status</th>
            		</tr>
            	</thead>
                <tbody>
                       
                    <?php
                        $sql = "select * from expense_reports
                                join user on user.user_id = expense_reports.submitter_id
                                where submitter_id = '".$_SESSION['userid']."'
                                union
                                select * from expense_reports
                                join user on user.user_id = expense_reports.approver_id
                                where approver_id = '".$_SESSION['userid']."'";
                                
                                
                                /*
                                "select * from expense_reports
                                join user on user.user_id = expense_reports.submitter_id
                                where submitter_id = 11
                                union
                                select * from expense_reports
                                join user on user.user_id = expense_reports.approver_id
                                where approver_id = 11";
                                */
                        /*$sql = "select user.user_id , user.user_fname, user.user_lname, expense_reports.submission_date, routing.routingUser_id, expense_reports.expense_reports_id, expense_reports.expensereport_status
                                from expense_reports
                                
                                left join user on user.user_id  = expense_reports.approver_id
                                
                                left join routing on routing.routingUser_id=user.user_id

                                where routing.routingUser_id=8
                                
                                union
                                
                                select user.user_id as submitter_id, user.user_fname, user.user_lname,expense_reports.submission_date, routingCondition.routingConditionType_id, expense_reports.expense_reports_id, expense_reports.expensereport_status
                                from expense_reports
                                
                                left join user on user.user_id  = expense_reports.submitter_id
                                  
                                left join routingCondition on routingCondition.routingConditionType_id= user.user_id
                                
                                where routingCondition.routingConditionType_id= 8";
*/
                        $result = mysqli_query($conn, $sql);
                        $num_rows = mysqli_num_rows($result);
                        
                        if ($num_rows > 0)
                        {
                            while($row = mysqli_fetch_assoc($result))
                            {   
                                
                                $expense_reports_id = $row['expense_reports_id'];
                                $user_id = $row['user_id'];
                                $fname = $row['user_fname'];
                                $lname = $row['user_lname'];
                                $name = $fname . " ". $lname;
                                $submission_date = $row ['submission_date'];
                                $approver_id = $row['approver_id'];
                                $status = $row ['expensereport_status'];
                                $approver = getUserNameById($approver_id, $conn);
                    ?>
                                <tr>
                                    <td><?php echo $expense_reports_id; ?></td>
                                    <td><?php echo $submission_date; ?></td>
                                    <td><?php echo $name; ?></td>    
                                    <td><?php echo $approver; ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#view-modal" data-id="<?php echo $expense_reports_id; ?>" id="getexpenseform" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i> View</button>
                                    </td>
                                    <td><?php echo $status;?></td>
                                </tr>
                        <?php
                            }
                        }
                        else {
                            echo "<td colspan='6' align='center'>No Results or History.</td>";
                            echo $_SESSION['userid'];
                        }
                    
               ?>
               </tbody>
            </table>            
        	<div class="container">
                <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<script>
$(document).ready(function(){
    
	$(document).on('click', '#getexpenseform', function(e){
		
		e.preventDefault();
		
		var formid = $(this).data('id');   // it will get id of clicked row
		
		$('#dynamic-content').html(''); // leave it blank before ajax call
		$('#modal-loader').show();      // load ajax loader
		
		$.ajax({
			url: 'expense_form.php',
			type: 'POST',
			data: 'id='+formid,
			dataType: 'html'
		})
		.done(function(data){
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