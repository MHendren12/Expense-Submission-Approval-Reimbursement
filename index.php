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
<div align="center" class="container">
	<div class="row">
		<div class="well panel panel-default">
			<div class="panel-body">
				<div id="content" class="site-content">
					<article id="post-8" class="single-post post-8 page type-page status-publish hentry">
						<div class="entry-content">
							<hr>
							<div align="center">
								<br><br>
								<table class="one">
										<td>
    										<div>
    											<h2 align="center">Better Your Experience 
    											with<br>Travel Costs and Reports.
    											</h2>
    											<div style="text-align: center">
    												<img alt="" class="img" height="63" src="images/train.gif" width="67">&nbsp;&nbsp; 
    												gfdgfdggfgfdsgfdsgfdsgfgsdgfgsf<br>
    												<br>dfsdfsfdsfsdfdsfdfsdfdsdfsdffdsdsfbxbc<br>
    											</div>
    											<br>
    											<div style="text-align: center">
    												<img alt="" class="img" height="63" src="images/train.gif" width="67">&nbsp;&nbsp; 
    												gfdgfdggfgfdsgfdsgfdsgfgsdgfgsf<br>
    												<br>dfsdfsfdsfsdfdsfdfsdfdsdfsdffdsdsffshw<br>
    											</div>
    											<br>
    											<div style="text-align: center">
    												<img alt="" class="img" height="63" src="images/train.gif" width="67">&nbsp;&nbsp; 
    												gfdgfdggfgfdsgfdsgfdsgfgsdgfgsf<br>
    												<br>dfsdfsfdsfsdfdsfdfsdfdsdfsdffdsdsfvxhr<br>
    											</div>
    											
    										</div>
										</td>
								</table>
								<form action="Account/register.php" method="post" >
									<table class="two">
										<td align="center">
											<h3>First Name: </h3>
											<input class="form-control" name="FName" placeholder="First Name" required="" style="width: 70%" type="text">
											<h3>Last Name: </h3>
											<input class="form-control" name="LName" placeholder="Last Name" required="" style="width: 70%" type="text">
											<h3>Email Address: </h3>
											<input class="form-control" name="Email" placeholder="Email" required="" style="width: 70%" type="text">
											<h3>Password: </h3>
											<input id="password" class="form-control" name="Password" placeholder="Password" required="" style="width: 70%" type="password">
											<h4>
											<div id="strength" class="figure">
											</div>
											</h4>
											<div id="strength_human" class="figure">
											</div>
											<div>
											<h3>Birthday: </h3>
											<select class="btn btn-default" name="DOBMonth" required="">
											<option></option>
											<option value="1">January</option>
											<option value="2">Febuary</option>
											<option value="3">March</option>
											<option value="4">April</option>
											<option value="5">May</option>
											<option value="6">June</option>
											<option value="7">July</option>
											<option value="8">August</option>
											<option value="9">September</option>
											<option value="10">October</option>
											<option value="11">November</option>
											<option value="12">December</option>
											</select>
											<select class="btn btn-default" name="DOBDay" required="">
											<option></option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
											<option value="13">13</option>
											<option value="14">14</option>
											<option value="15">15</option>
											<option value="16">16</option>
											<option value="17">17</option>
											<option value="18">18</option>
											<option value="19">19</option>
											<option value="20">20</option>
											<option value="21">21</option>
											<option value="22">22</option>
											<option value="23">23</option>
											<option value="24">24</option>
											<option value="25">25</option>
											<option value="26">26</option>
											<option value="27">27</option>
											<option value="28">28</option>
											<option value="29">29</option>
											<option value="30">30</option>
											<option value="31">31</option>
											</select>
											<select class="btn btn-default" name="DOBYear" required="">
											<option></option>
											<option value="2016">2016</option>
											<option value="2015">2015</option>
											<option value="2014">2014</option>
											<option value="2013">2013</option>
											<option value="2012">2012</option>
											<option value="2011">2011</option>
											<option value="2010">2010</option>
											<option value="2009">2009</option>
											<option value="2008">2008</option>
											<option value="2007">2007</option>
											<option value="2006">2006</option>
											<option value="2005">2005</option>
											<option value="2004">2004</option>
											<option value="2003">2003</option>
											<option value="2002">2002</option>
											<option value="2001">2001</option>
											<option value="2000">2000</option>
											<option value="1999">1999</option>
											<option value="1998">1998</option>
											<option value="1997">1997</option>
											<option value="1996">1996</option>
											<option value="1995">1995</option>
											<option value="1994">1994</option>
											<option value="1993">1993</option>
											<option value="1992">1992</option>
											<option value="1991">1991</option>
											<option value="1990">1990</option>
											<option value="1989">1989</option>
											<option value="1988">1988</option>
											<option value="1987">1987</option>
											<option value="1986">1986</option>
											<option value="1985">1985</option>
											<option value="1984">1984</option>
											<option value="1983">1983</option>
											<option value="1982">1982</option>
											<option value="1981">1981</option>
											<option value="1980">1980</option>
											<option value="1979">1979</option>
											<option value="1978">1978</option>
											<option value="1977">1977</option>
											<option value="1976">1976</option>
											<option value="1975">1975</option>
											<option value="1974">1974</option>
											<option value="1973">1973</option>
											<option value="1972">1972</option>
											<option value="1971">1971</option>
											<option value="1970">1970</option>
											<option value="1969">1969</option>
											<option value="1968">1968</option>
											<option value="1967">1967</option>
											<option value="1966">1966</option>
											<option value="1965">1965</option>
											<option value="1964">1964</option>
											<option value="1963">1963</option>
											<option value="1962">1962</option>
											<option value="1961">1961</option>
											<option value="1960">1960</option>
											<option value="1959">1959</option>
											<option value="1958">1958</option>
											<option value="1957">1957</option>
											<option value="1956">1956</option>
											<option value="1955">1955</option>
											<option value="1954">1954</option>
											<option value="1953">1953</option>
											<option value="1952">1952</option>
											<option value="1951">1951</option>
											<option value="1950">1950</option>
											<option value="1949">1949</option>
											<option value="1948">1948</option>
											<option value="1947">1947</option>
											</select>
											<br><br><br>
                                            <div class="row" align="center" >
                                                <input id="submit" input type="submit" class="btn btn-success" value="Submit" name="submit" />
                                                <a class="btn btn-default" href="/WorkoutDB/" role="button">Cancel &raquo;</a>
                                                
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
</div>

</body>

</html>
