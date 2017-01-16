<?php
    function getConnection() {
        $servername = "127.0.0.1";
		$username = "root";
		$password = "";
		$db = "expense_reimbursement";
        $conn= mysqli_connect($servername, $username, $password, $db) 
            or die("Unable to connect to MySQL");
        
        return $conn;
    }
?>