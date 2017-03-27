<html>
    <head>
        <style type="text/css">
            .table-style .today {background: #0083C6;}
            .table-style tr:first-child th{background-color:#F6F6F6; text-align:center; font-size: 15px;}
            .popover{min-width:450px;}
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

<div id="specialS" style="display:none;" >
    
    <?php  getCalendarSubmitterInfo($user_id, $conn); ?>  
</div>
<div id="specialA" style="display:none;">
    
    <?php  getCalendarApprovedInfo($user_id, $conn); ?> 
</div>
<div id="specialFA" style="display:none;">

    <?php  getCalendarFinalApprovedInfo($user_id, $conn); ?> 
</div>
 <div id="specialD" style="display:none;">
    
    <?php  getCalendarDeniedInfo($user_id, $conn); ?> 
</div>  
<?php
//getSubmittedDate($user_id, $conn);
//getApprovalDate($user_id, $conn);
//getFinalApprovalDate($user_id, $conn);
//getDeniedDate($user_id, $conn);
?>
<script>
    //Assign Month Number to left of each cell
    $('.submitted').wrapInner('<div class="SS" style="float:left;" />');
    $(".approved").wrapInner('<div class="AA" style="float:left;" />');  
    $(".finalapproved").wrapInner('<div class"FFAA" style="float:left;" />');
    $(".denied").wrapInner('<div class="DD" style="float:left;" />');
    
    //Append Glyphicon to date and assign to right of the cell
    $('.submitted').append('<span id="submitter" class="submitter glyphicon glyphicon-share" href="#" title="Submitted" data-placement="bottom" data-toggle="popover" data-trigger="hover" style="float:right;"></span>');
    $(".approved").append('<span id="approver" class="approver glyphicon glyphicon-check" href="#" title="Approved" data-placement="bottom" data-toggle="popover" data-trigger="hover" style="float:right;"></span>');
    $(".finalapproved").append('<span id="finalapprover" class="finalapprover glyphicon glyphicon-thumbs-up" href="#" title="Final Approved" data-placement="bottom" data-toggle="popover" data-trigger="hover" style="float:right;"></span>');
    $(".denied").append('<span id="denier" class="denier glyphicon glyphicon-thumbs-down" href="#" title="Denied" data-placement="bottom" data-toggle="popover" data-trigger="hover" style="float:right;"></span>');

    //Remove expense form action on same day, ex. Expense form is submitted and final approved.
    //$(".submitted.finalapproved").find(".submitter").remove();
    //$(".submitted.denied").find(".submitter").remove();
    //$(".approved.finalapproved").find(".approver").remove();
    //$(".approved.denied").find(".approver").remove();

    var originalLeave = $.fn.popover.Constructor.prototype.leave;
    $.fn.popover.Constructor.prototype.leave = function(obj){
      var self = obj instanceof this.constructor ?
        obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)
      var container, timeout;
    
      originalLeave.call(this, obj);
    
      if(obj.currentTarget) {
        container = $(obj.currentTarget).siblings('.popover')
        timeout = self.timeout;
        container.one('mouseenter', function(){
          clearTimeout(timeout);
          container.one('mouseleave', function(){
            $.fn.popover.Constructor.prototype.leave.call(self, self);
          });
        })
      }
    };
    
    $(function(){
        $('.submitter').popover({
            content: $('#specialS').html(),
            html: true,
            delay: {show : 0, hide : 1}
        });
        $('.approver').popover({
            content: $('#specialA').html(),
            html: true,
            delay: {show : 0, hide : 1}            
        });
        $('.finalapprover').popover({
            content: $('#specialFA').html(),
            html: true,
            delay: {show : 0, hide : 1}            
        });
        $('.denier').popover({
            content: $('#specialD').html(),
            html: true,
            delay: {show : 0, hide : 1}            
        });        
    });
</script>
</html>