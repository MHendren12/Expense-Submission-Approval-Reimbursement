<?php

?>
<!DOCTYPE html>
<html>

<head>
<title>Expense Reimbursement</title>
<!-- Styles -->
<link href="/Styles/css/bootstrap.css" rel="stylesheet">
<!-- Scripts -->
<script src="/Scripts/bootstrap.min.js"></script>
</head>

<body>

<?php
include("Navbar/header.php");	
?>
<div class="container">
	<div class="row">
		<div class="well panel panel-default">
			<div class="panel-body">
				<div id="content" class="site-content">
					<article id="post-8" class="single-post post-8 page type-page status-publish hentry">
						<div class="entry-content">
							<hr>
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
													<p>Train tickets, subway fair, and anything else that an employee might need when traveling 
													on trains.</p>	
												</div>												
											</div>
											<br><br>
											<div class="row">
												<div class="col-md-4" align="right">
													<img alt="" class="img" height="100" src="images/car.png" width="100" style="border:4px solid #021a40">
												</div>
												<div class="col-md-8" align="left">
													<h4>Automobiles</h4>
													<p>Automobile rental, fuel, taxis or Ubers, and anything else that might be needed when an employee 
													is traveling by car for business.</p>		
												</div>												
											</div>
										</td>
								</table>
								<form action="Account/register.php" method="post" >
									<table class="two">
										<td align="center">
											<div class="row">
												<h1>Register</h1><hr>
												<div class="col-md-6" align="right">
													<input class="form-control" name="FName" placeholder="First Name" required="" style="width: 70%" type="text">													
												</div>
												<div class="col-md-6" align="left">
													<input class="form-control" name="LName" placeholder="Last Name" required="" style="width: 70%" type="text">													
												</div>
											</div>											
											<br>
											<input class="form-control" name="Email" placeholder="Email" required="" style="width: 70%" type="text">
											<br>
											<input id="password" class="form-control" name="Password" placeholder="Password" required="" style="width: 70%" type="password">
											<br>
											<h4>
											<div id="strength" class="figure">
											</div>
											</h4>
											<div id="strength_human" class="figure">
											</div>
											<div>
											<h3>Date of Birth: </h3>
											<select class="btn btn-default" name="DOBMonth" required="">
											<option>----------------</option>
											<?php $months = array("January", "Febuary", "March", "April", "May", "June", "July", "August", "September", "October","November", "December");
											foreach($months as $month){
												echo "<option value='" . $month . "'>" . $month . "</option>";
											} ?>
											</select>
											<select class="btn btn-default" name="DOBDay" required="">
											<option>---</option>
											<?php
											for($i=0; $i<=31; $i++){
												echo "<option value='" . $i . "'>" . $i . "</option>";
											} ?>
											</select>
											<select class="btn btn-default" name="DOBYear" required="">
											<option>------</option>
											<?php for($i=2017; $i>=1947; $i--){
												echo "<option value='" . $i . "'>" . $i . "</option>";
											} ?>
											</select>
											<br><br><br>
											<p>By clicking Create Account, you will agree upon our Terms and our Policy Agreement. 
											You will recieve an email notification regaurding your account verification and confirmation.</p>
											<hr>
                                            <div class="row" align="center" >
                                                <input id="submit" input type="submit" class="btn btn-success" value="Create Account" name="submit" />
                                                
                                                <script language="JavaScript">
                                                    window.onbeforeunload = confirmExit;
                                                    function confirmExit()
                                                    {
                                                        // this shouldn't show if the user has filled out the page and wants to register
                                                        return "Do you wish to cancel your registration for the Not-So-Social-Network and leave this page?";
                                                    }
                                                </script>
                                            </div>
                                        </td>
									</table>
								</form>
							</div>
					</article>
				</div>
			</div>
		</div>
	</div>
    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <a class="navbar-brand" href="/WorkoutDB//contacts.php">Contacts</a>
                </div>
                <div class="col-md-6 col-sm-3 col-xs-6">
                    <a class="navbar-brand" href="/WorkoutDB/aboutus.php">About Us</a>
                </div>
            </div>
        </div>
    </nav> 
</div>

</body>

</html>