<?php

    session_start();
    if (file_exists('Database/config.php') )
    {
        include("Database/config.php");
    }
    else 
    {
        include("../Database/config.php");
    }
    $conn = getConnection();
    $id = $_SESSION['userid'];
    
    if( $_POST['val'] )  
    {
       
        switch ($_POST['val']) {
            case getExpenseTypes:
                $formid = $_POST['formid'];
                $sql = "select expense_types from expense_reports where expense_reports_id = '".$formid."'";
        		$result = mysqli_query($conn, $sql);
        		$row = mysqli_fetch_assoc($result);
        		$num_rows = mysqli_num_rows($result);
        		if ($num_rows > 0)
        		{
            	    echo $row['expense_types'];
        		}
                
                break;
            case getExpenseFields:
                echo getExpenseFields($_POST['formid'], $conn);
                break;  
            default:
                break;
        }
    }
    
    function getExpenseTypes($formid, $conn)
    {
        

    }
    function getExpenseFields($formid, $conn)
    {
        $sql = "select expense_fields from expense_reports where expense_reports_id = '".$formid."'";
        		$result = mysqli_query($conn, $sql);
        		$row = mysqli_fetch_assoc($result);
        		$num_rows = mysqli_num_rows($result);
        		
        		if ($num_rows > 0)
        		{
            	    echo $row['expense_fields'];
        		}
        		else
        		    echo '[]';
    }
    
    
?>