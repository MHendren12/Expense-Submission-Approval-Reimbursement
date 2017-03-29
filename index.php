<?php

?>
<!DOCTYPE html>
<html>
	<body>
	
	<?php
		include("Navbar/header.php");
		if($_GET['redirect'] == 1){
			header("Location: Account/logout.php");
		}
		if($_SESSION['userid'] != null){
			header("Location: home.php");
		}
	?>
	<div class="container contentContainer" >
		<div class="row">
			<div class="well panel panel-default">
				<div class="panel-body">
					<div id="content" class="site-content">
						<article id="post-8" class="single-post post-8 page type-page status-publish hentry">
							<div class="entry-content">
								<div align="center">
									<table class="one">
										<td>
											<h2 align="center">Better Your Experience 
											with<br>Travel Costs and Reports.
											</h2><hr>
											<div class="row">
												<div class="col-md-4" align="right">
													<img alt="" class="img" height="100" src="images/plane.png" width="100" style="border:4px solid #021a40">
												</div>
												<div class="col-md-8" align="left">
													<h4>Planes and Flight</h4>
													<p>Plane tickects, checked baggage, traveling to and from the airport, and anything else that might come 
													up when traveling by air.</p>	
												</div>												
											</div>
											<br><br>
											<div class="row">
												<div class="col-md-4" align="right">
													<img alt="" class="img" height="100" src="images/train.gif" width="100" style="border:4px solid #021a40">
												</div>
												<div class="col-md-8" align="left">
													<h4>Subways and Trains</h4>
													<p>Train tickets, subway fairs, and other train travel expense.</p>	
												</div>												
											</div>
											<br><br>
											<div class="row">
												<div class="col-md-4" align="right">
													<img alt="" class="img" height="100" src="images/car.png" width="100" style="border:4px solid #021a40">
												</div>
												<div class="col-md-8" align="left">
													<h4>Automobiles</h4>
													<p>Gas mileage, car rental, and other car related expenses that an employee might encounter on 
													a business trip.</p>		
												</div>												
											</div>
										</td>

									</table>
									<form action="Account/register.php" onsubmit="return validateForm()" method="post" >
										<table class="two">
											<td align="center">
												<div class="row">
													<h1>Register</h1><hr>
													<div class="col-md-6" align="right">
														<input class="form-control" name="FName" placeholder="First Name" required style="width: 68%" type="text">													
													</div>
													<div class="col-md-6" align="left">
														<input class="form-control" name="LName" placeholder="Last Name" required style="width: 68%" type="text">													
													</div>
												</div>											
												<br>
												<input class="form-control" name="Email" placeholder="Email" required style="width: 70%" type="text">
												<br>
												<div style="inline-block;position: relative; overflow: hidden;width:70%">
											        <input class="form-control" id="Password" name="password" placeholder="Password" required type="password">
											        <a onclick="showPassword(this, Password)" style="right:3%;position:absolute; top:10px;"><span class="glyphicon glyphicon-eye-open" ></span></a>
											    </div>  
												<br>
												<div style="inline-block;position: relative; overflow: hidden;width:70%">
											        <input class="form-control" id="confirmpassword" onchange="verifyPasswords();" name="confirmpassword" placeholder="Confirm Password" required type="password">
											        <a onclick="showPassword(this, confirmpassword)" style="right:3%;position:absolute; top:10px;"><span class="glyphicon glyphicon-eye-open" ></span></a>
											    </div> 
												
												<!--<input id="confirmpassword" onchange="verifyPasswords();" class="form-control" name="confirmpassword" placeholder="Confirm Password" required style="width: 70%" type="password">
												--><br>
												<div id="passNotEqual" style="display:none;width:70%;" align="left">
													<span style="color:red;font-weight:bold;">The Passwords do not match!</span>
												</div>
												<h4>
													<div id="strength" class="figure"></div>
												</h4>
												<div id="strength_human" class="figure"></div>
												<div>
													<h3>Date of Birth: </h3>
													<select class="btn btn-default" name="DOBMonth" id="DOBMonth" required>
													<option>- Month -</option>
													<?php 
														$months = array("January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October","November", "December");
														$count = 1;
														foreach($months as $month){
															echo "<option value='" . $count . "'>" . $month . "</option>";
															$count++;
														} ?>
														</select>
														<select class="btn btn-default" name="DOBDay" id="DOBDay" required>
															<option>- Day -</option>
															<?php
																for($i=1; $i<=31; $i++){
																	echo "<option value='" . $i . "'>" . $i . "</option>";
																} 
															?>
														</select>
														<select class="btn btn-default" name="DOBYear" id="DOBYear"  required>
															<option>- Year -</option>
															<?php 
																for($i=2017; $i>=1947; $i--)
																{
																	echo "<option value='" . $i . "'>" . $i . "</option>";
																} 
															?>
														</select>
													</div>
												<br><br><br>
												<p>By clicking Create Account, you will agree upon our Terms and our Policy Agreement. 
												You will recieve an email notification regarding your account verification and confirmation.</p>
												<hr>
	                                            <div class="row" align="center" >
	                                                <input id="submit" type="submit" class="btn btn-success" value="Create Account" name="submit" style="width:300px; height:50px; font-size:20px" />
	                                                
	                                                <script language="JavaScript">
	                                                    window.onbeforeunload = confirmExit;
	                                                    function confirmExit()
	                                                    {}
	                                                </script>
	                                            </div>
	                                        </td>
										</table>
									</form>
								</div>
							</div>
						</article>
					</div>
				</div>
				<hr>
				  <ul class="nav nav-pills nav-justified">
	                  <li><a data-toggle="tab" href="#aboutus"><h4>About us</h4></a></li>
	                  <li><a data-toggle="tab" href="#contactus"><h4>Contact us</h4></a></li>  
				  </ul>
                <div class="row">
                    <div class="col-lg-1">
                        
                    </div>
                    <div class="col-lg-10">
                        <div class="tab-content" align="left">
                            <div id="aboutus" class="tab-pane fade">
                                <h2>About Us</h2>
                                <?php include('aboutus.php'); ?>
                            </div>  
                            <div id="contactus" class="tab-pane fade">
                                <h2>Contact Us</h2>
                                <?php include('contactus.php'); ?>
                            </div>                                        
                        </div>     
                    </div>
                    <div class="col-lg-1">
                        
                    </div>                                    
                </div>				
			</div>
		</div>
        <div align="center">
            <label>&#169; Copyright 2017, RASE Corp. English(US). All Right Reserved.</label>
        </div>		
		<!--
	    <nav class="navbar navbar-inverse navbar-fixed-bottom">
	        <div class="container">
	            <div class="row">
	                <div class="col-md-2 col-sm-3 col-xs-6">
	                    <a class="navbar-brand" href="../WorkoutDB/contactus.php">Contact Us</a>
	                </div>
	                <div class="col-md-6 col-sm-3 col-xs-6">
	                    <a class="navbar-brand" href="../aboutus.php">About Us</a>
	                </div>
	            </div>
	        </div>
	    </nav> 
	    -->
	</div>
	</body>
	<script>
		function verifyPasswords()
		{
			debugger;
			var pass = $("#Password").val();
			var pass2 =  $("#confirmpassword").val();
			if (pass == pass2)
			{
				$("#passNotEqual").css("display","none");
				return true;
			}
			else
			{
				$("#passNotEqual").css("display","");
				return false;
			}
		}
		
		function validateForm()
		{
			var passMatch = $("#passNotEqual").css("display") == "none";
			if ($("#passNotEqual").css("display") == "none" )
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		function showPassword(link, fieldId)
        {
        	debugger;
            var type = $(fieldId).attr("type");
            if (type == "text")
            {
                $(link).find("span").attr("class","glyphicon glyphicon-eye-open");
                $(fieldId).attr("type","password");
            }
            else
            {
                $(link).find("span").attr("class","glyphicon glyphicon-eye-close");
                $(fieldId).attr("type","text");
            }
            
        }
	</script>
</html>