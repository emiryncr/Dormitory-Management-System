<?php 
    session_start();
    session_unset();// tips: unset session variables
    session_destroy();

    header("Location: ../authPages/login.php");
    exit();
?>