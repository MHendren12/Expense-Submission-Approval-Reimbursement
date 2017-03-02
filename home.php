<?php
    session_start();
    $user_id = $_SESSION['userid'];
    include("WebService/accountinfo.php");
    include("WebService/forminfo.php");
    include("Account/expenseEmail.php");
?>
<!DOCTYPE html>
<html>
    <head>

        <?php
            include("Navbar/header.php");
            if($_SESSION['userid'] == null){
                header("Location: index.php");
            }
        ?>
    </head>
    <body>
        <div class="container">
            <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                 <div class="modal-dialog" style="width:70%"> 
                      <div class="modal-content"> 
                      
                           <div class="modal-header"> 
                                <button align="left" type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                <button data-toggle="modal" style="margin-left: 87%;" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-print"></i> Print</button>
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
        <div class="container loggedInContainer" align = "center">
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" ><br><br>
                        <!-- Menu tabs are generated from bootstrap, the bootstap is included from the header.php file. -->
                            <ul class="nav nav-tabs nav-justified" id="homeTabs">
                              <li class="active"><a data-toggle="tab" href="#home"><h4>Home</h4></a></li>
                              <!-- Subpannel for My Form -->
                              <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#myform"><h4>My Form</h4>
                                <ul class="dropdown-menu" style="min-width: 100%;";>
                                  <li><a data-toggle="tab" href="#expenseform">Expense Form</a></li>
                                  <li><a data-toggle="tab" href="#mysaved">My Saved</a></li>
                                  <li><a data-toggle="tab" href="#mypending">My Pending</a></li>
                                  <li><a data-toggle="tab" href="#myprocessed">My Processed</a></li>
                                </ul>
                              </li>
                              <!--
                              <li><a data-toggle="tab" href="#myactivity"><h4>My activity</h4></a></li>
                                
                                <li><a data-toggle="tab" href="#aboutus"><h4>About us</h4></a></li>
                                <li><a data-toggle="tab" href="#contactus"><h4>Contact us</h4></a></li>     
                                -->
                                <?php
                                    
                                    $isadmin = isadmin($user_id, $conn);
                                    if ($isadmin)
                                    {
                                ?>
                                <li><a data-toggle="tab" href="#routing"><h4>Routing</h4></a></li>
                                <?php
                                    }
                                    
                                ?>                              
                            </ul>
                            <br><br>
                            <div class="row">
                                <div class="col-lg-1">
                                </div>
                                <div class="col-lg-10">
                                    <div class="tab-content" align="left">
                                        <div id="home" class="tab-pane fade in active">
                                            <h2>Your RASE Home</h2>
                                            <?php include_once('info.php'); ?>
                                        </div>
                                        <div id="expenseform" class="tab-pane fade">
                                            <h2>Create a New Expense Form</h2>
                                            <?php include_once('expenseform.php'); ?>
                                        </div>                                        
                                        <div id="mysaved" class="tab-pane fade">
                                            <h2>My Saved</h2>
                                            <?php include_once('mysaved.php'); ?>
                                        </div>
                                        <div id="mypending" class="tab-pane fade">
                                            <h2>My Pending</h2>
                                            <?php include_once('mypending.php'); ?>
                                        </div>  
                                        <div id="myprocessed" class="tab-pane fade">
                                            <h2>My Processed</h2>
                                            <?php include_once('myprocessed.php'); ?>
                                        </div>                                        
                                        <div id="routing" class="tab-pane fade">
                                            <h2>Routing</h2>
                                            <?php include_once('routing.php'); ?>
                                        </div>
                                    </div>     
                                </div>
                                <div class="col-lg-1">
                                    
                                </div>                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div align="center">
            <label>&#169; Copyright 2017, RASE Corp. English(US). All Right Reserved.</label>
        </div>
    </body>
    <script>
    
        $('#homeTabs a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
        
        // store the currently selected tab in the hash value
        $("ul.nav-tabs").on("shown.bs.tab", function(e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
        });
        
        // on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('#homeTabs a[href="' + hash + '"]').tab('show');

        // generate view dialog
        $(document).ready(function(){
        	$(document).on('click', '#getexpenseform', function(e){
        		
        		e.preventDefault();
        		
        		var user_id = $(this).data('id');   // it will get id of clicked row

        		$('#dynamic-content').html(''); // leave it blank before ajax call
        		$('#modal-loader').show();      // load ajax loader
        		
        		$.ajax({
        			url: 'expenseform.php',
        			type: 'POST',
        			data: 'id='+user_id,
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
</html>