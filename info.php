<html>
    <head>
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
                    <table class="table table-bordered table-style table-responsive">
                      <tr>
                        <th colspan="2"><button class="btn btn-default" onclick=""><span class="glyphicon glyphicon-chevron-left"></span></button></th>
                        <th colspan="3"> <?php echo date("M - Y"); ?></th>
                        <th colspan="2"><button class="btn btn-default" onclick=""><span class="glyphicon glyphicon-chevron-right"></span></button></th>
                      </tr>
                      <tr>
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                      </tr>
                      <?php
                      $count = 1;
                      $value = 1;
                      $start = (new DateTime('first day of this month'))->format('D');
                      $end = (new DateTime('last day of this month'))->format('D');
                      $initial = date('N', strtotime($start));
                      $final = date('N', strtotime($end));
                        if($initial == 7){
                            $initial = 0;
                        }
                        if($final == 7){
                            $final = 0;
                        }
                      for($i=0; $i<5; $i++){
                        echo "<tr></tr>";
                        for($j=0; $j<7; $j++){
                        
                            if($initial<$count && $count<34-$final){
                                if($value==date("j")){
                                    echo "<td class='today'>".$value."</td>";
                                    $value++;
                                    $count++; 
                                } else{
                                    echo "<td>".$value."</td>";
                                    $value++;
                                    $count++;                                    
                                }
                            }
                            else{
                                echo "<td></td>";
                                $count++;
                            }
                                
                        }
                      }
                     
                      ?>
                    </table>
            
                </div>
              </div>           
        </div>
        <div class="col-lg-6">
            <table class="table table-striped">
            	<thead>
            		<tr>
            			<th>ID #</th>
            			<th>Date of Submission</th>
            			<th>Date of Approval</th>
            			<th>Approver</th>
            			<th>View Form</th>
            			<th>Status</th>
            		</tr>
            	</thead>
            	<tr class="warning">
            		<th>1324213</th>
            		<td>02/01/17</td>
            		<td>--/--/----</td>
            		<td>Bill Johnson</td>
            		<td><a class="btn btn-default" href="#" role="button">View</a></td>	
            		<td>Pending</td>
            	</tr>
            	<tr class="success">
            		<th>2342324</th>
            		<td>02/01/17</td>
            		<td>02/03/17</td>		
            		<td>Jacob Thornton</td>
            		<td><a class="btn btn-default" href="#" role="button">View</a></td>	
            		<td>Accepted</td>
            	</tr>
            	<tr class="success">
            		<th>3234324</th>
            		<td>02/01/17</td>
            		<td>02/03/17</td>
            		<td>Larry Bird</td>
            		<td><a class="btn btn-default" href="#" role="button">View</a></td>	
            		<td>Accepted</td>
            	</tr>
            </table>
               
        </div>
    </div>	
</body>
<script>
    
</script>
</html>
