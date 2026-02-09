<?php
    $host = 'db'; 
    $username = 'user'; 
    $password = 'password'; 
    $dbname = 'ng4_database'; 

    $conn = new mysqli($host, $username, $password , $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        // echo "Connected successfully<br>";
    }
?>