<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dormitorydb";
    $connection = mysqli_connect($servername, $username, $password, $dbname);

    //tips: OOP style
    if ($connection->connect_error) {
        echo "Connection failed: {$connection->connect_error}";
    } else {
        // i thnk not necessery
        //echo "Database connected successfully";
    }
    
?>