<html>
    <head>
        <style type="text/css">
            .table-style .today {background: #2A3F54; color: #ffffff;}
            .table-style tr:first-child th{background-color:#F6F6F6; text-align:center; font-size: 15px;}
            #containerElem .popover{width:1000px;}
        </style>
    </head>
<body>
    <div class="row">
        <div class="col-lg-12">
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
    </div>
    <hr>    
    <div align="center">
        <h2>All Activity</h2>
    </div>
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
                    // Checks whether the user role is admin, submitter, approver, or submitter and approver (lower admin version)
                    // then assigns that current user a table based on thier session user id.
                    if(isadmin($_SESSION['userid'], $conn)){
                        getAdminTable($conn);
                    }
                    else if(isSubmitterAndApprover($_SESSION['userid'], $conn)){
                        getSandATable($_SESSION['userid'], $conn);
                    }
                    else if(isApprover($_SESSION['userid'], $conn)){
                        getApproverTable($_SESSION['userid'], $conn);
                    }
                    else if(isSubmitter($_SESSION['userid'], $conn)){
                        getSubmitterTable($_SESSION['userid'], $conn);
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
<?php
getSubmittedDate($user_id, $conn);
getApprovalDate($user_id, $conn);
?>
<script>
    var submitter = "<?php getCalendarSubmitterInfo($user_id, $conn); ?>";
    var approver = "<?php getCalendarApprovedInfo($user_id, $conn); ?>";
    $('.submitted').wrapInner('<div style="float:left;" />');
    $(".approved").wrapInner('<div style="float:left;" />');    
    $('.submitted').append('<span class="glyphicon glyphicon-share" href="#" title="Submitted" data-placement="bottom" data-toggle="popover" data-trigger="hover" data-content="'+submitter+'" style="float:right;"></span>');
    $(".approved").append('<span class="glyphicon glyphicon-check" href="#" title="Approved Date" data-placement="bottom" data-toggle="popover" data-trigger="hover" data-content="'+approver+'" style="float:right;"></span>');
    
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover(); 
    });   
</script>
</html>