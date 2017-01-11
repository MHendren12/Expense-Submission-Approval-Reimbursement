<?php
    $logged_in = false;
    if(isset($_SESSION['is_logged_in']))
    {
        $logged_in = true;
    }
?>
<style type="text/css">
    .nav-tabs
    {
        border-bottom:0px;
    }
</style>
<!DOCTYPE html>
<html lang="en">
    <head></head>
        <body>
            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                <div id="navbar" class="navbar-collapse collapse" style="float:none">
                    <div class="col-lg-4">
                        <ul class="nav nav-tabs" role="tablist">
                            <?php
                                if(isset($_SESSION['is_logged_in']))
                                {
                            ?>
                            <li role="presentation" ><a href="home.php">Home</a></li>
                            <?php
                                }
                                else {
                            ?>
                            <li role="presentation" ><a href="index.php">Home</a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                    <?php
                        if(!isset($_SESSION['is_logged_in']))
                        {
                    ?>
                    <div class="col-lg-8" float="right">
                        <form class="navbar-form navbar-right" action="Account/Login.php" method="post">
                            <div class="form-group">
                                <input type="text" placeholder="Email" class="form-control" name="Email">
                            </div>
                            <div class="form-group">
                                <input type="password" placeholder="Password" class="form-control" name="Password">
                            </div>  
                            <input type="submit" class="btn btn-success" value="Sign in" name="submit" />
                            <a href="registration.php"><p class="btn btn-default">Register</p></a>
                        </form>
                    </div>
                    <?php
                        }
                        else
                        {
                    ?>
                    <div class="col-lg-4">
                        
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" style="color:white; padding:12px;">Hello <?php echo $_SESSION['name']; ?>!</li>
                            <li role="presentation">
                                <div class="dropdown" style="padding:12px">
                                    <a data-toggle="dropdown">
                                        <span class="glyphicon glyphicon-triangle-bottom">
                                            
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">My Account</a></li>
                                        <li><a href="Account/logout.php">Logout</a></li>
                                    </ul>
                                </div>
                            </li>
                            
                            

                                
                            
                            
                        </ul>
                        </div>
                        
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </nav>   
    </body>
</html>
<script type="text/javascript" >
    function show_menu()
    {
        
    }
</script>
