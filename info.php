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
                    if(!$_GET['page']){
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
                        <li id="prev"><a href='home.php?page=<?php if($_GET['page']==1 || !$_GET['page']) { echo $prev;} else{echo --$prev;} ?>'>Prev</a></li>
                        <?php 
                        $totalNumRows = getTotalNumRows($conn);
                        $i = 0+$_GET['page'];
                        if(!$_GET['page']){
                            $totalNums = round($totalNumRows/5)-1+$_GET['page']-1;
                        }
                        else{
                            $totalNums = round($totalNumRows/5)-2+$_GET['page']-1;
                        }
                        if($i==0){
                            $i=1;
                        }

                        if(ceil($totalNumRows/25)<$_GET['page']){
                            if($totalNumRows%25>=5){
                                $totalNums = round($totalNumRows/5)+round(($totalNumRows%25)%5);
                                $i = ceil($totalNumRows/25)+round(($totalNumRows%25)%5);
                            }
                            else{
                                $totalNums = ceil($totalNumRows/5);
                            }
                            
                        }
                        else{
                            $totalNums++;                            
                        }
                        $j = ceil($totalNumRows);
                        if(ceil($totalNumRows/5)<5){
                            $i=1;   
                        }
                        for($i; $i<=$j; $i++){
                            if($i<=$totalNums){
                        ?>
                                <li><a class="num-<?php echo $i; ?>" href='home.php?page=<?php echo $i; ?>'><?php echo $i; ?></a></li> 
                        <?php
                            }
                        }
                        ?>
                        <li class='active' id="next"><a href='home.php?page=<?php if(getNumRows($conn)<5 || $totalNumRows<=5 || $totalNums==$_GET['page']){ echo $next; } else{echo ++$next;} ?>'>Next</a></li>        
        <?php
                    }
                    else if(isSubmitterAndApprover($_SESSION['userid'], $conn)){
        ?>
                        <li id="prev"><a href='home.php?page=<?php if($_GET['page']==1 || !$_GET['page']) { echo $prev;} else{echo --$prev;} ?>'>Prev</a></li>
                        <?php 
                        $totalNumRows = getTotalNumRowsSandA($conn);
                        $i = 0+$_GET['page'];
                        if(!$_GET['page']){
                            $totalNums = 5+$_GET['page']-1;
                        }
                        else{
                            $totalNums = 4+$_GET['page']-1;
                        }
                        if($i==0){
                            $i=1;
                        }

                        if(ceil($totalNumRows/25)<$_GET['page']){
                            if($totalNumRows%25>=5){
                                $totalNums = round($totalNumRows/5)+round(($totalNumRows%25)%5);
                                $i = ceil($totalNumRows/25)+round(($totalNumRows%25)%5);
                            }
                            else{
                                $totalNums = ceil($totalNumRows/5);
                            }
                            
                        }
                        else{
                            $totalNums++;                            
                        }
                        $j = ceil($totalNumRows);
                        if(ceil($totalNumRows/5)<5){
                            $i=1;   
                        }
                        for($i; $i<=$j; $i++){
                            if($i<=$totalNums){
                        ?>
                                <li><a class="num-<?php echo $i; ?>" href='home.php?page=<?php echo $i; ?>'><?php echo $i; ?></a></li> 
                        <?php
                            }
                        }
                        ?>                     
                        <li class='active' id="next"><a href='home.php?page=<?php if(getNumRowsSandA($conn)<5 || $totalNumRows<=5 || $totalNums==$_GET['page']){ echo $next; } else{echo ++$next;} ?>'>Next</a></li>           
        <?php 
                    }
                    else if(isApprover($_SESSION['userid'], $conn)){
        ?>
                        <li id="prev"><a href='home.php?page=<?php if($_GET['page']==1 || !$_GET['page']) { echo $prev;} else{echo --$prev;} ?>'>Prev</a></li>
                        <?php 
                        $totalNumRows = getTotalNumRowsA($conn);
                        $i = 0+$_GET['page'];
                        if(!$_GET['page']){
                            $totalNums = round($totalNumRows/5)-1+$_GET['page']-1;
                        }
                        else{
                            $totalNums = round($totalNumRows/5)-2+$_GET['page']-1;
                        }
                        if($i==0){
                            $i=1;
                        }

                        if(ceil($totalNumRows/25)<$_GET['page']){
                            if($totalNumRows%25>=5){
                                $totalNums = round($totalNumRows/5)+round(($totalNumRows%25)%5);
                                $i = ceil($totalNumRows/25)+round(($totalNumRows%25)%5);
                            }
                            else{
                                $totalNums = ceil($totalNumRows/5);
                            }
                            
                        }
                        else{
                            $totalNums++;                            
                        }
                        $j = ceil($totalNumRows);
                        if(ceil($totalNumRows/5)<5){
                            $i=1;   
                        }
                        for($i; $i<=$j; $i++){
                            if($i<=$totalNums){
                        ?>
                                <li><a class="num-<?php echo $i; ?>" href='home.php?page=<?php echo $i; ?>'><?php echo $i; ?></a></li> 
                        <?php
                            }
                        }
                        ?>                     
                        <li class='active' id="next"><a href='home.php?page=<?php if(getNumRowsA($conn)<5 || $totalNumRows<=5 || $totalNums==$_GET['page']){ echo $next; } else{echo ++$next;} ?>'>Next</a></li>           
        <?php
                    }
                    else if(isSubmitter($_SESSION['userid'], $conn)){
        ?>
                        <li id="prev"><a href='home.php?page=<?php if($_GET['page']==1 || !$_GET['page']) { echo $prev;} else{echo --$prev;} ?>'>Prev</a></li>
                        <?php 
                        $totalNumRows = getTotalNumRowsS($conn);
                        $i = 0+$_GET['page'];
                        if(!$_GET['page']){
                            $totalNums = round($totalNumRows/5)-1+$_GET['page']-1;
                        }
                        else{
                            $totalNums = round($totalNumRows/5)-2+$_GET['page']-1;
                        }
                        if($i==0){
                            $i=1;
                        }

                        if(ceil($totalNumRows/25)<$_GET['page']){
                            if($totalNumRows%25>=5){
                                $totalNums = round($totalNumRows/5)+round(($totalNumRows%25)%5);
                                $i = ceil($totalNumRows/25)+round(($totalNumRows%25)%5);
                            }
                            else{
                                $totalNums = ceil($totalNumRows/5);
                            }
                            
                        }
                        else{
                            $totalNums++;                            
                        }
                        $j = ceil($totalNumRows);
                        if(ceil($totalNumRows/5)<5){
                            $i=1;   
                        }
                        for($i; $i<=$j; $i++){
                            if($i<=$totalNums){
                        ?>
                                <li><a class="num-<?php echo $i; ?>" href='home.php?page=<?php echo $i; ?>'><?php echo $i; ?></a></li> 
                        <?php
                            }
                        }
                        ?>
                        <li class='active' id="next"><a href='home.php?page=<?php if(getNumRowsS($conn)<5 || $totalNumRows<=5 || $totalNums==$_GET['page']){ echo $next; } else{echo ++$next;} ?>'>Next</a></li>           
        <?php
                    }
        ?>
    </ul>
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

$(function() {
    $("#pagination li").live('click',function(e){
    e.preventDefault();
    });
});

</script>
</html>