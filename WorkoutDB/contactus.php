<html>
    <head>
        <title>Expense Reimbursement</title>
        <!-- Styles -->
        <link href="/Styles/css/style.css" rel="stylesheet">
        <link href="/Styles/css/bootstrap.css" rel="stylesheet">
        
        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="/Scripts/bootstrap.min.js"></script>
        
        
    </head>
    <body>
        <?php
            include("../Navbar/header.php");	
        ?>
        <div class="container">
            <hr>
            <div class="row">
                <div class="well panel panel-default" >
                    <div class="panel-body">
                        <div class="row" align ="left">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-10">
                                <h1>Contact Us</h1>
                                <hr>
                                <p>Have questions, comments, concerns or any other feedback you would like to share with us? Send us an email with<br>
                                    some basic information and we will get back to you as soon as possible. Or have one person in specific you are<br>
                                    trying to get ahold of? Find their contact info below.
                                </p> 
                                <hr>
                                <h2>Contact RASE Corp.</h2><hr>
                                <p>
                                    <form method="post" class="tag-beauty">
                        				<span class="error">  </span><br>
                        				<label>Your Name </label><span class="error">*</span>
                        				<input placeholder="Enter your name" name="yourname" type="text">
                        				<label>Email </label><span class="error">*</span>
                        				<input placeholder="Enter your email" name="email" type="text">
                        				<label>Contact no </label><span class="error">*</span>
                        				<input placeholder="Enter your Contact no" name="mobile" type="text">
                        				<label>Message </label><span class="error">*</span>
                        				<textarea cols="25%" rows="8" placeholder="Leave your message" name="message"></textarea>
                        				<input value="Submit" class="tag-button" type="submit">
                    				</form>
                                </p><hr>
                                <h2>Contact Admin</h2><hr>
                                    <h3>Michael Hendren</h3>
                                    <p>
                                        School Email: mrhendre@oakland.edu
                                    </p>
                                    <h3>Shane Kuskowski</h3>
                                    <p>
                                        School Email: srkusko2@oakland.edu
                                    </p> 
                                    <h3>Andre Mitchell</h3>
                                    <p>
                                        School Email: atmitche@oakland.edu
                                    </p>  
                                    <h3>Jon Calvert</h3>
                                    <p>
                                        School Email: jccalver@oakland.edu
                                    </p>  
                                    <h3>Matt Papais</h3>
                                    <p>
                                        School Email: mapapais@oakland.edu
                                    </p>  
                                    <h3>Marek Stolarczyk</h3>
                                    <p>
                                        School Email: mstolar2@oakland.edu
                                    </p>  
                            </div>
                            <div class="col-md-1">
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>