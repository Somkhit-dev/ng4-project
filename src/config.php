<?php
    $host = 'ng4_db'; 
    
    $username = 'user';       // ตรงกับ MYSQL_USER
    $password = 'password';   // ตรงกับ MYSQL_PASSWORD
    $dbname = 'ng4_database'; // ตรงกับ MYSQL_DATABASE

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>